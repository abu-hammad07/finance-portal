<?php
session_start();
include_once ("includes/config.php");
include_once ("includes/function.php");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
insertUtilityCharges();
?>

<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Add Utility Charges</h4>
    <!-- End:Title -->

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_message_Utility'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_message_Utility'] . '<a href="utilityCharges" class="btn btn-success" style="float: right; margin-top: -8px;">View Details</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_message_Utility']);
    }
    if (isset($_SESSION['error_message_Utility'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_message_Utility'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_message_Utility']);
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
                        <label class="form-label">Utility Type</label>
                        <input type="text" name="utility_type" id="utility_type" class="form-control"
                            placeholder="Electricity" required>
                        <span class="text-danger" id="utility_type_error"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="Amount" class="form-label">Amount</label>
                        <input type="text" name="utility_amount" id="Amount" class="form-control"
                            placeholder="100" required>
                        <span class="text-danger" id="utility_amount_error"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Billing Month</label>
                        <input type="month" name="utility_billing_month" id="utility_billing_month" class="form-control"
                            required value="<?php echo date('Y-m'); ?>">
                        <span class="text-danger" id="utility_billing_month_error"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Location</label>
                        <select name="utility_location" id="utility_location" class="form-select form-control" required>
                            <option value="">Select Location</option>
                            <option value="Office">Office</option>
                            <option value="Sports Area">Sports Area</option>
                            <option value="Shadi Hall">Shadi Hall</option>
                            <option value="Other">Other</option>
                        </select>
                        <span class="text-danger" id="utility_location_error"></span>
                    </div>

                    <!-- Button -->
                    <div class="col-md-12">
                        <button class="btn btn-primary" id="submit_btn" type="submit" name="utility_submit">Add
                            Now</button>
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

<script>
    var Amount = document.getElementById('Amount');
    Amount.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
  
</script>