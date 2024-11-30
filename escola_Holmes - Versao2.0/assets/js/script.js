

document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchInput");
    const table = document.getElementById("alunosTable");
    const rows = table.querySelectorAll("tbody tr");
    const headers = table.querySelectorAll("thead th[data-sort]");

    // Filtro por nome ou email
    searchInput.addEventListener("input", () => {
        const filter = searchInput.value.toLowerCase();
        rows.forEach(row => {
            const name = row.children[1].textContent.toLowerCase();
            const email = row.children[2].textContent.toLowerCase();
            if (name.includes(filter) || email.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });

    // Ordenação por coluna
    headers.forEach(header => {
        header.addEventListener("click", () => {
            const sortKey = header.dataset.sort;
            const sortedRows = Array.from(rows).sort((a, b) => {
                const aText = a.querySelector(`td:nth-child(${sortKey === 'select' ? 1 : sortKey === 'username' ? 2 : 3})`).textContent;
                const bText = b.querySelector(`td:nth-child(${sortKey === 'select' ? 1 : sortKey === 'username' ? 2 : 3})`).textContent;
                return aText.localeCompare(bText);
            });

            // Reorganiza as linhas da tabela
            const tbody = table.querySelector("tbody");
            tbody.innerHTML = "";
            sortedRows.forEach(row => tbody.appendChild(row));
        });
    });
});
