document.addEventListener("DOMContentLoaded", () => {
    const tableCells = document.querySelectorAll(".selectable");
    const selectedFieldDisplay = document.getElementById("selected-field");

    tableCells.forEach((cell) => {
        cell.addEventListener("click", () => {
            tableCells.forEach((c) => c.classList.remove("selected"));

            cell.classList.add("selected");

            const field = cell.parentElement.cells[0].textContent.trim();

            const date = cell.closest("table").querySelector("thead").rows[0].cells[cell.cellIndex].textContent.trim();

            selectedFieldDisplay.textContent = `${field}, ${date}`;
        });
    });
});
