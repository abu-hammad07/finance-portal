<?php
include_once ('includes/config.php');
// ------------filter penalty-----------
function filter_penalty_data_In_Database($penaltyLimited, $penaltyOrder, $penaltyMonth)
{
    global $conn;

    $month = date('m', strtotime($penaltyMonth));
    $year = date('Y', strtotime($penaltyMonth));

    // Modify the query based on your database structure
    $query = "SELECT * FROM penalty";

    if (!empty($penaltyMonth)) {
        $query .= " WHERE month(created_date) = '$month' AND year(created_date) = '$year'";
    }

    $query .= " ORDER BY id $penaltyOrder LIMIT $penaltyLimited";

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
                <a href="penaltyEdit.php?penalty_edit_id=' . $row['id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deletepenalty' . $row['id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash  text-danger p-1 "></i></span>
                </button>
                <div class="modal fade" id="deletepenalty' . $row['id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Name: <span class="text-danger">' . $row['id'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete your Incometion. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?penalty_delete_id=' . $row['id'] . '" class="btn btn-danger" name="delete_penalty">Delete</a>
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
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
function search_penalty_data_In_Database($penaltySearch)
{
    global $conn;

    $penaltySearch = mysqli_real_escape_string($conn, $penaltySearch);

    // Modify the query based on your database structure
    $query = "SELECT * From penalty";

    // empty search
    if (!empty($penaltySearch)) {
        $query .= " WHERE penalty_type LIKE '%" . $penaltySearch . "%' 
        OR penalty_cnic LIKE '%" . $penaltySearch . "%'";
    }

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
        <td>' . $row['created_date'] . '</td>
            <td>
            <a href="penaltyEdit.php?penalty_edit_id=' . $row['id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteIncome' . $row['id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash  text-danger p-1 "></i></span>
                </button>
                <div class="modal fade" id="deleteIncome' . $row['id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Name: <span class="text-danger">' . $row['id'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete your Incometion. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?penalty_delete_id=' . $row['id'] . '" class="btn btn-danger" name="delete_Income">Delete</a>
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        
        ';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $penaltySearch . '</td>
                </tr>';
    }

    return $data;
}

// =======================
// ==========================maintenace===================
// =======================
// ------------filter penalty-----------
function filter_maintenace_data_In_Database($maintenaiceLimited, $maintenaceOrder, $maintenaceMonth)
{
    global $conn;

    $month = date('m', strtotime($maintenaceMonth));
    $year = date('Y', strtotime($maintenaceMonth));

    // Modify the query based on your database structure
    $query = "SELECT * FROM maintenance_payments";

    if (!empty($maintenaceMonth)) {
        $query .= " WHERE MONTH(added_on) = $month AND YEAR(added_on) = $year";
    }

    $query .= " ORDER BY maintenance_id $maintenaceOrder LIMIT $maintenaiceLimited";

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
                <td>
                    <a href="maintenanceAdd.php?maintenance_add_id=' . htmlspecialchars($row['maintenance_id']) . '">
                        <span style="padding: 5px 10px; border-radius: 5px; color: white; background-color: ' . ($row['status'] == 'unpaid' ? 'lightcoral' : 'lightgreen') . ';">
                            ' . htmlspecialchars($row['status']) . '
                        </span>
                    </a>
                </td>
                <td>';
        if ($row['status'] != 'unpaid') {
            $data .= '
            <a class="d2c_danger_print_btn text-center justify-content-center text-decoration-none text-danger" href="includes/pdf_maker?MAT_ID=' . $row['maintenance_id'] . '&ACTION=VIEW" target="_blank">
                <span><i class="fas fa-print mt-2"></i></span>
            </a>';
        }
        $data .= '    
                <td>
                    <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deletepenalty' . htmlspecialchars($row['maintenance_id']) . '" data-bs-placement="top" title="Delete">
                        <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete">
                            <i class="fas fa-trash text-danger p-1"></i>
                        </span>
                    </button>
                    <div class="modal fade" id="deletepenalty' . htmlspecialchars($row['maintenance_id']) . '" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? ID: <span class="text-danger">' . htmlspecialchars($row['maintenance_id']) . '</span></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-start">
                                    <p>Please confirm that you want to delete your entry. <br>
                                        Once deleted, you won\'t be able to recover it. <br>
                                        Please proceed with caution.
                                    </p>
                                </div>
                                <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                    <a href="?Maintenance_delete_id=' . htmlspecialchars($row['maintenance_id']) . '" class="btn btn-danger" name="delete_penalty">Delete</a>
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no penalty data in the database. ' . $maintenaceMonth . '</td>
                </tr>';
    }

    return $data;
}

