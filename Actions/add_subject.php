<?php
include '../config/Database.php';

session_start();

//==Validation des données===
//Tableau erreurs
$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']) ?? "";
    if ($nom === "") {
        $erreurs[] = "Nouveau cours doit avoir un nom. Veuillez remplir ce champ.";
    }
    
    $description = htmlspecialchars($_POST['description']) ?? "";
    if ($description === "") {
        $erreurs[] = "Veuillez remplir la description du cours";
    }
    
    $list_enseignants = $_POST['tuteurs']; //array de integers, sécurisé par intval en les insérant dans la BDD
    if (count($list_enseignants) === 0) { //pas d'enseignants choisi
        $erreurs[] = "Veuillez assigner un ou plusieurs enseignants au nouveau cours.";
    }

    if (empty($erreurs)) { //il n y avait pas des erreurs
        //===inserer===
        $BDD = new ConnectionBDD(); //Connection Base de Données
        $BDD->inserer_cours($nom, $description); //Inserer nouveau cours
        $cours = $BDD->get_subject_by_name($nom)->fetch(); //récupérer la id
        $cours_id = $cours['id'];

        foreach ($list_enseignants as $e) { //Ajouter les enseignants au cours
            if ((intval($e) ?? 0) === 0) { //Enseignant n'est pas ajouté
                $_SESSION['error'] = "Il n'était pas possible d'ajouter tous les enseignants au cours";
                continue;
            }
            $BDD->inserer_tutor_subjects(intval($e), $cours_id);
        }

        // Ajouter message du succès
        $_SESSION["succes"] = "Insertion du cours est fait avec succès";
        header("Location: ../Pages/cours.php");
        exit();
    } else {
        //Retourner les erreurs
        $_SESSION['error'] = "";
        foreach ($erreurs as $e) {
        $_SESSION['error'] .= $e;
        }
    }
    header("Location: ../Pages/cours.php");
    exit();
}