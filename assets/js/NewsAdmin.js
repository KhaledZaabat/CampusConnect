const newsData = [
    { id: 1, title: "Recruitment announcement – Assistant Professors (MA)", date: "2024-04-11", description: "The National School of Artificial Intelligence is organizing a recruitment competition for the position of Assistant Professors.", link: "newsDetails.html" },
    { id: 2, title: "Upcoming AI Conference in December 2024", date: "2023-04-11", description: "Join us for the latest discussions on advancements in artificial intelligence, hosted by industry leaders.", link: "newsDetails.html" },
    { id: 3, title: "New AI Research Lab Opening in 2025", date: "2024-04-11", description: "A state-of-the-art research facility dedicated to AI innovations will be opening next year.", link: "newsDetails.html" },
    { id: 4, title: "Student Hackathon: Innovating AI Solutions", date: "2024-04-11", description: "A hackathon designed for students to create innovative AI solutions.", link: "newsDetails.html" },
    { id: 5, title: "ENSIA Celebrates AI Awareness Week", date: "October 25, 2024", description: "A week-long celebration to raise awareness about AI technologies.", link: "newsDetails.html" },
    { id: 6, title: "AI and Ethics: A Panel Discussion", date: "November 1, 2024", description: "Explore the ethical implications of AI with top researchers.", link: "newsDetails.html" },
    { id: 7, title: "Free Online AI Courses Now Available", date: "November 5, 2024", description: "ENSIA launches free online courses in AI for students and professionals.", link: "newsDetails.html" },
    { id: 8, title: "AI in Healthcare: Breakthrough Innovations", date: "November 10, 2024", description: "Discover how AI is transforming healthcare industries.", link: "newsDetails.html" },
    { id: 9, title: "ENSIA's AI Summer Camp Applications Open", date: "November 15, 2024", description: "Applications for the AI Summer Camp are now open for students worldwide.", link: "newsDetails.html" },
    { id: 10, title: "AI in Climate Change Research", date: "November 20, 2024", description: "How AI is being used to address global climate challenges.", link: "newsDetails.html" },
    { id: 11, title: "ENSIA Robotics Team Wins AI Championship", date: "November 22, 2024", description: "ENSIA's robotics team secures first place in the AI Championship.", link: "newsDetails.html" },
    { id: 12, title: "ENSIA Alumni Make Waves in AI Startups", date: "November 23, 2024", description: "Prominent alumni launch groundbreaking AI startups.", link: "newsDetails.html" },
];

const maxItemsPerPage = 10;
let currentPage = 1;

// Function to render news items
function renderNews(newsItems, page = 1) {
    const startIndex = (page - 1) * maxItemsPerPage;
    const endIndex = startIndex + maxItemsPerPage;
    const itemsToDisplay = newsItems.slice(startIndex, endIndex);

    const container = document.getElementById("news-container");
    container.innerHTML = itemsToDisplay.map((news) => `
        <div class="news-item">
            <h3><a href="${news.link}" class="text-primary">${news.title}</a></h3>
            <p class="date">${news.date}</p>
            <p>${news.description.substring(0, 100)}...</p>
            <div class="edit-delete-container">
                <span class="Edit" onclick="editNews(${news.id})">Edit</span> | 
                <span class="Delete" onclick="deleteNews(${news.id})">Delete</span>
            </div>
        </div>
    `).join("");

    renderPagination(newsItems, page);
}

// Function to render pagination
function renderPagination(newsItems, currentPage) {
    const totalPages = Math.ceil(newsItems.length / maxItemsPerPage);
    const paginationContainer = document.getElementById("pagination-controls");

    paginationContainer.innerHTML = Array.from({ length: totalPages }, (_, i) => `
        <button class="btn ${i + 1 === currentPage ? "btn-primary" : "btn-outline-primary"}" onclick="goToPage(${i + 1})">${i + 1}</button>
    `).join("");
}

// Go to a specific page
function goToPage(page) {
    currentPage = page;
    const searchTerm = document.getElementById("search-input").value.toLowerCase();
    const filteredNews = searchTerm
        ? newsData.filter(news => news.title.toLowerCase().includes(searchTerm))
        : newsData;

    renderNews(filteredNews, currentPage);
}

