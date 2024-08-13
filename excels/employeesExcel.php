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
                                    <th class="fs-4" colspan="14">Employee Deatails</th>
                                </tr>
                                <tr>
                                    <th>S/NO</th>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>CNIC</th>
                                    <th>Qualification</th>
                                    <th>Phone Number</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Appointment Date</th>
                                    <th>Employee Type</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Salary</th>
                                    <th>Entry Date</th>
                                </tr>
                            </thead>
                            <tbody id="data-table">';

                                // Execute the query
                                $query = "SELECT * FROM  `employees`";
                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) > 0) {
                                    $no = 1;
                                    while ($item = mysqli_fetch_assoc($result)) {
                                        $created_date = date('Y/F/d', strtotime($item['added_on']));
                                        $html .= '<tr>';
                                        $html .= '<td class="font">' . $no++ . '</td>';
                                        $html .= '<td>' . $item['employeeID'] . '</td>';
                                        $html .= '<td>' . $item['employee_full_name'] . '</td>';
                                        $html .= '<td>' . $item['employee_cnic'] . '</td>';
                                        $html .= '<td>' . $item['employee_qualification'] . '</td>';
                                        $html .= '<td>' . $item['employee_contact'] . '</td>';
                                        $html .= '<td>' . $item['employee_email'] . '</td>';
                                        $html .= '<td>' . $item['employee_address'] . '</td>';
                                        $html .= '<td>' . $item['appointment_date'] . '</td>';
                                        $html .= '<td>' . $item['employement_type'] . '</td>';
                                        $html .= '<td>' . $item['department'] . '</td>';
                                        $html .= '<td>' . $item['designation'] . '</td>';
                                        $html .= '<td>' . $item['salary'] . '</td>';
                                        $html .= '<td>' . $created_date . '</td>';

                                        $html .= '</tr>';
                                    }
                                } else {
                                    $html .= '<tr><td class="text-danger" colspan="35">Data not found</td></tr>';
                                }

                                // Close the HTML table
                                $html .= '</tbody></table>';

                                // Set the appropriate headers for Excel download
                                header('Content-Type: application/vnd.ms-excel');
                                header('Content-Disposition: attachment; filename=employees.xls');
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