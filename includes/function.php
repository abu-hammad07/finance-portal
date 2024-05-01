<?php
include "config.php";

// Add Houses
function addHouse()
{
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $houseNumber = mysqli_real_escape_string($conn, $_POST['house-number']);
        $ownerName = mysqli_real_escape_string($conn, $_POST['owner-name']);
        $ownerContact = mysqli_real_escape_string($conn, $_POST['owner-contact']);
        $occupanceStatus = mysqli_real_escape_string($conn, $_POST['occupance-status']);
        $tenantsName = mysqli_real_escape_string($conn, $_POST['tenants-name']);
        $tenantContact = mysqli_real_escape_string($conn, $_POST['tenant-contact']);
        $floor = mysqli_real_escape_string($conn, $_POST['floor']);
        $propertyType = mysqli_real_escape_string($conn, $_POST['property-type']);
        $propertySize = mysqli_real_escape_string($conn, $_POST['property-size']);
        $maintenanceCharges = mysqli_real_escape_string($conn, $_POST['maintenance-charges']);
        $notes = mysqli_real_escape_string($conn, $_POST['notes']);

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
            $_SESSION['success_message_house'] = "$houseNumber Added Successfully";
            header('location: addHouse');
            exit();
        } else {
            $_SESSION['error_message_house'] = "Something went wrong. Please try again.";
            header('location: addHouse');
            exit();
        }
    }
}

// update House
function updateHouse()
{
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $house_id = mysqli_real_escape_string($conn, $_POST['house_id']);
        $houseNumber = mysqli_real_escape_string($conn, $_POST['house-number']);
        $ownerName = mysqli_real_escape_string($conn, $_POST['owner-name']);
        $ownerContact = mysqli_real_escape_string($conn, $_POST['owner-contact']);
        $occupanceStatus = mysqli_real_escape_string($conn, $_POST['occupance-status']);
        $tenantsName = mysqli_real_escape_string($conn, $_POST['tenants-name']);
        $tenantContact = mysqli_real_escape_string($conn, $_POST['tenant-contact']);
        $floor = mysqli_real_escape_string($conn, $_POST['floor']);
        $propertyType = mysqli_real_escape_string($conn, $_POST['property-type']);
        $propertySize = mysqli_real_escape_string($conn, $_POST['property-size']);
        $maintenanceCharges = mysqli_real_escape_string($conn, $_POST['maintenance-charges']);
        $notes = mysqli_real_escape_string($conn, $_POST['notes']);

        $added_by = $_SESSION['username'];

        $insertQuery = "
        UPDATE `houses` SET `house_number` = '{$houseNumber}',
        `owner_name` = '{$ownerName}', `owner_contact` = '{$ownerContact}',
        `occupancy_status` = '{$occupanceStatus}', `tenants_name` = '{$tenantsName}',
        `tenants_contact` = '{$tenantContact}', `property_size` = '{$propertySize}',
        `floor` = '{$floor}', `property_type` = '{$propertyType}',
        `maintenance_charges` = '{$maintenanceCharges}', `notes` = '{$notes}',
        `added_on` = NOW(), `added_by` = '{$added_by}'
        WHERE `house_id` = '{$house_id}'";

        $query = mysqli_query($conn, $insertQuery);
        if ($query) {
            $_SESSION['success_updated_house'] = "$houseNumber updated Successfully";
            header('location: houses');
            exit();
        } else {
            $_SESSION['error_updated_house'] = "Something went wrong. Please try again.";
            header('location: houses');
            exit();
        }
    }
}

