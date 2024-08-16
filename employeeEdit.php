<?php
session_start();
include_once ("includes/config.php");
include_once ("includes/function.php");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
updateEmployees();
?>

<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Edit Employee</h4>
    <!-- End:Title -->

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_added_employee'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_added_employee'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_added_employee']);
    }
    if (isset($_SESSION['error_added_employee'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_added_employee'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_added_employee']);
    }
    ?>
    <!-- / Alert -->

    <?php
    if (isset($_GET['employee_edit_id'])) {

        $employee_edit_id = mysqli_real_escape_string($conn, $_GET['employee_edit_id']);

        $query = "SELECT * FROM employees WHERE employee_id = '$employee_edit_id'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>

                <form action="" method="post" id="add_houses_form" enctype="multipart/form-data">
                    <div class="card h-auto">
                        <div class="card-body">
                            <h3 class="card-header">Information</h3>
                            <hr class="my-4">
                            <div class="row g-3">
                                <input type="hidden" hidden name="employee_id" id="employee_id" class="form-control"
                                    value="<?= $row['employee_id'] ?>">
                                <div class="col-md-6">
                                    <label class="form-label">Employee ID
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" readonly name="employeeID" id="employeeID" class="form-control"
                                        placeholder="#EM001" value="<?= $row['employeeID'] ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Full Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Hammad Ali"
                                        required value="<?= $row['employee_full_name'] ?>">
                                    <span class="text-danger" id="full_name_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="EmployeeCnic" class="form-label">CNIC
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="cnic" id="EmployeeCnic" class="form-control" placeholder="XXXXX-XXXXXXX-X"
                                        required value="<?= $row['employee_cnic'] ?>">
                                    <span class="text-danger" id="cnic_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Qualification
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="qualification" id="qualification" class="form-control"
                                        placeholder="MBA" required value="<?= $row['employee_qualification'] ?>">
                                    <span class="text-danger" id="qualification_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="EmployeeContact" class="form-label">Phone Number
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="phone_number" id="EmployeeContact" class="form-control"
                                        placeholder="03XXXXXXXXX" required value="<?= $row['employee_contact'] ?>">
                                    <span class="text-danger" id="phone_number_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="ep4rK@example.com"
                                        required value="<?= $row['employee_email'] ?>">
                                    <span class="text-danger" id="email_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Address
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="address" id="address" class="form-control" placeholder="DHA Karachi"
                                        required value="<?= $row['employee_address'] ?>">
                                    <span class="text-danger" id="address_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Appointment Date
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="appointment_date" id="appointment_date" class="form-control"
                                        value="<?= $row['appointment_date'] ?>">
                                    <span class="text-danger" id="appointment_date_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Employee Type
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="employee_type" id="employee_type" class="form-select form-control" required>
                                        <option value="">Select Type</option>
                                        <option value="permanent" <?php if ($row['employement_type'] == 'permanent')
                                            echo "selected" ?>>permanent</option>
                                            <option value="contract" <?php if ($row['employement_type'] == 'contract')
                                            echo "selected" ?>>
                                                contract</option>
                                        </select>
                                        <span class="text-danger" id="gender_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Department
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="department" id="department" class="form-control" placeholder="IT"
                                            required value="<?= $row['department'] ?>">
                                    <span class="text-danger" id="department_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Designation
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="designation" id="designation" class="form-control"
                                        placeholder="Manager" required value="<?= $row['designation'] ?>">
                                    <span class="text-danger" id="designation_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Salary
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="employee_salary" id="employee_salary" class="form-control"
                                        placeholder="45000" required value="<?= $row['salary'] ?>">
                                    <span class="text-danger" id="employee_salary_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Employee Image</label>
                                    <input type="file" name="employee_image" id="employee_image" class="form-control">
                                </div>

                                <!-- Button -->
                                <div class="col-md-12">
                                    <button type="submit" id="submit_btn" name="employeeUpdate"
                                        class="btn btn-primary">Update</button>
                                    <a href="employee" class="btn btn-outline-danger">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <?php
            }
        } else {
            echo '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no data in the database.</td>
                </tr>';
        }
    } else {
        echo '<tr>
                <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no ID Found.</td>
            </tr>';
    }
    ?>

</div>
<!-- End:Main Body -->
</div>

<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->

<script>
    var EmployeeContact = document.getElementById('EmployeeContact');
    EmployeeContact.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    var EmployeeCnic = document.getElementById('EmployeeCnic');

    EmployeeCnic.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9-]/g, '');
        if (this.value.length > 5 && this.value[5] !== '-') {
            this.value = this.value.slice(0, 5) + '-' + this.value.slice(5);
        }
        if (this.value.length > 13 && this.value[13] !== '-') {
            this.value = this.value.slice(0, 13) + '-' + this.value.slice(13);
        }
        if (this.value.length > 15) {
            this.value = this.value.slice(0, 15);
        }
    });
</script>