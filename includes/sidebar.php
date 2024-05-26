<?php
$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);


$select = mysqli_query($conn, "SELECT users_detail.image, users_detail.full_name, role.name as role FROM `users`
LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
LEFT JOIN role ON role.role_id = users.role_id
WHERE users.user_id = '{$_SESSION['UID']}'");

$row = mysqli_fetch_assoc($select);
if ($row['image'] == '') {
    $row['image'] = "./assets/images/user-default.png";
} else {
    $row['image'] = "./media/images/" . $row['image'];
}
?>

<div class="d2c_sidebar offcanvas-lg offcanvas-start p-4 pe-lg-2" tabindex="-1" id="d2c_sidebar">
    <div class="d-flex flex-column">
        <!-- Logo -->
        <a href="index" class="mb-5 brand-icon">
            <img class="navbar-brand" src="./assets/images/logo/KDA.png" alt="logo">

        </a>
        <!-- End:Logo -->

        <!-- Profile -->
        <div class="card d2c_profile_card text-center mb-4">
            <!-- Profile Image -->
            <a href="profile">
                <img class="rounded-circle d2c_profile_image position-absolute top-0 start-50 translate-middle mb-2" src="<?= $row['image']; ?>" alt="d2c Profile Image">
            </a>
            <!-- End:Profile Image-->

            <div class="card-body mt-4">
                <h6 class="fw-bold mb-3"><?= $row['full_name']; ?></h6>
                <span class="d2c_role"><?= $row['role']; ?></span>
                <ul class="list-inline">
                    <!-- Profile -->
                    <li class="list-inline-item position-relative me-3">
                        <a class="dropdown-item d-flex align-items-center py-2" href="profile">
                            <i class="fas fa-user-cog"></i>
                            <p class="mb-0">&nbsp View Profile</p>
                        </a>

                    </li>
                    <!-- Profile -->


                </ul>

            </div>
        </div>
        <!-- End:Profile -->

        <!-- Menu -->
        <div class="card d2c_menu_card mb-4">
            <div class="card-body">
                <ul class="navbar-nav flex-grow-1">
                    <!-- Menu Item -->
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)">
                            <span>Menu</span>
                        </a>
                        <!-- Sub Menu -->
                        <ul class="sub-menu collapse show">
                            <!-- Sub Menu Item -->
                            <li class="nav-item <?php if ($page == 'index.php') echo ('active'); ?>">
                                <a class="sub-menu-link" href="index">
                                    <span class="d2c_icon">
                                        <i class="fas fa-home"></i>
                                    </span>
                                    <span>
                                        Overview
                                    </span>
                                </a>
                            </li>
                            <!-- End:Sub Menu Item -->

                            <!-- Sub Menu Item -->
                            <li class="nav-item <?php if ($page == 'houses.php' || $page == 'addHouse.php' || $page == 'houseView.php' || $page == 'houseEdit.php')
                                                    echo ('open active') ?>">
                                <a class="sub-menu-link" data-bs-toggle="collapse" data-bs-target="#income" aria-expanded="false" href="#">
                                    <span class="d2c_icon">
                                        <i class="fas fa-money-check-alt"></i>
                                    </span>
                                    <span>Income</span>
                                    <span class="fas fa-chevron-right ms-auto text-end"></span>
                                </a>
                                <!-- Child Sub Menu -->
                                <ul class="sub-menu collapse" id="income">
                                    <li class="nav-item <?php if ($page == 'houses.php' || $page == 'addHouse.php' || $page == 'houseView.php' || $page == 'houseEdit.php') echo ('active') ?>">
                                        <a class="nav-link" href="houses">
                                            <span>Society Houses</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?php if ($page == 'tenants.php' || $page == 'addTenant.php' || $page == 'tenantView.php' || $page == 'tenantEdit.php') echo ('active'); ?>">
                                        <a class="nav-link" href="tenants">
                                            <span>Tenents</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?php if ($page == 'shops.php' || $page == 'addShop.php' || $page == 'shopView.php' || $page == 'shopEdit.php') echo ('active'); ?>">
                                        <a class="nav-link" href="shops">
                                            <span>Shops</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?php if ($page == 'eGate.php' || $page == 'addeGate.php' || $page == 'eGateView.php' || $page == 'eGateEdit.php') echo ('active'); ?>">
                                        <a class="nav-link" href="eGate">
                                            <span>E-Gate Pass</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?php if ($page == 'servants.php' || $page == 'addServant.php' || $page == 'servantView.php' || $page == 'servantEdit.php') echo ('active'); ?>">
                                        <a class="nav-link" href="servants">
                                            <span>Servants</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?php if ($page == 'eventsDetails.php' || $page == 'eventBooking.php' || $page == 'eventView.php' || $page == 'eventEdit.php') echo ('active'); ?>">
                                        <a class="nav-link" href="eventsDetails">
                                            <span>Events Booking</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?php if ($page == 'maintenanceCharges.php') echo ('active'); ?>">
                                        <a class="nav-link" href="maintenanceCharges.php">
                                            <span>Maintenance Charges</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?php if ($page == 'penalty.php') echo ('active'); ?>">
                                        <a class="nav-link" href="penalty.php">
                                            <span>Penalty Charges</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="viewIncomeReports">
                                            <span>View Income Reports</span>
                                        </a>
                                    </li>
                                </ul>
                                <!-- End:Child Sub Menu -->
                            </li>
                            <!-- End:Sub Menu Item -->

                            <!-- Sub Menu Item -->
                            <li class="nav-item">
                                <a class="sub-menu-link" data-bs-toggle="collapse" data-bs-target="#expenses" aria-expanded="false" href="javascript:void(0)">
                                    <span class="d2c_icon">
                                        <i class="fas fa-money-check-alt"></i>
                                    </span>
                                    <span>Expenses</span>
                                    <span class="fas fa-chevron-right ms-auto text-end"></span>
                                </a>
                                <!-- Child Sub Menu -->
                                <ul class="sub-menu collapse" id="expenses">
                                    <li class="nav-item">
                                        <a class="nav-link" href="utilityCharges">
                                            <span>Utility Charges</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="societyMaintenance">
                                            <span>Society Maintenance</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="viewIncomeReports">
                                            <span>View Income Reports</span>
                                        </a>
                                    </li>
                                </ul>
                                <!-- End:Child Sub Menu -->
                            </li>
                            <!-- End:Sub Menu Item -->

                            <!-- Sub Menu Item -->
                            <li class="nav-item">
                                <a class="sub-menu-link" data-bs-toggle="collapse" data-bs-target="#employeeManagementSystem" aria-expanded="false" href="#">
                                    <span class="d2c_icon">
                                        <i class="fas fa-money-check-alt"></i>
                                    </span>
                                    <span>Employees & Payroll</span>
                                    <span class="fas fa-chevron-right ms-auto text-end"></span>
                                </a>
                                <!-- Child Sub Menu -->
                                <ul class="sub-menu collapse" id="employeeManagementSystem">
                                    <li class="nav-item">
                                        <a class="nav-link" href="employee">
                                            <span>Employee</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="payroll">
                                            <span>Payroll</span>
                                        </a>
                                    </li>
                                </ul>
                                <!-- End:Child Sub Menu -->
                            </li>
                            <!-- End:Sub Menu Item -->

                            <!-- Sub Menu Item -->
                            <li class="nav-item">
                                <a class="sub-menu-link" data-bs-toggle="collapse" data-bs-target="#reconcilation" aria-expanded="false" href="#">
                                    <span class="d2c_icon">
                                        <i class="fas fa-money-check-alt"></i>
                                    </span>
                                    <span>Reconcilation</span>
                                    <span class="fas fa-chevron-right ms-auto text-end"></span>
                                </a>
                                <!-- Child Sub Menu -->
                                <ul class="sub-menu collapse" id="reconcilation">
                                    <li class="nav-item">
                                        <a class="sub-menu-link" href="./pages/investment.html">
                                            <span>Reports</span>
                                        </a>
                                    </li>
                                </ul>
                                <!-- End:Child Sub Menu -->
                            </li>
                            <!-- End:Sub Menu Item -->



                            <!-- Sub Menu Item -->
                            <li class="nav-item <?php if ($page == "userDetails.php" || $page == "addUser.php") echo "active"; ?>">
                                <a class="sub-menu-link" href="userDetails">
                                    <span class="d2c_icon">
                                        <i class="fas fa-network-wired"></i>
                                    </span>
                                    <span>Users</span>
                                </a>
                            </li>
                            <!-- End:Sub Menu Item -->

                        </ul>
                        <!-- End:Sub Menu -->
                    </li>
                    <!-- End:Menu Item -->

                </ul>
            </div>
        </div>
        <!-- End:Menu -->

        <!-- Logout -->
        <div class="card d2c_single_menu mb-4">
            <div class="card-body p-0">
                <ul class="navbar-nav">
                    <!-- Item -->
                    <li class="nav-item">
                        <a class="nav-link" href="logout">
                            <span class="d2c_icon text-danger">
                                <i class="fas fa-sign-out-alt"></i>
                            </span>
                            <span>
                                Logout
                            </span>
                        </a>
                    </li>
                    <!-- End:Item -->
                </ul>
            </div>
        </div>
        <!-- End:Logout -->

        <!-- Theme Mode -->
        <div class="card d2c_switch_card">
            <div class="card-body p-0">
                <ul class="navbar-nav">
                    <!-- Item -->
                    <li class="nav-item d-flex align-items-center">
                        <span class="d2c_icon">
                            <i class="fas fa-moon"></i>
                        </span>
                        <span>Dark Mood</span>
                        <span class="form-switch d-flex ms-auto">
                            <input class="form-check-input" id="d2c_theme_changer" type="checkbox" role="switch">
                        </span>
                    </li>
                    <!-- End:Item -->
                </ul>
            </div>
        </div>
        <!-- End:Theme Mode -->
    </div>
</div>