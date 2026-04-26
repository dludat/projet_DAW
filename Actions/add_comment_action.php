<?php
include "../Model/Database.php";

session_start();

//=== Valider les données du formulaire===
if ($_SERVER["REQUEST_METHOD"] ==="POST") {
    //variables donné par le systeme
    //si par correcte, on a besoin de réconnection
    $id_ticket = intval($_POST["id_ticket"]) ?? 0;
    $id_auteur = intval($_POST["id_auteur"]) ?? 0;
    if ($id_ticket === 0 || $id_auteur === 0) {
        $_SESSION["error"] = "Erreur interne. Connectez-vous encore une fois";
        header("Location: ../Pages/index.php"); //retourner à la page précedent
        exit();
    }

    //Validation des données de l'utilisateur
    $contenu = htmlspecialchars($_POST["contenu"]) ?? "";
    if ($contenu === "") {
        $_SESSION["error"] = "Votre commentaire doit avoir un contenu visible. Reessayez.";
        header("Location: ../Pages/tickets.php?id=" . $id_ticket);
        exit();
    } else {
        //Insertion dans la BDD
        $BDD = new ConnectionBDD();
        $BDD->inserer_commentaire($id_ticket, $id_auteur, $contenu);

        //Commentaire succès
        $_SESSION["succes"] = "Le commentaire a été créé";
        header("Location: ../Pages/tickets.php?id=" . $id_ticket);
        exit();
    }

}