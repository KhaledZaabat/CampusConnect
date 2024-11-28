// Sample data with added `reportedBefore` property
const issues = [
    {
        fullName: "John Doe",
        dormNumber: "C4 23",
        problemType: "Maintenance Issue",
        description: "Leak in the faucet.",
        urgency: "High",
        photo: "assets/img/smaller-Upper-School_Sonner-Payne_Boys-Dorm_Band-Hall_M4196394-scaled.webp",
        status: "pending",
        reportedBefore: false
    },
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

// Render issues dynamically
function renderIssues(filter = 'pending') {
    const container = document.getElementById('issues-container');
    container.innerHTML = ''; // Clear existing content

    const filteredIssues = filter === 'all' ? issues : issues.filter(issue => issue.status === filter);

    filteredIssues.forEach((issue, index) => {
        const card = document.createElement('div');
        card.className = 'card issue-card';
        card.setAttribute('data-status', issue.status);
        card.innerHTML = `
            <div class="card-body position-relative">
                <!-- Badge for reported time -->
                <span class="badge position-absolute top-0 end-0 m-2 bg-${issue.reportedBefore ? 'secondary' : 'success'}">
                    ${issue.reportedBefore ? 'Reported Before' : 'Reported Now'}
                </span>
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
                                <button class="btn btn-done me-2" onclick="updateStatus(${index}, 'approved')">Approve</button>
                                <button class="btn btn-declined" onclick="updateStatus(${index}, 'declined')">Decline</button>
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
    issues[index].status = status;
    renderIssues('pending'); // Re-render with pending filter after updating
    alert(`Status updated to ${status.charAt(0).toUpperCase() + status.slice(1)}!`);
}

// Initial rendering of issues with 'pending' filter
document.addEventListener('DOMContentLoaded', () => renderIssues('pending'));
