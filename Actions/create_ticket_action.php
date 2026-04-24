<?php
include '../Model/Database.php';

session_start();

//=== Valider les données ===
//Tableau erreurs
$erreurs = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = htmlspecialchars($_POST['titre']) ?? "";
    if ($titre === "") {
        $erreurs[] = "Un ticket doit avoir un titre remarquable.";
    }

    $cours = intval($_POST["cours"]) ?? 0; //seulement les ids de la BDD envoyé, pas ce qu'était affiché
    if ($cours === 0) {
        $erreurs[] = "Un ticket doit etre attribuer à un cours.";
    }

    $tuteur = intval($_POST["tuteur"]) ?? 0; //seulement les ids de la BDD envoyé, pas ce qu'était affiché
    if ($tuteur === 0) {
        $erreurs[] = "Un ticket doit etre attribuer à un enseignant.";
    }

    $priorite = intval($_POST["priorite"]) ?? 0; //seulement id récupéré
    if ($priorite <= 0 or $priorite > 3) {
        $erreurs[] = "Il y a que les priorités basse, moyenne et haute.";
    }

    $categorie = intval($_POST["categorie"]) ?? 0;
    if ($categorie <= 0 or $categorie > 3) {
        $erreurs[] = "Il y a seulement les catégories cours, TD et TP. Veuillez en selectionner un.";
    }

    $description = htmlspecialchars($_POST["description"]) ?? "";
    if ($description === "") {
        $erreurs[] = "Veuillez décrire votre problème en détail. Sinon il est probablement pas possible de vous aider.";
    }


    //vérifier s'il y a ce cours avec ce tuteur (tutor_subjects)
    $BDD = new ConnectionBDD(); //ouvrir connection BDD
    $cours_de_tutor = $BDD->get_assigned_subjects($tuteur)->fetchAll();
    if (!array_search($cours, $cours_de_tutor)) { //rechercher le cours
        $erreurs[] = "Il n'y a pas ce cours qui est enseigné par le tuteur indiqué.";
    }

    $id_auteur = intval($_SESSION["user_id"]) ?? 0;
    $statut = 1; //après création, ticket toujours ouvert

    if (!empty($erreurs)) {//formulaire ne peut pas etre valider
        $_SESSION["error"] = "";
        foreach ($erreurs as $e) {
            $_SESSION["error"] .= $e;
        }
        //Rentrer à la page précedente
        header("Location: ../Pages/create.php");
        exit();
    } else {
        //inserer ticket dans la BDD
        $BDD->inserer_ticket($id_auteur, $cours, $tuteur, $categorie, $priorite, $statut, $titre, $description);
        $_SESSION["succes"] = "Ticket a été créé avec succès";
        //retourner à l'aperçu
        header("Location: ../Pages/etudiant.php");
        exit();
    }
}
?>