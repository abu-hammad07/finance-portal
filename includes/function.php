<?php
include "config.php";


// Total Houses
function totalHouses()
{
    global $conn;
    $sql = "SELECT * FROM houses";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $_SESSION['index_error'] = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    $totalCounts = mysqli_num_rows($result);
    return $totalCounts;
}


// Total Houses
function totalShops()
{
    global $conn;
    $sql = "SELECT * FROM shops";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $_SESSION['index_error'] = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    $totalCounts = mysqli_num_rows($result);
    return $totalCounts;
}


// Total Houses
function totalUsers()
{
    global $conn;
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $_SESSION['index_error'] = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    $totalCounts = mysqli_num_rows($result);
    return $totalCounts;
}

// Total Houses
function totalEmployees()
{
    global $conn;
    $sql = "SELECT * FROM employees";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $_SESSION['index_error'] = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    $totalCounts = mysqli_num_rows($result);
    return $totalCounts;
}

// Function to get total income count from income table
function get_total_combined_income()
{
    global $conn;

    // Get the current month and year
    $current_month = date('m');
    $current_year = date('Y');

    // Set the start and end date of the current month
    $start_date = "$current_year-$current_month-01";
    $end_date = date('Y-m-t', strtotime($start_date)); // Get the last day of the current month

    // Define the queries to get total income from each table
    $queries = [
        "SELECT SUM(maintenance_charges) AS total_income FROM `houses` WHERE added_on BETWEEN '$start_date' AND '$end_date'",
        "SELECT SUM(maintenance_charges) AS total_income FROM `shops` WHERE added_on BETWEEN '$start_date' AND '$end_date'",
        "SELECT SUM(eGate_charges) AS total_income FROM `egate` WHERE added_on BETWEEN '$start_date' AND '$end_date'",
        "SELECT SUM(servantFees) AS total_income FROM `servants` WHERE added_on BETWEEN '$start_date' AND '$end_date'",
        "SELECT SUM(bookingPayment) AS total_income FROM `events_booking` WHERE added_on BETWEEN '$start_date' AND '$end_date'",
        "SELECT SUM(maintenance_peyment) AS total_income FROM `maintenance_payments` WHERE added_on BETWEEN '$start_date' AND '$end_date'",
        "SELECT SUM(penalty_charges) AS total_income FROM `penalty` WHERE created_by BETWEEN '$start_date' AND '$end_date'"
    ];

    $total_combined_income = 0;

    // Execute each query and accumulate the total income
    foreach ($queries as $query) {
        $result = mysqli_query($conn, $query);
        if (!$result) {
            return "Error: " . mysqli_error($conn);
        }
        $row = mysqli_fetch_assoc($result);
        $total_combined_income += $row['total_income'];
    }

    // Format the combined total income amount with commas
    return number_format($total_combined_income);
}

