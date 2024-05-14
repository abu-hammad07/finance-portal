<?php
session_start();
include_once("includes/config.php");
include "includes/function.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
addHouse();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Add House</title>
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
            <h4 class="mb-4 text-capitalize">Add House</h4>
            <!-- End:Title -->

            <!-- Alert -->
            <?php
            if (isset($_SESSION['success_message_house'])) {
                echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_message_house'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['success_message_house']);
            }
            if (isset($_SESSION['error_message_house'])) {
                echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_message_house'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['error_message_house']);
            }
            ?>
            <!-- / Alert -->

            <form action="" method="post" id="add_houses_form">
                <div class="card h-auto">
                    <div class="card-body">
                        <h3 class="card-header">Information</h3>
                        <hr class="my-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">House/Unit Number</label>
                                <input type="number" name="house-number" class="form-control" placeholder="Enter House/Unit Number" required>
                                <span class="text-danger" id="house-number_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Owner's Name</label>
                                <input type="text" name="owner-name" class="form-control" placeholder="Enter Owner's Name" required>
                                <span class="text-danger" id="owner-name_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Owner's Contact Number</label>
                                <input type="number" name="owner-contact" class="form-control" placeholder="03XXXXXXXXX" required>
                                <span class="text-danger" id="owner-contact_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Owner's CINC</label>
                                <input type="number" name="owner-cinc" class="form-control" placeholder="XXXXX-XXXXXXX-X" required>
                                <span class="text-danger" id="owner-cinc_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="owner" class="form-label">Occupancy Status</label>
                                <select id="owner" name="occupance-status" class="form-select form-control">
                                    <option value="">-----</option>
                                    <option value="owned">Owned</option>
                                    <option value="rented">Rented</option>
                                </select>
                                <span class="text-danger" id="occupance-status_error"></span>
                            </div>
                            <div class="col-md-6 ">
                                <label for="floor" class="form-label">Floor</label>
                                <select id="floor" name="floor" class="form-select form-control">
                                    <option value="">-----</option>
                                    <option value="ground">Ground</option>
                                    <option value="floor1">Floor 1</option>
                                    <option value="floor2">Floor 2</option>
                                    <option value="floor3">Floor 3</option>
                                    <option value="floor4">Floor 4</option>
                                </select>
                                <span class="text-danger" id="floor_error"></span>
                            </div>
                            <div class="col-md-6 ">
                                <label for="property-type" class="form-label">Type of Property</label>
                                <select id="property-type" name="property-type" class="form-select form-control">
                                    <option value="">-----</option>
                                    <option value="Apartment">Apartment</option>
                                    <option value="Duplex">Duplex</option>
                                </select>
                                <span class="text-danger" id="property-type_error"></span>
                            </div>
                            <div class="col-md-6 ">
                                <label class="form-label">Size/Area of the Property</label>
                                <select id="size" name="property-size" class="form-select form-control">
                                    <option value="">-----</option>
                                    <option value="60 sq yards">60 sq yards</option>
                                    <option value="120 sq yards">120 sq yards</option>
                                </select>
                                <span class="text-danger" id="property-size_error"></span>
                            </div>
                            <div class="col-md-6 ">
                                <label class="form-label">Monthly Maintenance Fee</label>
                                <input name="maintenance-charges" type="number" class="form-control" placeholder="Enter Monthly Maintenance Fee" required>
                                <span class="text-danger" id="maintenance-charges_error"></span>
                            </div>

                            <!-- Button -->
                            <div class="col-md-12">
                                <button class="btn btn-primary" id="submit_btn" type="submit" name="submit">Add Now</button>
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