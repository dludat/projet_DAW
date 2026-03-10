<?php
session_start();
//afficher les erreurs
if (isset($_SESSION["error"])) {
    echo "<p id='erreur' style='color:red'> " . $_SESSION["error"] . "</p>";
    unset($_SESSION["error"]); 
}

//Télécharger les subjects et tuteurs possibles
$cours; //ici inserer les cours possibles avec noms et id
$tuteurs; //ici inserer les tuteurs possibles avec noms et id (tutor_subjects table)
$cours_list;
$tuteurs_list;

//écrire options pour <select> de cours
//foreach ($cours as $c) { //ajouter tous les options
//    $cours_list .= "<option value='" . htmlspecialchars($c->id) . "'>" . htmlspecialchars($c->name) . "</option>";
//}
//$list .= "</datalist>";

//écrire options pour <select> de tuteurs
//foreach ($tuteurs as $t) { //ajouter tous les options
//    $tuteurs_list .= "<option value='" . htmlspecialchars($t->id) . "'>". htmlspecialchars($t->name) . "</option>";
//}

//notes pour sauvegarder
//Cours: <input name="cours" type="select" list="cours" placeholder="Rechercher des cours" required>
//Tuteur: <input name="tuteur" type="select" list="cours_options" required><br>
//$list = "<datalist id='cours_options' form='nv_ticket'>";
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
                <option value="1">$c.name</option>
                <?php //echo $cours_list; //ajouter tous les options?>
            </select><br>
            Tuteurs:<select name="tuteur" required>
                <option value="2">$c.name</option>
                <?php //echo $tuteurs_list; //ajouter tous les options?>
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