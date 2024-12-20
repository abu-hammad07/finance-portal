<?php
session_start();
include_once ("includes/config.php");
include "includes/function2.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
updatePayroll();
?>

<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Payroll Update</h4>
    <!-- End:Title -->
    <!-- Alert -->
    <?php
    if (isset($_SESSION['alert_script'])) {
        echo $_SESSION['alert_script'];
        unset($_SESSION['alert_script']);
    }
    if (isset($_SESSION['success_message'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_message'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_message']);
    }
    if (isset($_SESSION['error_message'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_message'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_message']);
    }
    ?>

    <div class="card h-auto">
        <div class="card-body">
            <h3 class="card-header">Information</h3>
            <hr class="my-4">
            <form id="attendanceForm" method="post">
                <div class="row g-3">
                    <?php
                    if (isset($_GET['payroll_edit_id'])) {
                        $edit_id = mysqli_real_escape_string($conn, $_GET['payroll_edit_id']);
                        $edit_query = "SELECT * FROM payroll WHERE payroll_id = '$edit_id'";
                        $edit_result = mysqli_query($conn, $edit_query);

                        if (mysqli_num_rows($edit_result) > 0) {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($edit_result)) {
                                ?>
                                <input type="text" hidden name="payroll_id" class="form-control" readonly
                                    value="<?= $row['payroll_id']; ?>">

                                <div class="col-md-6">
                                    <label class="form-label">Employee ID</label>
                                    <select name="employee_id" id="Employee_ID" class="form-select form-control Employee_ID"
                                        required>
                                        <option value="<?= $row['employee_id']; ?>"><?= $row['employee_id']; ?></option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Employee Name</label>
                                    <select name="Employee_Name" id="Employee_Name" class="form-select form-control Employee_Name">
                                        <?php
                                        $payroll_names = explode(',', $row['employee_id']);
                                        foreach ($payroll_names as $payroll_name) {
                                            $seql_dep = mysqli_query($conn, "SELECT * FROM `employees` WHERE `employee_id` ='$payroll_name'");
                                            $dep = mysqli_fetch_object($seql_dep);
                                            if ($dep) {

                                            }
                                        }
                                        ?>
                                        <option value=""><?= $dep->employee_full_name; ?></option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Employee Salary</label>
                                    <select name="employee_salary" id="Employee_Salary"
                                        class="form-select form-control Employee_Salary" required>
                                        <option value="<?= $row['employee_salary']; ?>"><?= $row['employee_salary']; ?></option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Month-Year</label>
                                    <input type="month" id="monthYear" name="month_year" class="form-control"
                                        value="<?= $row['month_year']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Total Working Days</label>
                                    <input type="number" id="totalWorkingDays" name="total_working_days" class="form-control"
                                        value="30" " readonly>
                                                    </div>
                                                    <div class=" col-md-6">
                                    <label class="form-label">Days Absent</label>
                                    <input type="text" id="daysAbsent" name="days_absent" class="form-control" value="0" min="0"
                                        value="<?= $row['days_absent']; ?>" required oninput="calculateDaysPresent()">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Days Leave</label>
                                    <input type="text" id="daysLeave" name="days_leave" class="form-control" value="0" min="0"
                                        value="<?= $row['days_leave']; ?>" required oninput="calculateDaysPresent()">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Days Present</label>
                                    <input type="number" id="daysPresent" name="days_present" class="form-control"
                                        placeholder="Total Present" value="<?= $row['days_present']; ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Total Salary</label>
                                    <input type="number" id="totalSalary" name="total_salary" class="form-control"
                                        placeholder="Total Salary" value="<?= $row['total_salary']; ?>" readonly>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-primary" name="Update_payroll" type="submit">Update Salary</button>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    No House Found.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                        }
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End:Main Body -->
</div>

<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->


<script>
    $(document).ready(function () {
        function loadData(type, id) {
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                data: {
                    type: type,
                    id: id
                },
                dataType: 'html',
                success: function (data) {
                    if (type === "Employee_ID") {
                        $('#Employee_ID').append(data);
                    } else if (type === "Employee_Salary") {
                        $('#Employee_Salary').html(data);
                    } else if (type === "Employee_Name") {
                        $('#Employee_Name').html(data);
                    }
                }
            });
        }

        loadData("Employee_ID");

        $("#Employee_ID").on("change", function () {
            var customer = $("#Employee_ID").val();
            if (customer != "") {
                loadData("Employee_Salary", customer);
            } else {
                $('#Employee_Salary').html("");
            }
        });
        $("#Employee_ID").on("change", function () {
            var customer = $("#Employee_ID").val();
            if (customer != "") {
                loadData("Employee_Name", customer);
            } else {
                $('#Employee_Name').html("");
            }
        });

    });
</script>
<script>
    function calculateDaysPresent() {
        const totalWorkingDays = parseInt(document.getElementById('totalWorkingDays').value);
        const daysAbsent = parseInt(document.getElementById('daysAbsent').value) || 0;
        const daysLeave = parseInt(document.getElementById('daysLeave').value) || 0;

        const daysPresent = totalWorkingDays - (daysAbsent + daysLeave);
        document.getElementById('daysPresent').value = daysPresent;
        // Assuming basic salary and deductions
        const basicSalary = parseInt(document.getElementById('Employee_Salary').value) || 0; // Example base salary
        const daysPresent1 = parseInt(document.getElementById('daysPresent').value);
        const totalWorkingDays1 = parseInt(document.getElementById('totalWorkingDays').value);

        // Calculate the salary based on days present
        const totalSalary = (basicSalary / totalWorkingDays1) * daysPresent1;
        document.getElementById('totalSalary').value = totalSalary.toFixed(2);
    }
</script>


<script>
     var daysLeave = document.getElementById('daysLeave');
     var daysAbsent = document.getElementById('daysAbsent');
     daysLeave.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    daysAbsent.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

</script>