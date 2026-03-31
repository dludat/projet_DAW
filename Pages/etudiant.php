<?php
include "../config/Ticket.php"; //Connection BDD
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

//Rédirection en cas de role faux
if ($_SESSION['role'] == 'tutor') {
    header('Location: tuteur.php');
    exit();
}

//afficher que l'action a été effectué
if (isset($_SESSION['succes'])) {
    echo "<p style='color:green'>" . $_SESSION['succes'] .'</p>';
    unset($_SESSION['succes']);
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Espace utilisateur - Helpdesk</title>
        <link rel="stylesheet" href="../css/etudiant.css">
    </head>
    <body>
        <h1>Espace utilisateur</h1>

        <p>Bonjour, 
            <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
        </p>

        <p>Rôle: 
            <strong><?= htmlspecialchars($_SESSION['role']) ?></strong>
        </p>

        <p>Connexion réussie :) </p>
        <p><a href="logout.php">Se déconnecter</a></p>

        <h3>Démarre maintenant tes actions!</h3>
        <button type="button" id="creer_ticket" onclick="window.location.href='./create.php'">Créer nouveau ticket</button>
        <h4>Tes tickets:</h4>


        <table>
            <caption>Votre tickets:</caption>
            <tr>
                <th>id</th>
                <th>créateur</th>
                <th>titre</th>
                <th>catégorie</th>
                <th>priorité</th>
                <th>date de création</th>
                <th>statut</th>
                <th>dernier commentaire</th>
            </tr>

            <?php //Télécharger et afficher les tickets de la BDD
            $BDD = new ConnectionBDD();
            $data = $BDD->get_students_tickets_info($_SESSION["user_id"]); //consulter BDD
            while ($ligne = $data->fetch()): //afficher les tickets?>
            <tr class="appuyable">
                <td><?php echo htmlspecialchars($ligne['id']); ?></td>
                <td><?php echo htmlspecialchars($_SESSION['username']); //ici seulement tickets d'utilisateur actuel; ?></td>
                <td><?php echo htmlspecialchars($ligne['title']); ?></td>
                <td><?php echo htmlspecialchars($ligne['category_id']); //converti par javascript dans text?></td>
                <td><?php echo htmlspecialchars($ligne['priority_id']); //converti par javascript dans text?></td>
                <td><?php echo htmlspecialchars($ligne['created_at']); ?></td>
                <td><?php echo htmlspecialchars($ligne['status_id']); //converti par javascript dans text?></td>
                <td><?php echo htmlspecialchars($ligne['message']);?>
                </td>
            </tr>
            
            <?php endwhile ?>
            <tr class="appuyable" data-href="./tickets.php?id=1">
                <td>1</td>
                <td>David Ludat</td>
                <td>Problèmes avec l'inscription Plubel</td>
                <td>Cours</td>
                <td>Haute</td>
                <td>22/07/21</td>
                <td>Ouvert</td>
                <td>J'en travaille, Ryan, 29/07/21</td>
            </tr>
            <tr class="appuyable" data-href="./tickets.php?id=2">
                <td>1</td>
                <td>David Ludat</td>
                <td>Problèmes avec l'inscription Plubel</td>
                <td>Cours</td>
                <td>Haute</td>
                <td>22/07/21</td>
                <td>Ouvert</td>
                <td>J'en travaille, Ryan, 29/07/21</td>
            </tr>
            <tr class="appuyable" data-href="./tickets.php?id=3">
                <td>1</td>
                <td>David Ludat</td>
                <td>Problèmes avec l'inscription Plubel</td>
                <td>Cours</td>
                <td>Haute</td>
                <td>22/07/21</td>
                <td>Ouvert</td>
                <td>J'en travaille, Ryan, 29/07/21</td>
            </tr>
        </table>
        <script src="../javascript/etudiant.js"></script>
    </body>
</html>