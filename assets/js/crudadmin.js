document.querySelectorAll('.Edit').forEach((editButton) => {
    editButton.addEventListener('click', function(event) {
        event.preventDefault();

        const row = this.closest('tr'); // Get the row of the button clicked
        const inputs = row.querySelectorAll('.tableinput'); // Get all input fields in that row
        const editIcon = this.querySelector('i'); // Get the icon inside the button
        const roleInput = row.querySelector('.roleinput'); // Get the role input if it exists
        const inputFields = Array.from(inputs); // Convert NodeList to an array

        if (editIcon.classList.contains('fa-edit')) {
            // Capture initial values when Edit button is clicked
            var initialValues = inputFields.map(input => input.value); // Corrected line
            console.log('Initial Values: ', initialValues); // Debugging to check initial values
            
            // Enable all inputs in the row and make them visible
            inputs.forEach(input => {
                input.disabled = false;
                input.style.display = 'inline';
                input.style.border = '1px solid #ccc'; // Add a border or your preferred style
            });

            // Enable the dropdown arrow for the role input
            if (roleInput) {
                roleInput.style.webkitAppearance = 'auto';  // Enable arrow for WebKit browsers
                roleInput.style.mozAppearance = 'auto';  // Enable arrow for Firefox
                roleInput.style.appearance = 'auto';  // Enable arrow for other browsers
            }

            // Change edit icon to confirm icon
            editIcon.classList.remove('fa-edit');
            editIcon.classList.add('fa-check');
        } else {
            // Show SweetAlert confirmation for saving changes (without "Don't Save" option)
            Swal.fire({
                title: "Do you want to save the changes?",
                showCancelButton: true, // Only show "Cancel" button
                confirmButtonText: "Save", // "Save" button text
                cancelButtonText: "Cancel" // "Cancel" button text
            }).then((result) => {
                if (result.isConfirmed) {
                    // Save changes, disable inputs, and update button text to "Edit"
                    inputFields.forEach((input) => {
                        input.disabled = true; // Disable inputs again
                        input.style.display = ''; // Reset display to default
                        input.style.border = ''; // Reset to default or no border
                    });
                    Swal.fire("Saved!", "", "success");
                    editIcon.classList.remove('fa-check');
                    editIcon.classList.add('fa-edit');
                } else if (result.isDismissed) {
                    // Revert to initial values (if Cancel is clicked)
                    inputFields.forEach((input, index) => {
                        if (initialValues[index] !== undefined) {
                            input.value = initialValues[index]; // Restore the original value
                        }
                        input.disabled = true; // Disable inputs again
                        input.style.display = ''; // Reset display to default
                        input.style.border = ''; // Reset to default or no border
                    });

                    // Disable the dropdown arrow for the role input
                    if (roleInput) {
                        roleInput.style.webkitAppearance = 'none';  // Hide arrow for WebKit browsers
                        roleInput.style.mozAppearance = 'none';  // Hide arrow for Firefox
                        roleInput.style.appearance = 'none';  // Hide arrow for other browsers
                    }

                    // Change confirm icon back to edit icon
                    editIcon.classList.remove('fa-check');
                    editIcon.classList.add('fa-edit');

                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        }
    });
});
document.querySelectorAll('.Delete').forEach((deleteButton) => {
    deleteButton.addEventListener('click', function(event) {
        event.preventDefault();

        // Get the row of the button clicked
        const row = this.closest('tr');
        
        // Show SweetAlert confirmation for deleting the row
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, delete the row from the DOM
                row.remove();

                // Show success SweetAlert after deletion
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                });
            }
        });
    });
});
