<?php
session_start();


// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is authorized
if (!isset($_SESSION['user']) || ($_SESSION['user']['Role'] !== 'Admin' && $_SESSION['user']['Role'] !== 'Housing')) {
    header('Content-Type: application/json');
    die(json_encode(['error' => 'Unauthorized access']));
}

require 'db_connection.php';

// Handle Approve/Reject actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    // Log the incoming request data
    error_log("POST Data: " . print_r($_POST, true));

    // Check if 'action' and 'id' are set in the POST request
    if (!empty($_POST['action']) && !empty($_POST['id'])) {
        $action = $_POST['action'];
        $requestId = intval($_POST['id']);

        // Validate the action
        if ($action !== 'approve' && $action !== 'reject') {
            die(json_encode(['error' => 'Invalid action specified']));
        }

        // Validate the ID
        if ($requestId <= 0) {
            die(json_encode(['error' => 'Invalid request ID']));
        }

        try {
            $status = ($action === 'approve') ? 'Approved' : 'Rejected';

            // Prepare and execute the update
            $stmt = $conn->prepare("UPDATE roomrequest SET status = ? WHERE id = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param('si', $status, $requestId);

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            if ($stmt->affected_rows > 0) {
                $stmt->close();
                echo json_encode(['success' => true, 'message' => "Request successfully {$status}"]);
            } else {
                throw new Exception("No rows were updated");
            }

        } catch (Exception $e) {
            error_log("Error in room request processing: " . $e->getMessage());
            die(json_encode(['error' => 'Database error: ' . $e->getMessage()]));
        }

    } else {
        die(json_encode(['error' => 'Missing required parameters: action and/or id']));
    }
    exit;
}
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Admin - Room Change Requests</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/roomRequest.css">
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
</head>

