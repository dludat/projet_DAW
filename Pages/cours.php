<?php
include "../config/Database_tickets.php"; //Connection BDD
//Superglobal $_SESSION utiliser pas encore vu en CM:
//https://www.php.net/manual/en/function.session-start.php

// Démarre la session 
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION["user_id"])) {
    // Message si l'utilisateur n'est pas connecté & Redirige menu principal
    echo "Vous devez être connecté.";
    echo '<p><a href="index.php">Retour à l\'accueil</a></p>';
}

//Rédirection en cas de role faux
if ($_SESSION['role'] == 'student') {
    header('Location: etudiant.php');
    exit();
}

//afficher que l'action a été effectué
if (isset($_SESSION['succes'])) {
    echo "<p style='color:green'>" . $_SESSION['succes'] .'</p>';
    unset($_SESSION['succes']);
}

//Télécharger tous les cours et tuteurs
$BDD = new ConnectionBDD();
$cours = $BDD->get_subjects();
$cours_list = $cours->fetchAll();

$tuteurs = $BDD->get_tutors();
$tuteurs_list = $tuteurs->fetchAll();
?>
<html>
    <head>
        <title>Elargir la BDD</title>
    </head>
    <body>
        <form action="../Actions/add_tuteur.php" method="post" id="ajouter_enseignant">
            Nom d'utilisateur: <input type="texte" name="nom"><br>
            Mot de passe: <input type="password" name="mot_de_passe"><br>
            <label> Communiquez les enseignants leur mot de passe, s'il vous plait.
            Controle mot de passe: <input type="password" name="controle_mdp"><br>

            Assignez l'enseignant à un ou plusieurs cours:<br>
            <select name="cours" multiple>
                <?php //Ajouter tous les options
                foreach($tuteurs_list as $t) { 
                    echo "<option value='" . htmlspecialchars($t["tutor_id"]) ."'>". htmlspecialchars($t["username"]) . "</option>";
                }
                ?>
            </select>
            <button type="submit" id="valider">Enregistrer</button>
        </form>

        <form action="../Actions/add_subject.php" method="post" id="ajouter_cours">
            Nom du cours: <input type="texte" name="nom"><br>
            Description: <textarea name="description"></textarea>

            Assignez un ou plusieurs enseignants au cours:<br>
            <select name="enseignants" multiple>
                <?php //ajouter tous les options
                foreach($cours_list as $c) { 
                    echo "<option value='" . htmlspecialchars($c["id"]) ."'>". htmlspecialchars($c["name"]) . "</option>";
                }
                ?>
            </select>
            <button type="submit" id="valider">Enregistrer</button>
        </form>

    </body>
</html>