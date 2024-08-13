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
                                    <th class="fs-4" colspan="14">Payroll Deatails</th>
                                </tr>
                                <tr>
                                    <th>S/NO</th>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Employee Salary</th>
                                    <th>Salary Month</th>
                                    <th>Total Working Days</th>
                                    <th>Absent Days</th>
                                    <th>Leave Days</th>
                                    <th>Total Salary</th>
                                    <th>Entry Date</th>
                                </tr>
                            </thead>
                            <tbody id="data-table">';

                                // Execute the query
                                $query = "SELECT employees.employeeID, employees.employee_full_name, employees.salary, payroll.*
                                FROM  `payroll`
                                INNER JOIN `employees` ON `employees`.`employee_id` = `payroll`.`employee_id`";
                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) > 0) {
                                    $no = 1;
                                    while ($item = mysqli_fetch_assoc($result)) {
                                        $salaryMonth = date('Y/F', strtotime($item['month_year']));
                                        $created_date = date('Y/F/d', strtotime($item['added_on']));
                                        $html .= '<tr>';
                                        $html .= '<td class="font">' . $no++ . '</td>';
                                        $html .= '<td>' . $item['employeeID'] . '</td>';
                                        $html .= '<td>' . $item['employee_full_name'] . '</td>';
                                        $html .= '<td>' . $item['salary'] . '</td>';
                                        $html .= '<td>' . $salaryMonth . '</td>';
                                        $html .= '<td>' . $item['days_present'] . '</td>';
                                        $html .= '<td>' . $item['days_absent'] . '</td>';
                                        $html .= '<td>' . $item['days_leave'] . '</td>';
                                        $html .= '<td>' . $item['total_salary'] . '</td>';
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
                                header('Content-Disposition: attachment; filename=payroll.xls');
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