// document.addEventListener("DOMContentLoaded", () => {
//     const editB = document.querySelector(".edit");
    
//     editB.addEventListener("click", async function() {
//         const inputFields = document.querySelectorAll("input");
//         const initialValues = Array.from(inputFields).map(input => ({
//             id: input.dataset.id,
//             value: input.value
//         }));
    
//         if (editB.textContent === "Edit") {
//             inputFields.forEach(input => { input.disabled = false; });
//             editB.textContent = "Confirm";
//         } else if (editB.textContent === "Confirm") {
//             const result = await Swal.fire({
//                 title: "Do you want to save the changes?",
//                 showDenyButton: false,
//                 showCancelButton: true,
//                 confirmButtonText: "Save"
//             });

//             if (result.isConfirmed) {
//                 const changes = inputFields
//                     .filter((input, index) => input.value !== initialValues[index].value)
//                     .map(input => ({
//                         id: input.dataset.id,
//                         value: input.value,
//                         type: input.closest('td').previousElementSibling ? 'amount' : 'meal'
//                     }));

//                 if (changes.length > 0) {
//                     try {
//                         const response = await fetch('canteen_edit.php', {
//                             method: 'POST',
//                             headers: { 'Content-Type': 'application/json' },
//                             body: JSON.stringify({ changes })
//                         });
                        
//                         const data = await response.json();
//                         if (data.success) {
//                             inputFields.forEach(input => { input.disabled = true; });
//                             await Swal.fire("Saved!", "", "success");
//                         } else {
//                             await Swal.fire("Error saving changes", "", "error");
//                         }
//                     } catch (error) {
//                         await Swal.fire("Error saving changes", "", "error");
//                     }
//                 }
//             } else {
//                 inputFields.forEach((input, index) => {
//                     input.value = initialValues[index].value;
//                     input.disabled = true;
//                 });
//             }
//             editB.textContent = "Edit";
//         }
//     });

//     document.querySelectorAll(".button-container").forEach(container => {
//         const inputContainer = container.closest(".input-container");
//         if (!inputContainer) return;

//         const row = inputContainer.closest('tr');
//         const dayId = row.cells[0].getAttribute('data-day-id');
//         const typeId = row.cells[1].getAttribute('data-type-id');

//         const addButton = container.querySelector(".add");
//         if (addButton) {
//             addButton.addEventListener("click", async () => {
//                 const inputs = inputContainer.querySelectorAll("input");
//                 if (inputs.length < 7) {
//                     try {
//                         const response = await fetch('canteen_add.php', {
//                             method: 'POST',
//                             headers: { 'Content-Type': 'application/json' },
//                             body: JSON.stringify({ dayId, typeId, meal: "New Item", amount: "0" })
//                         });

//                         const data = await response.json();
//                         if (data.success) {
//                             const newInput = document.createElement("input");
//                             newInput.type = "text";
//                             newInput.value = "New Item";
//                             newInput.disabled = true;
//                             newInput.dataset.id = data.mealId;
//                             inputContainer.insertBefore(newInput, container);
//                             inputContainer.insertBefore(document.createElement("br"), container);
//                         } else {
//                             await Swal.fire("Error adding item", "", "error");
//                         }
//                     } catch (error) {
//                         await Swal.fire("Error adding item", "", "error");
//                     }
//                 } else {
//                     await Swal.fire("Can't add more than 7!");
//                 }
//             });
//         }

//         const deleteButton = container.querySelector(".Delete");
//         if (deleteButton) {
//             deleteButton.addEventListener("click", async () => {
//                 const inputs = inputContainer.querySelectorAll("input");
//                 if (inputs.length > 2) {
//                     const lastInput = inputs[inputs.length - 1];
//                     if (!lastInput.dataset.id) {
//                         await Swal.fire("Error: No meal ID found", "", "error");
//                         return;
//                     }

//                     try {
//                         const response = await fetch('canteen_delete.php', {
//                             method: 'POST',
//                             headers: { 'Content-Type': 'application/json' },
//                             body: JSON.stringify({ id: lastInput.dataset.id })
//                         });

//                         const data = await response.json();
//                         if (data.success) {
//                             const lastBreak = inputContainer.querySelectorAll("br")[inputs.length - 1];
//                             inputContainer.removeChild(lastInput);
//                             if (lastBreak) inputContainer.removeChild(lastBreak);
//                         } else {
//                             await Swal.fire("Error deleting item", "", "error");
//                         }
//                     } catch (error) {
//                         await Swal.fire("Error deleting item", "", "error");
//                     }
//                 } else {
//                     await Swal.fire("At least 2 must remain!");
//                 }
//             });
//         }
//     });
// });


