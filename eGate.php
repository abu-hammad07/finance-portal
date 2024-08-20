<?php
session_start();
include_once("includes/config.php");
include_once("includes/function.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

deleteEgate();
?>


<!-- Main sidebar -->
<?php
include("includes/sidebar.php");
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
                    <div class="col-md-4 col-12 mt-2">
                        <form class="position-relative">
                            <input type="text" class="form-control product-search ps-5 word-spacing-2px"
                                id="house_shop_no-search_eGate" placeholder="Search House & Shop Number &nbsp;..." />
                            <i class="fas fa-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                        </form>
                    </div>
                    <div class="col-md-4 col-12 mt-2">
                        <form class="position-relative">
                            <input type="text" class="form-control product-search ps-5 word-spacing-2px"
                                id="vehicle_number-search_eGate" placeholder="Search Vehicle Number &nbsp;..." />
                            <i class="fas fa-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                        </form>
                    </div>
                    <div class="col-md-4 col mt-2">
                        <select id="payment_type-search_eGate" class="form-control form-select" onchange="load_eGate_Data()">
                            <option value="">---- Select Payment Type --</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank">Bank</option>
                        </select>
                    </div>
                    <div class="col-md-4 col mt-2">
                        <input type="month" id="eGate-month" class="form-control" onchange="load_eGate_Data()">
                    </div>
                    <div class="col-md-4 col mt-2">
                        <select id="eGate-limit" class="form-control form-select" onchange="load_eGate_Data()">
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="75">75</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-12 mt-2">
                        <button type="button" class="btn btn-primary w-100"
                            onclick="search_eGate_Data()">Search</button>
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
                                <a class="d2c_pdf_btn text-center justify-content-center text-decoration-none text-primary"
                                    href="excels/eGateExcel">
                                    <span><i class="fas fa-file-pdf mt-2"></i></span>
                                </a>
                            </div>
                            <div class="mb-2">
                                <a href="addeGate" class="btn btn-primary"><i class="fas fa-plus"></i> E-Gate</a>
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

<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Load data on page load with default value (10)
        load_eGate_Data();

    });

    function load_eGate_Data() {

        let eGateMonth = $("#eGate-month").val();
        let eGateLimited = $("#eGate-limit").val();
        let paymentTypeSearch = document.getElementById('payment_type-search_eGate').value;

        $.ajax({
            url: 'admin-index.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load-eGate_booking-Data',
                eGateLimited: eGateLimited,
                eGateMonth: eGateMonth,
                paymentTypeSearch: paymentTypeSearch
            },
            success: function (response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#eGateDetails").html(response.data);
            },
        });
    }



    function search_eGate_Data() {

        let houseShopNoSearch = document.getElementById('house_shop_no-search_eGate').value;
        let paymentTypeSearch = document.getElementById('payment_type-search_eGate').value;
        let vehicleNoSearch = document.getElementById('vehicle_number-search_eGate').value;
        let eGateMonth = $("#eGate-month").val();
        let eGateLimited = $("#eGate-limit").val();

        $.ajax({
            url: 'admin-index.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'search-eGate-Data',
                houseShopNoSearch: houseShopNoSearch,
                paymentTypeSearch: paymentTypeSearch,
                vehicleNoSearch: vehicleNoSearch,
                eGateMonth: eGateMonth,
                eGateLimited: eGateLimited
            },
            success: function (response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#eGateDetails").html(response.data);
            },
        });
    }





</script>