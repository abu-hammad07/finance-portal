<?php
include_once('includes/config.php');
require_once('includes/phpqrcode/qrlib.php');


// Feature Function to filter and display data in the table based on user input or database data depending on your database structure and requirements  

function filter_user_data_In_Database($userLimited, $userOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $query = "SELECT users.user_id, users.username, users.email, users.status, users_detail.Phone, role.name as role 
    FROM users
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    LEFT JOIN role ON role.role_id = users.role_id
    ORDER BY users.user_id $userOrder LIMIT $userLimited;
    ";
    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {

        $data .= '

        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['username'] . '</td>
            <td>' . $row['email'] . '</td>
            <td>' . $row['Phone'] . '</td>
            <td>' . $row['role'] . '</td>
            <td>' . $row['status'] . '</td>
            <td>
                <a href="userEdit.php?user_edit_id=' . $row['user_id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <a class="" href="userView.php?user_view_id=' . $row['user_id'] . '">
                    <i class="fas fa-eye me-1 text-info"></i>
                </a>
                <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteUsers' . $row['user_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash  text-danger p-1 "></i></span>
                </button>
                <div class="modal fade" id="deleteUsers' . $row['user_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Name: <span class="text-danger">' . $row['username'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete your Incometion. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?user_delete_id=' . $row['user_id'] . '" class="btn btn-danger" name="delete_Income">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Users data in the database.</td>
                </tr>';
    }

    return $data;
}
function search_user_data_In_Database($userSearch)
{
    global $conn;

    $userSearch = mysqli_real_escape_string($conn, $userSearch);

    // Modify the query based on your database structure
    $query = "SELECT users.user_id, users.username, users.email, users.status, users_detail.Phone, role.name as role 
    FROM users
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    LEFT JOIN role ON role.role_id = users.role_id";

    // empty search
    if (!empty($userSearch)) {
        $query .= " WHERE users.username LIKE '%" . $userSearch . "%' OR users.email LIKE '%" . $userSearch . "%' OR users_detail.Phone LIKE '%" . $userSearch . "%'";
    }

    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '

        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['username'] . '</td>
            <td>' . $row['email'] . '</td>
            <td>' . $row['Phone'] . '</td>
            <td>' . $row['role'] . '</td>
            <td>' . $row['status'] . '</td>
            <td>
                <a href="userEdit.php?user_edit_id=' . $row['user_id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <a class="" href="userView.php?user_view_id=' . $row['user_id'] . '">
                    <i class="fas fa-eye me-1 text-info"></i>
                </a>
                <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteUsers' . $row['user_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash  text-danger p-1 "></i></span>
                </button>
                <div class="modal fade" id="deleteUsers' . $row['user_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Name: <span class="text-danger">' . $row['username'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete your Incometion. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?user_delete_id=' . $row['user_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $userSearch . '</td>
                </tr>';
    }

    return $data;
}

function filter_events_booking_data_In_Database($eventsLimited, $eventsOrder, $eventsMonth)
{
    global $conn;

    $month = date('m', strtotime($eventsMonth));
    $year = date('Y', strtotime($eventsMonth));

    // Modify the query based on your database structure
    $eventsQuery = "SELECT * FROM events_booking";

    if (!empty($eventsMonth)) {
        $eventsQuery .= " WHERE MONTH(added_on) = '$month' AND YEAR(added_on) = '$year'";
    }

    $eventsQuery .= " ORDER BY event_id $eventsOrder LIMIT $eventsLimited";

    $eventsResult = mysqli_query($conn, $eventsQuery);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($eventsResult)) {

        // Modify date & time format
        $date = date("d-F-Y", strtotime($row['date']));
        $startTime = date("h:i A", strtotime($row['startTiming']));
        $endTime = date("h:i A", strtotime($row['endTiming']));
        $data .= '

        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['eventName'] . '</td>
            <td>' . $row['location'] . '</td>
            <td>' . $row['customerName'] . '</td>
            <td>' . $date . '<br>' . $startTime . ' To ' . $endTime . '</td>
            <td>' . $row['bookingPayment'] . '</td>
            <td>' . $row['payment_type'] . '</td>
            <td>
                <a href="eventEdit.php?event_edit_id=' . $row['event_id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <a class="" href="eventView.php?event_view_id=' . $row['event_id'] . '">
                    <i class="fas fa-eye me-1 text-info"></i>
                </a>
                <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteUsers' . $row['event_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash  text-danger p-1 "></i></span>
                </button>
                <div class="modal fade" id="deleteUsers' . $row['event_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Name: <span class="text-danger">' . $row['eventName'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete your Incometion. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?booking_delete_id=' . $row['event_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Events Booking data in the database. ' . $eventsMonth . '</td>
                </tr>';
    }

    return $data;
}


function search_events_booking_data_In_Database($eventsSearch)
{
    global $conn;

    $eventsSearch = mysqli_real_escape_string($conn, $eventsSearch);

    // Modify the query based on your database structure
    $eventsQuery = "SELECT * FROM events_booking";

    if (!empty($eventsSearch)) {
        $eventsQuery .= " WHERE eventName LIKE '%" . $eventsSearch . "%' 
        OR customerName LIKE '%" . $eventsSearch . "%'
        OR customerCnic LIKE '%" . $eventsSearch . "%'
        OR bookingPayment LIKE '%" . $eventsSearch . "%'";
    }

    $eventsResult = mysqli_query($conn, $eventsQuery);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($eventsResult)) {

        // Modify date & time format
        $date = date("d-F-Y", strtotime($row['date']));
        $startTime = date("h:i A", strtotime($row['startTiming']));
        $endTime = date("h:i A", strtotime($row['endTiming']));
        $data .= '

        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['eventName'] . '</td>
            <td>' . $row['location'] . '</td>
            <td>' . $row['customerName'] . '</td>
            <td>' . $row['customerCnic'] . '</td>
            <td>' . $date . '<br>' . $startTime . ' To ' . $endTime . '</td>
            <td>' . $row['bookingPayment'] . '</td>
            <td>
                <a href="eventEdit.php?event_edit_id=' . $row['event_id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <a class="" href="eventView.php?event_view_id=' . $row['event_id'] . '">
                    <i class="fas fa-eye me-1 text-info"></i>
                </a>
                <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteUsers' . $row['event_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash  text-danger p-1 "></i></span>
                </button>
                <div class="modal fade" id="deleteUsers' . $row['event_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Name: <span class="text-danger">' . $row['eventName'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete your Incometion. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?booking_delete_id=' . $row['event_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $eventsSearch . '</td>
                </tr>';
    }

    return $data;
}

function filter_houses_data_In_Database($housesLimited, $housesOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $houseQuery = "SELECT * FROM houses
    ORDER BY house_id $housesOrder LIMIT $housesLimited";

    $houseResult = mysqli_query($conn, $houseQuery);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($houseResult)) {

        $data .= '

        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['house_number'] . '</td>
            <td>' . $row['owner_name'] . '</td>
            <td>' . $row['owner_contact'] . '</td>
            <td>' . $row['owner_cnic'] . '</td>
            <td>' . $row['occupancy_status'] . '</td>
            <td>' . $row['maintenance_charges'] . '</td>
            <td>' . $row['added_on'] . '</td>
            <td>
                <a href="houseEdit.php?house_edit_id=' . $row['house_id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <a class="" href="houseView.php?house_view_id=' . $row['house_id'] . '">
                    <i class="fas fa-eye me-1 text-info"></i>
                </a>
                <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteHouse' . $row['house_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash  text-danger p-1 "></i></span>
                </button>
                <div class="modal fade" id="deleteHouse' . $row['house_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? House Number: <span class="text-danger">' . $row['house_number'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete your Incometion. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?house_delete_id=' . $row['house_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Houses data in the database.</td>
                </tr>';
    }

    return $data;
}

