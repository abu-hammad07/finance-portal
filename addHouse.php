<?php
session_start();
include_once ("includes/config.php");
include "includes/function.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
addHouse();
?>


<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Add House</h4>
    <!-- End:Title -->

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_message_house'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_message_house'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_message_house']);
    }
    if (isset($_SESSION['error_message_house'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_message_house'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_message_house']);
    }
    ?>
    <!-- / Alert -->

    <form action="" method="post" id="add_houses_form">
        <div class="card h-auto">
            <div class="card-body">
                <h3 class="card-header">Information</h3>
                <hr class="my-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">House/Unit Number</label>
                        <input type="text" name="house-number" class="form-control"
                            placeholder="Enter House/Unit Number" required>
                        <span class="text-danger" id="house-number_error"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner's Name</label>
                        <input type="text" name="owner-name" class="form-control" placeholder="Enter Owner's Name"
                            required>
                        <span class="text-danger" id="owner-name_error"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner's Contact Number</label>
                        <input type="number" name="owner-contact" class="form-control" placeholder="03XXXXXXXXX"
                            required>
                        <span class="text-danger" id="owner-contact_error"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner's CINC</label>
                        <input type="number" name="owner-cinc" class="form-control" placeholder="XXXXX-XXXXXXX-X"
                            required>
                        <span class="text-danger" id="owner-cinc_error"></span>
                    </div>
                    <div class="col-md-6" style="display: none;">
                        <label for="owner" class="form-label">Occupancy Status</label>
                        <select id="owner" name="occupance-status" class="form-select form-control">
                            <option value="owned">Owned</option>
                            <!-- <option value="">-----</option>
                                    <option value="rented">Rented</option> -->
                        </select>
                        <span class="text-danger" id="occupance-status_error"></span>
                    </div>
                    <div class="col-md-6 ">
                        <label for="floor" class="form-label">Floor</label>
                        <select id="floor" name="floor" class="form-select form-control">
                            <option value="">-----</option>
                            <option value="ground">Ground</option>
                            <option value="floor1">Floor 1</option>
                            <option value="floor2">Floor 2</option>
                            <option value="floor3">Floor 3</option>
                            <option value="floor4">Floor 4</option>
                        </select>
                        <span class="text-danger" id="floor_error"></span>
                    </div>
                    <div class="col-md-6 ">
                        <label for="property-type" class="form-label">Type of Property</label>
                        <select id="property-type" name="property-type" class="form-select form-control">
                            <option value="">-----</option>
                            <option value="Apartment">Apartment</option>
                            <option value="Duplex">Duplex</option>
                        </select>
                        <span class="text-danger" id="property-type_error"></span>
                    </div>
                    <div class="col-md-6 ">
                        <label class="form-label">Size/Area of the Property</label>
                        <select id="size" name="property-size" class="form-select form-control">
                            <option value="">-----</option>
                            <option value="60 yards">60 yards</option>
                            <option value="120 yards">120 yards</option>
                            <option value="240 yards">240 yards</option>
                            <option value="520 yards">520 yards</option>
                        </select>
                        <span class="text-danger" id="property-size_error"></span>
                    </div>
                    <div class="col-md-6 ">
                        <label class="form-label">Monthly Maintenance Fee</label>
                        <input name="maintenance-charges" type="number" class="form-control"
                            placeholder="Enter Monthly Maintenance Fee" required>
                        <span class="text-danger" id="maintenance-charges_error"></span>
                    </div>

                    <!-- Button -->
                    <div class="col-md-12">
                        <button class="btn btn-primary" id="submit_btn" type="submit" name="submit">Add Now</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- End:Main Body -->
</div>


<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->