// Delete House Record
function deleteHouse()
{
    global $conn;
    if (isset($_GET['house_delete_id'])) {
        $delete_id = $_GET['house_delete_id'];
        $deleteQuery = "DELETE FROM houses where house_id = ('{$delete_id}')";
        $deleteSQL = mysqli_query($conn, $deleteQuery);
        if ($deleteSQL) {
            $_SESSION['success_updated_house'] = "House deleted successfully";
            header('location: houses');
            exit();
        } else {
            $_SESSION['error_updated_house'] = "House not deleted";
            header('location: houses');
            exit();
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
function deleteServants()
{
    global $conn;
    if (isset($_GET['servant_delete_id'])) {
        $delete_id = mysqli_real_escape_string($conn, $_GET['servant_delete_id']);
        $deleteQuery = "DELETE FROM servants where servant_id = ('{$delete_id}')";
        $deleteSQL = mysqli_query($conn, $deleteQuery);
        if ($deleteSQL) {
            $_SESSION['success_updated_servant'] = "Servant Deleted Successfully";
            header('location: servants');
            exit();
        } else {
            $_SESSION['error_updated_servant'] = "Servant Not Deleted";
            header('location: servants');
            exit();
        }
    }
}


// ========================= Start Event Booking Insert  =========================
function eventBookingInsert()
{
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $eventName = mysqli_real_escape_string($conn, $_POST['eventName']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $startTiming = mysqli_real_escape_string($conn, $_POST['startTiming']);
        $endTiming = mysqli_real_escape_string($conn, $_POST['endTiming']);
        $noOfServant = mysqli_real_escape_string($conn, $_POST['noOfServant']);
        $bookingName = mysqli_real_escape_string($conn, $_POST['bookingName']);
        $bookingEmail = mysqli_real_escape_string($conn, $_POST['bookingEmail']);
        $bookingContact = mysqli_real_escape_string($conn, $_POST['bookingContact']);
        $bookingPayment = mysqli_real_escape_string($conn, $_POST['bookingPayment']);


        // Get the current date and time
        $added_on = date('Y-m-d');
        $added_by = $_SESSION['username'];

        // check if no of servant is greater than total servatant count in database
        $check_noOfServant = "SELECT * FROM `servants`";
        $check_noOfServant_res = mysqli_query($conn, $check_noOfServant);
        $total_servant = mysqli_num_rows($check_noOfServant_res);
        if ($noOfServant > $total_servant) {
            $_SESSION['error_message_eventBooking'] = "No. of Servant ($noOfServant) is greater than total Servant ($total_servant)";
            header("location: eventBooking");
            exit();
        }

        // check duplicate date and timing overlap
        $check_overlap = "SELECT * FROM `events_booking`
            (('{$startTiming}' BETWEEN `startTiming` AND `endTiming`) OR 
            ('{$endTiming}' BETWEEN `startTiming` AND `endTiming`) OR 
            (`startTiming` BETWEEN '{$startTiming}' AND '{$endTiming}') OR 
            (`endTiming` BETWEEN '{$startTiming}' AND '{$endTiming}'))";
        $check_overlap_res = mysqli_query($conn, $check_overlap);
        if (mysqli_num_rows($check_overlap_res) > 0) {
            $_SESSION['error_message_eventBooking'] = "Time overlap with existing event for date: $date";
            header("location: eventBooking");
            exit();
        }



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
            `eventName`, `location`, `date`,`startTiming`,`endTiming`, `noOfServant`, `bookingName`, `bookingEmail`,
            `bookingContact`, `bookingPayment`, `added_on`, `added_by`) 
        VALUES ('$eventName', '$location', '$date','$startTiming','$endTiming', '$noOfServant', '$bookingName',
            '$bookingEmail', '$bookingContact', '$bookingPayment', '$added_on', '$added_by')";


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
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $startTiming = mysqli_real_escape_string($conn, $_POST['startTiming']);
        $endTiming = mysqli_real_escape_string($conn, $_POST['endTiming']);
        $noOfServant = mysqli_real_escape_string($conn, $_POST['noOfServant']);
        $bookingName = mysqli_real_escape_string($conn, $_POST['bookingName']);
        $bookingEmail = mysqli_real_escape_string($conn, $_POST['bookingEmail']);
        $bookingContact = mysqli_real_escape_string($conn, $_POST['bookingContact']);
        $bookingPayment = mysqli_real_escape_string($conn, $_POST['bookingPayment']);


        // Get the current date and time
        $updated_on = date('Y-m-d');
        $updated_by = $_SESSION['username'];

        // check if no of servant is greater than total servatant count in database
        $check_noOfServant = "SELECT * FROM `servants`";
        $check_noOfServant_res = mysqli_query($conn, $check_noOfServant);
        $total_servant = mysqli_num_rows($check_noOfServant_res);
        if ($noOfServant > $total_servant) {
            $_SESSION['error_updated_events'] = "No. of Servant ($noOfServant) is greater than total Servant ($total_servant)";
            header("location: eventsDetails");
            exit();
        }

        // check duplicate date and timing overlap
        $check_overlap = "SELECT * FROM `events_booking` WHERE
            (('{$startTiming}' BETWEEN `startTiming` AND `endTiming`) OR 
            ('{$endTiming}' BETWEEN `startTiming` AND `endTiming`) OR 
            (`startTiming` BETWEEN '{$startTiming}' AND '{$endTiming}') OR 
            (`endTiming` BETWEEN '{$startTiming}' AND '{$endTiming}')) AND `event_id` != '$event_id'";
        $check_overlap_res = mysqli_query($conn, $check_overlap);
        if (mysqli_num_rows($check_overlap_res) > 0) {
            $_SESSION['error_updated_events'] = "Time overlap with existing event for date: $date and time: $startTiming - $endTiming";
            header("location: eventsDetails");
            exit();
        }

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
        `eventName` = '$eventName',
        `location` = '$location',
        `date` = '$date',
        `startTiming` = '$startTiming',
        `endTiming` = '$endTiming',
        `noOfServant` = '$noOfServant',
        `bookingName` = '$bookingName',
        `bookingEmail` = '$bookingEmail',
        `bookingContact` = '$bookingContact',
        `bookingPayment` = '$bookingPayment',
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

function deleteBookingEvents()
{
    global $conn;
    if (isset($_GET['booking_delete_id'])) {
        $delete_id = mysqli_real_escape_string($conn, $_GET['booking_delete_id']);
        $deleteQuery = "DELETE FROM events_booking where event_id = ('{$delete_id}')";
        $deleteSQL = mysqli_query($conn, $deleteQuery);
        if ($deleteSQL) {
            $_SESSION['success_updated_events'] = "Booking Deleted Successfully";
            header('location: eventsDetails');
            exit();
        } else {
            $_SESSION['error_updated_events'] = "Booking Not Deleted";
            header('location: eventsDetails');
            exit();
        }
    }
}
