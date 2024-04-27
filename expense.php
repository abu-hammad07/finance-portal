<?php
session_start();
include_once("includes/config.php");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Expenses</title>
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
            <h4 class="mb-4 text-capitalize">Expense Charges</h4>
            <!-- End:Title -->

            <a href="addExpense.php" class="btn btn-primary mb-4"><i class="fas fa-plus"></i> Add Expense Charges</a>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card h-auto d2c_projects_datatable">
                        <div class="card-header">
                            <h6>Expense Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-responsive">
                                <table class="table" id="d2c_advanced_table_2">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 150px;">House/Unit Number</th>
                                            <th style="min-width: 150px;">Owner's Name</th>
                                            <th style="min-width: 130px;">Maintenance Charges</th>
                                            <th style="min-width: 130px;">Maintenance Period</th>
                                            <th style="min-width: 130px;">Break Down of Charges</th>
                                            <th style="min-width: 130px;">Additional Notes/Comments</th>
                                            <th style="min-width: 130px;">Added on</th>
                                            <th style="min-width: 130px;">Added By</th>
                                            <th style="min-width: 130px;">Updated on</th>
                                            <th style="min-width: 130px;">Updated By</th>
                                            <th style="min-width: 130px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>20 Mar 2023</td>
                                            <td>Jane Cooper</td>
                                            <td>Supplier</td>
                                            <td>58755</td>
                                            <td>Cash</td>
                                            <td>$4,582.39</td>
                                            <td>Supplier</td>
                                            <td>58755</td>
                                            <td>Cash</td>
                                            <td>$4,582.39</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
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
</body>
</html>
