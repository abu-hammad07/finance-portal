<?php
session_start();
include_once ("includes/config.php");
include "includes/function2.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
updateMaintenance();
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

    <form action="" method="post" id="add_houses_form">
        <div class="card h-auto">
            <div class="card-body">
                <h3 class="card-header">Information</h3>
                <hr class="my-4">
                <?php
                if (isset($_GET['maintenance_add_id'])) {
                    $mantiances_add_id = mysqli_real_escape_string($conn, $_GET['maintenance_add_id']);
                    $edit_query = "SELECT *  FROM maintenance_payments WHERE maintenance_id = '$mantiances_add_id'";
                    $edit_result = mysqli_query($conn, $edit_query);

                    if (mysqli_num_rows($edit_result) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($edit_result)) {
                            ?>
                            <div class="row g-3">
                                <input type="text" hidden name="maintenace_edit_id" value="<?= $row['maintenance_id'] ?>"
                                    class="form-control" placeholder="Penalty Charges" required>

                                <div class="col-md-6">
                                    <label class="form-label">House or Shop</label>
                                    <select name="house_or_shop" id="house_or_shop" class="form-select form-control house-id">
                                        <option value="<?= $row['house_or_shop'] ?>"><?= $row['house_or_shop'] ?></option>
                                        <option value="house">House</option>
                                        <option value="shop">Shop</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">House Number / Shop Number</label>
                                    <select name="house_shop_id" id="house_shop_id" class="form-select form-control house-id">
                                        <?php
                                        if ($row['house_or_shop'] == 'house') {
                                            echo '<option value="' . $row['house_id'] . '">' . $row['house_number'] . '</option>';
                                        } elseif ($row['house_or_shop'] == 'shop') {
                                            echo '<option value="' . $row['shop_id'] . '">' . $row['shop_number'] . '</option>';
                                        }
                                        ?> <!-- Options will be loaded here via AJAX -->
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Maintenance Month</label>
                                    <select class="form-select" id="monthData" required name="maintenace_month">
                                        <option value="<?= $row['maintenance_month'] ?>"><?= $row['maintenance_month'] ?></option>
                                        <!-- Options will be loaded here via AJAX -->
                                    </select>
                                    <span class="text-danger" id="Penal-Cnic_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Maintenance Charges</label>
                                    <input type="text" name="maintenace_charges" class="form-control"
                                        value="<?= $row['maintenance_peyment'] ?>" placeholder="Penalty Charges" required>
                                    <span class="text-danger" id="Penal-charges_error"></span>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-primary" id="submit_btn" type="submit" name="submit">Update Now</button>
                                </div>
                            </div>
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
        </div>
    </form>
</div>
<!-- End:Main Body -->
</div>

<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
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
            var selectedOption = $(this).find('option:selected').parent().attr('label');
            if (selectedOption === 'House Number') {
                $('#house_or_shop').val('house');
            } else if (selectedOption === 'Shop Number') {
                $('#house_or_shop').val('shop');
            }
        });
    });
</script>
