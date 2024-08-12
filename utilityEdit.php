<?php
session_start();
include_once ("includes/config.php");
include_once ("includes/function.php");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
updatedUtilityCharges();
?>

<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Edit Utility Charges</h4>
    <!-- End:Title -->

    <?php
    if (isset($_GET['utility_edit_id'])) {

        $utility_edit_id = mysqli_real_escape_string($conn, $_GET['utility_edit_id']);

        $query = "SELECT * FROM utility_charges WHERE utility_id = '$utility_edit_id'";
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
                                <input type="text" hidden name="utility_id" id="utility_id" class="form-control"
                                    value="<?= $row['utility_id'] ?>">
                                <div class="col-md-6">
                                    <label class="form-label">Utility Type</label>
                                    <input type="text" name="utility_type" id="utility_type" class="form-control"
                                        placeholder="Electricity" required value="<?= $row['utility_type'] ?>">
                                    <span class="text-danger" id="utility_type_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Amount</label>
                                    <input type="number" name="utility_amount" id="utility_amount" class="form-control"
                                        placeholder="$100" required value="<?= $row['utility_amount'] ?>">
                                    <span class="text-danger" id="utility_amount_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Billing Month</label>
                                    <input type="month" name="utility_billing_month" id="utility_billing_month" class="form-control"
                                        required value="<?= $row['utility_billing_month'] ?>">
                                    <span class="text-danger" id="utility_billing_month_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Location</label>
                                    <select name="utility_location" id="utility_location" class="form-select form-control" required>
                                        <option value="" <?php if ($row['utility_location'] == '')
                                            echo 'selected'; ?>>Select Location
                                        </option>
                                        <option value="Office" <?php if ($row['utility_location'] == 'Office')
                                            echo 'selected'; ?>>
                                            Office</option>
                                        <option value="Sports Area" <?php if ($row['utility_location'] == 'Sports Area')
                                            echo 'selected'; ?>>Sports Area</option>
                                        <option value="Shadi Hall" <?php if ($row['utility_location'] == 'Shadi Hall')
                                            echo 'selected'; ?>>Shadi Hall</option>
                                        <option value="Other" <?php if ($row['utility_location'] == 'Other')
                                            echo 'selected'; ?>>Other
                                        </option>
                                    </select>
                                    <span class="text-danger" id="utility_location_error"></span>
                                </div>

                                <!-- Button -->
                                <div class="col-md-12">
                                    <button class="btn btn-primary" id="submit_btn" type="submit"
                                        name="update_utility">Update</button>
                                    <a href="utilityCharges" class="btn btn-outline-danger">Back</a>
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
 
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $("#house_shop_id").select2();
    });
</script>