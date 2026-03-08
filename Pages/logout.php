<?php
    // Démarre la session
    session_start();

    // Supprime toutes les variables de session
    $_SESSION = [];

    // Détruit la session
    session_destroy();
?>

<!DOCTYPE html>
<html>
    <body>

    <h1>Déconnexion</h1>

    <p>Vous êtes maintenant déconnecté.</p>

    <p><a href="login.php">Se reconnecter</a></p>

    <p><a href="index.php">Retour accueil</a></p>

    </body>
</html>