function search_houses_data_In_Database($housesSearch)
{
    global $conn;

    // Modify the query based on your database structure
    $houseQuery = "SELECT * FROM houses";

    if (!empty($housesSearch)) {
        $houseQuery .= " WHERE house_number LIKE '%" . $housesSearch . "%'
        OR owner_name LIKE '%" . $housesSearch . "%'
        OR owner_contact LIKE '%" . $housesSearch . "%'
        OR owner_cnic LIKE '%" . $housesSearch . "%'";
    }

    $houseResult = mysqli_query($conn, $houseQuery);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($houseResult)) {

        $data .= '

        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['house_number'] . '</td>
            <td>' . $row['owner_name'] . '</td>
            <td>' . $row['owner_contact'] . '</td>
            <td>' . $row['owner_cnic'] . '</td>
            <td>' . $row['occupancy_status'] . '</td>
            <td>' . $row['maintenance_charges'] . '</td>
            <td>' . $row['added_on'] . '</td>
            <td>
                <a href="houseEdit.php?house_edit_id=' . $row['house_id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <a class="" href="houseView.php?house_view_id=' . $row['house_id'] . '">
                    <i class="fas fa-eye me-1 text-info"></i>
                </a>
                <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteHouse' . $row['house_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash  text-danger p-1 "></i></span>
                </button>
                <div class="modal fade" id="deleteHouse' . $row['house_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? House Number: <span class="text-danger">' . $row['house_number'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete your Incometion. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?house_delete_id=' . $row['house_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $housesSearch . '</td>
                </tr>';
    }

    return $data;
}


function filter_servant_data_In_Database($servantLimited, $servantOrder, $servantMonth)
{
    global $conn;

    $month = date('m', strtotime($servantMonth));
    $year = date('Y', strtotime($servantMonth));

    // Modify the query based on your database structure
    $query = "SELECT servants.*, houses.house_number, houses.owner_name From servants
    INNER JOIN houses ON houses.house_id = servants.house_id";

    if (!empty($servantMonth)) {
        $query .= " WHERE MONTH(servants.added_on) = '$month' AND YEAR(servants.added_on) = '$year'";
    }

    $query .= " ORDER BY servants.servant_id $servantOrder LIMIT $servantLimited";


    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '

        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['house_number'] . '</td>
            <td>' . $row['owner_name'] . '</td>
            <td>' . $row['servantDesignation'] . '</td>
            <td>' . $row['servantFees'] . '</td>
            <td>' . $row['payment_type'] . '</td>
            <td>
                <a href="servantEdit.php?servant_edit_id=' . $row['servant_id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <a class="" href="servantView.php?servant_view_id=' . $row['servant_id'] . '">
                    <i class="fas fa-eye me-1 text-info"></i>
                </a>
                <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteServant' . $row['servant_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash  text-danger p-1 "></i></span>
                </button>
                <div class="modal fade" id="deleteServant' . $row['servant_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Name: <span class="text-danger">' . $row['house_number'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete your Incometion. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?servant_delete_id=' . $row['servant_id'] . '" class="btn btn-danger" name="delete_servant">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no servants data in the database. ' . $servantMonth . '</td>
                </tr>';
    }

    return $data;
}
function search_servant_data_In_Database($servantSearch)
{
    global $conn;

    $servantSearch = mysqli_real_escape_string($conn, $servantSearch);

    // Modify the query based on your database structure
    $query = "SELECT servants.*, houses.house_number, houses.owner_name From servants
    INNER JOIN houses ON houses.house_id = servants.house_id ";

    // empty search
    if (!empty($servantSearch)) {
        $query .= " WHERE house_number LIKE '%" . $servantSearch . "%' 
        OR owner_name LIKE '%" . $servantSearch . "%' 
        OR servantDesignation LIKE '%" . $servantSearch . "%'";
    }

    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '

        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['house_number'] . '</td>
            <td>' . $row['owner_name'] . '</td>
            <td>' . $row['servantDesignation'] . '</td>
            <td>' . $row['servantFees'] . '</td>
            <td>
            <a href="servantEdit.php?servant_edit_id=' . $row['servant_id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <a href="servantView.php?servant_view_id=' . $row['servant_id'] . '">
                    <i class="fas fa-eye me-1 text-info"></i>
                </a>
                <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteIncome' . $row['servant_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash  text-danger p-1 "></i></span>
                </button>
                <div class="modal fade" id="deleteIncome' . $row['servant_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Name: <span class="text-danger">' . $row['house_number'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete your Incometion. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?servant_delete_id=' . $row['servant_id'] . '" class="btn btn-danger" name="delete_Income">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $servantSearch . '</td>
                </tr>';
    }

    return $data;
}


function filter_tenant_data_In_Database($tenantLimited, $tenantOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $query = "
        SELECT tenants.*, houses.house_number, shops.shop_number 
        FROM tenants
        LEFT JOIN houses ON tenants.house_id = houses.house_id
        LEFT JOIN shops ON shops.shop_id = tenants.shop_id
        ORDER BY tenants.tenant_id $tenantOrder 
        LIMIT $tenantLimited;
    ";

    // Debug: Print the query (remove in production)
    error_log("SQL Query: $query");

    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Debugging output for SQL errors
        $_SESSION['error_updated_tenant'] = ("Error executing query: " . mysqli_error($conn));
        header("Location: tenants");
        exit();
    }

    $data = '';
    $count = 1;

    while ($row = mysqli_fetch_assoc($result)) {
        // Debug: Print each row's data (remove in production)
        error_log("Row Data: " . print_r($row, true));

        $data .= '<tr>
            <td>' . $count++ . '</td>';

        // Determine whether to show house_number or shop_number
        if (!empty($row['house_id'])) {
            $data .= '<td>' . $row['house_number'] . '</td>';
        } elseif (!empty($row['shop_id'])) {
            $data .= '<td>' . $row['shop_number'] . '</td>';
        } else {
            $data .= '<td>-</td>'; // Show a placeholder if neither house_number nor shop_number is available
        }

        $data .= '<td>' . $row['tenant_name'] . '</td>
            <td>' . $row['tenant_contact_no'] . '</td>
            <td>' . $row['tenant_cnic'] . '</td>
            <td>
                <a href="tenantEdit.php?tenant_edit_id=' . $row['tenant_id'] . '">
                    <span><i class="fas fa-pencil-alt me-1 text-success"></i></span>
                </a>
                <a class="" href="tenantView.php?tenant_view_id=' . $row['tenant_id'] . '">
                    <i class="fas fa-eye me-1 text-info"></i>
                </a>
                <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteTenant' . $row['tenant_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash text-danger p-1"></i></span>
                </button>
                <div class="modal fade" id="deleteTenant' . $row['tenant_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Name: <span class="text-danger">' . $row['tenant_name'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete this entry. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?tenant_delete_id=' . $row['tenant_id'] . '" class="btn btn-danger" name="delete_tenant">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Tenants data in the database.</td>
                </tr>';
    }

    return $data;
}

function search_tenant_data_In_Database($tenantSearch)
{
    global $conn;

    $tenantSearch = mysqli_real_escape_string($conn, $tenantSearch);

    // Modify the query based on your database structure
    $query = "SELECT tenants.*, houses.house_number, shops.shop_number From tenants
    LEFT JOIN houses ON tenants.house_id = houses.house_id
    LEFT JOIN shops ON shops.shop_id = tenants.shop_id";

    if (!empty($tenantSearch)) {
        $query .= " WHERE houses.house_number LIKE '%" . $tenantSearch . "%'
        OR tenants.tenant_name LIKE '%" . $tenantSearch . "%'
        OR tenants.tenant_contact_no LIKE '%" . $tenantSearch . "%'
        OR tenants.tenant_cnic LIKE '%" . $tenantSearch . "%'";
    }


    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '

        <tr>
            <td>' . $count++ . '</td>';


        if (($row['house_or_shop'] == 'house')) {
            $data .= '<td>' . $row['house_number'] . '</td>';
        } elseif (($row['house_or_shop'] == 'shop')) {
            $data .= '<td>' . $row['shop_number'] . '</td>';
        }
        $data .= '<td>' . $row['tenant_name'] . '</td>
            <td>' . $row['tenant_contact_no'] . '</td>
            <td>' . $row['tenant_cnic'] . '</td>
            <td>
                <a href="tenantEdit.php?tenant_edit_id=' . $row['tenant_id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <a class="" href="tenantView.php?tenant_view_id=' . $row['tenant_id'] . '">
                    <i class="fas fa-eye me-1 text-info"></i>
                </a>
                <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteTenant' . $row['tenant_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash  text-danger p-1 "></i></span>
                </button>
                <div class="modal fade" id="deleteTenant' . $row['tenant_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Name: <span class="text-danger">' . $row['house_number'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete your Incometion. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?tenant_delete_id=' . $row['tenant_id'] . '" class="btn btn-danger" name="delete_tenant">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Tenants data in the database.</td>
                </tr>';
    }

    return $data;
}



