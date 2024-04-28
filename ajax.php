<?php

include_once("includes/config.php");

// ==================== fetch multi input ========================
$fetch_servant_data = '';

if (isset($_POST['type'])) {
    $type = $_POST['type'];
    switch ($type) {
        case "servantName_Data":
            $sql = "SELECT servant_id, servant_name FROM servants";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                $fetch_servant_data = '';
                while ($row = mysqli_fetch_assoc($query)) {
                    $fetch_servant_data .= "<option value='{$row['servant_id']}'>{$row['servant_name']}</option>";
                }
            } else {
                $fetch_servant_data = 'Query unsuccessful: ' . mysqli_error($conn);
            }
            break;
        case "servantEmail_Data":
        case "servantAddress_Data":
        case "servantStatus_Data":
            if (isset($_POST['id'])) {
                $stId = $_POST['id'];
                $columnName = '';
                switch ($type) {
                    case "servantEmail_Data":
                        $columnName = 'email';
                        break;
                    case "servantAddress_Data":
                        $columnName = 'address';
                        break;
                    case "servantStatus_Data":
                        $columnName = 'status';
                        break;
                }
                $query = mysqli_query($conn, "SELECT $columnName FROM servants WHERE servant_id = '$stId'");
                if ($query) {
                    $fetch_servant_data = '';
                    while ($row = mysqli_fetch_assoc($query)) {
                        $fetch_servant_data .= "<option value='{$row[$columnName]}'>{$row[$columnName]}</option>";
                    }
                } else {
                    $fetch_servant_data = 'Query unsuccessful: ' . mysqli_error($conn);
                }
            } else {
                $fetch_servant_data = 'ID not provided for batch Data';
            }
            break;
        default:
            $fetch_servant_data = 'Invalid type parameter';
            break;
    }
} else {
    $fetch_servant_data = 'Type parameter not set';
}
echo $fetch_servant_data;
