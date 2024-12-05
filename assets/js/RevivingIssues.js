// Sample data with added `reportedBefore` property
const issues = [

    {
        fullName: "John Doe",
        dormNumber: "C4 23",
        problemType: "Maintenance Issue",
        description: "Leak in the faucet.",
        urgency: "High",
        photo: "assets/img/None_Photo.jpg",
        status: "pending",
        reportedBefore: false
    },
    {
        fullName: "John Doe",
        dormNumber: "C4 23",
        problemType: "Maintenance Issue",
        description: "Leak in the faucet.",
        urgency: "High",
        photo: "assets/img/smaller-Upper-School_Sonner-Payne_Boys-Dorm_Band-Hall_M4196394-scaled.webp",
        status: "pending",
        reportedBefore: true
    },
    {
        fullName: "John Doe",
        dormNumber: "C4 23",
        problemType: "Maintenance Issue",
        description: "Leak in the faucet.",
        urgency: "High",
        photo: "assets/img/smaller-Upper-School_Sonner-Payne_Boys-Dorm_Band-Hall_M4196394-scaled.webp",
        status: "pending",
        reportedBefore: true
    },
    {
        fullName: "John Doe",
        dormNumber: "C4 23",
        problemType: "Maintenance Issue",
        description: "Leak in the faucet.",
        urgency: "High",
        photo: "assets/img/smaller-Upper-School_Sonner-Payne_Boys-Dorm_Band-Hall_M4196394-scaled.webp",
        status: "pending",
        reportedBefore: true
    },
    {
        fullName: "John Doe",
        dormNumber: "C4 23",
        problemType: "Maintenance Issue",
        description: "Leak in the faucet.",
        urgency: "High",
        photo: "assets/img/smaller-Upper-School_Sonner-Payne_Boys-Dorm_Band-Hall_M4196394-scaled.webp",
        status: "pending",
        reportedBefore: true
    },
    {
        fullName: "Jane Smith",
        dormNumber: "B2 12",
        problemType: "Electrical Issue",
        description: "Light not working.",
        urgency: "Medium",
        photo: "assets/img/smaller-Upper-School_Sonner-Payne_Boys-Dorm_Band-Hall_M4196394-scaled.webp",
        status: "approved",
        reportedBefore: true
    },
    {
        fullName: "Mark Brown",
        dormNumber: "D3 45",
        problemType: "Plumbing Issue",
        description: "Clogged toilet.",
        urgency: "Low",
        photo: "assets/img/smaller-Upper-School_Sonner-Payne_Boys-Dorm_Band-Hall_M4196394-scaled.webp",
        status: "declined",
        reportedBefore: true
    }
];
function renderIssues(filter = 'pending') {
    const container = document.getElementById('issues-container');
    container.innerHTML = ''; // Clear existing content

    const filteredIssues = issues.filter(issue => issue.status === filter);

    if (filteredIssues.length === 0) {
        // Show placeholder message with GIF if no issues match the filter
        container.innerHTML = `
          <div class="no-issues-container">
    <img src="https://www.exploreworld.com/_next/image?url=%2Fimages%2Fno-data.gif&w=1080&q=75" alt="No Issues">
    <h3>No Issues to display</h3>
    <p>It seems there are no Issues available at the moment. Please check back later!</p>
</div>
        `;
        return;
    }

    filteredIssues.forEach((issue, index) => {
        const card = document.createElement('div');
        card.className = 'card issue-card';
        card.setAttribute('data-status', issue.status);
        card.innerHTML = `
        <div class="card-body position-relative">
            <!-- Badge for reported time -->
            ${
                issue.status === 'pending'
                    ? `
                        <span class="badge position-absolute top-0 end-0 m-2 bg-${issue.reportedBefore ? 'secondary' : 'success'}">
                            ${issue.reportedBefore ? 'Reported Before' : 'Reported Now'}
                        </span>
                    `
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
                ${
                    issue.status === 'pending'
                        ? `
                            <button class="btn btn-done me-2" onclick="updateStatus(${issues.indexOf(issue)}, 'approved')">Approve</button>
                            <button class="btn btn-declined" onclick="updateStatus(${issues.indexOf(issue)}, 'declined')">Decline</button>
                          `
                        : `
                            <button class="btn btn-${issue.status === 'approved' ? 'done' : 'declined'}">
                                ${issue.status.charAt(0).toUpperCase() + issue.status.slice(1)}
                            </button>
                          `
                }
            </div>
        </div>
    `;

        container.appendChild(card);
    });
}

// Function to filter issues dynamically
function filterIssues(status) {
    renderIssues(status);
}

// Update status of an issue and re-render
function updateStatus(index, status) {
    let action;
    if(status =="declined")
        action="decline";
    else
    action="approve";
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
            issues[index].status = status; // Update status in the array

            Swal.fire({
                title: `${status.charAt(0).toUpperCase() + status.slice(1)}!`,
                text: `The issue has been ${status}.`,
                icon: "success"
            });

            renderIssues('pending'); // Re-render the Pending section
        }
    });
}

// Initial rendering of issues with 'pending' filter
document.addEventListener('DOMContentLoaded', () => renderIssues('pending'));
