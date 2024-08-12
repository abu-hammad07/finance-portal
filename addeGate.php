<?php
session_start();
include_once ("includes/config.php");
include_once ("includes/function.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

// insert Function
eGateInsert();
?>

<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
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
                    ' . $_SESSION['error_insert_egate'] . '
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
                    <div class="col-md-6">
                        <label class="form-label">House Number / Shop Number</label>
                        <select name="house_shop_id" id="house_shop_id" class="form-select form-control house-id"
                            required>
                            <option value="">--- Select House/Shop No ---</option>
                            <!-- Add your house/shop options here -->
                        </select>
                    </div>
                    <div class="col-md-6" style="display:none">
                        <label class="form-label">House or Shop</label>
                        <select name="house_or_shop" id="house_or_shop" class="form-select form-control house-id"
                            required>
                            <option value="">--- Select House/Shop ---</option>
                            <option value="house">House</option>
                            <option value="shop">Shop</option>
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
                        <input type="text" id="cnic_number" name="cnic_number" class="form-control"
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

<!-- Start: Footer -->
<?php include_once ('includes/footer.php'); ?>
<!-- End: Footer -->

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $("#house_shop_id").select2();
    });
</script>

<script>
    // $(document).ready(function() {
    //     function loadData(type, id = null) {
    //         $.ajax({
    //             url: 'ajax.php',
    //             type: 'POST',
    //             data: {
    //                 type: type,
    //                 id: id
    //             },
    //             dataType: 'html',
    //             success: function(data) {
    //                 if (type === "eGate_id_Data") {
    //                     // Clear the existing options except the placeholders
    //                     $('#house_id optgroup[label="House Number"]').empty().append('<option value="">--- Select House No ---</option>');
    //                     $('#house_id optgroup[label="Shop Number"]').empty().append('<option value="">--- Select Shop No ---</option>');

    //                     // Append the new data to the select element
    //                     $('#house_id').append(data);
    //                 }
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error('AJAX Error:', status, error);
    //             }
    //         });
    //     }

    //     loadData("eGate_id_Data");
    // });


    $(document).ready(function () {
        function loadData(type, id = null) {
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                data: {
                    type: type,
                    id: id
                },
                dataType: 'html',
                success: function (data) {
                    if (type === "eGate_id_Data") {
                        $('#house_shop_id').html(data);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }

        loadData("eGate_id_Data");

        $('#house_shop_id').change(function () {
            var selectedOption = $(this).find('option:selected').parent().attr('label');
            if (selectedOption === 'House Number') {
                $('#house_or_shop').val('house');
            } else if (selectedOption === 'Shop Number') {
                $('#house_or_shop').val('shop');
            }
        });
    });
</script>