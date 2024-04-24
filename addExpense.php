<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Add Expense Charges</title>
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
            <h4 class="mb-4 text-capitalize">Add Expense Charges</h4>
            <!-- End:Title -->

            <div class="card h-auto">
                <div class="card-body">
                    <form action="#">
                        <div class="row">
                        <div class="col-md-6 col-xl-4">
                                <div class="mb-4">
                                    <label class="form-label">House/Unit Number</label>
                                    <select id="Group" class="form-select form-control">
                                        <option selected>Select House Number</option>
                                    </select>
                                 </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="mb-4">
                                    <label class="form-label">Owner's Name</label>
                                    <input type="text" class="form-control" readonly required>
                                </div>
                            </div>
                           
                            <div class="col-md-6 col-xl-4">
                                <div class="mb-4">
                                    <label for="Group" class="form-label">Maintenance Period</label>
                                    <select id="Group" class="form-select form-control">
                                        <option selected>Monthly</option>
                                        <option>Quarterly</option>
                                        <option>Yearly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="mb-4">
                                    <label class="form-label">Maintenance Charges</label>
                                    <input type="number" class="form-control" placeholder="Enter Charges">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-4">
                                    <label class="form-label">Break Down of Charges</label><br>
                                    <input type="checkbox"><label for="" class="form-label">&nbsp Society Maintenance</label>
                                    <input type="checkbox"><label for="" class="form-label">&nbsp Security</label>
                                    <input type="checkbox"><label for="" class="form-label">&nbsp Electricity</label>
                                    <input type="checkbox"><label for="" class="form-label">&nbsp Water</label>
                                    <input type="checkbox"><label for="" class="form-label">&nbsp Gas</label>
                                    <input type="checkbox"><label for="" class="form-label">&nbsp Cleaning Services</label>
                                    <input type="checkbox"><label for="" class="form-label">&nbsp Repairs and Maintenance</label>
                                    
                                </div>
                            </div>
                          
                           
                            <div class="col-12">
                                <div class="mb-4">
                                    <label class="form-label">Additional Notes/Comments</label>
                                    <textarea cols="30" rows="4" class="form-control" placeholder="Write Additional Notes" required></textarea>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary">Add Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
