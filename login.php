<?php
$erreurs = [];

$nom = $_POST["nom"] ?? "";
echo $nom . "<br>";
if ($nom === "") {
    $erreurs[] = "Nom d'utilisateur obligatoire<br>";
}
$mot_de_passe = $_POST["mdp"] ?? "";
if ($mot_de_passe === "") {
    $erreurs[] = "Mot de passe obligatoire<br>";
}

if (!empty($erreurs)) {
    foreach ($erreurs as $e) {
        echo $e;
    }
} else { //vérifier mot de passe et ajouter role (etudiant/tuteur)
    $_SESSION["role"] = "etudiant"; 
}
?>
<html>
    <body>
        <button type="button" onclick="window.location.href='./index.html' ">back</button>
        <button type="button" onclick="window.location.href=' ./etudiant.html'">site d'apercu</button>
    </body>
</html>