// ------------search penalty-----------
function search_maintenace_data_In_Database($manitenaceSearch)
{
    global $conn;

    // Modify the query based on your database structure
    $query = "SELECT * From maintenance_payments";

    // empty search
    if (!empty($manitenaceSearch)) {
        $query .= " WHERE  house_shop_id LIKE '%" . $manitenaceSearch . "%'
        OR house_or_shop LIKE '%" . $manitenaceSearch . "%'
        OR maintenance_month LIKE '%" . $manitenaceSearch . "%'
        ";
    }

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
            foreach ($house_shop_ids as $shop_id_main) {
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
                <td>
                    <a href="maintenanceAdd.php?maintenance_add_id=' . htmlspecialchars($row['maintenance_id']) . '">
                        <span style="padding: 5px 10px; border-radius: 5px; color: white; background-color: ' . ($row['status'] == 'unpaid' ? 'lightcoral' : 'lightgreen') . ';">
                            ' . htmlspecialchars($row['status']) . '
                        </span>
                    </a>
                </td>
                <td>
                    <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deletepenalty' . htmlspecialchars($row['maintenance_id']) . '" data-bs-placement="top" title="Delete">
                        <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete">
                            <i class="fas fa-trash text-danger p-1"></i>
                        </span>
                    </button>
                    <div class="modal fade" id="deletepenalty' . htmlspecialchars($row['maintenance_id']) . '" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? ID: <span class="text-danger">' . htmlspecialchars($row['maintenance_id']) . '</span></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-start">
                                    <p>Please confirm that you want to delete your entry. <br>
                                        Once deleted, you won\'t be able to recover it. <br>
                                        Please proceed with caution.
                                    </p>
                                </div>
                                <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                    <a href="?Maintenance_delete_id=' . htmlspecialchars($row['maintenance_id']) . '" class="btn btn-danger" name="delete_penalty">Delete</a>
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        ';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $manitenaceSearch . '</td>
                </tr>';
    }

    return $data;
}

// ===============filter payroll====================

