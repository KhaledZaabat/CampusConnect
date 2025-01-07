document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('book-room-form');
    const roomNumber = document.getElementById('room-number');
    const confirmCheckbox = document.getElementById('confirm-checkbox');

    form?.addEventListener('submit', (event) => {
        event.preventDefault();
        let isValid = true;

        if (!roomNumber.value.trim()) {
            isValid = false;
        }

        if (!confirmCheckbox.checked) {
            isValid = false;
        }

        if (isValid) {
            // Since we're no longer using AJAX, submit the form normally.
            form.submit();
        } else {
            // Show an error if validation fails (could be an alert or custom message)
            alert('Please fill in all required fields and confirm the terms.');
        }
    });

    const searchInput = document.getElementById('search');
    const roomTableBody = document.getElementById('room-table-body');
    const rows = Array.from(roomTableBody.querySelectorAll('tr'));
    const rowsPerPage = 5;
    let filteredRows = rows;
    let currentPage = 1;

    const renderTable = () => {
        const start = (currentPage - 1) * rowsPerPage;
        const visibleRows = filteredRows.slice(start, start + rowsPerPage);

        roomTableBody.innerHTML = '';
        visibleRows.forEach((row) => roomTableBody.appendChild(row));

        document.getElementById('page-num').textContent = currentPage;
        document.getElementById('prev').disabled = currentPage === 1;
        document.getElementById('next').disabled = currentPage === Math.ceil(filteredRows.length / rowsPerPage);
    };

    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase();
        filteredRows = rows.filter((row) =>
            row.textContent.toLowerCase().includes(searchTerm)
        );
        currentPage = 1;
        renderTable();
    });

    document.getElementById('prev').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            renderTable();
        }
    });

    document.getElementById('next').addEventListener('click', () => {
        if (currentPage < Math.ceil(filteredRows.length / rowsPerPage)) {
            currentPage++;
            renderTable();
        }
    });

    renderTable();

    const tableHeaders = document.querySelectorAll('.sortable');
    tableHeaders.forEach((header, index) => {
        header.addEventListener('click', () => {
            filteredRows.sort((a, b) => {
                const textA = a.cells[index].textContent.trim();
                const textB = b.cells[index].textContent.trim();
                return textA.localeCompare(textB);
            });
            renderTable();
        });
    });
});





