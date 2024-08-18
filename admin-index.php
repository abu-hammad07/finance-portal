<?php
include_once('includes/config.php');
require_once('includes/phpqrcode/qrlib.php');


// Feature Function to filter and display data in the table based on user input or database data depending on your database structure and requirements  

function filter_user_data_In_Database($userLimited, $userOrder, $userMonth)
{
    global $conn;

    $month = date('m', strtotime($userMonth));
    $year = date('Y', strtotime($userMonth));

    // Modify the query based on your database structure
    $query = "SELECT users.user_id, users.username, users.email, users.status, users.created_date, users_detail.Phone, role.name as role 
    FROM users
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    LEFT JOIN role ON role.role_id = users.role_id";

    if (!empty($userMonth)) {
        $query .= " WHERE MONTH(users.created_date) = $month AND YEAR(users.created_date) = $year";
    }

    $query .= " ORDER BY users.user_id $userOrder LIMIT $userLimited";

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
                <div class="dropdown"><button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">Action</button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="userEdit.php?user_edit_id=' . $row['user_id'] . '">Edit</a></li>
                        <li><a class="dropdown-item" href="userView.php?user_view_id=' . $row['user_id'] . '">VIEW</a></li>
                        <li><a class="dropdown-item" href="?user_delete_id=' . $row['user_id'] . '">Delete</a></li>
                    </ul>
                </div>
            </td>
        </tr>
        
        ';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Users data in the database. ' . $userMonth . '</td>
                </tr>';
    }

    return $data;
}
function search_user_data_In_Database($usernameSearch, $emailSearch, $userLimited, $userMonth)
{
    global $conn;

    $month = date('m', strtotime($userMonth));
    $year = date('Y', strtotime($userMonth));

    $usernameSearch = mysqli_real_escape_string($conn, $usernameSearch);
    $emailSearch = mysqli_real_escape_string($conn, $emailSearch);

    // Base query
    $query = "SELECT users.user_id, users.username, users.email, users.status, users_detail.Phone, role.name as role 
    FROM users
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    LEFT JOIN role ON role.role_id = users.role_id";

    // Adding conditions dynamically
    $conditions = [];

    if (!empty($usernameSearch)) {
        $conditions[] = "users.username LIKE '%" . $usernameSearch . "%'";
    }
    if (!empty($emailSearch)) {
        $conditions[] = "users.email LIKE '%" . $emailSearch . "%'";
    }
    if (!empty($userMonth)) {
        $conditions[] = "MONTH(users.created_date) = " . $month . " AND YEAR(users.created_date) = " . $year;
    }

    // Combine conditions with AND
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    // Final query with LIMIT
    $query .= " ORDER BY users.user_id DESC LIMIT " . intval($userLimited);

    // Execute query
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
                <div class="dropdown"><button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">Action</button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="userEdit.php?user_edit_id=' . $row['user_id'] . '">Edit</a></li>
                        <li><a class="dropdown-item" href="userView.php?user_view_id=' . $row['user_id'] . '">VIEW</a></li>
                        <li><a class="dropdown-item" href="?user_delete_id=' . $row['user_id'] . '">Delete</a></li>
                    </ul>
                </div>
            </td>
        </tr>
        
        ';
    }

    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $usernameSearch . '' . $userMonth . '' . $emailSearch . '</td>
                </tr>';
    }

    return $data;
}


