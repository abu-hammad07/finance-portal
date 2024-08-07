<?php
session_start();
include_once("includes/config.php");
include_once("includes/function.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

deleteSocietyMaintenance();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Society Maintenance</title>
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
            <h4 class="mb-4 text-capitalize">Society Maintenance</h4>
            <!-- End:Title -->

            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card card-body h-auto d2c_projects_datatable">
                        <div class="row">
                            <div class="col-md-4 col-6 col-xl-3">
                                <form class="position-relative">
                                    <input type="text" class="form-control product-search ps-5 word-spacing-2px" id="societyMaintSearch" onkeyup="search_societyMaint_Data()" placeholder="Search &nbsp;..." />
                                    <i class="fas fa-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                                </form>
                            </div>
                            <div class="col-md-8 col-xl-9 col-6 text-end">
                                <a href="addSocietyMaintenance" class="btn btn-primary"><i class="fas fa-plus"></i> Utility CHarges</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert -->
            <?php
            if (isset($_SESSION['success_updated_societyMaint'])) {
                echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_updated_societyMaint'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['success_updated_societyMaint']);
            }
            if (isset($_SESSION['error_updated_societyMaint'])) {
                echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_updated_societyMaint'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['error_updated_societyMaint']);
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
                                        <input type="month" class="form-control" id="societyMaint-date" onchange="load_societyMaint_Data()">
                                    </div>
                                    <div class="me-2">
                                        <select id="societyMaint-limit" class="form-control" onchange="load_societyMaint_Data()">
                                            <option value="15">15</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="75">75</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                    <div class="me-2">
                                        <select id="societyMaint-order" class="form-control" onchange="load_societyMaint_Data()">
                                            <option value="ASC">Old</option>
                                            <option value="DESC">New</option>
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
                                            <th>Maintenance Type</th>
                                            <th>Amount</th>
                                            <th>Due Date</th>
                                            <th>Payment Date</th>
                                            <th>Comments</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="societyMaintDetails">
                                        <!-- <tr>
                                            <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Events Booking data in the database.()</td>
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
    <button class="d2c_offcanvas_toggle position-fixed top-50 start-0 translate-middle-y d-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#d2c_sidebar">
        <i class="far fa-hand-point-right"></i>
    </button>
    <!-- End:Offcanvas Toggler -->

    <!-- Initial  Javascript -->
    <script src="lib/jQuery/jquery-3.5.1.min.js"></script>
    <script src="lib/bootstrap_5/bootstrap.bundle.min.js"></script>

    <!-- custom js -->
    <script src="assets/js/main.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Load data on page load with default value (10)
            load_societyMaint_Data();

        });

        function load_societyMaint_Data() {

            let societyMaintLimited = $("#societyMaint-limit").val();
            let societyMaintOrder = $("#societyMaint-order").val();
            let societyMaintDate = $("#societyMaint-date").val();

            $.ajax({
                url: 'admin-index.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'load-societyMaint-Data',
                    societyMaintLimited: societyMaintLimited,
                    societyMaintOrder: societyMaintOrder,
                    societyMaintDate: societyMaintDate
                },
                success: function(response) {
                    console.log(response);
                    // Update the result div with the loaded data
                    $("#societyMaintDetails").html(response.data);
                },
            });
        }
    </script>
    <!-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Load data on page load with default value (10)
            search_societyMaint_Data();

        });

        function search_societyMaint_Data() {

            let societyMaintSearch = document.getElementById('societyMaintSearch').value;

            $.ajax({
                url: 'admin-index.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'search-societyMaint-Data',
                    societyMaintSearch: societyMaintSearch
                },
                success: function(response) {
                    console.log(response);
                    // Update the result div with the loaded data
                    $("#societyMaintDetails").html(response.data);
                },
            });
        }
    </script> -->

</body>

</html>