function filter_shops_data_In_Database($shopsLimited, $shopsOrder, $shopsMonth)
{
    global $conn;

    $month = date('m', strtotime($shopsMonth));
    $year = date('Y', strtotime($shopsOrder));

    // Modify the query based on your database structure
    $houseQuery = "SELECT * FROM shops";

    if (!empty($shopsMonth)) {
        $houseQuery .= " WHERE MONTH(added_on) = '$month' AND YEAR(added_on) = '$year'";
    }

    $houseQuery .= " ORDER BY shop_id $shopsOrder LIMIT $shopsLimited";

    $houseResult = mysqli_query($conn, $houseQuery);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($houseResult)) {

        $data .= '

        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['shop_number'] . '</td>
            <td>' . $row['owner_name'] . '</td>
            <td>' . $row['owner_contact'] . '</td>
            <td>' . $row['owner_cnic'] . '</td>
            <td>' . $row['occupancy_status'] . '</td>
            <td>
                <a href="shopEdit.php?shop_edit_id=' . $row['shop_id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <a class="" href="shopView.php?shop_view_id=' . $row['shop_id'] . '">
                    <i class="fas fa-eye me-1 text-info"></i>
                </a>
                <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteShop' . $row['shop_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash  text-danger p-1 "></i></span>
                </button>
                <div class="modal fade" id="deleteShop' . $row['shop_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? shop Number: <span class="text-danger">' . $row['shop_number'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete your Incometion. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?shop_delete_id=' . $row['shop_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no shops data in the database. ' . $shopsMonth . '</td>
                </tr>';
    }

    return $data;
}

function search_shops_data_In_Database($shopsSearch)
{
    global $conn;

    // $shopsSearch = mysqli_real_escape_string($conn, $shopsSearch);
    // Modify the query based on your database structure
    $shopQuery = "SELECT * FROM shops";

    if (!empty($shopsSearch)) {
        $shopsSearch .= " WHERE shop_number LIKE '%" . $shopsSearch . "%'
        OR owner_name LIKE '%" . $shopsSearch . "%'
        OR owner_contact LIKE '%" . $shopsSearch . "%'
        OR owner_cnic LIKE '%" . $shopsSearch . "%'";
    }

    $shopResult = mysqli_query($conn, $shopQuery);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($shopResult)) {

        $data .= '

        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['shop_number'] . '</td>
            <td>' . $row['owner_name'] . '</td>
            <td>' . $row['owner_contact'] . '</td>
            <td>' . $row['owner_cnic'] . '</td>
            <td>' . $row['occupancy_status'] . '</td>
            <td>
                <a href="shopEdit.php?shop_edit_id=' . $row['shop_id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <a class="" href="shopView.php?shop_view_id=' . $row['shop_id'] . '">
                    <i class="fas fa-eye me-1 text-info"></i>
                </a>
                <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteShop' . $row['shop_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash  text-danger p-1 "></i></span>
                </button>
                <div class="modal fade" id="deleteShop' . $row['shop_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? shop Number: <span class="text-danger">' . $row['shop_number'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete your Incometion. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?shop_delete_id=' . $row['shop_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $shopsSearch . '</td>
                </tr>';
    }

    return $data;
}


function filter_eGate_data_In_Database($eGateLimited, $eGateOrder, $eGateMonth)
{
    global $conn;

    $month = date('m', strtotime($eGateMonth));
    $year = date('Y', strtotime($eGateMonth));

    $houseQuery = "SELECT egate.*, houses.house_number, shops.shop_number 
               FROM egate
               LEFT JOIN houses ON egate.house_id = houses.house_id
               LEFT JOIN shops ON egate.shop_id = shops.shop_id";

    if (!empty($eGateMonth)) {
        $houseQuery .= " WHERE MONTH(egate.added_on) = '$month' AND YEAR(egate.added_on) = '$year'";
    }

    $houseQuery .= " ORDER BY egate.eGate_id $eGateOrder 
                 LIMIT $eGateLimited";

    $houseResult = mysqli_query($conn, $houseQuery);

    if (!$houseResult) {
        // Debugging output for SQL errors
        $_SESSION['error_update_egate'] = ("Error executing query: " . mysqli_error($conn));
        header("Location: eGate");
        exit();
    }

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($houseResult)) {
        $data .= '
        <tr>
            <td>' . $count++ . '</td>';

        if (($row['house_or_shop'] == 'house')) {
            $data .= '<td>' . $row['house_number'] . '</td>';
        } elseif (($row['house_or_shop'] == 'shop')) {
            $data .= '<td>' . $row['shop_number'] . '</td>';
        }

        $data .= '<td>' . $row['eGateperson_name'] . '</td>
        <td>' . $row['vehicle_number'] . '</td>
        <td>' . $row['eGate_charges'] . '</td>
        <td>' . $row['payment_type'] . '</td>
         

        <td>
        <a href="includes/pdf_maker?eGate_id=' . $row['eGate_id'] . '&ACTION=VIEW" target="_blank" >  <span style="padding: 5px 1px; border-radius: 5px; color: white; background-color:lightcoral;">
                            <i class="fas fa-file text-white m-0 p-1">Print</i>
                            </span></a>  
                    </td>

        

                  <td>
                      <a href="eGateEdit?eGate_edit_id=' . $row['eGate_id'] . '">
                          <span>
                              <i class="fas fa-pencil-alt me-1 text-success"></i>
                          </span>
                      </a>
                      <a class="" href="eGateView?eGate_view_id=' . $row['eGate_id'] . '">
                          <i class="fas fa-eye me-1 text-info"></i>
                      </a>
                      <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteeGate' . $row['eGate_id'] . '" data-bs-placement="top" title="Delete">
                          <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash text-danger p-1 "></i></span>
                      </button>
                      <div class="modal fade" id="deleteeGate' . $row['eGate_id'] . '" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? eGate Person Name: <span class="text-danger">' . $row['eGateperson_name'] . '</span></h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body text-start">
                                      <p>Please confirm that you want to delete this entry. <br>
                                          Once deleted, you won\'t be able to recover it. <br>
                                          Please proceed with caution.
                                      </p>
                                  </div>
                                  <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                      <a href="?eGate_delete_id=' . $row['eGate_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no entries in the database. ' . $eGateMonth . '</td>
                </tr>';
    }

    return $data;
}


