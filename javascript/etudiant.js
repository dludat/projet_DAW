//faire les colonnes du tableau appuyable pour voir les détails d'un ticket
//TODO: 
// Ajouter href en concernant ticket_id
// convertir id de catégorie, priorité dans text
document.querySelectorAll(".appuyable").forEach(row => {
    row.addEventListener("click", () => {
        window.location = row.dataset.href; //chaque ligne insere l'id de ticket avec get
    });
})