// Function to get total expences count from expences table
function get_total_combined_expences()
{
    global $conn;

    // Get the current month and year
    $current_month = date('m');
    $current_year = date('Y');

    // Set the start and end date of the current month
    $start_date = "$current_year-$current_month-01";
    $end_date = date('Y-m-t', strtotime($start_date)); // Get the last day of the current month

    // Define the queries to get total expences from each table
    $queries = [
        "SELECT SUM(utility_amount) AS total_expences FROM `utility_charges` WHERE added_on BETWEEN '$start_date' AND '$end_date'",
        "SELECT SUM(society_maint_amount) AS total_expences FROM `society_maintenance` WHERE added_on BETWEEN '$start_date' AND '$end_date'",
    ];

    $total_combined_expences = 0;

    // Execute each query and accumulate the total expences
    foreach ($queries as $query) {
        $result = mysqli_query($conn, $query);
        if (!$result) {
            return "Error: " . mysqli_error($conn);
        }
        $row = mysqli_fetch_assoc($result);
        $total_combined_expences += $row['total_expences'];
    }

    // Format the combined total expences amount with commas
    return number_format($total_combined_expences);
}









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
        $house_shop_id = mysqli_real_escape_string($conn, $_POST['house_shop_id']);
        $house_or_shop = mysqli_real_escape_string($conn, $_POST['house_or_shop']);
        $tenant_name = mysqli_real_escape_string($conn, $_POST['tenant_name']);
        $tenant_contact = mysqli_real_escape_string($conn, $_POST['tenant_contact']);
        $tenant_cnic = mysqli_real_escape_string($conn, $_POST['tenant_cnic']);


        // Validate house_shop_id against the correct table
        $valid_id = false;
        if ($house_or_shop === 'house') {
            $checkQuery = "SELECT house_id FROM houses WHERE house_id = '$house_shop_id'";
        } elseif ($house_or_shop === 'shop') {
            $checkQuery = "SELECT shop_id FROM shops WHERE shop_id = '$house_shop_id'";
        } else {
            $_SESSION['error_message_Tenant'] = "Invalid house_or_shop value.";
            header('location: addTenant');
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
            $_SESSION['error_message_Tenant'] = "Invalid house_shop_id for the given house_or_shop.";
            header('location: addTenant');
            exit();
        }


        // image upload
        $tenant_image = rand(111111111, 999999999) . '_' . $_FILES['tenant_image']['name'];
        move_uploaded_file($_FILES['tenant_image']['tmp_name'], 'media/images/' . $tenant_image);


        // added_by & added_on
        $added_by = $_SESSION['username'];
        $added_on = date("Y-m-d");

        // Insert data into tenants table
        // $insertTenants = "INSERT INTO tenants (
        //     house_id, house_or_shop, tenant_name, tenant_contact_no, tenant_cnic, tenant_image, added_by, added_on
        //     ) VALUES(
        //         '$house_shop_id', '$house_or_shop', '$tenant_name', '$tenant_contact', '$tenant_cnic', '$tenant_image', '$added_by', '$added_on'
        //         )";

        // Build insert query dynamically based on house_or_shop
        if ($house_or_shop === 'house') {
            $insertTenants = "INSERT INTO tenants (
                house_id, house_or_shop, tenant_name, tenant_contact_no, tenant_cnic, tenant_image, added_by, added_on
            ) VALUES (
                '$house_shop_id', '$house_or_shop', '$tenant_name', '$tenant_contact', '$tenant_cnic', '$tenant_image', 
                '$added_by', '$added_on'
            )";
        } elseif ($house_or_shop === 'shop') {
            $insertTenants = "INSERT INTO tenants (
                shop_id, house_or_shop, tenant_name, tenant_contact_no, tenant_cnic, tenant_image, added_by, added_on
            ) VALUES (
                '$house_shop_id', '$house_or_shop', '$tenant_name', '$tenant_contact', '$tenant_cnic', '$tenant_image', 
                '$added_by', '$added_on'
            )";
        }


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
            `property_size`, `floor`, `property_type`, 
            `maintenance_charges`, `added_on`, `added_by`) 
        VALUES (
            '$shop_number', '$owner_name', '$owner_contact', '$owner_cinc', 
            '$floor', '$property_type', '$property_size', 
            '$maintenance_charges', '$added_on', '$added_by')";

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

