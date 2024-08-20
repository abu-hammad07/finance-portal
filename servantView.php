<?php
session_start();
include_once("includes/config.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

?>


<!-- Main sidebar -->
<?php
include("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">
    <!-- Title -->
    <h4 class="mb-4 text-capitalize">View Servant</h4>
    <!-- End:Title -->

    <?php
    if (isset($_GET['servant_view_id'])) {

        $servant_view_id = mysqli_real_escape_string($conn, $_GET['servant_view_id']);

        $query = "SELECT servants.*, houses.house_id, houses.house_number, houses.owner_name, houses.owner_contact
                FROM servants
                INNER JOIN houses ON servants.house_id = houses.house_id
                    WHERE servants.servant_id = '$servant_view_id'";
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
                                    <input type="text" readonly id="designation" name="designation" class="form-control"
                                        placeholder="Enter Designation" value="<?= $row['servantDesignation'] ?>" required>
                                    <span class="text-danger" id="designation_error"></span>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Masi Name</label>
                                    <input type="text" name="masi_name" class="form-control" placeholder="Enter masi name" required
                                        value="<?= $row['masi_name'] ?>">
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Masi Contact</label>
                                    <input type="text" name="masi_contact" class="form-control" placeholder="Enter masi contact"
                                        required value="<?= $row['masi_contact'] ?>">
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Masi CNIC</label>
                                    <input type="text" name="masi_cnic" class="form-control" placeholder="Enter masi CNIC" required
                                        value="<?= $row['masi_cnic'] ?>">
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Fees</label>
                                    <input type="text" readonly id="servant_fees" name="servant_fees" class="form-control"
                                        placeholder="999" value="<?= $row['servantFees'] ?>" required>
                                    <span class="text-danger" id="servant_fees_error"></span>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Payment Type</label>
                                    <input type="text" readonly id="pymentType" name="pymentType" class="form-control"
                                        value="<?= $row['payment_type'] ?>" required>
                                    <span class="text-danger" id="pymentType"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="form-file">Masi Picture</label><br>
                                    <div class="justify-content-center text-center">
                                        <img src="media/images/<?= $row['masi_picture'] ?>"
                                            class="img-fluid img-thumbnail" alt="picture" height="200px"
                                            width="200px">
                                    </div>
                                </div>

                                <!-- Button -->
                                <div class="col-md-12">
                                    <!-- <button class="btn btn-primary" id="servant_btn" type="submit" name="serventUpdate">Update</button> -->
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