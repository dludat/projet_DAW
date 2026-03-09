<?php
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