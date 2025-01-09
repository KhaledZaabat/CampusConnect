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
                <img src="https://www.exploreworld.com/_next/image?url=%2Fimages%2Fno-data.gif&w=1080&q=75" alt="No Issues">
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