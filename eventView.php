<?php
session_start();
include_once ("includes/config.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
?>


<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
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
                                    <input type="text" class="form-control" id="eventName" name="eventName" readonly
                                        placeholder="Enter Event Name" value="<?= $row['eventName'] ?>">
                                    <span class="text-danger" id="eventName_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Location</label>
                                    <input type="text" class="form-control" id="location" name="location" readonly
                                        placeholder="Enter Location" value="<?= $row['location'] ?>">
                                    <span class="text-danger" id="location_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date" readonly name="date"
                                        value="<?= $row['date'] ?>">
                                    <span class="text-danger" id="date_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Timing</label>
                                    <div class="input-group input-daterange">
                                        <input type="time" id="startTiming" readonly name="startTiming" placeholder="MM/DD/YYYY"
                                            class="form-control" value="<?= $row['startTiming'] ?>" />
                                        <span class="input-group-text">to</span>
                                        <input type="time" id="endTiming" readonly name="endTiming" placeholder="MM/DD/YYYY"
                                            class="form-control" value="<?= $row['endTiming'] ?>" />
                                    </div>
                                    <span class="text-danger" id="startTiming_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No Of Persons</label>
                                    <input type="text" class="form-control" id="noOfServant" name="noOfServant" readonly
                                        placeholder="Enter No Of Persons" value="<?= $row['noOfPersons'] ?>">
                                    <span class="text-danger" id="noOfServant_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Event Type</label>
                                    <input type="text" class="form-control" id="bookingName" name="bookingName" readonly
                                        placeholder="Enter Customer Name" value="<?= $row['eventType'] ?>">
                                    <span class="text-danger" id="bookingName_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Customer CNIC</label>
                                    <input type="text" class="form-control" id="bookingEmail" name="bookingEmail" readonly
                                        placeholder=" Customer CNIC" value="<?= $row['customerCnic'] ?>">
                                    <span class="text-danger" id="bookingEmail_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Customer Contact</label>
                                    <input type="text" class="form-control" id="bookingContact" name="bookingContact" readonly
                                        placeholder=" Customer Contact" value="<?= $row['customerContact'] ?>">
                                    <span class="text-danger" id="bookingContact_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Payment</label>
                                    <input type="text" class="form-control" id="bookingPayment" name="bookingPayment" readonly
                                        placeholder="Enter Payment" value="<?= $row['bookingPayment'] ?>">
                                    <span class="text-danger" id="bookingPayment_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Payment Type</label>
                                    <select class="form-select form-control" id="pymentType" required name="paymentType">
                                        <option value="<?= $row['payment_type'] ?>"><?= $row['payment_type'] ?></option>
                                    </select>
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

<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->