document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const roomNumber = document.getElementById('room-number');
    const roomNumberError = document.createElement('div');
    roomNumberError.classList.add('error-message');
    roomNumber.parentNode.insertBefore(roomNumberError, roomNumber.nextSibling);
    roomNumberError.style.display = 'none';

    const reason = document.getElementById('reason');
    const reasonError = document.getElementById('reason-error');

    form.addEventListener('submit', function (event) {
        let isValid = true;
        event.preventDefault();
        // Validate room number
        if (roomNumber.value.trim() === '') {
            roomNumber.classList.add('input-error');
            roomNumberError.style.display = 'block';
            roomNumberError.textContent = 'Please enter a room number.';
            isValid = false; // Form is not valid
        } else {
            roomNumber.classList.remove('input-error');
            roomNumberError.style.display = 'none';
        }

        // Validate reason
        if (reason.value.trim() === '') {
            reason.classList.add('input-error');
            reasonError.style.display = 'block';
            isValid = false; // Form is not valid
        } else {
            reason.classList.remove('input-error');
            reasonError.style.display = 'none';
        }

        // Validate confirm checkbox
        const confirmCheckbox = document.getElementById('confirm-checkbox');
        const checkboxError = document.getElementById('checkbox-error');

        if (!confirmCheckbox.checked) {
            confirmCheckbox.classList.add('input-error');
            checkboxError.style.display = 'block';
            isValid = false; // Form is not valid
        } else {
            confirmCheckbox.classList.remove('input-error');
            checkboxError.style.display = 'none';
        }

        // Prevent form submission if not valid
        if (!isValid) {
            event.preventDefault();
        }
    });

    // Button to toggle table visibility
    const tableToggleBtn = document.createElement('button');
    tableToggleBtn.textContent = 'Show/Hide Available Rooms';
    tableToggleBtn.classList.add('btn', 'btn-primary', 'availibleroombtn', 'mt-3');
    const availableRooms = document.querySelector('.available-rooms');
    availableRooms.parentNode.insertBefore(tableToggleBtn, availableRooms);

    tableToggleBtn.addEventListener('click', function (event) {
        event.preventDefault();
        if (availableRooms.style.display === 'none' || availableRooms.style.display === '') {
            availableRooms.style.display = 'block';
        } else {
            availableRooms.style.display = 'none';
        }
    });

    // Initial state
    availableRooms.style.display = 'none';

    // Pagination and Search
    const rowsPerPage = 5;
    let currentPage = 1;

    const rooms = Array.from(document.querySelectorAll('#room-table-body tr'));
    const searchInput = document.getElementById('search');
    let filteredRooms = rooms;

    function filterRooms(searchTerm) {
        return rooms.filter(room => {
            const text = room.textContent.toLowerCase();
            return text.includes(searchTerm);
        });
    }

    function renderTable() {
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const visibleRooms = filteredRooms.slice(start, end);

        const roomTableBody = document.getElementById('room-table-body');
        roomTableBody.innerHTML = '';

        visibleRooms.forEach(room => {
            roomTableBody.appendChild(room);
        });

        document.getElementById('page-num').textContent = currentPage;
        const numPages = Math.ceil(filteredRooms.length / rowsPerPage);

        document.getElementById('prev').disabled = currentPage === 1;
        document.getElementById('next').disabled = currentPage === numPages;
    }

    function searchRooms() {
        const searchTerm = searchInput.value.toLowerCase();
        filteredRooms = filterRooms(searchTerm);
        currentPage = 1;
        renderTable();
    }

    // Sorting functionality
    function sortTable(columnIndex, type = 'text') {
        filteredRooms.sort((a, b) => {
            const aText = a.cells[columnIndex].textContent.trim();
            const bText = b.cells[columnIndex].textContent.trim();

            if (type === 'text') {
                return aText.localeCompare(bText);
            } else if (type === 'number') {
                return parseInt(aText, 10) - parseInt(bText, 10);
            } else if (type === 'custom') {
                const order = { R: 0, 1: 1, 2: 2, 3: 3, 4: 4, 5: 5 }; // Custom order for floors
                return order[aText] - order[bText];
            }
        });

        currentPage = 1;
        renderTable();
    }

    renderTable();

    document.getElementById('prev').addEventListener('click', function () {
        if (currentPage > 1) {
            currentPage--;
            renderTable();
        }
    });

    document.getElementById('next').addEventListener('click', function () {
        const numPages = Math.ceil(filteredRooms.length / rowsPerPage);
        if (currentPage < numPages) {
            currentPage++;
            renderTable();
        }
    });

    searchInput.addEventListener('input', function () {
        searchRooms();
    });

    // Attach sort event to table headers
    const tableHeaders = document.querySelectorAll('.available-rooms th');
    tableHeaders[0].addEventListener('click', () => sortTable(0)); // Sort by Block
    tableHeaders[1].addEventListener('click', () => sortTable(1, 'custom')); // Sort by Floor
    tableHeaders[2].addEventListener('click', () => sortTable(2, 'number')); // Sort by Room Number

    document.querySelectorAll('.sortable').forEach(header => {
        header.addEventListener('click', function () {
            const column = this.getAttribute('data-column');
            // const sortOrder = this.classList.contains('sorted-asc') ? 'desc' : 'asc';
    
            // Remove sorting styles from other headers
            document.querySelectorAll('.sortable').forEach(h => {
                h.classList.remove('sorted-asc');
                h.querySelector('.sort-icon').textContent = '⇅';
            });
    
            // Apply sorting styles to the clicked header
            this.classList.add( 'sorted-asc');
            this.querySelector('.sort-icon').textContent =   '↓';
    
            sortTable(column, sortOrder);
        });
    });
    
});
