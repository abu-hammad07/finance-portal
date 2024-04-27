<?php
session_start();
include_once ("includes/config.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

// ========================= Insert User =========================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $role_id = mysqli_real_escape_string($conn, $_POST['status']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Get email & password from form
    $_SESSION['show_email'] = $email;
    $_SESSION['show_password'] = $password;

    // hash password
    $pass = password_hash($password, PASSWORD_DEFAULT);
    // token generate
    $token = bin2hex(random_bytes(50));
    // Get the current date and time
    $created_date = date('Y-m-d');
    // Get the user's ID and name
    $created_by = $_SESSION['UID'];


    // check duplicate email
    $check_email = "SELECT * FROM `servants` WHERE `email` = '$email'";
    $check_username_res = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($check_username_res) > 0) {
        $_SESSION['error_message_user'] = "Email already exists $username";
        header("location: addServant");
        exit();
    } else {

        // Upload image
        $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], 'media/images/' . $image);

        // Insert data into user_details table first
        $insert_details = "INSERT INTO `servants`(`servant_name`, `phone`, `address`, `gender`, `email`, `image`, `added_by`, `added_on`
            ) VALUES (
                '$full_name', '$phone', '$address', '$gender', '$email', '$image', '$created_date', '$created_by'
            )";

        $insert_udetails_res = mysqli_query($conn, $insert_details);

        if ($insert_udetails_res) {

            $_SESSION['success_message_user'] = "$username Successfully Added";
            header('location: addServant');
            exit();

        } else {
            $_SESSION['error_message_user'] = "$username user not added";
            header('location: addServant');
            exit();
        }

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
    <title>Add Servants</title>
    <meta name="og:description"
        content="FinDeshY is a free financial Bootstrap dashboard template to manage your financial data easily. This free financial dashboard uses Bootstrap to provide a responsive and user-friendly interface. Whether you're a small business owner seeking insights into your company's financial health or an individual looking to simplify your personal finances, this free Bootstrap dashboard template has you covered.">
    <meta name="robots" content="index, follow">
    <meta name="og:title" property="og:title" content="FinDeshY - Free Financial Bootstrap Dashboard Template">
    <meta property="og:image"
        content="https://www.designtocodes.com/wp-content/uploads/2023/10/FinDeshY-Professional-Financial-Bootstrap-Dashboard-Template.jpg">
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
    <div class="preloader">
        <!-- <img src="assets/images/logo/logo.png" alt="DesignToCodes"> -->
    </div>
    <!-- Preloader End -->

    <div class="d2c_wrapper">

        <!-- Main sidebar -->
        <?php
        include ("includes/sidebar.php");
        ?>
        <!-- End:Sidebar -->

        <!-- Main Body-->
        <div class="d2c_main p-4 ps-lg-3">
            <!-- Title -->
            <h4 class="mb-4 text-capitalize">Add Servant</h4>
            <!-- End:Title -->

            <!-- Alert -->
            <?php
            if (isset($_SESSION['success_message_user'])) {
                echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_message_user'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['success_message_user']);
            }
            if (isset($_SESSION['error_message_user'])) {
                echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_message_user'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['error_message_user']);
            }
            ?>
            <!-- / Alert -->


            <form action="" method="POST" id="add_user_form" enctype="multipart/form-data">
                <div class="card h-auto">
                    <div class="card-body">
                        <h3 class="card-header">Information</h3>
                        <hr class="my-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name"
                                    placeholder="Enter Full Name" required>
                                <span class="text-danger" id="full_name_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter Email" required>
                                <span class="text-danger" id="email_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="Enter Phone Number" required>
                                <span class="text-danger" id="phone_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <div class="input-group">
                                    <select id="gender" name="gender" class="form-select form-control">
                                        <option value="">-----</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <span class="text-danger" id="gender_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Enter Address" required>
                                <span class="text-danger" id="address_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <div class="input-group">
                                    <select id="status" name="status" class="form-select form-control">
                                        <option value="">-----</option>
                                        <option value="Active">Active</option>
                                        <option value="Not Active">Not Active</option>
                                    </select>
                                </div>
                                <span class="text-danger" id="status_error"></span>
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
                    <button type="submit" id="submit_btn" class="btn btn-primary">Add</button>
                </div>
            </form>


            <!-- End:submit btn -->
        </div>
        <!-- End:Main Body -->
    </div>

    <!-- Offcanvas Toggler -->
    <button class="d2c_offcanvas_toggle position-fixed top-50 start-0 translate-middle-y d-block d-lg-none"
        type="button" data-bs-toggle="offcanvas" data-bs-target="#d2c_sidebar">
        <i class="far fa-hand-point-right"></i>
    </button>
    <!-- End:Offcanvas Toggler -->

    <!-- <script src="assets/js/error/addUserError.js"></script> -->
    <!-- Initial  Javascript -->
    <script src="lib/jQuery/jquery-3.5.1.min.js"></script>
    <script src="lib/bootstrap_5/bootstrap.bundle.min.js"></script>

    <!-- custom js -->
    <script src="assets/js/main.js"></script>
</body>

</html>