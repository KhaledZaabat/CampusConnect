const newsData = [
    { title: "Recruitment announcement – Assistant Professors (MA)", date: "September 26, 2024", description: "The National School of Artificial Intelligence is organizing a recruitment competition for the position of Assistant Professors.", link: "newsDetails.html" },
    { title: "Upcoming AI Conference in December 2024", date: "October 10, 2024", description: "Join us for the latest discussions on advancements in artificial intelligence, hosted by industry leaders.", link: "newsDetails.html" },
    { title: "New AI Research Lab Opening in 2025", date: "October 15, 2024", description: "A state-of-the-art research facility dedicated to AI innovations will be opening next year.", link: "newsDetails.html" },
    { title: "Student Hackathon: Innovating AI Solutions", date: "October 20, 2024", description: "A hackathon designed for students to create innovative AI solutions.", link: "newsDetails.html" },
    { title: "ENSIA Celebrates AI Awareness Week", date: "October 25, 2024", description: "A week-long celebration to raise awareness about AI technologies.", link: "newsDetails.html" },
    { title: "AI and Ethics: A Panel Discussion", date: "November 1, 2024", description: "Explore the ethical implications of AI with top researchers.", link: "newsDetails.html" },
    { title: "Free Online AI Courses Now Available", date: "November 5, 2024", description: "ENSIA launches free online courses in AI for students and professionals.", link: "newsDetails.html" },
    { title: "AI in Healthcare: Breakthrough Innovations", date: "November 10, 2024", description: "Discover how AI is transforming healthcare industries.", link: "newsDetails.html" },
    { title: "ENSIA's AI Summer Camp Applications Open", date: "November 15, 2024", description: "Applications for the AI Summer Camp are now open for students worldwide.", link: "newsDetails.html" },
    { title: "AI in Climate Change Research", date: "November 20, 2024", description: "How AI is being used to address global climate challenges.", link: "newsDetails.html" },
    { title: "ENSIA Robotics Team Wins AI Championship", date: "November 22, 2024", description: "ENSIA's robotics team secures first place in the AI Championship.", link: "newsDetails.html" },
    { title: "ENSIA Alumni Make Waves in AI Startups", date: "November 23, 2024", description: "Prominent alumni launch groundbreaking AI startups.", link: "newsDetails.html" },
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

// Function to handle news editing
function editNews(newsId) {
    alert(`Edit news with ID: ${newsId}`);
    // Add your logic to edit the news here
}

// Function to handle news deletion
function deleteNews(newsId) {
    if (confirm("Are you sure you want to delete this news?")) {
        const index = newsData.findIndex(news => news.id === newsId);
        if (index !== -1) {
            newsData.splice(index, 1);
            goToPage(currentPage); // Refresh current page
        }
    }
}

// Initialize news
renderNews(newsData, currentPage);
