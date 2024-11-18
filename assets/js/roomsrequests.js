document.addEventListener("DOMContentLoaded", () => {
    const requests = [
        { studentName: "John Doe", currentRoom: "A-R-5", requestedRoom: "B-2-15", reason: "Roommate issues", status: "Pending" },
        { studentName: "Jane Smith", currentRoom: "A-1-10", requestedRoom: "C-3-20", reason: "Need more privacy", status: "Pending" },
        { studentName: "Alex Carter", currentRoom: "C-3-12", requestedRoom: "D-4-1", reason: "Closer to classes", status: "Approved" },
        { studentName: "Emily Brown", currentRoom: "B-2-8", requestedRoom: "A-1-5", reason: "Better view", status: "Rejected" },
    ];

    const rowsPerPage = 5; // Number of rows per page
    let currentPage = 1; // Current page number
    let filteredRequests = requests.filter(req => req.status === "Pending"); // Initial filter for pending requests

    function renderTable(page) {
        const tbody = document.getElementById("requestTableBody");
        tbody.innerHTML = ""; // Clear the table body
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const requestsToShow = filteredRequests.slice(start, end);
        requestsToShow.forEach((request, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td data-label="Student Name">${request.studentName}</td>
                <td data-label="Current Room">${request.currentRoom}</td>
                <td data-label="Requested Room">${request.requestedRoom}</td>
                <td data-label="Reason">${request.reason}</td>
                <td data-label="Status">${request.status}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-approve" data-index="${requests.indexOf(request)}">Approve</button>
                    <button class="btn btn-sm btn-reject" data-index="${requests.indexOf(request)}">Reject</button>
                </td>
            `;
            tbody.appendChild(row);
        });
        renderPagination();
    }

    function renderPagination() {
        const paginationContainer = document.getElementById("pagination");
        paginationContainer.innerHTML = "";
        const totalPages = Math.ceil(filteredRequests.length / rowsPerPage);
        // Previous button
        const prevButton = document.createElement("button");
        prevButton.className = "btn btn-secondary";
        prevButton.innerText = "Previous";
        prevButton.disabled = currentPage === 1;
        prevButton.addEventListener("click", () => {
            currentPage--;
            renderTable(currentPage);
        });
        paginationContainer.appendChild(prevButton);
        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement("button");
            pageButton.className = `btn btn-secondary mx-1 ${i === currentPage ? "active" : ""}`;
            pageButton.innerText = i;
            pageButton.addEventListener("click", () => {
                currentPage = i;
                renderTable(currentPage);
            });
            paginationContainer.appendChild(pageButton);
        }
        // Next button
        const nextButton = document.createElement("button");
        nextButton.className = "btn btn-secondary";
        nextButton.innerText = "Next";
        nextButton.disabled = currentPage === totalPages;
        nextButton.addEventListener("click", () => {
            currentPage++;
            renderTable(currentPage);
        });
        paginationContainer.appendChild(nextButton);
    }

    function handleRequestAction() {
        document.addEventListener("click", (event) => {
            if (event.target.classList.contains("btn-approve")) {
                const index = parseInt(event.target.dataset.index, 10);
                requests[index].status = "Approved";
                applyFilter("Pending"); // Reapply filter to exclude approved requests
            }
            if (event.target.classList.contains("btn-reject")) {
                const index = parseInt(event.target.dataset.index, 10);
                requests[index].status = "Rejected";
                applyFilter("Pending"); // Reapply filter to exclude rejected requests
            }
        });
    }

    function applyFilter(status) {
        currentPage = 1; // Reset to the first page
        if (status === "All") {
            filteredRequests = requests;
        } else {
            filteredRequests = requests.filter(req => req.status === status);
        }
        renderTable(currentPage);
    }

    // Add filter dropdown event listeners (since the dropdown items are inside the dropdown menu "div")
    document.querySelectorAll(".dropdown-item").forEach(item => {
        item.addEventListener("click", (event) => {
            const filter = event.target.getAttribute("data-filter");
            if (filter) {
                applyFilter(filter);
            }
        });
    });

    // Initial render
    renderTable(currentPage);
    handleRequestAction();
});
