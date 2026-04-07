<?php
session_start();

$_SESSION = [];
session_destroy();

require_once __DIR__ . '/menu.php';
echo '<link rel="stylesheet" href="../css/index.css">';
?>

<h2>Déconnexion</h2>

<p>Vous êtes maintenant déconnecté.</p>
<p><a href="login.php">Se reconnecter</a></p>
<p><a href="index.php">Retour accueil</a></p>

</body>
</html>
