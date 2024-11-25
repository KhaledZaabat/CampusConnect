document.addEventListener('DOMContentLoaded', () => {
    const posts = [];
    const submit_btn = document.getElementById("submit_btn");
    const postsPerPage = 3; // Number of posts per page
    let currentPage = 1; // Track the current page
    let activeFilter = "All"; // Track the active filter

    // Event listener for dropdown filter
    document.querySelectorAll(".filter").forEach((filter) => {
        filter.addEventListener("click", (event) => {
            event.preventDefault();
            const selectedFilter = event.target.textContent.trim();
            if (selectedFilter === "Missing Listings") {
                activeFilter = "Missing";
            } else if (selectedFilter === "Found Listings") {
                activeFilter = "Found";
            } else {
                activeFilter = "All";
            }
            renderPosts(1); // Re-render posts based on the selected filter
        });
    });
    

    submit_btn.addEventListener('click', (event) => {
        event.preventDefault();
    
        // Get input values
        const title = document.getElementById("i_title");
        const description = document.getElementById("i_description");
        const imgInput = document.getElementById("file");
        const Found = document.getElementById("found");
        const Missing = document.getElementById("missing");
        const imageFile = imgInput.files[0];
        const imageUrl = imageFile ? URL.createObjectURL(imageFile) : "assets/img/no-img.png";
    
        // Validate required fields
        if (!title.value || !description.value) {
            alert("Please fill in all required fields.");
            return;
        }
    
        // Validate title length
        if (title.value.length > 80) {
            alert("Title is too long!");
            return;
        }
    
        // Validate description length
        if (description.value.length > 400) {
            alert("Description is too long!");
            return;
        }
    
        // Check if a radio button (Missing or Found) is selected
        if (!Found.checked && !Missing.checked) {
            alert("Please select the type of listing.");
            return;
        }
    

        // Create new submission object
        const newSubmission = {
            title: title.value,
            description: description.value,
            image: imageUrl,
            listingType: Found.checked ? "Found" : "Missing",
            comments: [], // Initialize with an empty comments array
            user: "me",
            currentCommentPage: 1,
        };

        posts.push(newSubmission);

        // Reset the form fields
        title.value = "";
        description.value = "";
        Found.checked = false;
        Missing.checked = false;
        resetImageUpload();
        renderPosts(currentPage);
    });

    function renderPosts(page) {
        const postsContainer = document.getElementById("blog_posts");

        // Filter posts based on activeFilter
        const filteredPosts = activeFilter === "All" ? posts : posts.filter(post => post.listingType === activeFilter);

        const startIndex = (page - 1) * postsPerPage;
        const endIndex = startIndex + postsPerPage;
        const postsToDisplay = filteredPosts.slice(startIndex, endIndex);

        postsContainer.innerHTML = ""; // Clear container before rendering

        if (postsToDisplay.length === 0) {
            postsContainer.innerHTML = `
                <div class="no-posts-message text-center py-5">
                    <h3>No posts to display</h3>
                    <p>It seems there are no posts available at the moment. Please check back later!</p>
                    <img src="https://www.exploreworld.com/_next/image?url=%2Fimages%2Fno-data.gif&w=1080&q=75" alt="No Data"> 
                </div>
            `;
            return;
        }

        postsToDisplay.forEach((submission) => renderPost(submission));

        renderPaginationGeneral({
            containerId: "pagination",
            currentPage: page,
            totalItems: filteredPosts.length,
            itemsPerPage: postsPerPage,
            onPageChange: (newPage) => {
                currentPage = newPage;
                renderPosts(currentPage);
            }
        });
    }

    function renderPost(submissionData) {
        const postsContainer = document.getElementById("blog_posts");

        const postElement = document.createElement("div");
        postElement.className = "col-md-6 col-lg-4 mt-5";

        const postContent = `
        <div class="post-c blog-grid">
            <div class="blog-grid-img position-relative">
                <img alt="img" src="${submissionData.image}" class="listing-img img-fluid">
            </div>
            <div class="blog-grid-text p-4">
                <div class="row">
                    <h3 class="h5 col-8 mb-3">${submissionData.title}</h3>
                    <div class="col-4 text-end">
                        <a href="#" class="Edit me-2"><i class="fas fa-edit"></i></a>
                        <a href="#" class="Delete"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
                <p class="display-30">${submissionData.description}</p>
                <div class="meta meta-style2">
                    <ul>
                        <li><i class="fas fa-calendar-alt icon-blue"></i> 10 Jul, 2022</li>
                        <li><a href="#!"><i class="fas fa-user icon-blue"></i> User</a></li>  
                        <li class="comments-toggle"><i class="fas fa-comments icon-blue"></i> ${submissionData.comments.length}</li>
                    </ul>
                </div>
                <!-- Hidden Comment Section -->
                <div class="comment-section mt-4" style="display: none;">
                    <form class="nav nav-item w-100 position-relative comment-form">
                        <textarea data-autoresize class="text-field pe-5 bg-light" rows="1" placeholder="Add a comment..."></textarea>
                        <button class="comments bg-transparent px-3 position-absolute top-50 end-0 translate-middle-y border-0" type="submit">
                            <i class="fa-regular fa-paper-plane"></i>
                        </button>
                    </form>
                    <!-- Comments Section -->
                    <div class="comments-container mt-3"></div>
                    <div class="comments-pagination"></div>
                </div>
            </div>
        </div>
        `;

        postElement.innerHTML = postContent;
        postsContainer.appendChild(postElement);

        const commentSection = postElement.querySelector('.comment-section');
        const commentsToggle = postElement.querySelector('.comments-toggle');
        const commentForm = postElement.querySelector('.comment-form');
        const commentsContainer = postElement.querySelector('.comments-container');
        const commentsPagination = postElement.querySelector('.comments-pagination');

        // Toggle comments section visibility
        commentsToggle.addEventListener('click', () => {
            commentSection.style.display = commentSection.style.display === 'none' ? 'block' : 'none';
            loadComments(submissionData, commentsContainer, commentsPagination);
        });

        // Add comment form functionality
        commentForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const textarea = commentForm.querySelector('textarea');
            const commentText = textarea.value.trim();

            if (commentText) {
                const newComment = {
                    username: 'User',
                    date: new Date().toLocaleString(),
                    commentText
                };
                submissionData.comments.push(newComment);
                textarea.value = "";
                submissionData.currentCommentPage = 1; // Reset to page 1 after a new comment
                loadComments(submissionData, commentsContainer, commentsPagination);
            }
        });
    }

    renderPosts(currentPage);
});
