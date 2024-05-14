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
        $ownerCNIC = mysqli_real_escape_string($conn, $_POST['owner-cinc']);
        $occupanceStatus = mysqli_real_escape_string($conn, $_POST['occupance-status']);
        // $tenantsName = mysqli_real_escape_string($conn, $_POST['tenants-name']);
        // $tenantContact = mysqli_real_escape_string($conn, $_POST['tenant-contact']);
        $floor = mysqli_real_escape_string($conn, $_POST['floor']);
        $propertyType = mysqli_real_escape_string($conn, $_POST['property-type']);
        $propertySize = mysqli_real_escape_string($conn, $_POST['property-size']);
        $maintenanceCharges = mysqli_real_escape_string($conn, $_POST['maintenance-charges']);
        // $notes = mysqli_real_escape_string($conn, $_POST['notes']);

        $added_by = $_SESSION['username'];
        $added_on = date("Y-m-d");

        $insertQuery = "INSERT INTO `houses`(`house_number`, `owner_name`, `owner_contact`, `owner_cnic`,
         `occupancy_status`, `property_size`, `floor`, `property_type`, `maintenance_charges`,`added_on`,
          `added_by`) VALUES ('$houseNumber','$ownerName','$ownerContact', '$ownerCNIC',
          '$occupanceStatus','$propertySize','$floor',
          '$propertyType','$maintenanceCharges',
          '$added_on','$added_by')";

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
// End of Houses Deleted Data


// Users Updated Data 
function userEdit()
{
    global $conn;
    if (isset($_POST['userUpdate'])) {
        $usersDetailId = mysqli_real_escape_string($conn, $_POST['users_detail_id']);
        $userId = mysqli_real_escape_string($conn, $_POST['user_id']);
        $fullName = mysqli_real_escape_string($conn, $_POST['full_name']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $dateOfBirth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $roleId = mysqli_real_escape_string($conn, $_POST['user_type']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        // Get the current date and time
        $updated_date = date('Y-m-d');
        // Get the user's ID and name
        $updated_by = $_SESSION['username'];

        // check duplicate username
        $check_username = "SELECT * FROM `users` WHERE `username` = '$username' AND `user_id` != '$userId'";
        $check_username_res = mysqli_query($conn, $check_username);

        if (mysqli_num_rows($check_username_res) > 0) {
            $_SESSION['error_updated_user'] = "Username already exists $username";
            header("location: userDetails");
            exit();
        }

        // check duplicate email
        $check_email = "SELECT * FROM `users` WHERE `email` = '$email' AND `email` != '$email'";
        $check_email_res = mysqli_query($conn, $check_email);

        if (mysqli_num_rows($check_email_res) > 0) {
            $_SESSION['error_updated_user'] = "Email already exists $email";
            header("location: userDetails");
            exit();
        }

        // Check if an image was uploaded
        $image = '';
        if (!empty($_FILES['image']['name'])) {
            $image = mysqli_real_escape_string($conn, rand(111111111, 999999999) . '_' . $_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], 'media/images/' . $image);
        }

        // Update the user's data in the database
        $updateUser = "UPDATE `users` SET `username` = '$username', `email` = '$email', `role_id` = '$roleId', 
        `updated_date` = '$updated_date', `updated_by` = '$updated_by' 
        WHERE `user_id` = '$userId'";
        $updateUser_res = mysqli_query($conn, $updateUser);

        if ($updateUser_res) {

            // Update the user's details in the database
            $updateUserDetail = "UPDATE `users_detail` SET `full_name`= '$fullName', `phone`= '$phone', 
            `date_of_birth`= '$dateOfBirth', `gender`= '$gender', `address`= '$address'";

            if (!empty($image)) {
                $updateUserDetail .= ", `image`= '$image'";
            }

            $updateUserDetail .= ", `updated_date`= '$updated_date', `updated_by`= '$updated_by'
            WHERE `users_detail_id` = '$usersDetailId'";
            $updateUserDetail_res = mysqli_query($conn, $updateUserDetail);

            if ($updateUserDetail_res) {
                $_SESSION['success_updated_user'] = "$username updated successfully";
                header("location: userDetails");
                exit();
            } else {
                $_SESSION['error_updated_user'] = "Error updating users details";
                header("location: userDetails");
                exit();
            }
        } else {
            $_SESSION['error_updated_user'] = "Error updating user";
            header("location: userDetails");
            exit();
        }
    }
}
// End of Users Updated Data



// Users Deleted Data
function userDelete()
{
    global $conn;

    if (isset($_GET['user_delete_id'])) {
        $userId = mysqli_real_escape_string($conn, $_GET['user_delete_id']);

        // select user details
        $selectUser = "SELECT username, users_detail_id FROM `users` WHERE `user_id` = '$userId'";
        $selectUser_res = mysqli_query($conn, $selectUser);
        if (mysqli_num_rows($selectUser_res) > 0) {
            $row = mysqli_fetch_assoc($selectUser_res);
            $usersDetailId = $row['users_detail_id'];
            $username = $row['username'];
        }

        // Delete the user
        $deleteUser = "DELETE FROM `users` WHERE `user_id` = '$userId'";
        $deleteUser_res = mysqli_query($conn, $deleteUser);

        if ($deleteUser_res) {

            // Delete the user's details
            $deleteUserDetail = "DELETE FROM `users_detail` WHERE `users_detail_id` = '$usersDetailId'";
            $deleteUserDetail_res = mysqli_query($conn, $deleteUserDetail);

            if ($deleteUserDetail_res) {
                $_SESSION['success_updated_user'] = "$username deleted successfully";
                header("location: userDetails");
                exit();
            } else {
                $_SESSION['error_updated_user'] = "Error deleting users details";
                header("location: userDetails");
                exit();
            }
        } else {
            $_SESSION['error_updated_user'] = "Error deleting user";
            header("location: userDetails");
            exit();
        }
    }
}
// End of Users Deleted Data


// Update profile data
function updateProfile()
{
    global $conn;

    if (isset($_POST['updateProfile'])) {
        $usersDetailId = mysqli_real_escape_string($conn, $_POST['usersDetailId']);
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);

        // image upload
        $image = '';
        if (!empty($_FILES['image']['name'])) {
            $image = mysqli_real_escape_string($conn, rand(111111111, 999999999) . '_' . $_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], 'media/images/' . $image);
        }

        // Get the current date and time
        $updated_date = date('Y-m-d');
        // Get the user's ID and name
        $updated_by = $_SESSION['username'];

        // Update the user's details in the database
        $updateUserDetail = "UPDATE `users_detail` SET `full_name`= '$full_name', `phone`= '$phone', 
        `date_of_birth`= '$date_of_birth', `gender`= '$gender', `address`= '$address'";
        if (!empty($image)) {
            $updateUserDetail .= ", `image`= '$image'";
        }

        $updateUserDetail .= ", `updated_date`= '$updated_date', `updated_by`= '$updated_by'
        WHERE `users_detail_id` = '$usersDetailId'";
        $updateUserDetail_res = mysqli_query($conn, $updateUserDetail);

        if ($updateUserDetail_res) {
            $_SESSION['success_updated_profile'] = "Profile updated successfully";
            header("location: profile");
            exit();
        } else {
            $_SESSION['error_updated_profile'] = "Error updating profile";
            header("location: profile");
            exit();
        }
    }
}
// End of Update profile data


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


