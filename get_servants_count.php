<?php
// Include your database connection file
include('includes/config.php');

// Query to get the count of rows in the 'servants' table
$query = "SELECT COUNT(*) as count FROM servants";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo $row['count'];
} else {
    echo "0"; // If there's an error, return 0
}
