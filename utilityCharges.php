<?php
session_start();
include_once("includes/config.php");
include_once("includes/function.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

deleteUtilityChargesID();
?>


<!-- Main sidebar -->
<?php
include("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Utility Charges</h4>
    <!-- End:Title -->

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card card-body h-auto d2c_projects_datatable">
                <div class="row">
                    <div class="col-md-4 col-12 mt-2">
                        <form class="position-relative">
                            <input type="text" class="form-control product-search ps-5 word-spacing-2px"
                                id="utilityType-search_utility" placeholder="Search Utility Type &nbsp;..." />
                            <i class="fas fa-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                        </form>
                    </div>
                    <div class="col-md-4 col mt-2">
                        <select id="payment-search_utility" class="form-control form-select" onchange="load_Utility_charges_Data()">
                            <option value="">---- Select Payment Type --</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank">Bank</option>
                        </select>
                    </div>
                    <div class="col-md-4 col mt-2">
                        <input type="month" class="form-control" id="Utility_charges-month"
                            onchange="load_Utility_charges_Data()">
                    </div>
                    <div class="col-md-4 col mt-2">
                        <select id="Utility_charges-limit" class="form-control form-select"
                            onchange="load_Utility_charges_Data()">
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="75">75</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-12 mt-2">
                        <button type="button" class="btn btn-primary w-100"
                            onclick="search_utility_Data()">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_updated_Utility_charges'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_updated_Utility_charges'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_updated_Utility_charges']);
    }
    if (isset($_SESSION['error_updated_Utility_charges'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_updated_Utility_charges'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_updated_Utility_charges']);
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
                            <!-- <div class="me-2">
                                <input type="month" class="form-control" id="Utility_charges-month" onchange="load_Utility_charges_Data()">
                            </div>
                            <div class="me-2">
                                <select id="Utility_charges-limit" class="form-control form-select" onchange="load_Utility_charges_Data()">
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="75">75</option>
                                    <option value="100">100</option>
                                </select>
                            </div> -->
                            <div class="me-2">
                                <a class="d2c_pdf_btn text-center justify-content-center text-decoration-none text-primary"
                                    href="excels/utilityChargesExcel" target="_blank">
                                    <span><i class="fas fa-file-pdf mt-2"></i></span>
                                </a>
                            </div>
                            <div class="mb-2">
                                <a href="addUtilityCharges" class="btn btn-primary"><i class="fas fa-plus"></i> Utility
                                    CHarges</a>
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
                                    <th>Utility Type</th>
                                    <th>Amount</th>
                                    <th>Billing Month</th>
                                    <th>Location</th>
                                    <th>Payment Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="Utility_chargesDetails">
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
        load_Utility_charges_Data();

    });

    function load_Utility_charges_Data() {

        let Utility_chargesLimited = $("#Utility_charges-limit").val();
        let Utility_chargesMonth = $("#Utility_charges-month").val();
        let paymentUtilitySearch = document.getElementById('payment-search_utility').value;

        $.ajax({
            url: 'admin-index.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load-Utility_charges-Data',
                Utility_chargesLimited: Utility_chargesLimited,
                Utility_chargesMonth: Utility_chargesMonth,
                paymentUtilitySearch: paymentUtilitySearch
            },
            success: function (response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#Utility_chargesDetails").html(response.data);
            },
        });
    }




    function search_utility_Data() {

        let UtilityTypeSearch = document.getElementById('utilityType-search_utility').value;
        let paymentUtilitySearch = document.getElementById('payment-search_utility').value;
        let Utility_chargesLimited = $("#Utility_charges-limit").val();
        let Utility_chargesMonth = $("#Utility_charges-month").val();


        $.ajax({
            url: 'admin-index.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'search-Utility_charges-Data',
                UtilityTypeSearch: UtilityTypeSearch,
                paymentUtilitySearch: paymentUtilitySearch,
                Utility_chargesLimited: Utility_chargesLimited,
                Utility_chargesMonth: Utility_chargesMonth,
            },
            success: function (response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#Utility_chargesDetails").html(response.data);
            },
        });
    }
</script>