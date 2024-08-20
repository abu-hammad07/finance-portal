<?php
include_once('includes/config.php');
// ------------filter penalty-----------
function filter_penalty_data_In_Database($penaltyLimited, $penaltyMonth, $paymentPenaltySearch)
{
    global $conn;

    $month = date('m', strtotime($penaltyMonth));
    $year = date('Y', strtotime($penaltyMonth));

    $paymentPenaltySearch = mysqli_real_escape_string($conn, $paymentPenaltySearch);

    // Modify the query based on your database structure
    $query = "SELECT * FROM penalty";

    if (!empty($penaltyMonth)) {
        $query .= " WHERE month(created_date) = '$month' AND year(created_date) = '$year'";
    }
    if (!empty($paymentPenaltySearch)) {
        $query .= " WHERE payment_type LIKE '%$paymentPenaltySearch%'";
    }

    $query .= " ORDER BY id DESC LIMIT $penaltyLimited";

    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '

        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['penalty_type'] . '</td>
            <td>' . $row['penalty_cnic'] . '</td>
            <td>' . $row['penalty_charges'] . '</td>
            <td>' . $row['payment_type'] . '</td>
            <td>' . $row['created_date'] . '</td>
            <td>
                <div class="dropdown"><button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">Action</button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="penaltyEdit.php?penalty_edit_id=' . $row['id'] . '">Edit</a></li>
                        <li><a class="dropdown-item" href="?penalty_delete_id=' . $row['id'] . '">Delete</a></li>
                    </ul>
                </div>
            </td>
        </tr>
        
        ';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no penaltys data in the database. ' . $penaltyMonth . '</td>
                </tr>';
    }

    return $data;
}
// ------------search penalty-----------
function search_penalty_data_In_Database($penaltyTypeSearch, $paymentPenaltySearch, $penaltyLimited, $penaltyMonth)
{
    global $conn;

    $month = date('m', strtotime($penaltyMonth));
    $year = date('Y', strtotime($penaltyMonth));

    $penaltyTypeSearch = mysqli_real_escape_string($conn, $penaltyTypeSearch);
    $paymentPenaltySearch = mysqli_real_escape_string($conn, $paymentPenaltySearch);

    // Start the base query
    $query = "SELECT * FROM penalty";

    // Initialize conditions array
    $conditions = [];

    // Add conditions based on input parameters
    if (!empty($penaltyTypeSearch)) {
        $conditions[] = "penalty_type LIKE '%$penaltyTypeSearch%'";
    }
    if (!empty($paymentPenaltySearch)) {
        $conditions[] = "payment_type LIKE '%$paymentPenaltySearch%'";
    }
    if (!empty($penaltyMonth)) {
        $conditions[] = "month(created_date) = '$month' AND year(created_date) = '$year'";
    }

    // If there are any conditions, add them to the query
    if (count($conditions) > 0) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    // Add the ORDER BY and LIMIT clauses
    $query .= " ORDER BY id DESC LIMIT $penaltyLimited";

    // Execute the query
    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '

        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['penalty_type'] . '</td>
            <td>' . $row['penalty_cnic'] . '</td>
            <td>' . $row['penalty_charges'] . '</td>
            <td>' . $row['payment_type'] . '</td>
            <td>' . $row['created_date'] . '</td>
            <td>
                <div class="dropdown"><button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">Action</button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="penaltyEdit.php?penalty_edit_id=' . $row['id'] . '">Edit</a></li>
                        <li><a class="dropdown-item" href="?penalty_delete_id=' . $row['id'] . '">Delete</a></li>
                    </ul>
                </div>
            </td>
        </tr>
        
        ';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $penaltyTypeSearch . '</td>
                </tr>';
    }

    return $data;
}

