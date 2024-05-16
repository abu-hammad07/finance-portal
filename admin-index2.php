<?php
include_once('includes/config.php');
// ------------filter penalty-----------
function filter_penalty_data_In_Database($penaltyLimited, $penaltyOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $query = "SELECT * FROM penalty 
    ORDER BY id $penaltyOrder LIMIT $penaltyLimited;
    ";
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no penaltys data in the database.</td>
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


if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // ------------filter penalty-----------
    if ($action == 'load-penalty-Data') {
        $penaltyLimited = $_POST['penaltyLimited'];
        $penaltyOrder = $_POST['penaltyOrder'];

        $result = filter_penalty_data_In_Database($penaltyLimited, $penaltyOrder);

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
}