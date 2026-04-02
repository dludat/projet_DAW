<?php
include "../config/Database_tickets.php"; //Connection BDD
include "../config/convertir_valeurs.php"; //Convertir ints de statut etc en texte
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

//Télécharger et préparer les données pour les afficher
$BDD = new ConnectionBDD();
$data = $BDD->get_students_tickets_info($_SESSION["user_id"]); //consulter BDD
$tickets_etudiant = $data->fetchAll();
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

        <?php if (count($tickets_etudiant) === 0): //Pas encore de tickets de l'étudiant?>
        <p>Vous avez pas encore créer des tickets. Pour en voir, veuillez les créer.</p>
        <?php else: //Afficher les tickets?>
        <table>
            <caption>Votre tickets:</caption>
            <tr>
                <th>id</th>
                <th>créateur</th>
                <th>titre</th>
                <th>Cours</th>
                <th>Statut</th>
                <th>date de création</th>
                <th>dernier commentaire</th>
            </tr>

            <?php //Afficher les tickets de la BDD
            foreach ($tickets_etudiant as $ticket) {//afficher les tickets
                echo "<tr class='appuyable' data-href='../Pages/tickets.php?id=" . $ticket['id'] . "'"; //pour appuyer et le paramètre get
                echo "<td>" . htmlspecialchars($ticket['id']) . "</td>";
                echo "<td>" . htmlspecialchars($_SESSION['username']). "</td>"; //ici seulement tickets d'utilisateur actuel
                echo "<td>" . htmlspecialchars($ticket['title']) . "</td>";
                echo "<td>" . htmlspecialchars($ticket['name']) . "</td>"; //nom du cours
                echo "<td>" . convertir_statut($ticket['status_id']) . "</td>";
                echo "<td>" . htmlspecialchars($ticket['created_at']) . "</td>";
                if ($ticket['message'] != '') { //éviter message vide sans date
                    echo "<td>" . htmlspecialchars($ticket['message']) . "\n " . 
                    htmlspecialchars($ticket['comment_date']) . "</td>";
                } else {
                    echo "<td>Pas encore de commentaires</td>";
                }
                echo "</tr>";
            } //end foreach?>
            <tr class="appuyable" data-href="./tickets.php?id=2">
                <td>1</td>
                <td>David Ludat</td>
                <td>Problèmes avec l'inscription Plubel</td>
                <td>DAW</td>
                <td>Ouvert</td>
                <td>22/07/21</td>
                <td>J'en travaille, Ryan, 29/07/21</td>
            </tr>
        </table>
        <?php endif ?>

        <script src="../javascript/etudiant.js"></script>
    </body>
</html>