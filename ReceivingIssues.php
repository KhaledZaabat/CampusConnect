<?php
session_start();
require "db_connection.php";

// Check if the user is an Admin or Maintenance employee
if ($_SESSION['user']['Role'] !== 'Admin' && $_SESSION['user']['Role'] !== 'Maintenance') {
    die("Only Admins and Maintenance Employees can access this page.");
}


// Handle status update (approve/decline)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['issueId']) && isset($_POST['status'])) {
    $issueId = $conn->real_escape_string($_POST['issueId']);
    $status = $conn->real_escape_string($_POST['status']);

    // Update the status in the database
    $updateQuery = "UPDATE issue SET status = '$status' WHERE Id = '$issueId'";
    if ($conn->query($updateQuery) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
    exit; // Stop further execution
}

// Fetch issues from the database
$query = "
  SELECT 
        i.Id, 
        i.description, 
        i.type AS problemType, 
        i.urgency, 
        i.img_path AS photo, 
        i.status, 
        i.duplicated AS reportedBefore,
        CONCAT(s.firstName, ' ', s.lastName) AS fullName,
        CONCAT(b.blockName, f.FloorNumber, r.RoomNumber) AS dormNumber
    FROM 
        issue i
    JOIN 
        student s ON i.studentId = s.Id
    JOIN 
        room r ON s.roomId = r.Id
    JOIN 
        floor f ON r.FloorID = f.Id
    JOIN 
        block b ON f.BlockID = b.Id
";

$result = $conn->query($query);

$issues = [];
if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        $issues[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Managing Issues</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/RecivingIssues.css">
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <script src="assets/js/navbar.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
    <?php require 'headerAdmin.php'; ?>
    <main>
        <div class="container mt-5">
            <h1 class="text-center">Received Issue Reports</h1>
            <div class="mb-3 text-end">
                <button class="btn btn-filter" data-filter="approved" onclick="filterIssues('approved')">Show
                    Approved</button>

                <button class="btn btn-filter" data-filter="declined" onclick="filterIssues('declined')">Show
                    Declined</button>
                <button class="btn btn-filter" data-filter="pending" onclick="filterIssues('pending')">Show
                    Pending</button>
            </div>
            <div class="issues-container mt-3" id="issues-container">
                <!-- Cards will be dynamically generated here -->
            </div>
        </div>
    </main>

    <div class="footer-spacing"></div>
    <?php include 'footer.php' ?>

    <script>
        // Pass PHP array to JavaScript
        const issues = <?php echo json_encode($issues); ?>;
    </script>
    <script src="assets/js/RevivingIssues.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <script>
        function renderIssues(filter = 'pending') {
            const container = document.getElementById('issues-container');
            container.innerHTML = ''; // Clear existing content

            const filteredIssues = issues.filter(issue => issue.status === filter);

            if (filteredIssues.length === 0) {
                container.innerHTML = `
            <div class="no-issues-container">
                <img src="uploads\\IssuesPhotos\\NoResult.gif" alt="No Issues">
                <h3>No Issues to display</h3>
                <p>It seems there are no Issues available at the moment. Please check back later!</p>
            </div>`;
                return;
            }

            filteredIssues.forEach(issue => {
                const card = document.createElement('div');
                card.className = 'card issue-card';
                card.setAttribute('data-status', issue.status);
                card.innerHTML = `
            <div class="card-body position-relative">
                ${issue.status === 'pending'
                        ? `<span class="badge position-absolute top-0 end-0 m-2 bg-${issue.reportedBefore ? 'secondary' : 'success'}">
                               ${issue.reportedBefore ? 'Reported Before' : 'Reported Now'}
                           </span>`
                        : ''
                    }
                <h5 class="card-title">Issue Details</h5>
                <p><strong>Full Name:</strong> ${issue.fullName}</p>
                <p><strong>Dorm Number:</strong> ${issue.dormNumber}</p>
                <p><strong>Problem Type:</strong> ${issue.problemType}</p>
                <p><strong>Description:</strong> ${issue.description}</p>
                <p><strong>Urgency Level:</strong> ${issue.urgency}</p>
                <div class="mb-3">
                    <h6>Attached Photo:</h6>
                    <img src="${issue.photo}" alt="Issue photo" class="img-fluid rounded">
                </div>
                <div class="d-flex justify-content-end">
                    ${issue.status === 'pending'
                        ? `<button class="btn btn-done me-2" onclick="updateStatus(${issue.Id}, 'approved')">Approve</button>
                               <button class="btn btn-declined" onclick="updateStatus(${issue.Id}, 'declined')">Decline</button>`
                        : `<button class="btn btn-${issue.status === 'approved' ? 'done' : 'declined'}">
                                 ${issue.status.charAt(0).toUpperCase() + issue.status.slice(1)}
                               </button>`
                    }
                </div>
            </div>`;
                container.appendChild(card);
            });
        }

        // Highlight the active filter button
        function setActiveFilterButton(filter) {
            document.querySelectorAll('.btn-filter').forEach(button => {
                button.classList.remove('active');
            });
            document.querySelector(`.btn-filter[data-filter="${filter}"]`)?.classList.add('active');
        }

        // Update status of an issue
        function updateStatus(issueId, status) {
            let action = status === "declined" ? "decline" : "approve";
            Swal.fire({
                title: `Are you sure you want to ${action} this issue?`,
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: `Yes, ${action} it!`
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("ReceivingIssues.php", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `issueId=${issueId}&status=${status}`,
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: `${status.charAt(0).toUpperCase() + status.slice(1)}!`,
                                    text: `The issue has been ${status}.`,
                                    icon: "success"
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: `Failed to update the issue status: ${data.error}`,
                                    icon: "error"
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                title: "Error!",
                                text: `An error occurred: ${error.message}`,
                                icon: "error"
                            });
                        });
                }
            });
        }

        // Filter issues
        function filterIssues(status) {
            setActiveFilterButton(status);
            renderIssues(status);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', () => {
            setActiveFilterButton('pending');
            renderIssues('pending');
        });
    </script>
</body>


</html>