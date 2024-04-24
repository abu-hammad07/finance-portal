document.addEventListener('DOMContentLoaded', function () {
    // Function to validate numeric input fields
    function validateNumericInput(inputElement, errorElement) {
        inputElement.addEventListener('input', function () {
            const inputValue = inputElement.value.trim();
            const numericValue = inputValue.replace(/\D/g, ''); // Remove non-numeric characters

            if (inputValue !== numericValue) { // If non-numeric characters are present
                errorElement.textContent = 'Type only numbers';
                errorElement.style.display = 'block';
                inputElement.classList.add('is-invalid');
            } else {
                errorElement.textContent = ''; // Clear error message
                errorElement.style.display = 'none';
                inputElement.classList.remove('is-invalid');
            }

            // Update the input value with the cleaned numeric value
            inputElement.value = numericValue;
        });

        // Ensure error message is displayed on initial load if there's an invalid value
        if (inputElement.value.trim() !== inputElement.value.replace(/\D/g, '')) {
            errorElement.textContent = '';
            errorElement.style.display = 'block';
            inputElement.classList.add('is-invalid');
        }
    }

    // Validate phone number input
    const phoneInput = document.getElementById('phone');
    const phoneError = document.getElementById('phone_error');
    validateNumericInput(phoneInput, phoneError);
});



// ======================== username lowercase only  ======================
document.addEventListener('DOMContentLoaded', function () {
    const usernameInput = document.getElementById('username');
    const usernameError = document.getElementById('username_error');

    usernameInput.addEventListener('input', function () {
        let inputValue = usernameInput.value.trim();

        // Convert input value to lowercase
        inputValue = inputValue.toLowerCase();
        usernameInput.value = inputValue;

        // Check if input value is empty
        if (inputValue === '') {
            usernameError.textContent = '';
            usernameError.style.display = 'block';
            usernameInput.classList.add('is-invalid');
        }
        // Check if input value contains characters other than lowercase letters, '.', '-', '_'
        else if (!/^[a-z._-]+$/.test(inputValue)) {
            usernameError.textContent = 'Username should contain only lowercase letters, ".", "-", or "_".';
            usernameError.style.display = 'block';
            usernameInput.classList.add('is-invalid');
        } else {
            usernameError.textContent = '';
            usernameError.style.display = 'none';
            usernameInput.classList.remove('is-invalid');
        }
    });
});







// ========================================================================

// JavaScript validation code
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('add_user_form');

    // Function to validate form
    function validateForm(event) {
        event.preventDefault(); // Prevent form submission

        // Reset error messages and borders
        const errorSpans = form.querySelectorAll('.text-danger');
        errorSpans.forEach(span => {
            span.textContent = '';
        });
        const inputFields = form.querySelectorAll('.form-control');
        inputFields.forEach(field => {
            field.classList.remove('is-invalid');
        });

        let isValid = true;

        // Validate each input field
        if (!full_name.value.trim()) {
            document.getElementById('full_name_error').textContent = 'Please enter your full name.';
            full_name.classList.add('is-invalid');
            isValid = false;
        }

        if (!phone.value.trim()) {
            document.getElementById('phone_error').textContent = 'Please enter your phone number.';
            phone.classList.add('is-invalid');
            isValid = false;
        }

        if (!date_of_birth.value.trim()) {
            document.getElementById('date_of_birth_error').textContent = 'Please enter your date of birth.';
            date_of_birth.classList.add('is-invalid');
            isValid = false;
        }

        if (gender.value === '') {
            document.getElementById('gender_error').textContent = 'Please select gender.';
            gender.classList.add('is-invalid');
            isValid = false;
        }

        if (!address.value.trim()) {
            document.getElementById('address_error').textContent = 'Please enter your address.';
            address.classList.add('is-invalid');
            isValid = false;
        }

        if (user_type.value === '') {
            document.getElementById('user_type_error').textContent = 'Please select user type.';
            user_type.classList.add('is-invalid');
            isValid = false;
        }

        if (!username.value.trim()) {
            document.getElementById('username_error').textContent = 'Please enter your username.';
            username.classList.add('is-invalid');
            isValid = false;
        }

        if (!email.value.trim()) {
            document.getElementById('email_error').textContent = 'Please enter your email.';
            email.classList.add('is-invalid');
            isValid = false;
        }

        if (!password.value.trim()) {
            document.getElementById('password_error').textContent = 'Please enter your password.';
            password.classList.add('is-invalid');
            isValid = false;
        }

        // Check if any field is empty
        if (!isValidInput()) {
            isValid = false;
        }

        if (isValid) {
            form.submit(); // Submit the form if all inputs are valid
        }
    }

    // Event listener for form submission
    document.getElementById('submit_btn').addEventListener('click', validateForm);

    // Event listener for toggling password visibility
    document.getElementById('toggle_password').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye_icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        }
    });

    // Function to check if any input field is empty
    function isValidInput() {
        const inputFields = form.querySelectorAll('.form-control');
        for (let i = 0; i < inputFields.length; i++) {
            if (!inputFields[i].value.trim()) {
                return false;
            }
        }
        return true;
    }
});

