<?php
session_start();
include_once("includes/config.php");
include "includes/function.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
addShopInsert();
?>
<!DOCTYPE html>
<html lang="en">
<!-- Main sidebar -->
<?php
include("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Add Shop</h4>
    <!-- End:Title -->

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_added_shop'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_added_shop'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_added_shop']);
    }
    if (isset($_SESSION['error_added_shop'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_added_shop'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_added_shop']);
    }
    ?>
    <!-- / Alert -->

    <form action="" method="post" id="add_shop_form">
        <div class="card h-auto">
            <div class="card-body">
                <h3 class="card-header">Information</h3>
                <hr class="my-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Shop Number</label>
                        <input type="text" id="shop_number" name="shop_number" class="form-control" placeholder="Enter House/Unit Number" required>
                        <span class="text-danger" id="shop_number_error"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner's Name</label>
                        <input type="text" name="owner_name" id="owner_name" class="form-control" placeholder="Enter Owner's Name">
                        <span class="text-danger" id="owner_name_error"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner's Contact Number</label>
                        <input type="text" name="owner_contact" id="owner_contact" class="form-control" placeholder="03XXXXXXXXX">
                        <span class="text-danger" id="owner_contact_error"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner's CINC</label>
                        <input type="text" name="owner_cinc" id="owner_cinc" class="form-control" placeholder="XXXXX-XXXXXXX-X">
                        <span class="text-danger" id="owner_cinc_error"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="owner" class="form-label">Occupancy Status</label>
                        <select id="occupancy_status" name="occupancy_status" class="form-select form-control">
                            <option value="">-----</option>
                            <option value="owned">Owned</option>
                            <option value="rented">Rented</option>
                        </select>
                        <span class="text-danger" id="occupancy_status_error"></span>
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
                        <label class="form-label">Size/Area of the Property</label>
                        <select id="property_size" name="property_size" class="form-select form-control">
                            <option value="">-----</option>
                            <option value="60 yards">60 yards</option>
                            <option value="120 yards">120 yards</option>
                            <option value="240 yards">240 yards</option>
                            <option value="520b yards">520 yards</option>
                        </select>
                        <span class="text-danger" id="property_size_error"></span>
                    </div>
                    <div class="col-md-6 ">
                        <label class="form-label">Monthly Maintenance Fee</label>
                        <input name="maintenance_charges" id="maintenance_charges" type="text" class="form-control" placeholder="Enter Monthly Maintenance Fee">
                        <span class="text-danger" id="maintenance_charges_error"></span>
                    </div>

                    <!-- Button -->
                    <div class="col-md-12">
                        <button class="btn btn-primary" id="shop_btn" type="submit" name="submit">Add Now</button>
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