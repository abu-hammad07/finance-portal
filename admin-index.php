<?php
include_once('includes/config.php');


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

function filter_events_booking_data_In_Database($eventsLimited, $eventsOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $eventsQuery = "SELECT * FROM events_booking
    ORDER BY event_id $eventsOrder LIMIT $eventsLimited";

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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Events Booking data in the database.</td>
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
            <td>' . $row['owner_cnic']  . '</td>
            <td>' . $row['occupancy_status'] . '</td>
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
            <td>' . $row['owner_cnic']  . '</td>
            <td>' . $row['occupancy_status'] . '</td>
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


function filter_servant_data_In_Database($servantLimited, $servantOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $query = "SELECT servants.*, houses.house_number, houses.owner_name From servants
    INNER JOIN houses ON houses.house_id = servants.house_id 
    ORDER BY servants.servant_id $servantOrder LIMIT $servantLimited;
    ";
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no servants data in the database.</td>
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
    $query = "SELECT tenants.*, houses.house_number From tenants
    INNER JOIN houses ON tenants.house_id = houses.house_id 
    ORDER BY tenants.tenant_id $tenantOrder LIMIT $tenantLimited;
    ";
    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '

        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['house_number'] . '</td>
            <td>' . $row['tenant_name'] . '</td>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no servants data in the database.</td>
                </tr>';
    }

    return $data;
}

function search_tenant_data_In_Database($tenantSearch)
{
    global $conn;

    $tenantSearch = mysqli_real_escape_string($conn, $tenantSearch);

    // Modify the query based on your database structure
    $query = "SELECT tenants.*, houses.house_number From tenants
    INNER JOIN houses ON tenants.house_id = houses.house_id";

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
            <td>' . $count++ . '</td>
            <td>' . $row['house_number'] . '</td>
            <td>' . $row['tenant_name'] . '</td>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no servants data in the database.</td>
                </tr>';
    }

    return $data;
}



function filter_shops_data_In_Database($shopsLimited, $shopsOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $houseQuery = "SELECT * FROM shops
    ORDER BY shop_id $shopsOrder LIMIT $shopsLimited";

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
            <td>' . $row['owner_cnic']  . '</td>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no shops data in the database.</td>
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
            <td>' . $row['owner_cnic']  . '</td>
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


function filter_eGate_data_In_Database($eGateLimited, $eGateOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $houseQuery = "SELECT egate.*, houses.house_number, shops.shop_number 
                   FROM egate
                   LEFT JOIN houses ON egate.house_id = houses.house_id
                   LEFT JOIN shops ON egate.shop_id = shops.shop_id
                   ORDER BY egate.eGate_id $eGateOrder 
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no entries in the database.</td>
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
        $data .= '
        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['employee_full_name'] . '</td>
            <td>' . $row['employee_cnic'] . '</td>
            <td>' . $row['employement_type'] . '</td>
            <td>' . $row['department'] . '</td>
            <td>' . $row['designation'] . '</td>
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
                                      <a href="?employee_delete_id=' . $row['employee_full_name'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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

        $data .= '
        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['employee_full_name'] . '</td>
            <td>' . $row['employee_cnic'] . '</td>
            <td>' . $row['employement_type'] . '</td>
            <td>' . $row['department'] . '</td>
            <td>' . $row['designation'] . '</td>
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
                                      <a href="?employee_delete_id=' . $row['employee_full_name'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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

        $result = filter_events_booking_data_In_Database($eventsLimited, $eventsOrder);

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

        $result = filter_servant_data_In_Database($servantLimited, $servantOrder);

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

        $result = filter_shops_data_In_Database($shopsLimited, $shopsOrder);

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

        $result = filter_eGate_data_In_Database($eGateLimited, $eGateOrder);

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
}
