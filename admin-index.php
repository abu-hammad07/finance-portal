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
    $eventsQuery = "SELECT event_id, eventName, location, dateTime, noOfServant, servants.servant_name
    FROM events_booking
    LEFT JOIN servants ON events_booking.servant_id = servants.servant_id
    ORDER BY events_booking.event_id $eventsOrder LIMIT $eventsLimited";

    $eventsResult = mysqli_query($conn, $eventsQuery);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($eventsResult)) {

        // Modify date & time format
        $date_time = $row['dateTime'];
        $date = substr($date_time, 0, 10);
        $time = date("h:i A", strtotime(substr($date_time, 11, 5)));

        $data .= '

        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['eventName'] . '</td>
            <td>' . $row['location'] . '</td>
            <td>' . $date . '<br>' . $time . '</td>
            <td>' . $row['noOfServant'] . '</td>
            <td>' . $row['servant_name'] . '</td>
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
                                <a href="?event_delete_id=' . $row['event_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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
    $eventsQuery = "SELECT event_id, eventName, location, dateTime, noOfServant, servants.servant_name
    FROM events_booking
    LEFT JOIN servants ON events_booking.servant_id = servants.servant_id";

    if (!empty($eventsSearch)) {
        $eventsQuery .= " WHERE eventName LIKE '%" . $eventsSearch . "%' 
        OR location LIKE '%" . $eventsSearch . "%'
        OR noOfServant LIKE '%" . $eventsSearch . "%'
        OR servant_name LIKE '%" . $eventsSearch . "%'";
    }

    $eventsResult = mysqli_query($conn, $eventsQuery);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($eventsResult)) {

        // Modify date & time format
        $date_time = $row['dateTime'];
        $date = substr($date_time, 0, 10);
        $time = date("h:i A", strtotime(substr($date_time, 11, 5)));

        $data .= '

        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['eventName'] . '</td>
            <td>' . $row['location'] . '</td>
            <td>' . $date . '<br>' . $time . '</td>
            <td>' . $row['noOfServant'] . '</td>
            <td>' . $row['servant_name'] . '</td>
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
                                <a href="?event_delete_id=' . $row['event_id'] . '" class="btn btn-danger" name="deleteUser">Delete</a>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. '.$eventsSearch.'</td>
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
            <td>' . $row['occupancy_status']  . '</td>
            <td>' . $row['tenants_name'] . '</td>
            <td>' . $row['tenants_contact'] . '</td>
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
        OR owner_contact LIKE '%" . $housesSearch . "%'";
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
            <td>' . $row['occupancy_status']  . '</td>
            <td>' . $row['tenants_name'] . '</td>
            <td>' . $row['tenants_contact'] . '</td>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. '. $housesSearch .'</td>
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

}