function eGateInsert()
{
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
        if ($house_or_shop === 'House') {
            $insertEGate = "INSERT INTO egate (
                house_id, house_or_shop, vehicle_number, vehicle_name, vehicle_color, 
                eGateperson_name, eGate_cnic, eGate_charges_type, eGate_charges, 
                added_on, added_by
            ) VALUES (
                '$house_shop_id', '$house_or_shop', '$vehicle_number', '$vehicle_name', '$vehicle_color', 
                '$person_name', '$cnic_number', '$charges_type', '$charges', 
                '$added_on', '$added_by'
            )";
        } elseif ($house_or_shop === 'Shop') {
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



// ========== addEmployee ==========
function InsertEmployees()
{
    global $conn;
    if (isset($_POST['submitEmployee'])) {

        $employeeID = mysqli_real_escape_string($conn, $_POST['employeeID']);
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $cnic = mysqli_real_escape_string($conn, $_POST['cnic']);
        $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
        $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $appointment_date = mysqli_real_escape_string($conn, $_POST['appointment_date']);
        $employee_type = mysqli_real_escape_string($conn, $_POST['employee_type']);
        $department = mysqli_real_escape_string($conn, $_POST['department']);
        $designation = mysqli_real_escape_string($conn, $_POST['designation']);
        $employee_salary = mysqli_real_escape_string($conn, $_POST['employee_salary']);

        // added_by & added_on
        $added_by = $_SESSION['username'];
        $added_on = date("Y-m-d");

        // unique cnic
        $cnic_check = "SELECT * FROM `employees` WHERE `employee_cnic` = '$cnic'";
        $cnic_check_result = mysqli_query($conn, $cnic_check);
        if (mysqli_num_rows($cnic_check_result) > 0) {
            $_SESSION['error_added_employee'] = "($cnic) cnic already exists.";
            header('location: addEmployee');
            exit();
        } else {

            // unique email
            $email_check = "SELECT * FROM `employees` WHERE `employee_email` = '$email'";
            $email_check_result = mysqli_query($conn, $email_check);
            if (mysqli_num_rows($email_check_result) > 0) {
                $_SESSION['error_added_employee'] = "($email) email already exists.";
                header('location: addEmployee');
                exit();
            } else {


                // unique phone number
                $phone_check = "SELECT * FROM `employees` WHERE `employee_contact` = '$phone_number'";
                $phone_check_result = mysqli_query($conn, $phone_check);
                if (mysqli_num_rows($phone_check_result) > 0) {
                    $_SESSION['error_added_employee'] = "($phone_number) phone number already exists.";
                    header('location: addEmployee');
                    exit();
                } else {

                    // Upload image
                    $employee_image = rand(111111111, 999999999) . '_' . $_FILES['employee_image']['name'];
                    move_uploaded_file($_FILES['employee_image']['tmp_name'], 'media/images/' . $employee_image);

                    // insert data into employee table
                    $insert_query = "INSERT INTO `employees`(
                        `employeeID`,`employee_full_name`, `employee_cnic`, `employee_qualification`, `employee_contact`, 
                        `employee_email`, `employee_address`, `employee_image`, `appointment_date`, 
                        `employement_type`, `department`, `designation`, `salary`, `added_on`, `added_by`) 
                    VALUES (
                        '$employeeID', '$full_name', '$cnic', '$qualification', '$phone_number', 
                        '$email', '$address', '$employee_image', '$appointment_date', 
                        '$employee_type', '$department', '$designation', '$employee_salary', 
                        '$added_on', '$added_by'
                    )";

                    $insert_query_res = mysqli_query($conn, $insert_query);

                    if ($insert_query_res) {
                        $_SESSION['success_added_employee'] = "($full_name) employee has been added.";
                        header('location: addEmployee');
                        exit();
                    } else {
                        $_SESSION['error_added_employee'] = "($full_name) employee not added.";
                        header('location: addEmployee');
                        exit();
                    }
                }
            }
        }
    }
}


