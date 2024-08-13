<?php
include "config.php";
$new_month = date('F,Y');
$sql = "SELECT house_id, maintenance_charges FROM houses";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $house_id = $row['house_id'];
        $maintenance_peyment = $row['maintenance_charges'];
        $house_or_shop = 'house';

        // Check if a record already exists for this house and month
        $check_query = "SELECT * FROM maintenance_payments WHERE house_shop_id = $house_id AND maintenance_month = '$new_month'";
        $check_result = $conn->query($check_query);

        if ($check_result->num_rows == 0) {
            // Insert new maintenance record for each house
            $sql_maintenance = "INSERT INTO maintenance_payments (house_shop_id, house_or_shop, maintenance_month, maintenance_peyment, status) VALUES ($house_id, '$house_or_shop', '$new_month', '$maintenance_peyment', 'unpaid')";
            if ($conn->query($sql_maintenance)) {
                echo "Maintenance record for house ID $house_id inserted successfully.\n";
            } else {
                echo "Error inserting maintenance record for house ID $house_id: " . $conn->error . "\n";
            }
        } else {
            echo "Maintenance record for house ID $house_id already exists for $new_month.\n";
        }
    }
    $_SESSION['success_message_house'] = "Maintenance statuses reset for the new month";
} else {
    echo "No houses found";
}
?>