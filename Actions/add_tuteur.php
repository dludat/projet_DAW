<?php
include '../config/Database_tickets.php';

session_start();
//Tableau erreurs
$erreurs = [];

$BDD = new ConnectionBDD(); //Connection Base de Données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']) ?? "";
    if ($nom === "") {
        $erreurs[] = "Nouveau enseigneur doit avoir un nom. Veuillez remplir ce champ.";
    }
    $mot_de_passe = htmlspecialchars($_POST["mot_de_passe"]) ?? "";
    if ($mot_de_passe === "") {
        $erreurs[] = "Compte doit avoir un mot de passe";
    }
    $controle_mdp = htmlspecialchars($_POST['controle_mdp']) ?? "";
    if ($controle_mdp === "" || $controle_mdp != $mot_de_passe) {
        $erreurs[] = "Veuillez confirmer le mot de passe correctement";
    }
    $cours_list = $_POST['cours']; //liste de tous les checkboxes sélectionnés

    if (empty($erreurs)) { //il n y avait pas des erreurs
        //Hash le mot de pass
        $hash_mdp = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        //Ajouter utilisateur à BDD
        $result = $BDD->inserer_user($nom, $hash_mdp, 'tutor');
        if ($result) { //insertion avait succès

            //Trouver l'id du nouveau utilisateur
            $resultat = $BDD->get_user_id($nom)->fetch();
            $id = $resultat['id'];
            echo $id;

            //Ajouter données dans tutor_subject
            foreach ($cours_list as $c) {
                $BDD->inserer_tutor_subjects($id, intval($c));
            }
            // Ajouter message du succès
            $_SESSION["succes"] = "Insertion du tuteur avait succès";
            header("Location: ../Pages/cours.php");
            exit();
        } else {
            $erreurs[] = "Echèc. Utilisateur ne pourrait pas etre créé, nom d'utilisateur dupliqué.";
        }
    }
    //Retourner les erreurs
    $_SESSION['error'] = "";
    foreach ($erreurs as $e) {
        $_SESSION['error'] .= $e;
    }
    header("Location: ../Pages/cours.php");
    exit();
}
