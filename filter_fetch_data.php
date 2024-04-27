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
}
