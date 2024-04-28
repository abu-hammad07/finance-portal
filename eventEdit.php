<?php
session_start();
include_once("includes/config.php");
include_once("includes/function.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

// Update Function
eventBookingUpdate();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Edit Event Booking</title>
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
            <h4 class="mb-4 text-capitalize">Edit Event</h4>
            <!-- End:Title -->

            <?php
            if (isset($_GET['event_edit_id'])) {

                $servant_view_id = mysqli_real_escape_string($conn, $_GET['event_edit_id']);

                $query = "SELECT event_id, eventName, location, dateTime, noOfServant, 
                servants.servant_id, servants.servant_name, servants.email, servants.address, servants.status 
                FROM events_booking
                LEFT JOIN servants ON events_booking.servant_id = servants.servant_id
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
                                        <input type="text" name="event_id" hidden value="<?= $row['event_id'] ?>">
                                        <div class="col-md-6">
                                            <label class="form-label">Event Name</label>
                                            <input type="text" class="form-control" id="eventName" name="eventName" placeholder="Enter Event Name" value="<?= $row['eventName'] ?>">
                                            <span class="text-danger" id="eventName_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Location</label>
                                            <input type="text" class="form-control" id="location" name="location" placeholder="Enter Location" value="<?= $row['location'] ?>">
                                            <span class="text-danger" id="location_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Date Time</label>
                                            <input type="datetime-local" class="form-control" id="dateTime" name="dateTime" value="<?= $row['dateTime'] ?>">
                                            <span class="text-danger" id="dateTime_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">No Of Servant</label>
                                            <input type="text" class="form-control" id="noOfServant" name="noOfServant" placeholder="Enter No Of Servant" value="<?= $row['noOfServant'] ?>">
                                            <span class="text-danger" id="noOfServant_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Servant Name</label>
                                            <select id="servantName" name="servantID" class="form-control">
                                                <option value="<?= $row['servant_id'] ?>"><?= $row['servant_name'] ?></option>
                                            </select>
                                            <span class="text-danger" id="servantName_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <select id="servantEmail" class="form-control">
                                                <option value="<?= $row['email'] ?>"><?= $row['email']; ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Address</label>
                                            <select id="servantAddress" class="form-control">
                                                <option value="<?= $row['address'] ?>"><?= $row['address']; ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Status</label>
                                            <div class="input-group">
                                                <select id="servantStatus" class="form-control">
                                                    <option value="<?= $row['status'] ?>"><?= $row['status']; ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- submit btn -->
                            <div class="mt-3">
                            <button type="submit" id="submit_btn" name="eventBookingUpdate" class="btn btn-primary">Update</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('event_booking_form');

            // Validate input fields
            function validateInput(inputElement, errorElement, validationRegex, errorMessage) {
                inputElement.addEventListener('input', function() {
                    let inputValue = inputElement.value.trim();
                    const isValid = validationRegex.test(inputValue);

                    if (!isValid) {
                        errorElement.textContent = errorMessage;
                        errorElement.style.display = 'block';
                        inputElement.classList.add('is-invalid');
                    } else {
                        errorElement.textContent = '';
                        errorElement.style.display = 'none';
                        inputElement.classList.remove('is-invalid');
                    }
                });
            }

            // Validation regex patterns and error messages
            const validationRules = {
                eventName: {
                    regex: /^.{1,}$/, // At least one character
                    errorMessage: 'Please enter an event name.'
                },
                location: {
                    regex: /^.{1,}$/, // At least one character
                    errorMessage: 'Please enter a location.'
                },
                dateTime: {
                    regex: /^.{1,}$/, // At least one character
                    errorMessage: 'Please select a date and time.'
                },
                noOfServant: {
                    regex: /^\d*$/, // Allow any number of digits
                    errorMessage: 'Please enter a valid number for the number of servants.'
                },
                servantName: {
                    regex: /^.{1,}$/, // At least one character
                    errorMessage: 'Please select servant name.'
                }
            };

            // Loop through each input field and attach validation
            Object.keys(validationRules).forEach(key => {
                const inputElement = document.getElementById(key);
                const errorElement = document.getElementById(`${key}_error`);
                validateInput(inputElement, errorElement, validationRules[key].regex, validationRules[key].errorMessage);
            });

            // Function to validate form submission
            function validateForm(event) {
                event.preventDefault(); // Prevent form submission

                let isValid = true;

                // Check if any input field is empty
                Object.keys(validationRules).forEach(key => {
                    const inputElement = document.getElementById(key);
                    const errorElement = document.getElementById(`${key}_error`);
                    const inputValue = inputElement.value.trim();
                    const isValidField = validationRules[key].regex.test(inputValue);

                    if (!isValidField) {
                        errorElement.textContent = validationRules[key].errorMessage;
                        errorElement.style.display = 'block';
                        inputElement.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        errorElement.textContent = '';
                        errorElement.style.display = 'none';
                        inputElement.classList.remove('is-invalid');
                    }
                });

                // Submit the form if all inputs are valid
                if (isValid) {
                    form.submit();
                }
            }

            // Event listener for form submission
            form.addEventListener('submit', validateForm);
        });
    </script>


    <!-- Initial  Javascript -->
    <script src="lib/jQuery/jquery-3.5.1.min.js"></script>
    <script src="lib/bootstrap_5/bootstrap.bundle.min.js"></script>

    <!-- custom js -->
    <script src="assets/js/main.js"></script>
</body>

</html>