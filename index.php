<?php
session_start();
include_once("includes/config.php");
include_once("includes/function.php");
include_once("includes/auto_addMontainace.php");
// include_once("includes/fetch_data.php");

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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                                        <button class="btn px-1 d2c_dropdown_btn" type="button" id="housesModalLabel"
                                            data-bs-toggle="modal" data-bs-target="#housesModal">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="housesModal" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="housesModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">

                                                <div class="modal-content position-relative">
                                                    <form>
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="housesModalLabel">
                                                                House </h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-0">
                                                            <div class="p-4">
                                                                <label class="col-form-label" for="house_month">Select
                                                                    House
                                                                    Month:</label>
                                                                <input class="form-control" id="filter-house_month"
                                                                    type="month" value="<?php echo date('Y-m'); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-outline-secondary" type="button"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button class="btn btn-primary" type="button"
                                                                data-bs-dismiss="modal"
                                                                onclick="filterHouseData()">Filter </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->
                                    </div>
                                </div>
                                <div class="col-12">
                                    <a href="houses">
                                        <div class="btn rounded shadow text-primary fs-3">
                                            <i class="fas fa-house-user"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <h6>Houses</h6>
                            <div id="houseDataMonth">
                                <p><?php echo date('F, Y') ?></p>
                                <h4 class="text-primary mb-0"><?php echo totalHouses() ?></h4>
                            </div>
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
                                        <button class="btn px-1 d2c_dropdown_btn" type="button" id="shopsModalLabel"
                                            data-bs-toggle="modal" data-bs-target="#shopsModal">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="shopsModal" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="shopsModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">

                                                <div class="modal-content position-relative">
                                                    <form>
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="shopsModalLabel">
                                                                Shop </h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-0">
                                                            <div class="p-4">
                                                                <label class="col-form-label" for="house_month">Select
                                                                    Shop Month:</label>
                                                                <input class="form-control" id="filter-shops_month"
                                                                    type="month" value="<?php echo date('Y-m'); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-outline-secondary" type="button"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button class="btn btn-primary" type="button"
                                                                data-bs-dismiss="modal"
                                                                onclick="filterShopData()">Filter </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->
                                    </div>
                                </div>
                                <div class="col-12">
                                    <a href="shops">
                                        <div class="btn rounded shadow text-primary fs-3">
                                            <i class="fas fa-store"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <h6>Shops</h6>
                            <div id="shopsDataMonth">
                                <p><?= date('F, Y') ?></p>
                                <h4 class="text-primary mb-0"><?= totalShops() ?></h4>
                            </div>
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
                                        <button class="btn px-1 d2c_dropdown_btn" type="button" id="usersModalLabel"
                                            data-bs-toggle="modal" data-bs-target="#usersModal">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="usersModal" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="usersModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">

                                                <div class="modal-content position-relative">
                                                    <form>
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="usersModalLabel">
                                                                User </h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-0">
                                                            <div class="p-4">
                                                                <label class="col-form-label" for="user_month">Select
                                                                    User Month:</label>
                                                                <input class="form-control" id="filter-users_month"
                                                                    type="month" value="<?php echo date('Y-m'); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-outline-secondary" type="button"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button class="btn btn-primary" type="button"
                                                                data-bs-dismiss="modal"
                                                                onclick="filterUserData()">Filter </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->
                                    </div>
                                </div>
                                <div class="col-12">
                                    <a href="userDetails">
                                        <div class="btn rounded shadow text-primary fs-3">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <h6>Users</h6>
                            <div id="usersDataMonth">
                                <p><?= date('F, Y') ?></p>
                                <h4 class="text-primary mb-0"><?= totalUsers() ?></h4>
                            </div>
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
                                        <button class="btn px-1 d2c_dropdown_btn" type="button" id="employeesModalLabel"
                                            data-bs-toggle="modal" data-bs-target="#employeesModal">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="employeesModal" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="employeesModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">

                                                <div class="modal-content position-relative">
                                                    <form>
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="employeesModalLabel">
                                                                Employee </h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-0">
                                                            <div class="p-4">
                                                                <label class="col-form-label"
                                                                    for="employee_month">Select Employee
                                                                    Month:</label>
                                                                <input class="form-control" id="filter-employees_month"
                                                                    type="month" value="<?php echo date('Y-m'); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-outline-secondary" type="button"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button class="btn btn-primary" type="button"
                                                                data-bs-dismiss="modal"
                                                                onclick="filterEmployeeData()">Filter </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->
                                    </div>
                                </div>
                                <div class="col-12">
                                    <a href="employee">
                                        <div class="btn rounded shadow text-primary fs-3">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <h6>Employees</h6>
                            <div id="employeesDataMonth">
                                <p><?= date('F, Y') ?></p>
                                <h4 class="text-primary mb-0"><?= totalEmployees() ?></h4>
                            </div>
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
                                        <button class="btn px-1 d2c_dropdown_btn" type="button" id="incomeModalLabel"
                                            data-bs-toggle="modal" data-bs-target="#incomeModal">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="incomeModal" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="incomeModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">

                                                <div class="modal-content position-relative">
                                                    <form>
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="incomeModalLabel">
                                                                Income </h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-0">
                                                            <div class="p-4">
                                                                <label class="col-form-label" for="income_month">Select
                                                                    Income
                                                                    Month:</label>
                                                                <input class="form-control" id="filter-income_month"
                                                                    type="month" value="<?php echo date('Y-m'); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-outline-secondary" type="button"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button class="btn btn-primary" type="button"
                                                                data-bs-dismiss="modal"
                                                                onclick="filterIncomeData()">Filter </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->
                                    </div>
                                </div>
                                <div class="col-12">
                                    <a href="viewIncomeReports">
                                        <div class="btn rounded shadow text-primary fs-3">
                                            <i class="fa-solid fa-rupee-sign"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <h6>Income</h6>
                            <div id="incomeDataMonth">
                                <p><?= date('F, Y') ?></p>
                                <h4 class="text-primary mb-0"><?= get_total_combined_income() ?></h4>
                            </div>
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
                                        <button class="btn px-1 d2c_dropdown_btn" type="button" id="expensesModalLabel"
                                            data-bs-toggle="modal" data-bs-target="#expensesModal">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="expensesModal" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="expensesModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">

                                                <div class="modal-content position-relative">
                                                    <form>
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="expensesModalLabel">Expense
                                                            </h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-0">
                                                            <div class="p-4">
                                                                <label class="col-form-label" for="expense_month">Select
                                                                    Expense
                                                                    Month:</label>
                                                                <input class="form-control" id="filter-Expences_month"
                                                                    type="month" value="<?php echo date('Y-m'); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-outline-secondary" type="button"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button class="btn btn-primary" type="button"
                                                                data-bs-dismiss="modal"
                                                                onclick="filterExpenceData()">Filter </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->
                                    </div>
                                </div>
                                <div class="col-12">
                                    <a href="viewexpensesReports">
                                        <div class="btn rounded shadow text-primary fs-3">
                                            <i class="fa-solid fa-rupee-sign"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <h6>Expenses</h6>
                            <div id="expencesDataMonth">
                                <p><?= date('F, Y') ?></p>
                                <h4 class="text-primary mb-0"><?= get_total_combined_expences() ?></h4>
                            </div>
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
                                    <div class="d2c_icon btn bg-primary text-primary rounded-circle bg-opacity-10">
                                        <i class="fa-solid fa-rupee-sign"></i>
                                    </div>
                                    <div class="flex-1 w-100 ms-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            Houses
                                            <span class="text-end">Paid
                                                <span class="fw-bold"><?= totalHousesPaid() ?>
                                                </span> /
                                                <span class="fw-bold">
                                                    <?= totalHouses() ?>
                                                </span>
                                                Total
                                            </span>
                                        </div>
                                        <div class="progress bg-primary bg-opacity-10">
                                            <?php
                                            $totalHouses = totalHouses();
                                            $totalHousesPaid = totalHousesPaid();
                                            $percentage = ($totalHousesPaid / $totalHouses) * 100;
                                            ?>
                                            <div class="progress-bar bg-primary rounded" role="progressbar"
                                                aria-label="Basic example" style="width: <?= $percentage ?>%;"
                                                aria-valuenow="<?= $percentage ?>" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Total Shops -->
                            <div class="card mb-4">
                                <div class="card-body d-flex align-items-center">
                                    <div class="d2c_icon btn bg-info text-info rounded-circle bg-opacity-10">
                                        <i class="fa-solid fa-rupee-sign"></i>
                                    </div>
                                    <div class="flex-1 w-100 ms-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            Shops
                                            <span class="text-end">Paid
                                                <span class="fw-bold"><?= totalShopsPaid() ?>
                                                </span> /
                                                <span class="fw-bold">
                                                    <?= totalShops() ?>
                                                </span>
                                                Total
                                            </span>
                                        </div>
                                        <div class="progress bg-info bg-opacity-10">
                                            <?php
                                            $totalShops = totalShops();
                                            $totalShopsPaid = totalShopsPaid();
                                            $percentage = ($totalShopsPaid / $totalShops) * 100;
                                            ?>
                                            <div class="progress-bar bg-info rounded" role="progressbar"
                                                aria-label="Basic example" style="width: <?= $percentage ?>%;"
                                                aria-valuenow="<?= $percentage ?>" aria-valuemin="0"
                                                aria-valuemax="100"></div>
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
                    <h4 class="text-primary">
                        <i class="fa-solid fa-rupee-sign"></i>
                        <?= get_total_combined_income() ?>
                    </h4>
                </div>
                <div class="card-body">
                    <div id="d2c_lineChart">

                    </div>
                </div>
            </div>
        </div>
        <!-- End:Income Summary -->

        <!-- Expenses -->
        <div class="col-xl-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6>Expenses</h6>
                    <h4 class="text-primary">
                        <i class="fa-solid fa-rupee-sign"></i>
                        <?= get_total_combined_expences() ?>
                    </h4>
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