// ========== addEmployee ==========
function updateEmployees()
{
    global $conn;
    if (isset($_POST['employeeUpdate'])) {

        $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
        $employeeID = mysqli_real_escape_string($conn, $_POST['employeeID']);
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $cnic = mysqli_real_escape_string($conn, $_POST['cnic']);
        $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
        $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $appointment_date = mysqli_real_escape_string($conn, $_POST['appointment_date']);
        $employee_type = mysqli_real_escape_string($conn, $_POST['employee_type']);
        $department = mysqli_real_escape_string($conn, $_POST['department']);
        $designation = mysqli_real_escape_string($conn, $_POST['designation']);
        $employee_salary = mysqli_real_escape_string($conn, $_POST['employee_salary']);

        // updated_by & updated_on
        $updated_by = $_SESSION['username'];
        $updated_on = date("Y-m-d");

        // unique cnic
        $cnic_check = "SELECT * FROM `employees` WHERE `employee_cnic` = '$cnic' AND `employee_id` != '$employee_id'";
        $cnic_check_result = mysqli_query($conn, $cnic_check);
        if (mysqli_num_rows($cnic_check_result) > 0) {
            $_SESSION['error_updated_employee'] = "($cnic) cnic already exists.";
            header('location: employee');
            exit();
        } else {

            // unique email
            $email_check = "SELECT * FROM `employees` WHERE `employee_email` = '$email' AND `employee_id` != '$employee_id'";
            $email_check_result = mysqli_query($conn, $email_check);
            if (mysqli_num_rows($email_check_result) > 0) {
                $_SESSION['error_updated_employee'] = "($email) email already exists.";
                header('location: employee');
                exit();
            } else {


                // unique phone number
                $phone_check = "SELECT * FROM `employees` WHERE `employee_contact` = '$phone_number' AND `employee_id` != '$employee_id'";
                $phone_check_result = mysqli_query($conn, $phone_check);
                if (mysqli_num_rows($phone_check_result) > 0) {
                    $_SESSION['error_updated_employee'] = "($phone_number) phone number already exists.";
                    header('location: employee');
                    exit();
                } else {

                    // Upload image
                    $employee_image = '';
                    $employee_image = rand(111111111, 999999999) . '_' . $_FILES['employee_image']['name'];
                    move_uploaded_file($_FILES['employee_image']['tmp_name'], 'media/images/' . $employee_image);

                    // update data into employee table
                    $update_query = "UPDATE `employees` SET 
                    `employeeID`='$employeeID',
                    `employee_full_name`='$full_name',
                    `employee_cnic`='$cnic',
                    `employee_qualification`='$qualification',
                    `employee_contact`='$phone_number',
                    `employee_email`='$email',
                    `employee_address`='$address',
                    `appointment_date`='$appointment_date',
                    `employement_type`='$employee_type',
                    `department`='$department',
                    `designation`='$designation',
                    `salary`='$employee_salary',
                    `updated_on`='$updated_on',
                    `updated_by`='$updated_by' 
                    WHERE `employee_id`='$employee_id'
                    ";

                    $update_query_res = mysqli_query($conn, $update_query);

                    if ($update_query_res) {
                        $_SESSION['success_updated_employee'] = "($full_name) employee has been Updated.";
                        header('location: employee');
                        exit();
                    } else {
                        $_SESSION['error_updated_employee'] = "($full_name) employee not Updated.";
                        header('location: employee');
                        exit();
                    }
                }
            }
        }
    }
}


// ========== deleteEmployee ===========
function deleteEmployeeID()
{
    global $conn;
    if (isset($_GET['employee_delete_id'])) {
        $employee_id = mysqli_real_escape_string($conn, $_GET['employee_delete_id']);
        $delete_query = "DELETE FROM `employees` WHERE `employee_id` = '$employee_id'";
        $delete_query_res = mysqli_query($conn, $delete_query);
        if ($delete_query_res) {
            $_SESSION['success_updated_employee'] = "Employee has been deleted.";
            header('location: employee');
            exit();
        } else {
            $_SESSION['error_updated_employee'] = "Employee not deleted.";
            header('location: employee');
            exit();
        }
    }
}





