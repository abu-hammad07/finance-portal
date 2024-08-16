<?php
session_start();
include_once ("includes/config.php");
include "includes/function2.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
addPenalty();
?>


<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Add Penalty</h4>
    <!-- End:Title -->

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_message_house'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_message_house'] . '<a href="penalty" class="btn btn-success" style="float: right; margin-top: -8px;">View Details</a>
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
                        <label class="form-label">Penalty Type</label>
                        <input type="text" required name="penalty_type" class="form-control"
                            placeholder="Enter Penalty Type" required>
                        <span class="text-danger" id="penalty-type_error"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="PenaltyCnic" class="form-label">Penalty CINC</label>
                        <input type="text" required name="penalty_cnic" id="PenaltyCnic" class="form-control"
                            placeholder="Penalty CINC" required>
                        <span class="text-danger" id="Penal-Cnic_error"></span>
                    </div>

                    <div class="col-md-6">
                        <label for="PenaltyCharge" class="form-label">Penalty Charges</label>
                        <input type="text" required name="penalty_charges" id="PenaltyCharge" class="form-control"
                            placeholder="Penalty Charges" required>
                        <span class="text-danger" id="Penal-charges_error"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Payment Type</label>
                        <select class="form-select form-control" id="pymentType" required name="paymentType">
                            <option value=""> Select Payment Type</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank">Bank</option>
                        </select>
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
<script>
    var PenaltyCharge = document.getElementById('PenaltyCharge');
    PenaltyCharge.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    var PenaltyCnic = document.getElementById('PenaltyCnic');

    PenaltyCnic.addEventListener('input', function() {
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