function search_eGate_data_In_Database($eGateSearch)
{
    global $conn;

    $eGateSearch = mysqli_real_escape_string($conn, $_POST['eGateSearch']);

    // Modify the query based on your database structure
    $houseQuery = "SELECT egate.*, houses.house_number, shops.shop_number 
    FROM egate
    LEFT JOIN houses ON egate.house_id = houses.house_id
    LEFT JOIN shops ON egate.shop_id = shops.shop_id";

    if (!empty($eGateSearch)) {
        $houseQuery .= " WHERE house_number LIKE '%" . $eGateSearch . "%'
        OR shop_number LIKE '%" . $eGateSearch . "%'
        OR eGateperson_name LIKE '%" . $eGateSearch . "%'
        OR vehicle_name LIKE '%" . $eGateSearch . "%'
        OR vehicle_number LIKE '%" . $eGateSearch . "%'";
    }

    $houseResult = mysqli_query($conn, $houseQuery);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($houseResult)) {

        $data .= '

        <tr>
        <td>' . $count++ . '</td>';

        if (($row['house_or_shop'] == 'house')) {
            $data .= '<td>' . $row['house_number'] . '</td>';
        } elseif (($row['house_or_shop'] == 'shop')) {
            $data .= '<td>' . $row['shop_number'] . '</td>';
        }

        $data .= '<td>' . $row['eGateperson_name'] . '</td>
              <td>' . $row['vehicle_name'] . '</td>
              <td>' . $row['vehicle_number'] . '</td>
              <td>' . $row['eGate_charges'] . '</td>
              <td>
                  <a href="eGateEdit?eGate_edit_id=' . $row['eGate_id'] . '">
                      <span>
                          <i class="fas fa-pencil-alt me-1 text-success"></i>
                      </span>
                  </a>
                  <a class="" href="eGateView?eGate_view_id=' . $row['eGate_id'] . '">
                      <i class="fas fa-eye me-1 text-info"></i>
                  </a>
                  <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteeGate' . $row['eGate_id'] . '" data-bs-placement="top" title="Delete">
                      <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash text-danger p-1 "></i></span>
                  </button>
                  <div class="modal fade" id="deleteeGate' . $row['eGate_id'] . '" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? eGate Person Name: <span class="text-danger">' . $row['eGateperson_name'] . '</span></h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body text-start">
                                  <p>Please confirm that you want to delete this entry. <br>
                                      Once deleted, you won\'t be able to recover it. <br>
                                      Please proceed with caution.
                                  </p>
                              </div>
                              <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                  <a href="?eGate_delete_id=' . $row['eGate_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $eGateSearch . '</td>
                </tr>';
    }

    return $data;
}


function filter_employee_data_In_Database($employeeLimited, $employeeOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $houseQuery = "SELECT * FROM employees 
                   ORDER BY employee_id $employeeOrder LIMIT $employeeLimited";

    $houseResult = mysqli_query($conn, $houseQuery);

    if (!$houseResult) {
        // Debugging output for SQL errors
        $_SESSION['error_updated_employee'] = ("Error executing query: " . mysqli_error($conn));
        header("Location: employee");
        exit();
    }

    $data = '';
    $count = 1;

    while ($row = mysqli_fetch_assoc($houseResult)) {
        $imagePath = 'media/qrcodeImages/' . $row['QRcode'];  // Ensure the correct path to your images folder

        // Check if the image file exists
        $imgTag = '';
        if (file_exists($imagePath)) {
            $imgTag = '<img src="' . $imagePath . '" alt="QR Code">';
        } else {
            $imgTag = 'QR Code image not found';
        }

        $data .= '
        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['employee_full_name'] . '</td>
            <td>' . $row['employee_cnic'] . '</td>
            <td>' . $row['employement_type'] . '</td>
            <td>' . $row['department'] . '</td>
            <td>' . $imgTag . '</td>
            <td>
                <a href="employeeEdit?employee_edit_id=' . $row['employee_id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <a class="" href="employeeView?employee_view_id=' . $row['employee_id'] . '">
                    <i class="fas fa-eye me-1 text-info"></i>
                </a>
                <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteEmployee' . $row['employee_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash text-danger p-1 "></i></span>
                </button>
                <div class="modal fade" id="deleteEmployee' . $row['employee_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? employee Person Name: <span class="text-danger">' . $row['employee_full_name'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete this entry. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?employee_delete_id=' . $row['employee_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Employee data in the database.</td>
                </tr>';
    }

    return $data;
}


function search_employee_data_In_Database($employeeSearch)
{
    global $conn;

    $employeeSearch = mysqli_real_escape_string($conn, $_POST['employeeSearch']);

    // Modify the query based on your database structure
    $houseQuery = "SELECT * FROM employees";

    if (!empty($employeeSearch)) {
        $houseQuery .= " WHERE employee_full_name LIKE '%" . $employeeSearch . "%'
        OR employee_cnic LIKE '%" . $employeeSearch . "%'
        OR employement_type LIKE '%" . $employeeSearch . "%'
        OR department LIKE '%" . $employeeSearch . "%'
        OR designation LIKE '%" . $employeeSearch . "%'";
    }

    $houseResult = mysqli_query($conn, $houseQuery);

    $data = '';
    $count = 1;

    while ($row = mysqli_fetch_assoc($houseResult)) {
        $imagePath = 'media/qrcodeImages/' . $row['QRcode'];  // Ensure the correct path to your images folder

        // Check if the image file exists
        $imgTag = '';
        if (file_exists($imagePath)) {
            $imgTag = '<img src="' . $imagePath . '" alt="QR Code">';
        } else {
            $imgTag = 'QR Code image not found';
        }

        $data .= '
    <tr>
        <td>' . $count++ . '</td>
        <td>' . $row['employee_full_name'] . '</td>
        <td>' . $row['employee_cnic'] . '</td>
        <td>' . $row['employement_type'] . '</td>
        <td>' . $row['department'] . '</td>
        <td>' . $imgTag . '</td>
        <td>
            <a href="employeeEdit?employee_edit_id=' . $row['employee_id'] . '">
                <span>
                    <i class="fas fa-pencil-alt me-1 text-success"></i>
                </span>
            </a>
            <a class="" href="employeeView?employee_view_id=' . $row['employee_id'] . '">
                <i class="fas fa-eye me-1 text-info"></i>
            </a>
            <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteEmployee' . $row['employee_id'] . '" data-bs-placement="top" title="Delete">
                <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash text-danger p-1 "></i></span>
            </button>
            <div class="modal fade" id="deleteEmployee' . $row['employee_id'] . '" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? employee Person Name: <span class="text-danger">' . $row['employee_full_name'] . '</span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <p>Please confirm that you want to delete this entry. <br>
                                Once deleted, you won\'t be able to recover it. <br>
                                Please proceed with caution.
                            </p>
                        </div>
                        <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                            <a href="?employee_delete_id=' . $row['employee_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $employeeSearch . '</td>
                </tr>';
    }

    return $data;
}


function filter_Utility_charges_data_In_Database($Utility_chargesLimited, $Utility_chargesOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $houseQuery = "SELECT * FROM utility_charges 
                   ORDER BY utility_id $Utility_chargesOrder LIMIT $Utility_chargesLimited";

    $houseResult = mysqli_query($conn, $houseQuery);

    if (!$houseResult) {
        // Debugging output for SQL errors
        $_SESSION['error_updated_employee'] = ("Error executing query: " . mysqli_error($conn));
        header("Location: employee");
        exit();
    }

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($houseResult)) {
        $data .= '
        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['utility_type'] . '</td>
            <td>' . $row['utility_amount'] . '</td>
            <td>' . $row['utility_billing_month'] . '</td>
            <td>' . $row['utility_location'] . '</td>
            <td>
                      <a href="utilityEdit?utility_edit_id=' . $row['utility_id'] . '">
                          <span>
                              <i class="fas fa-pencil-alt me-1 text-success"></i>
                          </span>
                      </a>
                      <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteUtility' . $row['utility_id'] . '" data-bs-placement="top" title="Delete">
                          <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash text-danger p-1 "></i></span>
                      </button>
                      <div class="modal fade" id="deleteUtility' . $row['utility_id'] . '" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Utility Charges Name: <span class="text-danger">' . $row['utility_type'] . '</span></h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body text-start">
                                      <p>Please confirm that you want to delete this entry. <br>
                                          Once deleted, you won\'t be able to recover it. <br>
                                          Please proceed with caution.
                                      </p>
                                  </div>
                                  <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                      <a href="?utility_delete_id=' . $row['utility_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Employee data in the database.</td>
                </tr>';
    }

    return $data;
}


