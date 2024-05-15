document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('add_servant_form');

    // Validate input fields
    function validateInput(inputElement, errorElement, validationRegex, errorMessage) {
        inputElement.addEventListener('input', function() {
            let inputValue = inputElement.value.trim();
            const isValid = validationRegex.test(inputValue);

            if (!isValid) {
                errorElement.textContent = errorMessage;
                errorElement.style.display = 'block';
                inputElement.classList.add('is-invalid');
            } else {
                errorElement.textContent = '';
                errorElement.style.display = 'none';
                inputElement.classList.remove('is-invalid');
            }
        });
    }

    // Validation regex patterns and error messages
    const validationRules = {
        // house_id: {
        //     regex: /^.{1,}$/, // At least one character
        //     errorMessage: 'Please select house number.'
        // },
        designation: {
            regex: /^.{1,}$/,
            errorMessage: 'Please enter designation.'
        },
        servant_fees: {
            regex: /^\d{1,}$/,
            errorMessage: 'Please enter Only Number.'
        },
    };

    // Loop through each input field and attach validation
    Object.keys(validationRules).forEach(key => {
        const inputElement = document.getElementById(key);
        const errorElement = document.getElementById(`${key}_error`);
        validateInput(inputElement, errorElement, validationRules[key].regex, validationRules[key].errorMessage);
    });

    // Function to validate form submission
    function validateForm(event) {
        event.preventDefault(); // Prevent form submission

        let isValid = true;

        // Check if any input field is empty
        Object.keys(validationRules).forEach(key => {
            const inputElement = document.getElementById(key);
            const errorElement = document.getElementById(`${key}_error`);
            const inputValue = inputElement.value.trim();
            const isValidField = validationRules[key].regex.test(inputValue);

            if (!isValidField) {
                errorElement.textContent = validationRules[key].errorMessage;
                errorElement.style.display = 'block';
                inputElement.classList.add('is-invalid');
                isValid = false;
            }
        });

        // Submit the form if all inputs are valid
        if (isValid) {
            form.submit();
        }
    }

    // Event listener for form submission
    document.getElementById('servant_btn').addEventListener('click', validateForm);
});
