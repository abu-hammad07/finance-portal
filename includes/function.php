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
        $floor = mysqli_real_escape_string($conn, $_POST['floor']);
        $propertyType = mysqli_real_escape_string($conn, $_POST['property-type']);
        $propertySize = mysqli_real_escape_string($conn, $_POST['property-size']);
        $maintenanceCharges = mysqli_real_escape_string($conn, $_POST['maintenance-charges']);

        $added_by = $_SESSION['username'];
        $added_on = date("Y-m-d");

        $insertQuery = "INSERT INTO houses(house_number, owner_name, owner_contact, owner_cnic,
         occupancy_status, property_size, floor, property_type, maintenance_charges,added_on,
          added_by) VALUES ('$houseNumber','$ownerName','$ownerContact', '$ownerCNIC',
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
        $ownerCNIC = mysqli_real_escape_string($conn, $_POST['owner-cinc']);
        $occupanceStatus = mysqli_real_escape_string($conn, $_POST['occupance-status']);
        $floor = mysqli_real_escape_string($conn, $_POST['floor']);
        $propertyType = mysqli_real_escape_string($conn, $_POST['property-type']);
        $propertySize = mysqli_real_escape_string($conn, $_POST['property-size']);
        $maintenanceCharges = mysqli_real_escape_string($conn, $_POST['maintenance-charges']);

        $updated_by = $_SESSION['username'];
        $updated_on = date("Y-m-d");

        $insertQuery = "
        UPDATE houses SET 
        house_number = '{$houseNumber}',
        owner_name = '{$ownerName}', 
        owner_contact = '{$ownerContact}',
        owner_cnic = '{$ownerCNIC}',
        occupancy_status = '{$occupanceStatus}',
        property_size = '{$propertySize}',
        floor = '{$floor}', 
        property_type = '{$propertyType}',
        maintenance_charges = '{$maintenanceCharges}', 
        updated_on = NOW(), 
        updated_by = '{$updated_by}'
        WHERE house_id = '{$house_id}'";

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
        $check_username = "SELECT * FROM users WHERE username = '$username' AND user_id != '$userId'";
        $check_username_res = mysqli_query($conn, $check_username);

        if (mysqli_num_rows($check_username_res) > 0) {
            $_SESSION['error_updated_user'] = "Username already exists $username";
            header("location: userDetails");
            exit();
        }

        // check duplicate email
        $check_email = "SELECT * FROM users WHERE email = '$email' AND email != '$email'";
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
        $updateUser = "UPDATE users SET username = '$username', email = '$email', role_id = '$roleId', 
        updated_date = '$updated_date', updated_by = '$updated_by' 
        WHERE user_id = '$userId'";
        $updateUser_res = mysqli_query($conn, $updateUser);

        if ($updateUser_res) {

            // Update the user's details in the database
            $updateUserDetail = "UPDATE users_detail SET full_name= '$fullName', phone= '$phone', 
            date_of_birth= '$dateOfBirth', gender= '$gender', address= '$address'";

            if (!empty($image)) {
                $updateUserDetail .= ", image= '$image'";
            }

            $updateUserDetail .= ", updated_date= '$updated_date', updated_by= '$updated_by'
            WHERE users_detail_id = '$usersDetailId'";
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
        $selectUser = "SELECT username, users_detail_id FROM users WHERE user_id = '$userId'";
        $selectUser_res = mysqli_query($conn, $selectUser);
        if (mysqli_num_rows($selectUser_res) > 0) {
            $row = mysqli_fetch_assoc($selectUser_res);
            $usersDetailId = $row['users_detail_id'];
            $username = $row['username'];
        }

        // Delete the user
        $deleteUser = "DELETE FROM users WHERE user_id = '$userId'";
        $deleteUser_res = mysqli_query($conn, $deleteUser);

        if ($deleteUser_res) {

            // Delete the user's details
            $deleteUserDetail = "DELETE FROM users_detail WHERE users_detail_id = '$usersDetailId'";
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
        $updateUserDetail = "UPDATE users_detail SET full_name= '$full_name', phone= '$phone', 
        date_of_birth= '$date_of_birth', gender= '$gender', address= '$address'";
        if (!empty($image)) {
            $updateUserDetail .= ", image= '$image'";
        }

        $updateUserDetail .= ", updated_date= '$updated_date', updated_by= '$updated_by'
        WHERE users_detail_id = '$usersDetailId'";
        $updateUserDetail_res = mysqli_query($conn, $updateUserDetail);

        if ($updateUserDetail_res) {
            $_SESSION['success_updated_profile'] = "Profile has been updated successfully";
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
        $house_id = mysqli_real_escape_string($conn, $_POST['house_id']);
        $designation = mysqli_real_escape_string($conn, $_POST['designation']);
        $servant_fees = mysqli_real_escape_string($conn, $_POST['servant_fees']);

        // select house details
        $selectHouse = "SELECT house_number FROM houses WHERE house_id = '$house_id'";
        $selectHouse_res = mysqli_query($conn, $selectHouse);
        if (mysqli_num_rows($selectHouse_res) > 0) {
            $row = mysqli_fetch_assoc($selectHouse_res);
            $house_number = $row['house_number'];
        }

        // Get the current date and time
        $added_on = date('Y-m-d');
        // Get the user's ID and name
        $added_by = $_SESSION['UID'];


        // Insert data into user_details table first
        $insert_details = "INSERT INTO servants(
            house_id, servantDesignation, servantFees, added_by, added_on) 
        VALUES (
            '$house_id', '$designation', '$servant_fees', '$added_by', '$added_on'
        )";

        $insert_udetails_res = mysqli_query($conn, $insert_details);

        if ($insert_udetails_res) {

            $_SESSION['success_message_servant'] = "($house_number) servant has been added.";
            header('location: addServant');
            exit();
        } else {
            $_SESSION['error_message_servant'] = "$house_number not added";
            header('location: addServant');
            exit();
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
        $house_id = mysqli_real_escape_string($conn, $_POST['house_id']);
        $designation = mysqli_real_escape_string($conn, $_POST['designation']);
        $servant_fees = mysqli_real_escape_string($conn, $_POST['servant_fees']);

        // select house details
        $selectHouse = "SELECT house_number FROM houses WHERE house_id = '$house_id'";
        $selectHouse_res = mysqli_query($conn, $selectHouse);
        if (mysqli_num_rows($selectHouse_res) > 0) {
            $row = mysqli_fetch_assoc($selectHouse_res);
            $house_number = $row['house_number'];
        }

        // Get the current date and time
        $updated_on = date('Y-m-d');
        $updated_by = $_SESSION['username'];



        // Update data into servants table
        $servant_update = "UPDATE servants SET
            house_id = '$house_id',
            servantDesignation = '$designation',
            servantFees = '$servant_fees',
            updated_by = '$updated_by',
            updated_on = '$updated_on'
            WHERE servant_id = '$servant_id'";

        $servant_udetails_res = mysqli_query($conn, $servant_update);

        if ($servant_udetails_res) {

            $_SESSION['success_updated_servant'] = "($house_number) has been Updated.";
            header('location: servants');
            exit();
        } else {
            $_SESSION['error_updated_servant'] = "($house_number) not updated";
            header('location: servants');
            exit();
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
        $noOfPersons = mysqli_real_escape_string($conn, $_POST['noOfPersons']);
        $customerName = mysqli_real_escape_string($conn, $_POST['customerName']);
        $customerContact = mysqli_real_escape_string($conn, $_POST['customerContact']);
        $customerCnic = mysqli_real_escape_string($conn, $_POST['customerCnic']);
        $eventType = mysqli_real_escape_string($conn, $_POST['eventType']);
        $bookingPayment = mysqli_real_escape_string($conn, $_POST['bookingPayment']);


        // Get the current date and time
        $added_on = date('Y-m-d');
        $added_by = $_SESSION['username'];

        // insert data into event_booking table
        $insertEventBooking = "INSERT INTO `events_booking`(
            `eventName`, `location`, `date`, `startTiming`, `endTiming`, `noOfPersons`, 
            `eventType`, `customerCnic`, `customerContact`, `customerName`, 
            `bookingPayment`, `added_by`, `added_on`) 
        VALUES(
            '{$eventName}', '{$location}', '{$date}', '{$startTiming}', '{$endTiming}', '{$noOfPersons}',
            '{$eventType}', '{$customerCnic}', '{$customerContact}', '{$customerName}', '{$bookingPayment}', '{$added_by}', '{$added_on}'
        )";


        $insertEventBooking_res = mysqli_query($conn, $insertEventBooking);

        if ($insertEventBooking_res) {
            $_SESSION['success_message_eventBooking'] = "($eventName) has been Added.";
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
        $noOfPersons = mysqli_real_escape_string($conn, $_POST['noOfPersons']);
        $customerName = mysqli_real_escape_string($conn, $_POST['customerName']);
        $customerContact = mysqli_real_escape_string($conn, $_POST['customerContact']);
        $customerCnic = mysqli_real_escape_string($conn, $_POST['customerCnic']);
        $eventType = mysqli_real_escape_string($conn, $_POST['eventType']);
        $bookingPayment = mysqli_real_escape_string($conn, $_POST['bookingPayment']);


        // Get the current date and time
        $updated_on = date('Y-m-d');
        $updated_by = $_SESSION['username'];

        // insert data into event_booking table
        $updateEventBooking = "UPDATE `events_booking` SET
        `eventName` = '$eventName',
        `location` = '$location',
        `date` = '$date',
        `startTiming` = '$startTiming',
        `endTiming` = '$endTiming',
        `noOfPersons` = '$noOfPersons',
        `customerName` = '$customerName',
        `customerContact` = '$customerContact',
        `customerCnic` = '$customerCnic',
        `eventType` = '$eventType',
        `bookingPayment` = '$bookingPayment',
        `updated_on` = '$updated_on',
        `updated_by` = '$updated_by'
        WHERE event_id = '$event_id'";

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

function updateTenants()
{
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tenant_id = mysqli_real_escape_string($conn, $_POST['tenant_id']);
        $house_id = mysqli_real_escape_string($conn, $_POST['house_id']);
        $tenant_name = mysqli_real_escape_string($conn, $_POST['tenant_name']);
        $tenant_contact = mysqli_real_escape_string($conn, $_POST['tenant_contact']);
        $tenant_cnic = mysqli_real_escape_string($conn, $_POST['tenant_cnic']);


        // image upload
        $tenant_image = '';
        if (!empty($_FILES['tenant_image']['name'])) {
            $tenant_image = mysqli_real_escape_string($conn, rand(111111111, 999999999) . '_' . $_FILES['tenant_image']['name']);
            move_uploaded_file($_FILES['tenant_image']['tmp_name'], 'media/images/' . $tenant_image);
        }

        // updated_by & updated_on
        $updated_by = $_SESSION['username'];
        $updated_on = date("Y-m-d");

        // update data into tenants table
        $updateTenants = "UPDATE tenants SET 
        house_id='$house_id',
        tenant_name='$tenant_name',
        tenant_contact_no='$tenant_contact',
        tenant_cnic='$tenant_cnic',
        updated_by='$updated_by',
        updated_on='$updated_on'";

        if (!empty($tenant_image)) {
            $updateTenants .= ", tenant_image='$tenant_image'";
        }

        $updateTenants .= " WHERE tenant_id = '$tenant_id'";

        $updateTenants_res = mysqli_query($conn, $updateTenants);

        if ($updateTenants_res) {
            $_SESSION['success_updated_tenant'] = "($tenant_name) tenant has been updated.";
            header('location: tenants');
            exit();
        } else {
            $_SESSION['error_updated_tenant'] = "($tenant_name) not updated.";
            header('location: tenants');
            exit();
        }
    }
}



function addShopInsert()
{
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $shop_number = mysqli_real_escape_string($conn, $_POST['shop_number']);
        $owner_name = mysqli_real_escape_string($conn, $_POST['owner_name']);
        $owner_contact = mysqli_real_escape_string($conn, $_POST['owner_contact']);
        $owner_cinc = mysqli_real_escape_string($conn, $_POST['owner_cinc']);
        $occupance_status = mysqli_real_escape_string($conn, $_POST['occupance_status']);
        $floor = mysqli_real_escape_string($conn, $_POST['floor']);
        $property_type = mysqli_real_escape_string($conn, $_POST['property_type']);
        $property_size = mysqli_real_escape_string($conn, $_POST['property_size']);
        $maintenance_charges = mysqli_real_escape_string($conn, $_POST['maintenance_charges']);

        // check unique shop number
        $checkShopNumber = "SELECT * FROM shops WHERE shop_number = '$shop_number'";
        $checkShopNumber_res = mysqli_query($conn, $checkShopNumber);
        if (mysqli_num_rows($checkShopNumber_res) > 0) {
            $_SESSION['error_added_shop'] = "Shop Number ($shop_number) Already Exists.";
            header('location: addShop');
            exit();
        }

        // added_on & added_by
        $added_by = $_SESSION['username'];
        $added_on = date("Y-m-d");

        // Insert data into shops table
        $insertShops = "INSERT INTO `shops`(
            `shop_number`, `owner_name`, `owner_contact`, `owner_cnic`, 
            `occupancy_status`, `property_size`, `floor`, `property_type`, 
            `maintenance_charges`, `added_on`, `added_by`) 
        VALUES (
            '$shop_number', '$owner_name', '$owner_contact', '$owner_cinc', 
            '$occupance_status', '$floor', '$property_type', '$property_size', 
            '$maintenance_charges', '$added_by', '$added_on')";
        
        $insertShops_res = mysqli_query($conn, $insertShops);

        if ($insertShops_res) {
            $_SESSION['success_added_shop'] = "($shop_number) shop has been added.";
            header('location: addShop');
            exit();
        } else {
            $_SESSION['error_added_shop'] = "($shop_number) not added.";
            header('location: addShop');
            exit();
        }
    }
}



function addShopupdate()
{
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $shop_id = mysqli_real_escape_string($conn, $_POST['shop_id']);
        $shop_number = mysqli_real_escape_string($conn, $_POST['shop_number']);
        $owner_name = mysqli_real_escape_string($conn, $_POST['owner_name']);
        $owner_contact = mysqli_real_escape_string($conn, $_POST['owner_contact']);
        $owner_cinc = mysqli_real_escape_string($conn, $_POST['owner_cinc']);
        $occupance_status = mysqli_real_escape_string($conn, $_POST['occupance_status']);
        $floor = mysqli_real_escape_string($conn, $_POST['floor']);
        $property_type = mysqli_real_escape_string($conn, $_POST['property_type']);
        $property_size = mysqli_real_escape_string($conn, $_POST['property_size']);
        $maintenance_charges = mysqli_real_escape_string($conn, $_POST['maintenance_charges']);

        // check unique shop number
        $checkShopNumber = "SELECT * FROM shops WHERE shop_number = '$shop_number' AND shop_id != '$shop_id'";
        $checkShopNumber_res = mysqli_query($conn, $checkShopNumber);
        if (mysqli_num_rows($checkShopNumber_res) > 0) {
            $_SESSION['error_updated_shop'] = "Shop Number ($shop_number) Already Exists.";
            header('location: shops');
            exit();
        }

        // updated_by & updated_on
        $updated_by = $_SESSION['username'];
        $updated_on = date("Y-m-d");

        // update data into shops table
        $updateShops = "UPDATE `shops` SET
            `shop_number` = '$shop_number',
            `owner_name` = '$owner_name',
            `owner_contact` = '$owner_contact',
            `owner_cnic` = '$owner_cinc',
            `occupancy_status` = '$occupance_status',
            `floor` = '$floor',
            `property_type` = '$property_type',
            `property_size` = '$property_size',
            `maintenance_charges` = '$maintenance_charges',
            `updated_by` = '$updated_by',
            `updated_on` = '$updated_on'
        WHERE `shop_id` = '$shop_id'";
        
        $updateShops_res = mysqli_query($conn, $updateShops);

        if ($updateShops_res) {
            $_SESSION['success_updated_shop'] = "($shop_number) shop has been updated.";
            header('location: shops');
            exit();
        } else {
            $_SESSION['error_updated_shop'] = "($shop_number) not updated.";
            header('location: shops');
            exit();
        }
    }
}



// function eGateInsert() {
//     global $conn;

//     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//         $house_shop_id = mysqli_real_escape_string($conn, $_POST['house_shop_id']);
//         $house_or_shop = mysqli_real_escape_string($conn, $_POST['house_or_shop']);
//         $vehicle_name = mysqli_real_escape_string($conn, $_POST['vehicle_name']);
//         $vehicle_number = mysqli_real_escape_string($conn, $_POST['vehicle_number']);
//         $vehicle_color = mysqli_real_escape_string($conn, $_POST['vehicle_color']);
//         $person_name = mysqli_real_escape_string($conn, $_POST['person_name']);
//         $cnic_number = mysqli_real_escape_string($conn, $_POST['cnic_number']);
//         $charges_type = mysqli_real_escape_string($conn, $_POST['charges_type']);
//         $charges = mysqli_real_escape_string($conn, $_POST['charges']);

//         // Validate house_shop_id against the correct table
//         // $valid_id = false;
//         // if ($house_or_shop === 'house') {
//         //     $checkQuery = "SELECT house_id FROM houses WHERE house_id = '$house_shop_id'";
//         // } elseif ($house_or_shop === 'shop') {
//         //     $checkQuery = "SELECT shop_id FROM shops WHERE shop_id = '$house_shop_id'";
//         // } else {
//         //     $_SESSION['error_insert_egate'] = "Invalid house_or_shop value.";
//         //     header('location: addeGate');
//         //     exit();
//         // }

//         // $checkResult = mysqli_query($conn, $checkQuery);
//         // if (mysqli_num_rows($checkResult) > 0) {
//         //     $valid_id = true;
//         // }

//         // if (!$valid_id) {
//         //     $_SESSION['error_insert_egate'] = "Invalid house_shop_id for the given house_or_shop.";
//         //     header('location: addeGate');
//         //     exit();
//         // }

//         // added_by & added_on
//         $added_by = $_SESSION['username'];
//         $added_on = date("Y-m-d");

//         // Insert data into e-gate table
//         $insertEGate = "INSERT INTO egate (
//             house_id, shop_id, house_or_shop, vehicle_number, vehicle_name, vehicle_color, 
//             eGateperson_name, eGate_cnic, eGate_charges_type, eGate_charges, 
//             added_on, added_by
//         ) VALUES (
//             '$house_shop_id', '$house_or_shop', '$vehicle_number', '$vehicle_name', '$vehicle_color', 
//             '$person_name', '$cnic_number', '$charges_type', '$charges', 
//             '$added_on', '$added_by'
//         )";

//         $insertEGate_res = mysqli_query($conn, $insertEGate);

//         if ($insertEGate_res) {
//             $_SESSION['success_insert_egate'] = "($vehicle_number) vehicle has been added.";
//             header('location: addeGate');
//             exit();
//         } else {
//             error_log("Error executing insert query: " . mysqli_error($conn));
//             $_SESSION['error_insert_egate'] = "($vehicle_number) not Added.";
//             header('location: addeGate');
//             exit();
//         }
//     }
// }

function eGateInsert() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $house_shop_id = mysqli_real_escape_string($conn, $_POST['house_shop_id']);
        $house_or_shop = mysqli_real_escape_string($conn, $_POST['house_or_shop']);
        $vehicle_name = mysqli_real_escape_string($conn, $_POST['vehicle_name']);
        $vehicle_number = mysqli_real_escape_string($conn, $_POST['vehicle_number']);
        $vehicle_color = mysqli_real_escape_string($conn, $_POST['vehicle_color']);
        $person_name = mysqli_real_escape_string($conn, $_POST['person_name']);
        $cnic_number = mysqli_real_escape_string($conn, $_POST['cnic_number']);
        $charges_type = mysqli_real_escape_string($conn, $_POST['charges_type']);
        $charges = mysqli_real_escape_string($conn, $_POST['charges']);

        // Validate house_shop_id against the correct table
        $valid_id = false;
        if ($house_or_shop === 'house') {
            $checkQuery = "SELECT house_id FROM houses WHERE house_id = '$house_shop_id'";
        } elseif ($house_or_shop === 'shop') {
            $checkQuery = "SELECT shop_id FROM shops WHERE shop_id = '$house_shop_id'";
        } else {
            $_SESSION['error_insert_egate'] = "Invalid house_or_shop value.";
            header('location: addeGate');
            exit();
        }

        $checkResult = mysqli_query($conn, $checkQuery);
        if (!$checkResult) {
            error_log("Error executing check query: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($checkResult) > 0) {
            $valid_id = true;
        }

        if (!$valid_id) {
            $_SESSION['error_insert_egate'] = "Invalid house_shop_id for the given house_or_shop.";
            header('location: addeGate');
            exit();
        }

        // added_by & added_on
        $added_by = $_SESSION['username'];
        $added_on = date("Y-m-d");

        // Build insert query dynamically based on house_or_shop
        if ($house_or_shop === 'house') {
            $insertEGate = "INSERT INTO egate (
                house_id, house_or_shop, vehicle_number, vehicle_name, vehicle_color, 
                eGateperson_name, eGate_cnic, eGate_charges_type, eGate_charges, 
                added_on, added_by
            ) VALUES (
                '$house_shop_id', '$house_or_shop', '$vehicle_number', '$vehicle_name', '$vehicle_color', 
                '$person_name', '$cnic_number', '$charges_type', '$charges', 
                '$added_on', '$added_by'
            )";
        } elseif ($house_or_shop === 'shop') {
            $insertEGate = "INSERT INTO egate (
                shop_id, house_or_shop, vehicle_number, vehicle_name, vehicle_color, 
                eGateperson_name, eGate_cnic, eGate_charges_type, eGate_charges, 
                added_on, added_by
            ) VALUES (
                '$house_shop_id', '$house_or_shop', '$vehicle_number', '$vehicle_name', '$vehicle_color', 
                '$person_name', '$cnic_number', '$charges_type', '$charges', 
                '$added_on', '$added_by'
            )";
        }

        $insertEGate_res = mysqli_query($conn, $insertEGate);

        if ($insertEGate_res) {
            $_SESSION['success_insert_egate'] = "($vehicle_number) vehicle has been added.";
            header('location: addeGate');
            exit();
        } else {
            error_log("Error executing insert query: " . mysqli_error($conn));
            $_SESSION['error_insert_egate'] = "($vehicle_number) not Added.";
            header('location: addeGate');
            exit();
        }
    }
}