// =======================
// ==========================maintenace===================
// =======================
// ------------filter penalty-----------
function filter_maintenace_data_In_Database($maintenaiceLimited, $maintenaceMonth, $paaymentTypeMaintSearch)
{
    global $conn;

    $month = date('m', strtotime($maintenaceMonth));
    $year = date('Y', strtotime($maintenaceMonth));

    $paaymentTypeMaintSearch = mysqli_real_escape_string($conn, $paaymentTypeMaintSearch);

    // Modify the query based on your database structure
    $query = "SELECT * FROM maintenance_payments";

    if (!empty($maintenaceMonth)) {
        $query .= " WHERE MONTH(added_on) = $month AND YEAR(added_on) = $year";
    }
    if (!empty($paaymentTypeMaintSearch)) {
        $query .= " WHERE payment_type LIKE '%$paaymentTypeMaintSearch%'";
    }


    $query .= " ORDER BY maintenance_id DESC LIMIT $maintenaiceLimited";

    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        // Start building the row for each maintenance payment record
        $data .= '
            <tr>
                <td>' . $count++ . '</td>';

        // Assuming $house_shop_id is a string of comma-separated IDs
        $house_shop_ids = explode(',', $row['house_shop_id']); // Convert the string of IDs to an array
        $shop_ids = explode(',', $row['shop_id']); // Convert the string of IDs to an array

        if ($row['house_or_shop'] == "house") {
            foreach ($house_shop_ids as $house_shop_id_main) {
                $house_shop_id_main = intval($house_shop_id_main); // Ensure it's an integer to prevent SQL injection
                $select = "SELECT house_number FROM houses WHERE house_id = $house_shop_id_main";
                $house_result = mysqli_query($conn, $select);

                if ($house_result && mysqli_num_rows($house_result) > 0) {
                    $house_row = mysqli_fetch_assoc($house_result);
                    $data .= '<td>' . htmlspecialchars($house_row['house_number']) . '</td>';
                } else {
                    $data .= '<td>House not found</td>';
                }
            }
        } elseif ($row['house_or_shop'] == "shop") {
            foreach ($shop_ids as $shop_id_main) {
                $shop_id_main = intval($shop_id_main); // Ensure it's an integer to prevent SQL injection
                $select = "SELECT shop_number FROM shops WHERE shop_id = $shop_id_main";
                $shop_result = mysqli_query($conn, $select);

                if ($shop_result && mysqli_num_rows($shop_result) > 0) {
                    $shop_row = mysqli_fetch_assoc($shop_result);
                    $data .= '<td>' . htmlspecialchars($shop_row['shop_number']) . '</td>';
                } else {
                    $data .= '<td>Shop not found</td>';
                }
            }
        }

        $data .= '
                <td>' . htmlspecialchars($row['house_or_shop']) . '</td>
                <td>' . htmlspecialchars($row['maintenance_month']) . '</td>
                <td>' . htmlspecialchars($row['maintenance_peyment']) . '</td>
                <td>' . htmlspecialchars($row['payment_type']) . '</td>
                <td>';
        if ($row["status"] == 'unpaid') {
            $data .= '  
                    <a href="maintenanceAdd.php?maintenance_add_id=' . htmlspecialchars($row['maintenance_id']) . '">
                        <span style="padding: 5px 10px; border-radius: 5px; color: white; background-color: red;">
                            ' . htmlspecialchars($row['status']) . '
                        </span>
                    </a>
                </td>';
        } else {
            $data .= '  
                        <span style="padding: 5px 10px; border-radius: 5px; color: white; background-color:  #00C161;">
                            ' . htmlspecialchars($row['status']) . '
                        </span>
                ';
        }
        $data .= '  
                <td>';
        if ($row['status'] != 'unpaid') {
            $data .= '
            <a class="d2c_danger_print_btn text-center justify-content-center text-decoration-none " style="color: red;" href="includes/pdf_maker?MAT_ID=' . $row['maintenance_id'] . '&ACTION=VIEW" target="_blank">
                <span><i class="fas fa-print mt-2"></i></span>
            </a>';
        }
        if ($row['status'] != 'unpaid') {
            $data .= '
         <td>
         <a href="MaintenanceEdit.php?MaintenanceEdit=' . htmlspecialchars($row['maintenance_id']) . '"  name="delete_penalty">
         <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deletepenalty' . htmlspecialchars($row['maintenance_id']) . '" data-bs-placement="top" title="Delete">
                      <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete">
                           <i class="fas fa-edit text-success p-1"></i>
                       </span>
                   </button></a>
         </td>
         ';
        }
        $data .= '   </tr>';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no penalty data in the database. ' . $maintenaceMonth . '</td>
                </tr>';
    }

    return $data;
}

