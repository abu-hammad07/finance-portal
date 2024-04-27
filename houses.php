<?php
session_start();
include_once ("includes/config.php");
include "includes/function.php";
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
deleteHouse();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Society Houses</title>
    <meta name="og:description"
        content="FinDeshY is a free financial Bootstrap dashboard template to manage your financial data easily. This free financial dashboard uses Bootstrap to provide a responsive and user-friendly interface. Whether you're a small business owner seeking insights into your company's financial health or an individual looking to simplify your personal finances, this free Bootstrap dashboard template has you covered.">
    <meta name="robots" content="index, follow">
    <meta name="og:title" property="og:title" content="FinDeshY - Free Financial Bootstrap Dashboard Template">
    <meta property="og:image"
        content="https://www.designtocodes.com/wp-content/uploads/2023/10/FinDeshY-Professional-Financial-Bootstrap-Dashboard-Template.jpg">
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
        <!-- <img src="assets/images/logo/KDA.png" alt="DesignToCodes"> -->
    </div>
    <!-- Preloader End -->

    <div class="d2c_wrapper">

        <!-- Main sidebar -->
        <?php
        include ("includes/sidebar.php");
        ?>
        <!-- End:Sidebar -->

        <!-- Main Body-->
        <div class="d2c_main p-4 ps-lg-3">

            <!-- Title -->
            <h4 class="mb-4 text-capitalize">Society Houses</h4>
            <!-- End:Title -->

            <a href="addHouse.php" class="btn btn-primary mb-4"><i class="fas fa-plus"></i> Add House</a>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card h-auto d2c_projects_datatable">
                        <div class="card-header">
                            <h6>Society Houses Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-responsive">
                                <table class="table" id="d2c_advanced_table_2">
                                    <thead>
                                        <tr>
                                            <th >S.No</th>
                                            <th >House/Unit Number</th>
                                            <th >Owner's Name</th>
                                            <th >Owner's Contact Information</th>
                                            <th >Occupancy Status</th>
                                            <th >Tenant's Name (if applicable)</th>
                                            <th >Tenant's Contact Information (if applicable)
                                            </th>
                                            <th >Type of Property</th>
                                            <th >Floor</th>
                                            <th >Size/Area of the Property</th>
                                            <th >Monthly Maintenance Fee</th>
                                            <th >Additional Notes/Comments</th>
                                            <th >Added on</th>
                                            <th >Added By</th>
                                            <th >Updated on</th>
                                            <th >Updated By</th>
                                            <th >Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT houses.*, users_detail.full_name
                                FROM houses
                                INNER JOIN users_detail ON houses.added_by = users_detail.users_detail_id";
                                        global $conn;
                                        $select_all_houses_query = mysqli_query($conn, $query);

                                        while ($row = mysqli_fetch_assoc($select_all_houses_query)) {
                                            $houseId = $row['house_id'];
                                            $houseNumber = $row['house_number'];
                                            $ownerName = $row['owner_name'];
                                            $ownerContact = $row['owner_contact'];
                                            $occupanceStatus = $row['occupancy_status'];
                                            $tenantsName = $row['tenants_name'];
                                            $tenantContact = $row['tenants_contact'];
                                            $floor = $row['floor'];
                                            $propertyType = $row['property_type'];
                                            $propertySize = $row['property_size'];
                                            $maintenanceCharges = $row['maintenance_charges'];
                                            $notes = $row['notes'];
                                            global $conn;
                                            $added_on = $row['added_on'];
                                            $added_by = $row['full_name'];
                                            $updated_on = $row['added_on'];
                                            $updated_by = $row['full_name'];
                                            ?>

                                            <tr>
                                                <td><?php echo $houseId;?></td>
                                                <td><?php echo $houseNumber;?></td>
                                                <td><?php echo $ownerName;?></td>
                                                <td><?php echo $ownerContact;?></td>
                                                <td><?php echo $occupanceStatus;?></td>
                                                <td><?php echo $tenantsName;?></td>
                                                <td><?php echo $tenantContact;?></td>
                                                <td><?php echo $propertyType;?></td>
                                                <td><?php echo $floor;?></td>
                                                <td><?php echo $propertySize;?></td>
                                                <td><?php echo $maintenanceCharges;?></td>
                                                <td><?php echo $notes;?></td>
                                                <td><?php echo $added_by;?></td>
                                                <td><?php echo $added_on;?></td>
                                                <td><?php echo $updated_by;?></td>
                                                <td><?php echo $updated_on;?></td>
                                                <td>
                                                <?php echo "<a dropdown-item' href='houses.php?delete={$houseId}'>" ?><button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" title="Delete">
                                                          <i class="fas fa-trash  text-danger p-1 "></i></span>
                                                        </button></a>
                                                    <!-- <div class="dropdown">
                                                        <button class="btn dropdown-toggle" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                        
                                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                                            <li><?php echo "<a dropdown-item' href='houses.php?delete={$houseId}'>" ?>Delete</a></li>
                                                        </ul>
                                                    </div> -->
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:Main Body -->
    </div>

    <!-- Offcanvas Toggler -->
    <button class="d2c_offcanvas_toggle position-fixed top-50 start-0 translate-middle-y d-block d-lg-none"
        type="button" data-bs-toggle="offcanvas" data-bs-target="#d2c_sidebar">
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