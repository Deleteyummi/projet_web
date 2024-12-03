document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelectorAll("form");

    forms.forEach((form) => {
        form.addEventListener("submit", function (event) {
            // Clear previous error messages
            clearErrors(form);

            // Validate form
            const isValid = validateForm(form);

            if (!isValid) {
                event.preventDefault(); // Prevent form submission if there are errors
            }
        });
    });

    function validateForm(form) {
        let isValid = true;

        // Get fields
        const title = form.querySelector("#title");
        const content = form.querySelector("#content");
        const author = form.querySelector("#author");
        const createdAt = form.querySelector("#created_at");
        const status = form.querySelector("#status");

        // Validate title: 6-16 characters, no numbers
        const titleRegex = /^[a-zA-Z\s]{6,16}$/;
        if (!title.value.trim() || !titleRegex.test(title.value)) {
            showError(title, "Title must be 6-16 characters and contain no numbers.");
            isValid = false;
        }

        // Validate content: At least 10 characters
        if (!content.value.trim() || content.value.trim().length < 10) {
            showError(content, "Content must be at least 10 characters long.");
            isValid = false;
        }

        // Validate author: Non-empty, no numbers
        const authorRegex = /^[a-zA-Z\s]+$/;
        if (!author.value.trim() || !authorRegex.test(author.value)) {
            showError(author, "Author name must contain only letters and cannot be empty.");
            isValid = false;
        }

        // Validate created_at: Non-empty and valid date
        if (!createdAt.value.trim()) {
            showError(createdAt, "Please select a valid date.");
            isValid = false;
        }

        // Validate status: Must be selected
        if (!status.value.trim()) {
            showError(status, "Please select a status.");
            isValid = false;
        }

        return isValid;
    }

    function showError(input, message) {
        // Create error message element
        const error = document.createElement("small");
        error.className = "error-message";
        error.textContent = message;
        error.style.color = "red";
        error.style.fontSize = "0.9em";
        error.style.marginTop = "5px";

        // Add error message after the input field
        input.style.borderColor = "red";
        input.insertAdjacentElement("afterend", error);
    }

    function clearErrors(form) {
        // Remove all error messages
        const errors = form.querySelectorAll(".error-message");
        errors.forEach((error) => error.remove());

        // Reset input field styles
        const inputs = form.querySelectorAll("input, textarea, select");
        inputs.forEach((input) => (input.style.borderColor = "#ccc"));
    }
});
