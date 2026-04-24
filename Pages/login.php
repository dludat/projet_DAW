<?php
// Charge la classe de connexion et d'accès aux requêtes SQL.
include '../Model/Database.php';

require_once __DIR__ . '/menu.php';

?>
<html>
    <body>
        <h2>Connexion</h2>

        <p><a href="inscription.php">Créer un compte</a></p>
        <form action="../Actions/connexion.php" method="post">
            <label for="username">Nom d'utilisateur</label><br>
            <input id="username" type="text" name="username" value="<?= htmlspecialchars($username) ?>" required><br><br>

            <label for="password">Mot de passe</label><br>
            <input id="password" type="password" name="password" required><br><br>

            <button type="submit">Se connecter</button>
        </form>

        <button class="retour" onclick="window.location.href='index.php'">Retour accueil</button>

    </body>
</html>