<?php
/*Fonctions nécessaire:
GET Données:
get_tutors:     SELECT DISTINCT tutor_id FROM tutors_subjects;
get_ticket(<id>): SELECT * FROM Tickets WHERE id = <id>;
get_commentaires(<ticket_id>): SELECT * FROM Tickets WHERE ticket_id = <ticket_id>;
test_tutors_subject:    SELECT COUNT(*) FROM tutors_subjects WHERE tutor_id = <id> AND subject_id = <id>;

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
    
    //public function __destruct() {
    //    $this->pdo = null; //detruire la connection BDD
    //}

    //vieille
    public function get_students_ticket(int $user_id) : PDOStatement{
        //consulter BDD pour recevoir tous les tickets créer par utilisateur $user_id
        try {
            $stmt = $this->pdo->prepare(
                "SELECT * FROM tickets T JOIN users U ON T.author_id = U.id WHERE U.id = :user_id");
            $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;

        } catch (PDOException $e) {
            echo $e->getMessage();  
        }
    }

    //vieille
    public function get_dernier_commentaire(int $ticket_id) : PDOStatement{
        //consulter BDD pour obtenir le dernier commentaire d'un ticket
        try {
            $stmt = $this->pdo->prepare(
                "SELECT * FROM comments WHERE ticket_id = :ticket_id AND created_at = (SELECT MAX(created_at) FROM Tickets)");
            $stmt->bindValue(":ticket_id", $ticket_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();  
        }
    }

    public function get_students_tickets_info(int $user_id) : PDOStatement{
        //consulter BDD pour obtenir tickets de l'étudiant avec le dernier commentaire qui était écrit pour chaque ticket
        try {
            $stmt = $this->pdo->prepare(
                "SELECT * FROM tickets T JOIN users U ON T.author_id = U.id JOIN comments C ON T.id = C.ticket_id WHERE U.id = :user_id AND C.created_at = 
                (SELECT MAX(created_at) FROM comments WHERE ticket_id = T.id LIMIT 1) ORDER BY C.created_at DESC");
            $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
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
            $stmt = $this->pdo->prepare("SELECT DISTINCT tutor_id, username FROM tutor_subjects JOIN users ON tutor_id = id WHERE role = 'tutor'");
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) { 
            echo $e->getMessage();
        }
    }

    public function inserer_ticket(int $author_id, int $subject_id, int $tutor_id, int $category_id, int $priority_id, int $status_id, string $title, string $description) : void {
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