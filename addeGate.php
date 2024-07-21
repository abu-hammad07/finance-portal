<?php
session_start();
include_once ("includes/config.php");
include_once ("includes/function.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

// insert Function
eGateInsert();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Add e-Gate</title>
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
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
            <h4 class="mb-4 text-capitalize">Add e-Gate</h4>
            <!-- End:Title -->

            <!-- Alert -->
            <?php
            if (isset($_SESSION['success_insert_egate'])) {
                echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_insert_egate'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['success_insert_egate']);
            }
            if (isset($_SESSION['error_insert_egate'])) {
                echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_insert_egate'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['error_insert_egate']);
            }
            ?>
            <!-- / Alert -->


            <form action="" method="post" id="add_houses_form" enctype="multipart/form-data">
                <div class="card h-auto">
                    <div class="card-body">
                        <h3 class="card-header">Information</h3>
                        <hr class="my-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">House Number / Shop Number</label>
                                <select name="house_shop_id" id="house_shop_id"
                                    class="form-select form-control house-id" required>
                                    <option value="">--- Select House/Shop No ---</option>
                                    <!-- Add your house/shop options here -->
                                </select>
                            </div>
                            <div class="col-md-6" style="display:none">
                                <label class="form-label">House or Shop</label>
                                <select name="house_or_shop" id="house_or_shop"
                                    class="form-select form-control house-id" required>
                                    <option value="">--- Select House/Shop ---</option>
                                    <option value="house">House</option>
                                    <option value="shop">Shop</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Vehicle Name</label>
                                <input type="text" id="vehicle_name" name="vehicle_name" class="form-control"
                                    placeholder="Honda City" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Vehicle Number</label>
                                <input type="text" id="vehicle_number" name="vehicle_number" class="form-control"
                                    placeholder="ABC-12345" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Vehicle Color</label>
                                <input type="text" id="vehicle_color" name="vehicle_color" class="form-control"
                                    placeholder="Black" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Person Name</label>
                                <input type="text" id="person_name" name="person_name" class="form-control"
                                    placeholder="John Doe">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">CNIC Number</label>
                                <input type="text" id="cnic_number" name="cnic_number" class="form-control" placeholder="XXXXX-XXXXXXX-X">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Charges Type</label>
                                <select name="charges_type" id="charges_type" class="form-select form-control house-id"
                                    required>
                                    <option value="">--- Select Charges Type ---</option>
                                    <option value="New Card">New Card</option>
                                    <option value="Renew">Renew</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Charges</label>
                                <input type="text" id="charges" name="charges" class="form-control" placeholder="2000">
                                <!-- <select name="charges" id="charges" class="form-select form-control house-id" required>
                                    <option value="">--- Select Charges ---</option>
                                    <option value="2000">2000</option>
                                    <option value="1000">1000</option>
                                </select> -->
                            </div>

                            <!-- Button -->
                            <div class="col-md-12">
                                <button class="btn btn-primary" id="submit_btn" type="submit" name="submit">Add
                                    Now</button>
                            </div>
                        </div>
                    </div>
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
    <!-- Initial  Javascript -->
    <script src="lib/jQuery/jquery-3.5.1.min.js"></script>
    <script src="lib/bootstrap_5/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#house_shop_id").select2();
        });
    </script>

    <!-- custom js -->
    <script src="assets/js/main.js"></script>
</body>

</html>

<script>
    // $(document).ready(function() {
    //     function loadData(type, id = null) {
    //         $.ajax({
    //             url: 'ajax.php',
    //             type: 'POST',
    //             data: {
    //                 type: type,
    //                 id: id
    //             },
    //             dataType: 'html',
    //             success: function(data) {
    //                 if (type === "eGate_id_Data") {
    //                     // Clear the existing options except the placeholders
    //                     $('#house_id optgroup[label="House Number"]').empty().append('<option value="">--- Select House No ---</option>');
    //                     $('#house_id optgroup[label="Shop Number"]').empty().append('<option value="">--- Select Shop No ---</option>');

    //                     // Append the new data to the select element
    //                     $('#house_id').append(data);
    //                 }
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error('AJAX Error:', status, error);
    //             }
    //         });
    //     }

    //     loadData("eGate_id_Data");
    // });


    $(document).ready(function () {
        function loadData(type, id = null) {
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                data: {
                    type: type,
                    id: id
                },
                dataType: 'html',
                success: function (data) {
                    if (type === "eGate_id_Data") {
                        $('#house_shop_id').html(data);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }

        loadData("eGate_id_Data");

        $('#house_shop_id').change(function () {
            var selectedOption = $(this).find('option:selected').parent().attr('label');
            if (selectedOption === 'House Number') {
                $('#house_or_shop').val('house');
            } else if (selectedOption === 'Shop Number') {
                $('#house_or_shop').val('shop');
            }
        });
    });
</script>