function filter_events_booking_data_In_Database($eventsLimited, $paymentType, $eventsMonth, $locationSearch)
{
    global $conn;

    $month = date('m', strtotime($eventsMonth));
    $year = date('Y', strtotime($eventsMonth));

    $locationSearch = mysqli_real_escape_string($conn, $locationSearch);

    // Modify the query based on your database structure
    $eventsQuery = "SELECT * FROM events_booking";

    if (!empty($eventsMonth)) {
        $eventsQuery .= " WHERE MONTH(date) = '$month' AND YEAR(date) = '$year'";
    }
    if (!empty($paymentType)) {
        $eventsQuery .= " WHERE payment_type LIKE '%$paymentType%'";
    }
    if (!empty($locationSearch)) {
        $eventsQuery .= " WHERE location LIKE '%$locationSearch%'";
    }

    $eventsQuery .= " ORDER BY event_id DESC LIMIT $eventsLimited";

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
            <td>' . $date . '</td>
            <td>' . $startTime . ' To ' . $endTime . '</td>
            <td>' . $row['bookingPayment'] . '</td>
            <td>' . $row['payment_type'] . '</td>
            <td>
                <div class="dropdown"><button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Action</button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="eventEdit.php?event_edit_id=' . $row['event_id'] . '">Edit</a></li>
                        <li><a class="dropdown-item" href="eventView.php?event_view_id=' . $row['event_id'] . '">View</a></li>
                        <li><a class="dropdown-item" href="?booking_delete_id=' . $row['event_id'] . '">Delete</a></li>
                    </ul>
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


function search_events_booking_data_In_Database($eventNameSearch, $locationSearch, $paymentType, $eventsLimited, $eventsMonth)
{
    global $conn;

    $month = date('m', strtotime($eventsMonth));
    $year = date('Y', strtotime($eventsMonth));

    // Escape the input to avoid SQL injection
    $eventNameSearch = mysqli_real_escape_string($conn, $eventNameSearch);
    $locationSearch = mysqli_real_escape_string($conn, $locationSearch);
    $paymentType = mysqli_real_escape_string($conn, $paymentType);

    // Start building the query
    $eventsQuery = "SELECT * FROM events_booking";

    // Dynamically add conditions
    $conditions = [];

    if (!empty($eventNameSearch)) {
        $conditions[] = "eventName LIKE '%$eventNameSearch%'";
    }
    if (!empty($locationSearch)) {
        $conditions[] = "location LIKE '%$locationSearch%'";
    }
    if (!empty($paymentType)) {
        $conditions[] = "payment_type LIKE '%$paymentType%'";
    }
    if (!empty($eventsMonth)) {
        $conditions[] = "MONTH(date) = '$month' AND YEAR(date) = '$year'";
    }

    // Add conditions to the query
    if (!empty($conditions)) {
        $eventsQuery .= " WHERE " . implode(" AND ", $conditions);
    }

    // Order and limit the results
    $eventsQuery .= " ORDER BY event_id DESC LIMIT " . intval($eventsLimited);

    // Execute the query
    $eventsResult = mysqli_query($conn, $eventsQuery);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($eventsResult)) {

        // Format date and time
        $date = date("d-F-Y", strtotime($row['date']));
        $startTime = date("h:i A", strtotime($row['startTiming']));
        $endTime = date("h:i A", strtotime($row['endTiming']));

        $data .= '
        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['eventName'] . '</td>
            <td>' . $row['location'] . '</td>
            <td>' . $date . '</td>
            <td>' . $startTime . ' To ' . $endTime . '</td>
            <td>' . $row['bookingPayment'] . '</td>
            <td>' . $row['payment_type'] . '</td>
            <td>
                <div class="dropdown"><button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Action</button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="eventEdit.php?event_edit_id=' . $row['event_id'] . '">Edit</a></li>
                        <li><a class="dropdown-item" href="eventView.php?event_view_id=' . $row['event_id'] . '">View</a></li>
                        <li><a class="dropdown-item" href="?booking_delete_id=' . $row['event_id'] . '">Delete</a></li>
                    </ul>
                </div>
            </td>
        </tr>
        ';
    }

    // If no data was found, display a message
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="8" class="fw-semibold bg-light-warning text-warning text-center">There are no Found data in the database. ' . $eventNameSearch . '</td>
                </tr>';
    }

    return $data;
}


function filter_houses_data_In_Database($housesLimited, $housesMonth, $houseShopType)
{
    global $conn;

    $month = date('m', strtotime($housesMonth));
    $year = date('Y', strtotime($housesMonth));

    // Modify the query based on your database structure
    $houseQuery = "SELECT * FROM houses";

    if (!empty($housesMonth)) {
        $houseQuery .= " WHERE MONTH(added_on) = " . $month . " AND YEAR(added_on) = " . $year;
    }
    if (!empty($houseShopType)) {
        $houseQuery .= " WHERE house_or_shop LIKE '%$houseShopType%'";
    }

    $houseQuery .= " ORDER BY house_id DESC LIMIT $housesLimited";

    $houseResult = mysqli_query($conn, $houseQuery);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($houseResult)) {

        $date = date("d-F-Y", strtotime($row['added_on']));

        $data .= '
        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['house_number'] . '</td>
            <td>' . $row['house_or_shop'] . '</td>
            <td>' . $row['owner_name'] . '</td>
            <td>' . $row['owner_contact'] . '</td>
            <td>' . $row['maintenance_charges'] . '</td>
            <td>' . $date . '</td>
            <td>
                <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="houseEdit.php?house_edit_id=' . $row['house_id'] . '">Edit</a></li>
                        <li><a class="dropdown-item" href="houseView.php?house_view_id=' . $row['house_id'] . '">View</a></li>
                        <li><a class="dropdown-item" href="?house_delete_id=' . $row['house_id'] . '">Delete</a></li>
                    </ul>
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

function search_houses_data_In_Database($houseShopNoSearch, $houseShopType, $housesLimited, $housesMonth)
{
    global $conn;

    $month = date('m', strtotime($housesMonth));
    $year = date('Y', strtotime($housesMonth));

    $houseShopNoSearch = mysqli_real_escape_string($conn, $houseShopNoSearch);
    $houseShopType = mysqli_real_escape_string($conn, $houseShopType);

    // Modify the query based on your database structure
    $houseQuery = "SELECT * FROM houses";

    if (!empty($houseShopNoSearch)) {
        $houseQuery .= " WHERE house_number LIKE '%$houseShopNoSearch%'";
    }

    if (!empty($houseShopType)) {
        $houseQuery .= " WHERE house_or_shop LIKE '%$houseShopType%'";
    }

    if (!empty($housesMonth)) {
        $houseQuery .= " WHERE MONTH(added_on) = $month AND YEAR(added_on) = $year";
    }

    $houseQuery .= " ORDER BY house_id DESC LIMIT $housesLimited";

    $houseResult = mysqli_query($conn, $houseQuery);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($houseResult)) {

        $date = date("d-F-Y", strtotime($row['added_on']));

        $data .= '
        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['house_number'] . '</td>
            <td>' . $row['house_or_shop'] . '</td>
            <td>' . $row['owner_name'] . '</td>
            <td>' . $row['owner_contact'] . '</td>
            <td>' . $row['maintenance_charges'] . '</td>
            <td>' . $date . '</td>
            <td>
                <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="houseEdit.php?house_edit_id=' . $row['house_id'] . '">Edit</a></li>
                        <li><a class="dropdown-item" href="houseView.php?house_view_id=' . $row['house_id'] . '">View</a></li>
                        <li><a class="dropdown-item" href="?house_delete_id=' . $row['house_id'] . '">Delete</a></li>
                    </ul>
                </div>
                
            </td>
        </tr>
        
        ';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Found data in the database. ' . $houseShopNoSearch . '</td>
                </tr>';
    }

    return $data;
}


