<?php
include "../config/Database_tickets.php"; //Connection BDD
//Superglobal $_SESSION utiliser pas encore vu en CM:
//https://www.php.net/manual/en/function.session-start.php

// Démarre la session 
session_start();
require_once __DIR__ . '/menu.php';

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

if (isset($_SESSION["error"])) {
    echo "<p id='erreur' style='color:red'> " . $_SESSION["error"] . "</p>";
    unset($_SESSION["error"]); 
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
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/index.css">
    </head>
    <body>
        <link rel="stylesheet" href="../css/index.css">
        <h3>Ajouter nouveau enseignant:</h3>
        <form action="../Actions/add_tuteur.php" method="post" id="ajouter_enseignant">
            Nom d'utilisateur: <input type="texte" name="nom"><br>
            Mot de passe: <input type="password" name="mot_de_passe"><br>
            <label> Communiquez les enseignants leur mot de passe, s'il vous plait.</label><br>
            Controle mot de passe: <input type="password" name="controle_mdp"><br>

            <fieldset>
                <legend>Assignez l'enseignant à un ou plusieurs cours:</legend>
                <?php //Ajouter tous les options
                foreach($cours_list as $c) { 
                    echo "<div>";
                    echo "<input type='checkbox' name='cours[]' id='" . intval($c["id"]) . "' value=" . intval($c["id"]) .">";
                    echo "<label for=" . intval($c["id"]) . ">" . htmlspecialchars($c["name"]) . "</label><br>";
                    echo "</div>";
                }
                ?>
            </fieldset>
            <button type="submit" id="valider">Enregistrer</button>
        </form>

        <h3>Ajouter nouveau cours</h3>
        <form action="../Actions/add_subject.php" method="post" id="ajouter_cours">
            Nom du cours: <input type="texte" name="nom"><br>
            Description: <textarea name="description"></textarea>

            <fieldset>
                <legend>Assignez un ou plusieurs enseignants au cours:</legend>
                <?php //Ajouter les enseignants comme options
                foreach ($tuteurs_list as $t) {
                    echo "<div>";
                    echo "<input type='checkbox' name='tuteurs[]' id='" . intval($t["id"]) . "' value=" . intval($t["id"]) . ">";
                    echo "<label for=" . intval($t["id"]) . ">" . htmlspecialchars($t["username"]) . "</label>";
                    echo "</div>";
                }
                ?>
            </fieldset>

            <button type="submit" id="valider">Enregistrer</button>
        </form>

        <button type="button" id="retour" onclick="window.location.href='./tuteur.php'">Retour à l'aperçu</button>

    </body>
</html>
