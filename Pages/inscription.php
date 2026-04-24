<?php
// Charge la classe de connexion et d'accès aux requêtes SQL.
include '/../Model/Database.php';

require_once __DIR__ . '/menu.php';
?>

<html>
    <body>
        <h2>Inscription</h2>

        <form action="../Actions/authentification.php" method="post">
            <p>
                <label for="username">Nom d'utilisateur</label><br>
                <input id="username" type="text" name="username">
            </p>

            <p>
                <label for="password">Mot de passe</label><br>
                <input id="password" type="password" name="password">
            </p>

            <p>
                <label for="password_confirm">Confirmer le mot de passe</label><br>
                <input id="password_confirm" type="password" name="password_confirm">
            </p>

            <p>
                <label for="role">Rôle</label><br>
                <select id="role" name="role">
                    <option value="student">Étudiant</option>
                    <option value="tutor">Tuteur</option>
                </select>
            </p>

            <p>
                <button type="submit">S'inscrire</button>
            </p>
        </form>

        <p><a href="login.php">Déjà inscrit ? Se connecter</a></p>
        <p><a href="index.php">Retour accueil</a></p>
    </body>
</html>


