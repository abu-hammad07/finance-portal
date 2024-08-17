<?php
session_start();
include_once ("includes/config.php");
include "includes/function2.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
addPayroll()
?>


<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Add Payroll</h4>
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
                    <div class="col-md-6">
                        <label class="form-label">Employee ID</label>
                        <select name="employee_id" id="Employee_ID" class="form-select form-control Employee_ID"
                            required>
                            <option value="">--- Employee ID ---</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Employee Name</label>
                        <select name="Employee_Name" id="Employee_Name" class="form-select form-control Employee_Name">
                            <option value="">--- Employee Name ---</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Employee Salary</label>
                        <select name="employee_salary" id="Employee_Salary"
                            class="form-select form-control Employee_Salary" required>
                            <option value="">--- Employee Salary ---</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Month-Year</label>
                        <input type="month" id="monthYear" name="month_year" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Total Working Days</label>
                        <input type="number" id="totalWorkingDays" name="total_working_days" class="form-control"
                            value="30" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Days Absent</label>
                        <input type="text" id="daysAbsent" name="days_absent" class="form-control" value="0" min="0"
                            required oninput="calculateDaysPresent()">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Days Leave</label>
                        <input type="text" id="daysLeave" name="days_leave" class="form-control" value="0" min="0"
                            required oninput="calculateDaysPresent()">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Days Present</label>
                        <input type="number" id="daysPresent" name="days_present" class="form-control"
                            placeholder="Total Present" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Total Salary</label>
                        <input type="number" id="totalSalary" name="total_salary" class="form-control"
                            placeholder="Total Salary" readonly>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary" name="add_payroll" type="submit">Add Salary</button>
                    </div>
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