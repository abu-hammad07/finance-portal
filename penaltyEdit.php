<?php
session_start();
include_once("includes/config.php");
include "includes/function2.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
updatePenalty();
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
            <h4 class="mb-4 text-capitalize">Add Penalty</h4>
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
            <?php
            if (isset($_GET['penalty_edit_id'])) {
                $edit_id = mysqli_real_escape_string($conn, $_GET['penalty_edit_id']);
                $edit_query = "SELECT * FROM penalty WHERE id = '$edit_id'";
                $edit_result = mysqli_query($conn, $edit_query);

                if (mysqli_num_rows($edit_result) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($edit_result)) {
            ?>
                        <form action="" method="post" id="penalty_form">
                            <div class="card h-auto">
                                <div class="card-body">
                                    <h3 class="card-header">Information</h3>
                                    <hr class="my-4">
                                    <div class="row g-3">
                                    <input type="text" name="penalty_id" hidden class="form-control" value="<?=$row['id'];?>" >
                                        <div class="col-md-6">
                                            <label class="form-label">Penalty Type</label>
                                            <input type="text" name="penalty_type" class="form-control" value="<?=$row['penalty_type'];?>" placeholder="Enter Penalty Type" required>
                                            <span class="text-danger" id="penalty-type_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Penalty CINC</label>
                                            <input type="text" name="penalty_cnic" class="form-control" value="<?=$row['penalty_cnic'];?>" placeholder="Penalty Charges" required>
                                            <span class="text-danger" id="Penal-Cnic_error"></span>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Penalty Charges</label>
                                            <input type="number" name="penalty_charges" class="form-control" value="<?=$row['penalty_charges'];?>" placeholder="Penalty Charges" required>
                                            <span class="text-danger" id="Penal-charges_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Payment Type</label>
                                            <select class="form-select form-control" id="pymentType" required name="paymentType">
                                                <option value=""> Select Payment Type</option>
                                                <option value="Cash" <?php if ($row['payment_type'] == 'Cash') echo 'selected'; ?>>Cash</option>
                                                <option value="Bank" <?php if ($row['payment_type'] == 'Bank') echo 'selected'; ?>>Bank</option>
                                            </select>
                                        </div>
                                        <!-- Button -->
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" id="Update_btn" type="submit" name="update">Update Now</button>
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
            }else {
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