function filter_servant_data_In_Database($servantLimited, $servantMonth, $paymentTypeSearch)
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
    if (!empty($paymentTypeSearch)) {
        $query .= " WHERE payment_type LIKE '%$paymentTypeSearch%'";
    }
    $query .= " ORDER BY servants.servant_id DESC LIMIT $servantLimited";


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
                 <a class="d2c_danger_print_btn text-center justify-content-center text-decoration-none " href="includes/pdf_maker?servants_id=' . $row['servant_id'] . '&ACTION=VIEW" target="_blank" >  <span >
                <i class="fas fa-print mt-2" style="color: red;"></i></span></a>  
            </td>
            <td>
                <div class="dropdown"><button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">Action</button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="servantEdit.php?servant_edit_id=' . $row['servant_id'] . '">Edit</a></li>
                        <li><a class="dropdown-item" href="servantView.php?servant_view_id=' . $row['servant_id'] . '">View</a></li>
                        <li><a class="dropdown-item" href="?servant_delete_id=' . $row['servant_id'] . '">Delete</a></li>
                    </ul>
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
function search_servant_data_In_Database($houseNoSearch, $paymentTypeSearch, $servantLimited, $servantMonth)
{
    global $conn;

    $month = date('m', strtotime($servantMonth));
    $year = date('Y', strtotime($servantMonth));

    $houseNoSearch = mysqli_real_escape_string($conn, $houseNoSearch);
    $paymentTypeSearch = mysqli_real_escape_string($conn, $paymentTypeSearch);

    // Modify the query based on your database structure
    $query = "SELECT servants.*, houses.house_number, houses.owner_name 
    From servants
    INNER JOIN houses ON houses.house_id = servants.house_id ";

    // empty search
    if (!empty($houseNoSearch)) {
        $query .= " WHERE house_number LIKE '%$houseNoSearch%'";
    }
    if (!empty($paymentTypeSearch)) {
        $query .= " WHERE payment_type LIKE '%$paymentTypeSearch%'";
    }

    if (!empty($servantMonth)) {
        $query .= " WHERE MONTH(servants.added_on) = '$month' AND YEAR(servants.added_on) = '$year'";
    }
    $query .= " ORDER BY servants.servant_id DESC LIMIT $servantLimited";


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
                <a class="d2c_danger_print_btn text-center justify-content-center text-decoration-none " href="includes/pdf_maker?servants_id=' . $row['servant_id'] . '&ACTION=VIEW" target="_blank" >  <span >
                <i class="fas fa-print mt-2" style="color: red;"></i></span></a>  
            </td>
            <td>
                <div class="dropdown"><button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">Action</button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="servantEdit.php?servant_edit_id=' . $row['servant_id'] . '">Edit</a></li>
                        <li><a class="dropdown-item" href="servantView.php?servant_view_id=' . $row['servant_id'] . '">View</a></li>
                        <li><a class="dropdown-item" href="?servant_delete_id=' . $row['servant_id'] . '">Delete</a></li>
                    </ul>
                </div>
            </td>
        </tr>
        
        ';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $houseNoSearch . '</td>
                </tr>';
    }

    return $data;
}


function filter_tenant_data_In_Database($tenantLimited, $tenantMonth)
{
    global $conn;

    $month = date('m', strtotime($tenantMonth));
    $year = date('Y', strtotime($tenantMonth));

    // Modify the query based on your database structure
    $query = "SELECT tenants.*, houses.house_number
        FROM tenants
        LEFT JOIN houses ON tenants.house_id = houses.house_id";

    if (!empty($tenantMonth)) {
        $query .= " WHERE MONTH(tenants.added_on) = $month AND YEAR(tenants.added_on) = $year";
    }

    $query .= " ORDER BY tenants.tenant_id DESC LIMIT $tenantLimited";

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
        $date = date('d-F-Y', strtotime($row['added_on']));

        $data .= '<tr>
            <td>' . $count++ . '</td>
            <td>' . $row['house_number'] . '</td>
            <td>' . $row['tenant_name'] . '</td>
            <td>' . $row['tenant_contact_no'] . '</td>
            <td>' . $row['tenant_cnic'] . '</td>
            <td>' . $date . '</td>
            <td>
                <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="tenantEdit.php?tenant_edit_id=' . $row['tenant_id'] . '">Edit</a></li>
                        <li><a class="dropdown-item" href="tenantView.php?tenant_view_id=' . $row['tenant_id'] . '">View</a></li>
                        <li><a class="dropdown-item" href="?tenant_delete_id=' . $row['tenant_id'] . '">Delete</a></li>
                    </ul>
                </div>
            </td>
        </tr>';
    }

    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Tenants data in the database. ' . $tenantMonth . '</td>
                </tr>';
    }

    return $data;
}

