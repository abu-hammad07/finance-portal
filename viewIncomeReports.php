<?php
session_start();
include_once("includes/config.php");
include_once("includes/function.php");
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
    <title>Income Reports</title>
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
            <h4 class="mb-4 text-capitalize">Income Reports</h4>
            <!-- End:Title -->

            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card card-body h-auto d2c_projects_datatable">
                        <div class="row g-3">
                            <div class="col-md-4 col-6">
                                <select id="selectUtilityMaint" class="form-select form-control" onchange="handleSelectionChange()">
                                    <option value="">Select Income Form</option>
                                    <option value="E-Gate Pass">E-Gate Pass</option>
                                    <option value="Servants">Servants</option>
                                    <option value="Events Booking">Events Booking</option>
                                    <option value="Maintenance Charges">Maintenance Charges</option>
                                    <option value="Penalty Charges">Penalty Charges</option>
                                </select>
                            </div>

                            
                            <!-- --------------egat-pass start------------------ -->
                            <div class="col-md-4 col-6" id="utilityTypeContainer" style="display: none;">
                                <input type="text" class="form-control" id="searchUtilityType" placeholder="Vehicle Name..." />
                            </div>
                            <div class="col-md-4 col-6" id="utilityTypeContainer" style="display: none;">
                                <input type="text" class="form-control" id="searchUtilityType" placeholder="Vehicle Number..." />
                            </div>
                            <div class="col-md-4 col-6" id="locationContainer" style="display: none;">
                                <select id="searchLocation" class="form-select form-control">
                                    <option value="">Select Location</option>
                                    <option value="Office">Office</option>
                                    <option value="Sports Area">Sports Area</option>
                                    <option value="Shadi Hall">Shadi Hall</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                              <!-- --------------egat-pass end------------------ -->
                            <div class="col-md-4 col-6" id="maintTypeContainer" style="display: none;">
                                <input type="text" class="form-control" id="searchMaintType" placeholder="Maintenance Type..." />
                            </div>

                            <div class="col-md-4 col-6">
                                <input type="month" class="form-control" id="searchMonth" onchange="load_expensesReports_Data()" />
                            </div>
                            <div class="col-md-4 col-6">
                                <select id="searchDropdown" class="form-select form-control" onchange="load_expensesReports_Data()">
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="75">75</option>
                                    <option value="100">100</option>
                                    <option value="125">125</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-6">
                                <button class="btn btn-primary w-100" id="submit_btn" type="submit" onclick="search_expensesReports_Data()">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card h-auto d2c_projects_datatable">
                        <div class="card-body">
                            <div class="table-responsive table-responsive">
                                <table class="table" id="d2c_advanced_table_2">
                                    <thead>
                                        <tr>
                                            <!-- ------------Tenant------------- -->
                                            <!-- ----------all page start------------------ -->
                                            <th id="snoID" style="display: none;">S.No</th>
                                            <th id="utilityTypeID" style="display: none;">House/Shop Number</th>
                                            <!-- ----------all page end------------------ -->
                                            <!-- ------------Egat ------------- -->
                                            <th id="maintCommentsID" style="display: none;">Person Name</th>
                                            <th id="maintCommentsID" style="display: none;">Vehicle Name</th>
                                            <th id="maintCommentsID" style="display: none;">Vehicle Number</th>
                                            <th id="maintCommentsID" style="display: none;">Charges</th>
                                            <!-- ------------Servant------------- -->
                                            <th id="maintActionID" style="display: none;">Owner Name</th>
                                            <th id="maintActionID" style="display: none;">Designation</th>
                                            <th id="maintActionID" style="display: none;">Fees</th>
                                            <!-- ------------event booking------------- -->
                                            <th id="maintActionID" style="display: none;">Event Name</th>
                                            <th id="maintActionID" style="display: none;">Customer Name</th>
                                            <th id="maintActionID" style="display: none;">Customer CNIC</th>
                                            <th id="maintActionID" style="display: none;">Date Time</th>
                                            <th id="maintActionID" style="display: none;">Booking Payment</th>
                                            <!-- ------------Maintenance------------- -->
                                            <th id="maintActionID" style="display: none;">House / Shop</th>
                                            <th id="maintActionID" style="display: none;">Maintenance Month</th>
                                            <th id="maintActionID" style="display: none;">Maintenance Charges</th>
                                            <!-- ------------Penalty------------- -->
                                            <th id="maintActionID" style="display: none;">Penalty type</th>
                                            <th id="maintActionID" style="display: none;">Penalty Cnic</th>
                                            <th id="maintActionID" style="display: none;">Penalty Charges</th>
                                            <!-- --------------------all----------------- -->
                                            <th id="maintActionID" style="display: none;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="expensesReportsData">
                                        <!-- <div id="successAlert" class="alert alert-warning text-warning text-center alert-dismissible" role="alert">
                                            Select Utility/Maintenance & Search the data .
                                        </div> -->
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
        function handleSelectionChange() {
            const selectUtilityMaint = document.getElementById('selectUtilityMaint');
            const utilityTypeContainer = document.getElementById('utilityTypeContainer');
            const locationContainer = document.getElementById('locationContainer');
            const maintTypeContainer = document.getElementById('maintTypeContainer');

            const snoID = document.getElementById('snoID');
            const utilityTypeID = document.getElementById('utilityTypeID');
            const utilityAmountID = document.getElementById('utilityAmountID');
            const utilityDueDateID = document.getElementById('utilityDueDateID');
            const utilityLocationID = document.getElementById('utilityLocationID');
            const maintTypeID = document.getElementById('maintTypeID');
            const maintAmountID = document.getElementById('maintAmountID');
            const maintDueDateID = document.getElementById('maintDueDateID');
            const maintPaymentDateID = document.getElementById('maintPaymentDateID');
            const maintCommentsID = document.getElementById('maintCommentsID');
            const maintActionID = document.getElementById('maintActionID');

            if (selectUtilityMaint.value === "Society Maintenance") {
                utilityTypeContainer.style.display = 'none';
                locationContainer.style.display = 'none';
                maintTypeContainer.style.display = 'block';

                snoID.style.display = 'table-cell';
                utilityTypeID.style.display = 'none';
                utilityAmountID.style.display = 'none';
                utilityDueDateID.style.display = 'none';
                utilityLocationID.style.display = 'none';
                maintTypeID.style.display = 'table-cell';
                maintAmountID.style.display = 'table-cell';
                maintDueDateID.style.display = 'table-cell';
                maintPaymentDateID.style.display = 'table-cell';
                maintCommentsID.style.display = 'table-cell';
                maintActionID.style.display = 'table-cell';

            } else if (selectUtilityMaint.value === "Utility Charges") {
                utilityTypeContainer.style.display = 'block';
                locationContainer.style.display = 'block';
                maintTypeContainer.style.display = 'none';

                snoID.style.display = 'table-cell';
                utilityTypeID.style.display = 'table-cell';
                utilityAmountID.style.display = 'table-cell';
                utilityDueDateID.style.display = 'table-cell';
                utilityLocationID.style.display = 'table-cell';
                maintTypeID.style.display = 'none';
                maintAmountID.style.display = 'none';
                maintDueDateID.style.display = 'none';
                maintPaymentDateID.style.display = 'none';
                maintCommentsID.style.display = 'none';
                maintActionID.style.display = 'table-cell';
            } else {
                utilityTypeContainer.style.display = 'none';
                locationContainer.style.display = 'none';
                maintTypeContainer.style.display = 'none';

                snoID.style.display = 'none';
                utilityTypeID.style.display = 'none';
                utilityAmountID.style.display = 'none';
                utilityDueDateID.style.display = 'none';
                utilityLocationID.style.display = 'none';
                maintTypeID.style.display = 'none';
                maintAmountID.style.display = 'none';
                maintDueDateID.style.display = 'none';
                maintPaymentDateID.style.display = 'none';
                maintCommentsID.style.display = 'none';
                maintActionID.style.display = 'none';
            }
        }
    </script>


    <script>
        // document.addEventListener("DOMContentLoaded", function() {
        //     // Load data on page load with default value (10)
        //     load_expensesReports_Data();

        // });

        // function load_expensesReports_Data() {

        //     let loadSearchMonth = document.getElementById('searchMonth').value;
        //     let loadSearchDropdown = $("#searchDropdown").val();

        //     $.ajax({
        //         url: 'admin-index.php',
        //         type: 'POST',
        //         dataType: 'json',
        //         data: {
        //             action: 'load-expensesReports-Data',
        //             loadSearchMonth: loadSearchMonth,
        //             loadSearchDropdown: loadSearchDropdown
        //         },
        //         success: function(response) {
        //             console.log(response);
        //             // Update the result div with the loaded data
        //             $("#expensesReportsData").html(response.data);
        //         },
        //     });
        // }




        // =========== function searching =============
        function search_expensesReports_Data() {

            let selectUtilityMaint = document.getElementById('selectUtilityMaint').value;
            let searchUtilityType = document.getElementById('searchUtilityType').value;
            let searchLocation = document.getElementById('searchLocation').value;
            let searchMaintType = document.getElementById('searchMaintType').value;
            let searchMonth = document.getElementById('searchMonth').value;
            let searchDropdown = $("#searchDropdown").val();


            $.ajax({
                url: 'admin-index.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'search-expensesReports-Data',
                    selectUtilityMaint: selectUtilityMaint,
                    searchUtilityType: searchUtilityType,
                    searchLocation: searchLocation,
                    searchMaintType: searchMaintType,
                    searchMonth: searchMonth,
                    searchDropdown: searchDropdown
                },
                success: function(response) {
                    console.log(response);
                    // Update the result div with the loaded data
                    $("#expensesReportsData").html(response.data);
                },
            });
        }
    </script>


</body>

</html>