function filter_payroll_data_In_Database($payrollLimited, $payrollOrder, $payrollMonth)
{
    global $conn;

    $month = date('m', strtotime($payrollMonth));
    $year = date('Y', strtotime($payrollMonth));

    // Modify the query based on your database structure
    $query = "SELECT * FROM payroll";

    if (!empty($payrollMonth)) {
        $query .= " WHERE MONTH(added_on) = $month AND YEAR(added_on) = $year";
    }

    $query .= " ORDER BY employee_id  $payrollOrder LIMIT $payrollLimited";

    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '
        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['employee_id'] . '</td>
            <td>';

        // Split the employee_id field to get multiple IDs
        $payroll_names = explode(',', $row['employee_id']);
        foreach ($payroll_names as $payroll_name) {
            $seql_dep = mysqli_query($conn, "SELECT * FROM `employees` WHERE `employee_id` ='$payroll_name'");
            $dep = mysqli_fetch_object($seql_dep);
            if ($dep) {
                $data .= $dep->employee_full_name . ' ';
            }
        }

        $data .= '</td>
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
                <a href="Payroll_edit.php?payroll_edit_id=' . $row['payroll_id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <a href="Payroll_view.php?payroll_view_id=' . $row['payroll_id'] . '">
                <span>
                    <i class="fas fa-eye me-1 text-success"></i>
                </span>
            </a>
                <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deletepenalty' . $row['payroll_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash text-danger p-1"></i></span>
                </button>
                <div class="modal fade" id="deletepenalty' . $row['payroll_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Name: <span class="text-danger">' . $row['payroll_id'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete your entry. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?Maintenance_delete_id=' . $row['payroll_id'] . '" class="btn btn-danger" name="delete_penalty">Delete</a>
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
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
function search_payroll_data_In_Database($penaltySearch)
{
    global $conn;

    $penaltySearch = mysqli_real_escape_string($conn, $penaltySearch);

    // Modify the query based on your database structure
    $query = "SELECT * From payroll";

    // empty search
    if (!empty($penaltySearch)) {
        $query .= " WHERE employee_id LIKE '%" . $penaltySearch . "%' 
        OR month_year LIKE '%" . $penaltySearch . "%'
        ";
    }

    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '
        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['employee_id'] . '</td>
            <td>';

        // Split the employee_id field to get multiple IDs
        $payroll_names = explode(',', $row['employee_id']);
        foreach ($payroll_names as $payroll_name) {
            $seql_dep = mysqli_query($conn, "SELECT * FROM `employees` WHERE `employee_id` ='$payroll_name'");
            $dep = mysqli_fetch_object($seql_dep);
            if ($dep) {
                $data .= $dep->employee_full_name . ' ';
            }
        }

        $data .= '</td>
            <td>' . $row['days_present'] . '</td>
            <td>' . $row['days_absent'] . '</td>
            <td>' . $row['days_leave'] . '</td>
            <td>' . $row['month_year'] . '</td>
            <td>
                <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deletepenalty" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete" class="bg-danger p-1 text-white rounded">Print</span>
                </button>
            </td>
            <td>
                <a href="Payroll_edit.php?payroll_edit_id=' . $row['payroll_id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <a href="Payroll_view.php?payroll_view_id=' . $row['payroll_id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deletepenalty' . $row['payroll_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash text-danger p-1"></i></span>
                </button>
                <div class="modal fade" id="deletepenalty' . $row['payroll_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Name: <span class="text-danger">' . $row['payroll_id'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete your entry. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?payroll_id=' . $row['payroll_id'] . '" class="btn btn-danger" name="delete_penalty">Delete</a>
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>';
    }

    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $penaltySearch . '</td>
                </tr>';
    }

    return $data;
}










if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // ------------filter penalty-----------
    if ($action == 'load-penalty-Data') {
        $penaltyLimited = $_POST['penaltyLimited'];
        $penaltyOrder = $_POST['penaltyOrder'];
        $penaltyMonth = $_POST['penaltyMonth'];

        $result = filter_penalty_data_In_Database($penaltyLimited, $penaltyOrder, $penaltyMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }
    // ------------ search filter penalty-----------
    if ($action == 'search-penalty-Data') {
        $penaltySearch = $_POST['penaltySearch'];

        $result = search_penalty_data_In_Database($penaltySearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // ------------filter maintenace-----------
    if ($action == 'load-maintenance-Data') {
        $maintenaiceLimited = $_POST['maintenaiceLimited'];
        $maintenaceOrder = $_POST['maintenaceOrder'];
        $maintenaceMonth = $_POST['maintenaceMonth'];

        $result = filter_maintenace_data_In_Database($maintenaiceLimited, $maintenaceOrder, $maintenaceMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }
    // ------------ search filter maintenace-----------
    if ($action == 'search-maintenance-Data') {
        $manitenaceSearch = $_POST['maintenaceSearch'];

        $result = search_maintenace_data_In_Database($manitenaceSearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // ------------filter payroll-----------
    if ($action == 'load-payroll-Data') {
        $payrollLimited = $_POST['payrollLimited'];
        $payrollOrder = $_POST['payrollOrder'];
        $payrollMonth = $_POST['payrollMonth'];

        $result = filter_payroll_data_In_Database($payrollLimited, $payrollOrder, $payrollMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }
    // ------------ search filter payroll-----------
    if ($action == 'search-payroll-Data') {
        $payrollSearch = $_POST['payrollSearch'];

        $result = search_payroll_data_In_Database($payrollSearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }
}
