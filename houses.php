<?php
session_start();
include_once ("includes/config.php");
include "includes/function.php";
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
deleteHouse();
?>

<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Society Houses</h4>
    <!-- End:Title -->

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card card-body h-auto d2c_projects_datatable">
                <div class="row">
                    <div class="col-md-4 col-xl-3">
                        <form class="position-relative">
                            <input type="text" class="form-control product-search ps-5 word-spacing-2px"
                                id="housesSearch" onkeyup="search_houses_Data()" placeholder="Search &nbsp;..." />
                            <i class="fas fa-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                        </form>
                    </div>
                    <div class="col-md-8 col-xl-9 text-end">
                        <div class="btn-group">
                            <!-- <a href="addTenant" class="btn btn-primary me-2"><i class="fas fa-plus"></i> Tenant</a> -->
                            <a href="addHouse" class="btn btn-primary"><i class="fas fa-plus"></i> House</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_updated_house'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_updated_house'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_updated_house']);
    }
    if (isset($_SESSION['error_updated_house'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_updated_house'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_updated_house']);
    }
    ?>
    <!-- / Alert -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card h-auto d2c_projects_datatable">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-header">Details</h4>
                    </div>
                    <div class="col-md-6 text-end card-header">
                        <div class="btn-group">
                            <div class="me-2">
                                <input type="month" class="form-control" id="">
                            </div>
                            <div class="me-2">
                                <select id="houses-limit" class="form-control" onchange="load_houses_Data()">
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="75">75</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="me-2">
                                <select id="houses-order" class="form-select" onchange="load_houses_Data()">
                                    <option value="ASC">Old</option>
                                    <option value="DESC">New</option>
                                </select>
                            </div>
                            <div class="me-2">
                                <a class="d2c_pdf_btn text-center justify-content-center text-decoration-none text-primary"
                                    href="">
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
                                    <th>S.No</th>
                                    <th>House Number</th>
                                    <th>Owner's Name</th>
                                    <th>Owner's Contact</th>
                                    <th>Owner's CNIC</th>
                                    <th>Occupancy Status</th>
                                    <th>maintenance charges</th>
                                    <th>Date of Entry</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="housesDetails">
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
        load_houses_Data();

    });

    function load_houses_Data() {

        let housesLimited = $("#houses-limit").val();
        let housesOrder = $("#houses-order").val();

        $.ajax({
            url: 'admin-index.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load-houses-Data',
                housesLimited: housesLimited,
                housesOrder: housesOrder
            },
            success: function (response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#housesDetails").html(response.data);
            },
        });
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Load data on page load with default value (10)
        search_houses_Data();

    });

    function search_houses_Data() {

        let housesSearch = document.getElementById('housesSearch').value;

        $.ajax({
            url: 'admin-index.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'search-houses-Data',
                housesSearch: housesSearch
            },
            success: function (response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#housesDetails").html(response.data);
            },
        });
    }
</script>