<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->


<script>
    // Filter Houses Data
    function filterHouseData() {
        var filterHousesData = document.getElementById('filter-house_month').value;

        // send the ajax request
        $.ajax({
            url: 'admin-index.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'filter-house-Data',
                filterHousesData: filterHousesData
            },
            success: function (response) {
                console.log(response);
                $('#houseDataMonth').html(response.data);
            },
        });
    }


    // Filter Shops Data
    function filterShopData() {
        var filterShopsData = document.getElementById('filter-shops_month').value;

        // send the ajax request
        $.ajax({
            url: 'admin-index.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'filter-shops-Data',
                filterShopsData: filterShopsData
            },
            success: function (response) {
                console.log(response);
                $('#shopsDataMonth').html(response.data);
            },
        });
    }


    // Filter Users Data
    function filterUserData() {
        var filterUsersData = document.getElementById('filter-users_month').value;

        // send the ajax request
        $.ajax({
            url: 'admin-index.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'filter-users-Data',
                filterUsersData: filterUsersData
            },
            success: function (response) {
                console.log(response);
                $('#usersDataMonth').html(response.data);
            },
        });
    }


    // Filter Employees Data
    function filterEmployeeData() {
        var filterEmployeesData = document.getElementById('filter-employees_month').value;

        // send the ajax request
        $.ajax({
            url: 'admin-index.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'filter-employees-Data',
                filterEmployeesData: filterEmployeesData
            },
            success: function (response) {
                console.log(response);
                $('#employeesDataMonth').html(response.data);
            },
        });
    }


    // Filter Income Data
    function filterIncomeData() {
        var filterIncomesData = document.getElementById('filter-income_month').value;

        // send the ajax request
        $.ajax({
            url: 'admin-index.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'filter-income-Data',
                filterIncomesData: filterIncomesData
            },
            success: function (response) {
                console.log(response);
                $('#incomeDataMonth').html(response.data);
            },
        });
    }


    // Filter Expences Data
    function filterExpenceData() {
        var filterExpencesData = document.getElementById('filter-Expences_month').value;
        // send the ajax request
        $.ajax({
            url: 'admin-index.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'filter-Expences-Data',
                filterExpencesData: filterExpencesData
            },
            success: function (response) {
                console.log(response);
                $('#expencesDataMonth').html(response.data);
            },
        });
    }
</script>