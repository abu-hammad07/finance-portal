<?php
session_start();
include_once("includes/config.php");

global $conn;

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Token exists in the database, proceed with update
    $update_query = "UPDATE users SET email_verfied_at = NOW(), status = 'Active' WHERE token = ?";
    $stmt_update = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt_update, "s", $token);

    if (mysqli_stmt_execute($stmt_update)) {
        // Account activated successfully
        session_start();
        $_SESSION['msg'] = "Account activated successfully";
        header('location: login'); // Assuming your login page is named login.php
    } else {
        // Error updating the account
        $_SESSION['msg'] = "Error: Account not updated";
        header('location: login');
    }
    // mysqli_stmt_close($stmt_select);
    mysqli_stmt_close($stmt_update);
} else {
    // Token doesn't exist in the database
    $_SESSION['msg'] = "Error: Token not found";
    header('location: login');
}
