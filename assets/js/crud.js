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