<?php
session_start();
include_once ("includes/config.php");
include_once ("includes/function.php");

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
    <meta name="og:description"
        content="FinDeshY is a free financial Bootstrap dashboard template to manage your financial data easily. This free financial dashboard uses Bootstrap to provide a responsive and user-friendly interface. Whether you're a small business owner seeking insights into your company's financial health or an individual looking to simplify your personal finances, this free Bootstrap dashboard template has you covered.">
    <meta name="robots" content="index, follow">
    <meta name="og:title" property="og:title" content="FinDeshY - Free Financial Bootstrap Dashboard Template">
    <meta property="og:image"
        content="https://www.designtocodes.com/wp-content/uploads/2023/10/FinDeshY-Professional-Financial-Bootstrap-Dashboard-Template.jpg">
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
        include ("includes/sidebar.php");
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
                <div class="col-xxl-12">
                    <div class="row">
                        <!-- Visa Card -->

                        <!-- Houses Card -->
                        <div class="col-xl-3 col-md-4 col-6 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="row mb-3">
                                        <div class="col d-flex justify-content-end">
                                            <div class="dropdown">
                                                <button class="btn px-1 d2c_dropdown_btn" type="button"
                                                    id="housesModalLabel" data-bs-toggle="modal"
                                                    data-bs-target="#housesModal">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="housesModal" data-bs-backdrop="static"
                                                    data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="housesModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">

                                                        <div class="modal-content position-relative">
                                                            <form>
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="housesModalLabel">
                                                                        House </h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body p-0">
                                                                    <div class="p-4">
                                                                        <label class="col-form-label"
                                                                            for="house_month">Select House
                                                                            Month:</label>
                                                                        <input class="form-control" id="house_month"
                                                                            type="month"
                                                                            value="<?php echo date('Y-m'); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-outline-secondary"
                                                                        type="button"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button class="btn btn-primary" type="button"
                                                                        data-bs-dismiss="modal">Search </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="btn rounded shadow text-primary fs-3">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h6>Houses</h6>
                                    <p><?= date('F, Y') ?></p>
                                    <h4 class="text-primary mb-0"><?= totalHouses() ?></h4>
                                </div>
                            </div>
                        </div>
                        <!-- End:Houses Card -->

                        <!-- Shops Card -->
                        <div class="col-xl-3 col-md-4 col-6 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="row mb-3">
                                        <div class="col d-flex justify-content-end">
                                            <div class="dropdown">
                                                <button class="btn px-1 d2c_dropdown_btn" type="button"
                                                    id="shopsModalLabel" data-bs-toggle="modal"
                                                    data-bs-target="#shopsModal">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="shopsModal" data-bs-backdrop="static"
                                                    data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="shopsModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">

                                                        <div class="modal-content position-relative">
                                                            <form>
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="shopsModalLabel">
                                                                        Shop </h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body p-0">
                                                                    <div class="p-4">
                                                                        <label class="col-form-label"
                                                                            for="house_month">Select Shop Month:</label>
                                                                        <input class="form-control" id="house_month"
                                                                            type="month"
                                                                            value="<?php echo date('Y-m'); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-outline-secondary"
                                                                        type="button"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button class="btn btn-primary" type="button"
                                                                        data-bs-dismiss="modal">Search </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="btn rounded shadow text-primary fs-3">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h6>Shops</h6>
                                    <p><?= date('F, Y') ?></p>
                                    <h4 class="text-primary mb-0"><?= totalShops() ?></h4>
                                </div>
                            </div>
                        </div>

                        <!-- Users Card -->
                        <div class="col-xl-3 col-md-4 col-6 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="row mb-3">
                                        <div class="col d-flex justify-content-end">
                                            <div class="dropdown">
                                                <button class="btn px-1 d2c_dropdown_btn" type="button"
                                                    id="usersModalLabel" data-bs-toggle="modal"
                                                    data-bs-target="#usersModal">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="usersModal" data-bs-backdrop="static"
                                                    data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="usersModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">

                                                        <div class="modal-content position-relative">
                                                            <form>
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="usersModalLabel">
                                                                        User </h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body p-0">
                                                                    <div class="p-4">
                                                                        <label class="col-form-label"
                                                                            for="user_month">Select User Month:</label>
                                                                        <input class="form-control" id="user_month"
                                                                            type="month"
                                                                            value="<?php echo date('Y-m'); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-outline-secondary"
                                                                        type="button"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button class="btn btn-primary" type="button"
                                                                        data-bs-dismiss="modal">Search </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="btn rounded shadow text-primary fs-3">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h6>Users</h6>
                                    <p><?= date('F, Y') ?></p>
                                    <h4 class="text-primary mb-0"><?= totalUsers() ?></h4>
                                </div>
                            </div>
                        </div>

                        <!-- Employees Card -->
                        <div class="col-xl-3 col-md-4 col-6 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="row mb-3">
                                        <div class="col d-flex justify-content-end">
                                            <div class="dropdown">
                                                <button class="btn px-1 d2c_dropdown_btn" type="button"
                                                    id="employeesModalLabel" data-bs-toggle="modal"
                                                    data-bs-target="#employeesModal">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="employeesModal" data-bs-backdrop="static"
                                                    data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="employeesModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">

                                                        <div class="modal-content position-relative">
                                                            <form>
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5"
                                                                        id="employeesModalLabel">Employee </h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body p-0">
                                                                    <div class="p-4">
                                                                        <label class="col-form-label"
                                                                            for="employee_month">Select Employee
                                                                            Month:</label>
                                                                        <input class="form-control" id="employee_month"
                                                                            type="month"
                                                                            value="<?php echo date('Y-m'); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-outline-secondary"
                                                                        type="button"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button class="btn btn-primary" type="button"
                                                                        data-bs-dismiss="modal">Search </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="btn rounded shadow text-primary fs-3">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h6>Employees</h6>
                                    <p><?= date('F, Y') ?></p>
                                    <h4 class="text-primary mb-0"><?= totalEmployees() ?></h4>
                                </div>
                            </div>
                        </div>

                        <!-- Income Card -->
                        <div class="col-xl-3 col-md-4 col-6 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="row mb-3">
                                        <div class="col d-flex justify-content-end">
                                            <div class="dropdown">
                                                <button class="btn px-1 d2c_dropdown_btn" type="button"
                                                    id="incomeModalLabel" data-bs-toggle="modal"
                                                    data-bs-target="#incomeModal">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="incomeModal" data-bs-backdrop="static"
                                                    data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="incomeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">

                                                        <div class="modal-content position-relative">
                                                            <form>
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="incomeModalLabel">
                                                                        Income </h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body p-0">
                                                                    <div class="p-4">
                                                                        <label class="col-form-label"
                                                                            for="income_month">Select Income
                                                                            Month:</label>
                                                                        <input class="form-control" id="income_month"
                                                                            type="month"
                                                                            value="<?php echo date('Y-m'); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-outline-secondary"
                                                                        type="button"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button class="btn btn-primary" type="button"
                                                                        data-bs-dismiss="modal">Search </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="btn rounded shadow text-primary fs-3">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h6>Income</h6>
                                    <p><?= date('F, Y') ?></p>
                                    <h4 class="text-primary mb-0"><?= get_total_combined_income() ?></h4>
                                </div>
                            </div>
                        </div>

                        <!-- Expenses Card -->
                        <div class="col-xl-3 col-md-4 col-6 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="row mb-3">
                                        <div class="col d-flex justify-content-end">
                                            <div class="dropdown">
                                                <button class="btn px-1 d2c_dropdown_btn" type="button"
                                                    id="expensesModalLabel" data-bs-toggle="modal"
                                                    data-bs-target="#expensesModal">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="expensesModal" data-bs-backdrop="static"
                                                    data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="expensesModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">

                                                        <div class="modal-content position-relative">
                                                            <form>
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5"
                                                                        id="expensesModalLabel">Expense </h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body p-0">
                                                                    <div class="p-4">
                                                                        <label class="col-form-label"
                                                                            for="expense_month">Select Expense
                                                                            Month:</label>
                                                                        <input class="form-control" id="expense_month"
                                                                            type="month"
                                                                            value="<?php echo date('Y-m'); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-outline-secondary"
                                                                        type="button"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button class="btn btn-primary" type="button"
                                                                        data-bs-dismiss="modal">Search </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="btn rounded shadow text-primary fs-3">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h6>Expenses</h6>
                                    <p><?= date('F, Y') ?></p>
                                    <h4 class="text-primary mb-0"><?= get_total_combined_expences() ?></h4>
                                </div>
                            </div>
                        </div>


                        <!-- Maintainance Charges -->
                        <div class="col-xxl-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Maintainance Charges</h6>
                                </div>
                                <div class="card-body mt-3">
                                    <!-- Facebook Ads -->
                                    <div class="card mb-4">
                                        <div class="card-body d-flex align-items-center">
                                            <div
                                                class="d2c_icon btn bg-primary text-primary rounded-circle bg-opacity-10">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                            <div class="flex-1 w-100 ms-3">
                                                <div class="d-flex justify-content-between mb-2">
                                                    Houses <span class="text-end"><span class="fw-bold">75</span> /
                                                        100</span>
                                                </div>
                                                <div class="progress bg-primary bg-opacity-10">
                                                    <div class="progress-bar bg-primary rounded" role="progressbar"
                                                        aria-label="Basic example" style="width: 75%" aria-valuenow="25"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
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
                                                    Shops <span class="text-end"><span class="fw-bold">50</span> /
                                                        100</span>
                                                </div>
                                                <div class="progress bg-info bg-opacity-10">
                                                    <div class="progress-bar bg-info rounded" role="progressbar"
                                                        aria-label="Basic example" style="width: 50%" aria-valuenow="25"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>

            <div class="row">
                <!-- Income Summary -->
                <div class="col-xl-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h6>Balance Summary</h6>
                            <h4 class="text-primary">$12,389.54</h4>
                        </div>
                        <div class="card-body">
                            <div id="d2c_lineChart"></div>
                        </div>
                    </div>
                </div>
                <!-- End:Income Summary -->

                <!-- Expenses -->
                <div class="col-xl-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h6>Expenses</h6>
                            <h4 class="text-primary">$12,389.54</h4>
                        </div>
                        <div class="card-body">
                            <div id="d2c_barChart"></div>
                        </div>
                    </div>
                </div>
                <!-- End:Expenses -->

            </div>
        </div>
        <!-- End:Main Body -->
    </div>

    <!-- Offcanvas Toggler -->
    <button class="d2c_offcanvas_toggle position-fixed top-50 start-0 translate-middle-y d-block d-lg-none"
        type="button" data-bs-toggle="offcanvas" data-bs-target="#d2c_sidebar" aria-controls="d2c_sidebar">
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