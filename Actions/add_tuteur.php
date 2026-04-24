<?php
include '../Model/Database.php';

session_start();

//=== Validation des données ===
//Tableau erreurs
$erreurs = [];

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
    //Aussi possible que nouveau enseignant n'a pas encore de cours
    //Sécurisé par intval
    if (empty($erreurs)) { //il n y avait pas des erreurs
        //Hash le mot de pass
        $hash_mdp = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        //Ajouter utilisateur à BDD
        $BDD = new ConnectionBDD(); //Connection Base de Données
        $BDD->inserer_user($nom, $hash_mdp, 'tutor');
        //Trouver l'id du nouveau utilisateur
        $resultat = $BDD->get_user_by_username($nom)->fetch();
        $id = $resultat['id'];

        //Ajouter données dans tutor_subject
        foreach ($cours_list as $c) {
            if ((intval($c) ?? 0) === 0) { //pas une nombre valide
                $_SESSION['error'] = "Il n'était pas possible d'ajouter tous les cours";
                continue;
            }
            $BDD->inserer_tutor_subjects($id, intval($c));
        }
        // Ajouter message du succès
        $_SESSION["succes"] = "Insertion du tuteur avait succès";
        header("Location: ../Pages/cours.php");
        exit();
    } else {
        //Retourner les erreurs
        $_SESSION['error'] = "";
        foreach ($erreurs as $e) {
            $_SESSION['error'] .= $e;
        }
    }
    //Rentrer à la page de vue
    header("Location: ../Pages/cours.php");
    exit();
}
