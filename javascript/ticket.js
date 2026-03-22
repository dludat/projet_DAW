//Récupérer catégorie
categorie = document.querySelector("table #categorie");
console.log(categorie.getAttribute("value"));

priorite = document.querySelector("table #priorite");
console.log(priorite.getAttribute("value"));

statut = document.querySelector("table #statut");
console.log(statut.getAttribute("value"));

try { //si role=tuteur
    switch(categorie.getAttribute("value")) { //choisir dans formualaire update_ticket categorie actuel par défaut
        case "1":
            document.querySelector("#update_ticket #cours").setAttribute("checked", true);
            break;
        case "2":
            document.querySelector("#update_ticket #td").setAttribute("checked", true);
            break;
        case "3":
            document.querySelector("#update_ticket #tp").setAttribute("checked", true);
            break;
    }
    
    switch(priorite.getAttribute("value")) { //choisir dans formualaire update_ticket priorite actuel par défaut
        case "1":
            document.querySelector("#update_ticket #basse").setAttribute("checked", true);
            break;
        case "2":
            document.querySelector("#update_ticket #moyenne").setAttribute("checked", true);
            break;
        case "3":
            document.querySelector("#update_ticket #haute").setAttribute("checked", true);
            break;
    }

    switch(statut.getAttribute("value")) { //choisir dans formualaire update_ticket statut actuel par défaut
        case "1":
            document.querySelector("#update_ticket #ouvert").setAttribute("checked", true);
            break;
        case "2":
            document.querySelector("#update_ticket #en_cours").setAttribute("checked", true);
            break;
        case "3":
            document.querySelector("#update_ticket #resolu").setAttribute("checked", true);
            break;
    }
} catch {
    //aucune conséquence
}

