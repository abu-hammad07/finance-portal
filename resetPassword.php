<?php
session_start();
include_once("includes/config.php");



// <!-- ========================= Reset Password page code =============================== -->
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // hash password
    $password = password_hash($password, PASSWORD_DEFAULT);

    if (isset($_GET['token'])) {
        $token = mysqli_real_escape_string($conn, $_GET['token']);


        if (!empty($password)) { // Check if password field is not empty
            $password_query = "UPDATE `users` SET `password` = '$password' WHERE `token` = '$token'";
            $password_query_run = mysqli_query($conn, $password_query);

            if ($password_query_run) {
                $_SESSION['msg'] = "Password Reset Successfully";
                header('location: login');
                exit();
            } else {
                $_SESSION['error_msg'] = "Something went wrong. Please try again.";
                header('location: resetPassword');
                exit();
            }
        } else {
            $_SESSION['error_reset_msg'] = "Password is required";
            header('location: resetPassword');
            exit();
        }
    }else{
        $_SESSION['error_reset_msg'] = "Token is not valid. $token";
        header('location: resetPassword');
        exit();
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Reset Password</title>
    <meta name="og:description" content="FinDeshY is a free financial Bootstrap dashboard template to manage your financial data easily. This free financial dashboard uses Bootstrap to provide a responsive and user-friendly interface. Whether you're a small business owner seeking insights into your company's financial health or an individual looking to simplify your personal finances, this free Bootstrap dashboard template has you covered.">
    <meta name="robots" content="index, follow">
    <meta name="og:title" property="og:title" content="FinDeshY - Free Financial Bootstrap Dashboard Template">
    <meta property="og:image" content="https://www.designtocodes.com/wp-content/uploads/2023/10/FinDeshY-Professional-Financial-Bootstrap-Dashboard-Template.jpg">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="lib/bootstrap_5/bootstrap.min.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="lib/fontawesome/css/all.min.css">
    <!-- main css -->
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- responsive css -->
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<style>
    /* Style for red border */
    .is-invalid {
        border: 1px solid red;
    }
</style>


<body class="d2c_theme_light">

    <!-- Preloader Start -->
    <!-- <div class="preloader">
        <img src="assets/images/logo/logo.png" alt="DesignToCodes">
    </div> -->
    <!-- Preloader End -->

    <section class="d2c_login_system d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3 col-xxl-4 offset-xxl-4">
                    <div class="d2c_login_wrapper">
                        <div class="text-center mb-4">
                            <h4 class="text-capitalize">Forget password?</h4>
                            <p class="text-muted">Enter the email address & we'll send you instructions to reset your password.</p>
                        </div>
                        <!-- Alert Message -->
                        <?php
                        if (isset($_SESSION['error_reset_msg'])) {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            ' . $_SESSION['error_reset_msg'] . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                            unset($_SESSION['error_reset_msg']);
                        }
                        ?>
                        <!-- / Alert Message -->
                        <form class="" id="resetPassword" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                                    <span class="input-group-text cursor-pointer" id="toggle_password"><i id="eye_icon" class="fas fa-eye-slash"></i></span>
                                </div>
                                <span class="text-danger" id="password_error"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Enter Confirm Password">
                                    <span class="input-group-text cursor-pointer" id="toggle_cpassword"><i id="c_eye_icon" class="fas fa-eye-slash"></i></span>
                                </div>
                                <span class="text-danger" id="cpassword_error"></span>
                            </div>
                            <div class="mb-3">
                                <button type="submit" id="submit_btn" name="reset-pass" class="btn btn-primary w-100 text-capitalize">Reset</button>
                            </div>
                            <a href="login" class="d2c_link_btn btn w-100 d-flex align-items-center justify-content-center text-capitalize">
                                Back To sign in
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Initial  Javascript -->
    <script src="lib/jQuery/jquery-3.5.1.min.js"></script>
    <script src="lib/bootstrap_5/bootstrap.bundle.min.js"></script>

    <!-- custom js -->
    <script src="assets/js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('resetPassword');

            // Function to validate form
            function validateForm(event) {
                event.preventDefault(); // Prevent form submission

                // Reset error messages
                document.getElementById('password_error').textContent = '';
                document.getElementById('cpassword_error').textContent = '';

                const password = document.getElementById('password').value.trim();
                const cpassword = document.getElementById('cpassword').value.trim();

                let isValid = true;

                // Check if password meets strength requirements
                if (!isStrongPassword(password)) {
                    document.getElementById('password_error').textContent = 'Password must be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, one number, and one special character.';
                    document.getElementById('password').classList.add('is-invalid');
                    isValid = false;
                } else {
                    document.getElementById('password').classList.remove('is-invalid');
                    document.getElementById('password').classList.add('is-valid');
                }

                // Check if passwords match
                if (password !== cpassword) {
                    document.getElementById('cpassword_error').textContent = 'Passwords do not match.';
                    document.getElementById('cpassword').classList.add('is-invalid');
                    isValid = false;
                } else {
                    document.getElementById('cpassword').classList.remove('is-invalid');
                    document.getElementById('cpassword').classList.add('is-valid');
                }

                if (isValid) {
                    form.submit(); // Submit the form if all inputs are valid
                }
            }

            // Event listener for form submission
            document.getElementById('submit_btn').addEventListener('click', validateForm);

            // Function to check if password is strong
            function isStrongPassword(password) {
                const strongRegex = new RegExp('^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})');
                return strongRegex.test(password);
            }

            // Event listener for toggling password visibility
            document.getElementById('toggle_password').addEventListener('click', function() {
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

            document.getElementById('toggle_cpassword').addEventListener('click', function() {
                const cpasswordInput = document.getElementById('cpassword');
                const eyeIcon = document.getElementById('c_eye_icon');
                if (cpasswordInput.type === 'password') {
                    cpasswordInput.type = 'text';
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                } else {
                    cpasswordInput.type = 'password';
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                }
            });
        });
    </script>
</body>

</html>