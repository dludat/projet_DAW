<?php
include "../Model/Database.php";
include "../Model/convertir_valeurs.php";

require_once __DIR__ . '/menu.php';

//Controler que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    $_SESSION["error"] = "Vous devez être connecte pour acceder a l'espace etudiant.";
    header('Location: index.php');
    exit();
}

//rediriger en cas du role faux
if ($_SESSION['role'] == 'tutor') {
    header('Location: tuteur.php');
    exit();
}

//=== Télécharger les données ===
$BDD = new ConnectionBDD();
$data = $BDD->get_tickets_from_student($_SESSION["user_id"]);
$tickets_etudiant = $data->fetchAll();
?>

<html>
    <body>
        <h2>Espace étudiant</h2>
        <p>Bonjour, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></p>
        <p>Rôle: <strong><?= htmlspecialchars($_SESSION['role']) ?></strong></p>
        <p><a href="create.php">Créer un ticket</a></p>
        <p><a href="logout.php">Se déconnecter</a></p>

        <h3>Vos tickets</h3>

        <?php if (count($tickets_etudiant) === 0): ?>
            <p>Vous n'avez pas encore créé de ticket.</p>
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
                    echo "<td>" . htmlspecialchars($_SESSION['username']) . "</td>";
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

        <script src="../javascript/etudiant.js"></script>
    </body>
</html>
