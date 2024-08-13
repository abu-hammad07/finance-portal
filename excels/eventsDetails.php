<?php
session_start();
include_once("../includes/config.php");
if (isset($_SESSION['login']) === true && $_SESSION['role'] === 'Admin') {
    $userID =   $_SESSION['role'] === 'Admin';
?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <form action="add_company_code.php" method="post">
                <div class="row my-5">
                    <div class="col-lg-12 ">
                        <div class="card">
                            <div class="dov ">
                                <?php
                                // Create a table in HTML and set it as a variable
                                $html = '<table class="contain-table" >
            <thead>
                <tr>
                    <th class="fs-4" colspan="14">Event  Deatails</th>
                </tr>
                <tr>
                      <th>S/NO</th>
                                    <th>Event Name</th>
                                    <th>Location</th>
                                    <th>Date Time</th>
                                    <th>start Timing</th>
                                    <th>end Timing</th>
                                    <th>noOf Persons</th>
                                    <th>event Type</th>
                                    <th>customer Cnic</th>
                                    <th>customer Contact</th>
                                    <th>customer Name</th>
                                    <th>Booking Payment</th>
                                    <th>Payment type</th>
                                  
                </tr>
            </thead>
            <tbody id="data-table">';

                                // Execute the query
                                $query = "SELECT * FROM  `events_booking` ";
                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) > 0) {
                                    $no = 1;
                                    while ($item = mysqli_fetch_assoc($result)) {
                                        $html .= '<tr>';
                                        $html .= '<td class="font">' . $no++ . '</td>';
                                        $html .= '<td>' . $item['eventName'] . '</td>';
                                        $html .= '<td>' . $item['location'] . '</td>';
                                        $html .= '<td>' . $item['date'] . '</td>';
                                        $html .= '<td>' . $item['startTiming'] . '</td>';
                                        $html .= '<td>' . $item['endTiming'] . '</td>';
                                        $html .= '<td>' . $item['noOfPersons'] . '</td>';
                                        $html .= '<td>' . $item['eventType'] . '</td>';
                                        $html .= '<td>' . $item['customerCnic'] . '</td>';
                                        $html .= '<td>' . $item['customerContact'] . '</td>';
                                        $html .= '<td>' . $item['customerName'] . '</td>';
                                        $html .= '<td>' . $item['bookingPayment'] . '</td>';
                                        $html .= '<td>' . $item['payment_type'] . '</td>';

                                        $html .= '</tr>';
                                    }
                                } else {
                                    $html .= '<tr><td class="text-danger" colspan="35">Data not found</td></tr>';
                                }

                                // Close the HTML table
                                $html .= '</tbody></table>';

                                // Set the appropriate headers for Excel download
                                header('Content-Type: application/vnd.ms-excel');
                                header('Content-Disposition: attachment; filename=Event_Details.xls');
                                echo $html;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    <?php
} else {
    header('location:../login.php ');
    exit;
}
    ?>