function search_Utility_charges_data_In_Database($Utility_chargesSearch)
{
    global $conn;

    $Utility_chargesSearch = mysqli_real_escape_string($conn, $_POST['Utility_chargesSearch']);

    // Modify the query based on your database structure
    $houseQuery = "SELECT * FROM utility_charges";

    if (!empty($Utility_chargesSearch)) {
        $houseQuery .= " WHERE utility_type LIKE '%" . $Utility_chargesSearch . "%'
        OR utility_amount LIKE '%" . $Utility_chargesSearch . "%'
        OR utility_location LIKE '%" . $Utility_chargesSearch . "%'";
    }

    $houseResult = mysqli_query($conn, $houseQuery);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($houseResult)) {

        $data .= '
        <tr>
        <td>' . $count++ . '</td>
        <td>' . $row['utility_type'] . '</td>
        <td>' . $row['utility_amount'] . '</td>
        <td>' . $row['utility_billing_month'] . '</td>
        <td>' . $row['utility_location'] . '</td>
        <td>
                  <a href="utilityEdit?utility_edit_id=' . $row['utility_id'] . '">
                      <span>
                          <i class="fas fa-pencil-alt me-1 text-success"></i>
                      </span>
                  </a>
                  <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteUtility' . $row['utility_id'] . '" data-bs-placement="top" title="Delete">
                      <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash text-danger p-1 "></i></span>
                  </button>
                  <div class="modal fade" id="deleteUtility' . $row['utility_id'] . '" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Utility Charges Name: <span class="text-danger">' . $row['utility_type'] . '</span></h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body text-start">
                                  <p>Please confirm that you want to delete this entry. <br>
                                      Once deleted, you won\'t be able to recover it. <br>
                                      Please proceed with caution.
                                  </p>
                              </div>
                              <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                  <a href="?utility_delete_id=' . $row['utility_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $Utility_chargesSearch . '</td>
                </tr>';
    }

    return $data;
}



function filter_societyMaint_data_In_Database($societyMaintLimited, $societyMaintOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $houseQuery = "SELECT * FROM society_maintenance 
                   ORDER BY society_maint_id $societyMaintOrder LIMIT $societyMaintLimited";

    $houseResult = mysqli_query($conn, $houseQuery);

    if (!$houseResult) {
        // Debugging output for SQL errors
        $_SESSION['error_updated_societyMaint'] = ("Error executing query: " . mysqli_error($conn));
        header("Location: societyMaintenance");
        exit();
    }

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($houseResult)) {
        $data .= '
        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['society_maint_type'] . '</td>
            <td>' . $row['society_maint_amount'] . '</td>
            <td>' . $row['society_maint_dueDate'] . '</td>
            <td>' . $row['society_maint_paymentDate'] . '</td>
            <td>' . $row['society_maint_comments'] . '</td>
            <td>
                      <a href="societyMaintEdit?societyMaint_edit_id=' . $row['society_maint_id'] . '">
                          <span>
                              <i class="fas fa-pencil-alt me-1 text-success"></i>
                          </span>
                      </a>
                      <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteSocietyMaint' . $row['society_maint_id'] . '" data-bs-placement="top" title="Delete">
                          <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash text-danger p-1 "></i></span>
                      </button>
                      <div class="modal fade" id="deleteSocietyMaint' . $row['society_maint_id'] . '" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Society Maintenance Name: <span class="text-danger">' . $row['society_maint_type'] . '</span></h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body text-start">
                                      <p>Please confirm that you want to delete this entry. <br>
                                          Once deleted, you won\'t be able to recover it. <br>
                                          Please proceed with caution.
                                      </p>
                                  </div>
                                  <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                      <a href="?societyMaint_delete_id=' . $row['society_maint_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no suciety maintenance data in the database.</td>
                </tr>';
    }

    return $data;
}


function search_societyMaint_data_In_Database($societyMaintSearch)
{
    global $conn;

    $societyMaintSearch = mysqli_real_escape_string($conn, $_POST['societyMaintSearch']);

    // Modify the query based on your database structure
    $houseQuery = "SELECT * FROM society_maintenance";

    if (!empty($societyMaintSearch)) {
        $houseQuery .= " WHERE society_maint_type LIKE '%" . $societyMaintSearch . "%'
        OR society_maint_amount LIKE '%" . $societyMaintSearch . "%'
        OR society_maint_comments LIKE '%" . $societyMaintSearch . "%'";
    }


    $houseResult = mysqli_query($conn, $houseQuery);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($houseResult)) {

        $data .= '
        <tr>
        <td>' . $count++ . '</td>
            <td>' . $row['society_maint_type'] . '</td>
            <td>' . $row['society_maint_amount'] . '</td>
            <td>' . $row['society_maint_dueDate'] . '</td>
            <td>' . $row['society_maint_paymentDate'] . '</td>
            <td>' . $row['society_maint_comments'] . '</td>
            <td>
                      <a href="societyMaintEdit?societyMaint_edit_id=' . $row['society_maint_id'] . '">
                          <span>
                              <i class="fas fa-pencil-alt me-1 text-success"></i>
                          </span>
                      </a>
                      <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteSocietyMaint' . $row['society_maint_id'] . '" data-bs-placement="top" title="Delete">
                          <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash text-danger p-1 "></i></span>
                      </button>
                      <div class="modal fade" id="deleteSocietyMaint' . $row['society_maint_id'] . '" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Society Maintenance Name: <span class="text-danger">' . $row['society_maint_type'] . '</span></h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body text-start">
                                      <p>Please confirm that you want to delete this entry. <br>
                                          Once deleted, you won\'t be able to recover it. <br>
                                          Please proceed with caution.
                                      </p>
                                  </div>
                                  <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                      <a href="?societyMaint_delete_id=' . $row['society_maint_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $societyMaintSearch . '</td>
                </tr>';
    }

    return $data;
}


