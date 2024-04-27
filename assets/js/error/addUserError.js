document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('add_user_form');

    // Validate input fields
    function validateInput(inputElement, errorElement, validationRegex, errorMessage) {
        inputElement.addEventListener('input', function () {
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
        full_name: {
            regex: /^.{1,}$/, // At least one character
            errorMessage: 'Please enter your full name.'
        },
        phone: {
            regex: /^\d{11}$/, // 15 digits only
            errorMessage: 'Please enter a valid phone number.'
        },
        date_of_birth: {
            regex: /^.{1,}$/, // At least one character
            errorMessage: 'Please enter your date of birth.'
        },
        gender: {
            regex: /^(?=.*[a-z]).{1,}$/, // At least one character
            errorMessage: 'Please select gender.'
        },
        address: {
            regex: /^.{1,}$/, // At least one character
            errorMessage: 'Please enter your address.'
        },
        user_type: {
            regex: /^(?=.*[a-z]).{1,}$/, // At least one character
            errorMessage: 'Please select user type.'
        },
        username: {
            regex: /^[a-z._-]+$/, // Lowercase letters, '.', '-', '_'
            errorMessage: 'Username should contain only lowercase letters, ".", "-", or "_".'
        },
        email: {
            regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, // Email pattern
            errorMessage: 'Please enter a valid email address.'
        },
        password: {
            regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/, // Password strength criteria
            errorMessage: 'Password should be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.'
        }
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
    document.getElementById('submit_btn').addEventListener('click', validateForm);
});
