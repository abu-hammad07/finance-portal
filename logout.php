<?php
session_start();
include "includes/config.php";

// logout time in user-details table
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    $user_id = $_SESSION['UID'];

    // Execute the update query directly
    $query = "UPDATE `users_detail` SET `logout_time` = NOW() 
    WHERE `users_detail_id` = (SELECT users_detail_id FROM `users` WHERE user_id = '$user_id')";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    }
}

// Set session message
$_SESSION['msg'] = "You have been logged out.";

// Destroy the session
session_unset();
session_destroy();

// Redirect to the login page
header("location: login");
exit();
