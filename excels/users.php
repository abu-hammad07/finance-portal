<?php
session_start();
include_once ("../includes/config.php");
if (isset($_SESSION['login']) === true && $_SESSION['role'] === 'Admin') {
    $userID = $_SESSION['role'] === 'Admin';
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
                                    <th class="fs-4" colspan="14">Users Deatails</th>
                                </tr>
                                <tr>
                                    <th>S/NO</th>
                                    <th>Full Name</th>
                                    <th>Phone Number</th>
                                    <th>Date Of Birth</th>
                                    <th>Gender</th>
                                    <th>Address</th>
                                    <th>User Type</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Entry Date</th>
                                </tr>
                            </thead>
                            <tbody id="data-table">';

                                // Execute the query
                                $query = "SELECT users.username, users.email, role.name, users_detail.*
                                FROM  `users`
                                INNER JOIN `users_detail` ON `users_detail`.`users_detail_id` = `users`.`users_detail_id`
                                INNER JOIN `role` ON `role`.`role_id` = `users`.`role_id`";
                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) > 0) {
                                    $no = 1;
                                    while ($item = mysqli_fetch_assoc($result)) {
                                        $date = date('Y-m-d', strtotime($item['created_date']));
                                        $html .= '<tr>';
                                        $html .= '<td class="font">' . $no++ . '</td>';
                                        $html .= '<td>' . $item['full_name'] . '</td>';
                                        $html .= '<td>' . $item['Phone'] . '</td>';
                                        $html .= '<td>' . $item['date_of_birth'] . '</td>';
                                        $html .= '<td>' . $item['gender'] . '</td>';
                                        $html .= '<td>' . $item['address'] . '</td>';
                                        $html .= '<td>' . $item['name'] . '</td>';
                                        $html .= '<td>' . $item['email'] . '</td>';
                                        $html .= '<td>' . $item['username'] . '</td>';
                                        $html .= '<td>' . $date . '</td>';

                                        $html .= '</tr>';
                                    }
                                } else {
                                    $html .= '<tr><td class="text-danger" colspan="35">Data not found</td></tr>';
                                }

                                // Close the HTML table
                                $html .= '</tbody></table>';

                                // Set the appropriate headers for Excel download
                                header('Content-Type: application/vnd.ms-excel');
                                header('Content-Disposition: attachment; filename=User_Details.xls');
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