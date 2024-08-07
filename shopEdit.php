<?php
session_start();
include_once("includes/config.php");
include "includes/function.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
addShopupdate();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Add Shop</title>
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
            <h4 class="mb-4 text-capitalize">Edit Shop</h4>
            <!-- End:Title -->

            <?php
            if (isset($_GET['shop_edit_id'])) {

                $shop_edit_id = mysqli_real_escape_string($conn, $_GET['shop_edit_id']);

                $query = "SELECT * FROM shops WHERE shop_id = '$shop_edit_id'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
            ?>

                        <form action="" method="post" id="add_shop_form">
                            <div class="card h-auto">
                                <div class="card-body">
                                    <h3 class="card-header">Information</h3>
                                    <hr class="my-4">
                                    <div class="row g-3">
                                        <input type="text" hidden name="shop_id" class="form-control" value="<?= $row['shop_id'] ?>">
                                        <div class="col-md-6">
                                            <label class="form-label">Shop Number</label>
                                            <input type="text" id="shop_number" name="shop_number" class="form-control" placeholder="Enter House/Unit Number" required value="<?= $row['shop_number'] ?>">
                                            <span class="text-danger" id="shop_number_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Owner's Name</label>
                                            <input type="text" name="owner_name" id="owner_name" class="form-control" placeholder="Enter Owner's Name" value="<?= $row['owner_name'] ?>">
                                            <span class="text-danger" id="owner_name_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Owner's Contact Number</label>
                                            <input type="text" name="owner_contact" id="owner_contact" class="form-control" placeholder="03XXXXXXXXX" value="<?= $row['owner_contact'] ?>">
                                            <span class="text-danger" id="owner_contact_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Owner's CINC</label>
                                            <input type="text" name="owner_cinc" id="owner_cinc" class="form-control" placeholder="XXXXX-XXXXXXX-X" value="<?= $row['owner_cnic'] ?>">
                                            <span class="text-danger" id="owner_cinc_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="owner" class="form-label">Occupancy Status</label>
                                            <select id="occupancy_status" name="occupancy_status" class="form-select form-control" value="<?= $row['occupancy_status'] ?>">
                                                <!-- <option value="">-----</option> -->
                                                <option value="owned" <?php if ($row['occupancy_status'] == 'owned') echo "selected" ?>>Owned</option>
                                                <option value="rented" <?php if ($row['occupancy_status'] == 'rented') echo "selected" ?>>Rented</option>
                                            </select>
                                            <span class="text-danger" id="occupancy_status_error"></span>
                                        </div>
                                        <div class="col-md-6 ">
                                            <label for="floor" class="form-label">Floor</label>
                                            <select id="floor" name="floor" class="form-select form-control">
                                                <!-- <option value="">-----</option> -->
                                                <option value="ground" <?php if ($row['floor'] == 'ground') echo "selected" ?>>Ground</option>
                                                <option value="floor1" <?php if ($row['floor'] == 'floor1') echo "selected" ?>>Floor 1</option>
                                                <option value="floor2" <?php if ($row['floor'] == 'floor2') echo "selected" ?>>Floor 2</option>
                                                <option value="floor3" <?php if ($row['floor'] == 'floor3') echo "selected" ?>>Floor 3</option>
                                                <option value="floor4" <?php if ($row['floor'] == 'floor4') echo "selected" ?>>Floor 4</option>
                                            </select>
                                            <span class="text-danger" id="floor_error"></span>
                                        </div>
                                        <div class="col-md-6 ">
                                            <label class="form-label">Size/Area of the Property</label>
                                            <select id="property_size" name="property_size" class="form-select form-control">
                                                <!-- <option value="">-----</option> -->
                                                <option value="60 sq yards" <?php if ($row['property_size'] == '60 sq yards') echo "selected" ?>>60 sq yards</option>
                                                <option value="120 sq yards" <?php if ($row['property_size'] == '120 sq yards') echo "selected" ?>>120 sq yards</option>
                                            </select>
                                            <span class="text-danger" id="property_size_error"></span>
                                        </div>
                                        <div class="col-md-6 ">
                                            <label class="form-label">Monthly Maintenance Fee</label>
                                            <input name="maintenance_charges" id="maintenance_charges" type="text" class="form-control" placeholder="999" value="<?= $row['maintenance_charges'] ?>">
                                            <span class="text-danger" id="maintenance_charges_error"></span>
                                        </div>

                                        <!-- Button -->
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" id="shop_btn" type="submit" name="submit">Update</button>
                                            <a href="shops" class="btn btn-outline-danger">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

            <?php
                    }
                } else {
                    echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    No Data Found.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                }
            } else {
                echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                No ID Found.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            }
            ?>

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

    <!-- custom js -->
    <script src="assets/js/main.js"></script>
</body>

</html>