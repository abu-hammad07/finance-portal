<?php
include_once("config.php");


// Users Updated Data 
function userEdit()
{
    global $conn;
    if (isset($_POST['userUpdate'])) {
        $usersDetailId = mysqli_real_escape_string($conn, $_POST['users_detail_id']);
        $userId = mysqli_real_escape_string($conn, $_POST['user_id']);
        $fullName = mysqli_real_escape_string($conn, $_POST['full_name']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $dateOfBirth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $roleId = mysqli_real_escape_string($conn, $_POST['user_type']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        // Get the current date and time
        $updated_date = date('Y-m-d');
        // Get the user's ID and name
        $updated_by = $_SESSION['username'];

        // check duplicate username
        $check_username = "SELECT * FROM `users` WHERE `username` = '$username' AND `user_id` != '$userId'";
        $check_username_res = mysqli_query($conn, $check_username);

        if (mysqli_num_rows($check_username_res) > 0) {
            $_SESSION['error_updated_user'] = "Username already exists $username";
            header("location: userDetails");
            exit();
        }

        // check duplicate email
        $check_email = "SELECT * FROM `users` WHERE `email` = '$email' AND `email` != '$email'";
        $check_email_res = mysqli_query($conn, $check_email);

        if (mysqli_num_rows($check_email_res) > 0) {
            $_SESSION['error_updated_user'] = "Email already exists $email";
            header("location: userDetails");
            exit();
        }

        // Check if an image was uploaded
        $image = '';
        if (!empty($_FILES['image']['name'])) {
            $image = mysqli_real_escape_string($conn, rand(111111111, 999999999) . '_' . $_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], 'media/images/' . $image);
        }

        // Update the user's data in the database
        $updateUser = "UPDATE `users` SET `username` = '$username', `email` = '$email', `role_id` = '$roleId', 
        `updated_date` = '$updated_date', `updated_by` = '$updated_by' 
        WHERE `user_id` = '$userId'";
        $updateUser_res = mysqli_query($conn, $updateUser);

        if ($updateUser_res) {

            // Update the user's details in the database
            $updateUserDetail = "UPDATE `users_detail` SET `full_name`= '$fullName', `phone`= '$phone', 
            `date_of_birth`= '$dateOfBirth', `gender`= '$gender', `address`= '$address'";

            if (!empty($image)) {
                $updateUserDetail .= ", `image`= '$image'";
            }

            $updateUserDetail .= ", `updated_date`= '$updated_date', `updated_by`= '$updated_by'
            WHERE `users_detail_id` = '$usersDetailId'";
            $updateUserDetail_res = mysqli_query($conn, $updateUserDetail);

            if ($updateUserDetail_res) {
                $_SESSION['success_updated_user'] = "$username updated successfully";
                header("location: userDetails");
                exit();
            } else {
                $_SESSION['error_updated_user'] = "Error updating users details";
                header("location: userDetails");
                exit();
            }
        } else {
            $_SESSION['error_updated_user'] = "Error updating user";
            header("location: userDetails");
            exit();
        }
    }
}
// End of Users Updated Data



// Users Deleted Data
function userDelete()
{
    global $conn;

    if (isset($_GET['user_delete_id'])) {
        $userId = mysqli_real_escape_string($conn, $_GET['user_delete_id']);

        // select user details
        $selectUser = "SELECT username, users_detail_id FROM `users` WHERE `user_id` = '$userId'";
        $selectUser_res = mysqli_query($conn, $selectUser);
        if (mysqli_num_rows($selectUser_res) > 0) {
            $row = mysqli_fetch_assoc($selectUser_res);
            $usersDetailId = $row['users_detail_id'];
            $username = $row['username'];
        }

        // Get the user's ID and name
        // $deleted_by = $_SESSION['username'];
        // Get the current date and time
        // $deleted_date = date('Y-m-d');

        // Delete the user
        $deleteUser = "DELETE FROM `users` WHERE `user_id` = '$userId'";
        $deleteUser_res = mysqli_query($conn, $deleteUser);

        if ($deleteUser_res) {

            // Delete the user's details
            $deleteUserDetail = "DELETE FROM `users_detail` WHERE `users_detail_id` = '$usersDetailId'";
            $deleteUserDetail_res = mysqli_query($conn, $deleteUserDetail);

            if ($deleteUserDetail_res) {
                $_SESSION['success_updated_user'] = "$username deleted successfully";
                header("location: userDetails");
                exit();
            } else {
                $_SESSION['error_updated_user'] = "Error deleting users details";
                header("location: userDetails");
                exit();
            }
        } else {
            $_SESSION['error_updated_user'] = "Error deleting user";
            header("location: userDetails");
            exit();
        }
    }
}
// End of Users Deleted Data


// Update profile data
function updateProfile()
{
    global $conn;

    if (isset($_POST['updateProfile'])) {
        $usersDetailId = mysqli_real_escape_string($conn, $_POST['usersDetailId']);
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);

        // image upload
        $image = '';
        if (!empty($_FILES['image']['name'])) {
            $image = mysqli_real_escape_string($conn, rand(111111111, 999999999) . '_' . $_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], 'media/images/' . $image);
        }

        // Get the current date and time
        $updated_date = date('Y-m-d');
        // Get the user's ID and name
        $updated_by = $_SESSION['username'];

        // Update the user's details in the database
        $updateUserDetail = "UPDATE `users_detail` SET `full_name`= '$full_name', `phone`= '$phone', 
        `date_of_birth`= '$date_of_birth', `gender`= '$gender', `address`= '$address'";
        if (!empty($image)) {
            $updateUserDetail .= ", `image`= '$image'";
        }

        $updateUserDetail .= ", `updated_date`= '$updated_date', `updated_by`= '$updated_by'
        WHERE `users_detail_id` = '$usersDetailId'";
        $updateUserDetail_res = mysqli_query($conn, $updateUserDetail);

        if ($updateUserDetail_res) {
            $_SESSION['success_updated_profile'] = "Profile updated successfully";
            header("location: profile");
            exit();
        } else {
            $_SESSION['error_updated_profile'] = "Error updating profile";
            header("location: profile");
            exit();
        }

    }
}
// End of Update profile data
