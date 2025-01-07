let editB = document.querySelector(".edit");
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
                    fetch('canteen_edit.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ changes })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            inputFields.forEach(input => { input.disabled = true; });
                            Swal.fire("Saved!", "", "success");
                        } else {
                            throw new Error('Update failed');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire("Error saving changes", "", "error");
                    });
                }
                editB.textContent = "Edit";
            } else {
                inputFields.forEach((input, index) => {
                    input.value = initialValues[index].value;
                    input.disabled = true;
                });
                editB.textContent = "Edit";
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", () => {
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
                    fetch('canteen_add.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ dayId, typeId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const newInput = document.createElement("input");
                            newInput.type = "text";
                            newInput.value = "New Item";
                            newInput.disabled = true;
                            newInput.dataset.id = data.mealId;
                            inputContainer.insertBefore(newInput, container);
                            inputContainer.insertBefore(document.createElement("br"), container);
                            location.reload(); // Refresh to sync with DB
                        } else {
                            throw new Error('Add failed');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire("Error adding item", "", "error");
                    });
                } else {
                    Swal.fire("Can't add more than 7!");
                }
            });
        }

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

                    fetch('canteen_delete.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: lastInput.dataset.id })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const lastBreak = inputContainer.querySelectorAll("br")[inputs.length - 1];
                            inputContainer.removeChild(lastInput);
                            if (lastBreak) inputContainer.removeChild(lastBreak);
                            location.reload(); // Refresh to sync with DB
                        } else {
                            throw new Error('Delete failed');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire("Error deleting item", "", "error");
                    });
                } else {
                    Swal.fire("At least 2 must remain!");
                }
            });
        }
    });
});