document.addEventListener('DOMContentLoaded', () => {
    const userId = document.getElementById('page').dataset.userId;
    const posts = [];
    const submit_btn = document.getElementById("submit_btn");
    const postsPerPage = 3; // Number of posts per page
    let currentPage = 1; // Track the current page
    let activeFilter = "All"; // Track the active filter

    function fetch_posts() {
        posts.length = 0;
        var xhr = new XMLHttpRequest();

        xhr.open('GET', 'posts.php', true);
        
        xhr.onreadystatechange = function() {
        
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    try {
                        var data = JSON.parse(xhr.responseText);
                        posts.push(...data);
    
                        console.log("posts:", posts);
                        renderPosts(currentPage);
                    } catch (e) {
                        console.error("Parsing error:", e.message);
                    }
                } else {
                    console.error('Error:', xhr.statusText);
                }
            }
        };
        
        
        xhr.send();
    }

    fetch_posts();
    




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
    

    document.getElementById('submit_btn').addEventListener('click', (event) => {
        event.preventDefault();
    
        // Get input values
        const title = document.getElementById("i_title");
        const description = document.getElementById("i_description");
        const imgInput = document.getElementById("file");
        const found = document.getElementById("found");
        const missing = document.getElementById("missing");
        const imageFile = imgInput.files[0] ? imgInput.files[0] : new File([], "assets/img/no-img.png");
    
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
        if (!found.checked && !missing.checked) {
            alert("Please select the type of listing.");
            return;
        }
    
        // Create form data
        const formData = new FormData();
        formData.append('title', title.value.trim());
        formData.append('description', description.value.trim());
        formData.append('listingType', found.checked ? "Found" : "Missing");
        formData.append('image', imageFile);
    
        // Send form data to the server using XMLHttpRequest
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'posts.php', true);
    
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                alert(xhr.responseText); // This can be changed to a sweet alert
    
                // Reset the form fields
                title.value = "";
                description.value = "";
                found.checked = false;
                missing.checked = false;
                imgInput.value = "";
                resetImageUpload();
                fetch_posts();
            } else {
                console.error('Error:', xhr.statusText);
                alert('Failed to submit the post');
            }
        };
    
        xhr.onerror = function () {
            console.error('Request error...');
            alert('Failed to submit the post');
        };
    
        xhr.send(formData);
    });
    
    
    function renderPosts(page) {
        const postsContainer = document.getElementById("blog_posts");

        // Filter posts based on activeFilter
        const filteredPosts = activeFilter === "All" ? posts : posts.filter(post => post.listingType === activeFilter);

        const startIndex = (page - 1) * postsPerPage;
        const endIndex = startIndex + postsPerPage;
        const postsToDisplay = filteredPosts.slice(startIndex, endIndex);
        postsContainer.innerHTML = ""; // Clear container before rendering

        if (postsToDisplay && postsToDisplay.length === 0) {
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
        const imageDataUrl = submissionData.img ? `data:image/jpeg;base64,${submissionData.img}` : 'assets/listings_img/no-img.png';
        const postContent = `
        <div data-post-index="${submissionData.Id}" class="post-c blog-grid">
            <div id="post">
                <div class="blog-grid-img position-relative">
                    <img alt="img" src="${imageDataUrl}" class="listing-img img-fluid">

                </div>
                <div class="blog-grid-text p-4">
                    <div class="row">
                        <h3 class="h5 col-8 mb-3">${submissionData.Title}</h3>
                        <div class="col-4 text-end">
                            <a href="#" class="Edit me-2"><i class="fas fa-edit"></i></a>
                            <a href="#" class="Delete"><i class="fas fa-trash-alt"></i></a>
                        </div>
                    </div>
                    <p class="display-30">${submissionData.Content}</p>
                    <div class="row mt-2" id="${submissionData.Id}-post">
                    </div>
                    <div class="meta meta-style2">
                        <ul>
                            <li><i class="fas fa-calendar-alt icon-blue"></i>${submissionData.Datetime}</li>
                            <li><a href="#!"><i class="fas fa-user icon-blue"></i> ${submissionData.FirstName}</a></li>  
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
        var isEditOpen = false;
        // Edit functionality
        editButton.addEventListener('click', (e) => {
            e.preventDefault();
        
            const postTitle = postElement.querySelector("h3");
            const postDescription = postElement.querySelector("p.display-30");
            const buttonContainer = document.getElementById(`${submissionData.Id}-post`);
        
            if (!isEditOpen) {
                // Enter edit mode
                isEditOpen = true;
        
                // Store the original content in case the user cancels editing
                const originalTitle = submissionData.Title;
                const originalDescription = submissionData.Content;
        
                // Replace the title and description with input fields
                postTitle.innerHTML = `<input type="text" class="form-control" value="${originalTitle}">`;
                postDescription.innerHTML = `<textarea class="form-control">${originalDescription}</textarea>`;
        
                buttonContainer.innerHTML = "";
        
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
                    var updateXhr = new XMLHttpRequest();
                    updateXhr.open('POST', 'update_post.php', true);
                    updateXhr.setRequestHeader('Content-Type', 'application/json');
                
                    updateXhr.onreadystatechange = function() {
                        if (updateXhr.readyState === 4) {
                            if (updateXhr.status === 200) {
                                var result = JSON.parse(updateXhr.responseText);
                                if (result.success) {
                                    // Update the post data and re-render
                                    submissionData.Title = updatedTitle;
                                    submissionData.Content = updatedDescription;
                                    renderPosts(currentPage);
                                    Swal.fire({
                                        title: "Success",
                                        text: result.message,
                                        icon: "success",
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Error",
                                        text: result.message,
                                        icon: "error",
                                    });
                                }
                                isEditOpen = false; // Exit edit mode
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: "Failed to update post. Please try again later.",
                                    icon: "error",
                                });
                            }
                        }
                    };
                
                    var updatedPost = {
                        Id: submissionData.Id,
                        Title: updatedTitle,
                        Content: updatedDescription
                    };
                
                    updateXhr.send(JSON.stringify(updatedPost));
                });
        
                // Add functionality to the cancel button
                cancelButton.addEventListener("click", () => {
                    // Revert the content to original values
                    postTitle.innerHTML = originalTitle;
                    postDescription.innerHTML = originalDescription;
                    buttonContainer.innerHTML = ""; // Remove the Save and Cancel buttons
                    isEditOpen = false; // Exit edit mode
                });
            } else {
                // Exit edit mode (revert changes if Save wasn't clicked)
                isEditOpen = false;
        
                // Revert to original values (assume `submissionData` is up-to-date if changes were saved)
                postTitle.innerHTML = submissionData.title;
                postDescription.innerHTML = submissionData.description;
                buttonContainer.innerHTML = ""; // Clear the buttons
            }
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
        /*const commentSection = postElement.querySelector('.comment-section');
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
        });*/
        
        
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
