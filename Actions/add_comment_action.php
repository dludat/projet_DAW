<?php
include "../config/Database.php";

session_start();
//Valider les données de la formulaire
if ($_SERVER["REQUEST_METHOD"] ==="POST") {
    //variables donné par le systeme
    //si par correcte, on a besoin de réconnection
    $id_ticket = $_POST["id_ticket"] ?? 0;
    $id_auteur = $_POST["id_auteur"] ?? 0;
    if ($id_ticket === 0 || $id_auteur === 0) {
        $_SESSION["error"] = "Erreur interne. Connectez-vous encore une fois";
        echo "<p>" . $_SESSION["error"] ."";
        header("Location: ../Pages/index.php");
        exit();
    }

    //Validation des données de l'utilisateur
    $contenu = htmlspecialchars($_POST["contenu"]) ?? "";
    if ($contenu === "") {
        $_SESSION["error"] = "Votre commentaire doit avoir un contenu visible. Reessayez.";
        header("Location: ../Pages/tickets.php");
        exit();
    }

    //Insertion dans la BDD
    $_SESSION["succes"] = "Le commentaire a été créé";
    header("Location: ../Pages/tickets.php");
    exit();
}