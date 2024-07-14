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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Edit e-Gate</title>
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
    <!-- Select2 -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->

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
                                        <div class="col-md-6">
                                            <label class="form-label">House Number / Shop Number</label>
                                            <select name="house_id" id="house_id" class="form-select form-control house-id" required>
                                                <!-- <option value="">--- Select House/Shop No ---</option> -->
                                                <?php
                                                if ($row['house_or_shop'] == 'house') {
                                                    echo '<option value="' . $row['house_id'] . '">' . $row['house_number'] . '</option>';
                                                } elseif ($row['house_or_shop'] == 'shop') {
                                                    echo '<option value="' . $row['shop_id'] . '">' . $row['shop_number'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <!-- <span class="text-danger" id="house_id_error"></span> -->
                                        </div>
                                        <div class="col-md-6" style="display:none">
                                            <label class="form-label">House or Shop</label>
                                            <select name="house_or_shop" id="house_or_shop" class="form-select form-control house-or-shop" required>
                                                <option value="<?= $row['house_or_shop'] ?>"><?= $row['house_or_shop'] ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 ">
                                            <label class="form-label">Vehicle Name</label>
                                            <input type="text" id="vehicle_name" name="vehicle_name" class="form-control" placeholder="Honda City" value="<?= $row['vehicle_name'] ?>" required>
                                            <!-- <span class="text-danger" id="vehicle_name_error"></span> -->
                                        </div>
                                        <div class="col-md-6 ">
                                            <label class="form-label">Vehicle Number</label>
                                            <input type="text" id="vehicle_number" name="vehicle_number" class="form-control" placeholder="ABC-12345" value="<?= $row['vehicle_number'] ?>" required>
                                            <!-- <span class="text-danger" id="vehicle_number_error"></span> -->
                                        </div>
                                        <div class="col-md-6 ">
                                            <label class="form-label">Vehicle Color</label>
                                            <input type="text" id="vehicle_color" name="vehicle_color" class="form-control" placeholder="Black" value="<?= $row['vehicle_color'] ?>" required>
                                            <!-- <span class="text-danger" id="vehicle_color_error"></span> -->
                                        </div>
                                        <div class="col-md-6 ">
                                            <label class="form-label">Person Name</label>
                                            <input type="test" id="person_name" name="person_name" class="form-control" placeholder="John Doe" value="<?= $row['eGateperson_name'] ?>">
                                            <!-- <span class="text-danger" id="person_name_error"></span> -->
                                        </div>
                                        <div class="col-md-6 ">
                                            <label class="form-label">CNIC Number</label>
                                            <input type="text" id="cnic_number" name="cnic_number" class="form-control" placeholder="XXXXX-XXXXXXX-X" value="<?= $row['eGate_cnic'] ?>">
                                            <!-- <span class="text-danger" id="cnic_number_error"></span> -->
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Charges Type</label>
                                            <select name="charges_type" id="charges_type" class="form-select form-control house-id" required>
                                                <option value="">--- Select Charges Type ---</option>
                                                <option value="New Card" <?php if ($row['eGate_charges_type'] == 'New Card') echo 'selected'; ?>>New Card</option>
                                                <option value="Renew" <?php if ($row['eGate_charges_type'] == 'Renew') echo 'selected'; ?>>Renew</option>
                                            </select>
                                            <!-- <span class="text-danger" id="charges_type_error"></span> -->
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Charges</label>
                                            <select name="charges" id="charges" class="form-select form-control house-id" required>
                                                <option value="">--- Select Charges ---</option>
                                                <option value="2000" <?php if ($row['eGate_charges'] == '2000') echo 'selected'; ?>>2000</option>
                                                <option value="1000" <?php if ($row['eGate_charges'] == '1000') echo 'selected'; ?>>1000</option>
                                            </select>
                                            <!-- <span class="text-danger" id="charges_error"></span> -->
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

    <!-- Offcanvas Toggler -->
    <button class="d2c_offcanvas_toggle position-fixed top-50 start-0 translate-middle-y d-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#d2c_sidebar">
        <i class="far fa-hand-point-right"></i>
    </button>
    <!-- End:Offcanvas Toggler -->

    <!-- Initial  Javascript -->
    <script src="lib/jQuery/jquery-3.5.1.min.js"></script>
    <script src="lib/bootstrap_5/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#house_id").select2();
        });
    </script> -->

    <!-- custom js -->
    <script src="assets/js/main.js"></script>
</body>

</html>