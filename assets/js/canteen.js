let editB = document.querySelector(".edit");
  editB.addEventListener("click", function() {
    let inputFields = document.querySelectorAll("input");
    // Store the initial values of the inputs
    let initialValues = Array.from(inputFields).map(input => input.value);
    if (editB.textContent === "Edit") {
      // Enable all input fields
      inputFields.forEach(input => { input.disabled = false; });
      editB.textContent = "Confirm";
    } else if (editB.textContent === "Confirm") {
      // Show SweetAlert confirmation dialog
      Swal.fire({
        title: "Do you want to save the changes?",
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: "Save",
        denyButtonText: `Don't save`
      }).then((result) => {
        if (result.isConfirmed) {
          // Save changes, disable inputs, and update button text to "Edit"
          inputFields.forEach(input => { input.disabled = true; });
          Swal.fire("Saved!", "", "success");
          editB.textContent = "Edit";
        } else if (result.isDenied) {
          // Reset changes, disable inputs, and update button text to "Edit"
          inputFields.forEach((input, index) => {
            input.value = initialValues[index]; // Reset to initial values
            input.disabled = true; // Disable inputs again
          });
          Swal.fire("Changes are not saved", "", "info");
          editB.textContent = "Edit";
        }
      });
    }
  });

  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".button-container").forEach(container => {
      const inputContainer = container.closest(".input-container");
  
      if (!inputContainer) {
        console.warn("Skipped a button-container without an input-container:", container);
        return; // Skip this container if no input-container is found
      }
  
      const addButton = container.querySelector(".add");
      const deleteButton = container.querySelector(".Delete");
  
      // Add functionality
      if (addButton) {
        addButton.addEventListener("click", () => {
          const inputs = inputContainer.querySelectorAll("input");
          if (inputs.length < 7) { // Limit to 7 inputs
            const newInput = document.createElement("input");
            newInput.type = "text";
            newInput.disabled = true;
            inputContainer.insertBefore(newInput, container);
            inputContainer.insertBefore(document.createElement("br"), container);
          } else {
            Swal.fire("Can't add more than 7!");
          }
        });
      }
  
      // Delete functionality
      if (deleteButton) {
        deleteButton.addEventListener("click", () => {
          const inputs = inputContainer.querySelectorAll("input");
          const breaks = inputContainer.querySelectorAll("br");
  
          if (inputs.length > 2) { // Limit to 2 inputs minimum
            const lastInput = inputs[inputs.length - 1];
            const lastBreak = breaks[breaks.length - 1];
            inputContainer.removeChild(lastInput);
            if (lastBreak) inputContainer.removeChild(lastBreak);
          } else {
            Swal.fire("At least 2 must remain!");
          }
        });
      }
    });
  });
  