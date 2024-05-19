<?php
include_once("config.php");
// -----------add penalty----------
function addPenalty()
{
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $penalty_type = mysqli_real_escape_string($conn, $_POST['penalty_type']);
        $penalty_cnic = mysqli_real_escape_string($conn, $_POST['penalty_cnic']);
        $penalty_charges = mysqli_real_escape_string($conn, $_POST['penalty_charges']);

        $added_by = $_SESSION['username'];
        $added_on = date("Y-m-d");

        $insertQuery = "INSERT INTO penalty(penalty_type, penalty_cnic, penalty_charges, created_date,
          created_by) VALUES ('$penalty_type','$penalty_cnic','$penalty_charges',
          '$added_on','$added_by')";

        $query = mysqli_query($conn, $insertQuery);
        if ($query) {
            $_SESSION['success_message_house'] = "$penalty_type Added Successfully";
            header('location: addpenalty');
            exit();
        } else {
            $_SESSION['error_message_house'] = "Something went wrong. Please try again.";
            header('location: addpenalty');
            exit();
        }
    }
}
// -----------update penalty----------
function updatePenalty()
{
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $penalty_id = mysqli_real_escape_string($conn, $_POST['penalty_id']);
        $penalty_type = mysqli_real_escape_string($conn, $_POST['penalty_type']);
        $penalty_cnic = mysqli_real_escape_string($conn, $_POST['penalty_cnic']);
        $penalty_charges = mysqli_real_escape_string($conn, $_POST['penalty_charges']);

        $update_by = $_SESSION['username'];

        $insertQuery = "
        UPDATE penalty SET penalty_type = '{$penalty_type}',
         penalty_cnic = '{$penalty_cnic}',penalty_charges = '{$penalty_charges}',
         updated_date = NOW(), updated_by = '{$update_by}'
        WHERE id = '{$penalty_id}'";

        $query = mysqli_query($conn, $insertQuery);
        if ($query) {
            $_SESSION['success_updated_penalty'] = "$penalty_type updated Successfully";
            header('location: penalty');
            exit();
        } else {
            $_SESSION['success_updated_penalty'] = "Something went wrong. Please try again.";
            header('location: penalty');
            exit();
        }
    }
}
// -----------Delete penalty----------
function penaltyDelete()
{
    global $conn;
    if (isset($_GET['penalty_delete_id'])) {
        $delete_id = mysqli_real_escape_string($conn, $_GET['penalty_delete_id']);
        $deleteQuery = "DELETE FROM penalty where id = ('{$delete_id}')";
        $deleteSQL = mysqli_query($conn, $deleteQuery);
        if ($deleteSQL) {
            $_SESSION['success_updated_penalty'] = "Servant Deleted Successfully";
            header('location: penalty');
            exit();
        } else {
            $_SESSION['success_updated_penalty'] = "Servant Not Deleted";
            header('location: penalty');
            exit();
        }
    }
}

// =============maintenance================
function addMaintenance()
{
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $house_or_shop = mysqli_real_escape_string($conn, $_POST['house_or_shop']);
        $house_shop_id = mysqli_real_escape_string($conn, $_POST['house_shop_id']);
        $maintenace_month = mysqli_real_escape_string($conn, $_POST['maintenace_month']);
        $maintenace_charges = mysqli_real_escape_string($conn, $_POST['maintenace_charges']);

        $added_by = $_SESSION['username'];
        $added_on = date("Y-m-d");

        if ($house_or_shop === 'house') {
            $insertQuery = "INSERT INTO maintenance_payments (house_id, house_or_shop, maintenance_month, maintenance_peyment, added_on, added_by) 
                            VALUES ('$house_shop_id', '$house_or_shop', '$maintenace_month', '$maintenace_charges', '$added_on', '$added_by')";
        } elseif ($house_or_shop === 'shop') {
            $insertQuery = "INSERT INTO maintenance_payments (shop_id, house_or_shop, maintenance_month, maintenance_peyment, added_on, added_by) 
                            VALUES ('$house_shop_id', '$house_or_shop', '$maintenace_month', '$maintenace_charges', '$added_on', '$added_by')";
        } else {
            $_SESSION['error_message_house'] = "Invalid house or shop selection.";
            header('location: addMaintenance');
            exit();
        }

        // Debugging: Check if $insertQuery is set properly
        if (isset($insertQuery)) {
            $query = mysqli_query($conn, $insertQuery);
            if ($query) {
                $_SESSION['success_message_house'] = "$maintenace_month Added Successfully";
                header('location: addMaintenance');
                exit();
            } else {
                $_SESSION['error_message_house'] = "Something went wrong. Please try again.";
                header('location: addMaintenance');
                exit();
            }
        } else {
            $_SESSION['error_message_house'] = "Insert query not set. Please check your input.";
            header('location: addMaintenance');
            exit();
        }
    }
}

