<?php
session_start();
include_once("includes/config.php");
include_once("includes/function.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

servantSubmit();
?>


<!-- Main sidebar -->
<?php
include("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">
    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Add Servant</h4>
    <!-- End:Title -->

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_message_servant'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_message_servant'] . '<a href="servants" class="btn btn-success" style="float: right; margin-top: -8px;">View Details</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_message_servant']);
    }
    if (isset($_SESSION['error_message_servant'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_message_servant'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_message_servant']);
    }
    ?>
    <!-- / Alert -->


    <form action="" method="post" id="add_servant_form" enctype="multipart/form-data">
        <div class="card h-auto">
            <div class="card-body">
                <h3 class="card-header">Information</h3>
                <hr class="my-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">House/Unit Number</label>
                        <select name="house_id" id="house_id" class="form-select form-control " required>
                            <option value="">--- Select House No ---</option>
                        </select>

                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner's Name</label>
                        <select id="owner_name" class="form-select form-control">
                            <!-- <option value="">--- Select House No ---</option> -->
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner's Contact</label>
                        <select id="owner_contact" class="form-select form-control">
                            <!-- <option value="">--- Select House No ---</option> -->
                        </select>
                    </div>
                    <div class="col-md-6 ">
                        <label class="form-label">Designation</label>
                        <input type="text" id="designation" name="designation" class="form-control"
                            placeholder="Enter Designation" required>
                        <span class="text-danger" id="designation_error"></span>
                    </div>
                    <div class="col-md-6 ">
                        <label class="form-label">Masi Name</label>
                        <input type="text" name="masi_name" class="form-control"
                            placeholder="Enter masi name" required>
                    </div>
                    <div class="col-md-6 ">
                        <label class="form-label">Masi Contact</label>
                        <input type="text" name="masi_contact" class="form-control"
                            placeholder="Enter masi contact" required>
                    </div>
                    <div class="col-md-6 ">
                        <label class="form-label">Masi CNIC</label>
                        <input type="text" name="masi_cnic" class="form-control"
                            placeholder="Enter masi CNIC" required>
                    </div>
                    <div class="col-md-6 ">
                        <label class="form-label">Masi Picture</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                    <div class="col-md-6 ">
                        <label for="servantFees" class="form-label">Fees</label>
                        <input type="text" id="servantFees" name="servant_fees" class="form-control"
                            placeholder="999" required>
                        <span class="text-danger" id="servant_fees_error"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Payment Type</label>
                        <select class="form-select form-control" id="pymentType" required name="pymentType">
                            <option value="">Select Payment Type</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank">Bank</option>
                        </select>
                    </div>

                    <!-- Button -->
                    <div class="col-md-12">
                        <button class="btn btn-primary" id="servant_btn" type="submit" name="submit">Add Now</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <!-- End:submit btn -->
</div>
<!-- End:Main Body -->
</div>

<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->

<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<!-- <script>
    $(document).ready(function () {
        $("#house_id").select2();
    });
</script> -->
<script>
    $(document).ready(function() {
        function loadData(type, id) {
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                data: {
                    type: type,
                    id: id
                },
                dataType: 'html',
                success: function(data) {
                    if (type === "house_id_Data") {
                        $('#house_id').append(data);
                    } else if (type === "owner_name_Data") {
                        $('#owner_name').html(data);
                    } else if (type === "owner_contact_Data") {
                        $('#owner_contact').html(data);
                    }
                }
            });
        }

        loadData("house_id_Data");

        $("#house_id").on("change", function() {
            var customer = $("#house_id").val();
            if (customer != "") {
                loadData("owner_name_Data", customer);
            } else {
                $('#owner_name').html("");
            }
        });
        $("#house_id").on("change", function() {
            var customer = $("#house_id").val();
            if (customer != "") {
                loadData("owner_contact_Data", customer);
            } else {
                $('#owner_contact').html("");
            }
        });
    });
</script>

<script>
    var servantFees = document.getElementById('servantFees');
    servantFees.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>