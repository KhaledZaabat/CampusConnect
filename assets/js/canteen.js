document.addEventListener("DOMContentLoaded", () => {
    const editB = document.querySelector(".edit");
    
    // Handle Edit/Confirm toggle
    editB.addEventListener("click", function() {
        let inputFields = document.querySelectorAll("input");
        let initialValues = Array.from(inputFields).map(input => ({
            id: input.dataset.id,
            value: input.value
        }));
    
        if (editB.textContent === "Edit") {
            inputFields.forEach(input => { input.disabled = false; });
            editB.textContent = "Confirm";
        } else if (editB.textContent === "Confirm") {
            Swal.fire({
                title: "Do you want to save the changes?",
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: "Save"
            }).then((result) => {
                if (result.isConfirmed) {
                    const changes = [];
                    inputFields.forEach((input, index) => {
                        if (input.value !== initialValues[index].value) {
                            changes.push({
                                id: input.dataset.id,
                                value: input.value,
                                type: input.closest('td').previousElementSibling ? 'amount' : 'meal'
                            });
                        }
                    });
    
                    if (changes.length > 0) {
                        // Replacing Fetch with XMLHttpRequest
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', 'canteen_edit.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/json');
    
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    const data = JSON.parse(xhr.responseText);
                                    if (data.success) {
                                        inputFields.forEach(input => { input.disabled = true; });
                                        Swal.fire("Saved!", "", "success");
                                    } else {
                                        Swal.fire("Error saving changes", "", "error");
                                    }
                                } else {
                                    Swal.fire("Error saving changes", "", "error");
                                }
                            }
                        };
    
                        // Send data to the server
                        xhr.send(JSON.stringify({ changes }));
                    }
                } else {
                    inputFields.forEach((input, index) => {
                        input.value = initialValues[index].value;
                        input.disabled = true;
                    });
                }
                editB.textContent = "Edit";
            });
        }
    });
    

    // Handle Add/Delete buttons dynamically
    document.querySelectorAll(".button-container").forEach(container => {
        const inputContainer = container.closest(".input-container");
        if (!inputContainer) return;

        const row = inputContainer.closest('tr');
        const dayId = row.cells[0].getAttribute('data-day-id');
        const typeId = row.cells[1].getAttribute('data-type-id');

        const addButton = container.querySelector(".add");
        if (addButton) {
            addButton.addEventListener("click", () => {
                const inputs = inputContainer.querySelectorAll("input");
                if (inputs.length < 7) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'canteen_add.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/json');

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                const data = JSON.parse(xhr.responseText);
                                if (data.success) {
                                    const newInput = document.createElement("input");
                                    newInput.type = "text";
                                    newInput.value = "New Item";
                                    newInput.disabled = true;
                                    newInput.dataset.id = data.mealId;
                                    inputContainer.insertBefore(newInput, container);
                                    inputContainer.insertBefore(document.createElement("br"), container);
                                } else {
                                    Swal.fire("Error adding item", "", "error");
                                }
                            } else {
                                Swal.fire("Error adding item", "", "error");
                            }
                        }
                    };

                    // Send request to add the meal
                    xhr.send(JSON.stringify({ dayId, typeId, meal: "New Item", amount: "0" }));
                } else {
                    Swal.fire("Can't add more than 7!");
                }
            });
        }

        // Delete button XHR handling as well.
        const deleteButton = container.querySelector(".Delete");
        if (deleteButton) {
            deleteButton.addEventListener("click", () => {
                const inputs = inputContainer.querySelectorAll("input");
                if (inputs.length > 2) {
                    const lastInput = inputs[inputs.length - 1];
                    if (!lastInput.dataset.id) {
                        Swal.fire("Error: No meal ID found", "", "error");
                        return;
                    }

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'canteen_delete.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/json');

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                const data = JSON.parse(xhr.responseText);
                                if (data.success) {
                                    const lastBreak = inputContainer.querySelectorAll("br")[inputs.length - 1];
                                    inputContainer.removeChild(lastInput);
                                    if (lastBreak) inputContainer.removeChild(lastBreak);
                                } else {
                                    Swal.fire("Error deleting item", "", "error");
                                }
                            } else {
                                Swal.fire("Error deleting item", "", "error");
                            }
                        }
                    };

                    // Send the request to delete the meal
                    xhr.send(JSON.stringify({ id: lastInput.dataset.id }));
                } else {
                    Swal.fire("At least 2 must remain!");
                }
            });
        }
    });
});
