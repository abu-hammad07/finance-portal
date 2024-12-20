<?php
session_start();
include_once("includes/config.php");
include_once("includes/function.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

// insert Function
eGateUpdate();
?>



<!-- Main sidebar -->
<?php
include("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">
    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Edit e-Gate</h4>
    <!-- End:Title -->


    <form action="" method="post" id="add_houses_form" enctype="multipart/form-data">

        <?php
        if (isset($_GET['eGate_edit_id'])) {

            $eGate_edit_id = mysqli_real_escape_string($conn, $_GET['eGate_edit_id']);

            $query = "SELECT egate.*, houses.house_number, shops.shop_number 
                        FROM egate
                        LEFT JOIN houses ON egate.house_id = houses.house_id
                        LEFT JOIN shops ON egate.shop_id = shops.shop_id
                        WHERE egate.eGate_id = '$eGate_edit_id'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
        ?>

                    <div class="card h-auto">
                        <div class="card-body">
                            <h3 class="card-header">Information</h3>
                            <hr class="my-4">
                            <div class="row g-3">
                                <input type="text" hidden name="eGate_id" class="form-control" value="<?= $row['eGate_id'] ?>">

                                <div class="col-md-6 ">
                                    <label for="propertytype" class="form-label">Please Select Type</label>
                                    <select id="propertytype" name="house_or_shop" required class="form-select form-control">
                                        <option <?php echo ($row['house_or_shop'] == "shop") ? 'selected' : ''; ?> value="Shop">Shop</option>
                                        <option <?php echo ($row['house_or_shop'] == "house") ? 'selected' : ''; ?> value="House">House</option>

                                    </select>
                                    <span class="text-danger"></span>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">House Number / Shop Number</label>
                                    <select name="house_id" id="house_shop_id" class="form-select form-control house-id" required>
                                        <!-- <option value="">--- Select House/Shop No ---</option> -->
                                        <?php

                                        echo '<option value="' . $row['house_id'] . '">' . $row['house_number'] . '</option>';

                                        ?>
                                    </select>
                                    <!-- <span class="text-danger" id="house_id_error"></span> -->
                                </div>
                               
                                <div class="col-md-6 ">
                                    <label class="form-label">Vehicle Name</label>
                                    <input type="text" id="vehicle_name" name="vehicle_name" class="form-control"
                                        placeholder="Honda City" value="<?= $row['vehicle_name'] ?>" required>
                                    <!-- <span class="text-danger" id="vehicle_name_error"></span> -->
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Vehicle Number</label>
                                    <input type="text" id="vehicle_number" name="vehicle_number" class="form-control"
                                        placeholder="ABC-12345" value="<?= $row['vehicle_number'] ?>" required>
                                    <!-- <span class="text-danger" id="vehicle_number_error"></span> -->
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Vehicle Color</label>
                                    <input type="text" id="vehicle_color" name="vehicle_color" class="form-control"
                                        placeholder="Black" value="<?= $row['vehicle_color'] ?>" required>
                                    <!-- <span class="text-danger" id="vehicle_color_error"></span> -->
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Person Name</label>
                                    <input type="test" id="person_name" name="person_name" class="form-control"
                                        placeholder="John Doe" value="<?= $row['eGateperson_name'] ?>">
                                    <!-- <span class="text-danger" id="person_name_error"></span> -->
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">CNIC Number</label>
                                    <input type="text" id="cnic_number" name="cnic_number" class="form-control"
                                        placeholder="XXXXX-XXXXXXX-X" value="<?= $row['eGate_cnic'] ?>">
                                    <!-- <span class="text-danger" id="cnic_number_error"></span> -->
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Charges Type</label>
                                    <select name="charges_type" id="charges_type" class="form-select form-control house-id"
                                        required>
                                        <option value="">--- Select Charges Type ---</option>
                                        <option value="New Card" <?php if ($row['eGate_charges_type'] == 'New Card')
                                                                        echo 'selected'; ?>>New Card</option>
                                        <option value="Renew" <?php if ($row['eGate_charges_type'] == 'Renew')
                                                                    echo 'selected'; ?>>Renew</option>
                                    </select>
                                    <!-- <span class="text-danger" id="charges_type_error"></span> -->
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Charges</label>
                                    <input type="text" id="charges" name="charges" class="form-control" placeholder="2000"
                                        value="<?= $row['eGate_charges'] ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Payment Type</label>
                                    <select class="form-select form-control" id="pymentType" required name="pymentType">
                                        <option value=""> Select Payment Type</option>
                                        <option value="Cash" <?php if ($row['payment_type'] == 'Cash')
                                                                    echo 'selected'; ?>>Cash
                                        </option>
                                        <option value="Bank" <?php if ($row['payment_type'] == 'Bank')
                                                                    echo 'selected'; ?>>Bank
                                        </option>
                                    </select>
                                </div>

                                <!-- Button -->
                                <div class="col-md-12">
                                    <button class="btn btn-primary" id="submit_btn" type="submit" name="submit">Update</button>
                                    <a href="eGate" class="btn btn-outline-danger">Back</a>
                                </div>
                            </div>
                        </div>
            <?php
                }
            } else {
                echo '<div class="alert alert-warning text-center" role="alert">There are no data Found!</div>';
            }
        } else {
            echo '<div class="alert alert-warning text-center" role="alert">There are no ID Found!</div>';
        }
            ?>

                    </div>
    </form>



    <!-- End:submit btn -->
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