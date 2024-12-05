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
    if (input) {
        input.style.borderColor = 'red'; // Highlight input with red border
    }
}

// Reset error message and border style
function resetError(input) {
    if (input) {
        input.style.borderColor = ''; // Reset border color
    }
}

// Validate the Student ID
function validateStudentID(input) {
    if (!input) {
        console.error("Student ID input field not found.");
        return false;
    }
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
    if (!input) {
        console.error(`Input field for ${minLength} characters not found.`);
        return false;
    }
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
    if (!input) {
        console.error("Email input field not found.");
        return false;
    }
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
    if (!input) {
        console.error("Phone input field not found.");
        return false;
    }
    let value = input.value.trim();
    let pattern = /^\d{10}$/; // Phone number should be exactly 10 digits
    if (!value) { // Check if the field is empty
        showError(input, "Phone number is required.");
        return false;
    }
    if (value && !pattern.test(value)) {
        showError(input, "Phone number must be exactly 10 digits.");
        return false;
    }
    resetError(input);
    return true;
}

function validateRoom(input) {
    if(!input) {
        console.error("Room number not found");
        return false;
    }
    let value=input.value.trim();
    let pattern = /^\d{1,2}/;
    if(!value) {
        showError(input, "Phone number is required.");
        return false;
    }
    if(value && !pattern.test(value)) {
        showError(input, "Room number must be at most 2 digits.");
        return false;
    }
    resetError(input);
    return true;
}

// Validate the Form before submission
function validateForm(event,type) {
    let isValid = true;

    // Validate Student ID
    let studentIdInput = document.querySelector('#ID')
    if(!validateStudentID(studentIdInput)) {
        isValid=false;
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

    if(type==='student') {
        //validate room number
        let roomN=document.querySelector('input[name="room"]');
        if(!validateRoom(roomN)) {
            isValid=false;
        }
    }

    // Prevent form submission if validation fails
    if (!isValid) {
        event.preventDefault(); // Prevent form submission
    }
    return isValid;
}

// Function to handle adding rows to the student or admin table
function addRowToTable(formData, type) {
    let tableBody;

    if (type === 'student') {
        tableBody = document.querySelector('#student-table-body');
    } else if (type === 'admin') {
        tableBody = document.querySelector('#admin-table-body');
    }

    if (!tableBody) {
        console.error(`${type} table body not found.`);
        return;
    }

    // Create a new row
    let newRow = document.createElement('tr');

    // Populate the row with form data
    if (type === 'student') {
        newRow.innerHTML = `
            <td><img src="${formData.image || 'assets/img/default.jpg'}" alt="${formData.firstName}" class="student-img"></td>
            <td><input type="text" class="tableinput idinput" value="${formData.StudentID}" disabled></td>
            <td><input type="text" class="tableinput name" value="${formData.firstName}" disabled></td>
            <td><input type="text" class="tableinput name Lname" value="${formData.lastName}" disabled></td>
            <td><input type="text" class="tableinput emailinput" value="${formData.email}" disabled></td>
            <td><input type="text" class="tableinput phone" value="${formData.phone}" disabled></td>
            <td><input type="text" class="tableinput roominput" value="${formData.room}" disabled></td>
            <td>
                <div class="button-container">
                    <button type="button" class="Edit"><i class="fas fa-edit"></i></button>
                    <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
                </div>
            </td>
        `;
    } else if (type === 'admin') {
        newRow.innerHTML = `
            <td><img src="${formData.image}" alt="${formData.firstName || ''}" class="student-img"></td>
            <td><input type="text" class="tableinput idinput" value="${formData.UserID}" disabled></td>
            <td><input type="text" class="tableinput name" value="${formData.firstName || ''}" disabled></td>
            <td><input type="text" class="tableinput name Lname" value="${formData.lastName || ''}" disabled></td>
            <td><input type="text" class="tableinput emailinput" value="${formData.email || ''}" disabled></td>
            <td><input type="text" class="tableinput phone" value="${formData.phone || ''}" disabled></td>
            <td>
                <select class="tableinput roleinput" disabled>
                    <option value="Maintenance" ${formData.role === "Maintenance" ? "selected" : ""}>Maintenance</option>
                    <option value="Housing" ${formData.role === "Housing" ? "selected" : ""}>Housing</option>
                    <option value="Chef" ${formData.role === "Chef" ? "selected" : ""}>Chef</option>
                    <option value="Chef" ${formData.role === "Admin" ? "selected" : ""}>Admin</option>
                </select>
            </td>
            <td>
                <div class="button-container">
                    <button type="button" class="Edit"><i class="fas fa-edit"></i></button>
                    <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
                </div>
            </td>
        `;
    }

    // Append the new row to the table body
    tableBody.appendChild(newRow);
}

// Function to handle form submissions
function handleFormSubmit(event) {
    if (!event) {
        console.error('No event passed to handleFormSubmit.');
        return;
    }
    event.preventDefault();

    const form = event.target;

    let type = form.classList.contains('admin-form') ? 'admin' : 'student';
    let formData;

    if (type === 'student') {
        formData = {
            StudentID: document.querySelector('#ID').value.trim(),
            firstName: document.querySelector('input[name="firstName"]').value.trim(),
            lastName: document.querySelector('input[name="lastName"]').value.trim(),
            email: document.querySelector('input[name="email"]').value.trim(),
            phone: document.querySelector('input[name="phone"]').value.trim(),
            room: document.querySelector('select[name="bloc"]').value + 
                document.querySelector('select[name="floor"]').value + " " + 
                document.querySelector('input[name="room"]').value.trim(),
            image: document.querySelector('#file').files[0]
                ? URL.createObjectURL(document.querySelector('#file').files[0])
                : null
        };
    } else if (type === 'admin') {
        formData = {
            UserID: document.querySelector('#ID').value.trim(),
            firstName: document.querySelector('input[name="firstName"]').value.trim(),
            lastName: document.querySelector('input[name="lastName"]').value.trim(),
            email: document.querySelector('input[name="email"]').value.trim(),
            phone: document.querySelector('input[name="phone"]').value.trim(),
            role: document.querySelector('select[name="role"]')?.value || '',
            image: document.querySelector('#file').files[0]
                ? URL.createObjectURL(document.querySelector('#file').files[0])
                : null
        };
    }

    if (validateForm(formData,type)) {
        addRowToTable(formData, type);

        // Reset the form and preview
        form.reset();
        const preview = document.querySelector('#image-preview');
        if (preview) {
            preview.style.display = 'none';
            preview.querySelector('img').src = '';
        }
    }
}

// Attach the submit event listener to both forms
document.querySelectorAll('.student-form, .admin-form').forEach(form => {
    form.addEventListener('submit', handleFormSubmit);
});
