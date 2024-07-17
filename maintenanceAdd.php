<?php
session_start();
include_once("includes/config.php");
include "includes/function2.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
updateMaintenance();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Add House</title>
    <meta name="og:description" content="FinDeshY is a free financial Bootstrap dashboard template to manage your financial data easily. This free financial dashboard uses Bootstrap to provide a responsive and user-friendly interface. Whether you're a small business owner seeking insights into your company's financial health or an individual looking to simplify your personal finances, this free Bootstrap dashboard template has you covered.">
    <meta name="robots" content="index, follow">
    <meta name="og:title" property="og:title" content="FinDeshY - Free Financial Bootstrap Dashboard Template">
    <meta property="og:image" content="https://www.designtocodes.com/wp-content/uploads/2023/10/FinDeshY-Professional-Financial-Bootstrap-Dashboard-Template.jpg">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="lib/bootstrap_5/bootstrap.min.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="lib/fontawesome/css/all.min.css">
    <!-- main css -->
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- responsive css -->
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>

<body class="d2c_theme_light">
    <!-- Preloader Start -->
    <div class="preloader">
        <!-- <img src="assets/images/logo/logo.png" alt="DesignToCodes"> -->
    </div>
    <!-- Preloader End -->

    <div class="d2c_wrapper">

        <!-- Main sidebar -->
        <?php
        include("includes/sidebar.php");
        ?>
        <!-- End:Sidebar -->

        <!-- Main Body-->
        <div class="d2c_main p-4 ps-lg-3">

            <!-- Title -->
            <h4 class="mb-4 text-capitalize">Add Maintenance</h4>
            <!-- End:Title -->

            <!-- Alert -->
            <?php
            if (isset($_SESSION['success_updated_Maintenance'])) {
                echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_updated_Maintenance'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['success_updated_Maintenance']);
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
                                        <input type="text" hidden name="maintenace_edit_id" value="<?= $row['maintenance_id'] ?>" class="form-control" placeholder="Penalty Charges" required>

                                        <div class="col-md-6">
                                            <label class="form-label">House or Shop</label>
                                            <select name="house_or_shop" id="house_or_shop" class="form-select form-control house-id">
                                                <option value="<?= $row['house_or_shop'] ?>"><?= $row['house_or_shop'] ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">House Number / Shop Number</label>
                                            <select name="house_shop_id" class="form-select form-control house-id">
                                                <?php
                                                // Assuming $house_shop_id is an array
                                                $house_shop_ids = explode(',', $row['house_shop_id']); // Convert the string of IDs to an array

                                                if ($row['house_or_shop'] == "house") {
                                                    foreach ($house_shop_ids as $house_shop_id_main) {
                                                        $house_shop_id_main = intval($house_shop_id_main); // Ensure it's an integer to prevent SQL injection
                                                        $select = "SELECT * FROM houses WHERE house_id = $house_shop_id_main";
                                                        $result = mysqli_query($conn, $select);

                                                        if ($result && mysqli_num_rows($result) > 0) {
                                                            $house_row = mysqli_fetch_assoc($result);
                                                ?>
                                                            <option class="form-control" value="<?= $house_row['house_id'] ?>"><?= $house_row['house_number'] ?></option>
                                                        <?php
                                                        }
                                                    }
                                                } elseif ($row['house_or_shop'] == "shop") {
                                                    foreach ($house_shop_ids as $shop_id_main) {
                                                        $shop_id_main = intval($shop_id_main); // Ensure it's an integer to prevent SQL injection
                                                        $select = "SELECT * FROM shops WHERE shop_id = $shop_id_main";
                                                        $result = mysqli_query($conn, $select);

                                                        if ($result && mysqli_num_rows($result) > 0) {
                                                            $shop_row = mysqli_fetch_assoc($result);
                                                        ?>
                                                            <option class="form-control" value="<?= $shop_row['shop_id'] ?>"><?= $shop_row['shop_number'] ?></option>

                                                <?php }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">House Owner name / Owner name </label>
                                            <select class="form-select form-control house-id">
                                                <?php
                                                // Assuming $house_shop_id is an array
                                                $house_shop_ids = explode(',', $row['house_shop_id']); // Convert the string of IDs to an array

                                                if ($row['house_or_shop'] == "house") {
                                                    foreach ($house_shop_ids as $house_shop_id_main) {
                                                        $house_shop_id_main = intval($house_shop_id_main); // Ensure it's an integer to prevent SQL injection
                                                        $select = "SELECT * FROM houses WHERE house_id = $house_shop_id_main";
                                                        $result = mysqli_query($conn, $select);

                                                        if ($result && mysqli_num_rows($result) > 0) {
                                                            $house_row = mysqli_fetch_assoc($result);
                                                ?>
                                                            <option class="form-control" value="<?= $house_row['owner_name'] ?>"><?= $house_row['owner_name'] ?></option>
                                                        <?php
                                                        }
                                                    }
                                                } elseif ($row['house_or_shop'] == "shop") {
                                                    foreach ($house_shop_ids as $shop_id_main) {
                                                        $shop_id_main = intval($shop_id_main); // Ensure it's an integer to prevent SQL injection
                                                        $select = "SELECT * FROM shops WHERE shop_id = $shop_id_main";
                                                        $result = mysqli_query($conn, $select);

                                                        if ($result && mysqli_num_rows($result) > 0) {
                                                            $shop_row = mysqli_fetch_assoc($result);
                                                        ?>
                                                            <option class="form-control" value="<?= $shop_row['owner_name'] ?>"><?= $shop_row['owner_name'] ?></option>

                                                <?php }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">House Owner CNIC / Owner CNIC </label>
                                            <select class="form-select form-control house-id">
                                                <?php
                                                // Assuming $house_shop_id is an array
                                                $house_shop_ids = explode(',', $row['house_shop_id']); // Convert the string of IDs to an array

                                                if ($row['house_or_shop'] == "house") {
                                                    foreach ($house_shop_ids as $house_shop_id_main) {
                                                        $house_shop_id_main = intval($house_shop_id_main); // Ensure it's an integer to prevent SQL injection
                                                        $select = "SELECT * FROM houses WHERE house_id = $house_shop_id_main";
                                                        $result = mysqli_query($conn, $select);

                                                        if ($result && mysqli_num_rows($result) > 0) {
                                                            $house_row = mysqli_fetch_assoc($result);
                                                ?>
                                                            <option class="form-control" value="<?= $house_row['owner_cnic'] ?>"><?= $house_row['owner_cnic'] ?></option>
                                                        <?php
                                                        }
                                                    }
                                                } elseif ($row['house_or_shop'] == "shop") {
                                                    foreach ($house_shop_ids as $shop_id_main) {
                                                        $shop_id_main = intval($shop_id_main); // Ensure it's an integer to prevent SQL injection
                                                        $select = "SELECT * FROM shops WHERE shop_id = $shop_id_main";
                                                        $result = mysqli_query($conn, $select);

                                                        if ($result && mysqli_num_rows($result) > 0) {
                                                            $shop_row = mysqli_fetch_assoc($result);
                                                        ?>
                                                            <option class="form-control" value="<?= $shop_row['owner_cnic'] ?>"><?= $shop_row['owner_cnic'] ?></option>
                                                <?php }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Maintenance Month</label>
                                            <select class="form-select" id="monthData" required name="maintenace_month">
                                                <option value="<?= $row['maintenance_month'] ?>"><?= $row['maintenance_month'] ?></option>
                                            </select>
                                            <span class="text-danger" id="Penal-Cnic_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Maintenance Charges</label>
                                            <select class="form-select" id="pymentType" required name="pymentType">
                                                <option value=""> Select Payment Type</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Bank">Bank</option>
                                            </select>
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Maintenance Charges</label>
                                            <input type="text" name="maintenace_charges" readonly class="form-control" value="<?= $row['maintenance_peyment'] ?>" placeholder="Penalty Charges" required>
                                            <span class="text-danger" id="Penal-charges_error"></span>
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" id="submit_btn" type="submit" name="submit">Submit</button>
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

    <!-- Offcanvas Toggler -->
    <button class="d2c_offcanvas_toggle position-fixed top-50 start-0 translate-middle-y d-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#d2c_sidebar">
        <i class="far fa-hand-point-right"></i>
    </button>
    <!-- End:Offcanvas Toggler -->
    <!-- Initial  Javascript -->
    <script src="lib/jQuery/jquery-3.5.1.min.js"></script>
    <script src="lib/bootstrap_5/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#house_shop_id").select2();
        });
    </script>
    <!-- custom js -->
    <script src="assets/js/main.js"></script>
    <script>
        $(document).ready(function() {
            function loadData(type, id = null) {
                $.ajax({
                    url: 'ajax.php',
                    type: 'POST',
                    data: {
                        type: type,
                        id: id
                    },
                    dataType: 'html',
                    success: function(data) {
                        if (type === "eGate_id_Data1") {
                            $('#house_shop_id').html(data);
                        } else if (type === "month_data") {
                            $('#monthData').html(data);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            }

            loadData("eGate_id_Data1");

            $('#house_shop_id').change(function() {
                var houseShopId = $(this).val();
                loadData("month_data", houseShopId);
            });

            $('#house_shop_id').change(function() {
                var selectedOption = $(this).find('option:selected').parent().attr('label');
                if (selectedOption === 'House Number') {
                    $('#house_or_shop').val('house');
                } else if (selectedOption === 'Shop Number') {
                    $('#house_or_shop').val('shop');
                }
            });
        });
    </script>

</body>

</html>