function search_maintenance_data_in_database($houseShopNoSearch, $maintenanceLimit, $maintenanceMonth, $paaymentTypeMaintSearch)
{
    global $conn;

    $month = date('m', strtotime($maintenanceMonth));
    $year = date('Y', strtotime($maintenanceMonth));

    $houseShopNoSearch = mysqli_real_escape_string($conn, $houseShopNoSearch);
    $paaymentTypeMaintSearch = mysqli_real_escape_string($conn, $paaymentTypeMaintSearch);

    // Base query
    $query = "SELECT maintenance_payments.*, houses.house_number 
              FROM maintenance_payments
              LEFT JOIN houses ON maintenance_payments.house_shop_id = houses.house_id";

    $conditions = [];

    if (!empty($houseShopNoSearch)) {
        $conditions[] = "houses.house_number LIKE '%$houseShopNoSearch%'";
    }
    if (!empty($paaymentTypeMaintSearch)) {
        $conditions[] = "houses.payment_type LIKE '%$paaymentTypeMaintSearch%'";
    }
    if (!empty($maintenanceMonth)) {
        $conditions[] = "MONTH(added_on) = $month AND YEAR(added_on) = $year";
    }
    if (!empty($conditions)) {
        $query .= ' WHERE ' . implode(' AND ', $conditions);
    }

    $query .= " ORDER BY maintenance_id DESC LIMIT $maintenanceLimit";

    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        // Build the row for each maintenance payment record
        $data .= '
            <tr>
                <td>' . $count++ . '</td>';

        // Assuming $house_shop_id is a string of comma-separated IDs
        $house_shop_ids = explode(',', $row['house_shop_id']);
        $shop_ids = explode(',', $row['shop_id']);

        if ($row['house_or_shop'] == "house") {
            foreach ($house_shop_ids as $house_shop_id_main) {
                $house_shop_id_main = intval($house_shop_id_main);
                $select = "SELECT house_number FROM houses WHERE house_id = $house_shop_id_main";
                $house_result = mysqli_query($conn, $select);

                if ($house_result && mysqli_num_rows($house_result) > 0) {
                    $house_row = mysqli_fetch_assoc($house_result);
                    $data .= '<td>' . htmlspecialchars($house_row['house_number']) . '</td>';
                } else {
                    $data .= '<td>House not found</td>';
                }
            }
        } elseif ($row['house_or_shop'] == "shop") {
            foreach ($shop_ids as $shop_id_main) {
                $shop_id_main = intval($shop_id_main);
                $select = "SELECT shop_number FROM shops WHERE shop_id = $shop_id_main";
                $shop_result = mysqli_query($conn, $select);

                if ($shop_result && mysqli_num_rows($shop_result) > 0) {
                    $shop_row = mysqli_fetch_assoc($shop_result);
                    $data .= '<td>' . htmlspecialchars($shop_row['shop_number']) . '</td>';
                } else {
                    $data .= '<td>Shop not found</td>';
                }
            }
        }

        $data .= '
                <td>' . htmlspecialchars($row['house_or_shop']) . '</td>
                <td>' . htmlspecialchars($row['maintenance_month']) . '</td>
                <td>' . htmlspecialchars($row['maintenance_peyment']) . '</td>
                <td>' . htmlspecialchars($row['payment_type']) . '</td>
                <td>';

        if ($row["status"] == 'unpaid') {
            $data .= '  
                    <a href="maintenanceAdd.php?maintenance_add_id=' . htmlspecialchars($row['maintenance_id']) . '">
                        <span style="padding: 5px 10px; border-radius: 5px; color: white; background-color: red;">
                            ' . htmlspecialchars($row['status']) . '
                        </span>
                    </a>
                </td>';
        } else {
            $data .= '  
                        <span style="padding: 5px 10px; border-radius: 5px; color: white; background-color: #00C161;">
                            ' . htmlspecialchars($row['status']) . '
                        </span>
                ';
        }

        $data .= '</td>';

        if ($row['status'] != 'unpaid') {
            $data .= '
                <td>
                    <a class="d2c_danger_print_btn text-center justify-content-center text-decoration-none " style="color: red;" href="includes/pdf_maker?MAT_ID=' . $row['maintenance_id'] . '&ACTION=VIEW" target="_blank">
                        <span><i class="fas fa-print mt-2"></i></span>
                    </a>
                </td>';
        }
        if ($row['status'] != 'unpaid') {
            $data .= '
                <td>
                    <a href="MaintenanceEdit.php?MaintenanceEdit=' . htmlspecialchars($row['maintenance_id']) . '" name="delete_penalty">
                        <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deletepenalty' . htmlspecialchars($row['maintenance_id']) . '" data-bs-placement="top" title="Delete">
                            <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete">
                                <i class="fas fa-edit text-success p-1"></i>
                            </span>
                        </button>
                    </a>
                </td>';
        }

        $data .= '</tr>';
    }

    // If no data, show a warning message
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $houseShopNoSearch . '</td>
                </tr>';
    }

    return $data;
}


