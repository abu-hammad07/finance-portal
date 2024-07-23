<?php
session_start();
include_once ("includes/config.php");
include_once ("includes/function.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

// deleteBookingeGate();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>E-Gate</title>
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
            <h4 class="mb-4 text-capitalize">E-Gate</h4>
            <!-- End:Title -->

            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card card-body h-auto d2c_projects_datatable">
                        <div class="row">
                            <div class="col-md-8 col-12">
                                <div class="col-md-4">
                                    <form class="position-relative">
                                        <input type="text" class="form-control product-search ps-5 word-spacing-2px"
                                            id="eGateSearch" onkeyup="search_eGate_Data()"
                                            placeholder="Search &nbsp;..." />
                                        <i
                                            class="fas fa-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4 col-12 text-end">
                                <a href="addeGate" class="btn btn-primary"><i class="fas fa-plus"></i> E-Gate</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert -->
            <?php
            if (isset($_SESSION['success_updated_eGate'])) {
                echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_updated_eGate'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['success_updated_eGate']);
            }
            if (isset($_SESSION['error_updated_eGate'])) {
                echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_updated_eGate'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['error_updated_eGate']);
            }
            ?>
            <!-- / Alert -->


            <div class="row">
                <div class="col-lg-12">
                    <div class="card h-auto d2c_projects_datatable">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-header">
                                    Details
                                </h4>
                            </div>
                            <div class="col-md-6 text-end card-header">
                                <div class="btn-group">
                                    <div class="me-2">
                                        <input type="month" id="eGate-month" class="form-control"
                                            onchange="load_eGate_Data()">
                                    </div>
                                    <div class="me-2">
                                        <select id="eGate-limit" class="form-control" onchange="load_eGate_Data()">
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="75">75</option>
                                            <option value="100">100</option>
                                            <option value="125">125</option>
                                        </select>
                                    </div>
                                    <div class="me-2">
                                        <select id="eGate-order" class="form-control" onchange="load_eGate_Data()">
                                            <option value="DESC">New</option>
                                            <option value="ASC">Old</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-responsive">
                                <table class="table" id="d2c_advanced_table_2">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>House/Shop Number</th>
                                            <th>Person Name</th>
                                            <th>Vehicle Number</th>
                                            <th>Charges</th>
                                            <th>Payment Type</th>
                                            <th>Print</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="eGateDetails">
                                        <!-- <tr>
                                            <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no eGate Booking data in the database.()</td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

    <!-- custom js -->
    <script src="assets/js/main.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Load data on page load with default value (10)
            load_eGate_Data();

        });

        function load_eGate_Data() {

            let eGateMonth = $("#eGate-month").val();
            let eGateLimited = $("#eGate-limit").val();
            let eGateOrder = $("#eGate-order").val();

            $.ajax({
                url: 'admin-index.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'load-eGate_booking-Data',
                    eGateLimited: eGateLimited,
                    eGateOrder: eGateOrder,
                    eGateMonth: eGateMonth
                },
                success: function (response) {
                    console.log(response);
                    // Update the result div with the loaded data
                    $("#eGateDetails").html(response.data);
                },
            });
        }
    </script>
    <!-- <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Load data on page load with default value (10)
            search_eGate_Data();

        });

        function search_eGate_Data() {

            let eGateSearch = document.getElementById('eGateSearch').value;

            $.ajax({
                url: 'admin-index.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'search-eGate-Data',
                    eGateSearch: eGateSearch
                },
                success: function (response) {
                    console.log(response);
                    // Update the result div with the loaded data
                    $("#eGateDetails").html(response.data);
                },
            });
        }
    </script> -->

</body>

</html>