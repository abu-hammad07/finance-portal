<?php
session_start();
include_once ("includes/config.php");
include_once ("includes/function.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

deleteBookingEvents();
?>


<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Events Booking</h4>
    <!-- End:Title -->

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card card-body h-auto d2c_projects_datatable">
                <div class="row">
                    <div class="col-md-4 col-xl-3">
                        <form class="position-relative">
                            <input type="text" class="form-control product-search ps-5 word-spacing-2px"
                                id="eventsSearch" onkeyup="search_events_Data()" placeholder="Search &nbsp;..." />
                            <i class="fas fa-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                        </form>
                    </div>
                    <div class="col-md-8 col-xl-9 text-end">
                        <a href="addEventBooking" class="btn btn-primary"><i class="fas fa-plus"></i> Events Booking</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_updated_events'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_updated_events'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_updated_events']);
    }
    if (isset($_SESSION['error_updated_events'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_updated_events'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_updated_events']);
    }
    ?>
    <!-- / Alert -->


    <div class="row">
        <div class="col-lg-12">
            <div class="card h-auto d2c_projects_datatable">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-header">
                            Details
                        </h4>
                    </div>
                    <div class="col-md-6 text-end card-header">
                        <div class="btn-group">
                            <div class="me-2">
                                <input type="month" class="form-control" id="events-month"
                                    onchange="load_events_Data()">
                            </div>
                            <div class="me-2">
                                <select id="events-limit" class="form-control" onchange="load_events_Data()">
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="75">75</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <!-- <div class="me-2">
                                <select id="events-order" class="form-control" onchange="load_events_Data()">
                                    <option value="DESC">New</option>
                                    <option value="ASC">Old</option>
                                </select>
                            </div> -->
                            <div class="me-2">
                                <a class="d2c_pdf_btn text-center justify-content-center text-decoration-none text-primary"
                                    href="excels/eventsDetailsExcel">
                                    <span><i class="fas fa-file-pdf mt-2"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-responsive">
                        <table class="table" id="d2c_advanced_table_2">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Event Name</th>
                                    <th>Location</th>
                                    <th>Customer Name</th>
                                    <!-- <th>Customer CNIC</th> -->
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Booking Payment</th>
                                    <th>Payment Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="eventsDetails">
                                <!-- <tr>
                                            <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Events Booking data in the database.()</td>
                                        </tr> -->
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

<!-- Start: Footer -->
<?php include_once ('includes/footer.php'); ?>
<!-- End: Footer -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Load data on page load with default value (10)
        load_events_Data();

    });

    function load_events_Data() {

        let eventsLimited = $("#events-limit").val();
        // let eventsOrder = $("#events-order").val();
        let eventsMonth = $("#events-month").val();

        $.ajax({
            url: 'admin-index.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load-events_booking-Data',
                eventsLimited: eventsLimited,
                // eventsOrder: eventsOrder,
                eventsMonth: eventsMonth
            },
            success: function (response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#eventsDetails").html(response.data);
            },
        });
    }
</script>
<!-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Load data on page load with default value (10)
            search_events_Data();

        });

        function search_events_Data() {

            let eventsSearch = document.getElementById('eventsSearch').value;

            $.ajax({
                url: 'admin-index.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'search-events_booking-Data',
                    eventsSearch: eventsSearch
                },
                success: function(response) {
                    console.log(response);
                    // Update the result div with the loaded data
                    $("#eventsDetails").html(response.data);
                },
            });
        }
    </script> -->