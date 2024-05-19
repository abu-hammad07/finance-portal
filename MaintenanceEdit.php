<?php
session_start();
include_once("includes/config.php");
include "includes/function2.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
updateMaintenance();
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
            <h4 class="mb-4 text-capitalize">Add Maintenance</h4>
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
                        <?php
                        if (isset($_GET['maintenance_edit_id'])) {
                            $edit_id = mysqli_real_escape_string($conn, $_GET['maintenance_edit_id']);
                            $edit_query = "SELECT maintenance_payments.*, houses.house_number, shops.shop_number 
                            FROM maintenance_payments
                            LEFT JOIN houses ON maintenance_payments.house_id = houses.house_id
                            LEFT JOIN shops ON maintenance_payments.shop_id = shops.shop_id
                            WHERE maintenance_payments.maintenance_id = '$edit_id'";
                            $edit_result = mysqli_query($conn, $edit_query);

                            if (mysqli_num_rows($edit_result) > 0) {
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($edit_result)) {
                        ?>
                                    <div class="row g-3">
                                        <input type="text" hidden name="maintenace_edit_id" value="<?= $row['maintenance_id'] ?>" class="form-control" placeholder="Penalty Charges" required>

                                        <div class="col-md-6" style="display:none">
                                            <label class="form-label">House or Shop</label>
                                            <select name="house_or_shop" id="house_or_shop" class="form-select form-control house-id">
                                                <option value="<?= $row['house_or_shop'] ?>"><?= $row['house_or_shop'] ?></option>
                                                <option value="house">House</option>
                                                <option value="shop">Shop</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">House Number / Shop Number</label>
                                            <select name="house_shop_id" id="house_shop_id" class="form-select form-control house-id">
                                                <?php
                                                if ($row['house_or_shop'] == 'house') {
                                                    echo '<option value="' . $row['house_id'] . '">' . $row['house_number'] . '</option>';
                                                } elseif ($row['house_or_shop'] == 'shop') {
                                                    echo '<option value="' . $row['shop_id'] . '">' . $row['shop_number'] . '</option>';
                                                }
                                                ?> <!-- Options will be loaded here via AJAX -->
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Maintenance Month</label>
                                            <select class="form-select" id="monthData" required name="maintenace_month">
                                                <option value="<?= $row['maintenance_month'] ?>"><?= $row['maintenance_month'] ?></option>
                                                <!-- Options will be loaded here via AJAX -->
                                            </select>
                                            <span class="text-danger" id="Penal-Cnic_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Maintenance Charges</label>
                                            <input type="text" name="maintenace_charges" class="form-control" value="<?= $row['maintenance_peyment'] ?>" placeholder="Penalty Charges" required>
                                            <span class="text-danger" id="Penal-charges_error"></span>
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" id="submit_btn" type="submit" name="submit">Update Now</button>
                                        </div>
                                    </div>
                        <?php
                                }
                            } else {
                                echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    No House Found.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                            }
                        }
                        ?>
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
    <script>
        $(document).ready(function() {
            $("#house_shop_id").select2();
        });
    </script>
    <!-- custom js -->
    <script src="assets/js/main.js"></script>
    <script>
        $(document).ready(function() {
            function loadData(type, id = null) {
                $.ajax({
                    url: 'ajax.php',
                    type: 'POST',
                    data: {
                        type: type,
                        id: id
                    },
                    dataType: 'html',
                    success: function(data) {
                        if (type === "eGate_id_Data1") {
                            $('#house_shop_id').html(data);
                        } else if (type === "month_data") {
                            $('#monthData').html(data);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            }

            loadData("eGate_id_Data1");

            $('#house_shop_id').change(function() {
                var houseShopId = $(this).val();
                loadData("month_data", houseShopId);
            });

            $('#house_shop_id').change(function() {
                var selectedOption = $(this).find('option:selected').parent().attr('label');
                if (selectedOption === 'House Number') {
                    $('#house_or_shop').val('house');
                } else if (selectedOption === 'Shop Number') {
                    $('#house_or_shop').val('shop');
                }
            });
        });
    </script>

</body>

</html>