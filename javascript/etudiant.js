//faire les colonnes du tableau appuyable pour voir les détails d'un ticket
console.log("Bonjour");
document.querySelectorAll(".appuyable").forEach(row => {
    row.addEventListener("click", () => {
        console.log("Bouton appuyé");
        window.location = row.dataset.href;
    });
})