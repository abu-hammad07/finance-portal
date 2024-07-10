<?php
session_start();
require_once ('config.php');
require_once 'phpqrcode/qrlib.php';





if (isset($_REQUEST['submitEmployee'])) {

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

    $path = '../media/qrcodeImages/';
    $qrcode = $path . time() . $employeeID . '.png';
    $qrimage = time() . $employeeID . ".png";

    // Upload image
    $employee_image = rand(111111111, 999999999) . '_' . $_FILES['employee_image']['name'];
    move_uploaded_file($_FILES['employee_image']['tmp_name'], '../media/images/' . $employee_image);


    $query = "INSERT INTO `employees`(
    `employee_id`, `employeeID`, `employee_full_name`, `employee_cnic`, `employee_qualification`, `employee_contact`, 
    `employee_email`, `employee_address`, `employee_image`, `appointment_date`, `employement_type`, `QRcode`, 
    `department`, `designation`, `salary`, `added_on`, `added_by`) 
    VALUES ('$employeeID', '$employeeID', '$full_name', '$cnic', '$qualification', '$phone_number',
    '$email', '$address', '$employee_image', '$appointment_date', '$employee_type', '$qrimage', '$department', 
    '$designation', '$employee_salary', NOW(), '$_SESSION[username]')";

    // Debug: print the query
    echo "<pre>$query</pre>";

    $result = mysqli_query($conn, $query);

    // if ($result) {
    //     $_SESSION['success_added_employee'] = "($full_name) employee has been added.";
    //     header('location: ../addEmployee');
    //     exit();
    // } else {
    //     $_SESSION['error_added_employee'] = "($full_name) employee not added.";
    //     header('location: ../addEmployee');
    //     exit();
    // }

    if ($result) {
        $qrcode = $path . $qrimage;
        QRcode::png(
            "Employee ID: " . $employeeID . ", Employee Name: " . $full_name . ", CNIC: " . $cnic .
            ", Phone Number: " . $phone_number . ", Email: " . $email . ", Appointment Date: " . $appointment_date .
            ", Employee Type: " . $employee_type . ", Department: " . $department,
            $qrcode,
            'L',
            10,
            2
        );

        $_SESSION['success_added_employee'] = "($full_name) employee has been added.";
        header('location: ../addEmployeeQRcode');

        // echo '<img src="images/' . $qrimage . '">';

        exit();
    } else {
        echo "error";
    }


}

// Generate QR code
QRcode::png(
    "Employee ID: " . $employeeID . ", Employee Name: " . $full_name . ", CNIC: " . $cnic .
    ", Phone Number: " . $phone_number . ", Email: " . $email . ", Appointment Date: " . $appointment_date .
    ", Employee Type: " . $employee_type . ", Department: " . $department,
    $qrcode,
    'L',
    10,
    2
);

// echo '<img src="images/' . $qrimage . '">';

