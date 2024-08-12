<?php
session_start();
include_once ("includes/config.php");
include "includes/function.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
updateHouse();
?>

<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">View House</h4>
    <!-- End:Title -->

    <?php
    if (isset($_GET['house_view_id'])) {
        $edit_id = mysqli_real_escape_string($conn, $_GET['house_view_id']);
        $edit_query = "SELECT * FROM houses WHERE house_id = '$edit_id'";
        $edit_result = mysqli_query($conn, $edit_query);

        if (mysqli_num_rows($edit_result) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_assoc($edit_result)) {
                ?>
                <form action="" method="post" id="add_houses_form">
                    <div class="card h-auto">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <h3 class="card-header">Information</h3>
                                </div>
                                <div class="col-md-9">
                                    <!-- ====print icon===== -->
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary" onclick="printContent()"><i
                                                class="fas fa-print"></i></button>
                                    </div>

                                </div>
                            </div>
                            <hr class="my-4">
                            <div class="row g-3">
                                <input type="text" hidden name="house_id" value="<?= $row['house_id'] ?>">
                                <div class="col-md-6">
                                    <label class="form-label">House/Unit Number</label>
                                    <input type="number" readonly name="house-number" class="form-control"
                                        placeholder="Enter House/Unit Number" required value="<?= $row['house_number'] ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Owner's Name</label>
                                    <input type="text" readonly name="owner-name" class="form-control"
                                        placeholder="Enter Owner's Name" required value="<?= $row['owner_name'] ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Owner's Contact</label>
                                    <input type="number" readonly name="owner-contact" class="form-control"
                                        placeholder="Enter Owner's Contact Information" required
                                        value="<?= $row['owner_contact'] ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Owner's CINC</label>
                                    <input type="number" readonly name="owner-cinc" class="form-control"
                                        placeholder="XXXXX-XXXXXXX-X" value="<?= $row['owner_cnic'] ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="owner" class="form-label">Occupancy Status</label>
                                    <select id="owner" name="occupance-status" class="form-select form-control">
                                        <option value="<?= $row['occupancy_status'] ?>"><?= $row['occupancy_status'] ?></option>
                                    </select>
                                </div>
                                <div class="col-md-6 ">
                                    <label for="floor" class="form-label">Floor</label>
                                    <select id="floor" name="floor" class="form-select form-control">
                                        <option value="<?= $row['floor'] ?>"><?= $row['floor'] ?></option>
                                    </select>
                                </div>
                                <div class="col-md-6 ">
                                    <label for="property-type" class="form-label">Type of Property</label>
                                    <select id="property-type" name="property-type" class="form-select form-control">
                                        <option value="<?= $row['property_type'] ?>"><?= $row['property_type'] ?></option>
                                    </select>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Size/Area of the Property</label>
                                    <select id="size" name="property-size" class="form-select form-control">
                                        <option value="<?= $row['property_size'] ?>"><?= $row['property_size'] ?></option>
                                    </select>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Monthly Maintenance Fee</label>
                                    <input name="maintenance-charges" readonly type="number" class="form-control"
                                        placeholder="Enter Monthly Maintenance Fee" required
                                        value="<?= $row['maintenance_charges'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- submit btn -->
                    <div class="mt-3">
                        <a href="houses" class="btn btn-danger">Back</a>
                    </div>
                </form>
                <!-- -------------Print----------- -->
                <div class="content-wrapper" hidden id="printable-content">
                    <link rel="preconnect" href="https://fonts.googleapis.com">
                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
                        rel="stylesheet">
                    <style>
                        body {
                            font-family: 'Montserrat', sans-serif;
                            margin: 0;
                            padding: 0;
                            background-color: #f4f4f4;
                            max-width: 100vw;
                            /* Ensure body does not exceed viewport width */
                        }

                        .container {
                            margin: 0;
                            padding: 0;
                            max-width: 100vw;
                            /* Ensure container does not exceed viewport width */
                            padding: 10px;
                            /* Optional: Add some padding for better spacing */
                        }

                        .header {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            margin-bottom: 20px;
                        }

                        .header img {
                            max-width: 150px;
                        }

                        .header h3 {
                            margin: 0;
                            font-weight: 500;
                            color: #333;
                            flex: 1;
                            font-size: 20px;
                            text-align: center;
                        }

                        .contact-info {
                            font-size: 0.9em;
                            color: #555;
                            text-align: right;
                        }

                        .invoice-title {
                            font-size: 1.2em;
                            font-weight: 700;
                            color: white;
                            margin: 20px 0;
                            padding: 5px;
                            text-align: center;
                            background-color: #04bd62;
                        }

                        .terms {
                            margin-bottom: 20px;
                            font-size: 0.9em;
                            color: #777;
                        }

                        .bold {
                            font-weight: 800;
                        }

                        .table_div {
                            display: flex;
                            justify-content: space-between;
                            align-items: flex-start;
                            width: 100%;
                        }

                        .table_div>div {
                            width: 48%;
                            padding: 10px;
                        }

                        .footer {
                            text-align: center;
                            margin-top: 20px;
                            font-size: 0.9em;
                            color: #777;
                        }

                        /* Print-specific styles */
                        @media print {
                            .invoice-title {
                                -webkit-print-color-adjust: exact;
                                /* Ensures the background color is printed */
                            }
                        }
                    </style>
                    <div class="container">
                        <div class="header">
                            <img src="./assets/images/logo/KDA.png" alt="KDA Logo">
                            <h3>KDA Officers Co-Operative Housing Society Residents Welfare Association</h3>
                            <div class="contact-info">
                                <p><span class="bold">Email:</span> info@kda.com</p>
                                <p><span class="bold">Phone:</span> 123-456-7890</p>
                                <p><span class="bold">Website:</span> www.kda.com</p>
                            </div>
                        </div>

                        <div class="terms">
                            <h4>Terms and Conditions</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque euismod orci ut et lobortis.
                                Suspendisse potenti.</p>
                        </div>

                        <div class="main-content">
                            <h2 class="invoice-title">Property Details</h2>
                            <div class="table_div">
                                <div>
                                    <p><span>House/Unit Number:</span><?= $row['house_number'] ?></p>
                                    <p><span>Owner's Name:</span><?= $row['owner_name'] ?></p>
                                    <p><span>Owner's Contact Number: </span><?= $row['owner_contact'] ?></p>
                                    <p><span>Owner's CNIC: </span><?= $row['owner_cnic'] ?></p>
                                    <p><span>Occupancy Status: </span><?= $row['occupancy_status'] ?></p>
                                </div>
                                <div>
                                    <p><span>Floor: </span><?= $row['property_size'] ?></p>
                                    <p><span>Type of Property: </span><?= $row['property_size'] ?></p>
                                    <p><span>Size/Area of the Property: </span><?= $row['property_type'] ?></p>
                                    <p><span>Monthly Maintenance Fee: </span><?= $row['maintenance_charges'] ?></p>
                                    <p><span>Maintenance Date: </span><?= $row['added_on'] ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <p>Thank you for your cooperation.</p>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    No House Found.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    }
    ?>
</div>
<!-- End:Main Body -->
</div>

<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->
 
<script>
    function printContent() {
        var printWindow = window.open('', '', 'height=400,width=600');
        printWindow.document.write('<html><head><title>KDA Officers</title>');
        // Include Bootstrap CSS
        printWindow.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">');
        printWindow.document.write('</head><body>');
        printWindow.document.write(document.getElementById('printable-content').innerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();

        printWindow.onload = function () {
            printWindow.print();
        };
    }
</script>
