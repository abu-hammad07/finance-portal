<?php
session_start();
include_once("includes/config.php");
include "includes/function.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
addTenants();
?>

</style>
<!-- Main sidebar -->
<?php
include("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Add Tenant</h4>
    <!-- End:Title -->

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_message_Tenant'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_message_Tenant'] . '<a href="tenants" class="btn btn-success" style="float: right; margin-top: -8px;">View Details</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_message_Tenant']);
    }
    if (isset($_SESSION['error_message_Tenant'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_message_Tenant'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_message_Tenant']);
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
                        <label for="propertytype" class="form-label">Please Select type</label>
                        <select id="propertytype" name="house_or_shop" required class="form-select form-control">
                            <option value="">-----</option>
                        </select>
                        <span class="text-danger" ></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">House/Shop Number</label>
                        <select name="house_shop_id" id="house_shop_id" class="form-select form-control house-id"
                            required>
                            <option value="">--- Select House/Shop No ---</option>
                            <!-- Add your house/shop options here -->
                        </select>
                    </div>
                
                    <div class="col-md-6 ">
                        <label class="form-label">Tenant's Name</label>
                        <input type="text" id="tenant-name" name="tenant_name" class="form-control"
                            placeholder="Enter Tenant's Name" required>
                        <!-- <span class="text-danger" id="tenants-name_error"></span> -->
                    </div>
                    <div class="col-md-6 ">
                        <label class="form-label">Tenant's Contact Number</label>
                        <input type="text" id="TenantContact" name="tenant_contact" class="form-control"
                            placeholder="03XXXXXXXXX">
                        <!-- <span class="text-danger" id="tenant-contact_error"></span> -->
                    </div>
                    <div class="col-md-6 ">
                        <label class="form-label">Tenant's CNIC</label>
                        <input type="text" id="TenantCnic" name="tenant_cnic" class="form-control"
                            placeholder="XXXXX-XXXXXXX-X" required>
                        <!-- <span class="text-danger" id="tenant-cnic_error"></span> -->
                    </div>
                    <div class="col-md-6 ">
                        <label class="form-label">Tenant's Image</label>
                        <input type="file" id="TenantImage" name="tenant_image" class="form-control">
                        <!-- <span class="text-danger" id="tenant-image_error"></span> -->
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

<?php include_once('includes/footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- jQuery version 3.6.0 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

        loadData("propertytype");

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


<!-- Start: Footer -->
<script>
    var TenantContact = document.getElementById('TenantContact');
    var TenantCnic = document.getElementById('TenantCnic');
    TenantContact.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

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






