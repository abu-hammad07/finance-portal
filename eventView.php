<?php
session_start();
include_once("includes/config.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>View Event Booking</title>
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
            <h4 class="mb-4 text-capitalize">View Event</h4>
            <!-- End:Title -->

            <?php
            if (isset($_GET['event_view_id'])) {

                $servant_view_id = mysqli_real_escape_string($conn, $_GET['event_view_id']);

                $query = "SELECT * FROM events_booking
                WHERE event_id = '$servant_view_id'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
            ?>
                        <form action="" method="POST" id="event_booking_form" enctype="multipart/form-data">
                            <div class="card h-auto">
                                <div class="card-body">
                                    <h3 class="card-header">Booking</h3>
                                    <hr class="my-4">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Event Name</label>
                                            <input type="text" class="form-control" id="eventName" name="eventName" readonly placeholder="Enter Event Name" value="<?= $row['eventName'] ?>">
                                            <span class="text-danger" id="eventName_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Location</label>
                                            <input type="text" class="form-control" id="location" name="location" readonly placeholder="Enter Location" value="<?= $row['location'] ?>">
                                            <span class="text-danger" id="location_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Date</label>
                                            <input type="date" class="form-control" id="date" readonly name="date" value="<?= $row['date'] ?>">
                                            <span class="text-danger" id="date_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Timing</label>
                                            <div class="input-group input-daterange">
                                                <input type="time" id="startTiming" readonly name="startTiming" placeholder="MM/DD/YYYY" class="form-control" value="<?= $row['startTiming'] ?>" />
                                                <span class="input-group-text">to</span>
                                                <input type="time" id="endTiming" readonly name="endTiming" placeholder="MM/DD/YYYY" class="form-control" value="<?= $row['endTiming'] ?>" />
                                            </div>
                                            <span class="text-danger" id="startTiming_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">No Of Servant</label>
                                            <input type="text" class="form-control" id="noOfServant" name="noOfServant" readonly placeholder="Enter No Of Servant" value="<?= $row['noOfServant'] ?>">
                                            <span class="text-danger" id="noOfServant_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Booking Name</label>
                                            <input type="text" class="form-control" id="bookingName" name="bookingName" readonly placeholder="Enter Booking Name" value="<?= $row['bookingName'] ?>">
                                            <span class="text-danger" id="bookingName_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" id="bookingEmail" name="bookingEmail" readonly placeholder="Enter Email" value="<?= $row['bookingEmail'] ?>">
                                            <span class="text-danger" id="bookingEmail_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Contact</label>
                                            <input type="text" class="form-control" id="bookingContact" name="bookingContact" readonly placeholder="Enter Contact" value="<?= $row['bookingContact'] ?>">
                                            <span class="text-danger" id="bookingContact_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Payment</label>
                                            <input type="text" class="form-control" id="bookingPayment" name="bookingPayment" readonly placeholder="Enter Payment" value="<?= $row['bookingPayment'] ?>">
                                            <span class="text-danger" id="bookingPayment_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- submit btn -->
                            <div class="mt-3">
                                <a href="eventsDetails" class="btn btn-danger">Back</a>
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