function search_tenant_data_In_Database($houseShopNoSearch, $phoneNoType, $tenantLimited, $tenantMonth)
{
    global $conn;

    $month = date('m', strtotime($tenantMonth));
    $year = date('Y', strtotime($tenantMonth));

    $houseShopNoSearch = mysqli_real_escape_string($conn, $houseShopNoSearch);
    $phoneNoType = mysqli_real_escape_string($conn, $phoneNoType);

    // Modify the query based on your database structure
    $query = "SELECT tenants.*, houses.house_number
    From tenants
    LEFT JOIN houses ON tenants.house_id = houses.house_id";

    if (!empty($houseShopNoSearch)) {
        $query .= " WHERE houses.house_number LIKE '%" . $houseShopNoSearch . "%'";
    }

    if (!empty($phoneNoType)) {
        $query .= " WHERE tenants.tenant_contact_no LIKE '" . $phoneNoType . "'";
    }

    if (!empty($tenantMonth)) {
        $query .= " WHERE MONTH(tenants.added_on) = $month AND YEAR(tenants.added_on) = $year";
    }

    $query .= " ORDER BY tenants.tenant_id DESC LIMIT $tenantLimited";

    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $date = date('d-F-Y', strtotime($row['added_on']));

        $data .= '<tr>
            <td>' . $count++ . '</td>
            <td>' . $row['house_number'] . '</td>
            <td>' . $row['tenant_name'] . '</td>
            <td>' . $row['tenant_contact_no'] . '</td>
            <td>' . $row['tenant_cnic'] . '</td>
            <td>' . $date . '</td>
            <td>
                <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="tenantEdit.php?tenant_edit_id=' . $row['tenant_id'] . '">Edit</a></li>
                        <li><a class="dropdown-item" href="tenantView.php?tenant_view_id=' . $row['tenant_id'] . '">View</a></li>
                        <li><a class="dropdown-item" href="?tenant_delete_id=' . $row['tenant_id'] . '">Delete</a></li>
                    </ul>
                </div>
            </td>
        </tr>';

    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Found data in the database. ' . $houseShopNoSearch . ' ' . $tenantMonth . ' ' . $phoneNoType . '</td>
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


function filter_eGate_data_In_Database($eGateLimited, $eGateMonth, $paymentTypeSearch)
{
    global $conn;

    $month = date('m', strtotime($eGateMonth));
    $year = date('Y', strtotime($eGateMonth));

    $paymentTypeSearch = mysqli_real_escape_string($conn, $paymentTypeSearch);

    $houseQuery = "SELECT egate.*, houses.house_number 
               FROM egate
               LEFT JOIN houses ON egate.house_id = houses.house_id";

    if (!empty($eGateMonth)) {
        $houseQuery .= " WHERE MONTH(egate.added_on) = '$month' AND YEAR(egate.added_on) = '$year'";
    }
    if(!empty($paymentTypeSearch)){
        $houseQuery .= " WHERE payment_type LIKE '%$paymentTypeSearch%'";
    }

    $houseQuery .= " ORDER BY egate.eGate_id DESC LIMIT $eGateLimited";

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
            <td>' . $count++ . '</td>
            <td>' . $row['house_number'] . '</td>
            <td>' . $row['eGateperson_name'] . '</td>
            <td>' . $row['vehicle_number'] . '</td>
            <td>' . $row['eGate_charges'] . '</td>
            <td>' . $row['payment_type'] . '</td>
            <td>
                <a class="d2c_danger_print_btn text-center justify-content-center text-decoration-none " href="includes/pdf_maker?eGate_id=' . $row['eGate_id'] . '&ACTION=VIEW" target="_blank" >  <span >
                <i class="fas fa-print mt-2" style="color: red;"></i></span>
                </a>  
            </td>
            <td>
                <div class="dropdown"><button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">Action</button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="eGateEdit?eGate_edit_id=' . $row['eGate_id'] . '">Edit</a></li>
                        <li><a class="dropdown-item" href="eGateView?eGate_view_id=' . $row['eGate_id'] . '">View</a></li>
                        <li><a class="dropdown-item" href="?eGate_delete_id=' . $row['eGate_id'] . '">Delete</a></li>
                    </ul>
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


function search_eGate_data_In_Database($houseShopNoSearch, $paymentTypeSearch, $vehicleNoSearch, $eGateMonth, $eGateLimited)
{
    global $conn;

    $month = date('m', strtotime($eGateMonth));
    $year = date('Y', strtotime($eGateMonth));

    $houseShopNoSearch = mysqli_real_escape_string($conn, $_POST['houseShopNoSearch']);
    $paymentTypeSearch = mysqli_real_escape_string($conn, $_POST['paymentTypeSearch']);
    $vehicleNoSearch = mysqli_real_escape_string($conn, $_POST['vehicleNoSearch']);

    // Modify the query based on your database structure
    $houseQuery = "SELECT egate.*, houses.house_number
    FROM egate
    LEFT JOIN houses ON egate.house_id = houses.house_id";

    if (!empty($houseShopNoSearch)) {
        $houseQuery .= " WHERE house_number LIKE '%$houseShopNoSearch%'";
    }
    if (!empty($paymentTypeSearch)) {
        $houseQuery .= " WHERE paymetn_type LIKE '%$paymentTypeSearch%'";
    }
    if (!empty($vehicleNoSearch)) {
        $houseQuery .= " WHERE vehicle_name LIKE '%$vehicleNoSearch%'";
    }
    if (!empty($eGateMonth)) {
        $houseQuery .= " WHERE MONTH(egate.added_on) = '$month' AND YEAR(egate.added_on) = '$year'";
    }

    $houseQuery .= " ORDER BY egate.eGate_id DESC LIMIT $eGateLimited";

    $houseResult = mysqli_query($conn, $houseQuery);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($houseResult)) {

        $data .= '
        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['house_number'] . '</td>
            <td>' . $row['eGateperson_name'] . '</td>
            <td>' . $row['vehicle_name'] . '</td>
            <td>' . $row['vehicle_number'] . '</td>
            <td>' . $row['eGate_charges'] . '</td>
            <td>
                <a class="d2c_danger_print_btn text-center justify-content-center text-decoration-none " href="includes/pdf_maker?eGate_id=' . $row['eGate_id'] . '&ACTION=VIEW" target="_blank" >  <span >
                <i class="fas fa-print mt-2" style="color: red;"></i></span>
                </a>  
            </td>
            <td>
                <div class="dropdown"><button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                  aria-expanded="false">Action</button>
                  <ul class="dropdown-menu text-center">
                      <li><a class="dropdown-item" href="eGateEdit?eGate_edit_id=' . $row['eGate_id'] . '">Edit</a></li>
                      <li><a class="dropdown-item" href="eGateView?eGate_view_id=' . $row['eGate_id'] . '">View</a></li>
                      <li><a class="dropdown-item" href="?eGate_delete_id=' . $row['eGate_id'] . '">Delete</a></li>
                  </ul>
              </div>
            </td>
        </tr>';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $houseShopNoSearch . ',' . $paymentTypeSearch . ',' . $vehicleNoSearch . '</td>
                </tr>';
    }

    return $data;
}


function filter_employee_data_In_Database($employeeLimited, $employeeMonth)
{
    global $conn;

    $month = date('m', strtotime($employeeMonth));
    $year = date('Y', strtotime($employeeMonth));

    // Modify the query based on your database structure
    $employeeQuery = "SELECT * FROM employees";

    if (!empty($employeeMonth)) {
        $employeeQuery .= " WHERE MONTH(added_on) = $month AND YEAR(added_on) = $year";
    }

    $employeeQuery .= " ORDER BY employee_id DESC LIMIT $employeeLimited";

    $employeeResult = mysqli_query($conn, $employeeQuery);

    if (!$employeeResult) {
        // Debugging output for SQL errors
        $_SESSION['error_updated_employee'] = ("Error executing query: " . mysqli_error($conn));
        header("Location: employee");
        exit();
    }

    $data = '';
    $count = 1;

    while ($row = mysqli_fetch_assoc($employeeResult)) {

        $data .= '
        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['employeeID'] . '</td>
            <td>' . $row['employee_full_name'] . '</td>
            <td>' . $row['employee_cnic'] . '</td>
            <td>' . $row['employement_type'] . '</td>
            <td>' . $row['department'] . '</td>
            <td>
                <a class="d2c_danger_print_btn text-center justify-content-center text-decoration-none " style="color: red;" href="includes/pdf_maker?employee_id=' . $row['employee_id'] . '&ACTION=VIEW" target="_blank">
                    <span><i class="fas fa-print mt-2"></i></span>
                </a>
            </td>
            <td>
                <div class="dropdown"><button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">Action</button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="employeeEdit?employee_edit_id=' . $row['employee_id'] . '">Edit</a></li>
                        <li><a class="dropdown-item" href="employeeView?employee_view_id=' . $row['employee_id'] . '">View</a></li>
                        <li><a class="dropdown-item" href="?employee_delete_id=' . $row['employee_id'] . '">Delete</a></li>
                    </ul>
                </div>
            </td>
        </tr>';
    }



    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Employee data in the database. ' . $employeeMonth . '</td>
                </tr>';
    }

    return $data;
}