document.addEventListener("DOMContentLoaded", () => {
    //debug
    console.log('dom loaded');
    const editB = document.querySelector(".edit");
    
    editB.addEventListener("click", async function() {
        console.log('Edit button clicked');
        const inputFields = document.querySelectorAll("input");
        
        if (editB.textContent === "Edit") {
            console.log('Enabling edit mode');
            inputFields.forEach(input => { input.disabled = false; });
            editB.textContent = "Confirm";
        } else if (editB.textContent === "Confirm") {
            console.log('Confirm clicked');
            const result = await Swal.fire({
                title: "Do you want to save the changes?",
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: "Save"
            });
    
            if (result.isConfirmed) {
                const changes = [];
                inputFields.forEach((input, index) => {
                    const td = input.closest('td');
                    // Get the parent row
                    const row = td.closest('tr');
                    // Get all cells in this row
                    const cells = Array.from(row.cells);
                    // Find the index of the input's container relative to visible cells
                    const isAmountColumn = cells.indexOf(td) === cells.length - 1;
            
                    console.log('Input:', {
                        value: input.value,
                        rowCells: cells.length,
                        isLastColumn: isAmountColumn,
                        dataset: input.dataset
                    });
                    
                    changes.push({
                        id: input.dataset.id,
                        value: input.value,
                        type: isAmountColumn ? 'amount' : 'meal'
                    });
                });
                console.log('Final changes array:', JSON.stringify(changes, null, 2));
    
                try {
                    const response = await fetch('canteen_edit.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ changes })
                    });
                    
                    const data = await response.json();
                    console.log('Response:', data);
                    
                    if (data.success) {
                        inputFields.forEach(input => { input.disabled = true; });
                        await Swal.fire("Saved!", "", "success");
                        location.reload();
                    } else {
                        await Swal.fire("Error saving changes", data.message || "", "error");
                    }
                } catch (error) {
                    console.error('Error:', error);
                    await Swal.fire("Error saving changes", "", "error");
                }
            }
            editB.textContent = "Edit";
        }
    });

    document.querySelectorAll(".button-container").forEach(container => {
        const inputContainer = container.closest(".input-container");
        if (!inputContainer) return;
    
        const row = inputContainer.closest('tr');
        
        // Improved day cell finding logic
        let dayCell = row.cells[0];
        if (!dayCell.hasAttribute('data-day-id')) {
            // If current row doesn't have day-id, look for previous rows
            let currentRow = row;
            while (currentRow.previousElementSibling) {
                currentRow = currentRow.previousElementSibling;
                const prevDayCell = currentRow.cells[0];
                if (prevDayCell && prevDayCell.hasAttribute('data-day-id')) {
                    dayCell = prevDayCell;
                    break;
                }
            }
        }
        
        // Get IDs with logging
        const dayId = dayCell?.dataset.dayId;
        const typeCell = row.querySelector('td[data-type-id]');
        const typeId = typeCell?.dataset.typeId;
    
        // Debug logging
        console.log('Row data:', {
            dayId: dayId,
            typeId: typeId,
            rowHTML: row.innerHTML
        });
    
        const addButton = container.querySelector(".add");
        if (addButton) {
            addButton.addEventListener("click", async () => {
                const inputs = inputContainer.querySelectorAll("input");
                if (inputs.length < 7) {
                    // Log the values before sending
                    console.log('Attempting to add item:', {
                        dayId: dayId,
                        typeId: typeId,
                        inputCount: inputs.length
                    });
    
                    if (!dayId || !typeId) {
                        await Swal.fire("Error", "Could not determine day or meal type", "error");
                        return;
                    }
    
                    try {
                        const requestData = { 
                            dayId: parseInt(dayId), 
                            typeId: parseInt(typeId), 
                            meal: "New Item", 
                            amount: "0" 
                        };
    
                        console.log('Sending request:', requestData);
    
                        const response = await fetch('canteen_add.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(requestData)
                        });
    
                        // Log raw response for debugging
                        const responseText = await response.text();
                        console.log('Raw server response:', responseText);
    
                        let data;
                        try {
                            data = JSON.parse(responseText);
                        } catch (e) {
                            console.error('Failed to parse response:', e);
                            await Swal.fire("Error", "Invalid server response", "error");
                            return;
                        }
    
                        if (data.success) {
                            const newInput = document.createElement("input");
                            newInput.type = "text";
                            newInput.value = "New Item";
                            newInput.disabled = true;
                            newInput.dataset.id = data.mealId;
                            inputContainer.insertBefore(newInput, container);
                            inputContainer.insertBefore(document.createElement("br"), container);
                            location.reload();
                        } else {
                            console.error('Server error:', data);
                            await Swal.fire("Error adding item", data.message || "Server error occurred", "error");
                        }
                    } catch (error) {
                        console.error('Request error:', error);
                        await Swal.fire("Error adding item", error.message || "Network error occurred", "error");
                    }
                } else {
                    await Swal.fire("Can't add more than 7!");
                }
            });
    
        }

        const deleteButton = container.querySelector(".Delete");
        if (deleteButton) {
            deleteButton.addEventListener("click", async () => {
                const inputs = inputContainer.querySelectorAll("input");
                if (inputs.length > 2) {
                    const lastInput = inputs[inputs.length - 1];
                    if (!lastInput.dataset.id) {
                        await Swal.fire("Error: No meal ID found", "", "error");
                        return;
                    }

                    try {
                        const response = await fetch('canteen_delete.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ id: lastInput.dataset.id })
                        });

                        const data = await response.json();
                        if (data.success) {
                            const lastBreak = inputContainer.querySelectorAll("br")[inputs.length - 1];
                            inputContainer.removeChild(lastInput);
                            location.reload(); 
                            if (lastBreak) inputContainer.removeChild(lastBreak);
                        } else {
                            await Swal.fire("Error deleting item", "", "error");
                        }
                    } catch (error) {
                        await Swal.fire("Error deleting item", "", "error");
                    }
                } else {
                    await Swal.fire("At least 2 must remain!");
                }
            });
        }
    });
});