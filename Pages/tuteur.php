<?php

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

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Espace utilisateur - Helpdesk</title>
        <link rel="stylesheet" href="../css/tuteur.css">
    </head>
    <body>
        <h1>Espace utilisateur</h1>

        <p>Bonjour, 
            <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
        </p>

        <p>Rôle: 
            <strong><?= htmlspecialchars($_SESSION['role']) ?></strong>
        </p>

        <p>Connexion réussie :)</p>
        <p><a href="logout.php">Se déconnecter</a></p>

        <h1>Bienvenue chez Helpdesk</h1>
        <h3>Démarre maintenant tes actions!</h3>
        <h4>Tous les derniers tickets:</h4>
        <ul>
            <li>Ticket1</li>
            <li>Ticket2</li>
            <li>Ici ajouter plus tard les tickets de base de données</li>
        </ul>
        <button type="button" id="voir_tickets" onclick="window.location.href='./tickets.php'">Voir la liste extensive</button>
    </body>
</html>

<?php
//Télécharger les données de la bd
//les afficher en forme courte
?>