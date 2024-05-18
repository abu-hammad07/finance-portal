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

