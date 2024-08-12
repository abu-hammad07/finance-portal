<?php
session_start();
include_once ("includes/config.php");
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
    <h4 class="mb-4 text-capitalize">View User</h4>
    <!-- End:Title -->

    <?php
    if (isset($_GET['user_view_id'])) {

        $user_view_id = mysqli_real_escape_string($conn, $_GET['user_view_id']);

        $query = "SELECT user_id, username, email, users_detail.full_name, users_detail.Phone, users_detail.address, users_detail.gender, users_detail.date_of_birth, role.name as role
                    FROM users 
                    LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
                    LEFT JOIN role ON users.role_id = role.role_id
                    WHERE users.user_id = '$user_view_id'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <form action="" method="POST" id="add_user_form" enctype="multipart/form-data">
                    <div class="card h-auto">
                        <div class="card-body">
                            <h3 class="card-header">Information</h3>
                            <hr class="my-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" readonly class="form-control" id="full_name" name="full_name"
                                        placeholder="Enter Full Name" value="<?= $row['full_name'] ?>">
                                    <span class="text-danger" id="full_name_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" readonly class="form-control" id="phone" name="phone"
                                        placeholder="Enter Phone Number" value="<?= $row['Phone'] ?>">
                                    <span class="text-danger" id="phone_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date Of Birth</label>
                                    <input type="date" readonly class="form-control" id="date_of_birth" name="date_of_birth"
                                        placeholder="Enter Date Of Birth" value="<?= $row['date_of_birth'] ?>">
                                    <span class="text-danger" id="date_of_birth_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Gender</label>
                                    <div class="input-group">
                                        <select id="gender" name="gender" class="form-control">
                                            <option value="<?= $row['gender'] ?>"><?= $row['gender'] ?></option>
                                        </select>
                                    </div>
                                    <span class="text-danger" id="gender_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Address</label>
                                    <input type="text" readonly class="form-control" id="address" name="address"
                                        placeholder="Enter Address" value="<?= $row['address'] ?>">
                                    <span class="text-danger" id="address_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">User Type</label>
                                    <div class="input-group">
                                        <select id="user_type" name="user_type" class="form-control">
                                            <option value="<?= $row['role'] ?>"><?= $row['role'] ?></option>
                                        </select>
                                    </div>
                                    <span class="text-danger" id="user_type_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Username</label>
                                    <input type="text" readonly class="form-control" id="username" name="username"
                                        placeholder="Enter Username" value="<?= $row['username'] ?>">
                                    <span class="text-danger" id="username_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" readonly class="form-control" id="email" name="email"
                                        placeholder="Enter Email" value="<?= $row['email'] ?>">
                                    <span class="text-danger" id="email_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- submit btn -->
                    <div class="mt-3">
                        <a href="userDetails" class="btn btn-danger">Back</a>
                    </div>
                </form>
                <?php
            }
        } else {
            header('location: 404');
            exit();
        }
    }
    ?>


    <!-- End:submit btn -->
</div>
<!-- End:Main Body -->
</div>



<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->