function search_employee_data_In_Database($nameEmployeeSearch, $IDemployeeSearch, $employeeLimited, $employeeMonth)
{
    global $conn;

    $month = date('m', strtotime($employeeMonth));
    $year = date('Y', strtotime($employeeMonth));

    $nameEmployeeSearch = mysqli_real_escape_string($conn, $_POST['nameEmployeeSearch']);
    $IDemployeeSearch = mysqli_real_escape_string($conn, $_POST['IDemployeeSearch']);

    // Modify the query based on your database structure
    $houseQuery = "SELECT * FROM employees";

    if (!empty($nameEmployeeSearch)) {
        $houseQuery .= " WHERE employee_full_name LIKE '%$nameEmployeeSearch%'";
    }
    if (!empty($IDemployeeSearch)) {
        $houseQuery .= " WHERE employee_full_name LIKE '%$IDemployeeSearch%'";
    }
    if (!empty($employeeMonth)) {
        $houseQuery .= " WHERE MONTH(added_on) = $month AND YEAR(added_on) = $year";
    }

    $houseQuery .= " ORDER BY employee_id DESC LIMIT $employeeLimited";

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
        <td>' . $row['employeeID'] . '</td>
        <td>' . $row['employee_full_name'] . '</td>
        <td>' . $row['employee_cnic'] . '</td>
        <td>' . $row['employement_type'] . '</td>
        <td>' . $row['department'] . '</td>
        <td>
            <a class="d2c_danger_print_btn text-center justify-content-center text-decoration-none " style="color: red;" href="includes/pdf_maker?employee_id=' . $row['employee_id'] . '&ACTION=VIEW" target="_blank">
                <span><i class="fas fa-print mt-2"></i></span>
            </a>
        </td>
        <td>
            <div class="dropdown"><button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">Action</button>
                <ul class="dropdown-menu text-center">
                    <li><a class="dropdown-item" href="employeeEdit?employee_edit_id=' . $row['employee_id'] . '">Edit</a></li>
                    <li><a class="dropdown-item" href="employeeView?employee_view_id=' . $row['employee_id'] . '">View</a></li>
                    <li><a class="dropdown-item" href="?employee_delete_id=' . $row['employee_id'] . '">Delete</a></li>
                </ul>
            </div>
        </td>
    </tr>';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $nameEmployeeSearch . '' . $IDemployeeSearch . '</td>
                </tr>';
    }

    return $data;
}


