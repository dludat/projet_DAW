<?php
// Charge la classe de connexion et d'accès aux requêtes SQL.
include '../Model/Database.php';

require_once __DIR__ . '/menu.php';

?>

<h2>Connexion</h2>

<form action="../Actions/connexion.php" method="post">
    <label for="username">Nom d'utilisateur</label><br>
    <input id="username" type="text" name="username" value="<?= htmlspecialchars($username) ?>" required><br><br>

    <label for="password">Mot de passe</label><br>
    <input id="password" type="password" name="password" required><br><br>

    <button type="submit">Se connecter</button>
</form>

<p><a href="inscription.php">Créer un compte</a></p>
<p><a href="index.php">Retour accueil</a></p>

</body>
</html>
