document.addEventListener('DOMContentLoaded', () => {
    const submissions = [];
    const submit_btn = document.getElementById("submit_btn");
    const postsPerPage = 3; // Number of posts per page
    let currentPage = 1; // Track the current page

    submit_btn.addEventListener('click', (event) => {
        event.preventDefault();

        // Get input values
        const title = document.getElementById("i_title");
        const description = document.getElementById("i_description");
        const imgInput = document.getElementById("file");
        const Found = document.getElementById("found");
        const Missing = document.getElementById("missing");
        const imageFile = imgInput.files[0];
        const imageUrl = imageFile ? URL.createObjectURL(imageFile) : null;

        // Validate required fields
        if (!title.value || !description.value) {
            alert("Please fill in all required fields.");
            return;
        }

        // Create new submission object
        const newSubmission = {
            title: title.value,
            description: description.value,
            image: imageUrl,
            listingType: Found.checked ? "Found" : "Missing",
            comments: [], // Initialize with an empty comments array
            currentCommentPage: 1 // Add pagination state for comments
        };

        submissions.push(newSubmission);

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
        const startIndex = (page - 1) * postsPerPage;
        const endIndex = startIndex + postsPerPage;
        const postsToDisplay = submissions.slice(startIndex, endIndex);
    
        postsContainer.innerHTML = ""; // Clear container before rendering
    
        // Check if there are no posts to display
        if (postsToDisplay.length === 0) {
            postsContainer.innerHTML = `
                <div class="no-posts-message text-center py-5">
                    <h3>No posts to display</h3>
                    <div class="row">
                        <p>It seems there are no posts available at the moment. Please check back later!</p>
                        <img src="https://www.exploreworld.com/_next/image?url=%2Fimages%2Fno-data.gif&w=1080&q=75" alt="No Data"> 
                    </div>
                </div>
            `;
            renderPagination(); // Still render pagination (optional)
            return; // Exit function early
        }
    
        // Render posts if available
        postsToDisplay.forEach(submission => renderPost(submission));
        renderPagination();
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
    

    function loadComments(submissionData, commentsContainer, commentsPagination) {
        const commentsPerPage = 2; // Display 2 comments per page
        const startIndex = (submissionData.currentCommentPage - 1) * commentsPerPage;
        const endIndex = startIndex + commentsPerPage;
        const commentsToDisplay = submissionData.comments.slice(startIndex, endIndex);

        commentsContainer.innerHTML = commentsToDisplay.map(comment => `
            <div class="border-visible bg-light p-3 rounded mb-2">
                <div class="d-flex justify-content-between">
                    <h6 class="mb-1"><a href="#!">${comment.username}</a></h6>
                    <small class="ms-2">${comment.date}</small>
                </div>
                <p class="small mb-0">${comment.commentText}</p>
            </div>
        `).join('');

        // Render comment pagination
        commentsPagination.innerHTML = '';
        const totalCommentPages = Math.ceil(submissionData.comments.length / commentsPerPage);

        if (submissionData.currentCommentPage > 1) {
            const prevButton = document.createElement('button');
            prevButton.className = 'btn btn-sm btn-secondary me-1';
            prevButton.innerText = 'Previous';
            prevButton.addEventListener('click', () => {
                submissionData.currentCommentPage--;
                loadComments(submissionData, commentsContainer, commentsPagination);
            });
            commentsPagination.appendChild(prevButton);
        }

        if (submissionData.currentCommentPage < totalCommentPages) {
            const nextButton = document.createElement('button');
            nextButton.className = 'btn btn-sm btn-secondary';
            nextButton.innerText = 'Next';
            nextButton.addEventListener('click', () => {
                submissionData.currentCommentPage++;
                loadComments(submissionData, commentsContainer, commentsPagination);
            });
            commentsPagination.appendChild(nextButton);
        }
    }

    function renderPagination() {
        const paginationContainer = document.getElementById("pagination");
        paginationContainer.innerHTML = "";

        const totalPages = Math.ceil(submissions.length / postsPerPage);

        // Create previous button
        const prevButton = document.createElement("button");
        prevButton.className = "btn btn-secondary";
        prevButton.innerText = "Previous";
        prevButton.disabled = currentPage === 1;
        prevButton.addEventListener("click", () => {
            currentPage--;
            renderPosts(currentPage);
        });
        paginationContainer.appendChild(prevButton);

        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement("button");
            pageButton.className = "btn btn-secondary mx-1";
            pageButton.innerText = i;
            pageButton.disabled = i === currentPage;
            pageButton.addEventListener("click", () => {
                currentPage = i;
                renderPosts(currentPage);
            });
            paginationContainer.appendChild(pageButton);
        }

        const nextButton = document.createElement("button");
        nextButton.className = "btn btn-secondary";
        nextButton.innerText = "Next";
        nextButton.disabled = currentPage === totalPages;
        nextButton.addEventListener("click", () => {
            currentPage++;
            renderPosts(currentPage);
        });
        paginationContainer.appendChild(nextButton);
    }

    renderPosts(currentPage);
});
