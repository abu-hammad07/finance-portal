<?php
session_start();
include_once ("includes/config.php");
include "includes/function.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
// updateTenants();
?>

<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">View Tenant</h4>
    <!-- End:Title -->

    <?php
    if (isset($_GET['tenant_view_id'])) {
        $edit_id = mysqli_real_escape_string($conn, $_GET['tenant_view_id']);
        $edit_query = "SELECT tenants.*, houses.house_id, houses.house_number, houses.owner_name, houses.owner_contact
                From tenants
                INNER JOIN houses ON tenants.house_id = houses.house_id
                WHERE tenants.tenant_id = '$edit_id'";
        $edit_result = mysqli_query($conn, $edit_query);

        if (mysqli_num_rows($edit_result) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_assoc($edit_result)) {
                ?>

                <form action="" method="post" id="add_houses_form" enctype="multipart/form-data">
                    <div class="card h-auto">
                        <div class="card-body">
                            <h3 class="card-header">Information</h3>
                            <hr class="my-4">
                            <div class="row g-3">
                                <input type="text" hidden name="tenant_id" class="form-control" value="<?= $row['tenant_id'] ?>">
                                <div class="col-md-6">
                                    <label class="form-label">House/Unit Number</label>
                                    <select name="house_id" id="house_id" class="form-select form-control house-id" required>
                                        <option value="<?= $row['house_id'] ?>"><?= $row['house_number'] ?></option>
                                    </select>
                                    <!-- <span class="text-danger" id="house_id_error"></span> -->
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Owner's Name</label>
                                    <select id="owner_name" class="form-select form-control">
                                        <option value="<?= $row['owner_name'] ?>"><?= $row['owner_name'] ?></option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Owner's Contact</label>
                                    <select id="owner_contact" class="form-select form-control">
                                        <option value="<?= $row['owner_contact'] ?>"><?= $row['owner_contact'] ?></option>
                                    </select>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Tenant's Name</label>
                                    <input type="text" readonly id="tenant-name" name="tenant_name" class="form-control"
                                        placeholder="Enter Tenant's Name" value="<?= $row['tenant_name'] ?>" required>
                                    <!-- <span class="text-danger" id="tenants-name_error"></span> -->
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Tenant's Contact Number</label>
                                    <input type="number" readonly id="tenant-contact" name="tenant_contact" class="form-control"
                                        placeholder="03XXXXXXXXX" value="<?= $row['tenant_contact_no'] ?>" required>
                                    <!-- <span class="text-danger" id="tenant-contact_error"></span> -->
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Tenant's CNIC</label>
                                    <input type="number" readonly id="tenant-contact" name="tenant_cnic" class="form-control"
                                        placeholder="XXXXX-XXXXXXX-X" value="<?= $row['tenant_cnic'] ?>" required>
                                    <!-- <span class="text-danger" id="tenant-cnic_error"></span> -->
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Tenant's Image</label>
                                    <!-- <input type="file" id="tenant-contact" name="tenant_image" class="form-control"> -->
                                    <!-- <span class="text-danger" id="tenant-image_error"></span> -->
                                    <div class="fs-4">
                                        <img src="media/images/<?= $row['tenant_image'] ?>" alt="" height="250px" width="250px">
                                    </div>
                                </div>

                                <!-- Button -->
                                <div class="col-md-12">
                                    <a href="tenants" class="btn btn-danger">Back</a>
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

<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->