<?php
/*Fonctions nécessaire:
GET Données:
get_tutors:     SELECT DISTINCT tutor_id FROM tutors_subjects;

Inserer Données:
fini

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
        $username = getenv('DB_USER') ?: 'root'; //Nom utilisateur MySQL
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
                JOIN (SELECT username, id, role FROM users) AS U ON U.id = author_id
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

    public function get_all_tickets() : PDOStatement {
        try { //consulter BDD et recevoir tous les tickets créer par cet utilisateur avec info courte
            $stmt = $this->pdo->prepare(
                "SELECT T.id AS id, title, S.name, status_id, T.created_at, C.message, 
                C.created_at AS comment_date, U.username AS author_name
                FROM tickets T 
                JOIN (SELECT id, name FROM subjects) AS S ON T.subject_id = S.id
                JOIN (SELECT id, username FROM users) AS U ON T.author_id = U.id
                LEFT JOIN comments AS C ON T.id = C.ticket_id 
                WHERE C.created_at = (SELECT MAX(created_at) FROM comments WHERE ticket_id = T.id LIMIT 1) 
                OR C.created_at IS NULL
                ORDER BY COALESCE(C.created_at, T.id) DESC"); //ici aussi le nom d'auteur important, car peut etre différent
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

    public function get_user_id(string $username) {
        try {
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
            $stmt->bindValue(":username", $username, PDO::PARAM_STR);
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

    public function get_tutors(): PDOStatement {
        //consulter BDD et retourner tous les tuteurs avec leurs noms associés
        try {
            $stmt = $this->pdo->prepare("SELECT id, username FROM users WHERE role = 'tutor'");
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) { 
            echo $e->getMessage();
        }
    }

    public function inserer_commentaire(int $ticket_id, int $author_id, string $message) : void {
        try {
            $stmt = $this->pdo->prepare(
                "INSERT INTO comments (ticket_id, author_id, message) 
                VALUES (:ticket_id, :author_id, :message)");
            $stmt->bindValue(":ticket_id", $ticket_id, PDO::PARAM_INT);
            $stmt->bindValue(":author_id", $author_id, PDO::PARAM_INT);
            $stmt->bindValue(":message", $message, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function inserer_ticket(int $author_id, int $subject_id, int $tutor_id, int $category_id, 
        int $priority_id, int $status_id, string $title, string $description) : void {
        try { //preparer query
            $stmt = $this->pdo->prepare(
                "INSERT INTO tickets (author_id, subject_id, assigned_tutor_id, category_id, priority_id, 
                status_id, title, description)
                VALUES (:author_id, :subject_id, :assigned_tutor_id, :category_id, :priority_id, :status_id, 
                :title, :description)");
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
    /** 
    public function inserer_user(string $username, string $password_hash, string $role) : bool {
        try { //inserer utilisateur, retourne true si succès, non si username duplicat
            $stmt = $this->pdo->prepare(
                "INSERT INTO users (username, password_hash, role) VALUES (:username, :password_hash, :role)"
            );
            $stmt->bindValue(":username", $username, PDO::PARAM_STR);
            $stmt->bindValue(":password_hash", $password_hash, PDO::PARAM_STR);
            $stmt->bindValue(":role", $role, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Code: " . $e->getCode();
            if ($e->getCode() == 23000) { //erreur 1062 Duplicate Entry
                return false;
            }
            echo $e->getMessage();
        }
    } */

    public function inserer_tutor_subjects(int $tutor_id, int $subject_id) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO tutor_subjects (tutor_id, subject_id) 
                VALUES (:tutor_id, :subject_id)");
            $stmt->bindValue(":tutor_id", $tutor_id, PDO::PARAM_INT);
            $stmt->bindValue(":subject_id", $subject_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function update_ticket(int $ticket_id, int $category_id, int $status_id, int $priority_id) : void {
        try {
            $stmt = $this->pdo->prepare(
                "UPDATE tickets SET status_id = :new_statut, category_id = :new_category,
                priority_id = :new_priority WHERE id = :ticket_id");
            $stmt->bindValue(":ticket_id", $ticket_id, PDO::PARAM_INT);
            $stmt->bindValue(":new_category", $category_id, PDO::PARAM_INT);
            $stmt->bindValue("new_statut", $status_id, PDO::PARAM_INT);
            $stmt->bindValue("new_priority", $priority_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    //======Inscription======
    public function get_user_by_username(string $username): PDOStatement {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT id FROM users WHERE username = :username LIMIT 1"
            );
            $stmt->execute(['username' => $username]);
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function inserer_user(string $username, string $password_hash, string $role): void {
    try {
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (username, password_hash, role)
            VALUES (:username, :password_hash, :role)"
        );
        $stmt->execute([
            'username' => $username,
            'password_hash' => $password_hash,
            'role' => $role,
        ]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

    //======Connexion======
    public function get_login_user_by_username(string $username): PDOStatement {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT id, username, password_hash, role
                FROM users
                WHERE username = :username
                LIMIT 1"
            );

            $stmt->execute(['username' => $username]);
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    

}
