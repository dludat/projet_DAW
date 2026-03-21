<?php
/*Fonctions nécessaire:
GET Données:
get_subjects:   SELECT id, name FROM subjects;
get_tutors:     SELECT DISTINCT tutor_id FROM tutors_subjects;
get_students_ticket(<userId>): SELECT * FROM Tickets T JOIN users ON T.authorId = U.id WHERE U.id = <userId>;
get_ticket(<id>): SELECT * FROM Tickets WHERE id = <id>;
get_commentaires(<ticket_id>): SELECT * WHERE ticket_id = <ticket_id>;
test_tutors_subject:    SELECT COUNT(*) FROM tutors_subjects WHERE tutor_id = <id> AND subject_id = <id>;

Inserer Données:
insert_ticket: INSERT INTO tickets VALUES (...);
insert_commentaire: INSERT INTO comments VALUES (...);

Modifier Données:
change_status(<ticket_id>): UPDATE Tickets SET status_id = new_statut;
change_priorite(<ticket_id>): UPDATE Tickets SET priority_id = new_priorite;
*/

//Définition d'un ticket, evtl pas utilisé plus tard
class Ticket {
    public int $id;
    public string $auteur;
    public string $title;
    public string $description;
    public array $commentaires;
    public string $tuteur;
    public int $categorie; //0: Cours; 1: TD; 2: TP
    public int $priorite; //0: Basse; 1: Moyen; 2: Haut 
    public int $statu; //0: Ouver; 1: En cours; 2: Resolu
    public DateTime $date;

    public function __construct(int $id, string $auteur, string $title, string $description, int $categorie, int $priorite, string $tuteur) {
        $this->id = $id;
        $this->auteur = $auteur;
        $this->tuteur = $tuteur;
        $this->title = $title;
        $this->description = $description;
        $this->categorie = $categorie;
        $this->priorite = $priorite;
        $this->statu = 0;
        $this->date = new DateTime();
    }

    public function getInfo(): array {
        return 0;
    }

    public function maj_status(int $statu) { //Mettre à jour du status, seulement par tuteurs
        if (0 <= $statu and $statu < 3) {
            $this->statu = $statu;
        }
    }

    public function ajoute_commentaire(string $commentaire) { //ajoute commentaire à array
        $this->commentaires[] = $commentaire;
    }

}

//Connection de la base de données