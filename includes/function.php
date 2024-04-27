<?php
include "config.php";

// Add Houses
function addHouse(){
    if (isset($_POST['submit'])) {
        $houseNumber = $_POST['house-number'];
        $ownerName = $_POST['owner-name'];
        $ownerContact = $_POST['owner-contact'];
        $occupanceStatus = $_POST['occupance-status'];
        $tenantsName = $_POST['tenants-name'];
        $tenantContact = $_POST['tenant-contact'];
        $floor = $_POST['floor'];
        $propertyType = $_POST['property-type'];
        $propertySize = $_POST['property-size'];
        $maintenanceCharges = $_POST['maintenance-charges'];
        $notes = $_POST['notes'];
        global $conn;
        $added_on = date('d-m-y');
        $added_by = $_SESSION['UID'];

        $insertQuery = "INSERT INTO `houses`(`house_number`, `owner_name`, `owner_contact`,
         `occupancy_status`, `tenants_name`, `tenants_contact`, `property_size`, 
         `floor`, `property_type`, `maintenance_charges`, `notes`, `added_on`,
          `added_by`) VALUES ('{$houseNumber}','{$ownerName}','{$ownerContact}',
          '{$occupanceStatus}',
          '{$tenantsName}','{$tenantContact}','{$propertySize}','{$floor}',
          '{$propertyType}','{$maintenanceCharges}',
          '{$notes}','{$added_on}','{$added_by}')";

        $query = mysqli_query($conn, $insertQuery);
        if ($query) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Data Inserted Successfully!</strong>.
            <button type='button' class='btn-close'- data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Failed to add at the moment.</strong>.
            <button type='button' class='btn-close'- data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
    }

}

// Delete House Record
function deleteHouse(){
    global $conn;
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $deleteQuery = "DELETE FROM houses where house_id = ('{$delete_id}')";
        $deleteSQL = mysqli_query($conn, $deleteQuery);
        if (!$deleteSQL) {
            die("QUERY FAILED" . mysqli_error($conn));
        } else {
    
        }
    }
}
