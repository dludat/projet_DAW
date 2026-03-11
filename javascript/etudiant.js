//faire les colonnes du tableau appuyable pour voir les détails d'un ticket
document.querySelectorAll(".appuyable").forEach(row => {
    row.addEventListener("click", () => {
        window.location = row.dataset.href; //chaque ligne insere l'id de ticket avec get
    });
})