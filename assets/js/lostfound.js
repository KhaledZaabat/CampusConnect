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
            title: title.value.trim(),
            description: description.value.trim(),
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
        <div data-post-index="${posts.indexOf(submissionData)}" class="post-c blog-grid">
            <div id="post">
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
                    <div id="b-post"></div>
                    <div class="meta meta-style2">
                        <ul>
                            <li><i class="fas fa-calendar-alt icon-blue"></i> 10 Jul, 2022</li>
                            <li><a href="#!"><i class="fas fa-user icon-blue"></i> User</a></li>  
                            <li data-post-index="${posts.indexOf(submissionData)}" class="comments-toggle" ><i class="fas fa-comments icon-blue"></i> ${submissionData.comments.length}</li>
                        </ul>


                    </div>
                <div>
                <!-- Hidden Comment Section -->
                <div data-post-index="${posts.indexOf(submissionData)}" class="comment-section mt-4" style="display: none;">
                    <form class="nav nav-item w-100 position-relative comment-form">
                        <textarea data-autoresize class="text-field pe-5 bg-light" rows="1" placeholder="Add a comment..."></textarea>
                        <button class="comments bg-transparent px-3 position-absolute top-50 end-0 translate-middle-y border-0" type="submit">
                            <i class="fa-regular fa-paper-plane"></i>
                        </button>
                    </form>
                    <!-- Comments Section -->
                    <div data-post-index="${posts.indexOf(submissionData)}" class="comments-container mt-3"></div>
                    <div class="comments-pagination"></div>
                </div>
            </div>
        </div>
        `;
    
        postElement.innerHTML = postContent;
        postsContainer.appendChild(postElement);
        const editButton = postElement.querySelector('.Edit');
        const deleteButton = postElement.querySelector('.Delete');
        
        // Edit functionality
        editButton.addEventListener('click', (e) => {
            e.preventDefault();
        
            // Make the title and description editable
            const postTitle = postElement.querySelector("h3");
            const postDescription = postElement.querySelector("p.display-30");
        
            // Store the original content in case the user cancels editing
            const originalTitle = submissionData.title;
            const originalDescription = submissionData.description;
        
            // Replace the title and description with input fields
            postTitle.innerHTML = `<input type="text" class="form-control" value="${originalTitle}">`;
            postDescription.innerHTML = `<textarea class="form-control">${originalDescription}</textarea>`;
        
            const buttonContainer = document.createElement("div");
            buttonContainer.className = "row mt-2"; // Bootstrap row with margin-top for spacing
        
            // Create Save button
            const saveButtonCol = document.createElement("div");
            saveButtonCol.className = "col-auto"; // Bootstrap column with auto width
            const saveButton = document.createElement("button");
            saveButton.className = "save-button";
            saveButton.textContent = "Save";
            saveButtonCol.appendChild(saveButton);
        
            // Create Cancel button
            const cancelButtonCol = document.createElement("div");
            cancelButtonCol.className = "col-auto"; // Bootstrap column with auto width
            const cancelButton = document.createElement("button");
            cancelButton.className = "cancel-button";
            cancelButton.textContent = "Cancel";
            cancelButtonCol.appendChild(cancelButton);
        
            // Append columns to the container
            buttonContainer.appendChild(saveButtonCol);
            buttonContainer.appendChild(cancelButtonCol);
            document.getElementById("b-post").appendChild(buttonContainer);
            // Append the button container after the description
        
            // Add functionality to the save button
            saveButton.addEventListener("click", () => {
                const updatedTitle = postTitle.querySelector("input").value.trim();
                const updatedDescription = postDescription.querySelector("textarea").value.trim();
        
                if (!updatedTitle || !updatedDescription) {
                    Swal.fire({
                        title: "Error",
                        text: "Both title and description are required!",
                        icon: "error",
                    });
                    return;
                }
        
                // Update the post data and re-render
                submissionData.title = updatedTitle;
                submissionData.description = updatedDescription;
                renderPosts(currentPage);
            });
        
            // Add functionality to the cancel button
            cancelButton.addEventListener("click", () => {
                // Revert the content to original values
                postTitle.innerHTML = originalTitle;
                postDescription.innerHTML = originalDescription;
                buttonContainer.remove(); // Remove the Save and Cancel buttons
            });
        
            // Optional SweetAlert to inform the user they are editing
        });
        
        
        // Delete functionality
        deleteButton.addEventListener('click', (e) => {
            e.preventDefault();
        
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to delete this post? This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, keep it",
            }).then((result) => {
                if (result.isConfirmed) {
                    const postIndex = posts.indexOf(submissionData);
                    if (postIndex !== -1) {
                        posts.splice(postIndex, 1); // Remove the post from the array
                        Swal.fire({
                            title: "Deleted!",
                            text: "The post has been deleted.",
                            icon: "success",
                        });
                        renderPosts(currentPage); // Re-render posts to reflect changes
                    }
                }
            });
        });
        
        // Comments toggle
        const commentSection = postElement.querySelector('.comment-section');
        const commentsToggle = postElement.querySelector('.comments-toggle');
        const commentForm = postElement.querySelector('.comment-form');
        const commentsContainer = postElement.querySelector('.comments-container');
        const commentsPagination = postElement.querySelector('.comments-pagination');
    
        commentsToggle.addEventListener('click', () => {
            commentSection.style.display = commentSection.style.display === 'none' ? 'block' : 'none';
            loadComments(submissionData, commentsContainer, commentsPagination, posts.indexOf(submissionData));
        });
        
    
        // Add comment form functionality
        commentForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const textarea = commentForm.querySelector('textarea');
            const commentText = textarea.value.trim();
            
            // Check if the comment length is greater than 100 characters
            if (commentText.length > 100) {
                Swal.fire({
                    title: "Error",
                    text: "Comment must be 100 characters or less!",
                    icon: "error",
                });
                return;
            }
        
            // If comment length is valid, proceed to add the comment
            if (commentText) {
                const newComment = {
                    username: 'User',
                    date: new Date().toLocaleString(),
                    commentText
                };
                submissionData.comments.push(newComment);
                textarea.value = "";
                submissionData.currentCommentPage = 1; // Reset to page 1 after a new comment
                loadComments(submissionData, commentsContainer, commentsPagination, commentsContainer.dataset.postIndex);

            }
        });
        
        
    }
    
    function loadComments(submissionData, commentsContainer, commentsPagination, postIndex) {
        const commentsPerPage = 2; // Display 2 comments per page
    
        // Update the comment length in the UI for the correct post
        const commentsToggle = document.querySelector(`.comments-toggle[data-post-index="${postIndex}"]`);
        if (commentsToggle) {
            commentsToggle.innerHTML = `<i class="fas fa-comments icon-blue"></i> ${submissionData.comments.length}`;
        }
    
        // Sort comments in descending order by date
        submissionData.comments.sort((a, b) => new Date(b.date) - new Date(a.date));
    
        const startIndex = (submissionData.currentCommentPage - 1) * commentsPerPage;
        const endIndex = startIndex + commentsPerPage;
        const commentsToDisplay = submissionData.comments.slice(startIndex, endIndex);
    
        // Render the comments
        commentsContainer.innerHTML = commentsToDisplay.map((comment, index) => `
        <div class="border-visible bg-light p-3 rounded mb-2" data-comment-index="${startIndex + index}">
            <div class="d-flex justify-content-between">
                <h6 class="mb-1"><a href="#!">${comment.username}</a></h6>
                <small class="ms-2">${comment.date}</small>
            </div>
            <div class="row">
                <p class="small col-8 mb-0 comment-text display-30">${comment.commentText}</p>
                <div class="comment-actions col-4 text-end">
                    <a href="#" class="edit-comment Edit cm me-2"><i class="fas fa-edit"></i></a>
                    <a href="#" class="delete-comment Delete cm sm"><i class="fas fa-trash-alt"></i></a>
                </div>
            </div>
        </div>
        `).join('');
    
        // Attach event listeners for edit and delete icons
        attachCommentListeners(submissionData, commentsContainer, commentsPagination, postIndex);
    
        // Render pagination
        commentsPagination.innerHTML = '';
        const totalCommentPages = Math.ceil(submissionData.comments.length / commentsPerPage);
    
        if (submissionData.currentCommentPage > 1) {
            const prevButton = document.createElement('button');
            prevButton.className = 'btn btn-sm btn-secondary me-1';
            prevButton.innerText = 'Previous';
            prevButton.addEventListener('click', () => {
                submissionData.currentCommentPage--;
                loadComments(submissionData, commentsContainer, commentsPagination, postIndex);
            });
            commentsPagination.appendChild(prevButton);
        }
    
        if (submissionData.currentCommentPage < totalCommentPages) {
            const nextButton = document.createElement('button');
            nextButton.className = 'btn btn-sm btn-secondary';
            nextButton.innerText = 'Next';
            nextButton.addEventListener('click', () => {
                submissionData.currentCommentPage++;
                loadComments(submissionData, commentsContainer, commentsPagination, postIndex);
            });
            commentsPagination.appendChild(nextButton);
        }
    }
    
    function attachCommentListeners(submissionData, commentsContainer, commentsPagination, postIndex) {
        // Add edit and delete functionality for comments
        commentsContainer.querySelectorAll('.edit-comment').forEach((editIcon, index) => {
            editIcon.addEventListener('click', (e) => {
                e.preventDefault();
                const commentText = submissionData.comments[index].commentText;
                const commentParagraph = commentsContainer.querySelectorAll('.comment-text')[index];
    
                // Replace comment text with an editable input
                commentParagraph.innerHTML = `
                    <textarea class="form-control">${commentText}</textarea>
                `;
    
                // Change the Edit icon to a Save icon
                const saveIcon = document.createElement('i');
                saveIcon.className = "fas fa-save save save-comment text-success cm ms-2";
                saveIcon.style.cursor = "pointer";
                saveIcon.title = "Save";
                commentParagraph.parentElement.querySelector('.comment-actions').appendChild(saveIcon);
    
                // Hide the original Edit icon
                editIcon.style.display = 'none';
    
                // Add save functionality
                saveIcon.addEventListener('click', () => {
                    const updatedComment = commentParagraph.querySelector('textarea').value.trim();
    
                    if (updatedComment) {
                        // Update the comment in the data array
                        submissionData.comments[index].commentText = updatedComment;
                        submissionData.comments[index].date = new Date().toLocaleString(); // Update the date
                        loadComments(submissionData, commentsContainer, commentsPagination, postIndex); // Re-render comments
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Comment cannot be empty!",
                            icon: "error",
                        });
                    }
                });
            });
        });
    
        commentsContainer.querySelectorAll('.delete-comment').forEach((deleteIcon, index) => {
            deleteIcon.addEventListener('click', (e) => {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you really want to delete this comment?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Remove the comment from the data array
                        submissionData.comments.splice(index, 1);
                        loadComments(submissionData, commentsContainer, commentsPagination, postIndex); // Re-render comments
                    }
                });
            });
        });
    }
    
    
    

    renderPosts(currentPage);
});
