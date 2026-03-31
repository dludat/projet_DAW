<?php
include "../config/Ticket.php";

session_start();
//afficher les erreurs
if (isset($_SESSION["error"])) {
    echo "<p id='erreur' style='color:red'> " . $_SESSION["error"] . "</p>";
    unset($_SESSION["error"]); 
}

//Télécharger les subjects et tuteurs possibles
$BDD = new ConnectionBDD();

$cours = $BDD->get_subjects(); //consulter BDD pour cours possibles
$tuteurs = $BDD->get_tutors(); //ici inserer les tuteurs possibles avec noms et id (tutor_subjects table)
$cours_list = $cours->fetchAll(); //générer les listes pour les insérer dans select
$tuteurs_list = $tuteurs->fetchAll();

?>

<html>
    <head>
        <link rel="stylesheet" href="../css/create.css">
        <title>Ajouter ticket nouveau</title>
    </head>
    <body>
        <h1>Creer nouveau ticket:</h1>
        <form id="nv_ticket" action="../Actions/create_ticket_action.php" method="post">
            Titre: <input name="titre" type="text" required><br>
            Cours:<select name="cours" required>
                <?php //ajouter tous les options
                foreach($cours_list as $c) { 
                    echo "<option value='" . htmlspecialchars($c["id"]) ."'>". htmlspecialchars($c["name"]) . "</option>";
                }
                ?>
            </select><br>
            Tuteurs:<select name="tuteur" required>
                <?php //ajouter tous les options
                foreach($tuteurs_list as $t) { 
                    echo "<option value='" . htmlspecialchars($t["tutor_id"]) ."'>". htmlspecialchars($t["username"]) . "</option>";
                }
                ?>
            </select><br>

            <fieldset>
                <legend>Sélectionnez la priorité du ticket</legend>
                <input type="radio" name="priorite" id="basse" value="1">
                <label for="basse">Basse</label><br>
                <input type="radio" name="priorite" id="moyenne" value="2" checked>
                <label for="moyenne">Moyenne</label><br>
                <input type="radio" name="priorite" id="haut" value="3">
                <label for="Haute">Haute</label><br>
            </fieldset>
            <br>
            <fieldset>
                <legend>Sélectionnez la catégorie du ticket</legend>
                <input type="radio" name="categorie" id="cours" value="1">
                <label for="cours">Cours</label><br>
                <input type="radio" name="categorie" id="td" value="2">
                <label for="td">TD</label><br>
                <input type="radio" name="categorie" id="tp" value="3">
                <label for="tp">TP</label><br>
            </fieldset><br>
            <label for="description">Décrivez votre problème en détail</label>
            <textarea type="text" name="description" cols="30" rows="10">
            </textarea>
            <br>
            <button type="submit" id="valider">Valider</button>
        </form>
        <button type="button" id="retour" onclick="window.location.href='./etudiant'">Retour à l'aperçu</button>
    </body>
</html>