function filter_Utility_charges_data_In_Database($Utility_chargesLimited, $Utility_chargesMonth, $paymentUtilitySearch)
{
    global $conn;

    $month = date('m', strtotime($Utility_chargesMonth));
    $year = date('Y', strtotime($Utility_chargesMonth));

    $paymentUtilitySearch = mysqli_real_escape_string($conn, $_POST['paymentUtilitySearch']);

    // Modify the query based on your database structure
    $houseQuery = "SELECT * FROM utility_charges";

    if (!empty($Utility_chargesMonth)) {
        $houseQuery .= " WHERE MONTH(utility_billing_month) = $month AND YEAR(utility_billing_month) = $year";
    }
    if (!empty($paymentUtilitySearch)) {
        $houseQuery .= " WHERE payment_type LIKE '%$paymentUtilitySearch%'";
    }

    $houseQuery .= " ORDER BY utility_id DESC LIMIT $Utility_chargesLimited";

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
        $billingDate = date('F-Y', strtotime($row['utility_billing_month']));
        $data .= '
        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['utility_type'] . '</td>
            <td>' . $row['utility_amount'] . '</td>
            <td>' . $billingDate . '</td>
            <td>' . $row['utility_location'] . '</td>
            <td>' . $row['payment_type'] . '</td>
            <td>
                <div class="dropdown"><button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">Action</button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="utilityEdit?utility_edit_id=' . $row['utility_id'] . '">Edit</a></li>
                        <li><a class="dropdown-item" href="?utility_delete_id=' . $row['utility_id'] . '">Delete</a></li>
                    </ul>
                </div>
            </td>
        </tr>';
    }

    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Employee data in the database. ' . $Utility_chargesMonth . '</td>
                </tr>';
    }

    return $data;
}


