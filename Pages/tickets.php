<?php
//Récuperer Données
session_start();
$ticket_id = $_GET["id"];
$role = $_SESSION["role"]; //Variable défini en se connectant

$role = "tuteur"; //pour un test

//Message de succès p. ex. après la création d'une ticket
if (isset($_SESSION["succes"])) {
    echo "<p id='succes' style='color:green'> " . $_SESSION["succes"] . "</p>";
    unset($_SESSION["succes"]); 
}

//afficher les erreurs
if (isset($_SESSION["error"])) {
    echo "<p id='erreur' style='color:red'> " . $_SESSION["error"] . "</p>";
    unset($_SESSION["error"]); 
}

//Télécharger les données du ticket
//Télécharger tous les commentaires
//Inserer les données dans le tableau en modifiant aussi les attributes values
$priorite_actuel;
$statut_actuel;
$categorie_actuel;
?>

<html>
    <head>
        <title>Vu en détail des tickets</title>
    </head>
    <body>
        <h1>Aperçu du ticket Nr <?php echo $ticket_id?></h1>
        <table id="info_ticket">
            <caption>Informations importantes</caption>
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
                <td id="ticket_id">1</td>
                <td id="auteur">David Ludat</td>
                <td id="titre">Problème</td>
                <td id="categorie" value="3">TP</td>
                <td id="priorite" value="3">Haute</td>
                <td id="date">22/03/2026</td>
                <td id="statut" value="1">Ouvert</td>
                <td id="commentaire_dern">Hallo</td>
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
        <form id="nv_commentaire" action="../Actions/add_comment_action.php" method="post">
            <input type="hidden" name="id_ticket" value="<?php echo $ticket_id;?>"><br>
            <input type="hidden" name="id_auteur" value="<?php echo $_SESSION['user_id'];?>"><br>
            <textarea name="contenu" placeholder="Ajouter votre commentaire ici"></textarea>
            <button type="submit" id="valider">Ajouter</button>
        </form>

        <?php if ($role === "tuteur"): 
        //Seulement afficher si on a le droit de modifier le ticket?>
        <h3>Modifier Ticket</h3>
        <form id='update_ticket' action='../Actions/update_ticket_action.php' method='post'>
        
        <?php echo sprintf("<input name='ticket_id' type='hidden' value='%s'>", $ticket_id); ?>
        <fieldset>
            <legend>Veuillez sélectionner la priorité du ticket</legend>

            <input type='radio' name='priorite' id='basse' value='1'> 
            <label for='basse'>Basse</label><br>

            <input type='radio' name='priorite' id='moyenne' value='2'> 
            <label for='moyenne'>Moyenne</label><br>

            <input type='radio' name='priorite' id='haute' value='3'>
            <label for='haute'>Haute</label><br>
        </fieldset>
        <br>
        <fieldset>
            <legend>Veuillez sélectionner le statut de ticket</legend>

            <input type='radio' name='statut' id='ouvert' value='1'>
            <label for='ouvert'>Ouvert</label><br>

            <input type='radio' name='statut' id='en_cours' value='2'>
            <label for='En Cours'>En Cours</label><br>

            <input type='radio' name='statut' id='resolu' value='3'>
            <label for='resolu'>Résolu</label><br>
        </fieldset>
        <br>
        <fieldset>
            <legend>Veuillez sélectionner la catégorie du ticket</legend>

            <input type='radio' name='categorie' id='cours' value='1'>
            <label for='cours'>Cours</label><br>

            <input type='radio' name='categorie' id='td' value='2'>
            <label for='td'>TD</label><br>

            <input type='radio' name='categorie' id='tp' value='3'>
            <label for='tp'>TP</label><br>
        </fieldset><br>

        <button type='submit' id='modifier'>Modifier</button>
    </form>
    <?php endif; //fin afficher si role=tuteur?>
        
        <button type="button" id="retour" onclick="window.location.href='./tuteur.php'">Retour à l'aperçu</button>
    
        <script src="../javascript/ticket.js"></script>
    </body> 
</html>