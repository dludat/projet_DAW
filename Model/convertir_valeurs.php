<?php
//Fonctions pour convertir des valeurs int en texte
function convertir_statut(int $statut): string {
    $texte = "";
    switch ($statut) {
        case 1: //Ouvert
            $texte =  "Ouvert";
            break;
        case 2: //en Cours
            $texte = "En Cours";
            break;
        case 3: //Resolu
            $texte = "Résolu";
            break;
    }
    return $texte;
}

function convertir_priorite(int $priorite): string {
    $texte = "";
    switch ($priorite) {
        case 1: //Basse
            $texte = "Basse";
            break;
        case 2: //Moyenne
            $texte = "Moyenne";
            break;
        case 3: //Haute
            $texte = "Haute";
            break;
    }
    return $texte;
}

function convertir_categorie(int $categorie): string {
    $texte = "";
    switch ($categorie) {
        case 1: //cours
            $texte = "Cours";
            break;
        case 2: //TD
            $texte = "TD";
            break;
        case 3: //TP
            $texte = "TP";
            break;
    }
    return $texte;
}
?>