function updateMaintenance()
{
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $edit_id = mysqli_real_escape_string($conn, $_POST['edit_id']);
        $house_or_shop = mysqli_real_escape_string($conn, $_POST['house_or_shop']);
        $house_shop_id = mysqli_real_escape_string($conn, $_POST['house_shop_id']);
        $maintenance_month = mysqli_real_escape_string($conn, $_POST['maintenance_month']);
        $maintenance_charges = mysqli_real_escape_string($conn, $_POST['maintenance_charges']);

        $updated_by = $_SESSION['username'];
        $updated_on = date("Y-m-d");

        if ($house_or_shop === 'house') {
            $updateQuery = "UPDATE maintenance_payments 
                            SET house_id = '$house_shop_id', 
                                house_or_shop = '$house_or_shop', 
                                maintenance_month = '$maintenance_month', 
                                maintenance_peyment = '$maintenance_charges', 
                                updated_on = '$updated_on', 
                                updated_by = '$updated_by'
                            WHERE maintenance_id = '$edit_id'";
        } elseif ($house_or_shop === 'shop') {
            $updateQuery = "UPDATE maintenance_payments 
                            SET shop_id = '$house_shop_id', 
                                house_or_shop = '$house_or_shop', 
                                maintenance_month = '$maintenance_month', 
                                maintenance_peyment = '$maintenance_charges', 
                                updated_on = '$updated_on', 
                                updated_by = '$updated_by'
                            WHERE maintenance_id = '$edit_id'";
        } else {
            $_SESSION['error_message_house'] = "Invalid house or shop selection.";
            header('location: updateMaintenance');
            exit();
        }

        // Debugging: Check if $updateQuery is set properly
        if (isset($updateQuery)) {
            $query = mysqli_query($conn, $updateQuery);
            if ($query) {
                $_SESSION['success_message_house'] = "Maintenance record updated successfully.";
                header('location: updateMaintenance');
                exit();
            } else {
                $_SESSION['error_message_house'] = "Something went wrong. Please try again.";
                header('location: updateMaintenance');
                exit();
            }
        } else {
            $_SESSION['error_message_house'] = "Update query not set. Please check your input.";
            header('location: updateMaintenance');
            exit();
        }
    }
}


function MaintenanceDelete()
{
    global $conn;
    if (isset($_GET['Maintenance_delete_id'])) {
        $delete_id = mysqli_real_escape_string($conn, $_GET['Maintenance_delete_id']);
        $deleteQuery = "DELETE FROM Maintenance where maintenance_id = ('{$delete_id}')";
        $deleteSQL = mysqli_query($conn, $deleteQuery);
        if ($deleteSQL) {
            $_SESSION['success_updated_Maintenance'] = "Servant Deleted Successfully";
            header('location: Maintenance');
            exit();
        } else {
            $_SESSION['success_updated_Maintenance'] = "Servant Not Deleted";
            header('location: Maintenance');
            exit();
        }
    }
}
