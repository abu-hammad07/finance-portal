<?php
session_start();
include_once("includes/config.php");

// Check if the signIn form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['email-username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // SQL query to select user with provided username/email and active status
    $login_query = "SELECT user_id, username, email, users.users_detail_id, role.name AS role, users.password 
        FROM users
        LEFT JOIN role ON role.role_id = users.role_id 
        WHERE (username = '$username' OR email = '$username') AND users.status = 'Active'";

    // Execute the query
    $login_result = mysqli_query($conn, $login_query);

    // Check if any row is returned
    if (mysqli_num_rows($login_result) > 0) {
        // Fetch user data
        $row = mysqli_fetch_assoc($login_result);
        // Retrieve hashed password from database
        $db_pass = $row['password'];

        // Verify entered password with hashed password
        $pass_decode = password_verify($password, $db_pass);

        // If passwords match
        if ($pass_decode) {
            // Store user data in session variables
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['UID'] = $row['user_id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['details_id'] = $row['users_detail_id'];

            // If remember me is checked, set cookies
            if (isset($_POST['rememberme'])) {
                setcookie('emailcookie', $username, time() + 86400);
                setcookie('passwordcookie', $password, time() + 86400);
            }

            // Redirect based on user role
            if ($_SESSION['role'] == 'Admin') {
                header('location: index');
            } elseif ($_SESSION['role'] == 'User') {
                header('location: index');
            } else {
                // Handle unknown role
                header('location: index');
            }
            $_SESSION['login'] = true;
            exit(); // Terminate script execution after redirection
        } else {
            // Incorrect password
            $_SESSION['incorrect'] = "Incorrect Password";
        }
    } else {
        // Incorrect email/username or account not active
        $_SESSION['incorrect'] = "Incorrect Email/Username or Account Not Active";
    }
}

// Redirect to login page with error message




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Sign In</title>
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

<body class="d2c_theme_light">
    <!-- Preloader Start -->
    <!-- <div class="preloader">
        <img src="assets/images/logo/logo.png" alt="DesignToCodes">
    </div> -->
    <!-- Preloader End -->
    <!-- Main Body-->
    <section class="d2c_login_system d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3 col-xxl-4 offset-xxl-4">
                    <div class="d2c_login_wrapper">
                        <div class="text-center mb-4">
                            <h4 class="text-capitalize">Welcome to KDA Housing Society Scheme</h4>
                        </div>
                        <!-- Alert -->
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                ' . $_SESSION['msg'] . '
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                            unset($_SESSION['msg']);
                        }
                        if (isset($_SESSION['incorrect'])) {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                ' . $_SESSION['incorrect'] . '
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                            unset($_SESSION['incorrect']);
                        }
                        ?>
                        <!-- / Alert -->
                        <form class="" method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Your Email or Username</label>
                                <input type="text" class="form-control" name="email-username" placeholder="Enter your mail or username" value="<?php if (isset($_COOKIE['emailcookie'])) {
                                                                                                                                                    echo $_COOKIE['emailcookie'];
                                                                                                                                                } ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control border-end-0" name="password" placeholder="Enter password" aria-describedby="button-addon2" value="<?php if (isset($_COOKIE['passwordcookie'])) {
                                                                                                                                                                                        echo $_COOKIE['passwordcookie'];
                                                                                                                                                                                    } ?>">
                                    <button class="btn ps-0 border-start-0 m-0" type="button" id="button-addon2"><i class="far fa-eye-slash"></i></button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="rememberme">
                                        <label class="form-check-label text-muted" for="exampleCheck1">Remember Me</label>
                                    </div>
                                </div>
                                <div class="col text-end ps-0">
                                    <a href="forgetPassword" class="d2c_link text-primary text-capitalize">Forget Password?</a>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100 text-capitalize" name="signIn">Sign In</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End:Main Body -->

    <!-- Initial  Javascript -->
    <script src="lib/jQuery/jquery-3.5.1.min.js"></script>
    <script src="lib/bootstrap_5/bootstrap.bundle.min.js"></script>
    <!-- custom js -->
    <script src="assets/js/main.js"></script>
</body>

</html>