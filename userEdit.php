<?php
session_start();
include_once ("includes/config.php");
include_once ("includes/function.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
userEdit();
?>


<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">
    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Edit User</h4>
    <!-- End:Title -->

    <?php
    if (isset($_GET['user_edit_id'])) {

        $user_view_id = mysqli_real_escape_string($conn, $_GET['user_edit_id']);

        $query = "SELECT user_id, username, email, users_detail.users_detail_id, users_detail.full_name, 
                users_detail.Phone, users_detail.address, users_detail.gender, users_detail.date_of_birth, 
                role.name as role, role.role_id
                    FROM users 
                    LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
                    LEFT JOIN role ON users.role_id = role.role_id
                    WHERE users.user_id = '$user_view_id'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {



                ?>
                <form action="" method="POST" id="add_user_form" enctype="multipart/form-data">
                    <div class="card h-auto">
                        <div class="card-body">
                            <h3 class="card-header">Information</h3>
                            <hr class="my-4">
                            <div class="row g-3">
                                <input type="text" hidden name="users_detail_id" value="<?= $row['users_detail_id'] ?>">
                                <input type="text" hidden name="user_id" value="<?= $row['user_id'] ?>">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name"
                                        placeholder="Enter Full Name" value="<?= $row['full_name'] ?>">
                                    <span class="text-danger" id="full_name_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number"
                                        value="<?= $row['Phone'] ?>">
                                    <span class="text-danger" id="phone_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date Of Birth</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                        placeholder="Enter Date Of Birth" value="<?= $row['date_of_birth'] ?>">
                                    <span class="text-danger" id="date_of_birth_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Gender</label>
                                    <div class="input-group">
                                        <select id="gender" name="gender" class="form-select form-control">
                                            <option value="Male" <?php if ($row['gender'] == "Male")
                                                echo "selected"; ?>>Male</option>
                                            <option value="Female" <?php if ($row['gender'] == "Female")
                                                echo "selected"; ?>>Female
                                            </option>
                                        </select>
                                    </div>
                                    <span class="text-danger" id="gender_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address"
                                        value="<?= $row['address'] ?>">
                                    <span class="text-danger" id="address_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">User Type</label>
                                    <div class="input-group">
                                        <select id="user_type" name="user_type" class="form-select form-control">
                                            <option value="<?= $row['role_id'] ?>"><?= $row['role'] ?></option>
                                        </select>
                                    </div>
                                    <span class="text-danger" id="user_type_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Login -->
                    <div class="card h-auto mt-4">
                        <div class="card-body">
                            <h3 class="card-header">Login</h3>
                            <hr class="my-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="Enter Username" value="<?= $row['username'] ?>">
                                    <span class="text-danger" id="username_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email"
                                        value="<?= $row['email'] ?>">
                                    <span class="text-danger" id="email_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- submit btn -->
                    <div class="mt-3">
                        <button type="submit" id="submit_btn" name="userUpdate" class="btn btn-primary">Update</button>
                        <a href="userDetails" class="btn btn-danger">Back</a>
                    </div>
                </form>
                <?php
            }
        } else {
            header('location: 404');
            exit();
        }
    }
    ?>


    <!-- End:submit btn -->
</div>
<!-- End:Main Body -->
</div>



<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->


<script>
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

        // Toggle password visibility
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
</script>
