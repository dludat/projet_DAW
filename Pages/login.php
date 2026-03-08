<?php
session_start();

include '../config/Database.php';

//Tableau Erreur
$errors = [];
//Trim:Supprime Espaces début et fin
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Validations des champs
    if ($username === '') {
        $errors[] = "Le nom d'utilisateur est obligatoire.";
    }

    if ($password === '') {
        $errors[] = 'Le mot de passe est obligatoire.';
    }


    //====== A MODIFIER AVEC LE COURS DU PROCHAIN CM !!!!!!!!======
    //===== Enregistrement dans la BDD =====
    //Si aucune erreurs est dans le tableau des erreurs
    if (empty($errors)) {
        //Vérification dans la base de donnée de l'existance de l'utilisateur

        //Si oui, vérification du MDP hasher
        if (!$user || !password_verify($password, $user['password_hash'])) {
                $errors[] = 'Identifiants invalides.';
            } 
        else{
            //Si oui, redirection vers etudiant.php si rôle = Etudiant ; sinon tuteur.php
            if ($user['role'] === 'tutor') {
                //Redirection automatique -> tuteur.php
            }
            else {
                //Redirection automatique -> etudiant.php
            }
        }         
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion - Helpdesk</title>
    </head>
    <body>
        <h1>Connexion</h1>

        <?php if (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form action="login.php" method="post">
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