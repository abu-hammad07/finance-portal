<?php
session_start();
include_once ("includes/config.php");
include_once ("includes/function2.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
MaintenanceDelete();
?>


<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Maintenance</h4>
    <!-- End:Title -->

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_updated_Maintenance'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_updated_Maintenance'] . '
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
                    <div class="col-md-4 col-xl-3">
                        <form class="position-relative" method="post">
                            <input type="text" class="form-control product-search ps-5 word-spacing-2px"
                                id="maintenaceSearch" onkeyup="search_maintenace_Data()"
                                placeholder="Search &nbsp;..." />
                            <i class="fas fa-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                        </form>
                    </div>
                    <div class="col-md-4 col-xl-3">
                        <form class="position-relative">
                            <input type="month" class="form-control product-search ps-5 word-spacing-2px"
                                id="maintenace_month" onkeyup="search_maintenace_Data()"
                                placeholder="Search &nbsp;..." />
                        </form>
                    </div>
                    <div class="col-md-4 col-xl-3">
                        <form class="position-relative">
                            <select name="" class="form-control" id="">
                                <option value="house">house</option>
                                <option value="shop">shop</option>
                            </select>
                        </form>
                    </div>
                    <!-- <div class="col-md-8 col-xl-9 text-end">
                                <a href="addMaintenance" class="btn btn-primary"><i class="fas fa-plus"></i> Add Maintenace</a>
                            </div> -->
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
                                <input type="month" class="form-control" id="maintenace-month"
                                    onchange="load_maintenace_Data()">
                            </div>
                            <div class="me-2">
                                <select id="maintenace-limit" class="form-control" onchange="load_maintenace_Data()">
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="75">75</option>
                                    <option value="10000000000">All</option>
                                </select>
                            </div>
                            <div class="me-2">
                                <select id="maintenace-order" class="form-control" onchange="load_maintenace_Data()">
                                    <option value="ASC">Old</option>
                                    <option value="DESC">New</option>
                                </select>
                            </div>
                            <div class="me-2">

                                <a class="d2c_pdf_btn text-center justify-content-center text-decoration-none text-primary"

                                <a class="d2c_pdf_btn text-center justify-content-center text-decoration-none text-black"

                                    href="">
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
                                <!-- <a class="d2c_danger_print_btn text-center justify-content-center text-decoration-none text-danger" href="">
                                    <span><i class="fas fa-print mt-2"></i></span>
                            </a>
                            <a class="d2c_pdf_btn text-center justify-content-center text-decoration-none text-black" href="">
                                    <span><i class="fas fa-file-pdf mt-2"></i></span>
                            </a> -->
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
<?php include_once ('includes/footer.php'); ?>
<!-- End: Footer -->


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Load data on page load with default value (10)
        load_maintenace_Data();

    });

    function load_maintenace_Data() {

        let maintenaiceLimited = $("#maintenace-limit").val();
        let maintenaceOrder = $("#maintenace-order").val();
        let maintenaceMonth = $("#maintenace-month").val();

        $.ajax({
            url: 'admin-index2.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load-maintenance-Data',
                maintenaiceLimited: maintenaiceLimited,
                maintenaceOrder: maintenaceOrder,
                maintenaceMonth: maintenaceMonth
            },
            success: function (response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#maintenanceDetails").html(response.data);
            },
        });
    }
</script>
<!-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Load data on page load with default value (10)
            search_maintenace_Data();

        });

        function search_maintenace_Data() {

            let maintenaceSearch = document.getElementById('maintenaceSearch').value;
            let maintenace_id = document.getElementById('maintenace_id').value;
            let maintenace_month = document.getElementById('maintenace_month').value;

            $.ajax({
                url: 'admin-index2.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'search-maintenance-Data',
                    maintenaceSearch: maintenaceSearch
                   

                },
                success: function(response) {
                    console.log(response);
                    // Update the result div with the loaded data
                    $("#maintenanceDetails").html(response.data);
                },
            });
        }
    </script> -->