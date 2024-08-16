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
                    <th class="fs-4" colspan="14">Maintenance Deatails</th>
                </tr>
                <tr>
                                   <th>S.No</th>
                                     <th>House / Shop Number</th>
                                    <th>House/Shop</th>
                                    <th>Owner/Tenant Name</th>
                                    <th>Owner/Tenant Contact</th>
                                    <th>Maintenance Paid Date </th>
                                    <th>Amount Paid</th>
                                    <th>Payment Type</th>
                                    <th>Status</th>          
                </tr>
            </thead>
            <tbody id="data-table">';

                                // Execute the query
                                $query = "SELECT * FROM  `maintenance_payments` ";
                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) > 0) {
                                    $no = 1;
                                    while ($item = mysqli_fetch_assoc($result)) {
                                        $html .= '<tr>';
                                        $html .= '<td class="font">' . $no++ . '</td>';

                                        $house_shop_ids = explode(',', $item['house_shop_id']);
                                        foreach ($house_shop_ids as $house_shop_id) {
                                            $seql_dep = mysqli_query($conn, "SELECT * FROM `houses` WHERE `house_id` ='$house_shop_id'");
                                            $dep = mysqli_fetch_object($seql_dep);
                                            if ($dep) {
                                                $_SESSION['house_number'] = $dep->house_number;
                                                $_SESSION['owner_name'] = $dep->owner_name;
                                                $_SESSION['owner_contact'] = $dep->owner_contact;
                                            }
                                        }
                                        $html .= '<td>' . $_SESSION['house_number'] . '</td>';
                                        $html .= '<td>' . $item['house_or_shop'] . '</td>';
                                        $html .= '<td>' . $_SESSION['owner_name'] . '</td>';
                                        $html .= '<td>' . $_SESSION['owner_contact'] . '</td>';



                                        $html .= '<td>' . $item['added_on'] . '</td>';
                                        $html .= '<td>' . $item['maintenance_peyment'] . '</td>';
                                        $html .= '<td>' . $item['payment_type'] . '</td>';
                                        $html .= '<td>' . $item['status'] . '</td>';
                                        $html .= '</tr>';
                                    }
                                } else {
                                    $html .= '<tr><td class="text-danger" colspan="35">Data not found</td></tr>';
                                }

                                // Close the HTML table
                                $html .= '</tbody></table>';

                                // Set the appropriate headers for Excel download
                                header('Content-Type: application/vnd.ms-excel');
                                header('Content-Disposition: attachment; filename=maintenance_Details.xls');
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