document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const fileInput = document.getElementById('file'); // Image input element
    const imagePreviewContainer = document.getElementById('image-preview'); // Preview container
    const previewImage = document.getElementById('preview-img'); // Preview image element

    // Preview Image Functionality
    fileInput.addEventListener('change', function (event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result; // Set the image source
                imagePreviewContainer.style.display = 'block'; // Show the preview container
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        } else {
            // Hide the preview if no file is selected
            imagePreviewContainer.style.display = 'none';
            previewImage.src = '';
        }
    });

    form.addEventListener('submit', function (event) {
        let isValid = true;
        event.preventDefault();

        // Clear previous error messages and reset border styles
        document.querySelectorAll('.error-message').forEach(msg => {
            msg.textContent = ''; // Clear text
            msg.style.display = 'none'; // Hide the error message
        });
        document.querySelectorAll('input, select, textarea').forEach(field => {
            field.classList.remove('error'); // Remove error class
        });

        // Problem Type Validation
        const problemType = document.getElementById('problem-type');
        if (!problemType.value) {
            isValid = false;
            const typeError = document.getElementById('type-error');
            typeError.textContent = 'Please select a problem type.';
            typeError.style.display = 'block';
            problemType.classList.add('error'); // Add error class
        }

        // Problem Description Validation
        const problemDescription = document.getElementById('problem-description');
        if (!problemDescription.value.trim()) {
            isValid = false;
            const descriptionError = document.getElementById('description-error');
            descriptionError.textContent = 'Please provide a short description.';
            descriptionError.style.display = 'block';
            problemDescription.classList.add('error'); // Add error class
        }

        // Urgency Level Validation
        const urgency = document.getElementById('urgency');
        if (!urgency.value) {
            isValid = false;
            const urgencyError = document.getElementById('urgency-error');
            urgencyError.textContent = 'Please select an urgency level.';
            urgencyError.style.display = 'block';
            urgency.classList.add('error'); // Add error class
        }

        // Reported Before Validation
        const reportedBefore = document.getElementById('reported-before');
        if (!reportedBefore.value) {
            isValid = false;
            const reportedError = document.getElementById('reported-error');
            reportedError.textContent = 'Please select whether this has been reported before.';
            reportedError.style.display = 'block';
            reportedBefore.classList.add('error'); // Add error class
        }

        // Confirmation Checkbox Validation
        const confirm = document.getElementById('confirm');
        if (!confirm.checked) {
            isValid = false;
            const confirmError = document.getElementById('confirm-error');
            confirmError.textContent = 'You must confirm the information is correct.';
            confirmError.style.display = 'block';
            confirm.classList.add('error'); // Add error class
        }

        if (isValid) {
            Swal.fire({
                title: 'Confirm Submission',
                text: 'Are you sure you want to submit this form?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit it!',
                cancelButtonText: 'No, cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show success alert after confirmation
                    Swal.fire({
                        title: 'Success!',
                        text: 'Your form has been submitted successfully.',
                        icon: 'success',
                        timer: 2000, // Display success alert for 2 seconds
                        showConfirmButton: false, // No confirm button
                    }).then(() => {
                        // Submit the form after the success alert
                        form.submit();
                    });
                }
            });
        }
    });
});
