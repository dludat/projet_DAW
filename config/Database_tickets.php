<?php
/*Fonctions nécessaire:
GET Données:
get_tutors:     SELECT DISTINCT tutor_id FROM tutors_subjects;
get_ticket(<id>): SELECT * FROM Tickets WHERE id = <id>;

Inserer Données:
insert_commentaire: INSERT INTO comments VALUES (...);

Modifier Données:
change_status(<ticket_id>): UPDATE Tickets SET status_id = new_statut;
change_priorite(<ticket_id>): UPDATE Tickets SET priority_id = new_priorite;
*/

//Connection de la base de données
class ConnectionBDD {
    private PDO $pdo;
    public function __construct() {
        try {
        $host = '127.0.0.1'; //Adresse serveur MySQL
        $port = '3306'; //Port MySQL
        $dbname = 'helpdesk'; //Nom BDD
        $username = getenv('DB_USER') ?: ''; //Nom utilisateur MySQL
        $password = getenv('DB_PASS') ?: ''; //Mot de passe utilisateur MySQL

        //Création DSN
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $dbname);

        //Création de la connexion PDO
        $this->pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function get_commentaires(int $ticket_id) {
        //consulter BDD et récupérer tous les commentaires d'un ticket
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM comments
                JOIN (SELECT username, id FROM users) AS U ON U.id = author_id
                WHERE :ticket_id = ticket_id ORDER BY created_at DESC');
            $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function get_students_tickets(int $user_id) : PDOStatement{
        try { //consulter BDD et recevoir tous les tickets créer par cet utilisateur avec info courte
            $stmt = $this->pdo->prepare(
                "SELECT T.id AS id, title, S.name, status_id, T.created_at, C.message, 
                C.created_at AS comment_date
                FROM tickets T 
                JOIN (SELECT id, name FROM subjects) AS S ON T.subject_id = S.id
                LEFT JOIN comments AS C ON T.id = C.ticket_id 
                WHERE T.author_id = :user_id AND (C.created_at = 
                (SELECT MAX(created_at) FROM comments WHERE ticket_id = T.id LIMIT 1) OR C.created_at IS NULL)
                ORDER BY C.created_at, T.id DESC");
            $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function get_ticket(int $ticket_id) : PDOStatement{
        try {
            $stmt = $this->pdo->prepare("SELECT U2.username AS author_name, title, description, S.name, 
                U.username as tutor_name, category_id, status_id, priority_id, created_at
                FROM tickets AS T
                JOIN (SELECT id, name FROM subjects) AS S ON T.subject_id = S.id
                JOIN (SELECT id, username, role FROM users WHERE role = 'tutor') AS U ON assigned_tutor_id = U.id
                JOIN (SELECT id, username FROM users) AS U2 ON U2.id = T.author_id
                WHERE :ticket_id = T.id LIMIT 1");
            $stmt->bindValue(":ticket_id", $ticket_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function get_subjects(): PDOStatement {
        //consulter BDD et retourner tous les cours possibles
        try {
            $stmt = $this->pdo->prepare("SELECT id, name FROM subjects");
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function get_tutors(): PDOStatement {
        //consulter BDD et retourner tous les tuteurs qui enseignent un cours avec leurs noms associés
        try {
            $stmt = $this->pdo->prepare("SELECT DISTINCT tutor_id, username FROM tutor_subjects JOIN users 
                ON tutor_id = id WHERE role = 'tutor'");
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) { 
            echo $e->getMessage();
        }
    }

    public function consulter_tutor_subjects(int $tutor_id, int $subject_id) : PDOStatement {
        //consulter BDD pour voir si existe cours avec ce tuteur
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM tutor_subjects 
                JOIN users AS U ON tutor_id = U.id 
                WHERE role ='tutor' AND :cours_id = subject_id AND :tutor_id = tutor_id");
            $stmt->bindValue(":tutor_id", $tutor_id, PDO::PARAM_INT);
            $stmt->bindValue(":cours_id", $subject_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function inserer_ticket(int $author_id, int $subject_id, int $tutor_id, int $category_id, 
        int $priority_id, int $status_id, string $title, string $description) : void {
        try { //preparer query
            $stmt = $this->pdo->prepare(
                "INSERT INTO tickets (author_id, subject_id, assigned_tutor_id, category_id, priority_id, status_id, title, description)
                VALUES (:author_id, :subject_id, :assigned_tutor_id, :category_id, :priority_id, :status_id, :title, :description)");
            $stmt->bindValue(":author_id", $author_id, PDO::PARAM_INT);
            $stmt->bindValue(":subject_id", $subject_id, PDO::PARAM_INT);
            $stmt->bindValue(":assigned_tutor_id", $tutor_id, PDO::PARAM_INT);
            $stmt->bindValue(":category_id", $category_id, PDO::PARAM_INT);
            $stmt->bindValue(":priority_id", $priority_id, PDO::PARAM_INT);
            $stmt->bindValue(":status_id", $status_id, PDO::PARAM_INT);
            $stmt->bindValue(":title", $title, PDO::PARAM_STR);
            $stmt->bindValue(":description", $description, PDO::PARAM_STR);
            $stmt->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}