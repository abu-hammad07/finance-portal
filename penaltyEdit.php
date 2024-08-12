<?php
session_start();
include_once ("includes/config.php");
include "includes/function2.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
updatePenalty();
?>

<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Add Penalty</h4>
    <!-- End:Title -->

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_message_house'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_message_house'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_message_house']);
    }
    if (isset($_SESSION['error_message_house'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_message_house'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_message_house']);
    }
    ?>
    <!-- / Alert -->
    <?php
    if (isset($_GET['penalty_edit_id'])) {
        $edit_id = mysqli_real_escape_string($conn, $_GET['penalty_edit_id']);
        $edit_query = "SELECT * FROM penalty WHERE id = '$edit_id'";
        $edit_result = mysqli_query($conn, $edit_query);

        if (mysqli_num_rows($edit_result) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_assoc($edit_result)) {
                ?>
                <form action="" method="post" id="penalty_form">
                    <div class="card h-auto">
                        <div class="card-body">
                            <h3 class="card-header">Information</h3>
                            <hr class="my-4">
                            <div class="row g-3">
                                <input type="text" name="penalty_id" hidden class="form-control" value="<?= $row['id']; ?>">
                                <div class="col-md-6">
                                    <label class="form-label">Penalty Type</label>
                                    <input type="text" name="penalty_type" class="form-control" value="<?= $row['penalty_type']; ?>"
                                        placeholder="Enter Penalty Type" required>
                                    <span class="text-danger" id="penalty-type_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Penalty CINC</label>
                                    <input type="text" name="penalty_cnic" class="form-control" value="<?= $row['penalty_cnic']; ?>"
                                        placeholder="Penalty Charges" required>
                                    <span class="text-danger" id="Penal-Cnic_error"></span>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Penalty Charges</label>
                                    <input type="number" name="penalty_charges" class="form-control"
                                        value="<?= $row['penalty_charges']; ?>" placeholder="Penalty Charges" required>
                                    <span class="text-danger" id="Penal-charges_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Payment Type</label>
                                    <select class="form-select form-control" id="pymentType" required name="paymentType">
                                        <option value=""> Select Payment Type</option>
                                        <option value="Cash" <?php if ($row['payment_type'] == 'Cash')
                                            echo 'selected'; ?>>Cash
                                        </option>
                                        <option value="Bank" <?php if ($row['payment_type'] == 'Bank')
                                            echo 'selected'; ?>>Bank
                                        </option>
                                    </select>
                                </div>
                                <!-- Button -->
                                <div class="col-md-12">
                                    <button class="btn btn-primary" id="Update_btn" type="submit" name="update">Update Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
            }
        } else {
            echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    No Data Found.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    } else {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                No ID Found.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    ?>
</div>
<!-- End:Main Body -->
</div>

<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->