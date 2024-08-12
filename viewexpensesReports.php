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
                <div class="card-body">
                    <div class="table-responsive table-responsive">
                        <table class="table" id="d2c_advanced_table_2">
                            <thead>
                                <tr>
                                    <th id="snoID" style="display: none;">S.No</th>
                                    <th id="utilityTypeID" style="display: none;">Utility Type</th>
                                    <th id="utilityAmountID" style="display: none;">Amount</th>
                                    <th id="utilityDueDateID" style="display: none;">Billing Month</th>
                                    <th id="utilityLocationID" style="display: none;">Location</th>
                                    <th id="maintTypeID" style="display: none;">Maintenance Type</th>
                                    <th id="maintAmountID" style="display: none;">Amount</th>
                                    <th id="maintDueDateID" style="display: none;">Due Date</th>
                                    <th id="maintPaymentDateID" style="display: none;">Payment Date</th>
                                    <th id="maintCommentsID" style="display: none;">Comments</th>
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

<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->

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
            success: function (response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#expensesReportsData").html(response.data);
            },
        });
    }
</script>