// Search functionality
document.getElementById("search-input").addEventListener("input", () => {
    const searchTerm = document.getElementById("search-input").value.toLowerCase();
    const filteredNews = searchTerm
        ? newsData.filter(news => news.title.toLowerCase().includes(searchTerm))
        : newsData;

    currentPage = 1;
    renderNews(filteredNews, currentPage);
});

function editNews(newsId) {
    const newsItem = newsData.find(news => news.id === newsId);
    if (newsItem) {
        Swal.fire({
            title: "Edit News",
            html: `
                <div style="text-align: left; padding: 20px; max-width: 80%; display: flex; flex-direction: column; gap: 20px;">
                    <div style="display: flex; align-items: center; gap: 20px;">
                        <label for="edit-title" style="flex: 1; text-align: left; white-space: nowrap;"><strong>Title:</strong></label>
                        <input id="edit-title" class="swal2-input" value="${newsItem.title}" maxlength="70" style="flex: 3; padding: 8px; display: block;">
                    </div>
                    <div style="display: flex; align-items: center; gap: 20px;">
                        <label for="edit-date" style="flex: 1; text-align: left; white-space: nowrap;"><strong>Date:</strong></label>
                        <input id="edit-date" class="swal2-input" type="date" value="${newsItem.date}" style="flex: 3; padding: 8px; display: block;">
                    </div>
                    <div style="display: flex; align-items: flex-start; gap: 20px;">
                        <label for="edit-description" style="flex: 1; text-align: left; white-space: nowrap; margin-top: 8px;"><strong>Description:</strong></label>
                        <button class="swal2-confirm" onclick="editDescriptionModal(${newsItem.id})">Edit Description</button>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: "Save Changes",
            cancelButtonText: "Cancel",
            preConfirm: () => {
                const editedTitle = document.getElementById("edit-title").value.trim();
                const editedDate = document.getElementById("edit-date").value;

                if (!editedTitle || !editedDate) {
                    Swal.showValidationMessage("All fields are required.");
                }

                return { title: editedTitle, date: editedDate };
            }
        }).then((editResult) => {
            if (editResult.isConfirmed) {
                const { title, date } = editResult.value;
                newsItem.title = title;
                newsItem.date = date;

                goToPage(currentPage);

                Swal.fire({
                    title: "Updated!",
                    text: `The news titled "${title}" has been successfully updated.`,
                    icon: "success"
                });
            }
        });
    }
}

function editDescriptionModal(newsId) {
    const newsItem = newsData.find(news => news.id === newsId);
    if (newsItem) {
        Swal.fire({
            title: "Edit Description",
            html: `
                <textarea id="large-description" style="width: 100%; height: 300px; padding: 10px; resize: none;">${newsItem.description}</textarea>
            `,
            showCancelButton: true,
            confirmButtonText: "Save Description",
            cancelButtonText: "Cancel",
            preConfirm: () => {
                const editedDescription = document.getElementById("large-description").value.trim();
                if (!editedDescription) {
                    Swal.showValidationMessage("Description cannot be empty.");
                }
                return editedDescription;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                newsItem.description = result.value;
                goToPage(currentPage);
                Swal.fire({
                    title: "Updated!",
                    text: "The description has been successfully updated.",
                    icon: "success"
                });
            }
        });
    }
}

function deleteNews(newsId) {
    const index = newsData.findIndex(news => news.id === newsId);
    if (index !== -1) {
        const newsTitle = newsData[index].title; 

        Swal.fire({
            title: "Are you sure?",
            text: `You are about to delete the news: "${newsTitle}". This action cannot be undone.`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Delete it!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                newsData.splice(index, 1);
                goToPage(currentPage);
                Swal.fire({
                    title: "Deleted!",
                    text: `The news titled "${newsTitle}" has been successfully deleted.`,
                    icon: "success"
                });
            }
        });
    }
}

// Initial rendering
renderNews(newsData);