function addTenants()
{
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $house_id = mysqli_real_escape_string($conn, $_POST['house_id']);
        $tenant_name = mysqli_real_escape_string($conn, $_POST['tenant_name']);
        $tenant_contact = mysqli_real_escape_string($conn, $_POST['tenant_contact']);
        $tenant_cnic = mysqli_real_escape_string($conn, $_POST['tenant_cnic']);
    

        // image upload
        $upload_directory = 'media/images/';

        if (!file_exists($upload_directory)) {
            if (!mkdir($upload_directory, 0777, true)) {
                // die("Failed to create directory: $upload_directory");
                $_SESSION['error_message_Tenant'] = "Failed to create directory: $upload_directory";
                header('location: addTenant');
                exit();
            }
        } elseif (!is_writable($upload_directory)) {
            // die("Error: Directory '$upload_directory' is not writable.");
            $_SESSION['error_message_Tenant'] = "Error: Directory '$upload_directory' is not writable.";
            header('location: addTenant');
            exit();
        }

        // Image upload
        function upload_image($file, $upload_directory)
        {
            $filename = rand(111111111, 999999999) . '_' . $file['name'];
            $destination = $upload_directory . $filename;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return $filename;
            } else {
                // die("Failed to move uploaded file: $filename");
                $_SESSION['error_message_Tenant'] = "Failed to move uploaded file: $filename";
                header('location: addTenant');
                exit();
            }
        }

        // Call the function for each image upload
        $tenant_image = upload_image($_FILES['tenant_image'], $upload_directory);


        // added_by & added_on
        $added_by = $_SESSION['username'];
        $added_on = date("Y-m-d");

        // Insert data into tenants table
        $insertTenants = "INSERT INTO tenants (
            house_id, tenant_name, tenant_contact_no, tenant_cnic, tenant_image, added_by, added_on) VALUES
        ('$house_id', '$tenant_name', '$tenant_contact', '$tenant_cnic', '$tenant_image', '$added_by', '$added_on')";
        $insertTenants_res = mysqli_query($conn, $insertTenants);

        if ($insertTenants_res) {
            $_SESSION['success_message_Tenant'] = "($tenant_name) Successfully Added.";
            header('location: addTenant');
            exit();
        } else {
            $_SESSION['error_message_Tenant'] = "($tenant_name) not Added.";
            header('location: addTenant');
            exit();
        }
    }
}

