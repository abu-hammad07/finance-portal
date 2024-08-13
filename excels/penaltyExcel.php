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
                                    <th class="fs-4" colspan="14">Penalty Deatails</th>
                                </tr>
                                <tr>
                                   <th>S.No</th>
                                    <th>Penalty type</th>
                                    <th>Penalty CNIC</th>
                                    <th>Penalty Charges</th>
                                    <th>Payment Type</th>
                                    <th>Penalty Date</th>   
                                </tr>
                            </thead>
                            <tbody id="data-table">';

                                // Execute the query
                                $query = "SELECT * FROM  `penalty` ";
                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) > 0) {
                                    $no = 1;
                                    while ($item = mysqli_fetch_assoc($result)) {
                                        $html .= '<tr>';
                                        $html .= '<td class="font">' . $no++ . '</td>';
                                        $html .= '<td>' . $item['penalty_type'] . '</td>';
                                        $html .= '<td>' . $item['penalty_cnic'] . '</td>';
                                        $html .= '<td>' . $item['penalty_charges'] . '</td>';
                                        $html .= '<td>' . $item['payment_type'] . '</td>';
                                        $html .= '<td>' . $item['created_date'] . '</td>';
                                        $html .= '</tr>';
                                    }
                                } else {
                                    $html .= '<tr><td class="text-danger" colspan="35">Data not found</td></tr>';
                                }

                                // Close the HTML table
                                $html .= '</tbody></table>';

                                // Set the appropriate headers for Excel download
                                header('Content-Type: application/vnd.ms-excel');
                                header('Content-Disposition: attachment; filename=penalty_Details.xls');
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