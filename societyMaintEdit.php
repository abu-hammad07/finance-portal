<?php
session_start();
include_once("includes/config.php");
include_once("includes/function.php");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
updateSocietyMaintenance();
?>

        <!-- Main sidebar -->
        <?php
        include("includes/sidebar.php");
        ?>
        <!-- End:Sidebar -->

        <!-- Main Body-->
        <div class="d2c_main p-4 ps-lg-3">

            <!-- Title -->
            <h4 class="mb-4 text-capitalize">Edit Society Maintenance</h4>
            <!-- End:Title -->

            <?php
            if (isset($_GET['societyMaint_edit_id'])) {

                $societyMaint_edit_id = mysqli_real_escape_string($conn, $_GET['societyMaint_edit_id']);

                $query = "SELECT * FROM society_maintenance WHERE society_maint_id = '$societyMaint_edit_id'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
            ?>

                        <form action="" method="post" id="add_houses_form">
                            <div class="card h-auto">
                                <div class="card-body">
                                    <h3 class="card-header">Information</h3>
                                    <hr class="my-4">
                                    <div class="row g-3">
                                        <input type="text" hidden name="society_maint_id" class="form-control" value="<?= $row['society_maint_id']; ?>">
                                        <div class="col-md-6">
                                            <label class="form-label">Maintenance Type</label>
                                            <input type="text" name="society_maint_type" id="society_maint_type" class="form-control" placeholder="Security" required value="<?= $row['society_maint_type']; ?>">
                                            <span class="text-danger" id="society_maint_type_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Amount</label>
                                            <input type="number" name="society_maint_amount" id="society_maint_amount" class="form-control" placeholder="$100" required value="<?= $row['society_maint_amount']; ?>">
                                            <span class="text-danger" id="society_maint_amount_error"></span>
                                        </div>
                                       
                                        <div class="col-md-6">
                                            <label class="form-label">Payment Date</label>
                                            <input type="date" name="society_maint_paymentDate" id="society_maint_paymentDate" class="form-control" value="<?= $row['society_maint_paymentDate']; ?>" required>
                                            <span class="text-danger" id="society_maint_paymentDate_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Remarks/Comments</label>
                                            <input type="text" name="society_maint_comments" id="society_maint_comments" placeholder="Monthly charge" class="form-control" value="<?= $row['society_maint_comments']; ?>">
                                            <span class="text-danger" id="society_maint_comments_error"></span>
                                        </div>

                                        <!-- Button -->
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" id="submit_btn" type="submit" name="societyMaintenance_update">Update</button>
                                            <a href="societyMaintenance" class="btn btn-outline-danger">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

            <?php
                    }
                } else {
                    echo '<div id="successAlert" class="alert alert-warning alert-dismissible fade show" role="alert">
                    No Data Found.</div>';
                }
            } else {
                echo '<div id="successAlert" class="alert alert-warning alert-dismissible fade show" role="alert">
                No ID Found.</div>';
            }
            ?>

        </div>
        <!-- End:Main Body -->
    </div>

<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->