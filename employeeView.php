<?php
session_start();
include_once("includes/config.php");
include_once("includes/function.php");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>View Employee</title>
    <meta name="og:description" content="FinDeshY is a free financial Bootstrap dashboard template to manage your financial data easily. This free financial dashboard uses Bootstrap to provide a responsive and user-friendly interface. Whether you're a small business owner seeking insights into your company's financial health or an individual looking to simplify your personal finances, this free Bootstrap dashboard template has you covered.">
    <meta name="robots" content="index, follow">
    <meta name="og:title" property="og:title" content="FinDeshY - Free Financial Bootstrap Dashboard Template">
    <meta property="og:image" content="https://www.designtocodes.com/wp-content/uploads/2023/10/FinDeshY-Professional-Financial-Bootstrap-Dashboard-Template.jpg">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="lib/bootstrap_5/bootstrap.min.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="lib/fontawesome/css/all.min.css">
    <!-- main css -->
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- responsive css -->
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>

<body class="d2c_theme_light">
    <!-- Preloader Start -->
    <div class="preloader">
        <!-- <img src="assets/images/logo/logo.png" alt="DesignToCodes"> -->
    </div>
    <!-- Preloader End -->

    <div class="d2c_wrapper">

        <!-- Main sidebar -->
        <?php
        include("includes/sidebar.php");
        ?>
        <!-- End:Sidebar -->

        <!-- Main Body-->
        <div class="d2c_main p-4 ps-lg-3">

            <!-- Title -->
            <h4 class="mb-4 text-capitalize">View Employee</h4>
            <!-- End:Title -->

            <?php
            if (isset($_GET['employee_view_id'])) {

                $employee_view_id = mysqli_real_escape_string($conn, $_GET['employee_view_id']);

                $query = "SELECT * FROM employees WHERE employee_id = '$employee_view_id'";
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
                                        <input type="hidden" hidden name="employee_id" id="employee_id" class="form-control" value="<?= $row['employee_id'] ?>">
                                        <div class="col-md-6">
                                            <label class="form-label">Employee ID
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" readonly name="employeeID" id="employeeID" class="form-control" placeholder="#EM001" value="<?= $row['employeeID'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Full Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" readonly name="full_name" id="full_name" class="form-control" placeholder="Hammad Ali" required value="<?= $row['employee_full_name'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">CNIC
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" readonly name="cnic" id="cnic" class="form-control" placeholder="XXXXX-XXXXXXX-X" required value="<?= $row['employee_cnic'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Qualification
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" readonly name="qualification" id="qualification" class="form-control" placeholder="MBA" required value="<?= $row['employee_qualification'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Phone Number
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" readonly name="phone_number" id="phone_number" class="form-control" placeholder="03XXXXXXXXX" required value="<?= $row['employee_contact'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" readonly name="email" id="email" class="form-control" placeholder="ep4rK@example.com" required value="<?= $row['employee_email'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Address
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" readonly name="address" id="address" class="form-control" placeholder="DHA Karachi" required value="<?= $row['employee_address'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Appointment Date
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" readonly name="appointment_date" id="appointment_date" class="form-control" value="<?= $row['appointment_date'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Employee Type
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="employee_type" id="employee_type" class="form-select form-control" required>
                                                <option value="<?= $row['employement_type'] ?>"><?= $row['employement_type'] ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Department
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" readonly name="department" id="department" class="form-control" placeholder="IT" required value="<?= $row['department'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Designation
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" readonly name="designation" id="designation" class="form-control" placeholder="Manager" required value="<?= $row['designation'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Salary
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" readonly name="employee_salary" id="employee_salary" class="form-control" placeholder="45000" required value="<?= $row['salary'] ?>">
                                        </div>
                                        <!-- images show -->
                                        <div class="col-md-6">
                                            <label class="form-label">Employee Image</label>
                                            <img src="media/images/<?= $row['employee_image'] ?>" alt="employee image" class="img-fluid">
                                        </div>

                                        <!-- Button -->
                                        <div class="col-md-12">
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

    <!-- Offcanvas Toggler -->
    <button class="d2c_offcanvas_toggle position-fixed top-50 start-0 translate-middle-y d-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#d2c_sidebar">
        <i class="far fa-hand-point-right"></i>
    </button>
    <!-- End:Offcanvas Toggler -->
    <!-- Initial  Javascript -->
    <script src="lib/jQuery/jquery-3.5.1.min.js"></script>
    <script src="lib/bootstrap_5/bootstrap.bundle.min.js"></script>

    <!-- custom js -->
    <script src="assets/js/main.js"></script>
</body>

</html>