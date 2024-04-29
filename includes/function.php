<?php
include "config.php";

// Add Houses
function addHouse()
{
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $houseNumber = $_POST['house-number'];
        $ownerName = $_POST['owner-name'];
        $ownerContact = $_POST['owner-contact'];
        $occupanceStatus = $_POST['occupance-status'];
        $tenantsName = $_POST['tenants-name'];
        $tenantContact = $_POST['tenant-contact'];
        $floor = $_POST['floor'];
        $propertyType = $_POST['property-type'];
        $propertySize = $_POST['property-size'];
        $maintenanceCharges = $_POST['maintenance-charges'];
        $notes = $_POST['notes'];

        $added_by = $_SESSION['username'];

        $insertQuery = "INSERT INTO `houses`(`house_number`, `owner_name`, `owner_contact`,
         `occupancy_status`, `tenants_name`, `tenants_contact`, `property_size`, 
         `floor`, `property_type`, `maintenance_charges`, `notes`, `added_on`,
          `added_by`) VALUES ('{$houseNumber}','{$ownerName}','{$ownerContact}',
          '{$occupanceStatus}',
          '{$tenantsName}','{$tenantContact}','{$propertySize}','{$floor}',
          '{$propertyType}','{$maintenanceCharges}',
          '{$notes}',NOW(),'{$added_by}')";

        $query = mysqli_query($conn, $insertQuery);
        if ($query) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Data Inserted Successfully!</strong>.
            <button type='button' class='btn-close'- data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Failed to add at the moment.</strong>.
            <button type='button' class='btn-close'- data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
    }
}

// Delete House Record
function deleteHouse()
{
    global $conn;
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $deleteQuery = "DELETE FROM houses where house_id = ('{$delete_id}')";
        $deleteSQL = mysqli_query($conn, $deleteQuery);
        if (!$deleteSQL) {
            die("QUERY FAILED" . mysqli_error($conn));
        } else {
        }
    }
}



// ========================= servant =========================
function servantSubmit()
{
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        // Get the current date and time
        $created_date = date('Y-m-d');
        // Get the user's ID and name
        $created_by = $_SESSION['UID'];


        // check duplicate email
        $check_email = "SELECT * FROM `servants` WHERE `email` = '$email'";
        $check_username_res = mysqli_query($conn, $check_email);

        if (mysqli_num_rows($check_username_res) > 0) {
            $_SESSION['error_message_servant'] = "Email already exists $full_name, ($email)";
            header("location: addServant");
            exit();
        } else {

            // Upload image
            $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], 'media/images/' . $image);

            // Insert data into user_details table first
            $insert_details = "INSERT INTO `servants`(`servant_name`, `phone`, `address`, `gender`, `status`, `email`, `image`, `added_by`, `added_on`
            ) VALUES (
                '$full_name', '$phone', '$address', '$gender', '$status', '$email', '$image', '$created_by', '$created_date'
            )";

            $insert_udetails_res = mysqli_query($conn, $insert_details);

            if ($insert_udetails_res) {

                $_SESSION['success_message_servant'] = "$full_name Successfully Added";
                header('location: addServant');
                exit();
            } else {
                $_SESSION['error_message_servant'] = "$full_name not added";
                header('location: addServant');
                exit();
            }
        }
    }
}
// ========================= end of servant =========================


// ========================= Start servent Update =========================
function serventUpdate()
{
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $servant_id = mysqli_real_escape_string($conn, $_POST['servant_id']);
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        // Get the current date and time
        $updated_date = date('Y-m-d');
        // Get the user's ID and name
        $updated_by = $_SESSION['UID'];


        // check duplicate email
        $check_email = "SELECT * FROM `servants` WHERE `email` = '$email' AND `servant_id` != '$servant_id'";
        $check_username_res = mysqli_query($conn, $check_email);

        if (mysqli_num_rows($check_username_res) > 0) {
            $_SESSION['error_updated_servant'] = "Email already exists $full_name, ($email)";
            header("location: servants");
            exit();
        } else {

            // Upload image empty
            $image = '';
            if (!empty($_FILES['image']['name'])) {
                $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], 'media/images/' . $image);
            }

            // Update data into servants table
            $servant_update = "UPDATE `servants` SET
            `servant_name` = '$full_name',
            `phone` = '$phone',
            `address` = '$address',
            `gender` = '$gender',
            `status` = '$status',
            `email` = '$email',
            `updated_by` = '$updated_by',
            `updated_on` = '$updated_date'";

            if (!empty($image)) {
                $servant_update .= ", `image` = '$image'";
            }

            $servant_update .= " WHERE `servant_id` = '$servant_id'";

            $servant_udetails_res = mysqli_query($conn, $servant_update);

            if ($servant_udetails_res) {

                $_SESSION['success_updated_servant'] = "$full_name Successfully Updated";
                header('location: servants');
                exit();
            } else {
                $_SESSION['error_updated_servant'] = "$full_name not updated";
                header('location: servants');
                exit();
            }
        }
    }
}
// ========================= End servent Update =========================