function eGateUpdate()
{
    global $conn;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $eGate_id = mysqli_real_escape_string($conn, $_POST['eGate_id']);
        $house_id = mysqli_real_escape_string($conn, $_POST['house_id']);
        $house_or_shop = mysqli_real_escape_string($conn, $_POST['house_or_shop']);
        $vehicle_name = mysqli_real_escape_string($conn, $_POST['vehicle_name']);
        $vehicle_number = mysqli_real_escape_string($conn, $_POST['vehicle_number']);
        $vehicle_color = mysqli_real_escape_string($conn, $_POST['vehicle_color']);
        $person_name = mysqli_real_escape_string($conn, $_POST['person_name']);
        $cnic_number = mysqli_real_escape_string($conn, $_POST['cnic_number']);
        $charges_type = mysqli_real_escape_string($conn, $_POST['charges_type']);
        $charges = mysqli_real_escape_string($conn, $_POST['charges']);

        // Validate house_id against the correct table
        $valid_id = false;
        if ($house_or_shop === 'house') {
            $checkQuery = "SELECT house_id FROM houses WHERE house_id = '$house_id'";
        } elseif ($house_or_shop === 'shop') {
            $checkQuery = "SELECT shop_id FROM shops WHERE shop_id = '$house_id'";
        } else {
            $_SESSION['error_updated_eGate'] = "Invalid house_or_shop value.";
            header('location: eGate');
            exit();
        }

        $checkResult = mysqli_query($conn, $checkQuery);
        if (mysqli_num_rows($checkResult) > 0) {
            $valid_id = true;
        }

        if (!$valid_id) {
            $_SESSION['error_updated_eGate'] = "Invalid house_id or shop_id for the given house_or_shop.";
            header('location: eGate');
            exit();
        }

        // updated_by & updated_on
        $updated_by = $_SESSION['username'];
        $updated_on = date("Y-m-d");

        // Build the update query based on house_or_shop
        if ($house_or_shop === 'house') {
            $updateField = "`house_id` = '$house_id', `shop_id` = NULL";
        } elseif ($house_or_shop === 'shop') {
            $updateField = "`shop_id` = '$house_id', `house_id` = NULL";
        }

        // updated data into e-gate table
        $updatedEGate = "UPDATE `egate` SET
            $updateField,
            `vehicle_number` = '$vehicle_number',
            `vehicle_name` = '$vehicle_name',
            `vehicle_color` = '$vehicle_color',
            `eGateperson_name` = '$person_name',
            `eGate_cnic` = '$cnic_number',
            `eGate_charges_type` = '$charges_type',
            `eGate_charges` = '$charges',
            `updated_by` = '$updated_by',
            `updated_on` = '$updated_on'
            WHERE `eGate_id` = '$eGate_id'";
        
        $updatedEGate_res = mysqli_query($conn, $updatedEGate);

        if ($updatedEGate_res) {
            $_SESSION['success_updated_eGate'] = "($vehicle_number) vehicle has been updated.";
            header('location: eGate');
            exit();
        } else {
            $_SESSION['error_updated_eGate'] = "($vehicle_number) not updated.";
            header('location: eGate');
            exit();
        }
    }
}
