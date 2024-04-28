<?php
session_start();
include_once("includes/config.php");
include_once("includes/function.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

// Update Servants
serventUpdate(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Edit Servants</title>
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
    <div class="preloader">
        <!-- <img src="assets/images/logo/logo.png" alt="DesignToCodes"> -->
    </div>
    <!-- Preloader End -->

    <div class="d2c_wrapper">

        <!-- Main sidebar -->
        <?php
        include("includes/sidebar.php");
        ?>
        <!-- End:Sidebar -->

        <!-- Main Body-->
        <div class="d2c_main p-4 ps-lg-3">
            <!-- Title -->
            <h4 class="mb-4 text-capitalize">Edit Servant</h4>
            <!-- End:Title -->

            <?php
            if (isset($_GET['servant_edit_id'])) {

                $servant_edit_id = mysqli_real_escape_string($conn, $_GET['servant_edit_id']);

                $query = "SELECT * FROM servants
                    WHERE servant_id = '$servant_edit_id'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
            ?>
                        <form action="" method="POST" id="add_servant_form" enctype="multipart/form-data">
                            <div class="card h-auto">
                                <div class="card-body">
                                    <h3 class="card-header">Information</h3>
                                    <hr class="my-4">
                                    <input type="text" name="servant_id" value="<?= $row['servant_id'] ?>" hidden>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter Full Name" value="<?= $row['servant_name'] ?>">
                                            <span class="text-danger" id="full_name_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?= $row['email'] ?>">
                                            <span class="text-danger" id="email_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" value="<?= $row['phone'] ?>">
                                            <span class="text-danger" id="phone_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Gender</label>
                                            <div class="input-group">
                                                <select id="gender" name="gender" class="form-select form-control">
                                                    <option value="" <?php if ($row['gender'] == '') echo "selected"; ?>>-----</option>
                                                    <option value="Male" <?php if ($row['gender'] == 'Male') echo "selected"; ?>>Male</option>
                                                    <option value="Female" <?php if ($row['gender'] == 'Female') echo "selected"; ?>>Female</option>
                                                </select>
                                            </div>
                                            <span class="text-danger" id="gender_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Address</label>
                                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" value="<?= $row['address'] ?>">
                                            <span class="text-danger" id="address_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Status</label>
                                            <div class="input-group">
                                                <select id="status" name="status" class="form-select form-control">
                                                    <option value="" <?php if ($row['status'] == '') echo "selected"; ?>>-----</option>
                                                    <option value="Active" <?php if ($row['status'] == 'Active') echo "selected"; ?>>Active</option>
                                                    <option value="Not Active" <?php if ($row['status'] == 'Not Active') echo "selected"; ?>>Not Active</option>
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
                                <button type="submit" id="submit_btn" name="servantUpdate" class="btn btn-primary">Update</button>
                                <a href="servants" class="btn btn-danger">Back</a>
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

    <!-- Offcanvas Toggler -->
    <button class="d2c_offcanvas_toggle position-fixed top-50 start-0 translate-middle-y d-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#d2c_sidebar">
        <i class="far fa-hand-point-right"></i>
    </button>
    <!-- End:Offcanvas Toggler -->

    <script>
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
                full_name: {
                    regex: /^.{1,}$/, // At least one character
                    errorMessage: 'Please enter your full name.'
                },
                phone: {
                    regex: /^\d{11}$/, // 15 digits only
                    errorMessage: 'Please enter a valid phone number.'
                },
                gender: {
                    regex: /^(?=.*[a-z]).{1,}$/, // At least one character
                    errorMessage: 'Please select gender.'
                },
                address: {
                    regex: /^.{1,}$/, // At least one character
                    errorMessage: 'Please enter your address.'
                },
                status: {
                    regex: /^(?=.*[a-z]).{1,}$/, // At least one character
                    errorMessage: 'Please select user type.'
                },
                email: {
                    regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, // Email pattern
                    errorMessage: 'Please enter a valid email address.'
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
            document.getElementById('submit_btn').addEventListener('click', validateForm);
        });
    </script>
    <!-- Initial  Javascript -->
    <script src="lib/jQuery/jquery-3.5.1.min.js"></script>
    <script src="lib/bootstrap_5/bootstrap.bundle.min.js"></script>

    <!-- custom js -->
    <script src="assets/js/main.js"></script>
</body>

</html>