// ========== addUtilityCharges ===========
function insertUtilityCharges()
{
    global $conn;

    if (isset($_POST['utility_submit'])) {
        $utility_type = mysqli_real_escape_string($conn, $_POST['utility_type']);
        $utility_amount = mysqli_real_escape_string($conn, $_POST['utility_amount']);
        $utility_billing_month = mysqli_real_escape_string($conn, $_POST['utility_billing_month']);
        $utility_location = mysqli_real_escape_string($conn, $_POST['utility_location']);

        // added_on & added_by
        $added_by = $_SESSION['username'];
        $added_on = date("Y-m-d");

        // Insert data into utility_charges table
        $insert_query = "INSERT INTO `utility_charges` SET
        `utility_type` = '$utility_type',
        `utility_amount` = '$utility_amount',
        `utility_billing_month` = '$utility_billing_month',
        `utility_location` = '$utility_location',
        `added_by` = '$added_by',
        `added_on` = '$added_on'";

        $insert_query_res = mysqli_query($conn, $insert_query);

        if ($insert_query_res) {
            $_SESSION['success_message_Utility'] = "($utility_type) Utility Charges had been Added.";
            header('location: addUtilityCharges');
            exit();
        } else {
            $_SESSION['error_message_Utility'] = "($utility_type) Utility Charges not Added.";
            header('location: addUtilityCharges');
            exit();
        }
    }
}


// ========== addUtilityCharges ===========
function updatedUtilityCharges()
{
    global $conn;

    if (isset($_POST['update_utility'])) {
        $utility_id = mysqli_real_escape_string($conn, $_POST['utility_id']);
        $utility_type = mysqli_real_escape_string($conn, $_POST['utility_type']);
        $utility_amount = mysqli_real_escape_string($conn, $_POST['utility_amount']);
        $utility_billing_month = mysqli_real_escape_string($conn, $_POST['utility_billing_month']);
        $utility_location = mysqli_real_escape_string($conn, $_POST['utility_location']);

        // updated_on & updated_by
        $updated_by = $_SESSION['username'];
        $updated_on = date("Y-m-d");

        // updated data into utility_charges table
        $updated_query = "UPDATE `utility_charges` SET 
        `utility_type`='$utility_type',
        `utility_amount`='$utility_amount',
        `utility_billing_month`='$utility_billing_month',
        `utility_location`='$utility_location',
        `updated_by`='$updated_by',
        `updated_on`='$updated_on' 
        WHERE `utility_id`='$utility_id'";

        $updated_query_res = mysqli_query($conn, $updated_query);

        if ($updated_query_res) {
            $_SESSION['success_updated_Utility_charges'] = "($utility_type) Utility Charges had been updated.";
            header('location: utilityCharges');
            exit();
        } else {
            $_SESSION['error_updated_Utility_charges'] = "($utility_type) Utility Charges not updated.";
            header('location: utilityCharges');
            exit();
        }
    }
}

// ========== deleteUtilityCharges ===========
function deleteUtilityChargesID()
{
    global $conn;
    if (isset($_GET['utility_delete_id'])) {
        $utility_id = mysqli_real_escape_string($conn, $_GET['utility_delete_id']);
        $delete_query = "DELETE FROM `utility_charges` WHERE `utility_id` = '$utility_id'";
        $delete_query_res = mysqli_query($conn, $delete_query);
        if ($delete_query_res) {
            $_SESSION['success_updated_Utility_charges'] = "Utility Charges has been deleted.";
            header('location: utilityCharges');
            exit();
        } else {
            $_SESSION['error_updated_Utility_charges'] = "Utility Charges not deleted.";
            header('location: utilityCharges');
            exit();
        }
    }
}


