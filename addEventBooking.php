<?php
session_start();
include_once ("includes/config.php");
include_once ("includes/function.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

// insert Function
eventBookingInsert();
?>


        <!-- Main sidebar -->
        <?php
        include ("includes/sidebar.php");
        ?>
        <!-- End:Sidebar -->

        <!-- Main Body-->
        <div class="d2c_main p-4 ps-lg-3">
            <!-- Title -->
            <h4 class="mb-4 text-capitalize">Event</h4>
            <!-- End:Title -->

            <!-- Alert -->
            <?php
            if (isset($_SESSION['success_message_eventBooking'])) {
                echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_message_eventBooking'] . '<a href="eventsDetails" class="btn btn-success" style="float: right; margin-top: -8px;">View Details</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['success_message_eventBooking']);
            }
            if (isset($_SESSION['error_message_eventBooking'])) {
                echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_message_eventBooking'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['error_message_eventBooking']);
            }
            ?>
            <!-- / Alert -->


            <form action="" method="POST" id="event_booking_form" enctype="multipart/form-data">
                <div class="card h-auto">
                    <div class="card-body">
                        <h3 class="card-header">Booking</h3>
                        <hr class="my-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Event Name</label>
                                <input type="text" class="form-control" id="eventName" name="eventName"
                                    placeholder="Enter Event Name" required>
                                <span class="text-danger" id="eventName_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <select name="location" id="location" class="form-control form-select" required>
                                    <option value="">--- Select Location ---</option>
                                    <option value="Shadi Hall">Shadi Hall</option>
                                    <option value="Sports Centre">Sports Centre</option>
                                </select>
                                <span class="text-danger" id="location_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date">
                                <span class="text-danger" id="date_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Timing</label>
                                <div class="input-group input-daterange">
                                    <input type="time" id="startTiming" name="startTiming" placeholder="MM/DD/YYYY"
                                        class="form-control" />
                                    <span class="input-group-text">to</span>
                                    <input type="time" id="endTiming" name="endTiming" placeholder="MM/DD/YYYY"
                                        class="form-control" />
                                </div>
                                <span class="text-danger" id="startTiming_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No Of Persons</label>
                                <input type="text" class="form-control" id="noOfPersons" name="noOfPersons"
                                    placeholder="50">
                                <span class="text-danger" id="noOfPersons_error"></span>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Customer Name</label>
                                <input type="text" class="form-control" id="customerName" name="customerName"
                                    placeholder="Enter Booking Name">
                                <span class="text-danger" id="customerName_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Customer Contact</label>
                                <input type="text" class="form-control" id="EventContact" name="customerContact"
                                    placeholder="03XXXXXXXXX">
                                <span class="text-danger" id="customerContact_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Customer CNIC</label>
                                <input type="text" class="form-control" id="EventCnic" name="customerCnic"
                                    placeholder="XXXXXXXXXXXXX">
                                <span class="text-danger" id="customerCnic_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Payment</label>
                                <input type="text" class="form-control" id="bookingPayment" name="bookingPayment"
                                    placeholder="999">
                                <span class="text-danger" id="bookingPayment_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Payment Type</label>
                                <select class="form-select form-control" id="pymentType" required name="paymentType">
                                    <option value=""> Select Payment Type</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank">Bank</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- submit btn -->
                <div class="mt-3">
                    <button type="submit" id="submit_btn" class="btn btn-primary">Add</button>
                </div>
            </form>


            <!-- End:submit btn -->
        </div>
        <!-- End:Main Body -->
    </div>

<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->

<script>
    var eventContact = document.getElementById('EventContact');
    var EventCnic = document.getElementById('EventCnic');
    var bookingPayment = document.getElementById('bookingPayment');
    eventContact.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    bookingPayment.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    EventCnic.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9-]/g, '');
        if (this.value.length > 5 && this.value[5] !== '-') {
            this.value = this.value.slice(0, 5) + '-' + this.value.slice(5);
        }
        if (this.value.length > 13 && this.value[13] !== '-') {
            this.value = this.value.slice(0, 13) + '-' + this.value.slice(13);
        }
        if (this.value.length > 15) {
            this.value = this.value.slice(0, 15);
        }
    });
</script>