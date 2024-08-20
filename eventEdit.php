<?php
session_start();
include_once ("includes/config.php");
include_once ("includes/function.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

// Update Function
eventBookingUpdate();
?>


<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">
    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Edit Event</h4>
    <!-- End:Title -->

    <?php
    if (isset($_GET['event_edit_id'])) {

        $servant_view_id = mysqli_real_escape_string($conn, $_GET['event_edit_id']);

        $query = "SELECT * FROM events_booking WHERE event_id = '$servant_view_id'";
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
                                <input type="text" class="form-control" hidden name="event_id" value="<?= $row['event_id'] ?>">
                                <div class="col-md-6">
                                    <label class="form-label">Event Name</label>
                                    <input type="text" class="form-control" id="eventName" name="eventName"
                                        placeholder="Enter Event Name" value="<?= $row['eventName'] ?>" required>
                                    <span class="text-danger" id="eventName_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Location</label>
                                    <select name="location" id="location" class="form-control form-select" required>
                                        <!-- <option value="">--- Select Location ---</option> -->
                                        <option value="Shadi Hall" <?php if ($row['location'] == 'Shadi Hall')
                                            echo "selected"; ?>>
                                            Shadi Hall</option>
                                        <option value="Sports Centre" <?php if ($row['location'] == 'Sports Centre')
                                            echo "selected"; ?>>Sports Centre</option>
                                    </select>
                                    <span class="text-danger" id="location_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" value="<?= $row['date'] ?>">
                                    <span class="text-danger" id="date_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Timing</label>
                                    <div class="input-group input-daterange">
                                        <input type="time" id="startTiming" name="startTiming" placeholder="MM/DD/YYYY"
                                            class="form-control" value="<?= $row['startTiming'] ?>" />
                                        <span class="input-group-text">to</span>
                                        <input type="time" id="endTiming" name="endTiming" placeholder="MM/DD/YYYY"
                                            class="form-control" value="<?= $row['endTiming'] ?>" />
                                    </div>
                                    <span class="text-danger" id="startTiming_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No Of Persons</label>
                                    <input type="text" class="form-control" id="noOfPersons" name="noOfPersons" placeholder="50"
                                        value="<?= $row['noOfPersons'] ?>">
                                    <span class="text-danger" id="noOfPersons_error"></span>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Customer Name</label>
                                    <input type="text" class="form-control" id="customerName" name="customerName"
                                        placeholder="Enter Booking Name" value="<?= $row['customerName'] ?>">
                                    <span class="text-danger" id="customerName_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Customer Contact</label>
                                    <input type="number" class="form-control" id="customerContact" name="customerContact"
                                        placeholder="03XXXXXXXXX" value="<?= $row['customerContact'] ?>">
                                    <span class="text-danger" id="customerContact_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Customer CNIC</label>
                                    <input type="number" class="form-control" id="customerCnic" name="customerCnic"
                                        placeholder="XXXXXXXXXXXXX" value="<?= $row['customerCnic'] ?>">
                                    <span class="text-danger" id="customerCnic_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Payment</label>
                                    <input type="number" class="form-control" id="bookingPayment" name="bookingPayment"
                                        placeholder="999" value="<?= $row['bookingPayment'] ?>">
                                    <span class="text-danger" id="bookingPayment_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Payment Type</label>
                                    <select class="form-select form-control" id="pymentType" required name="paymentType">
                                        <option value=""> Select Payment Type</option>
                                        <option value="Cash" <?php if ($row['payment_type'] == 'Cash')
                                            echo 'selected'; ?>>Cash
                                        </option>
                                        <option value="Bank" <?php if ($row['payment_type'] == 'Bank')
                                            echo 'selected'; ?>>Bank
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- submit btn -->
                    <div class="mt-3">
                        <button type="submit" id="submit_btn" name="eventBookingUpdate" class="btn btn-primary">Update</button>
                        <a href="eventsDetails" class="btn btn-outline-danger">Back</a>
                    </div>
                </form>

                <?php
            }
        } else {
            echo '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database.</td>
                </tr>';
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


<!-- JavaScript code -->
<script>
    $(document).ready(function () {
        // Function to fetch servants count and update input field
        function updateServantsCount() {
            $.ajax({
                url: 'get_servants_count.php', // PHP script to get total servants count
                type: 'GET',
                success: function (response) {
                    var totalServants = parseInt(response);
                    var enteredValue = parseInt($('#noOfServant').val());
                    $('#noOfServant').attr('placeholder', 'Enter No Of Servant (Total: ' + totalServants + ')');

                    // Check if entered value exceeds total servants count
                    if (enteredValue > totalServants) {
                        $('#noOfServant_error').text('Error: Cannot exceed total servants count (' + totalServants + ')');
                    } else {
                        $('#noOfServant_error').text('');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        // Call the function whenever the input field value changes
        $('#noOfServant').on('input', function () {
            updateServantsCount();
        });

        // Call the function when the page loads
        updateServantsCount();
    });
</script>