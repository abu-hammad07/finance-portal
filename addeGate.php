<?php
session_start();
include_once("includes/config.php");
include_once("includes/function.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

// insert Function
eGateInsert();
?>

<!-- Main sidebar -->
<?php
include("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">
    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Add e-Gate</h4>
    <!-- End:Title -->


    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_insert_egate'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_insert_egate'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_insert_egate']);
    }
    if (isset($_SESSION['error_insert_egate'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_insert_egate'] . '<a href="eGate" class="btn btn-success" style="float: right; margin-top: -8px;">View Details</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_insert_egate']);
    }
    ?>
    <!-- / Alert -->


    <form action="" method="post" id="add_houses_form" enctype="multipart/form-data">
        <div class="card h-auto">
            <div class="card-body">
                <h3 class="card-header">Information</h3>
                <hr class="my-4">
                <div class="row g-3">
                    <div class="col-md-6 ">
                        <label for="propertytype" class="form-label">Please Select Type</label>
                        <select id="propertytype" name="house_or_shop" required class="form-select form-control">
                            <option value="">-----</option>
                            <option value="Shop">Shop</option>
                            <option value="House">House</option>
                        </select>
                        <span class="text-danger"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">House Number / Shop Number</label>
                        <select name="house_shop_id" id="house_shop_id" class="form-select form-control house-id"
                            required>
                            <option value="">--- Select House/Shop No ---</option>
                            <!-- Add your house/shop options here -->
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Vehicle Name</label>
                        <input type="text" id="vehicle_name" name="vehicle_name" class="form-control"
                            placeholder="Honda City" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Vehicle Number</label>
                        <input type="text" id="vehicle_number" name="vehicle_number" class="form-control"
                            placeholder="ABC-12345" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Vehicle Color</label>
                        <input type="text" id="vehicle_color" name="vehicle_color" class="form-control"
                            placeholder="Black" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Person Name</label>
                        <input type="text" id="person_name" name="person_name" class="form-control"
                            placeholder="John Doe">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">CNIC Number</label>
                        <input type="text" id="TenantCnic" name="cnic_number" class="form-control"
                            placeholder="XXXXX-XXXXXXX-X">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Charges Type</label>
                        <select name="charges_type" id="charges_type" class="form-select form-control house-id"
                            required>
                            <option value="">--- Select Charges Type ---</option>
                            <option value="New Card">New Card</option>
                            <option value="Renew">Renew</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Charges</label>
                        <input type="text" id="charges" name="charges" class="form-control" placeholder="2000">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Payment Type</label>
                        <select class="form-select form-control" id="pymentType" required name="pymentType">
                            <option value=""> Select Payment Type</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank">Bank</option>
                        </select>
                    </div>

                    <!-- Button -->
                    <div class="col-md-12">
                        <button class="btn btn-primary" id="submit_btn" type="submit" name="submit">Add
                            Now</button>
                    </div>
                </div>
            </div>
        </div>
    </form>





    <!-- End:submit btn -->
</div>
<!-- End:Main Body -->
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $("#house_shop_id").select2();
    });
</script>
<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->



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
                    if (type === "propertytype") {
                        $('#propertytype').append(data);
                    } else if (type === "house_shop_id") {
                        $('#house_shop_id').html(data);
                    }
                }
            });
        }

        // loadData("propertytype");

        $("#propertytype").on("change", function() {
            var department = $("#propertytype").val();
            if (department != "") {
                loadData("house_shop_id", department);
            } else {
                $('#house_shop_id').html("");

            }
        });
    });
</script>

<script>
    // var TenantContact = document.getElementById('TenantContact');
    // TenantContact.addEventListener('input', function() {
    //     this.value = this.value.replace(/[^0-9]/g, '');
    // });
    var TenantCnic = document.getElementById('TenantCnic');

    TenantCnic.addEventListener('input', function() {
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