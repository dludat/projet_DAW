<?php
session_start();

// afficher les erreurs
if (isset($_SESSION["error"])) {
    echo "<p id='erreur' style='color:red'>" . $_SESSION["error"] . "</p>";
    unset($_SESSION["error"]);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Bienvenue sur Helpdesk!</title>
    <link rel="stylesheet" href="/css/index.css">
</head>
<body>
    <h1>Bienvenue sur Helpdesk!</h1>
    <h3>Choisissez une action</h3>

    <button id="connexion" type="button" onclick="window.location.href='/Pages/login.php'">
        Se connecter
    </button>
    <button id="inscription" type="button" onclick="window.location.href='/Pages/inscription.php'">
        S'inscrire
    </button>
    </body>
</html>
