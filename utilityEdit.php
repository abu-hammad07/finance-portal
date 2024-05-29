<?php
session_start();
include_once("includes/config.php");
include_once("includes/function.php");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
updatedUtilityCharges();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Edit Utility Charges</title>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
            <h4 class="mb-4 text-capitalize">Edit Utility Charges</h4>
            <!-- End:Title -->

            <?php
            if (isset($_GET['utility_edit_id'])) {

                $utility_edit_id = mysqli_real_escape_string($conn, $_GET['utility_edit_id']);

                $query = "SELECT * FROM utility_charges WHERE utility_id = '$utility_edit_id'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
            ?>

                        <form action="" method="post" id="add_houses_form">
                            <div class="card h-auto">
                                <div class="card-body">
                                    <h3 class="card-header">Information</h3>
                                    <hr class="my-4">
                                    <div class="row g-3">
                                        <input type="text" hidden name="utility_id" id="utility_id" class="form-control" value="<?= $row['utility_id'] ?>">
                                        <div class="col-md-6">
                                            <label class="form-label">Utility Type</label>
                                            <input type="text" name="utility_type" id="utility_type" class="form-control" placeholder="Electricity" required value="<?= $row['utility_type'] ?>">
                                            <span class="text-danger" id="utility_type_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Amount</label>
                                            <input type="number" name="utility_amount" id="utility_amount" class="form-control" placeholder="$100" required value="<?= $row['utility_amount'] ?>">
                                            <span class="text-danger" id="utility_amount_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Billing Month</label>
                                            <input type="month" name="utility_billing_month" id="utility_billing_month" class="form-control" required value="<?= $row['utility_billing_month'] ?>">
                                            <span class="text-danger" id="utility_billing_month_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Location</label>
                                            <select name="utility_location" id="utility_location" class="form-select form-control" required>
                                                <option value="" <?php if ($row['utility_location'] == '') echo 'selected'; ?>>Select Location</option>
                                                <option value="Office" <?php if ($row['utility_location'] == 'Office') echo 'selected'; ?>>Office</option>
                                                <option value="Sports Area" <?php if ($row['utility_location'] == 'Sports Area') echo 'selected'; ?>>Sports Area</option>
                                                <option value="Shadi Hall" <?php if ($row['utility_location'] == 'Shadi Hall') echo 'selected'; ?>>Shadi Hall</option>
                                                <option value="Other" <?php if ($row['utility_location'] == 'Other') echo 'selected'; ?>>Other</option>
                                            </select>
                                            <span class="text-danger" id="utility_location_error"></span>
                                        </div>

                                        <!-- Button -->
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" id="submit_btn" type="submit" name="update_utility">Update</button>
                                            <a href="utilityCharges" class="btn btn-outline-danger">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

            <?php
                    }
                } else {
                    echo '<div id="successAlert" class="alert alert-warning alert-dismissible fade show" role="alert">
                    No Data Found.</div>';
                }
            } else {
                echo '<div id="successAlert" class="alert alert-warning alert-dismissible fade show" role="alert">
                No ID Found.</div>';
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
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#house_shop_id").select2();
        });
    </script>

    <!-- custom js -->
    <script src="assets/js/main.js"></script>
</body>

</html>