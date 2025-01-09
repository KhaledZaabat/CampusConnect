document.addEventListener("DOMContentLoaded", () => {
    const requests = [
        { studentName: "John Doe", currentRoom: "A-R-5", requestedRoom: "B-2-15", reason: "Roommate issues", status: "Pending" },
        { studentName: "Jane Smith", currentRoom: "A-1-10", requestedRoom: "C-3-20", reason: "Need more privacy", status: "Pending" },
        { studentName: "Jane Smith", currentRoom: "A-1-10", requestedRoom: "C-3-20", reason: "Need more privacy", status: "Pending" },
        { studentName: "Jane Smith", currentRoom: "A-1-10", requestedRoom: "C-3-20", reason: "Need more privacy", status: "Pending" },
        { studentName: "Jane Smith", currentRoom: "A-1-10", requestedRoom: "C-3-20", reason: "Need more privacy", status: "Pending" },
        { studentName: "Jane Smith", currentRoom: "A-1-10", requestedRoom: "C-3-20", reason: "Need more privacy", status: "Pending" },
        { studentName: "Jane Smith", currentRoom: "A-1-10", requestedRoom: "C-3-20", reason: "Need more privacy", status: "Pending" },
        { studentName: "Jane Smith", currentRoom: "A-1-10", requestedRoom: "C-3-20", reason: "Need more privacy", status: "Pending" },
        { studentName: "Jane Smith", currentRoom: "A-1-10", requestedRoom: "C-3-20", reason: "Need more privacy", status: "Pending" },
        { studentName: "Alex Carter", currentRoom: "C-3-12", requestedRoom: "D-4-1", reason: "Closer to classes", status: "Approved" },
        { studentName: "Emily Brown", currentRoom: "B-2-8", requestedRoom: "A-1-5", reason: "Better view", status: "Rejected" },
        // Add more sample requests...
    ];

    const rowsPerPage = 8;
    let currentPage = 1;
    let filteredRequests = [...requests]; // Clone requests to avoid direct mutation
    let sortDirection = {}; // Keep track of sorting direction for each column

    function renderTable(page) {
        const tbody = document.getElementById("requestTableBody");
        tbody.innerHTML = "";
        const pagi = document.getElementById("pagination");
        pagi.innerHTML= "";
        const startIndex = (page - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const requestsToShow = filteredRequests.slice(startIndex, endIndex);

        displayRows(requestsToShow, tbody);

        addApproveRejectListeners(); // Add event listeners after rendering the table
    }

    function displayRows(requestsToShow, tbody) {
        if (requestsToShow.length === 0) {
            const row = document.createElement("tr");
            const cell = document.createElement("td");
            cell.colSpan = 6;
            cell.className = "text-center";
            cell.innerText = "No requests to show";
            row.appendChild(cell);
            tbody.appendChild(row);
        } else {
            requestsToShow.forEach((request) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td data-label="Student Name">${request.studentName}</td>
                    <td data-label="Current Room">${request.currentRoom}</td>
                    <td data-label="Requested Room">${request.requestedRoom}</td>
                    <td data-label="Reason">${request.reason}</td>
                    <td data-label="Status">${request.status}</td>
                    <td class="text-center">
                        ${request.status === "Pending" ? `
                            <button class="btn btn-sm btn-approve" data-index="${requests.indexOf(request)}">Approve</button>
                            <button class="btn btn-sm btn-reject" data-index="${requests.indexOf(request)}">Reject</button>
                        ` : ""}
                    </td>
                `;
                tbody.appendChild(row);
                renderPagination();
            });
        }
    }

    function renderPagination() {
        const paginationContainer = document.getElementById("pagination");
        paginationContainer.innerHTML = ""; // Clear the container

        const totalPages = Math.ceil(filteredRequests.length / rowsPerPage);

        // Create the nav element
        const nav = document.createElement("nav");
        nav.setAttribute("aria-label", "Page navigation example");

        // Create the ul element
        const ul = document.createElement("ul");
        ul.className = "pagination justify-content-center";

        // Previous button
        const prevLi = document.createElement("li");
        prevLi.className = `page-item ${currentPage === 1 ? "disabled" : ""}`;
        const prevLink = document.createElement("a");
        prevLink.className = "page-link";
        prevLink.href = "#";
        prevLink.setAttribute("aria-label", "Previous");
        prevLink.innerHTML = `<span aria-hidden="true">&laquo;</span>`;
        prevLink.addEventListener("click", (event) => {
            event.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                renderTable(currentPage);
            }
        });
        prevLi.appendChild(prevLink);
        ul.appendChild(prevLi);

        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement("li");
            li.className = `page-item ${i === currentPage ? "active" : ""}`;
            const a = document.createElement("a");
            a.className = "page-link";
            a.href = "#";
            a.innerText = i;
            a.addEventListener("click", (event) => {
                event.preventDefault();
                currentPage = i;
                renderTable(currentPage);
            });
            li.appendChild(a);
            ul.appendChild(li);
        }

        // Next button
        const nextLi = document.createElement("li");
        nextLi.className = `page-item ${currentPage === totalPages ? "disabled" : ""}`;
        const nextLink = document.createElement("a");
        nextLink.className = "page-link";
        nextLink.href = "#";
        nextLink.setAttribute("aria-label", "Next");
        nextLink.innerHTML = `<span aria-hidden="true">&raquo;</span>`;
        nextLink.addEventListener("click", (event) => {
            event.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                renderTable(currentPage);
            }
        });
        nextLi.appendChild(nextLink);
        ul.appendChild(nextLi);

        // Append the ul to the nav and then to the container
        nav.appendChild(ul);
        paginationContainer.appendChild(nav);
    }

    function addApproveRejectListeners() {
        document.querySelectorAll(".btn-approve").forEach(button => {
            button.addEventListener("click", (event) => {
                const index = event.target.getAttribute("data-index");
                requests[index].status = "Approved";
                renderTable(currentPage); // Reapply filter to exclude rejected requests
            });
        });
        document.querySelectorAll(".btn-reject").forEach(button => {
            button.addEventListener("click", (event) => {
                const index = event.target.getAttribute("data-index");
                requests[index].status = "Rejected";
                renderTable(currentPage); // Reapply filter to exclude rejected requests
            });
        });
    }

    function sortTable(columnKey) {
        sortDirection[columnKey] = !sortDirection[columnKey]; // Toggle sorting direction
        const direction = sortDirection[columnKey] ? 1 : -1;
        filteredRequests.sort((a, b) => {
            const valueA = a[columnKey].toString().toLowerCase();
            const valueB = b[columnKey].toString().toLowerCase();
            if (valueA < valueB) return -1 * direction;
            if (valueA > valueB) return 1 * direction;
            return 0;
        });
        renderTable(currentPage);
    }

    function applyFilter(status) {
        currentPage = 1;
        if (status === "All") {
            filteredRequests = [...requests];
        } else {
            filteredRequests = requests.filter(req => req.status === status);
        }
        renderTable(currentPage);
    }

    // Add event listeners to table headers
    document.querySelectorAll("#table-head").forEach((header, index) => {
        const columnKeys = ["studentName", "currentRoom", "requestedRoom", "reason", "status"]; // Map headers to keys
        if (index < columnKeys.length) {
            header.addEventListener("click", () => sortTable(columnKeys[index]));
        }
    });

    document.querySelectorAll(".dropdown-item").forEach(item => {
        item.addEventListener("click", (event) => {
            const filter = event.target.getAttribute("data-filter");
            if (filter) {
                applyFilter(filter);
            }
        });
    });

    renderTable(currentPage);
});