function search_Utility_charges_data_In_Database($UtilityTypeSearch, $paymentUtilitySearch, $Utility_chargesLimited, $Utility_chargesMonth)
{
    global $conn;

    $month = date('m', strtotime($Utility_chargesMonth));
    $year = date('Y', strtotime($Utility_chargesMonth));

    $UtilityTypeSearch = mysqli_real_escape_string($conn, $_POST['UtilityTypeSearch']);
    $paymentUtilitySearch = mysqli_real_escape_string($conn, $_POST['paymentUtilitySearch']);

    // Modify the query based on your database structure
    $houseQuery = "SELECT * FROM utility_charges";

    if (!empty($UtilityTypeSearch)) {
        $houseQuery .= " WHERE utility_type LIKE '%$UtilityTypeSearch%'";
    }
    if (!empty($paymentUtilitySearch)) {
        $houseQuery .= " WHERE payment_type LIKE '%$paymentUtilitySearch%'";
    }
    if (!empty($Utility_chargesMonth)) {
        $houseQuery .= " WHERE MONTH(utility_billing_month) = $month AND YEAR(utility_billing_month) = $year";
    }

    $houseQuery .= " ORDER BY utility_id DESC LIMIT $Utility_chargesLimited";

    $houseResult = mysqli_query($conn, $houseQuery);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($houseResult)) {

        $billingDate = date('F-Y', strtotime($row['utility_billing_month']));

        $data .= '
        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['utility_type'] . '</td>
            <td>' . $row['utility_amount'] . '</td>
            <td>' . $billingDate . '</td>
            <td>' . $row['utility_location'] . '</td>
            <td>' . $row['payment_type'] . '</td>
            <td>
                <div class="dropdown"><button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">Action</button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="utilityEdit?utility_edit_id=' . $row['utility_id'] . '">Edit</a></li>
                        <li><a class="dropdown-item" href="?utility_delete_id=' . $row['utility_id'] . '">Delete</a></li>
                    </ul>
                </div>
            </td>
        </tr>';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data in the database. ' . $UtilityTypeSearch . '</td>
                </tr>';
    }

    return $data;
}



function filter_societyMaint_data_In_Database($societyMaintLimited, $societyMaintDate)
{
    global $conn;

    $month = date('m', strtotime($societyMaintDate));
    $year = date('Y', strtotime($societyMaintDate));

    // Modify the query based on your database structure
    $houseQuery = "SELECT * FROM society_maintenance";

    if (!empty($societyMaintDate)) {
        $houseQuery .= " WHERE MONTH(society_maint_paymentDate) = $month AND YEAR(society_maint_paymentDate) = $year";
    }

    $houseQuery .= " ORDER BY society_maint_id DESC LIMIT $societyMaintLimited";

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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no suciety maintenance data in the database. ' . $societyMaintDate . '</td>
                </tr>';
    }

    return $data;
}