// ================= insertSocietyMaintenance =================
function insertSocietyMaintenance()
{
    global $conn;
    if (isset($_POST['societyMaintenance_submit'])) {
        $society_maint_type = mysqli_real_escape_string($conn, $_POST['society_maint_type']);
        $society_maint_amount = mysqli_real_escape_string($conn, $_POST['society_maint_amount']);
        $society_maint_dueDate = mysqli_real_escape_string($conn, $_POST['society_maint_dueDate']);
        $society_maint_paymentDate = mysqli_real_escape_string($conn, $_POST['society_maint_paymentDate']);
        $society_maint_comments = mysqli_real_escape_string($conn, $_POST['society_maint_comments']);

        // added_on & added_by
        $added_by = $_SESSION['username'];
        $added_on = date("Y-m-d");

        // Insert data into society_maintenance table
        $insert_query = "INSERT INTO `society_maintenance` SET
        `society_maint_type` = '$society_maint_type',
        `society_maint_amount` = '$society_maint_amount',
        `society_maint_dueDate` = '$society_maint_dueDate',
        `society_maint_paymentDate` = '$society_maint_paymentDate',
        `society_maint_comments` = '$society_maint_comments',
        `added_by` = '$added_by',
        `added_on` = '$added_on'";

        $insert_query_res = mysqli_query($conn, $insert_query);

        if ($insert_query_res) {
            $_SESSION['success_message_societyMaint'] = "($society_maint_type) Society Maintenance Added.";
            header('location: addSocietyMaintenance');
            exit();
        } else {
            $_SESSION['error_message_societyMaint'] = "($society_maint_type) Society Maintenance not Added.";
            header('location: addSocietyMaintenance');
            exit();
        }
    }
}

// ================= updateSocietyMaintenance =================
function updateSocietyMaintenance()
{
    global $conn;
    if (isset($_POST['societyMaintenance_update'])) {
        $society_maint_id = mysqli_real_escape_string($conn, $_POST['society_maint_id']);
        $society_maint_type = mysqli_real_escape_string($conn, $_POST['society_maint_type']);
        $society_maint_amount = mysqli_real_escape_string($conn, $_POST['society_maint_amount']);
        $society_maint_dueDate = mysqli_real_escape_string($conn, $_POST['society_maint_dueDate']);
        $society_maint_paymentDate = mysqli_real_escape_string($conn, $_POST['society_maint_paymentDate']);
        $society_maint_comments = mysqli_real_escape_string($conn, $_POST['society_maint_comments']);

        // updated_on & updated_by
        $updated_by = $_SESSION['username'];
        $updated_on = date("Y-m-d");

        // updated data into society_maintenance table
        $updated_query = "UPDATE `society_maintenance` SET
        `society_maint_type` = '$society_maint_type',
        `society_maint_amount` = '$society_maint_amount',
        `society_maint_dueDate` = '$society_maint_dueDate',
        `society_maint_paymentDate` = '$society_maint_paymentDate',
        `society_maint_comments` = '$society_maint_comments',
        `updated_by` = '$updated_by',
        `updated_on` = '$updated_on' 
        WHERE `society_maint_id` = '$society_maint_id'";

        $updated_query_res = mysqli_query($conn, $updated_query);

        if ($updated_query_res) {
            $_SESSION['success_updated_societyMaint'] = "($society_maint_type) Society Maintenance Added Successfully.";
            header('location: societyMaintenance');
            exit();
        } else {
            $_SESSION['error_updated_societyMaint'] = "($society_maint_type) Society Maintenance not Added.";
            header('location: societyMaintenance');
            exit();
        }
    }
}



// ================= deleteSocietyMaintenance =================
function deleteSocietyMaintenance()
{
    global $conn;
    if (isset($_GET['societyMaint_delete_id'])) {
        $delete_id = mysqli_real_escape_string($conn, $_GET['societyMaint_delete_id']);

        $delete_query = "DELETE FROM `society_maintenance` WHERE `society_maint_id` = '$delete_id'";

        $delete_query_res = mysqli_query($conn, $delete_query);

        if ($delete_query_res) {
            $_SESSION['success_updated_societyMaint'] = "Society Maintenance Deleted Successfully.";
            header('location: societyMaintenance');
            exit();
        } else {
            $_SESSION['error_updated_societyMaint'] = "Society Maintenance not Deleted.";
            header('location: societyMaintenance');
            exit();
        }
    }
}
