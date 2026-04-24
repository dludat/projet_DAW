<?php
include "../Model/Database.php";

//Afficher le menu, démarrer la session, affichage erreurs
require_once __DIR__ . '/menu.php';

//Controler que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Vous devez etre connecte pour créer un ticket.";
    header('Location: index.php');
    exit();
}

//=== Télécharger les données necessaires
$BDD = new ConnectionBDD();
$cours = $BDD->get_subjects();
$tuteurs = $BDD->get_tutors();
$cours_list = $cours->fetchAll();
$tuteurs_list = $tuteurs->fetchAll();

//=== Affichage du site ===
?>
<html>
    <body>
        <h2>Créer un ticket</h2>

        <form id="nv_ticket" action="../Actions/create_ticket_action.php" method="post">
            <label for="titre">Titre</label><br>
            <input id="titre" name="titre" type="text" required><br><br>

            <label for="cours">Cours</label><br>
            <select id="cours" name="cours" required>
                <?php //Ajouter les options de cours
                foreach ($cours_list as $c) {
                    echo "<option value='" . htmlspecialchars($c["id"]) . "'>" . htmlspecialchars($c["name"]) . "</option>";
                }
                ?>
            </select><br><br>

            <label for="tuteur">Tuteur</label><br>
            <select id="tuteur" name="tuteur" required>
                <?php //Ajouter les options de tuteurs
                foreach ($tuteurs_list as $t) {
                    echo "<option value='" . htmlspecialchars($t["tutor_id"]) . "'>" . htmlspecialchars($t["username"]) . "</option>";
                }
                ?>
            </select><br><br>

            <fieldset>
                <legend>Sélectionnez la priorité du ticket</legend>
                <label for="basse"><input type="radio" name="priorite" id="basse" value="1">Basse</label><br>
                <label for="moyenne"><input type="radio" name="priorite" id="moyenne" value="2" checked>Moyenne</label><br>
                <label for="haut"><input type="radio" name="priorite" id="haut" value="3">Haute</label><br>
            </fieldset>
            <br>

            <fieldset>
                <legend>Sélectionnez la catégorie du ticket</legend>
                <label for="cours-ticket"><input type="radio" name="categorie" id="cours-ticket" value="1">Cours</label><br>
                <label for="td"><input type="radio" name="categorie" id="td" value="2">TD</label><br>
                <label for="tp"><input type="radio" name="categorie" id="tp" value="3">TP</label><br>
            </fieldset>
            <br>

            <label for="description">Décrivez votre problème en détail</label><br>
            <textarea id="description" name="description" cols="30" rows="10"></textarea><br><br>

            <button type="submit" id="valider">Valider</button>
        </form>

        <button class="retour" onclick="window.location.href='
            <?= ($_SESSION['role'] ?? '') === 'tutor' ? 'tuteur.php' : 'etudiant.php' ?>
            '">Retour à l'aperçu</button>

    </body>
</html>