function searching_expensesReports_data_In_Database($selectUtilityMaint, $searchUtilityType, $searchLocation, $searchMaintType, $searchMonth, $searchDropdown)
{
    global $conn;
    $searchUtilityType = mysqli_real_escape_string($conn, $_POST['searchUtilityType']);
    $searchLocation = mysqli_real_escape_string($conn, $_POST['searchLocation']);
    $searchMaintType = mysqli_real_escape_string($conn, $_POST['searchMaintType']);
    $searchDropdown = mysqli_real_escape_string($conn, $_POST['searchDropdown']);
    $year = date('Y', strtotime($searchMonth));
    $month = date('m', strtotime($searchMonth));

    if ($selectUtilityMaint == 'Utility Charges') {
        $queryUtility = "SELECT * FROM utility_charges WHERE 1=1";

        if (!empty($searchUtilityType)) {
            $queryUtility .= " AND utility_type LIKE '%" . $searchUtilityType . "%'";
        }

        if (!empty($searchLocation)) {
            $queryUtility .= " AND utility_location LIKE '%" . $searchLocation . "%'";
        }

        if (!empty($searchMonth)) {
            $queryUtility .= " AND utility_billing_month LIKE '%" . $searchMonth . "%'";
        }

        $queryUtility .= " ORDER BY utility_id DESC LIMIT $searchDropdown";

        $resultUtility = mysqli_query($conn, $queryUtility);
        $data = '';
        $count = 1;
        while ($row = mysqli_fetch_assoc($resultUtility)) {
            $data .= '
            <tr>
                <td>' . $count++ . '</td>
                <td>' . $row['utility_type'] . '</td>
                <td>' . $row['utility_amount'] . '</td>
                <td>' . $row['utility_billing_month'] . '</td>
                <td>' . $row['utility_location'] . '</td>
                <td>
                    <a href="utilityEdit?utility_edit_id=' . $row['utility_id'] . '">
                        <span>
                            <i class="fas fa-pencil-alt me-1 text-success"></i>
                        </span>
                    </a>
                    <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteUtility' . $row['utility_id'] . '" data-bs-placement="top" title="Delete">
                        <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash text-danger p-1 "></i></span>
                    </button>
                    <div class="modal fade" id="deleteUtility' . $row['utility_id'] . '" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Utility Charges Name: <span class="text-danger">' . $row['utility_type'] . '</span></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-start">
                                    <p>Please confirm that you want to delete this entry. <br>
                                        Once deleted, you won\'t be able to recover it. <br>
                                        Please proceed with caution.
                                    </p>
                                </div>
                                <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                    <a href="?utility_delete_id=' . $row['utility_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            ';
        }

        if (empty($data)) {
            $data = '<tr>
                        <td colspan="6" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database.</td>
                    </tr>';
        }

        return $data;
    } elseif ($selectUtilityMaint == 'Society Maintenance') {
        $queryMaint = "SELECT * FROM society_maintenance WHERE 1=1";

        if (!empty($searchMaintType)) {
            $queryMaint .= " AND society_maint_type LIKE '%" . $searchMaintType . "%'";
        }

        if (!empty($searchMonth)) {
            $queryMaint .= " AND month(society_maint_dueDate) = '$month' AND year(society_maint_dueDate) = '$year'";
        }

        $queryMaint .= " ORDER BY society_maint_id DESC LIMIT $searchDropdown";

        $resultMaint = mysqli_query($conn, $queryMaint);
        $data = '';
        $count = 1;
        while ($row = mysqli_fetch_assoc($resultMaint)) {
            $data .= '
            <tr>
                <td>' . $count++ . '</td>
                <td>' . $row['society_maint_type'] . '</td>
                <td>' . $row['society_maint_amount'] . '</td>
                <td>' . $row['society_maint_dueDate'] . '</td>
                <td>' . $row['society_maint_paymentDate'] . '</td>
                <td>' . $row['society_maint_comments'] . '</td>
                <td>
                    <a href="societyMaintEdit?societyMaint_edit_id=' . $row['society_maint_id'] . '">
                        <span>
                            <i class="fas fa-pencil-alt me-1 text-success"></i>
                        </span>
                    </a>
                    <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteSocietyMaint' . $row['society_maint_id'] . '" data-bs-placement="top" title="Delete">
                        <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash text-danger p-1 "></i></span>
                    </button>
                    <div class="modal fade" id="deleteSocietyMaint' . $row['society_maint_id'] . '" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Society Maintenance Name: <span class="text-danger">' . $row['society_maint_type'] . '</span></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-start">
                                    <p>Please confirm that you want to delete this entry. <br>
                                        Once deleted, you won\'t be able to recover it. <br>
                                        Please proceed with caution.
                                    </p>
                                </div>
                                <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                    <a href="?societyMaint_delete_id=' . $row['society_maint_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            ';
        }

        if (empty($data)) {
            $data = '<tr>
                        <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database.</td>
                    </tr>';
        }

        return $data;
    } else {
        return '<tr>
        <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">Select Utility/Maintenance & Search the data.</td>
    </tr>';
    }
}



function searching_incomeReports_data_In_Database($selectIncomeReport, $searchMonth, $searchDropdown)
{
    global $conn;
    $selectIncomeReport = mysqli_real_escape_string($conn, $selectIncomeReport);
    $searchMonth = mysqli_real_escape_string($conn, $searchMonth);
    $month = date('m', strtotime($searchMonth));
    $year = date('Y', strtotime($searchDropdown));
    $searchDropdown = mysqli_real_escape_string($conn, $searchDropdown);


    if ($selectIncomeReport == 'E-Gate Pass') {

        $eGateQuery = "SELECT egate.*, houses.house_number, shops.shop_number 
                   FROM egate
                   LEFT JOIN houses ON egate.house_id = houses.house_id
                   LEFT JOIN shops ON egate.shop_id = shops.shop_id 
                   WHERE 1=1";

        if (!empty($searchMonth)) {
            $eGateQuery .= " AND egate.added_on LIKE '%" . $searchMonth . "%'";
        }
        $eGateQuery .= " ORDER BY eGate_id DESC LIMIT $searchDropdown";

        $eGateResult = mysqli_query($conn, $eGateQuery);
        $data = '';
        $count = 1;
        while ($row = mysqli_fetch_array($eGateResult)) {

            $data .= '

                <tr>
                    <td>' . $count++ . '</td>';

            if (($row['house_or_shop'] == 'house')) {
                $data .= '<td>' . $row['house_number'] . '</td>';
            } elseif (($row['house_or_shop'] == 'shop')) {
                $data .= '<td>' . $row['shop_number'] . '</td>';
            }

            $data .= '<td>' . $row['eGateperson_name'] . '</td>
                    <td>' . $row['vehicle_name'] . '</td>
                    <td>' . $row['vehicle_number'] . '</td>
                    <td>' . $row['eGate_charges'] . '</td>
                    <td>
                      <a href="eGateEdit?eGate_edit_id=' . $row['eGate_id'] . '">
                          <span>
                              <i class="fas fa-pencil-alt me-1 text-success"></i>
                          </span>
                      </a>
                      <a class="" href="eGateView?eGate_view_id=' . $row['eGate_id'] . '">
                          <i class="fas fa-eye me-1 text-info"></i>
                      </a>
                      <button type="button" class="border-0 rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteeGate' . $row['eGate_id'] . '" data-bs-placement="top" title="Delete">
                          <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash text-danger p-1 "></i></span>
                      </button>
                      <div class="modal fade" id="deleteeGate' . $row['eGate_id'] . '" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? eGate Person Name: <span class="text-danger">' . $row['eGateperson_name'] . '</span></h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body text-start">
                                      <p>Please confirm that you want to delete this entry. <br>
                                          Once deleted, you won\'t be able to recover it. <br>
                                          Please proceed with caution.
                                      </p>
                                  </div>
                                  <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                      <a href="?eGate_delete_id=' . $row['eGate_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
                                      <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </td>
              </tr>';
        }

        if (empty($data)) {
            $data = '<tr>
                        <td colspan="6" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database.' . $searchMonth . '</td>
                    </tr>';
        }

        return $data;
    } elseif ($selectIncomeReport == 'Servants') {

        // Modify the query based on your database structure
        $query = "SELECT servants.*, houses.house_number, houses.owner_name From servants
        INNER JOIN houses ON houses.house_id = servants.house_id 
        WHERE 1=1";

        if (!empty($searchMonth)) {
            $query .= " AND servants.added_on LIKE '%" . $searchMonth . "%'";
        }
        $query .= " ORDER BY servant_id DESC LIMIT $searchDropdown";


        $result = mysqli_query($conn, $query);

        $data = '';
        $count = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $data .= '

        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['house_number'] . '</td>
            <td>' . $row['owner_name'] . '</td>
            <td>' . $row['servantDesignation'] . '</td>
            <td>' . $row['servantFees'] . '</td>
            <td>
                <a href="servantEdit.php?servant_edit_id=' . $row['servant_id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <a class="" href="servantView.php?servant_view_id=' . $row['servant_id'] . '">
                    <i class="fas fa-eye me-1 text-info"></i>
                </a>
                <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteServant' . $row['servant_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash  text-danger p-1 "></i></span>
                </button>
                <div class="modal fade" id="deleteServant' . $row['servant_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Name: <span class="text-danger">' . $row['house_number'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete your Incometion. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?servant_delete_id=' . $row['servant_id'] . '" class="btn btn-danger" name="delete_servant">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no servants data in the database.' . $searchMonth . '</td>
                </tr>';
        }

        return $data;
    } elseif ($selectIncomeReport == 'Events Booking') {

        // Modify the query based on your database structure
        $eventsQuery = "SELECT * FROM events_booking WHERE 1=1";

        if (!empty($searchMonth)) {
            $eventsQuery .= " AND added_on LIKE '%" . $searchMonth . "%'";
        }
        $eventsQuery .= " ORDER BY event_id DESC LIMIT $searchDropdown";

        $eventsResult = mysqli_query($conn, $eventsQuery);

        $data = '';
        $count = 1;
        while ($row = mysqli_fetch_assoc($eventsResult)) {

            // Modify date & time format
            $date = date("d-F-Y", strtotime($row['date']));
            $startTime = date("h:i A", strtotime($row['startTiming']));
            $endTime = date("h:i A", strtotime($row['endTiming']));
            $data .= '

        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['eventName'] . '</td>
            <td>' . $row['location'] . '</td>
            <td>' . $row['customerName'] . '</td>
            <td>' . $date . '<br>' . $startTime . ' To ' . $endTime . '</td>
            <td>' . $row['bookingPayment'] . '</td>
            <td>
                <a href="eventEdit.php?event_edit_id=' . $row['event_id'] . '">
                    <span>
                        <i class="fas fa-pencil-alt me-1 text-success"></i>
                    </span>
                </a>
                <a class="" href="eventView.php?event_view_id=' . $row['event_id'] . '">
                    <i class="fas fa-eye me-1 text-info"></i>
                </a>
                <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteUsers' . $row['event_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash  text-danger p-1 "></i></span>
                </button>
                <div class="modal fade" id="deleteUsers' . $row['event_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete? Name: <span class="text-danger">' . $row['eventName'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete your Incometion. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?booking_delete_id=' . $row['event_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Events Booking data in the database.' . $searchMonth . '</td>
                </tr>';
        }

        return $data;
    } elseif ($selectIncomeReport == 'Maintenance Charges') {

        // Modify the query based on your database structure
        $query = "SELECT * FROM maintenance_payments WHERE 1=1";

        if (!empty($searchMonth)) {
            $query .= " AND added_on LIKE '%" . $searchMonth . "%'";
        }
        $query .= " ORDER BY maintenance_id DESC LIMIT $searchDropdown";

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
            </tr>';
        }
        // Check if $data is empty
        if (empty($data)) {
            $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Maintenance data in the database.' . $searchMonth . '</td>
                </tr>';
        }

        return $data;
    } elseif ($selectIncomeReport == 'Penalty Charges') {

        // Modify the query based on your database structure
        $query = "SELECT * FROM penalty WHERE 1=1";

        if (!empty($searchMonth)) {
            $query .= " AND created_date LIKE '%" . $searchMonth . "%'";
        }
        $query .= " ORDER BY id DESC LIMIT $searchDropdown";


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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no penalty data in the database. ' . $searchMonth . '</td>
                </tr>';
        }

        return $data;
    } else {
        return '<tr>
        <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">Please Select the income reports for Searching the data.</td>
    </tr>';
    }
}






