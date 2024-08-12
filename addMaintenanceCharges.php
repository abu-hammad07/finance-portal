<?php
session_start();
include_once("includes/config.php");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
?>


        <!-- Main sidebar -->
        <?php
        include("includes/sidebar.php");
       ?>
        <!-- End:Sidebar -->

        <!-- Main Body-->
        <div class="d2c_main p-4 ps-lg-3">

            <!-- Title -->
            <h4 class="mb-4 text-capitalize">Add Maintenance Charges</h4>
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

<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->