// previewImage
function previewImage(event) {
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const uploadIcon = document.getElementById('upload-icon');
    const uploadText = document.getElementById('upload-text');
    
    // Show the image preview section
    imagePreview.style.display = 'block';
    
    // Update the image source for preview
    previewImg.src = URL.createObjectURL(event.target.files[0]);
    
    // Optionally hide the upload icon and text after the image is uploaded
    uploadIcon.style.display = 'none';
    uploadText.innerHTML = 'Image selected!';
}
// resetThe Image upload veiw
function resetImageUpload() {
    const imgInput = document.getElementById('file');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const uploadIcon = document.getElementById('upload-icon');
    const uploadText = document.getElementById('upload-text');

    // Hide the image preview section
    imagePreview.style.display = 'none';

    // Reset the preview image source
    previewImg.src = '';

    // Restore the upload icon and text
    uploadIcon.style.display = 'block';
    uploadText.innerHTML = 'Click to upload image';

    // Reset the file input by replacing it with a cloned element
    const newInput = imgInput.cloneNode();
    imgInput.replaceWith(newInput);

    // Re-attach the previewImage function to the new input
    newInput.addEventListener('change', previewImage);
}
//an abstract way to render a pagination
function renderPaginationGeneral({
    containerId,
    currentPage,
    totalItems,
    itemsPerPage,
    onPageChange
}) {
    const paginationContainer = document.getElementById(containerId);
    paginationContainer.innerHTML = "";

    const totalPages = Math.ceil(totalItems / itemsPerPage);

    // Create the nav element
    const nav = document.createElement("nav");
    nav.setAttribute("aria-label", "Page navigation example");

    // Create the ul element
    const ul = document.createElement("ul");
    ul.className = "pagination justify-content-center";

    // Previous button
    const prevLi = document.createElement("li");
    prevLi.className = `page-item ${currentPage === 1 ? "disabled" : ""}`;
    const prevLink = document.createElement("a");
    prevLink.className = "page-link";
    prevLink.href = "#";
    prevLink.setAttribute("aria-label", "Previous");
    prevLink.innerHTML = `<span aria-hidden="true">&laquo;</span>`;
    prevLink.addEventListener("click", (event) => {
        event.preventDefault();
        if (currentPage > 1) {
            onPageChange(currentPage - 1);
        }
    });
    prevLi.appendChild(prevLink);
    ul.appendChild(prevLi);

    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement("li");
        li.className = `page-item ${i === currentPage ? "active" : ""}`;
        const a = document.createElement("a");
        a.className = "page-link";
        a.href = "#";
        a.innerText = i;
        a.addEventListener("click", (event) => {
            event.preventDefault();
            onPageChange(i);
        });
        li.appendChild(a);
        ul.appendChild(li);
    }

    // Next button
    const nextLi = document.createElement("li");
    nextLi.className = `page-item ${currentPage === totalPages ? "disabled" : ""}`;
    const nextLink = document.createElement("a");
    nextLink.className = "page-link";
    nextLink.href = "#";
    nextLink.setAttribute("aria-label", "Next");
    nextLink.innerHTML = `<span aria-hidden="true">&raquo;</span>`;
    nextLink.addEventListener("click", (event) => {
        event.preventDefault();
        if (currentPage < totalPages) {
            onPageChange(currentPage + 1);
        }
    });
    nextLi.appendChild(nextLink);
    ul.appendChild(nextLi);

    // Append the ul to the nav and then to the container
    nav.appendChild(ul);
    paginationContainer.appendChild(nav);
}
