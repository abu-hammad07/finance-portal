<?php
session_start();
include_once("includes/config.php");



// <!-- =========================Forget Password page code =============================== -->

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'includes/PHPMailer/src/Exception.php';
require 'includes/PHPMailer/src/PHPMailer.php';
require 'includes/PHPMailer/src/SMTP.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if (!empty($email)) { // Check if email field is not empty
        $email_query = "SELECT * FROM `users` WHERE `email` = '$email' AND `status` = 'Active'";
        $email_query_run = mysqli_query($conn, $email_query);

        $count_email = mysqli_num_rows($email_query_run);
        if ($count_email) {
            $userData = mysqli_fetch_array($email_query_run);
            $full_name = $userData['full_name'];
            $token = $userData['token'];
            $_SESSION['user_email'] = $userData['email'];

            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'hammadking427@gmail.com';
                $mail->Password = 'gtohfmaaanqufdbn';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('hammadking427@gmail.com', 'Abu_Hammad');
                $mail->addAddress($email, $full_name);
                $mail->Subject = 'Password Reset';
                // Include the email content from email.php
                include('email_Reset.php');
                // Replace placeholders with actual values
                $emailContent = str_replace('$full_name', $full_name, $emailContent);
                $emailContent = str_replace('$token', $token, $emailContent);
                // Set the email content as HTML
                $mail->isHTML(true);
                $mail->Body = $emailContent;
                $mail->send();
                $_SESSION['msg'] =  $email . " Email Sent & Password Reset. ";
                header('location: login');
                exit();
            } catch (Exception $e) {
                echo "Failed to send email. Error: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['forgot_msg'] = "Enter valid email";
            header('location: forgetPassword');
            exit();
        }
    } else {
        $_SESSION['forgot_msg'] = "Enter valid email";
        header('location: forgetPassword');
        exit();
    }
} else {
    // Display error message only when form is submitted
    // unset($_SESSION['forgot_msg']); // Clear any previous error message
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Forget Password</title>
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
                        if (isset($_SESSION['forgot_msg'])) {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            ' . $_SESSION['forgot_msg'] . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                            unset($_SESSION['forgot_msg']);
                        }
                        ?>
                        <!-- / Alert Message -->
                        <form class="" id="forgotPassword" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Your Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                                <span class="text-danger" id="email_error"></span>
                            </div>
                            <div class="mb-3">
                                <button type="submit" id="submit_btn" name="forget-pass" class="btn btn-primary w-100 text-capitalize">Send Mail</button>
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
            const form = document.getElementById('forgotPassword');

            // Function to validate form
            function validateForm(event) {
                event.preventDefault(); // Prevent form submission

                const email = document.getElementById('email');
                const emailError = document.getElementById('email_error');

                // Reset error message and input border
                emailError.textContent = '';
                email.classList.remove('is-invalid');

                let isValid = true;

                // Validate email
                if (!email.value.trim()) {
                    emailError.textContent = 'Please enter your email.';
                    email.classList.add('is-invalid'); // Add red border class
                    isValid = false;
                } else if (!isValidEmail(email.value.trim())) {
                    emailError.textContent = 'Please enter a valid email address.';
                    email.classList.add('is-invalid'); // Add red border class
                    isValid = false;
                }

                if (isValid) {
                    // Submit the form if all inputs are valid
                    form.submit();
                }
            }

            // Event listener for form submission
            document.getElementById('submit_btn').addEventListener('click', validateForm);

            // Function to validate email format
            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }
        });
    </script>
</body>

</html>