// ====================== Index Page Functions Start ======================
function filter_month_house_data_In_Database($filterHousesData)
{
    global $conn;

    // Extract month and year from the selected month variable
    $month = date('m', strtotime($filterHousesData));
    $year = date('Y', strtotime($filterHousesData));

    $house_query = "SELECT * FROM houses WHERE month(added_on) = '$month' AND year(added_on) = '$year'";
    $house_result = mysqli_query($conn, $house_query);
    $total_houses = mysqli_num_rows($house_result);

    $data = '
        
        <p>' . date('F, Y', strtotime($filterHousesData)) . '</p>
        <h4 class="text-primary mb-0">' . $total_houses . '</h4>
        
        ';

    return $data;
}

function filter_month_shops_data_In_Database($filterShopsData)
{
    global $conn;

    // Extract month and year from the selected month variable
    $month = date('m', strtotime($filterShopsData));
    $year = date('Y', strtotime($filterShopsData));

    $query = "SELECT * FROM shops WHERE month(added_on) = '$month' AND year(added_on) = '$year'";
    $result = mysqli_query($conn, $query);
    $total_numbers = mysqli_num_rows($result);

    $data = '
        
        <p>' . date('F, Y', strtotime($filterShopsData)) . '</p>
        <h4 class="text-primary mb-0">' . $total_numbers . '</h4>
        
        ';

    return $data;
}

function filter_month_users_data_In_Database($filterUsersData)
{
    global $conn;

    // Extract month and year from the selected month variable
    $month = date('m', strtotime($filterUsersData));
    $year = date('Y', strtotime($filterUsersData));

    $query = "SELECT * FROM users WHERE month(created_date) = '$month' AND year(created_date) = '$year'";
    $result = mysqli_query($conn, $query);
    $total_numbers = mysqli_num_rows($result);

    $data = '
        
        <p>' . date('F, Y', strtotime($filterUsersData)) . '</p>
        <h4 class="text-primary mb-0">' . $total_numbers . '</h4>
        
        ';

    return $data;
}

function filter_month_employees_data_In_Database($filterEmployeesData)
{
    global $conn;

    // Extract month and year from the selected month variable
    $month = date('m', strtotime($filterEmployeesData));
    $year = date('Y', strtotime($filterEmployeesData));

    $query = "SELECT * FROM employees WHERE month(added_on) = '$month' AND year(added_on) = '$year'";
    $result = mysqli_query($conn, $query);
    $total_numbers = mysqli_num_rows($result);

    $data = '
        
        <p>' . date('F, Y', strtotime($filterEmployeesData)) . '</p>
        <h4 class="text-primary mb-0">' . $total_numbers . '</h4>
        
        ';

    return $data;
}

function filter_month_income_data_In_Database($filterIncomesData)
{
    global $conn;

    // Extract month and year from the selected month variable
    $month = date('m', strtotime($filterIncomesData));
    $year = date('Y', strtotime($filterIncomesData));

    // Define the queries to calculate the total income from various tables
    $queries = [
        "SELECT SUM(maintenance_charges) AS total_income FROM `houses` WHERE MONTH(added_on) = '$month' AND YEAR(added_on) = '$year'",
        "SELECT SUM(maintenance_charges) AS total_income FROM `shops` WHERE MONTH(added_on) = '$month' AND YEAR(added_on) = '$year'",
        "SELECT SUM(eGate_charges) AS total_income FROM `egate` WHERE MONTH(added_on) = '$month' AND YEAR(added_on) = '$year'",
        "SELECT SUM(servantFees) AS total_income FROM `servants` WHERE MONTH(added_on) = '$month' AND YEAR(added_on) = '$year'",
        "SELECT SUM(bookingPayment) AS total_income FROM `events_booking` WHERE MONTH(added_on) = '$month' AND YEAR(added_on) = '$year'",
        "SELECT SUM(maintenance_peyment) AS total_income FROM `maintenance_payments` WHERE MONTH(added_on) = '$month' AND YEAR(added_on) = '$year'",
        "SELECT SUM(penalty_charges) AS total_income FROM `penalty` WHERE MONTH(created_by) = '$month' AND YEAR(created_by) = '$year'"
    ];

    $total_income = 0;

    // Execute each query and accumulate the total income
    foreach ($queries as $query) {
        $result = mysqli_query($conn, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $total_income += $row['total_income'];
        }
    }

    // Prepare the data to be returned
    $data = '
        <p>' . date('F, Y', strtotime($filterIncomesData)) . '</p>
        <h4 class="text-primary mb-0">' . number_format($total_income) . '</h4>
    ';

    return $data;
}

function filter_month_expences_data_In_Database($filterExpencesData)
{
    global $conn;

    // Extract month and year from the selected month variable
    $month = date('m', strtotime($filterExpencesData));
    $year = date('Y', strtotime($filterExpencesData));

    // Define the queries to calculate the total income from various tables
    $queries = [
        "SELECT SUM(utility_amount) AS total_expences FROM `utility_charges` WHERE MONTH(added_on) = '$month' AND YEAR(added_on) = '$year'",
        "SELECT SUM(society_maint_amount) AS total_expences FROM `society_maintenance` WHERE MONTH(added_on) = '$month' AND YEAR(added_on) = '$year'",
    ];

    $total_expences = 0;

    // Execute each query and accumulate the total income
    foreach ($queries as $query) {
        $result = mysqli_query($conn, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $total_expences += $row['total_expences'];
        }
    }

    // Prepare the data to be returned
    $data = '
        <p>' . date('F, Y', strtotime($filterExpencesData)) . '</p>
        <h4 class="text-primary mb-0">' . number_format($total_expences) . '</h4>
    ';

    return $data;
}