<body>
    <?php require 'headerAdmin.php'; ?>

    <div class="table-container">
        <div class="dropdown mb-3 text-end">
            <a class="dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fas fa-filter"></i> Filter
            </a>
            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                <li><a class="dropdown-item filterDropdown" data-filter="All" href="#">All Requests</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <h6 class="dropdown-header">Status</h6>
                </li>
                <li><a class="dropdown-item filterDropdown" data-filter="Pending" href="#">Pending</a></li>
                <li><a class="dropdown-item filterDropdown" data-filter="Approved" href="#">Approved</a></li>
                <li><a class="dropdown-item filterDropdown" data-filter="Rejected" href="#">Rejected</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <h6 class="dropdown-header">Request Type</h6>
                </li>
                <li><a class="dropdown-item filterDropdown" data-filter="Book" href="#">Book</a></li>
                <li><a class="dropdown-item filterDropdown" data-filter="Change" href="#">Change</a></li>
            </ul>
        </div>

        <h2>Room Change Requests</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="custom-head">
                    <th>Student Name</th>
                    <th>Current Room</th>
                    <th>Requested Room</th>
                    <th>Reason</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="requestTableBody">
                <!-- Data will be populated here by JavaScript -->
            </tbody>
        </table>

        <div id="pagination" class="d-flex justify-content-center mt-3">
            <!-- Pagination will be populated here by JavaScript -->
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/helperFunctions.js"></script>
    <script>

        document.addEventListener("DOMContentLoaded", () => {
            const rowsPerPage = 8;
            let currentPage = 1;
            let allRequests = [];
            let filteredRequests = [];
            let sortDirection = {};

            // Add click event listeners to table headers for sorting
            function initializeSortingHeaders() {
                const headers = document.querySelectorAll('.custom-head th');
                const sortableColumns = ['studentName', 'currentRoom', 'requestedRoom'];

                headers.forEach((header, index) => {
                    if (index < 3) { // Only first 3 columns are sortable
                        header.style.cursor = 'pointer';
                        header.addEventListener('click', () => {
                            const columnKey = sortableColumns[index];
                            sortTable(columnKey);
                        });
                    }
                });
            }

            // Sorting function
            function sortTable(columnKey) {
                sortDirection[columnKey] = !sortDirection[columnKey];
                const direction = sortDirection[columnKey] ? 1 : -1;

                filteredRequests.sort((a, b) => {
                    const valueA = (a[columnKey] || '').toString().toLowerCase();
                    const valueB = (b[columnKey] || '').toString().toLowerCase();
                    return direction * valueA.localeCompare(valueB);
                });

                renderTable(currentPage);
            }

            // Handle approve/reject actions
            window.handleAction = async function (requestId, action) {
                try {
                    // Show confirmation dialog
                    const result = await Swal.fire({
                        title: 'Are you sure?',
                        text: `Do you want to ${action} this request?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: action === 'approve' ? '#28a745' : '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: action === 'approve' ? 'Yes, approve it!' : 'Yes, reject it!',
                        cancelButtonText: 'Cancel'
                    });

                    // If user confirms
                    if (result.isConfirmed) {
                        const formData = new URLSearchParams();
                        formData.append('action', action);
                        formData.append('id', requestId);

                        const response = await fetch(window.location.href, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Show success message
                            await Swal.fire({
                                title: 'Success!',
                                text: action === 'approve' ?
                                    'The request has been approved.' :
                                    'The request has been rejected.',
                                icon: 'success',
                                confirmButtonColor: '#28a745',
                                timer: 2000,
                                timerProgressBar: true
                            });

                            // Refresh the table
                            fetchRequests();
                        } else {
                            throw new Error(data.error || 'Unknown error occurred');
                        }
                    }
                } catch (error) {
                    console.error('Error details:', error);

                    // Show error message
                    await Swal.fire({
                        title: 'Error!',
                        text: error.message || 'Something went wrong!',
                        icon: 'error',
                        confirmButtonColor: '#dc3545',
                    });
                }
            };
            // Fetch requests from the server
            async function fetchRequests() {
                try {
                    const response = await fetch('LoadData.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'action=fetch'
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    if (Array.isArray(data)) {
                        allRequests = data;
                        filteredRequests = [...allRequests];
                        renderTable(currentPage);
                    } else {
                        throw new Error('Invalid data format received');
                    }
                } catch (error) {
                    console.error('Error fetching requests:', error);
                    alert('Error loading requests: ' + error.message);
                }
            }

            // Apply filters based on status and type
            function applyFilters(filter) {
                filteredRequests = allRequests.filter(request => {
                    if (filter === 'All') return true;
                    if (['Pending', 'Approved', 'Rejected'].includes(filter)) {
                        return request.status === filter;
                    }
                    if (['Book', 'Change'].includes(filter)) {
                        return request.type === filter;
                    }
                    return false;
                });
                currentPage = 1;
                renderTable(currentPage);
            }

            // Search function for room numbers and names
            function searchTable(searchTerm, column) {
                if (!searchTerm) {
                    filteredRequests = [...allRequests];
                } else {
                    searchTerm = searchTerm.toLowerCase();
                    filteredRequests = allRequests.filter(request => {
                        const value = (request[column] || '').toString().toLowerCase();
                        return value.includes(searchTerm);
                    });
                }
                currentPage = 1;
                renderTable(currentPage);
            }

            // Display rows in the table
            function displayRows(requestsToShow, tbody) {
                tbody.innerHTML = '';

                if (requestsToShow.length === 0) {
                    const row = tbody.insertRow();
                    const cell = row.insertCell();
                    cell.colSpan = 8;
                    cell.className = "text-center";
                    cell.textContent = "No requests to show";
                    return;
                }

                requestsToShow.forEach((request) => {
                    const row = tbody.insertRow();
                    row.innerHTML = `
                <td>${escapeHtml(request.studentName)}</td>
                <td>${escapeHtml(request.currentRoom)}</td>
                <td>${escapeHtml(request.requestedRoom)}</td>
                <td>${escapeHtml(request.reason)}</td>
                <td>${escapeHtml(request.description)}</td>
                <td>${escapeHtml(request.status)}</td>
                <td>${escapeHtml(request.type)}</td>
                <td class="text-center">
                    ${request.status.toLowerCase() === "pending" ? `
                        <button onclick="handleAction(${request.id}, 'approve')" class="btn btn-sm btn-success">Approve</button>
                        <button onclick="handleAction(${request.id}, 'reject')" class="btn btn-sm btn-danger">Reject</button>
                    ` : ""}
                </td>
            `;
                });
            }

            // Helper function to escape HTML
            function escapeHtml(unsafe) {
                return unsafe
                    ? unsafe
                        .toString()
                        .replace(/&/g, "&amp;")
                        .replace(/</g, "&lt;")
                        .replace(/>/g, "&gt;")
                        .replace(/"/g, "&quot;")
                        .replace(/'/g, "&#039;")
                    : '';
            }

            // Render the table with pagination
            function renderTable(page) {
                const tbody = document.getElementById("requestTableBody");
                const pagi = document.getElementById("pagination");
                const startIndex = (page - 1) * rowsPerPage;
                const endIndex = startIndex + rowsPerPage;
                const requestsToShow = filteredRequests.slice(startIndex, endIndex);

                displayRows(requestsToShow, tbody);
                renderPagination(page);
            }

            // Render pagination buttons
            function renderPagination(currentPage) {
                const pagi = document.getElementById("pagination");
                pagi.innerHTML = '';
                const totalPages = Math.ceil(filteredRequests.length / rowsPerPage);

                for (let i = 1; i <= totalPages; i++) {
                    const pageButton = document.createElement("button");
                    pageButton.innerText = i;
                    pageButton.className = `btn mx-1 ${i === currentPage ? 'btn-primary' : 'btn-outline-primary'}`;
                    pageButton.addEventListener("click", () => {
                        currentPage = i;
                        renderTable(currentPage);
                    });
                    pagi.appendChild(pageButton);
                }
            }

            // Initialize event listeners
            function initializeEventListeners() {
                // Filter dropdown listeners
                document.querySelectorAll('.filterDropdown').forEach(item => {
                    item.addEventListener('click', event => {
                        event.preventDefault();
                        const filter = event.target.getAttribute("data-filter");
                        applyFilters(filter);
                    });
                });

                // Initialize sorting headers
                initializeSortingHeaders();
            }

            // Initial setup
            initializeEventListeners();
            fetchRequests();
        });
    </script>
</body>

</html>