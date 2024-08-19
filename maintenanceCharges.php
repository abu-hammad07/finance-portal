<?php
session_start();
include_once("includes/config.php");
include_once("includes/function2.php");
include_once("includes/auto_addMontainace.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
MaintenanceDelete();
?>


<!-- Main sidebar -->
<?php
include("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">


    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_updated_Maintenance'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_updated_Maintenance'] . ' <a class="d2c_danger_print_btn p-1 text-bg-success text-center rounded" style="float: right; margin-top:-5px;"  href="includes/pdf_maker?MAT_ID=' . $_SESSION['maintainace_id'] . '&ACTION=VIEW" target="_blank">
                Download Pdf
            </a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_updated_Maintenance']);
    }
    if (isset($_SESSION['error_message_Maintenance'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_message_Maintenance'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_message_Maintenance']);
    }
    ?>
    <!-- / Alert -->

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card card-body h-auto d2c_projects_datatable">
                <div class="row">
                    <div class="col-md-4 col-12 mt-2">
                        <form class="position-relative">
                            <input type="text" class="form-control product-search ps-5 word-spacing-2px"
                                id="house_shop_no-search_maint" placeholder="Search House & Shop Number &nbsp;..." />
                            <i class="fas fa-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                        </form>
                    </div>
                    <div class="col-md-4 col mt-2">
                        <select id="payment_type-search_maint" class="form-control form-select"
                            onchange="load_maintenace_Data()">
                            <option value="">--- Select Payment Type --</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank">Bank</option>
                        </select>
                    </div>
                    <div class="col-md-4 col mt-2">
                        <input type="month" class="form-control" id="maintenace-month"
                            onchange="load_maintenace_Data()">
                    </div>
                    <div class="col-md-4 col mt-2">
                        <select id="maintenace-limit" class="form-control form-select"
                            onchange="load_maintenace_Data()">
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="75">75</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-12 mt-2">
                        <button type="button" class="btn btn-primary w-100"
                            onclick="search_maintenace_Data()">Search</button>
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
                            <div class="me-2">
                                <a class="d2c_pdf_btn text-center justify-content-center text-decoration-none text-primary"
                                    href="excels/maintenanceChargesExcel">
                                    <span><i class="fas fa-file-pdf mt-2 "></i></span>
                                </a>
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
                                    <th>House/Shop</th>
                                    <th>Month</th>
                                    <th>Charges</th>
                                    <th>Charges Type</th>
                                    <th>Status</th>
                                    <th>Print</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="maintenanceDetails">
                                <!-- <button id="alert15" class="btn btn-primary">Alert 15</button> -->
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

<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Load data on page load with default value (10)
        load_maintenace_Data();

    });

    function load_maintenace_Data() {

        let maintenaiceLimited = $("#maintenace-limit").val();
        let maintenaceMonth = $("#maintenace-month").val();
        let paaymentTypeMaintSearch = document.getElementById('payment_type-search_maint').value;

        $.ajax({
            url: 'admin-index2.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load-maintenance-Data',
                maintenaiceLimited: maintenaiceLimited,
                maintenaceMonth: maintenaceMonth,
                paaymentTypeMaintSearch: paaymentTypeMaintSearch
            },
            success: function (response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#maintenanceDetails").html(response.data);
            },
        });
    }


    function search_maintenace_Data() {
        let houseShopNoSearch = document.getElementById('house_shop_no-search_maint').value;
        let paaymentTypeMaintSearch = document.getElementById('payment_type-search_maint').value;
        let maintenanceLimit = $("#maintenace-limit").val();
        let maintenanceMonth = $("#maintenace-month").val();

        $.ajax({
            url: 'admin-index2.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'search-maintenance-Data',
                houseShopNoSearch: houseShopNoSearch,
                maintenanceLimit: maintenanceLimit,
                maintenanceMonth: maintenanceMonth,
                paaymentTypeMaintSearch: paaymentTypeMaintSearch
            },
            success: function (response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#maintenanceDetails").html(response.data);
            },
        });
    }


</script>