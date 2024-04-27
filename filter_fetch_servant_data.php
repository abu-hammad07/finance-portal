<?php
include_once('includes/config.php');

// Feature Function to filter and display data in the table based on user input or database data depending on your database structure and requirements  


function filter_user_data_In_Database($userLimited, $userOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $query = "SELECT *From servants LIMIT $userLimited;
    ";
    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '

        <tr>
                                                    <td>' . $count++ . '</td>
                                                    <td>' . $row['servant_name'] . '</td>
                                                    <td>' . $row['email'] . '</td>
                                                    <td>' . $row['phone'] . '</td>
                                                    <td>' . $row['gender'] . '</td>
                                                    <td>' . $row['address'] . '</td>
                                                    <td>' . $row['image'] . '</td>
                                                    <td>' . $row['status'] . '</td>
                                                    <td>
                                                        <a href="edit_servant.php?id=' . $row['servant_id'] . '">
                                                            <span>
                                                                <i class="fas fa-pencil-alt me-1 text-success"></i>
                                                            </span>
                                                        </a>
                                                        <a class="" href="view_servant.php?id=' . $row['servant_id'] . '">
                                                            <i class="fas fa-eye me-1 text-info"></i>
                                                        </a>
                                                        <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteIncome' . $row['user_id'] . '" data-bs-placement="top" title="Delete">
                                                            <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash  text-danger p-1 "></i></span>
                                                        </button>
                                                        <div class="modal fade" id="deleteIncome' . $row['servant_id']. '" tabindex="-1" aria-hidden="true">
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
                                                                        <a href="?id=' . $row['servant_id'] . '" class="btn btn-danger" name="delete_Income">Delete</a>
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
    $query = "SELECT * FROM servants";

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
                                                    <td>' . $row['servant_name'] . '</td>
                                                    <td>' . $row['email'] . '</td>
                                                    <td>' . $row['phone'] . '</td>
                                                    <td>' . $row['gender'] . '</td>
                                                    <td>' . $row['address'] . '</td>
                                                    <td>' . $row['status'] . '</td>
                                                    <td>
                                                    <a href="edit_servant.php?id=' . $row['servant_id'] . '">
                                                            <span>
                                                                <i class="fas fa-pencil-alt me-1 text-success"></i>
                                                            </span>
                                                        </a>
                                                        <a class="" href="view_servant.php?id=' . $row['servant_id'] . '">
                                                            <i class="fas fa-eye me-1 text-info"></i>
                                                        </a>
                                                        <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteIncome' . $row['user_id'] . '" data-bs-placement="top" title="Delete">
                                                            <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fas fa-trash  text-danger p-1 "></i></span>
                                                        </button>
                                                        <div class="modal fade" id="deleteIncome'. $row['servant_id']. '" tabindex="-1" aria-hidden="true">
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
                                                                        <a href="?income_delete_id=' . $row['servant_id'].'" class="btn btn-danger" name="delete_Income">Delete</a>
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
