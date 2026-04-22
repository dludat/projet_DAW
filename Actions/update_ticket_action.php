<?php
include "../config/Database.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Récupérer les données
    $erreurs = array();
    $ticket_id = intval($_POST["ticket_id"]) ?? 0;
    $priorite = intval($_POST["priorite"]) ?? 0;
    $statut = intval($_POST["statut"]) ?? 0;
    $categorie = intval($_POST["categorie"]) ?? 0;

    if ($ticket_id === 0) {
        $erreurs[] = "Problème interne. Essaye de nouveau";
    }if ($priorite === 0) {
        $erreurs[] = "Veuillez définir une priorité";
    }
    if ($statut === 0) {
        $erreurs[] = "Veuillez définir un statut";
    }
    if ($categorie === 0) { 
        $erreurs[] = "Veuillez définir une catégorie";
    }
    if (empty($erreurs)) {
        //Modifier la base de données
        $BDD = new ConnectionBDD();
        $BDD->update_ticket($ticket_id, $categorie, $statut, $priorite);
        
        //afficher le succes
        $_SERVER["succes"] = "La modification a été un succès.";
        header("Location: ../Pages/tickets.php?id=" . $ticket_id);
        exit();
    } else {
        //afficher les erreurs
        $_SERVER["error"] = "";
        foreach ($erreurs as $e) { 
            $_SERVER["error"] .= $e . "\n";
        }
        header("Location: ../Pages/tickets.phpid=" . $ticket_id);
        exit();
    }
}