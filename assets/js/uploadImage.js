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
