document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('book-room-form');
    const roomNumber = document.getElementById('room-number');
    const confirmCheckbox = document.getElementById('confirm-checkbox');

    form?.addEventListener('submit', (event) => {
        let isValid = true;
    
        if (!roomNumber.value.trim()) {
            isValid = false;
        }
    
        if (!confirmCheckbox.checked) {
            isValid = false;
        }
    
        if (!isValid) {
            event.preventDefault();
            alert('Please fill in all required fields');
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
        const searchTerm = searchInput.value.trim().toLowerCase();
    
        // Filter rows based on block, floor, and room number (e.g., "A25")
        filteredRows = rows.filter((row) => {
            const [block, floor, room] = Array.from(row.querySelectorAll('td')).map((col) => col.textContent.toLowerCase().trim());
    
            // Match against full or partial combinations like "A35", "A", "25", etc.
            const combinedText = `${block}${floor}${room}`; // Combine block, floor, and room without spaces
            return (
                block.includes(searchTerm) || // Match block
                floor.includes(searchTerm) || // Match floor
                room.includes(searchTerm) || // Match room
                combinedText.includes(searchTerm) // Match full combination
            );
        });
    
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
