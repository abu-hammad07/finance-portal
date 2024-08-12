<?php
session_start();
include_once ("includes/config.php");
include "includes/function2.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
addMaintenance();
?>


<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Add Maintenance</h4>
    <!-- End:Title -->

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_message_house'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_message_house'] . '
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

    <form action="" method="post" id="add_houses_form" target="_blank">
        <div class="card h-auto">
            <div class="card-body">
                <h3 class="card-header">Information</h3>
                <hr class="my-4">
                <div class="row g-3">
                    <div class="col-md-6" style="display:none">
                        <label class="form-label">House or Shop</label>
                        <select name="house_or_shop" id="house_or_shop" class="form-select form-control house-id">
                            <option value="">--- Select House/Shop ---</option>
                            <option value="house">House</option>
                            <option value="shop">Shop</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">House Number / Shop Number</label>
                        <select name="house_shop_id" id="house_shop_id" class="form-select form-control house-id">
                            <option value="">--- Select House/Shop No ---</option>
                            <!-- Options will be loaded here via AJAX -->
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Maintenance Month</label>
                        <select class="form-select" id="monthData" required name="maintenace_month">
                            <option value="">Select Month</option>
                            <!-- Options will be loaded here via AJAX -->
                        </select>
                        <span class="text-danger" id="Penal-Cnic_error"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner Name</label>
                        <select class="form-control" id="owner_name" required name="owner_name">
                            <!-- <option value="">Select Month</option> -->
                            <!-- Options will be loaded here via AJAX -->
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner Contact</label>
                        <select class="form-control" id="owner_contact" required name="owner_contact">
                            <!-- <option value="">Select Month</option> -->
                            <!-- Options will be loaded here via AJAX -->
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner CNIC</label>
                        <select class="form-control" id="owner_cnic" required name="owner_cnic">
                            <!-- <option value="">Select Month</option> -->
                            <!-- Options will be loaded here via AJAX -->
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Total Maintenance</label>
                        <select class="form-control" id="totalMaintenace" required name="totalMaintenace">
                            <!-- <option value="">Select Month</option> -->
                            <!-- Options will be loaded here via AJAX -->
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Maintenance Charges</label>
                        <input type="text" name="maintenace_charges" class="form-control" placeholder="Penalty Charges"
                            required>
                        <span class="text-danger" id="Penal-charges_error"></span>
                    </div>
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
<?php include_once ('includes/footer.php'); ?>
<!-- End: Footer -->

<script>
    $(document).ready(function () {
        $("#house_shop_id").select2();
    });
</script>

<script>
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
                    if (type === "eGate_id_Data1") {
                        $('#house_shop_id').html(data);
                    } else if (type === "month_data") {
                        $('#monthData').html(data);
                    } else if (type === "owner_name") {
                        $('#owner_name').html(data);
                    } else if (type === "owner_contact") {
                        $('#owner_contact').html(data);
                    } else if (type === "owner_cnic") {
                        $('#owner_cnic').html(data);
                    } else if (type === "totalMaintenace") {
                        $('#totalMaintenace').html(data);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }

        loadData("eGate_id_Data1");

        $('#house_shop_id').change(function () {
            var houseShopId = $(this).val();
            loadData("month_data", houseShopId);
        });

        $('#house_shop_id').change(function () {
            var monthData = $(this).val();
            loadData("owner_name", monthData);
        });
        $('#house_shop_id').change(function () {
            var monthData = $(this).val();
            loadData("owner_contact", monthData);
        });
        $('#house_shop_id').change(function () {
            var monthData = $(this).val();
            loadData("owner_cnic", monthData);
        });
        $('#house_shop_id').change(function () {
            var monthData = $(this).val();
            loadData("totalMaintenace", monthData);
        });

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