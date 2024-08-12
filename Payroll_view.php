<?php
session_start();
include_once ("includes/config.php");
include "includes/function2.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
?>

<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Empoly Details</h4>
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
    <div class="card h-auto shadow-sm">
        <div class="card-body">
            <h3 class="card-header text-center bg-primary text-white">Payroll Information</h3>
            <hr class="my-4">
            <div class="row g-3">
                <?php
                if (isset($_GET['payroll_view_id'])) {
                    $edit_id = mysqli_real_escape_string($conn, $_GET['payroll_view_id']);
                    $edit_query = "SELECT * FROM payroll WHERE payroll_id = '$edit_id'";
                    $edit_result = mysqli_query($conn, $edit_query);

                    if (mysqli_num_rows($edit_result) > 0) {
                        while ($row = mysqli_fetch_assoc($edit_result)) {
                            ?>
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th>Employee ID</th>
                                    <td><?= htmlspecialchars($row['employee_id']); ?></td>
                                </tr>
                                <tr>
                                    <th>Employee Name</th>
                                    <td>
                                        <?php
                                        $payroll_names = explode(',', $row['employee_id']);
                                        foreach ($payroll_names as $payroll_name) {
                                            $seql_dep = mysqli_query($conn, "SELECT * FROM `employees` WHERE `employee_id` ='$payroll_name'");
                                            $dep = mysqli_fetch_object($seql_dep);
                                            if ($dep) {
                                                echo htmlspecialchars($dep->employee_full_name);
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Employee Salary</th>
                                    <td><?= htmlspecialchars($row['employee_salary']); ?></td>
                                </tr>
                                <tr>
                                    <th>Month-Year</th>
                                    <td><?= htmlspecialchars($row['month_year']); ?></td>
                                </tr>
                                <tr>
                                    <th>Total Working Days</th>
                                    <td>30</td>
                                </tr>
                                <tr>
                                    <th>Days Absent</th>
                                    <td><?= htmlspecialchars($row['days_absent']); ?></td>
                                </tr>
                                <tr>
                                    <th>Days Leave</th>
                                    <td><?= htmlspecialchars($row['days_leave']); ?></td>
                                </tr>
                                <tr>
                                    <th>Days Present</th>
                                    <td><?= htmlspecialchars($row['days_present']); ?></td>
                                </tr>
                                <tr>
                                    <th>Total Salary</th>
                                    <td><?= htmlspecialchars($row['total_salary']); ?></td>
                                </tr>
                            </table>
                            <?php
                        }
                    } else {
                        echo '<div id="successAlert" class="alert alert-warning alert-dismissible fade show" role="alert">
                            No Payroll Found.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
                    }
                }
                ?>
            </div>
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