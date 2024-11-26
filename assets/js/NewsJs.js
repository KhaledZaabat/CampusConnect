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

function renderNews(newsItems, page = 1) {
    const startIndex = (page - 1) * maxItemsPerPage;
    const endIndex = startIndex + maxItemsPerPage;
    const itemsToDisplay = newsItems.slice(startIndex, endIndex);

    const container = document.getElementById("news-container");
    container.innerHTML = itemsToDisplay.length
        ? itemsToDisplay.map(news => `
            <div class="news-item">
                <div class="news-item-content">
                    <h3 class="news-item-title">
                        <a href="${news.link}" class="news-item-link">${news.title}</a>
                    </h3>
                    <p class="news-item-date">${news.date}</p>
                    <p class="news-item-description">${news.description.substring(0, 100)}...</p>
                </div>
            </div>
        `).join("")
        : "<p class='news-no-results'>No news found. Please refine your search.</p>";

    renderPagination(newsItems, page);
}

function renderPagination(newsItems, currentPage) {
    const totalPages = Math.ceil(newsItems.length / maxItemsPerPage);
    const paginationContainer = document.getElementById("pagination-controls");

    paginationContainer.innerHTML = totalPages > 1
        ? Array.from({ length: totalPages }, (_, i) => `
            <button class="pagination-btn ${i + 1 === currentPage ? "active" : ""}" onclick="goToPage(${i + 1})" aria-label="Go to page ${i + 1}">${i + 1}</button>
        `).join("")
        : "";
}

function goToPage(page) {
    currentPage = page;
    const searchTerm = document.getElementById("search-input").value.toLowerCase();
    const filteredNews = searchTerm
        ? newsData.filter(news => news.title.toLowerCase().includes(searchTerm))
        : newsData;

    renderNews(filteredNews, currentPage);
}

document.getElementById("search-input").addEventListener("input", () => {
    const searchTerm = document.getElementById("search-input").value.toLowerCase();
    const filteredNews = searchTerm
        ? newsData.filter(news => news.title.toLowerCase().includes(searchTerm))
        : newsData;

    currentPage = 1;
    renderNews(filteredNews, currentPage);
});

document.getElementById("search-input").addEventListener("keydown", (event) => {
    if (event.key === "Enter") {
        const searchTerm = document.getElementById("search-input").value.toLowerCase();
        const filteredNews = searchTerm
            ? newsData.filter(news => news.title.toLowerCase().includes(searchTerm))
            : newsData;

        currentPage = 1;
        renderNews(filteredNews, currentPage);
    }
});

renderNews(newsData, currentPage);
