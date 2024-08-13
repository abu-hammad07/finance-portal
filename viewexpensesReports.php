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
    <h4 class="mb-4 text-capitalize">Expenses Reports</h4>
    <!-- End:Title -->

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card card-body h-auto d2c_projects_datatable">
                <div class="row g-3">
                    <div class="col-md-4 col-6">
                        <select id="selectUtilityMaint" class="form-select form-control"
                            onchange="handleSelectionChange()">
                            <option value="">Select Utility/Maintenance</option>
                            <option value="Utility Charges">Utility Charges</option>
                            <option value="Society Maintenance">Society Maintenance</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-6" id="utilityTypeContainer" style="display: none;">
                        <input type="text" class="form-control" id="searchUtilityType" placeholder="Utility Type..." />
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
                    <div class="col-md-4 col-6" id="maintTypeContainer" style="display: none;">
                        <input type="text" class="form-control" id="searchMaintType"
                            placeholder="Maintenance Type..." />
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
                            onclick="search_expensesReports_Data()">Search</button>
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
                            Reports
                        </h4>
                    </div>
                    <div class="col-md-6 text-end card-header">
                        <div class="btn-group">
                            <!-- Utility Charges -->
                            <div class="me-2 excelUtilityCharges" style="display: none;">
                                <a class="d2c_pdf_btn text-center justify-content-center text-decoration-none text-primary"
                                    href="excels/utilityChargesExcel" target="_blank">
                                    <span><i class="fas fa-file-pdf mt-2"></i></span>
                                </a>
                            </div>
                            <!-- Maintenance -->
                            <div class="me-2 excelSocietyMaintenance" style="display: none;">
                                <a class="d2c_pdf_btn text-center justify-content-center text-decoration-none text-primary"
                                    href="excels/societyMaintenanceExcel" target="_blank">
                                    <span><i class="fas fa-file-pdf mt-2"></i></span>
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
                                    <!-- --------------------all----------------- -->
                                    <th class="snoID" style="display: none;">S.No</th>
                                    <!-- --------------------Utility----------------- -->
                                    <th class="utilityID" style="display: none;">Utility Type</th>
                                    <th class="utilityID" style="display: none;">Amount</th>
                                    <th class="utilityID" style="display: none;">Billing Month</th>
                                    <th class="utilityID" style="display: none;">Location</th>
                                    <!-- --------------------Maintenace----------------- -->
                                    <th class="maintID" style="display: none;">Maintenance Type</th>
                                    <th class="maintID" style="display: none;">Amount</th>
                                    <th class="maintID" style="display: none;">Due Date</th>
                                    <th class="maintID" style="display: none;">Payment Date</th>
                                    <th class="maintID" style="display: none;">Comments</th>
                                    <!-- --------------------All----------------- -->
                                    <th class="actionID" style="display: none;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="expensesReportsData">
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
    function handleSelectionChange() {
        var select = document.getElementById("selectUtilityMaint");
        var selectedValue = select.value;

        // Hide all columns first
        var allColumns = document.querySelectorAll('th, td');
        allColumns.forEach(function (col) {
            col.style.display = 'none';
        });

        // Hide all buttons first
        var allButtons = document.querySelectorAll('.excelUtilityCharges, .excelSocietyMaintenance');
        allButtons.forEach(function (btn) {
            btn.style.display = 'none';
        });

        // Show relevant columns and buttons based on selection
        if (selectedValue === "Utility Charges") {
            showColumns(['snoID', 'utilityID', 'actionID']);
            showButtons(['excelUtilityCharges']);
        } else if (selectedValue === "Society Maintenance") {
            showColumns(['snoID', 'maintID', 'actionID']);
            showButtons(['excelSocietyMaintenance']);
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
            success: function (response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#expensesReportsData").html(response.data);
            },
        });
    }
</script>