// ===============filter payroll====================

function filter_payroll_data_In_Database($payrollLimited, $payrollMonth)
{
    global $conn;

    $month = date('m', strtotime($payrollMonth));
    $year = date('Y', strtotime($payrollMonth));

    // Modify the query based on your database structure
    $query = "SELECT payroll.*, employees.employeeID, employees.employee_full_name
    FROM payroll
    LEFT JOIN employees ON payroll.employee_id = employees.employee_id";

    if (!empty($payrollMonth)) {
        $query .= " WHERE MONTH(payroll.added_on) = $month AND YEAR(payroll.added_on) = $year";
    }

    $query .= " ORDER BY employee_id DESC LIMIT $payrollLimited";

    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '
        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['employeeID'] . '</td>
            <td>' . $row['employee_full_name'] . '</td>
            <td>' . $row['days_present'] . '</td>
            <td>' . $row['days_absent'] . '</td>
            <td>' . $row['days_leave'] . '</td>
            <td>' . $row['month_year'] . '</td>
            <td>
                <a class="d2c_danger_print_btn text-center justify-content-center text-decoration-none text-danger" href="includes/pdf_maker?PAY_ID=' . $row['payroll_id'] . '&ACTION=VIEW">
                    <span><i class="fas fa-print mt-2"></i></span>
                </a>
            </td>
            <td>
                <div class="dropdown"><button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Action</button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="Payroll_edit.php?payroll_edit_id=' . $row['payroll_id'] . '">Edit</a></li>
                        <li><a class="dropdown-item" href="Payroll_view.php?payroll_view_id=' . $row['payroll_id'] . '">View</a></li>
                        <li><a class="dropdown-item" href="?Maintenance_delete_id=' . $row['payroll_id'] . '">Delete</a></li>
                    </ul>
                </div>
            </td>
        </tr>';
    }

    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no penaltys data in the database. ' . $payrollMonth . '</td>
                </tr>';
    }

    return $data;
}
// ------------search Payroll-----------
function search_payroll_data_In_Database($IDPayrollSearch, $namePayrollSearch, $payrollLimited, $payrollMonth)
{
    global $conn;

    $month = date('m', strtotime($payrollMonth));
    $year = date('Y', strtotime($payrollMonth));

    $IDPayrollSearch = mysqli_real_escape_string($conn, $IDPayrollSearch);
    $namePayrollSearch = mysqli_real_escape_string($conn, $namePayrollSearch);

    // Modify the query based on your database structure
    $query = "SELECT payroll.*, employees.employeeID, employees.employee_full_name
    FROM payroll
    LEFT JOIN employees ON payroll.employee_id = employees.employee_id";

    // empty search
    if (!empty($IDPayrollSearch)) {
        $query .= " WHERE employeeID LIKE '%$IDPayrollSearch%'";
    }
    if (!empty($namePayrollSearch)) {
        $query .= " WHERE employee_full_name LIKE '%$namePayrollSearch%'";
    }
    if (!empty($payrollMonth)) {
        $query .= " WHERE MONTH(payroll.added_on) = $month AND YEAR(payroll.added_on) = $year";
    }

    $query .= " ORDER BY employee_id DESC LIMIT $payrollLimited";

    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '
        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['employeeID'] . '</td>
            <td>' . $row['employee_full_name'] . '</td>
            <td>' . $row['days_present'] . '</td>
            <td>' . $row['days_absent'] . '</td>
            <td>' . $row['days_leave'] . '</td>
            <td>' . $row['month_year'] . '</td>
            <td>
                <a class="d2c_danger_print_btn text-center justify-content-center text-decoration-none text-danger" href="">
                    <span><i class="fas fa-print mt-2"></i></span>
                </a>
            </td>
            <td>
                <div class="dropdown"><button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Action</button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="Payroll_edit.php?payroll_edit_id=' . $row['payroll_id'] . '">Edit</a></li>
                        <li><a class="dropdown-item" href="Payroll_view.php?payroll_view_id=' . $row['payroll_id'] . '">View</a></li>
                        <li><a class="dropdown-item" href="?Maintenance_delete_id=' . $row['payroll_id'] . '">Delete</a></li>
                    </ul>
                </div>
            </td>
        </tr>';
    }

    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $IDPayrollSearch . '' . $namePayrollSearch . '</td>
                </tr>';
    }

    return $data;
}










