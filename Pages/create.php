<?php
//télécharger la liste des cours de la BDD
echo "<datalist id='cours_options>"
?>

<html>
    <head>
        <link rel="stylesheet" href="../css/create.css">
        <title>Ajouter ticket nouveau</title>
    </head>
    <body>
        <h1>Creer nouveau ticket:</h1>
        <form action="../Actions/create_ticket_action.php" method="get">
            Titre: <input name="titre" type="text" required><br>
            Cours: <input name="cours" type="search" list="" placeholder="Rechercher des cours" required>
            <button type="button" name="recherche_cours">Rechercher</button><br>
            Tuteur: <input name="tuteur" type="search" required list="cours_options"><br>

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
            <label>Déscrivez votre problème en détail</label>
            <textarea type="text" name="description" cols="30" rows="10">
            </textarea>
            <br>
        </form>
        <button type="button" id="retour" onclick="window.location.href='./etudiant'">Retour à l'aperçu</button>
    </body>
</html>

<?php

//Function de recherche pour les matières
?> 