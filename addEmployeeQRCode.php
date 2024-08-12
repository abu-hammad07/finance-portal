<?php
session_start();
include_once ("includes/config.php");
include_once ("includes/function.php");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
// InsertEmployees();
?>
        <!-- Main sidebar -->
        <?php
        include ("includes/sidebar.php");
        ?>
        <!-- End:Sidebar -->

        <!-- Main Body-->
        <div class="d2c_main p-4 ps-lg-3">

            <!-- Title -->
            <h4 class="mb-4 text-capitalize">Add Employee</h4>
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
            $gene_query = "SELECT `employeeID` FROM `employees` ORDER BY `employeeID` DESC";
            $gene_result = mysqli_query($conn, $gene_query);
            if (!$gene_result) {
                die("Error in SQL query: " . mysqli_error($conn));
            }
            $gene_row = mysqli_fetch_array($gene_result);
            $last_reg_no = isset($gene_row['employeeID']) ? $gene_row['employeeID'] : null;

            if (empty($last_reg_no)) {
                $auto_reg_no = "#-0001";
            } else {
                $idd = str_replace("#-", "", $last_reg_no);
                // $id = str_pad($idd + 1, 4, 0, STR_PAD_LEFT);
                $id = str_pad((string)($idd + 1), 4, 0, STR_PAD_LEFT);
                $auto_reg_no = "#-" . $id;
            }
            ?>

            <form action="includes/QRcode.php" method="post" id="add_houses_form" enctype="multipart/form-data">
                <div class="card h-auto">
                    <div class="card-body">
                        <h3 class="card-header">Information</h3>
                        <hr class="my-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Employee ID
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" readonly name="employeeID" id="employeeID" class="form-control"
                                    placeholder="#EM001" value="<?= $auto_reg_no ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Full Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="full_name" id="full_name" class="form-control"
                                    placeholder="Hammad Ali" required>
                                <span class="text-danger" id="full_name_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">CNIC
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="cnic" id="cnic" class="form-control"
                                    placeholder="XXXXX-XXXXXXX-X" required>
                                <span class="text-danger" id="cnic_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Qualification
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="qualification" id="qualification" class="form-control"
                                    placeholder="MBA" required>
                                <span class="text-danger" id="qualification_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="phone_number" id="phone_number" class="form-control"
                                    placeholder="03XXXXXXXXX" required>
                                <span class="text-danger" id="phone_number_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="email" id="email" class="form-control"
                                    placeholder="ep4rK@example.com" required>
                                <span class="text-danger" id="email_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Address
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="address" id="address" class="form-control"
                                    placeholder="DHA Karachi" required>
                                <span class="text-danger" id="address_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Appointment Date
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="appointment_date" id="appointment_date" class="form-control"
                                    value="<?= date('Y-m-d') ?>">
                                <span class="text-danger" id="appointment_date_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Employee Type
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="employee_type" id="employee_type" class="form-select form-control"
                                    required>
                                    <option value="">Select Type</option>
                                    <option value="permanent">permanent</option>
                                    <option value="contract">contract</option>
                                </select>
                                <span class="text-danger" id="gender_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Department
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="department" id="department" class="form-control"
                                    placeholder="IT" required>
                                <span class="text-danger" id="department_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Designation
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="designation" id="designation" class="form-control"
                                    placeholder="Manager" required>
                                <span class="text-danger" id="designation_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Salary
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="employee_salary" id="employee_salary" class="form-control"
                                    placeholder="45000" required>
                                <span class="text-danger" id="employee_salary_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Employee Image</label>
                                <input type="file" name="employee_image" id="employee_image" class="form-control">
                            </div>

                            <!-- Button -->
                            <div class="col-md-12">
                                <button class="btn btn-primary" id="submit_btn" type="submit" name="submitEmployee">Add
                                    Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- End:Main Body -->
    </div>

<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->