<?php
session_start();
include_once "includes/config.php";
include_once "includes/function.php";
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

// Update Servants
serventUpdate();
?>



<!-- Main sidebar -->
<?php
include("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">
    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Edit Servant</h4>
    <!-- End:Title -->

    <?php
    if (isset($_GET['servant_edit_id'])) {

        $servant_edit_id = mysqli_real_escape_string($conn, $_GET['servant_edit_id']);

        $query = "SELECT servants.*, houses.house_id, houses.house_number, houses.owner_name, houses.owner_contact
                    FROM servants
                    INNER JOIN houses ON servants.house_id = houses.house_id
                    WHERE servants.servant_id = '$servant_edit_id'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <form action="" method="post" id="add_servant_form" enctype="multipart/form-data">
                    <div class="card h-auto">
                        <div class="card-body">
                            <h3 class="card-header">Information</h3>
                            <hr class="my-4">
                            <div class="row g-3">
                                <input type="text" hidden name="servant_id" class="form-control" placeholder="Enter Designation"
                                    value="<?= $row['servant_id'] ?>" required>

                                <div class="col-md-6">
                                    <label class="form-label">House/Unit Number</label>
                                    <select name="house_id" id="house_id" class="form-select form-control house-id" required>
                                        <option value="<?= $row['house_id'] ?>"><?= $row['house_number'] ?></option>
                                    </select>
                                    <span class="text-danger" id="house_id_error"></span>
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
                                    <label class="form-label">Designation</label>
                                    <input type="text" id="designation" name="designation" class="form-control"
                                        placeholder="Enter Designation" value="<?= $row['servantDesignation'] ?>" required>
                                    <span class="text-danger" id="designation_error"></span>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Masi Name</label>
                                    <input type="text" name="masi_name" class="form-control" placeholder="Enter masi name" required value="<?= $row['masi_name'] ?>">
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Masi Contact</label>
                                    <input type="text" name="masi_contact" class="form-control" placeholder="Enter masi contact"
                                        required value="<?= $row['masi_contact'] ?>">
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Masi CNIC</label>
                                    <input type="text" name="masi_cnic" class="form-control" placeholder="Enter masi CNIC" required value="<?= $row['masi_cnic'] ?>">
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Masi Picture</label>
                                    <input type="file" name="image" class="form-control" required>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Fees</label>
                                    <input type="text" id="servant_fees" name="servant_fees" class="form-control" placeholder="999"
                                        value="<?= $row['servantFees'] ?>" required>
                                    <span class="text-danger" id="servant_fees_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Payment Type</label>
                                    <select class="form-select form-control" id="pymentType" required name="pymentType">
                                        <option value=""> Select Payment Type</option>
                                        <option value="Cash" <?php if ($row['payment_type'] == 'Cash')
                                            echo 'selected'; ?>>Cash
                                        </option>
                                        <option value="Bank" <?php if ($row['payment_type'] == 'Bank')
                                            echo 'selected'; ?>>Bank
                                        </option>
                                    </select>
                                </div>

                                <!-- Button -->
                                <div class="col-md-12">
                                    <button class="btn btn-primary" id="servant_btn" type="submit"
                                        name="serventUpdate">Update</button>
                                    <a href="servants" class="btn btn-outline-danger">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <?php
            }
        } else {
            header('location: 404');
            exit();
        }
    }
    ?>


    <!-- End:submit btn -->
</div>
<!-- End:Main Body -->
</div>

<!-- Start: Footer -->
<?php include_once 'includes/footer.php'; ?>
<!-- End: Footer -->