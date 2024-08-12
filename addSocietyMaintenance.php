<?php
session_start();
include_once ("includes/config.php");
include_once ("includes/function.php");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
insertSocietyMaintenance();
?>

<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Add Society Maintenance</h4>
    <!-- End:Title -->

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_message_societyMaint'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_message_societyMaint'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_message_societyMaint']);
    }
    if (isset($_SESSION['error_message_societyMaint'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_message_societyMaint'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_message_societyMaint']);
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
                        <label class="form-label">Maintenance Type</label>
                        <input type="text" name="society_maint_type" id="society_maint_type" class="form-control"
                            placeholder="Security" required>
                        <span class="text-danger" id="society_maint_type_error"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Amount</label>
                        <input type="number" name="society_maint_amount" id="society_maint_amount" class="form-control"
                            placeholder="$100" required>
                        <span class="text-danger" id="society_maint_amount_error"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Due Date</label>
                        <input type="date" name="society_maint_dueDate" id="society_maint_dueDate" class="form-control"
                            required>
                        <span class="text-danger" id="society_maint_dueDate_error"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Payment Date</label>
                        <input type="date" name="society_maint_paymentDate" id="society_maint_paymentDate"
                            class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        <span class="text-danger" id="society_maint_paymentDate_error"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Remarks/Comments</label>
                        <input type="text" name="society_maint_comments" id="society_maint_comments"
                            placeholder="Monthly charge" class="form-control">
                        <span class="text-danger" id="society_maint_comments_error"></span>
                    </div>

                    <!-- Button -->
                    <div class="col-md-12">
                        <button class="btn btn-primary" id="submit_btn" type="submit"
                            name="societyMaintenance_submit">Add Now</button>
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