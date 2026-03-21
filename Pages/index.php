<?php
//afficher les erreurs
if (isset($_SESSION["error"])) {
    echo "<p id='erreur' style='color:red'> " . $_SESSION["error"] . "</p>";
    unset($_SESSION["error"]); 
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Bienvenue sur Helpdesk!</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <h1>Bienvenue sur Helpdesk!</h1>
    <h3>Login</h3>
    <form id = "login" action="Pages/login.php" method="post">
        Nom: <input type="text" name="nom"><br>
        Mot de passe: <input type="password" name="mdp"><br>
        <button id="valider">Se connecter</button>
        <button id="inscription" type="button" onclick="window.location.href='Pages/inscription.php'">S'inscrire</button>
    </form>
</html>