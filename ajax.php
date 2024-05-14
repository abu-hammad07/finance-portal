<?php

include_once("includes/config.php");

// ==================== fetch multi input ========================
$fetch_servant_data = '';
$fetchHousesData = '';

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




// =================== Start damage_product_id_Data ===================
if (isset($_POST['type'])) {
    if ($_POST['type'] == "house_id_Data") {
        $sql = "SELECT house_id, house_number FROM houses";
        $query = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        $fetchHousesData = '---';
        while ($row = mysqli_fetch_assoc($query)) {
            $fetchHousesData .= "<option value='{$row['house_id']}'>{$row['house_number']}</option>";
        }
    } elseif ($_POST['type'] == "owner_name_Data") {
        if (isset($_POST['id'])) {
            $batchId = $_POST['id'];
            $query = mysqli_query($conn, "SELECT owner_name FROM houses WHERE house_id = $batchId");
            $fetchHousesData = '';
            while ($row = mysqli_fetch_assoc($query)) {
                $fetchHousesData .= "<option value='{$row['owner_name']}'>{$row['owner_name']}</option>";
            }
        } else {
            $fetchHousesData = 'ID not provided for batch Data';
        }
    } elseif ($_POST['type'] == "owner_contact_Data") {
        if (isset($_POST['id'])) {
            $batchId = $_POST['id'];
            $query = mysqli_query($conn, "SELECT owner_contact FROM houses WHERE house_id = $batchId");
            $fetchHousesData = '';
            while ($row = mysqli_fetch_assoc($query)) {
                $fetchHousesData .= "<option value='{$row['owner_contact']}'>{$row['owner_contact']}</option>";
            }
        } else {
            $fetchHousesData = 'ID not provided for batch Data';
        }
    }
} else {
    $fetchHousesData = 'Type parameter not set';
}

echo $fetchHousesData;