<?php
session_start();
include_once ("includes/config.php");
include_once ("includes/function.php");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
$select = mysqli_query($conn, "SELECT users.*, role.name as role, users_detail.*
FROM users
LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
LEFT JOIN role ON role.role_id = users.role_id
WHERE users.user_id = '{$_SESSION['UID']}'");

if (mysqli_num_rows($select) > 0) {


    $row = mysqli_fetch_assoc($select);
    if ($row['image'] == '') {
        $adminImage = "./assets/images/user-default.png";
    } else {
        $adminImage = "./media/images/" . $row['image'];
    }

    $role = $row['role'];
    $email = $row['email'];
    $fullName = $row['full_name'];
    $phone = $row['Phone'];
    $dateOfBirth = $row['date_of_birth'];
    $gender = $row['gender'];
    $address = $row['address'];
    $usersDetailId = $row['users_detail_id'];
}

// update profile function
updateProfile();

?>

<!-- Main sidebar -->
<?php include ("includes/sidebar.php"); ?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4">Profile</h4>
    <!-- End:Title -->

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_updated_profile'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_updated_profile'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_updated_profile']);
    }
    if (isset($_SESSION['error_updated_profile'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_updated_profile'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_updated_profile']);
    }
    ?>
    <!-- / Alert -->

    <div class="card h-auto">
        <div class="card-body d2c_user_profile_card">
            <div class="row">
                <div class="col-xxl-3">
                    <div class="row">
                        <div class="col-lg-6 col-xxl-12">
                            <div class="card mb-4">
                                <img src="assets/images/profile_info_bg.jpg" class="w-100 d2c_user_bg"
                                    alt="profile info bg">
                                <div class="card-body d2c_user_info ">
                                    <img src="<?= $adminImage ?>" class="d2c_user_profile_img mb-3 rounded"
                                        alt="User image">
                                    <h5 class="mb-0 d2c_user_title"><?= $fullName ?></h5>
                                    <p class="mb-0"><?= $role ?></p>
                                    <p><?= $email ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-12">
                            <div class="card mb-4">
                                <div class="card-body d2c_info_details">
                                    <!-- user details -->
                                    <h5 class="mb-3 d2c_user_title">Details</h5>
                                    <p>
                                        <i class="fas fa-phone"></i>
                                        <?= $phone ?>
                                    </p>
                                    <p>
                                        <i class="fas fa-calendar"></i>
                                        <!-- Date of Birth:  -->
                                        <?= $dateOfBirth ?>
                                    </p>
                                    <p>
                                        <i class="fas fa-address-book"></i>
                                        <!-- Address:  -->
                                        <?= $address ?>
                                    </p>
                                    <p>
                                        <i class="fas fa-users"></i>
                                        <!-- Gender:  -->
                                        <?= $gender ?>
                                    </p>

                                    <div class="mt-3">
                                        <button id="edit_btn" class="btn btn-primary">Edit Profile</button>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl" id="editForm" style="visibility: hidden;">
                    <form action="" method="POST" id="add_user_form" enctype="multipart/form-data">
                        <div class="card h-auto">
                            <div class="card-body">
                                <h3 class="card-header">Information</h3>
                                <hr class="my-4">
                                <div class="row g-3">
                                    <input type="text" class="form-control" hidden name="usersDetailId"
                                        value="<?= $usersDetailId ?>">
                                    <div class="col-md-6">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="full_name" name="full_name"
                                            placeholder="Enter Full Name" value="<?= $fullName ?>">
                                        <span class="text-danger" id="full_name_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            placeholder="Enter Phone Number" value="<?= $phone ?>">
                                        <span class="text-danger" id="phone_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Date Of Birth</label>
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                            placeholder="Enter Date Of Birth" value="<?= $dateOfBirth ?>">
                                        <span class="text-danger" id="date_of_birth_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Gender</label>
                                        <div class="input-group">
                                            <select id="gender" name="gender" class="form-select form-control">
                                                <option value="Male" <?php if ($gender == "Male")
                                                    echo "selected"; ?>>Male
                                                </option>
                                                <option value="Female" <?php if ($gender == "Female")
                                                    echo "selected"; ?>>
                                                    Female</option>
                                            </select>
                                        </div>
                                        <span class="text-danger" id="gender_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            placeholder="Enter Address" value="<?= $address ?>">
                                        <span class="text-danger" id="address_error"></span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Login -->
                        <div class="card h-auto mt-4">
                            <div class="card-body">
                                <h3 class="card-header">Update Profile Picture</h3>
                                <hr class="my-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Image</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- submit btn -->
                        <div class="mt-3">
                            <button type="submit" id="submit_btn" name="updateProfile"
                                class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- End:Main Body -->
</div>

<?php include_once('includes/footer.php'); ?>

<script>
    document.getElementById("edit_btn").addEventListener('click', () => {
        // toggle edit button
        document.getElementById("edit_btn").style.display = "none";
        document.getElementById("submit_btn").style.display = "block";
        document.getElementById("editForm").style.visibility = "visible";
        document.getElementById("editForm").style.display = "block";
    });
</script>
