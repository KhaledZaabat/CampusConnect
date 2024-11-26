//Edit
document.querySelectorAll('.Edit').forEach((editButton) => {
    editButton.addEventListener('click', function(event) {
        event.preventDefault();

        const row = this.closest('tr');
        const inputs = row.querySelectorAll('.tableinput');
        const editIcon = this.querySelector('i'); 
        const roleInput = row.querySelector('.roleinput');
        const inputFields = Array.from(inputs); 

        if (editIcon.classList.contains('fa-edit')) {
            // Enable all inputs in the row and make them visible
            inputs.forEach(input => {
                input.disabled = false;
                input.style.display = 'inline';
                input.style.border = '1px solid #ccc'; 
            });

            // Enable the dropdown arrow for the role input
            if (roleInput) {
                roleInput.style.webkitAppearance = 'auto';  
                roleInput.style.mozAppearance = 'auto';  
                roleInput.style.appearance = 'auto';  
            }

            // Change edit icon to confirm icon
            editIcon.classList.remove('fa-edit');
            editIcon.classList.add('fa-check');
        } else {
            Swal.fire({
                title: "Do you want to save the changes?",
                showCancelButton: true,
                confirmButtonText: "Save", 
                cancelButtonText: "Cancel" 
            }).then((result) => {
                if (result.isConfirmed) {
                    // Save changes, disable inputs, and update button text to "Edit"
                    inputFields.forEach((input) => {
                        input.disabled = true; 
                        input.style.display = ''; 
                        input.style.border = ''; 
                    });
                    Swal.fire("Saved!", "", "success");
                    editIcon.classList.remove('fa-check');
                    editIcon.classList.add('fa-edit');
                } else if (result.isDismissed) {
                    inputFields.forEach((input, index) => {
                        if (initialValues[index] !== undefined) {
                            input.value = initialValues[index];
                        }
                        input.disabled = true;
                        input.style.display = '';
                        input.style.border = '';
                    });

                    // Disable the dropdown arrow for the role input
                    if (roleInput) {
                        roleInput.style.webkitAppearance = 'none';
                        roleInput.style.mozAppearance = 'none'; 
                        roleInput.style.appearance = 'none';  
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

//delete
document.querySelectorAll('.Delete').forEach((deleteButton) => {
    deleteButton.addEventListener('click', function(event) {
        event.preventDefault();

        // Get the row of the button clicked
        const row = this.closest('tr');
        
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
                row.remove();
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                });
            }
        });
    });
});

//search bar
document.querySelector('.search-icon').addEventListener('click', function() {
    const searchBar = document.querySelector('.search-bar');
    searchBar.classList.toggle('active');
    const icon = this.querySelector('i');
    if (searchBar.classList.contains('active')) {
        icon.classList.remove('fa-search');
        icon.classList.add('fa-times'); // Change to close icon
    } else {
        icon.classList.remove('fa-times');
        icon.classList.add('fa-search'); // Change back to search icon
    }
});

document.querySelector('.search-bar').addEventListener('input', function() {
    const query = this.value.toLowerCase(); 
    const rows = document.querySelectorAll('tbody tr'); 
    rows.forEach(row => {
        const roomNumber = row.querySelector('.roominput') ? row.querySelector('.roominput').value.toLowerCase() : ''; 
        const role = row.querySelector('.roleinput') ? row.querySelector('.roleinput').value.toLowerCase() : ''; 
        const lastName = row.querySelector('.Lname') ? row.querySelector('.Lname').value.toLowerCase() : '';

        if (roomNumber.includes(query) || role.includes(query) || lastName.includes(query)) {
            row.style.display = ''; 
        } else {
            row.style.display = 'none'; 
        }
    });
});

//Pagination 
// Set the number of rows (students) per page
const rowsPerPage = 10;
let currentPage = 1;

// Function to display the current page
function displayPage(page) {
    const rows = document.querySelectorAll("tbody tr");
    const totalRows = rows.length;
    const totalPages = Math.ceil(totalRows / rowsPerPage);
    
    // Hide all rows
    rows.forEach((row) => row.style.display = 'none');
    
    // Show only the rows for the current page
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    for (let i = start; i < end && i < totalRows; i++) {
        rows[i].style.display = '';
    }
    
    // Update the page number display
    document.getElementById("page-num").textContent = page;
    
    // Enable/disable pagination buttons
    document.getElementById("prevpage").disabled = (page === 1);
    document.getElementById("nextpage").disabled = (page === totalPages);
}

// Event listeners for the pagination buttons
document.getElementById("prevpage").addEventListener("click", function() {
    if (currentPage > 1) {
        currentPage--;
        displayPage(currentPage);
    }
});

document.getElementById("nextpage").addEventListener("click", function() {
    const rows = document.querySelectorAll("tbody tr");
    const totalPages = Math.ceil(rows.length / rowsPerPage);
    
    if (currentPage < totalPages) {
        currentPage++;
        displayPage(currentPage);
    }
});

// Initialize pagination
displayPage(currentPage);

// Function to update floor options based on selected bloc
function updateFloorOptions() {
    let blocInput = document.querySelector('select[name="bloc"]');
    let floorInput = document.querySelector('select[name="floor"]');
    
    let floorOptions = floorInput.querySelectorAll('option');
    
    // Remove the 5th floor option if bloc is C, D, or E
    if (blocInput.value === 'C' || blocInput.value === 'D' || blocInput.value === 'E') {
        // Hide the 5th floor option
        floorOptions.forEach(option => {
            if (option.value === '5') {
                option.style.display = 'none';
            }
        });
    } else {
        // Show the 5th floor option for other blocs
        floorOptions.forEach(option => {
            if (option.value === '5') {
                option.style.display = 'block';
            }
        });
    }
}

// Initialize the floor options when the page loads
window.addEventListener('DOMContentLoaded', function() {
    updateFloorOptions(); // Update based on initial selection

    // Listen for changes in the bloc selection
    document.querySelector('select[name="bloc"]').addEventListener('change', updateFloorOptions);
});

// General function to show error message for a given input
function showError(input, message) {
    let errorElement = document.createElement('span');
    errorElement.classList.add('error-message');
    errorElement.style.color = 'red';
    errorElement.textContent = message;

    // Check if there's already an error message
    if (!input.parentElement.querySelector('.error-message')) {
        input.parentElement.appendChild(errorElement);
    }
    input.style.borderColor = 'red'; // Highlight input with red border
}

// Reset error message and border style
function resetError(input) {
    let errorElement = input.parentElement.querySelector('.error-message');
    if (errorElement) {
        errorElement.remove();
    }
    input.style.borderColor = ''; // Reset border color
}

// Validate the Student ID
function validateStudentID(input) {
    let value = input.value.trim();
    let pattern = /^\d{9}/; // Student ID should be at least 9 digits
    if (!pattern.test(value)) {
        showError(input, "Student ID must be at least 9 digits.");
        return false;
    }
    resetError(input);
    return true;
}

// Validate text input (First Name and Last Name)
function validateTextInput(input, minLength) {
    let value = input.value.trim();
    if (value.length < minLength) {
        showError(input, `${input.placeholder} must be at least ${minLength} characters.`);
        return false;
    }
    resetError(input);
    return true;
}

// Validate Email
function validateEmail(input) {
    let value = input.value.trim();
    let pattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (value && !pattern.test(value)) {
        showError(input, "Please enter a valid email address.");
        return false;
    }
    resetError(input);
    return true;
}

// Validate Phone Number
function validatePhone(input) {
    let value = input.value.trim();
    let pattern = /^\d{10}$/; // Phone number should be exactly 10 digits
    if (value && !pattern.test(value)) {
        showError(input, "Phone number must be exactly 10 digits.");
        return false;
    }
    resetError(input);
    return true;
}

// Validate the Form before submission
function validateForm(event) {
    let isValid = true;

    // Validate Student ID
    let studentIdInput = document.querySelector('input[name="StudentID"]');
    if (!validateStudentID(studentIdInput)) {
        isValid = false;
    }

    // Validate user ID
    let userId = document.querySelector('input[name="userID"]');
    if (!validateStudentID(userId)) {
        isValid = false;
    }

    // Validate First Name (at least 2 characters)
    let firstNameInput = document.querySelector('input[name="firstName"]');
    if (!validateTextInput(firstNameInput, 2)) {
        isValid = false;
    }

    // Validate Last Name (at least 2 characters)
    let lastNameInput = document.querySelector('input[name="lastName"]');
    if (!validateTextInput(lastNameInput, 2)) {
        isValid = false;
    }

    // Validate Email
    let emailInput = document.querySelector('input[name="email"]');
    if (!validateEmail(emailInput)) {
        isValid = false;
    }

    // Validate Phone Number (exactly 10 digits)
    let phoneInput = document.querySelector('input[name="phone"]');
    if (!validatePhone(phoneInput)) {
        isValid = false;
    }

    // Prevent form submission if validation fails
    return isValid;
}

// Attach the validation function to the form submission
let form = document.querySelector('.student-form');
form.addEventListener('submit', function(event) {
    // Prevent form submission only if validation fails
    if (!validateForm(event)) {
        event.preventDefault(); // Prevent form submission
    }
});
