<?php
session_start();
include_once("includes/config.php");
include_once("includes/function2.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
payrollDelete();
?>


<!-- Main sidebar -->
<?php
include("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Payroll</h4>
    <!-- End:Title -->

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_updated_payroll'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_updated_payroll'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_updated_payroll']);
    }
    if (isset($_SESSION['error_updated_payroll'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_updated_payroll'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_updated_payroll']);
    }
    ?>
    <!-- / Alert -->

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card card-body h-auto d2c_projects_datatable">
                <div class="row">
                    <div class="col-md-4 col-12 mt-2">
                        <div class="position-relative">
                            <input type="text" class="form-control product-search ps-5 word-spacing-2px"
                                id="id-search_payroll" placeholder="Search Employee ID &nbsp;..." />
                            <i class="fas fa-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 mt-2">
                        <div class="position-relative">
                            <input type="text" class="form-control product-search ps-5 word-spacing-2px"
                                id="name-search_payroll" placeholder="Search Employee Name &nbsp;..." />
                            <i class="fas fa-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                        </div>
                    </div>
                    <div class="col-md-4 col mt-2">
                        <input type="month" class="form-control" id="payroll-month" onchange="load_maintenace_Data()">
                    </div>
                    <div class="col-md-4 col mt-2">
                        <select id="payroll-limit" class="form-control form-select" onchange="load_maintenace_Data()">
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="75">75</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-12 mt-2">
                        <button type="button" class="btn btn-primary w-100"
                            onclick="search_payroll_Data()">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                            <!-- <div class="me-2">
                                <input type="month" class="form-control" id="payroll-month" onchange="load_maintenace_Data()">
                            </div>
                            <div class="me-2">
                                <select id="payroll-limit" class="form-control" onchange="load_maintenace_Data()">
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="75">75</option>
                                    <option value="75">75</option>
                                    <option value="10000000000">All</option>
                                </select>
                            </div>
                            <div class="me-2">
                                <select id="payroll-order" class="form-control" onchange="load_maintenace_Data()">
                                    <option value="DESC">New</option>
                                    <option value="ASC">Old</option>
                                </select>
                            </div> -->
                            <div class="me-2">
                                <a class="d2c_pdf_btn text-center justify-content-center text-decoration-none text-primary"
                                    href="excels/payrollExcel" target="_blank">
                                    <span><i class="fas fa-file-pdf mt-2"></i></span>
                                </a>
                            </div>
                            <div class="mb-2">
                                <a href="addPayroll" class="btn btn-primary"><i class="fas fa-plus"></i> Add Payroll</a>
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
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Present Days</th>
                                    <th>Absent Days</th>
                                    <th>Leave</th>
                                    <th>Month-Year</th>
                                    <th>Salary Invoice</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="payrollDetails">
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

<?php include_once('includes/footer.php') ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Load data on page load with default value (10)
        load_maintenace_Data();

    });

    function load_maintenace_Data() {

        let payrollMonth = $("#payroll-month").val();
        let payrollLimited = $("#payroll-limit").val();

        $.ajax({
            url: 'admin-index2.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load-payroll-Data',
                payrollLimited: payrollLimited,
                payrollMonth: payrollMonth
            },
            success: function (response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#payrollDetails").html(response.data);
            },
        });
    }


    function search_payroll_Data() {

        let IDPayrollSearch = document.getElementById('id-search_payroll').value;
        let namePayrollSearch = document.getElementById('name-search_payroll').value;
        let payrollMonth = $("#payroll-month").val();
        let payrollLimited = $("#payroll-limit").val();

        $.ajax({
            url: 'admin-index2.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'search-payroll-Data',
                IDPayrollSearch: IDPayrollSearch, 
                namePayrollSearch: namePayrollSearch, 
                payrollMonth: payrollMonth, 
                payrollLimited: payrollLimited,             },
            success: function (response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#payrollDetails").html(response.data);
            },
        });
    }
</script>