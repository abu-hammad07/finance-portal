<?php
session_start();
include_once ("includes/config.php");
include "includes/function.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
addHouse();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Add House</title>
    <meta name="og:description"
        content="FinDeshY is a free financial Bootstrap dashboard template to manage your financial data easily. This free financial dashboard uses Bootstrap to provide a responsive and user-friendly interface. Whether you're a small business owner seeking insights into your company's financial health or an individual looking to simplify your personal finances, this free Bootstrap dashboard template has you covered.">
    <meta name="robots" content="index, follow">
    <meta name="og:title" property="og:title" content="FinDeshY - Free Financial Bootstrap Dashboard Template">
    <meta property="og:image"
        content="https://www.designtocodes.com/wp-content/uploads/2023/10/FinDeshY-Professional-Financial-Bootstrap-Dashboard-Template.jpg">
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
        include ("includes/sidebar.php");
        ?>
        <!-- End:Sidebar -->

        <!-- Main Body-->
        <div class="d2c_main p-4 ps-lg-3">

            <!-- Title -->
            <h4 class="mb-4 text-capitalize">Add New House</h4>
            <!-- End:Title -->

            <div class="card h-auto">
                <div class="card-body">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-6 col-xl-4">
                                <div class="mb-4">
                                    <label class="form-label">House/Unit Number</label>
                                    <input type="number" name="house-number"class="form-control" placeholder="Enter House/Unit Number"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="mb-4">
                                    <label class="form-label">Owner's Name</label>
                                    <input type="text" name="owner-name" class="form-control" placeholder="Enter Owner's Name" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="mb-4">
                                    <label class="form-label">Owner's Contact Information</label>
                                    <input type="number" name="owner-contact" class="form-control"
                                        placeholder="Enter Owner's Contact Information" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="mb-4">
                                    <label for="owner" class="form-label">Occupancy Status</label>
                                    <select id="owner" name="occupance-status" class="form-select form-control">
                                        <option>-----</option>
                                        <option value="owned">Owned</option>
                                        <option value="rented">Rented</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="mb-4">
                                    <label class="form-label">Tenant's Name (if applicable)</label>
                                    <input type="text" name="tenants-name" class="form-control" placeholder="Enter Tenant's Name">
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="mb-4">
                                    <label class="form-label">Tenant's Contact Information (if applicable)</label>
                                    <input type="text" name="tenant-contact" class="form-control"
                                        placeholder="Enter Tenant's Contact Information">
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="mb-4">
                                    <label for="floor" class="form-label">Floor</label>
                                    <select id="floor" name="floor" class="form-select form-control">
                                        <option>-----</option>
                                        <option value="ground">Ground</option>
                                        <option value="floor1">Floor 1</option>
                                        <option value="floor2">Floor 2</option>
                                        <option value="floor3">Floor 3</option>
                                        <option value="floor4">Floor 4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="mb-4">
                                    <label for="property-type" class="form-label">Type of Property</label>
                                    <select id="property-type" name="property-type"class="form-select form-control">
                                        <option>-----</option>
                                        <option value="Apartment">Apartment</option>
                                        <option value="Duplex">Duplex</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="mb-4">
                                    <label class="form-label">Size/Area of the Property</label>
                                    <select id="size" name="property-size" class="form-select form-control">
                                        <option>-----</option>
                                        <option value="60 sq yards">60 sq yards</option>
                                        <option value="120 sq yards">120 sq yards</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-xl-4">
                                <div class="mb-4">
                                    <label class="form-label">Monthly Maintenance Fee</label>
                                    <input name="maintenance-charges" type="number" class="form-control"
                                        placeholder="Enter Monthly Maintenance Fee" required>
                                </div>
                            </div>


                            <div class="col-8">
                                <div class="mb-4">
                                    <label class="form-label">Additional Notes/Comments</label>
                                    <textarea cols="30" rows="4" class="form-control"
                                        placeholder="Write Additional Notes" name="notes"></textarea>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary" type="submit" name="submit">Add Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End:Main Body -->
    </div>

    <!-- Offcanvas Toggler -->
    <button class="d2c_offcanvas_toggle position-fixed top-50 start-0 translate-middle-y d-block d-lg-none"
        type="button" data-bs-toggle="offcanvas" data-bs-target="#d2c_sidebar">
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