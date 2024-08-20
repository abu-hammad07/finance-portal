<?php
session_start();
include_once("includes/config.php");
include "includes/function.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
updateHouse();
?>

<!-- Main sidebar -->
<?php
include("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Edit House</h4>
    <!-- End:Title -->

    <?php
    if (isset($_GET['house_edit_id'])) {
        $edit_id = mysqli_real_escape_string($conn, $_GET['house_edit_id']);
        $edit_query = "SELECT * FROM houses WHERE house_id = '$edit_id'";
        $edit_result = mysqli_query($conn, $edit_query);

        if (mysqli_num_rows($edit_result) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_assoc($edit_result)) {
    ?>
                <form action="" method="post" id="add_houses_form">
                    <div class="card h-auto">
                        <div class="card-body">
                            <h3 class="card-header">Information</h3>
                            <hr class="my-4">
                            <div class="row g-3">
                                <input type="text" hidden name="house_id" value="<?= $row['house_id'] ?>">
                                <div class="col-md-6 ">
                                    <label for="house_or_shop" class="form-label">House OR Shop</label>
                                    <select id="house_or_shop" name="house_or_shop" class="form-select form-control">
                                        <option value="">-----</option>
                                        <option value="House" <?php if ($row['house_or_shop'] == 'House') echo 'selected' ?>>House</option>
                                        <option value="Shop" <?php if ($row['house_or_shop'] == 'Shop') echo 'selected' ?>>Shop</option>
                                    </select>
                                    <span class="text-danger" id="property-type_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">House/Unit Number</label>
                                    <input type="text" name="house-number" class="form-control"
                                        placeholder="House/Shop Number" required value="<?= $row['house_number'] ?>">
                                    <span class="text-danger" id="house-number_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Owner's Name</label>
                                    <input type="text" name="owner-name" class="form-control" placeholder="Enter Owner's Name"
                                        required value="<?= $row['owner_name'] ?>">
                                    <span class="text-danger" id="owner-name_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="OwnerContact" class="form-label">Owner's Contact</label>
                                    <input type="text" id="OwnerContact" name="owner-contact" class="form-control"
                                        placeholder="Enter Owner's Contact Information" required
                                        value="<?= $row['owner_contact'] ?>">
                                    <span class="text-danger" id="owner-contact_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="OwnerCnic" class="form-label">Owner's CINC</label>
                                    <input type="text" id="OwnerCnic" name="owner-cinc" class="form-control" placeholder="XXXXX-XXXXXXX-X"
                                        value="<?= $row['owner_cnic'] ?>" required>
                                    <span class="text-danger" id="owner-cinc_error"></span>
                                </div>

                                <div class="col-md-6" id="Shopstatus">
                                    <label for="owner" class="form-label">Occupancy Status</label>
                                    <select id="occupance-status" name="occupance-status" class="form-select form-control">
                                        <option value="">-----</option>
                                        <option <?php if ($row['occupancy_status'] == 'owned')
                                                    echo 'selected' ?> value="owned">Owned</option>
                                        <option <?php if ($row['occupancy_status'] == 'rented')
                                                    echo 'selected' ?> value="rented">Rented</option>
                                    </select>
                                    <span class="text-danger" id="occupance-status_error"></span>
                                </div>

                                <div class="col-md-6 ">
                                    <label for="floor" class="form-label">Floor</label>
                                    <select id="floor" name="floor" class="form-select form-control">
                                        <!-- <option value="">-----</option> -->
                                        <option value="ground" <?php if ($row['floor'] == 'ground')
                                                                    echo 'selected' ?>>Ground</option>
                                        <option value="floor1" <?php if ($row['floor'] == 'floor1')
                                                                    echo 'selected' ?>>Floor 1
                                        </option>
                                        <option value="floor2" <?php if ($row['floor'] == 'floor2')
                                                                    echo 'selected' ?>>Floor 2
                                        </option>
                                        <option value="floor3" <?php if ($row['floor'] == 'floor3')
                                                                    echo 'selected' ?>>Floor 3
                                        </option>
                                        <option value="floor4" <?php if ($row['floor'] == 'floor4')
                                                                    echo 'selected' ?>>Floor 4
                                        </option>
                                    </select>
                                    <span class="text-danger" id="floor_error"></span>
                                </div>
                                <div class="col-md-6 ">
                                    <label for="property-type" class="form-label">Type of Property</label>
                                    <select id="property-type" name="property-type" class="form-select form-control">
                                        <!-- <option value="">-----</option> -->
                                        <option value="Apartment" <?php if ($row['property_type'] == 'Apartment')
                                                                        echo 'selected' ?>>
                                            Apartment</option>
                                        <option value="Duplex" <?php if ($row['property_type'] == 'Duplex')
                                                                    echo 'selected' ?>>Duplex
                                        </option>
                                    </select>
                                    <span class="text-danger" id="property-type_error"></span>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Size/Area of the Property</label>
                                    <select id="size" name="property-size" class="form-select form-control">
                                        <!-- <option value="">-----</option> -->
                                        <option value="60 yards" <?php if ($row['property_size'] == '60 yards')
                                                                        echo 'selected' ?>>60
                                            yards</option>
                                        <option value="120 yards" <?php if ($row['property_size'] == '120 yards')
                                                                        echo 'selected' ?>>
                                            120 yards</option>
                                        <option value="240 yards" <?php if ($row['property_size'] == '240 yards')
                                                                        echo 'selected' ?>>
                                            240 yards</option>
                                        <option value="520 yards" <?php if ($row['property_size'] == '520 yards')
                                                                        echo 'selected' ?>>
                                            520 yards</option>
                                    </select>
                                    <span class="text-danger" id="property-size_error"></span>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Monthly Maintenance Fee</label>
                                    <input name="maintenance-charges" type="number" class="form-control"
                                        placeholder="Enter Monthly Maintenance Fee" required
                                        value="<?= $row['maintenance_charges'] ?>">
                                    <span class="text-danger" id="maintenance-charges_error"></span>
                                </div>

                                <!-- Button -->
                                <div class="col-md-12">
                                    <button class="btn btn-primary" id="submit_btn" type="submit" name="update">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
    <?php
            }
        } else {
            echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    No House Found.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    }
    ?>
</div>
<!-- End:Main Body -->
</div>

<script>
       var OwnerContact = document.getElementById('OwnerContact');
    var OwnerCnic = document.getElementById('OwnerCnic');
    OwnerContact.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    var OwnerCnic = document.getElementById('OwnerCnic');

    OwnerCnic.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9-]/g, '');
        if (this.value.length > 5 && this.value[5] !== '-') {
            this.value = this.value.slice(0, 5) + '-' + this.value.slice(5);
        }
        if (this.value.length > 13 && this.value[13] !== '-') {
            this.value = this.value.slice(0, 13) + '-' + this.value.slice(13);
        }
        if (this.value.length > 15) {
            this.value = this.value.slice(0, 15);
        }
    });
</script>
<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->