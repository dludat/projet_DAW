<?php
include "../Model/Database.php";
include "../Model/convertir_valeurs.php";

require_once __DIR__ . '/menu.php';

//Utilisateur doit être connecté
if (!isset($_SESSION["user_id"])) {
    $_SESSION["error"] = "Vous devez etre connecte pour consulter un ticket.";
    header('Location: index.php');
    exit();
}
//Valider l'access au ticket
$ticket_id = intval($_GET["id"] ?? 0);
$BDD = new ConnectionBDD();
$author = $BDD->get_ticket_author($ticket_id)->fetch()['author_id']; //Controler qu'on a access
$role = $_SESSION["role"] ?? '';

if ($author != $_SESSION["user_id"] && $role != 'tutor') { //accès pas autorisé
    $_SESSION["error"] = "Vous n'avez pas le droit d'acceder ce ticket.";
}
//Lien peut être différent dependant du rôle
$dashboardLink = $role === 'tutor' ? 'tuteur.php' : 'etudiant.php';

if ($ticket_id <= 0) {
    $_SESSION["error"] = "Le ticket demande est invalide.";
}

if (isset($_SESSION['error'])) { //retourner à la page d'aperçu
    header('Location: ' . $dashboardLink);
    exit();
}

//Télécharger informations du ticket
$ticket_info = $BDD->get_ticket_info($ticket_id)->fetch();
$commentaires = $BDD->get_commentaires($ticket_id)->fetchAll();

//Ticket n'existe pas
if ($ticket_info === false) {
    $_SESSION["error"] = "Le ticket demande est introuvable.";
    header('Location: ' . $dashboardLink);
    exit();
}

//=== Affichage du site ===
?>

<html>
    <body>
        <h2>Aperçu du ticket n <?php echo $ticket_id; ?></h2>

        <table id="info_ticket">
            <caption>Informations importantes</caption>
            <tr>
                <th>créateur</th>
                <th>titre</th>
                <th>Déscription</th>
                <th>Cours</th>
                <th>Tuteur</th>
                <th>Catégorie</th>
                <th>Statut</th>
                <th>Priorité</th>
                <th>date de création</th>
            </tr>
            <tr>
                <?php
                echo "<td>" . $ticket_info["author_name"] . "</td>";
                echo "<td>" . $ticket_info["title"] . "</td>";
                echo "<td>" . $ticket_info["description"] . "</td>";
                echo "<td>" . $ticket_info["name"] . "</td>";
                echo "<td>" . $ticket_info["tutor_name"] . "</td>";
                echo "<td id='categorie' value='" . $ticket_info["category_id"] . "'>" . convertir_categorie($ticket_info["category_id"]) . "</td>";
                echo "<td id='statut' value='" . $ticket_info["status_id"] . "'>" . convertir_statut($ticket_info["status_id"]) . "</td>";
                echo "<td id='priorite' value='" . $ticket_info["priority_id"] . "'>" . convertir_priorite($ticket_info["priority_id"]) . "</td>";
                echo "<td>" . $ticket_info["created_at"] . "</td>";
                ?>
            </tr>
        </table>

        <h3>Commentaires</h3>
        <?php if (count($commentaires) == 0): ?>
            <p>Il n'y a pas encore de commentaires sur ce ticket.</p>
        <?php else: ?>
            <table>
                <caption>Commentaires</caption>
                <tr>
                    <th>Date</th>
                    <th>Auteur</th>
                    <th>Role de l'auteur</th>
                    <th>Message</th>
                </tr>
                <?php
                foreach ($commentaires as $commentaires_item) {
                    echo "<tr>";
                    echo "<td>" . $commentaires_item["created_at"] . "</td>";
                    echo "<td>" . $commentaires_item["username"] . "</td>";
                    echo "<td>" . $commentaires_item["role"] . "</td>";
                    echo "<td>" . $commentaires_item["message"] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        <?php endif; ?>

        <h3>Ajouter un commentaire</h3>
        <form id="nv_commentaire" action="../Actions/add_comment_action.php" method="post">
            <input type="hidden" name="id_ticket" value="<?php echo $ticket_id; ?>">
            <input type="hidden" name="id_auteur" value="<?php echo $_SESSION['user_id']; ?>">
            <label for="contenu">Commentaire</label><br>
            <textarea id="contenu" name="contenu" placeholder="Ajouter votre commentaire ici"></textarea><br>
            <button type="submit" id="valider">Ajouter</button>
        </form>

        <?php if ($role === "tutor"): ?>
            <h3>Modifier le ticket</h3>
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
        <?php endif; ?>

        <p><a href="<?= $dashboardLink ?>">Retour à l'aperçu</a></p>

        <script src="../javascript/ticket.js"></script>
    </body>
</html>
