<?php
session_start();
include_once("includes/config.php");
include_once("includes/function.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

servantSubmit();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Add Servants</title>
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
        include("includes/sidebar.php");
        ?>
        <!-- End:Sidebar -->

        <!-- Main Body-->
        <div class="d2c_main p-4 ps-lg-3">
            <!-- Title -->
            <h4 class="mb-4 text-capitalize">Add Servant</h4>
            <!-- End:Title -->

            <!-- Alert -->
            <?php
            if (isset($_SESSION['success_message_servant'])) {
                echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_message_servant'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['success_message_servant']);
            }
            if (isset($_SESSION['error_message_servant'])) {
                echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_message_servant'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['error_message_servant']);
            }
            ?>
            <!-- / Alert -->


            <form action="" method="post" id="add_servant_form" enctype="multipart/form-data">
                <div class="card h-auto">
                    <div class="card-body">
                        <h3 class="card-header">Information</h3>
                        <hr class="my-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">House/Unit Number</label>
                                <select name="house_id" id="house_id" class="form-select form-control house-id" required>
                                    <option value="">--- Select House No ---</option>
                                </select>
                                <span class="text-danger" id="house_id_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Owner's Name</label>
                                <select id="owner_name" class="form-select form-control">
                                    <!-- <option value="">--- Select House No ---</option> -->
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Owner's Contact</label>
                                <select id="owner_contact" class="form-select form-control">
                                    <!-- <option value="">--- Select House No ---</option> -->
                                </select>
                            </div>
                            <div class="col-md-6 ">
                                <label class="form-label">Designation</label>
                                <input type="text" id="designation" name="designation" class="form-control" placeholder="Enter Designation" required>
                                <span class="text-danger" id="designation_error"></span>
                            </div>

                            <div class="col-md-6 ">
                                <label class="form-label">Fees</label>
                                <input type="number" id="servant_fees" name="servant_fees" class="form-control" placeholder="999" required>
                                <span class="text-danger" id="servant_fees_error"></span>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Payment Type</label>
                                <select class="form-select form-control" id="pymentType" required name="pymentType">
                                    <option value="">Select Payment Type</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank">Bank</option>
                                </select>
                            </div>

                            <!-- Button -->
                            <div class="col-md-12">
                                <button class="btn btn-primary" id="servant_btn" type="submit" name="submit">Add Now</button>
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
    <button class="d2c_offcanvas_toggle position-fixed top-50 start-0 translate-middle-y d-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#d2c_sidebar">
        <i class="far fa-hand-point-right"></i>
    </button>
    <!-- End:Offcanvas Toggler -->

    <!-- Initial  Javascript -->
    <script src="lib/jQuery/jquery-3.5.1.min.js"></script>
    <script src="lib/bootstrap_5/bootstrap.bundle.min.js"></script>
    <!-- custom js -->
    <script src="assets/js/main.js"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#house_id").select2();
        });
    </script>
    <!-- <script src="./assets/js/error/servant.js"></script> -->
</body>

</html>

<script>
    $(document).ready(function() {
        function loadData(type, id) {
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                data: {
                    type: type,
                    id: id
                },
                dataType: 'html',
                success: function(data) {
                    if (type === "house_id_Data") {
                        $('#house_id').append(data);
                    } else if (type === "owner_name_Data") {
                        $('#owner_name').html(data);
                    } else if (type === "owner_contact_Data") {
                        $('#owner_contact').html(data);
                    }
                }
            });
        }

        loadData("house_id_Data");

        $("#house_id").on("change", function() {
            var customer = $("#house_id").val();
            if (customer != "") {
                loadData("owner_name_Data", customer);
            } else {
                $('#owner_name').html("");
            }
        });
        $("#house_id").on("change", function() {
            var customer = $("#house_id").val();
            if (customer != "") {
                loadData("owner_contact_Data", customer);
            } else {
                $('#owner_contact').html("");
            }
        });
    });
</script>