<?php
include "../Model/Database.php";
include "../Model/convertir_valeurs.php";

session_start();

if (!isset($_SESSION["user_id"])) {
    $_SESSION["error"] = "Vous devez etre connecte pour acceder a l'espace tuteur.";
    header('Location: index.php');
    exit();
}

if ($_SESSION['role'] == 'student') {
    header('Location: etudiant.php');
    exit();
}

$BDD = new ConnectionBDD();
$data = $BDD->get_all_tickets($_SESSION["user_id"]);
$tickets_etudiant = $data->fetchAll();

require_once __DIR__ . '/menu.php';
echo '<link rel="stylesheet" href="../css/index.css">';
?>

<h2>Espace tuteur</h2>
<p>Bonjour, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></p>
<p>Rôle: <strong><?= htmlspecialchars($_SESSION['role']) ?></strong></p>
<p><a href="create.php">Créer un ticket</a></p>
<p><a href="logout.php">Se déconnecter</a></p>

<h3>Tickets à suivre</h3>

<?php if (count($tickets_etudiant) === 0): ?>
    <p>Aucun ticket n'est encore disponible.</p>
<?php else: ?>
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

        <?php
        foreach ($tickets_etudiant as $ticket) {
            echo "<tr class='appuyable' data-href='../Pages/tickets.php?id=" . $ticket['id'] . "'>";
            echo "<td>" . htmlspecialchars($ticket['id']) . "</td>";
            echo "<td>" . htmlspecialchars($ticket['author_name']) . "</td>";
            echo "<td>" . htmlspecialchars($ticket['title']) . "</td>";
            echo "<td>" . htmlspecialchars($ticket['name']) . "</td>";
            echo "<td>" . convertir_statut($ticket['status_id']) . "</td>";
            echo "<td>" . htmlspecialchars($ticket['created_at']) . "</td>";
            if ($ticket['message'] != '') {
                echo "<td>" . htmlspecialchars($ticket['message']) . "<br>le " .
                htmlspecialchars($ticket['comment_date']) . "</td>";
            } else {
                echo "<td>Pas encore de commentaires</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
<?php endif; ?>

<script src="../javascript/tuteur.js"></script>
</body>
</html>