if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // ------------filter penalty-----------
    if ($action == 'load-penalty-Data') {
        $penaltyLimited = $_POST['penaltyLimited'];
        $penaltyMonth = $_POST['penaltyMonth'];
        $paymentPenaltySearch = $_POST['paymentPenaltySearch'];

        $result = filter_penalty_data_In_Database($penaltyLimited, $penaltyMonth, $paymentPenaltySearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }
    // ------------ search filter penalty-----------
    if ($action == 'search-penalty-Data') {
        $penaltyTypeSearch = $_POST['penaltyTypeSearch'];
        $paymentPenaltySearch = $_POST['paymentPenaltySearch'];
        $penaltyLimited = $_POST['penaltyLimited'];
        $penaltyMonth = $_POST['penaltyMonth'];

        $result = search_penalty_data_In_Database($penaltyTypeSearch, $paymentPenaltySearch, $penaltyLimited, $penaltyMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // ------------filter maintenace-----------
    if ($action == 'load-maintenance-Data') {
        $maintenaiceLimited = $_POST['maintenaiceLimited'];
        $maintenaceMonth = $_POST['maintenaceMonth'];
        $paaymentTypeMaintSearch = $_POST['paaymentTypeMaintSearch'];

        $result = filter_maintenace_data_In_Database($maintenaiceLimited, $maintenaceMonth, $paaymentTypeMaintSearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }
    // ------------ search filter maintenace-----------
    if ($action == 'search-maintenance-Data') {
        $houseShopNoSearch = $_POST['houseShopNoSearch'];
        $maintenanceLimit = $_POST['maintenanceLimit'];
        $maintenanceMonth = $_POST['maintenanceMonth'];
        $paaymentTypeMaintSearch = $_POST['paaymentTypeMaintSearch'];

        $result = search_maintenance_data_in_database($houseShopNoSearch, $maintenanceLimit, $maintenanceMonth, $paaymentTypeMaintSearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // ------------filter payroll-----------
    if ($action == 'load-payroll-Data') {
        $payrollLimited = $_POST['payrollLimited'];
        $payrollMonth = $_POST['payrollMonth'];

        $result = filter_payroll_data_In_Database($payrollLimited, $payrollMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }
    // ------------ search filter payroll-----------
    if ($action == 'search-payroll-Data') {
        $IDPayrollSearch = $_POST['IDPayrollSearch'];
        $namePayrollSearch = $_POST['namePayrollSearch'];
        $payrollMonth = $_POST['payrollMonth'];
        $payrollLimited = $_POST['payrollLimited'];

        $result = search_payroll_data_In_Database($IDPayrollSearch, $namePayrollSearch, $payrollLimited, $payrollMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }
}
