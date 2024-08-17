<?php
session_start();
include_once("includes/config.php");
include "includes/function.php";
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
deleteHouse();
?>

<!-- Main sidebar -->
<?php
include("includes/sidebar.php");
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
                    <div class="col-md-4 col-12 mt-2">
                        <form class="position-relative">
                            <input type="text" class="form-control product-search ps-5 word-spacing-2px"
                                id="house_shop_no-search" placeholder="Search House & Shop Number &nbsp;..." />
                            <i class="fas fa-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                        </form>
                    </div>
                    <div class="col-md-4 col-12 mt-2">
                        <select id="house_shop-type" class="form-select form-control">
                            <option value="">--- House OR Shop --</option>
                            <option value="House">House</option>
                            <option value="Shop">Shop</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-12 mt-2">
                        <input type="month" class="form-control" id="houses-month" onchange="load_houses_Data()">
                    </div>
                    <div class="col-md-4 col-12 mt-2">
                        <select id="houses-limit" class="form-control form-select" onchange="load_houses_Data()">
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="75">75</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-12 mt-2">
                        <button type="button" class="btn btn-primary w-100"
                            onclick="search_houses_Data()">Search</button>
                    </div>
                    <!-- <div class="col-md-8 col-xl-9 text-end">
                        <div class="btn-group">
                            <a href="addHouse" class="btn btn-primary"><i class="fas fa-plus"></i> House</a>
                        </div>
                    </div> -->
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
                                <a class="d2c_pdf_btn text-center justify-content-center text-decoration-none text-primary"
                                    href="excels/houseExcel">
                                    <span><i class="fas fa-file-pdf mt-2"></i></span>
                                </a>
                            </div>
                            <div class="mb-2">
                                <a href="addHouse" class="btn btn-primary"><i class="fas fa-plus"></i> House</a>
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
                                    <th>House & Shop Number</th>
                                    <th>House OR Shop</th>
                                    <th>Owner's Name</th>
                                    <th>Contact</th>
                                    <!-- <th>Owner's CNIC</th> -->
                                    <!-- <th>Occupancy Status</th> -->
                                    <th>charges</th>
                                    <th>Date</th>
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
        let housesMonth = $("#houses-month").val();


        $.ajax({
            url: 'admin-index.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load-houses-Data',
                housesLimited: housesLimited,
                housesMonth: housesMonth
            },
            success: function (response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#housesDetails").html(response.data);
            },
        });
    }


    // For Searching Houses
    function search_houses_Data() {

        let houseShopNoSearch = document.getElementById('house_shop_no-search').value;
        let houseShopType = document.getElementById('house_shop-type').value;
        let housesLimited = $("#houses-limit").val();
        let housesMonth = $("#houses-month").val();

        $.ajax({
            url: 'admin-index.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'search-houses-Data',
                houseShopNoSearch: houseShopNoSearch,
                houseShopType: houseShopType,
                housesLimited: housesLimited,
                housesMonth: housesMonth
            },
            success: function (response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#housesDetails").html(response.data);
            },
        });
    }

</script>


<!-- <div class="dropdown"><button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
        aria-expanded="false">Action</button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Edit</a></li>
        <li><a class="dropdown-item" href="#">Delete</a></li>
    </ul>
</div> -->

<!-- <a href="houseEdit.php?house_edit_id=' . $row['house_id'] . '">
    <span>
        <i class="fas fa-pencil-alt me-1 text-success"></i>
    </span>
</a>
<a class="" href="houseView.php?house_view_id=' . $row['house_id'] . '">
    <i class="fas fa-eye me-1 text-info"></i>
</a>
<button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal"
    data-bs-target="#deleteHouse' . $row['house_id'] . '" data-bs-placement="top" title="Delete">
    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i
            class="fas fa-trash  text-danger p-1 "></i></span>
</button>
<div class="modal fade" id="deleteHouse' . $row['house_id'] . '" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? House Number: <span
                        class="text-danger">' . $row['house_number'] . '</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">
                <p>Please confirm that you want to delete your Incometion. <br>
                    Once deleted, you won\'t be able to recover it. <br>
                    Please proceed with caution.
                </p>
            </div>
            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                <a href="?house_delete_id=' . $row['house_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->