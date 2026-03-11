<?php
//Récuperer Données
$ticket_id = $_GET["id"];

//Message de succès p. ex. après la création d'une ticket
if (isset($_SESSION["success"])) {
    echo "<p id='succes' style='color:green'> " . $_SESSION["succes"] . "</p>";
    unset($_SESSION["success"]); 
}

//afficher les erreurs
if (isset($_SESSION["error"])) {
    echo "<p id='erreur' style='color:red'> " . $_SESSION["error"] . "</p>";
    unset($_SESSION["error"]); 
}

//Télécharger les données du ticket
//Télécharger tous les commentaires
?>

<html>
    <head>
        <title>Vu en détail des tickets</title>
    </head>
    <body>
        <h1>On me replacera plus tard</h1>
        <table>
            <caption>Ticket Id <?php echo $ticket_id?></caption>
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
            <tr>

            </tr>
        </table>

        <table>
            <caption>Commentaires</caption>
            <tr>
                <th>Date</th>
                <th>Auteur</th>
                <th>Role de l'auteur</th>
                <th>Message</th>
            </tr>
        </table>
        <h3>Ajouter commentaire</h3>
        <form id="nv_commentaire" action="../add_comment_action.php" method="post">
            <input type="hidden" name="id_ticket" value="<?php echo $ticket_id;?>"><br>
            <input type="hidden" name="id_auteur" value="<?php echo $_SESSION['user_id'];?>"><br>
            <textarea name="contenu" placeholder="Ajouter votre commentaire ici"></textarea>
            <button type="submit" id="valider">Ajouter</button>
        </form>
        <button type="button" id="retour" onclick="window.location.href='./tuteur'">Retour à l'aperçu</button>
    </body> 
</html>