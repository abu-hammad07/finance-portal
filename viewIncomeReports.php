<?php
session_start();
include_once ("includes/config.php");
include_once ("includes/function.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
?>


<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
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
                        <select id="selectIncomeReport" class="form-select form-control"
                            onchange="handleSelectionChange()">
                            <option value="">Select Income Report</option>
                            <option value="E-Gate Pass">E-Gate Pass</option>
                            <option value="Servants">Servants</option>
                            <option value="Events Booking">Events Booking</option>
                            <option value="Maintenance Charges">Maintenance Charges</option>
                            <option value="Penalty Charges">Penalty Charges</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-6">
                        <input type="month" class="form-control" id="searchMonth"
                            onchange="load_expensesReports_Data()" />
                    </div>
                    <div class="col-md-4 col-6">
                        <select id="searchDropdown" class="form-select form-control"
                            onchange="load_expensesReports_Data()">
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="75">75</option>
                            <option value="100">100</option>
                            <option value="125">125</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-6">
                        <button class="btn btn-primary w-100" id="submit_btn" type="submit"
                            onclick="search_incomeReports_Data()">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card h-auto d2c_projects_datatable">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-header">
                                Reports
                            </h4>
                        </div>
                        <div class="col-md-6 text-end card-header">
                            <div class="btn-group">
                                <!-- eGate -->
                                <div class="me-2 eGateExcel" style="display: none;">
                                    <a class="d2c_pdf_btn text-center justify-content-center text-decoration-none text-primary"
                                        href="excels/eGateExcel">
                                        <span><i class="fas fa-file-pdf mt-2"></i></span>
                                    </a>
                                </div>
                                <!-- Servents -->
                                <div class="me-2 servantsExcel" style="display: none;">
                                    <a class="d2c_pdf_btn text-center justify-content-center text-decoration-none text-primary"
                                        href="excels/servantsExcel">
                                        <span><i class="fas fa-file-pdf mt-2"></i></span>
                                    </a>
                                </div>
                                <!-- Events Booking -->
                                <div class="me-2 eventsExcel" style="display: none;">
                                    <a class="d2c_pdf_btn text-center justify-content-center text-decoration-none text-primary"
                                        href="excels/eventsDetailsExcel">
                                        <span><i class="fas fa-file-pdf mt-2"></i></span>
                                    </a>
                                </div>
                                <!-- Maintenance -->
                                <div class="me-2 maintenanceExcel" style="display: none;">
                                    <a class="d2c_pdf_btn text-center justify-content-center text-decoration-none text-primary"
                                        href="excels/maintenanceChargesExcel">
                                        <span><i class="fas fa-file-pdf mt-2 "></i></span>
                                    </a>
                                </div>
                                <!-- Penalty -->
                                <div class="me-2 penaltyExcel" style="display: none;">
                                    <a class="d2c_pdf_btn text-center justify-content-center text-decoration-none text-primary"
                                        href="excels/penaltyExcel">
                                        <span><i class="fas fa-file-pdf mt-2"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive">
                        <table class="table" id="d2c_advanced_table_2">
                            <thead>
                                <tr>
                                    <!-- ------------Tenant------------- -->
                                    <!-- ----------all start------------------ -->
                                    <th class="snoID" style="display: none;">S.No</th>
                                    <!-- ----------all end------------------ -->
                                    <!-- ----------Egat, Servant & Maintenance Allow Start------------------ -->
                                    <th class="houseShopID" style="display: none;">House/Shop Number</th>
                                    <!-- ----------Egat, Servant & Maintenance Allow end------------------ -->
                                    <!-- ------------Egat ------------- -->
                                    <th class="eGatID" style="display: none;">Person Name</th>
                                    <th class="eGatID" style="display: none;">Vehicle Name</th>
                                    <th class="eGatID" style="display: none;">Vehicle Number</th>
                                    <th class="eGatID" style="display: none;">Charges</th>
                                    <!-- ------------Servant------------- -->
                                    <th class="servantID" style="display: none;">Owner Name</th>
                                    <th class="servantID" style="display: none;">Designation</th>
                                    <th class="servantID" style="display: none;">Fees</th>
                                    <!-- ------------event booking------------- -->
                                    <th class="eventBookingID" style="display: none;">Event Name</th>
                                    <th class="eventBookingID" style="display: none;">Customer Name</th>
                                    <th class="eventBookingID" style="display: none;">Location</th>
                                    <th class="eventBookingID" style="display: none;">Booking Date</th>
                                    <th class="eventBookingID" style="display: none;">Payment</th>
                                    <!-- ------------Maintenance------------- -->
                                    <th class="maintenanceID" style="display: none;">House / Shop</th>
                                    <th class="maintenanceID" style="display: none;">Maintenance Month</th>
                                    <th class="maintenanceID" style="display: none;">Maintenance Charges</th>
                                    <th class="maintenanceID" style="display: none;">Status</th>
                                    <!-- ------------Penalty------------- -->
                                    <th class="penaltyID" style="display: none;">Penalty type</th>
                                    <th class="penaltyID" style="display: none;">Penalty Cnic</th>
                                    <th class="penaltyID" style="display: none;">Penalty Charges</th>
                                    <th class="penaltyID" style="display: none;">Penalty Date</th>
                                    <!-- --------------------all----------------- -->
                                    <th class="ActionID" style="display: none;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="incomeReportsData">
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

<!-- Start: Footer -->
<?php include_once ('includes/footer.php'); ?>
<!-- End: Footer -->


<!-- <script>
    function handleSelectionChange() {
        var select = document.getElementById("selectIncomeReport");
        var selectedValue = select.value;

        // Hide all columns first
        var allColumns = document.querySelectorAll('th, td');
        allColumns.forEach(function (col) {
            col.style.display = 'none';
        });

        // Show relevant columns based on selection
        if (selectedValue === "E-Gate Pass") {
            showColumns(['snoID', 'houseShopID', 'eGatID', 'ActionID']);
        } else if (selectedValue === "Servants") {
            showColumns(['snoID', 'houseShopID', 'servantID', 'ActionID']);
        } else if (selectedValue === "Events Booking") {
            showColumns(['snoID', 'eventBookingID', 'ActionID']);
        } else if (selectedValue === "Maintenance Charges") {
            showColumns(['snoID', 'houseShopID', 'maintenanceID', 'ActionID']);
        } else if (selectedValue === "Penalty Charges") {
            showColumns(['snoID', 'penaltyID', 'ActionID']);
        }
    }

    function showColumns(classList) {
        classList.forEach(function (className) {
            var columns = document.querySelectorAll('.' + className);
            columns.forEach(function (col) {
                col.style.display = '';
            });
        });
    }

    // Initialize by calling handleSelectionChange on page load to ensure the correct columns are shown based on any pre-selected value.
    document.addEventListener('DOMContentLoaded', handleSelectionChange);
</script> -->


<script>
    function handleSelectionChange() {
        var select = document.getElementById("selectIncomeReport");
        var selectedValue = select.value;

        // Hide all columns first
        var allColumns = document.querySelectorAll('th, td');
        allColumns.forEach(function (col) {
            col.style.display = 'none';
        });

        // Hide all buttons first
        var allButtons = document.querySelectorAll('.eGateExcel, .servantsExcel, .eventsExcel, .maintenanceExcel, .penaltyExcel');
        allButtons.forEach(function (btn) {
            btn.style.display = 'none';
        });

        // Show relevant columns and buttons based on selection
        if (selectedValue === "E-Gate Pass") {
            showColumns(['snoID', 'houseShopID', 'eGatID', 'ActionID']);
            showButtons(['eGateExcel']);
        } else if (selectedValue === "Servants") {
            showColumns(['snoID', 'houseShopID', 'servantID', 'ActionID']);
            showButtons(['servantsExcel']);
        } else if (selectedValue === "Events Booking") {
            showColumns(['snoID', 'eventBookingID', 'ActionID']);
            showButtons(['eventsExcel']);
        } else if (selectedValue === "Maintenance Charges") {
            showColumns(['snoID', 'houseShopID', 'maintenanceID', 'ActionID']);
            showButtons(['maintenanceExcel']);
        } else if (selectedValue === "Penalty Charges") {
            showColumns(['snoID', 'penaltyID', 'ActionID']);
            showButtons(['penaltyExcel']);
        }
    }

    function showColumns(classList) {
        classList.forEach(function (className) {
            var columns = document.querySelectorAll('.' + className);
            columns.forEach(function (col) {
                col.style.display = '';
            });
        });
    }

    function showButtons(buttonList) {
        buttonList.forEach(function (btnClass) {
            var buttons = document.querySelectorAll('.' + btnClass);
            buttons.forEach(function (btn) {
                btn.style.display = 'block';
            });
        });
    }

    // Initialize by calling handleSelectionChange on page load to ensure the correct columns and buttons are shown based on any pre-selected value.
    document.addEventListener('DOMContentLoaded', handleSelectionChange);
</script>


<script>

    // =========== function searching =============
    function search_incomeReports_Data() {

        let selectIncomeReport = document.getElementById('selectIncomeReport').value;
        let searchMonth = document.getElementById('searchMonth').value;
        let searchDropdown = $("#searchDropdown").val();


        $.ajax({
            url: 'admin-index.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'search-incomeReports-Data',
                selectIncomeReport: selectIncomeReport,
                searchMonth: searchMonth,
                searchDropdown: searchDropdown
            },
            success: function (response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#incomeReportsData").html(response.data);
            },
        });
    }
</script>