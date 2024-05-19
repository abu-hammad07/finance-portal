<?php
session_start();
include_once("includes/config.php");
include "includes/function.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
updateHouse();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>View House</title>
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
            <h4 class="mb-4 text-capitalize">View House</h4>
            <!-- End:Title -->

            <?php
            if (isset($_GET['house_view_id'])) {
                $edit_id = mysqli_real_escape_string($conn, $_GET['house_view_id']);
                $edit_query = "SELECT * FROM houses WHERE house_id = '$edit_id'";
                $edit_result = mysqli_query($conn, $edit_query);

                if (mysqli_num_rows($edit_result) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($edit_result)) {
            ?>
                        <form action="" method="post" id="add_houses_form">
                            <div class="card h-auto">
                                <div class="card-body">
                                    <h3 class="card-header">Information</h3>
                                    <hr class="my-4">
                                    <div class="row g-3">
                                        <input type="text" hidden name="house_id" value="<?= $row['house_id'] ?>">
                                        <div class="col-md-6">
                                            <label class="form-label">House/Unit Number</label>
                                            <input type="number" readonly name="house-number" class="form-control" placeholder="Enter House/Unit Number" required value="<?= $row['house_number'] ?>">
                                            <span class="text-danger" id="house-number_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Owner's Name</label>
                                            <input type="text" readonly name="owner-name" class="form-control" placeholder="Enter Owner's Name" required value="<?= $row['owner_name'] ?>">
                                            <span class="text-danger" id="owner-name_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Owner's Contact</label>
                                            <input type="number" readonly name="owner-contact" class="form-control" placeholder="Enter Owner's Contact Information" required value="<?= $row['owner_contact'] ?>">
                                            <span class="text-danger" id="owner-contact_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Owner's CINC</label>
                                            <input type="number" readonly name="owner-cinc" class="form-control" placeholder="XXXXX-XXXXXXX-X" value="<?= $row['owner_cnic'] ?>" required>
                                            <span class="text-danger" id="owner-cinc_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="owner" class="form-label">Occupancy Status</label>
                                            <select id="owner" name="occupance-status" class="form-select form-control">
                                                <option value="<?= $row['occupancy_status'] ?>"><?= $row['occupancy_status'] ?></option>
                                            </select>
                                            <span class="text-danger" id="occupance-status_error"></span>
                                        </div>
                                        <div class="col-md-6 ">
                                            <label for="floor" class="form-label">Floor</label>
                                            <select id="floor" name="floor" class="form-select form-control">
                                                <option value="<?= $row['floor'] ?>"><?= $row['floor'] ?></option>
                                            </select>
                                            <span class="text-danger" id="floor_error"></span>
                                        </div>
                                        <div class="col-md-6 ">
                                            <label for="property-type" class="form-label">Type of Property</label>
                                            <select id="property-type" name="property-type" class="form-select form-control">
                                                <option value="<?= $row['property_type'] ?>"><?= $row['property_type'] ?></option>
                                            </select>
                                            <span class="text-danger" id="property-type_error"></span>
                                        </div>
                                        <div class="col-md-6 ">
                                            <label class="form-label">Size/Area of the Property</label>
                                            <select id="size" name="property-size" class="form-select form-control">
                                                <option value="<?= $row['property_size'] ?>"><?= $row['property_size'] ?></option>
                                            </select>
                                            <span class="text-danger" id="property-size_error"></span>
                                        </div>
                                        <div class="col-md-6 ">
                                            <label class="form-label">Monthly Maintenance Fee</label>
                                            <input name="maintenance-charges" readonly type="number" class="form-control" placeholder="Enter Monthly Maintenance Fee" required value="<?= $row['maintenance_charges'] ?>">
                                            <span class="text-danger" id="maintenance-charges_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- submit btn -->
                            <div class="mt-3">
                                <a href="houses" class="btn btn-danger">Back</a>
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