if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Filter user load
    if ($action == 'load-user-Data') {
        $userLimited = $_POST['userLimited'];
        $userOrder = $_POST['userOrder'];

        $result = filter_user_data_In_Database($userLimited, $userOrder);

        $response = array('data' => $result);
        echo json_encode($response);
    }
    // Filter user search
    if ($action == 'search-user-Data') {
        $userSearch = $_POST['userSearch'];

        $result = search_user_data_In_Database($userSearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter events booking
    if ($action == 'load-events_booking-Data') {
        $eventsLimited = $_POST['eventsLimited'];
        $eventsOrder = $_POST['eventsOrder'];
        $eventsMonth = $_POST['eventsMonth'];;
        $result = filter_events_booking_data_In_Database($eventsLimited, $eventsOrder, $eventsMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter events booking search
    if ($action == 'search-events_booking-Data') {
        $eventsSearch = $_POST['eventsSearch'];

        $result = search_events_booking_data_In_Database($eventsSearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter Society Houses 
    if ($action == 'load-houses-Data') {
        $housesLimited = $_POST['housesLimited'];
        $housesOrder = $_POST['housesOrder'];

        $result = filter_houses_data_In_Database($housesLimited, $housesOrder);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter Society Houses search
    if ($action == 'search-houses-Data') {
        $housesSearch = $_POST['housesSearch'];

        $result = search_houses_data_In_Database($housesSearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // Filter servant load
    if ($action == 'load-servant-Data') {
        $servantLimited = $_POST['servantLimited'];
        $servantOrder = $_POST['servantOrder'];
        $servantMonth = $_POST['servantMonth'];

        $result = filter_servant_data_In_Database($servantLimited, $servantOrder, $servantMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }
    // Filter servant search
    if ($action == 'search-servant-Data') {
        $servantSearch = $_POST['servantSearch'];

        $result = search_servant_data_In_Database($servantSearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // Filter tenants load
    if ($action == 'load-tenant-Data') {
        $tenantLimited = $_POST['tenantLimited'];
        $tenantOrder = $_POST['tenantOrder'];

        $result = filter_tenant_data_In_Database($tenantLimited, $tenantOrder);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // Filter tenant search
    if ($action == 'search-tenant-Data') {
        $tenantSearch = $_POST['tenantSearch'];

        $result = search_tenant_data_In_Database($tenantSearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter Society shops 
    if ($action == 'load-shops-Data') {
        $shopsLimited = $_POST['shopsLimited'];
        $shopsOrder = $_POST['shopsOrder'];
        $shopsMonth = $_POST['shopsMonth'];

        $result = filter_shops_data_In_Database($shopsLimited, $shopsOrder, $shopsMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter Society shops search
    if ($action == 'search-shops-Data') {
        $shopsSearch = $_POST['shopsSearch'];

        $result = search_shops_data_In_Database($shopsSearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter E-gate 
    if ($action == 'load-eGate_booking-Data') {
        $eGateLimited = $_POST['eGateLimited'];
        $eGateOrder = $_POST['eGateOrder'];
        $eGateMonth = $_POST['eGateMonth'];

        $result = filter_eGate_data_In_Database($eGateLimited, $eGateOrder, $eGateMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter search
    if ($action == 'search-eGate-Data') {
        $eGateSearch = $_POST['eGateSearch'];

        $result = search_eGate_data_In_Database($eGateSearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }


    // filter employee booking
    if ($action == 'load-employee-Data') {
        $employeeLimited = $_POST['employeeLimited'];
        $employeeOrder = $_POST['employeeOrder'];

        $result = filter_employee_data_In_Database($employeeLimited, $employeeOrder);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter employee booking search
    if ($action == 'search-employee-Data') {
        $employeeSearch = $_POST['employeeSearch'];

        $result = search_employee_data_In_Database($employeeSearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }



    // filter Utility_charges
    if ($action == 'load-Utility_charges-Data') {
        $Utility_chargesLimited = $_POST['Utility_chargesLimited'];
        $Utility_chargesOrder = $_POST['Utility_chargesOrder'];

        $result = filter_Utility_charges_data_In_Database($Utility_chargesLimited, $Utility_chargesOrder);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter Utility_charges search
    if ($action == 'search-Utility_charges-Data') {
        $Utility_chargesSearch = $_POST['Utility_chargesSearch'];

        $result = search_Utility_charges_data_In_Database($Utility_chargesSearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter events booking
    if ($action == 'load-societyMaint-Data') {
        $societyMaintLimited = $_POST['societyMaintLimited'];
        $societyMaintOrder = $_POST['societyMaintOrder'];

        $result = filter_societyMaint_data_In_Database($societyMaintLimited, $societyMaintOrder);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter events booking search
    if ($action == 'search-societyMaint-Data') {
        $societyMaintSearch = $_POST['societyMaintSearch'];

        $result = search_societyMaint_data_In_Database($societyMaintSearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }


    // expenses view reports
    if ($action == 'search-expensesReports-Data') {
        $selectUtilityMaint = $_POST['selectUtilityMaint'];
        $searchUtilityType = $_POST['searchUtilityType'];
        $searchLocation = $_POST['searchLocation'];
        $searchMaintType = $_POST['searchMaintType'];
        $searchMonth = $_POST['searchMonth'];
        $searchDropdown = $_POST['searchDropdown'];

        $result = searching_expensesReports_data_In_Database($selectUtilityMaint, $searchUtilityType, $searchLocation, $searchMaintType, $searchMonth, $searchDropdown);

        $response = array('data' => $result);
        echo json_encode($response);
    }


    // Income view reports
    if ($action == 'search-incomeReports-Data') {
        $selectIncomeReport = $_POST['selectIncomeReport'];
        $searchMonth = $_POST['searchMonth'];
        $searchDropdown = $_POST['searchDropdown'];

        $result = searching_incomeReports_data_In_Database($selectIncomeReport, $searchMonth, $searchDropdown);

        $response = array('data' => $result);
        echo json_encode($response);
    }



    // index page houses data month wise
    if ($action == 'filter-house-Data') {
        $filterHousesData = $_POST['filterHousesData'];

        $result = filter_month_house_data_In_Database($filterHousesData);
        $response = array('data' => $result);
        echo json_encode($response);
    }


    // index page shops data month wise
    if ($action == 'filter-shops-Data') {
        $filterShopsData = $_POST['filterShopsData'];

        $result = filter_month_shops_data_In_Database($filterShopsData);
        $response = array('data' => $result);
        echo json_encode($response);
    }


    // index page Users data month wise
    if ($action == 'filter-users-Data') {
        $filterUsersData = $_POST['filterUsersData'];

        $result = filter_month_users_data_In_Database($filterUsersData);
        $response = array('data' => $result);
        echo json_encode($response);
    }


    // index page Employees data month wise
    if ($action == 'filter-employees-Data') {
        $filterEmployeesData = $_POST['filterEmployeesData'];

        $result = filter_month_employees_data_In_Database($filterEmployeesData);
        $response = array('data' => $result);
        echo json_encode($response);
    }


    // index page Income data month wise
    if ($action == 'filter-income-Data') {
        $filterIncomesData = $_POST['filterIncomesData'];

        $result = filter_month_income_data_In_Database($filterIncomesData);
        $response = array('data' => $result);
        echo json_encode($response);
    }


    // index page Expences data month wise
    if ($action == 'filter-Expences-Data') {
        $filterExpencesData = $_POST['filterExpencesData'];

        $result = filter_month_expences_data_In_Database($filterExpencesData);
        $response = array('data' => $result);
        echo json_encode($response);
    }
}