function search_societyMaint_data_In_Database($societyMaintSearch, $societyMaintLimited, $societyMaintDate)
{
    global $conn;

    $month = date('m', strtotime($societyMaintDate));
    $year = date('Y', strtotime($societyMaintDate));

    $societyMaintSearch = mysqli_real_escape_string($conn, $_POST['societyMaintSearch']);

    // Modify the query based on your database structure
    $houseQuery = "SELECT * FROM society_maintenance";

    if (!empty($societyMaintSearch)) {
        $houseQuery .= " WHERE society_maint_type LIKE '%$societyMaintSearch%'";
    }
    if (!empty($societyMaintDate)) {
        $houseQuery .= " WHERE MONTH(society_maint_paymentDate) = $month AND YEAR(society_maint_paymentDate) = $year";
    }

    $houseQuery .= " ORDER BY society_maint_id DESC LIMIT $societyMaintLimited";


    $houseResult = mysqli_query($conn, $houseQuery);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($houseResult)) {

        $data .= '
        <tr>
        <td>' . $count++ . '</td>
            <td>' . $row['society_maint_type'] . '</td>
            <td>' . $row['society_maint_amount'] . '</td>
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
            $queryMaint .= " AND month(society_maint_paymentDate) = '$month' AND year(society_maint_paymentDate) = '$year'";
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
        $userMonth = $_POST['userMonth'];

        $result = filter_user_data_In_Database($userLimited, $userOrder, $userMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }
    // Filter user search
    if ($action == 'search-user-Data') {
        $usernameSearch = $_POST['usernameSearch'];
        $emailSearch = $_POST['emailSearch'];
        $userLimited = $_POST['userLimited'];
        $userMonth = $_POST['userMonth'];

        $result = search_user_data_In_Database($usernameSearch, $emailSearch, $userLimited, $userMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter events booking
    if ($action == 'load-events_booking-Data') {
        $eventsLimited = $_POST['eventsLimited'];
        $paymentType = $_POST['paymentType'];
        $eventsMonth = $_POST['eventsMonth'];
        $locationSearch = $_POST['locationSearch'];
        ;
        $result = filter_events_booking_data_In_Database($eventsLimited, $paymentType, $eventsMonth, $locationSearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter events booking search
    if ($action == 'search-events_booking-Data') {
        $eventNameSearch = $_POST['eventNameSearch'];
        $locationSearch = $_POST['locationSearch'];
        $paymentType = $_POST['paymentType'];
        $eventsLimited = $_POST['eventsLimited'];
        $eventsMonth = $_POST['eventsMonth'];

        $result = search_events_booking_data_In_Database($eventNameSearch, $locationSearch, $paymentType, $eventsLimited, $eventsMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter Society Houses 
    if ($action == 'load-houses-Data') {
        $housesLimited = $_POST['housesLimited'];
        $housesMonth = $_POST['housesMonth'];
        $houseShopType = $_POST['houseShopType'];


        $result = filter_houses_data_In_Database($housesLimited, $housesMonth, $houseShopType);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter Society Houses search
    if ($action == 'search-houses-Data') {
        $houseShopNoSearch = $_POST['houseShopNoSearch'];
        $houseShopType = $_POST['houseShopType'];
        $housesLimited = $_POST['housesLimited'];
        $housesMonth = $_POST['housesMonth'];

        $result = search_houses_data_In_Database($houseShopNoSearch, $houseShopType, $housesLimited, $housesMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // Filter servant load
    if ($action == 'load-servant-Data') {
        $servantLimited = $_POST['servantLimited'];
        $servantMonth = $_POST['servantMonth'];
        $paymentTypeSearch = $_POST['paymentTypeSearch'];

        $result = filter_servant_data_In_Database($servantLimited, $servantMonth, $paymentTypeSearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }
    // Filter servant search
    if ($action == 'search-servant-Data') {
        $houseNoSearch = $_POST['houseNoSearch'];
        $paymentTypeSearch = $_POST['paymentTypeSearch'];
        $servantLimited = $_POST['servantLimited'];
        $servantMonth = $_POST['servantMonth'];

        $result = search_servant_data_In_Database($houseNoSearch, $paymentTypeSearch, $servantLimited, $servantMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // Filter tenants load
    if ($action == 'load-tenant-Data') {
        $tenantLimited = $_POST['tenantLimited'];
        $tenantMonth = $_POST['tenantMonth'];


        $result = filter_tenant_data_In_Database($tenantLimited, $tenantMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // Filter tenant search
    if ($action == 'search-tenant-Data') {
        $houseShopNoSearch = $_POST['houseShopNoSearch'];
        $phoneNoType = $_POST['phoneNoType'];
        $tenantLimited = $_POST['tenantLimited'];
        $tenantMonth = $_POST['tenantMonth'];

        $result = search_tenant_data_In_Database($houseShopNoSearch, $phoneNoType, $tenantLimited, $tenantMonth);

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
        $eGateMonth = $_POST['eGateMonth'];
        $paymentTypeSearch = $_POST['paymentTypeSearch'];

        $result = filter_eGate_data_In_Database($eGateLimited, $eGateMonth, $paymentTypeSearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter search
    if ($action == 'search-eGate-Data') {
        $houseShopNoSearch = $_POST['houseShopNoSearch'];
        $paymentTypeSearch = $_POST['paymentTypeSearch'];
        $vehicleNoSearch = $_POST['vehicleNoSearch'];
        $eGateMonth = $_POST['eGateMonth'];
        $eGateLimited = $_POST['eGateLimited'];

        $result = search_eGate_data_In_Database($houseShopNoSearch, $paymentTypeSearch, $vehicleNoSearch, $eGateMonth, $eGateLimited);

        $response = array('data' => $result);
        echo json_encode($response);
    }


    // filter employee booking
    if ($action == 'load-employee-Data') {
        $employeeLimited = $_POST['employeeLimited'];
        // $employeeOrder = $_POST['employeeOrder'];
        $employeeMonth = $_POST['employeeMonth'];

        $result = filter_employee_data_In_Database($employeeLimited, $employeeMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter employee booking search
    if ($action == 'search-employee-Data') {
        $nameEmployeeSearch = $_POST['nameEmployeeSearch'];
        $IDemployeeSearch = $_POST['IDemployeeSearch'];
        $employeeLimited = $_POST['employeeLimited'];
        $employeeMonth = $_POST['employeeMonth'];

        $result = search_employee_data_In_Database($nameEmployeeSearch, $IDemployeeSearch, $employeeLimited, $employeeMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }



    // filter Utility_charges
    if ($action == 'load-Utility_charges-Data') {
        $Utility_chargesLimited = $_POST['Utility_chargesLimited'];
        $Utility_chargesMonth = $_POST['Utility_chargesMonth'];
        $paymentUtilitySearch = $_POST['paymentUtilitySearch'];

        $result = filter_Utility_charges_data_In_Database($Utility_chargesLimited, $Utility_chargesMonth, $paymentUtilitySearch);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter Utility_charges search
    if ($action == 'search-Utility_charges-Data') {
        $UtilityTypeSearch = $_POST['UtilityTypeSearch'];
        $paymentUtilitySearch = $_POST['paymentUtilitySearch'];
        $Utility_chargesLimited = $_POST['Utility_chargesLimited'];
        $Utility_chargesMonth = $_POST['Utility_chargesMonth'];

        $result = search_Utility_charges_data_In_Database($UtilityTypeSearch, $paymentUtilitySearch, $Utility_chargesLimited, $Utility_chargesMonth);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter events booking
    if ($action == 'load-societyMaint-Data') {
        $societyMaintLimited = $_POST['societyMaintLimited'];
        $societyMaintDate = $_POST['societyMaintDate'];

        $result = filter_societyMaint_data_In_Database($societyMaintLimited, $societyMaintDate);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter events booking search
    if ($action == 'search-societyMaint-Data') {
        $societyMaintSearch = $_POST['societyMaintSearch'];
        $societyMaintLimited = $_POST['societyMaintLimited'];
        $societyMaintDate = $_POST['societyMaintDate'];

        $result = search_societyMaint_data_In_Database($societyMaintSearch, $societyMaintLimited, $societyMaintDate);

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