// ========================= Start Event Booking Insert  =========================
function eventBookingInsert()
{
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $eventName = mysqli_real_escape_string($conn, $_POST['eventName']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);
        $dateTime = mysqli_real_escape_string($conn, $_POST['dateTime']);
        $noOfServant = mysqli_real_escape_string($conn, $_POST['noOfServant']);
        $servantID = mysqli_real_escape_string($conn, $_POST['servantID']);


        // Get the current date and time
        $added_on = date('Y-m-d');
        $added_by = $_SESSION['username'];

        // check duplicate location
        $check_location = "SELECT * FROM `events_booking` WHERE `location` = '$location'";
        $check_location_res = mysqli_query($conn, $check_location);

        if (mysqli_num_rows($check_location_res) > 0) {
            $_SESSION['error_message_eventBooking'] = "Location already exists ($location)";
            header("location: eventBooking");
            exit();
        }

        // insert data into event_booking table
        $insertEventBooking = "INSERT INTO `events_booking` (
        `servant_id`, `eventName`, `location`, `dateTime`, `noOfServant`, `added_on`, `added_by`) 
    VALUES ('$servantID', '$eventName', '$location', '$dateTime', '$noOfServant', '$added_on', '$added_by')";

        $insertEventBooking_res = mysqli_query($conn, $insertEventBooking);

        if ($insertEventBooking_res) {
            $_SESSION['success_message_eventBooking'] = "($eventName) Successfully Added.";
            header('location: eventBooking');
            exit();
        } else {
            $_SESSION['error_message_eventBooking'] = "($eventName) Not Added.";
            header('location: eventBooking');
            exit();
        }
    }
}
// ========================= End Event Booking Insert  =========================


// ========================= Start Event Booking update  =========================
function eventBookingUpdate()
{
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
        $eventName = mysqli_real_escape_string($conn, $_POST['eventName']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);
        $dateTime = mysqli_real_escape_string($conn, $_POST['dateTime']);
        $noOfServant = mysqli_real_escape_string($conn, $_POST['noOfServant']);
        $servantID = mysqli_real_escape_string($conn, $_POST['servantID']);


        // Get the current date and time
        $updated_on = date('Y-m-d');
        $updated_by = $_SESSION['username'];

        // check duplicate location
        $check_location = "SELECT * FROM `events_booking` WHERE `location` = '$location' AND `location` != '$location'";
        $check_location_res = mysqli_query($conn, $check_location);

        if (mysqli_num_rows($check_location_res) > 0) {
            $_SESSION['error_updated_events'] = "Location already exists ($location)";
            header("location: eventsDetails");
            exit();
        }

        // insert data into event_booking table
        $updateEventBooking = "UPDATE `events_booking` SET
        `servant_id` = '$servantID',
        `eventName` = '$eventName',
        `location` = '$location',
        `dateTime` = '$dateTime',
        `noOfServant` = '$noOfServant',
        `updated_on` = '$updated_on',
        `updated_by` = '$updated_by'
        WHERE `event_id` = '$event_id'";

        $updateEventBooking_res = mysqli_query($conn, $updateEventBooking);

        if ($updateEventBooking_res) {
            $_SESSION['success_updated_events'] = "($eventName) Successfully Updated.";
            header('location: eventsDetails');
            exit();
        } else {
            $_SESSION['error_updated_events'] = "($eventName) not Updated.";
            header('location: eventsDetails');
            exit();
        }
    }
}
// ========================= End Event Booking Update  =========================
