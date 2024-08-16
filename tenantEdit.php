<?php
session_start();
include_once("includes/config.php");
include "includes/function.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
updateTenants();
?>

<!-- Main sidebar -->
<?php
include("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Edit Tenant</h4>
    <!-- End:Title -->

    <?php
    if (isset($_GET['tenant_edit_id'])) {
        $edit_id = mysqli_real_escape_string($conn, $_GET['tenant_edit_id']);
        $edit_query = "SELECT tenants.*, houses.house_id, houses.house_number, houses.owner_name, houses.owner_contact
                From tenants
                INNER JOIN houses ON tenants.house_id = houses.house_id
                WHERE tenants.tenant_id = '$edit_id'";
        $edit_result = mysqli_query($conn, $edit_query);

        if (mysqli_num_rows($edit_result) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_assoc($edit_result)) {
    ?>

                <form action="" method="post" id="add_houses_form" enctype="multipart/form-data">
                    <div class="card h-auto">
                        <div class="card-body">
                            <h3 class="card-header">Information</h3>
                            <hr class="my-4">
                            <div class="row g-3">
                                <input type="text" hidden name="tenant_id" class="form-control" value="<?= $row['tenant_id'] ?>">

                                <div class="col-md-6 ">
                                    <label for="propertytype" class="form-label">Type of Property</label>
                                    <select id="propertytype"   name="house_or_shop" class="form-select form-control">
                                        <option  value="<?= $row['house_or_shop'] ?>"><?= $row['house_or_shop'] ?></option>
                                    </select>
                                    <span class="text-danger"></span>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">House/Shop Number</label>
                                    <select name="house_id"  id="house_shop_id" class="form-select form-control house-id" required>
                                        <option value="<?= $row['house_id'] ?>"><?= $row['house_number'] ?></option>
                                    </select>
                                    <!-- <span class="text-danger" id="house_id_error"></span> -->
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
                                    <label class="form-label">Tenant's Name</label>
                                    <input type="text"  id="tenant-name" name="tenant_name" class="form-control"
                                        placeholder="Enter Tenant's Name" value="<?= $row['tenant_name'] ?>" required>
                                    <!-- <span class="text-danger" id="tenants-name_error"></span> -->
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Tenant's Contact Number</label>
                                    <input type="text" id="tenant-contact" name="tenant_contact" class="form-control"
                                        placeholder="03XXXXXXXXX" value="<?= $row['tenant_contact_no'] ?>" required>
                                    <!-- <span class="text-danger" id="tenant-contact_error"></span> -->
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Tenant's CNIC</label>
                                    <input type="text" id="tenant-contact" name="tenant_cnic" class="form-control"
                                        placeholder="XXXXX-XXXXXXX-X" value="<?= $row['tenant_cnic'] ?>" required>
                                    <!-- <span class="text-danger" id="tenant-cnic_error"></span> -->
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Tenant's Image</label>
                                    <input type="file" id="tenant-contact" name="tenant_image" class="form-control">
                                    <!-- <span class="text-danger" id="tenant-image_error"></span> -->
                                </div>

                                <!-- Button -->
                                <div class="col-md-12">
                                    <button class="btn btn-primary" id="submit_btn" type="submit" name="update">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
    <?php
            }
        } else {
            echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    No House Found.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    }
    ?>
</div>
<!-- End:Main Body -->
</div>

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
</script> -->