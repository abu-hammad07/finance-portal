<?php
session_start();
include_once("includes/config.php");
include_once("includes/function.php");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
InsertEmployees();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Add Employee</title>
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
            <h4 class="mb-4 text-capitalize">Add Employee</h4>
            <!-- End:Title -->

            <!-- Alert -->
            <?php
            if (isset($_SESSION['success_added_employee'])) {
                echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_added_employee'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['success_added_employee']);
            }
            if (isset($_SESSION['error_added_employee'])) {
                echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_added_employee'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['error_added_employee']);
            }
            ?>
            <!-- / Alert -->

            <?php
            $gene_query = "SELECT `employeeID` FROM `employees` ORDER BY `employeeID` DESC";
            $gene_result = mysqli_query($conn, $gene_query);
            if (!$gene_result) {
                die("Error in SQL query: " . mysqli_error($conn));
            }
            $gene_row = mysqli_fetch_array($gene_result);
            $last_reg_no = isset($gene_row['employeeID']) ? $gene_row['employeeID'] : null;

            if (empty($last_reg_no)) {
                $auto_reg_no = "#-0001";
            } else {
                $idd = str_replace("#-", "", $last_reg_no);
                $id = str_pad($idd + 1, 4, 0, STR_PAD_LEFT);
                $auto_reg_no = "#-" . $id;
            }
            ?>

            <form action="" method="post" id="add_houses_form" enctype="multipart/form-data">
                <div class="card h-auto">
                    <div class="card-body">
                        <h3 class="card-header">Information</h3>
                        <hr class="my-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Employee ID
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" readonly name="employeeID" id="employeeID" class="form-control" placeholder="#EM001" value="<?= $auto_reg_no ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Full Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Hammad Ali" required>
                                <span class="text-danger" id="full_name_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">CNIC
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="cnic" id="cnic" class="form-control" placeholder="XXXXX-XXXXXXX-X" required>
                                <span class="text-danger" id="cnic_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Qualification
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="qualification" id="qualification" class="form-control" placeholder="MBA" required>
                                <span class="text-danger" id="qualification_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="phone_number" id="phone_number" class="form-control" placeholder="03XXXXXXXXX" required>
                                <span class="text-danger" id="phone_number_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="ep4rK@example.com" required>
                                <span class="text-danger" id="email_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Address
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="address" id="address" class="form-control" placeholder="DHA Karachi" required>
                                <span class="text-danger" id="address_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Appointment Date
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="appointment_date" id="appointment_date" class="form-control" value="<?= date('Y-m-d') ?>">
                                <span class="text-danger" id="appointment_date_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Employee Type
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="employee_type" id="employee_type" class="form-select form-control" required>
                                    <option value="">Select Type</option>
                                    <option value="permanent">permanent</option>
                                    <option value="contract">contract</option>
                                </select>
                                <span class="text-danger" id="gender_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Department
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="department" id="department" class="form-control" placeholder="IT" required>
                                <span class="text-danger" id="department_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Designation
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="designation" id="designation" class="form-control" placeholder="Manager" required>
                                <span class="text-danger" id="designation_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Salary
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="employee_salary" id="employee_salary" class="form-control" placeholder="45000" required>
                                <span class="text-danger" id="employee_salary_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Employee Image</label>
                                <input type="file" name="employee_image" id="employee_image" class="form-control">
                            </div>

                            <!-- Button -->
                            <div class="col-md-12">
                                <button class="btn btn-primary" id="submit_btn" type="submit" name="submitEmployee">Add Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- End:Main Body -->
    </div>

    <!-- Offcanvas Toggler -->
    <button class="d2c_offcanvas_toggle position-fixed top-50 start-0 translate-middle-y d-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#d2c_sidebar">
        <i class="far fa-hand-point-right"></i>
    </button>
    <!-- End:Offcanvas Toggler -->
    <!-- Start:Validation -->
    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('add_houses_form');

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
                "house-number": {
                    regex: /^\d+$/, // Only digits allowed
                    errorMessage: 'Please enter a valid house/unit number.'
                },
                "owner-name": {
                    regex: /^.{1,}$/, // At least one character
                    errorMessage: 'Please enter the owner\'s name.'
                },
                "owner-contact": {
                    regex: /^\d{11}$/, // 11 digits only
                    errorMessage: 'Please enter a valid owner\'s contact number.'
                },

                "tenants-name": {
                    regex: /^.{1,}$/, // 
                    errorMessage: 'Please enter a Tenant/s Name.'
                },
                "tenant-contact": {
                    regex: /^\d{11}$/, // 11 digits only
                    errorMessage: 'Please enter a valid Tenant\'s Contact Information.'
                },


                "occupance-status": {
                    regex: /^(owned|rented)$/, // Only allow 'owned' or 'rented'
                    errorMessage: 'Please select the occupancy status.'
                },
                "floor": {
                    regex: /^(ground|floor[1-4])$/, // Only allow 'ground' or 'floor' followed by a number from 1 to 4
                    errorMessage: 'Please select the floor.'
                },
                "property-type": {
                    regex: /^(Apartment|Duplex)$/, // Only allow 'Apartment' or 'Duplex'
                    errorMessage: 'Please select the type of property.'
                },
                "property-size": {
                    regex: /^(60 sq yards|120 sq yards)$/, // Only allow '60 sq yards' or '120 sq yards'
                    errorMessage: 'Please select the size/area of the property.'
                },
                "maintenance-charges": {
                    regex: /^\d+$/, // Only digits allowed
                    errorMessage: 'Please enter a valid monthly maintenance fee.'
                }
            };


            // Loop through each input field and attach validation
            Object.keys(validationRules).forEach(key => {
                const inputElement = document.getElementsByName(key)[0];
                const errorElement = document.getElementById(`${key}_error`);
                validateInput(inputElement, errorElement, validationRules[key].regex, validationRules[key].errorMessage);
            });

            // Function to validate form submission
            function validateForm(event) {
                event.preventDefault(); // Prevent form submission

                let isValid = true;

                // Check if any input field is empty or invalid
                Object.keys(validationRules).forEach(key => {
                    const inputElement = document.getElementsByName(key)[0];
                    const errorElement = document.getElementById(`${key}_error`);
                    const inputValue = inputElement.value.trim();
                    const isValidField = validationRules[key].regex.test(inputValue);

                    if (!isValidField) {
                        errorElement.textContent = validationRules[key].errorMessage;
                        errorElement.style.display = 'block';
                        inputElement.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        errorElement.textContent = '';
                        errorElement.style.display = 'none';
                        inputElement.classList.remove('is-invalid');
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
    </script> -->
    <!-- End:Validation -->
    <!-- Initial  Javascript -->
    <script src="lib/jQuery/jquery-3.5.1.min.js"></script>
    <script src="lib/bootstrap_5/bootstrap.bundle.min.js"></script>

    <!-- custom js -->
    <script src="assets/js/main.js"></script>
</body>

</html>