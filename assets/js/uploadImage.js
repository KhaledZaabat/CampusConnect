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
