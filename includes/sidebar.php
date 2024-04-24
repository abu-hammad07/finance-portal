<?php
$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);


$select = mysqli_query($conn, "SELECT users_detail.image, users_detail.full_name, role.name as role FROM `users`
LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
LEFT JOIN role ON role.role_id = users.role_id
WHERE users.user_id = '{$_SESSION['UID']}'");

$row = mysqli_fetch_assoc($select);
?>

<div class="d2c_sidebar offcanvas-lg offcanvas-start p-4 pe-lg-2" tabindex="-1" id="d2c_sidebar">
    <div class="d-flex flex-column">
        <!-- Logo -->
        <a href="./index.php" class="mb-5 brand-icon">
            <img class="navbar-brand" src="./assets/images/logo/logo.png" alt="logo">
        </a>
        <!-- End:Logo -->

        <!-- Profile -->
        <div class="card d2c_profile_card text-center mb-4">
            <!-- Profile Image -->
            <a href="./pages/elements/profile.html">
                <img class="rounded-circle d2c_profile_image position-absolute top-0 start-50 translate-middle mb-2" src="./media/images/<?= $row['image']; ?>" alt="d2c Profile Image">
            </a>
            <!-- End:Profile Image-->

            <div class="card-body mt-4">
                <h6 class="fw-bold mb-3"><?= $row['full_name']; ?></h6>
                <span class="d2c_role"><?= $row['role']; ?></span>
                <ul class="list-inline">
                    <!-- Profile -->
                    <li class="list-inline-item position-relative me-3">
                        <a class="dropdown-item d-flex align-items-center py-2" href="./pages/elements/profile.html">
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
                        <a class="nav-link" href="#">
                            <span>Menu</span>
                        </a>
                        <!-- Sub Menu -->
                        <ul class="sub-menu collapse show">
                            <!-- Sub Menu Item -->
                            <li class="nav-item">
                                <a class="sub-menu-link" href="./index.php">
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
                            <li class="nav-item">
                                <a class="sub-menu-link" href="./houses.php">
                                    <span class="d2c_icon">
                                        <i class="fas fa-money-check-alt"></i>
                                    </span>
                                    <span>
                                        Society Houses

                                    </span>
                                </a>
                            </li>
                            <!-- End:Sub Menu Item -->

                            <!-- Sub Menu Item -->
                            <li class="nav-item">
                                <a class="sub-menu-link" href="./expense.php">
                                    <span class="d2c_icon">
                                        <i class="fas fa-money-check-alt"></i>
                                    </span>
                                    <span>
                                        Expenses
                                    </span>
                                </a>
                            </li>
                            <!-- End:Sub Menu Item -->

                            <!-- Sub Menu Item -->
                            <li class="nav-item">
                                <a class="sub-menu-link" href="./maintenanceCharges.php">
                                    <span class="d2c_icon">
                                        <i class="fas fa-money-check-alt"></i>
                                    </span>
                                    <span>
                                        Maintenance Charges
                                    </span>
                                </a>
                            </li>
                            <!-- End:Sub Menu Item -->

                            <!-- Sub Menu Item -->
                            <li class="nav-item">
                                <a class="sub-menu-link" href="./pages/transaction.html">
                                    <span class="d2c_icon">
                                        <i class="fas fa-list-alt"></i>
                                    </span>
                                    <span>
                                        Penalty Charges
                                    </span>
                                </a>
                            </li>
                            <!-- End:Sub Menu Item -->

                            <!-- Sub Menu Item -->
                            <li class="nav-item">
                                <a class="sub-menu-link" href="./pages/wallet.html">
                                    <span class="d2c_icon">
                                        <i class="fas fa-wallet"></i>
                                    </span>
                                    <span>
                                        Event Booking
                                    </span>
                                </a>
                            </li>
                            <!-- End:Sub Menu Item -->

                            <!-- Sub Menu Item -->
                            <li class="nav-item">
                                <a class="sub-menu-link" href="./pages/investment.html">
                                    <span class="d2c_icon">
                                        <i class="fas fa-network-wired"></i>
                                    </span>
                                    <span>
                                        Reconcilation Reports
                                    </span>
                                </a>
                            </li>
                            <!-- End:Sub Menu Item -->

                            <!-- Sub Menu Item -->
                            <li class="nav-item <?php if ($page == "userDetails.php" || $page == "addUser.php") echo "active"; ?>">
                                <a class="sub-menu-link" href="userDetails">
                                    <span class="d2c_icon">
                                        <i class="fas fa-network-wired"></i>
                                    </span>
                                    <span>
                                        Users

                                    </span>
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