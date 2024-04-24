<?php
session_start();
include_once("includes/config.php");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

// When the admin logs in, insert the login time into the users_detail table in the database
if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    $user_id = $_SESSION['UID'];

    // Execute the update query directly
    $query = "UPDATE `users_detail` SET `login_time` = NOW() 
    WHERE `users_detail_id` = (SELECT users_detail_id FROM `users` WHERE user_id = '$user_id')";
    
    $result = mysqli_query($conn, $query);

    if (!$result) {
        $_SESSION['index_error'] = "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Dashboard</title>
    <meta name="og:description" content="FinDeshY is a free financial Bootstrap dashboard template to manage your financial data easily. This free financial dashboard uses Bootstrap to provide a responsive and user-friendly interface. Whether you're a small business owner seeking insights into your company's financial health or an individual looking to simplify your personal finances, this free Bootstrap dashboard template has you covered.">
    <meta name="robots" content="index, follow">
    <meta name="og:title" property="og:title" content="FinDeshY - Free Financial Bootstrap Dashboard Template">
    <meta property="og:image" content="https://www.designtocodes.com/wp-content/uploads/2023/10/FinDeshY-Professional-Financial-Bootstrap-Dashboard-Template.jpg">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="./lib/bootstrap_5/bootstrap.min.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="./lib/fontawesome/css/all.min.css">
    <!-- main css -->
    <link rel="stylesheet" href="./assets/css/global.css">
    <link rel="stylesheet" href="./assets/css/style.css">

    <!-- responsive css -->
    <link rel="stylesheet" href="./assets/css/responsive.css">
</head>

<body class="d2c_theme_light">
    <!-- Preloader Start -->
    <div class="preloader">
        <!-- <img src="./assets/images/logo/logo.png" alt="DesignToCodes"> -->
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
            <h4 class="mb-4 text-capitalize">Dashboard</h4>
            <!-- End:Title -->

            <!-- Alert -->
            <?php
            if (isset($_SESSION['index_error'])) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                ' . $_SESSION['index_error'] . '
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                unset($_SESSION['index_error']);
            }
            ?>
            <!-- End:Alert -->

            <div class="row d2c_home_card">
                <div class="col-xxl-9">
                    <div class="row">
                        <!-- Visa Card -->

                        <!-- Income Card -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-8">
                                            <div class="btn rounded shadow text-primary">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-end">
                                            <div class="dropdown">
                                                <button class="btn px-1 d2c_dropdown_btn" type="button" id="dropdownMenuButton11" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu d2c_dropdown" aria-labelledby="dropdownMenuButton11">
                                                    <li><a class="dropdown-item" href="#">Premium</a></li>
                                                    <li><a class="dropdown-item" href="#">Regular</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <h6>Income</h6>
                                    <p>Last Month</p>

                                    <h4 class="text-primary mb-0">$24,977.05</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Total Spent -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-8">
                                            <div class="btn rounded shadow text-primary">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-end">
                                            <div class="dropdown">
                                                <button class="btn px-1 d2c_dropdown_btn" type="button" id="dropdownMenuButton11" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu d2c_dropdown" aria-labelledby="dropdownMenuButton11">
                                                    <li><a class="dropdown-item" href="#">Premium</a></li>
                                                    <li><a class="dropdown-item" href="#">Regular</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <h6>Total Spent</h6>
                                    <p>Last Month</p>

                                    <h4 class="text-primary mb-0">$16,547.59</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Transactions -->
                        <div class="col-xl-4 col-md-6 mb-4 ">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-8">
                                            <div class="btn rounded shadow text-primary">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-end">
                                            <div class="dropdown">
                                                <button class="btn px-1 d2c_dropdown_btn" type="button" id="dropdownMenuButton11" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu d2c_dropdown" aria-labelledby="dropdownMenuButton11">
                                                    <li><a class="dropdown-item" href="#">Premium</a></li>
                                                    <li><a class="dropdown-item" href="#">Regular</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <h6>Transactions</h6>
                                    <p>Last Month</p>

                                    <h4 class="text-primary mb-0">$90,548.23</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Total Cashback -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-8">
                                            <div class="btn rounded shadow text-primary">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-end">
                                            <div class="dropdown">
                                                <button class="btn px-1 d2c_dropdown_btn" type="button" id="dropdownMenuButton11" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu d2c_dropdown" aria-labelledby="dropdownMenuButton11">
                                                    <li><a class="dropdown-item" href="#">Premium</a></li>
                                                    <li><a class="dropdown-item" href="#">Regular</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <h6>Total Cashback</h6>
                                    <p>Last Month</p>

                                    <h4 class="text-primary mb-0">$8,548.23</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Investment -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-8">
                                            <div class="btn rounded shadow text-primary">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-end">
                                            <div class="dropdown">
                                                <button class="btn px-1 d2c_dropdown_btn" type="button" id="dropdownMenuButton11" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu d2c_dropdown" aria-labelledby="dropdownMenuButton11">
                                                    <li><a class="dropdown-item" href="#">Premium</a></li>
                                                    <li><a class="dropdown-item" href="#">Regular</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <h6>Investment</h6>
                                    <p>Last Month</p>

                                    <h4 class="text-primary mb-0">$22,548.23</h4>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Budget Goals -->
                <div class="col-xxl-3 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Budget Goals</h6>
                        </div>
                        <div class="card-body mt-3">
                            <!-- Facebook Ads -->
                            <div class="card mb-4">
                                <div class="card-body d-flex align-items-center">
                                    <div class="d2c_icon btn bg-primary text-primary rounded-circle bg-opacity-10">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <div class="flex-1 w-100 ms-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            Facebook Ads <span class="text-end"><span class="fw-bold">75</span> / 100</span>
                                        </div>
                                        <div class="progress bg-primary bg-opacity-10">
                                            <div class="progress-bar bg-primary rounded" role="progressbar" aria-label="Basic example" style="width: 75%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Youtube Premium -->
                            <div class="card mb-4">
                                <div class="card-body d-flex align-items-center">
                                    <div class="d2c_icon btn bg-info text-info rounded-circle bg-opacity-10">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <div class="flex-1 w-100 ms-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            Youtube Premium <span class="text-end"><span class="fw-bold">50</span> / 100</span>
                                        </div>
                                        <div class="progress bg-info bg-opacity-10">
                                            <div class="progress-bar bg-info rounded" role="progressbar" aria-label="Basic example" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Skype Premium -->
                            <div class="card">
                                <div class="card-body d-flex align-items-center">
                                    <div class="d2c_icon btn bg-danger text-danger rounded-circle bg-opacity-10">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <div class="flex-1 w-100 ms-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            Skype Premium <span class="text-end"><span class="fw-bold">30</span> / 100</span>
                                        </div>
                                        <div class="progress bg-danger bg-opacity-10">
                                            <div class="progress-bar bg-danger rounded" role="progressbar" aria-label="Basic example" style="width: 30%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6 mb-4">
                    <!-- Balance Summary -->
                    <div class="card h-100">
                        <div class="card-header">
                            <h6>Balance Summary</h6>
                            <h4 class="text-primary">$12,389.54</h4>
                        </div>
                        <div class="card-body">
                            <div id="d2c_lineChart"></div>
                        </div>
                    </div>
                    <!-- End:Balance Summary -->
                </div>

                <div class="col-xl-6 mb-4">
                    <!-- Balance -->
                    <div class="card">
                        <div class="card-header">
                            <h6>Balance</h6>
                            <h4 class="text-primary">$12,389.54</h4>
                        </div>
                        <div class="card-body">
                            <div id="d2c_barChart"></div>
                        </div>
                    </div>
                    <!-- End:Balance -->
                </div>

                <div class="col-xl-6 mb-4">
                    <!-- All Expanses -->
                    <div class="card">
                        <div class="card-header">
                            <h6>All Expanses</h6>
                            <div class="row">
                                <div class="col">
                                    <p class="mb-0">Daily</p>
                                    <p>$678.09</p>
                                </div>
                                <div class="col">
                                    <p class="mb-0">Weekly</p>
                                    <p>$1,904.21</p>
                                </div>
                                <div class="col">
                                    <p class="mb-0">Monthly</p>
                                    <p>$29,904.21</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="d2c_dashboard_radialBarChart"></div>
                        </div>
                    </div>
                    <!-- End:All Expanses -->
                </div>

                <div class="col-xl-6 mb-4">
                    <!-- Market Cap -->
                    <div class="card h-100">
                        <div class="card-header">
                            <h6>Market Cap</h6>
                        </div>
                        <div class="card-body">
                            <div id="d2c_dashboard_donutChart"></div>
                        </div>
                    </div>
                    <!-- End:Market Cap -->
                </div>

                <div class="col-xl-6 mb-4">
                    <!-- investment bar chart -->
                    <div class="card">
                        <div class="card-header">
                            <h6>Investment</h6>
                            <h4 class="text-primary">$78,537.48</h4>
                        </div>
                        <div class="card-body">
                            <div id="d2c_investment_bar_chart"></div>
                        </div>
                    </div>
                    <!-- End:investment -->
                </div>

                <div class="col-xl-6 mb-4">
                    <!-- Balance -->
                    <div class="card">
                        <div class="card-header">
                            <h6>Stock Watch list</h6>
                            <h4 class="text-primary">$8,537.48</h4>
                        </div>
                        <div class="card-body">
                            <div id="d2c_areaChart"></div>
                        </div>
                    </div>
                    <!-- End:Balance -->
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-4">
                    <!-- Basic Table -->
                    <div class="card h-auto d2c_projects_datatable">
                        <div class="card-header">
                            <h6>Advance Table</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="d2c_advanced_table">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 170px;">Date</th>
                                            <th style="min-width: 170px;">Customer</th>
                                            <th style="min-width: 130px;">Group Name</th>
                                            <th style="min-width: 130px;">Voucher</th>
                                            <th style="min-width: 130px;">Payment Type</th>
                                            <th style="min-width: 130px;">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">
                                                        20 Mar 2023
                                                    </label>
                                                </div>
                                            </td>
                                            <td>Jane Cooper</td>
                                            <td>Supplier</td>
                                            <td>58755</td>
                                            <td class="text-warning">Pending</td>
                                            <td>$4,323.39</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">
                                                        19 Jan 2023
                                                    </label>
                                                </div>
                                            </td>
                                            <td>Alex Cooper</td>
                                            <td>Vendor</td>
                                            <td>58723</td>
                                            <td class="text-success">Delivered</td>
                                            <td>$2,432.39</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">
                                                        16 Mar 2023
                                                    </label>
                                                </div>
                                            </td>
                                            <td>Hales Jane</td>
                                            <td>Customer</td>
                                            <td>58712</td>
                                            <td class="text-danger">Unpaid</td>
                                            <td>$1,582.87</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">
                                                        23 Jun 2023
                                                    </label>
                                                </div>
                                            </td>
                                            <td>Maria D</td>
                                            <td>Supplier</td>
                                            <td>34755</td>
                                            <td class="text-success">Delivered</td>
                                            <td>$5,582.45</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">
                                                        12 Aug 2023
                                                    </label>
                                                </div>
                                            </td>
                                            <td>Robert Mon</td>
                                            <td>Customer</td>
                                            <td>67755</td>
                                            <td class="text-success">Delivered</td>
                                            <td>$6,546.32</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">
                                                        11 May 2023
                                                    </label>
                                                </div>
                                            </td>
                                            <td>Brian Depew</td>
                                            <td>Vendor</td>
                                            <td>28755</td>
                                            <td class="text-warning">Pending</td>
                                            <td>$3,582.6</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">
                                                        6 Oct 2023
                                                    </label>
                                                </div>
                                            </td>
                                            <td>James Murray</td>
                                            <td>Customer</td>
                                            <td>11755</td>
                                            <td class="text-success">Delivered</td>
                                            <td>$8,432.56</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">
                                                        10 Oct 2023
                                                    </label>
                                                </div>
                                            </td>
                                            <td>Alex Carey</td>
                                            <td>Vendor</td>
                                            <td>88755</td>
                                            <td class="text-success">Delivered</td>
                                            <td>$1,321.34</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">
                                                        29 Oct 2023
                                                    </label>
                                                </div>
                                            </td>
                                            <td>Jane Cooper</td>
                                            <td>Vendor</td>
                                            <td>56735</td>
                                            <td class="text-danger">Unpaid</td>
                                            <td>$6,453.66</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">
                                                        27 Mar 2023
                                                    </label>
                                                </div>
                                            </td>
                                            <td>Gary Nunez</td>
                                            <td>Vendor</td>
                                            <td>45637</td>
                                            <td class="text-success">Delivered</td>
                                            <td>$3,321.54</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">
                                                        26 Mar 2023
                                                    </label>
                                                </div>
                                            </td>
                                            <td>James Bowes</td>
                                            <td>Customer</td>
                                            <td>90876</td>
                                            <td class="text-success">Delivered</td>
                                            <td>$4,582.39</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">
                                                        25 Mar 2023
                                                    </label>
                                                </div>
                                            </td>
                                            <td>David Sankey</td>
                                            <td>Expenses</td>
                                            <td>33425</td>
                                            <td class="text-warning">Pending</td>
                                            <td>$4,582.39</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">
                                                        24 Mar 2023
                                                    </label>
                                                </div>
                                            </td>
                                            <td>Paul Clark</td>
                                            <td>Vendor</td>
                                            <td>33445</td>
                                            <td class="text-warning">Pending</td>
                                            <td>$4,582.39</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">
                                                        23 Mar 2023
                                                    </label>
                                                </div>
                                            </td>
                                            <td>Matt Cogdell</td>
                                            <td>Customer</td>
                                            <td>33332</td>
                                            <td class="text-success">Delivered</td>
                                            <td>$4,582.39</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">
                                                        20 Mar 2023
                                                    </label>
                                                </div>
                                            </td>
                                            <td>Bill Blevins</td>
                                            <td>Vendor</td>
                                            <td>55565</td>
                                            <td class="text-success">Delivered</td>
                                            <td>$4,582.39</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">
                                                        21 Mar 2023
                                                    </label>
                                                </div>
                                            </td>
                                            <td>Joseph Dole</td>
                                            <td>Supplier</td>
                                            <td>88998</td>
                                            <td class="text-success">Delivered</td>
                                            <td>$4,582.39</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End:Advanced Table -->
                </div>
            </div>

        </div>
        <!-- End:Main Body -->
    </div>

    <!-- Offcanvas Toggler -->
    <button class="d2c_offcanvas_toggle position-fixed top-50 start-0 translate-middle-y d-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#d2c_sidebar" aria-controls="d2c_sidebar">
        <i class="far fa-hand-point-right"></i>
    </button>
    <!-- End:Offcanvas Toggler -->

    <!-- Initial  Javascript -->
    <script src="./lib/jQuery/jquery-3.5.1.min.js"></script>
    <script src="./lib/bootstrap_5/bootstrap.bundle.min.js"></script>

    <!-- Chart Config -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="./assets/js/apexchart/script.js"></script>

    <!-- custom js -->
    <script src="./assets/js/main.js"></script>

</body>

</html>