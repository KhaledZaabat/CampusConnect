document.addEventListener('DOMContentLoaded', () => {
    const userId = document.getElementById('page').dataset.userId;
    const posts = [];
    const submit_btn = document.getElementById("submit_btn");
    const postsPerPage = 3; // Number of posts per page
    const isAdmin = document.getElementById('page').dataset.isAdmin === "Admin";
    let currentPage = 1; 
    let activeFilter = "All"; 

    function fetch_posts() {
        posts.length = 0;
        var xhr = new XMLHttpRequest();
    
        xhr.open('GET', 'posts.php', true);
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    try {
                        var data = JSON.parse(xhr.responseText);
                        if (Array.isArray(data)) {
                            posts.push(...data);
                        } else {
                            console.error("Expected an array but got:", data);
                        }
    
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
        const imageFile = imgInput.files[0];
    
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
    
        if (!found.checked && !missing.checked) {
            alert("Please select the type of listing.");
            return;
        }
    
        const formData = new FormData();
        formData.append('title', title.value.trim());
        formData.append('description', description.value.trim());
        formData.append('listingType', found.checked ? "Found" : "Missing");
        formData.append('image', imageFile);
    
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'posts.php', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Posted successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
        
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
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to submit the post',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        };
        
        xhr.onerror = function () {
            console.error('Request error...');
            Swal.fire({
                title: 'Error!',
                text: 'Failed to submit the post',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        };
        
        xhr.send(formData);
        
    });
    
    
    function renderPosts(page) {
        const postsContainer = document.getElementById("blog_posts");

        // Filter posts based on activeFilter
        const filteredPosts = activeFilter === "All" ? posts : posts.filter(post => post.Type === activeFilter);

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
        const imageDataUrl = submissionData.img ? `data:image/jpeg;base64,${submissionData.img}` : 'assets/img/no-img.png';
        const postContent = `
        <div data-post-index="${submissionData.Id}" class="post-c blog-grid">
            <div id="post">
                <div class="blog-grid-img position-relative">
                    <img alt="img" src="${imageDataUrl}" class="listing-img img-fluid">

                </div>
                <div class="blog-grid-text p-4">
                    <div class="row">
                        <h3 class="h5 col-8 mb-3">${submissionData.Title}</h3>
                        
                        <div id="edit_delete" class="col-4 text-end">
                        </div>

                    </div>
                    <p class="display-30">${submissionData.Content}</p>
                    <div class="row mt-2" id="${submissionData.Id}-post">
                    </div>
                    <div class="meta meta-style2">
                        <ul>
                            <li><i class="fas fa-calendar-alt icon-blue"></i>${submissionData.Datetime}</li>
                            <li><i class="fas fa-user icon-blue"></i> ${submissionData.FirstName}</li>
                        <li id="comments-toggle-${submissionData.Id}" data-post-index="${submissionData.Id}" class="comments-toggle"><i class="fas fa-comments icon-blue"></i></li> 
                        </ul>


                    </div>
                <div>
                <!-- Hidden Comment Section -->
                <div data-post-index="${submissionData.Id}" class="comment-section mt-4" style="display: none;">
                    <form class="nav nav-item w-100 position-relative comment-form">
                        <textarea data-autoresize class="text-field pe-5 bg-light" rows="1" placeholder="Add a comment..."></textarea>
                        <button class="comments bg-transparent px-3 position-absolute top-50 end-0 translate-middle-y border-0" type="submit">
                            <i class="fa-regular fa-paper-plane"></i>
                        </button>
                    </form>
                    <!-- Comments Section -->
                    <div data-post-index="${submissionData.Id}" class="comments-container mt-3"></div>
                    <div class="comments-pagination"></div>
                </div>
            </div>
        </div>
        `;
        postElement.innerHTML = postContent;
        postsContainer.appendChild(postElement);
        const isPostOwner = (submissionData.UserId === userId);
        var isEditOpen = false;
        var editButton= null;
        var deleteButton= null;
        const edit_delete = postElement.querySelector('#edit_delete');

        if(isPostOwner){
            editButton = document.createElement("a");

            editButton.innerHTML = `<i class="fas fa-edit"></i>`;
            editButton.href = "#";
            editButton.className = "Edit me-2";
            
            deleteButton = document.createElement("a");
            deleteButton.innerHTML = `<i class="fas fa-trash-alt"></i>`;
            deleteButton.href = "#";
            deleteButton.className = "Delete";
            edit_delete.appendChild(editButton);
            edit_delete.appendChild(deleteButton);
        }

        else if(isAdmin){
            deleteButton = document.createElement("a");
            deleteButton.innerHTML = `<i class="fas fa-trash-alt"></i>`;
            deleteButton.href = "#";
            deleteButton.className = "Delete";
            edit_delete.appendChild(deleteButton);
        }
        
        if(editButton){
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
                    
                        updateXhr.send(JSON.stringify({
                            action: 'update',
                            Id: submissionData.Id,
                            Title: updatedTitle,
                            Content: updatedDescription
                        }));
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
        }
        // Delete functionality
        if(deleteButton){
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
                        const postId = submissionData.Id;
                        const postIndex = posts.indexOf(submissionData);
            
                        if (postIndex !== -1) {
                            // Send delete request to the server using XMLHttpRequest
                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', 'update_post.php', true);
                            xhr.setRequestHeader('Content-Type', 'application/json');
            
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4) { // Request is complete
                                    if (xhr.status === 200) { // Success
                                        const data = JSON.parse(xhr.responseText);
                                        if (data.success) {
                                            posts.splice(postIndex, 1); // Remove the post from the array
                                            Swal.fire({
                                                title: "Deleted!",
                                                text: "The post has been deleted.",
                                                icon: "success",
                                            });
                                            renderPosts(currentPage); // Re-render posts to reflect changes
                                        } else {
                                            Swal.fire({
                                                title: "Error!",
                                                text: data.message,
                                                icon: "error",
                                            });
                                        }
                                    } else { // Error
                                        Swal.fire({
                                            title: "Error!",
                                            text: "An error occurred while deleting the post.",
                                            icon: "error",
                                        });
                                    }
                                }
                            };
            
                            xhr.send(JSON.stringify({ action: 'delete', Id: postId }));
                        }
                    }
                });
            });
        }    


        const commentSection = postElement.querySelector('.comment-section');
        const commentsToggle = postElement.querySelector(`#comments-toggle-${submissionData.Id}`);
        const commentForm = postElement.querySelector('.comment-form');
        const commentsContainer = postElement.querySelector('.comments-container');
        const commentsPagination = postElement.querySelector('.comments-pagination');
        commentsToggle.innerHTML = `<i class="fas fa-comments icon-blue"></i> ${submissionData.comment.length}`;

        commentsToggle.addEventListener('click', () => {
            commentSection.style.display = commentSection.style.display === 'none' ? 'block' : 'none';
            loadComments(submissionData, commentsContainer, commentsPagination, submissionData.id);
        });

    
        commentForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const textarea = commentForm.querySelector('textarea');
            const commentText = textarea.value.trim();
            
            if (commentText.length > 100) {
                Swal.fire({
                    title: "Error",
                    text: "Comment must be 100 characters or less!",
                    icon: "error",
                });
                return;
            }
        
            if (commentText) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'comments.php', true);
                xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            try {
                                const response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    const newComment = {
                                        FirstName: response.username, 
                                        Id: response.Id, 
                                        Datetime: new Date().toLocaleString(),
                                        Content :commentText,
                                        UserId: userId
                                    };
                                    console.log(newComment);
                                    submissionData.comment.push(newComment);
                                    textarea.value = "";
                                    submissionData.currentCommentPage = 1; // Reset to page 1 after a new comment
                                    loadComments(submissionData, commentsContainer, commentsPagination, submissionData.id);
                                } else {
                                    Swal.fire({
                                        title: "Error",
                                        text: response.message,
                                        icon: "error",
                                    });
                                }
                            } catch (e) {
                                console.log(response);
                                console.error("Parsing error:", e.message);
                            }
                        } else {
                            Swal.fire({
                                title: "Error",
                                text: "Unexpected error occurred. Check the console for details.",
                                icon: "error",
                            });
                        }
                    }
                };
                
        
                const data = JSON.stringify({
                    action: 'create',
                    postId: submissionData.Id,
                    content: commentText,
                    userId: userId 
                });
                xhr.send(data);
            }
        });
    }
    
    function loadComments(submissionData, commentsContainer, commentsPagination, postIndex) {
        const commentsPerPage = 2; // Display 2 comments per page        
        const commentsToggle = document.querySelector(`#comments-toggle-${submissionData.Id}`);
        commentsToggle.innerHTML = `<i class="fas fa-comments icon-blue"></i> ${submissionData.comment.length}`;

        // Sort comments in descending order by date
        submissionData.comment.sort((a, b) => new Date(b.Datetime) - new Date(a.Datetime));
        if(!submissionData.currentCommentPage){
            submissionData.currentCommentPage = 1;
        }
        const startIndex = (submissionData.currentCommentPage - 1) * commentsPerPage;
        const endIndex = startIndex + commentsPerPage;
        const commentsToDisplay = submissionData.comment.slice(startIndex, endIndex);
        // Render the comments
        commentsContainer.innerHTML = commentsToDisplay.map((comment, index) => `
        <div class="border-visible bg-light p-3 rounded mb-2" data-comment-index="${startIndex + index}">
            <div class="d-flex justify-content-between">
                <h6 class="mb-1"><a href="#!">${comment.FirstName}</a></h6>
                <small class="ms-2">${comment.Datetime}</small>
            </div>
            <div class="row">
                <p class="small col-8 mb-0 comment-text display-30">${comment.Content}</p>
                <div class="comment-actions col-4 text-end">
                    ${comment.UserId === userId ? `
                    <a href="#" class="edit-comment Edit cm me-2"><i class="fas fa-edit"></i></a>
                    <a href="#" class="delete-comment Delete cm sm"><i class="fas fa-trash-alt"></i></a>
                    ` : ''
                    }
                    ${comment.UserId !== userId && isAdmin ?
                        `<a href="#" class="delete-comment Delete cm sm"><i class="fas fa-trash-alt"></i></a>`
                        : ''
                    }

                </div>
            </div>
        </div>
    `).join('');
    
        // Attach event listeners for edit and delete icons
        attachCommentListeners(submissionData, commentsContainer, commentsPagination, postIndex);
    
        // Render pagination
        commentsPagination.innerHTML = '';
        const totalCommentPages = Math.ceil(submissionData.comment.length / commentsPerPage);
    
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
                const commentText = submissionData.comment[index].Content;
                const commentParagraph = commentsContainer.querySelectorAll('.comment-text')[index];
        
                commentParagraph.innerHTML = `
                    <textarea class="form-control">${commentText}</textarea>
                `;
        
                const saveIcon = document.createElement('i');
                saveIcon.className = "fas fa-save save save-comment text-success cm ms-2";
                saveIcon.style.cursor = "pointer";
                saveIcon.title = "Save";
                commentParagraph.parentElement.querySelector('.comment-actions').appendChild(saveIcon);
        
                editIcon.style.display = 'none';
        
                saveIcon.addEventListener('click', () => {
                    const updatedComment = commentParagraph.querySelector('textarea').value.trim();
        
                    if (updatedComment) {
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', 'comments.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                try {
                                    const response = JSON.parse(xhr.responseText);
                                    if (response.success) {
                                        submissionData.comment[index].Content = updatedComment;
                                        submissionData.comment[index].date = new Date().toLocaleString(); // Update the date
                                        loadComments(submissionData, commentsContainer, commentsPagination, postIndex); // Re-render comments
                                    } else {
                                        Swal.fire({
                                            title: "Error",
                                            text: response.message,
                                            icon: "error",
                                        });
                                    }
                                } catch (e) {
                                    console.error("Parsing error:", e.message);
                                }
                            }
                        };
        
                        const data = JSON.stringify({
                            action: 'edit',
                            commentId: submissionData.comment[index].Id,
                            content: updatedComment
                        });
                        xhr.send(data);
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
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', 'comments.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                try {
                                    const response = JSON.parse(xhr.responseText);
                                    if (response.success) {
                                        submissionData.comment.splice(index, 1);
                                        loadComments(submissionData, commentsContainer, commentsPagination, submissionData.id);
                                    } else {
                                        Swal.fire({
                                            title: "Error",
                                            text: response.message,
                                            icon: "error",
                                        });
                                    }
                                } catch (e) {
                                    console.error("Parsing error:", e.message);
                                }
                            }
                        };
        
                        const data = JSON.stringify({
                            action: 'delete',
                            commentId: submissionData.comment[index].Id,
                            userId: userId 
                        });
                        console.log(data);
                        xhr.send(data);
                    }
                });
            });
        });                
    }
    
    renderPosts(currentPage);
});