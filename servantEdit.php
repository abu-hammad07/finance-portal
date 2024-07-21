<?php
session_start();
include_once("includes/config.php");
include_once("includes/function.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

// Update Servants
serventUpdate();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Edit Servants</title>
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
            <h4 class="mb-4 text-capitalize">Edit Servant</h4>
            <!-- End:Title -->

            <?php
            if (isset($_GET['servant_edit_id'])) {

                $servant_edit_id = mysqli_real_escape_string($conn, $_GET['servant_edit_id']);

                $query = "SELECT servants.*, houses.house_id, houses.house_number, houses.owner_name, houses.owner_contact
                    FROM servants
                    INNER JOIN houses ON servants.house_id = houses.house_id
                    WHERE servants.servant_id = '$servant_edit_id'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
            ?>
                        <form action="" method="post" id="add_servant_form" enctype="multipart/form-data">
                            <div class="card h-auto">
                                <div class="card-body">
                                    <h3 class="card-header">Information</h3>
                                    <hr class="my-4">
                                    <div class="row g-3">
                                    <input type="text" hidden  name="servant_id" class="form-control" placeholder="Enter Designation" value="<?= $row['servant_id'] ?>" required>

                                        <div class="col-md-6">
                                            <label class="form-label">House/Unit Number</label>
                                            <select name="house_id" id="house_id" class="form-select form-control house-id" required>
                                                <option value="<?= $row['house_id'] ?>"><?= $row['house_number'] ?></option>
                                            </select>
                                            <span class="text-danger" id="house_id_error"></span>
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
                                            <label class="form-label">Designation</label>
                                            <input type="text" id="designation" name="designation" class="form-control" placeholder="Enter Designation" value="<?= $row['servantDesignation'] ?>" required>
                                            <span class="text-danger" id="designation_error"></span>
                                        </div>
                                        <div class="col-md-6 ">
                                            <label class="form-label">Fees</label>
                                            <input type="text" id="servant_fees" name="servant_fees" class="form-control" placeholder="999" value="<?= $row['servantFees'] ?>" required>
                                            <span class="text-danger" id="servant_fees_error"></span>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label"> Payment Type</label>
                                            <select class="form-select" id="pymentType" required name="pymentType">
                                                <option value="<?= $row['payment_type'] ?>"> <?= $row['payment_type'] ?></option>
                                                <option value="Cash">Cash</option>
                                                <option value="Bank">Bank</option>
                                            </select>
                                            <span class="text-danger"></span>
                                        </div>

                                        <!-- Button -->
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" id="servant_btn" type="submit" name="serventUpdate">Update</button>
                                            <a href="servants" class="btn btn-outline-danger">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

            <?php
                    }
                } else {
                    header('location: 404');
                    exit();
                }
            }
            ?>


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

    <!-- custom js -->
    <script src="assets/js/main.js"></script>
</body>

</html>