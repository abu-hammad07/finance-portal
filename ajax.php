<?php

include_once("includes/config.php");

// ==================== fetch multi input ========================
$fetch_servant_data = '';
$fetchHousesData = '';
// $eGateData = '';
$houseOptions = '';
$shopOptions = '';

if (isset($_POST['type'])) {
    $type = $_POST['type'];
    switch ($type) {
        case "servantName_Data":
            $sql = "SELECT servant_id, servant_name FROM servants";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                $fetch_servant_data = '';
                while ($row = mysqli_fetch_assoc($query)) {
                    $fetch_servant_data .= "<option value='{$row['servant_id']}'>{$row['servant_name']}</option>";
                }
            } else {
                $fetch_servant_data = 'Query unsuccessful: ' . mysqli_error($conn);
            }
            break;
        case "servantEmail_Data":
        case "servantAddress_Data":
        case "servantStatus_Data":
            if (isset($_POST['id'])) {
                $stId = $_POST['id'];
                $columnName = '';
                switch ($type) {
                    case "servantEmail_Data":
                        $columnName = 'email';
                        break;
                    case "servantAddress_Data":
                        $columnName = 'address';
                        break;
                    case "servantStatus_Data":
                        $columnName = 'status';
                        break;
                }
                $query = mysqli_query($conn, "SELECT $columnName FROM servants WHERE servant_id = '$stId'");
                if ($query) {
                    $fetch_servant_data = '';
                    while ($row = mysqli_fetch_assoc($query)) {
                        $fetch_servant_data .= "<option value='{$row[$columnName]}'>{$row[$columnName]}</option>";
                    }
                } else {
                    $fetch_servant_data = 'Query unsuccessful: ' . mysqli_error($conn);
                }
            } else {
                $fetch_servant_data = 'ID not provided for batch Data';
            }
            break;
        default:
            $fetch_servant_data = 'Invalid type parameter';
            break;
    }
} else {
    $fetch_servant_data = 'Type parameter not set';
}
echo $fetch_servant_data;




// =================== Start house_id_Data ===================
if (isset($_POST['type'])) {
    if ($_POST['type'] == "house_id_Data") {
        $sql = "SELECT house_id, house_number FROM houses";
        $query = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        $fetchHousesData = '---';
        while ($row = mysqli_fetch_assoc($query)) {
            $fetchHousesData .= "<option value='{$row['house_id']}'>{$row['house_number']}</option>";
        }
    } elseif ($_POST['type'] == "owner_name_Data") {
        if (isset($_POST['id'])) {
            $batchId = $_POST['id'];
            $query = mysqli_query($conn, "SELECT owner_name FROM houses WHERE house_id = $batchId");
            $fetchHousesData = '';
            while ($row = mysqli_fetch_assoc($query)) {
                $fetchHousesData .= "<option value='{$row['owner_name']}'>{$row['owner_name']}</option>";
            }
        } else {
            $fetchHousesData = 'ID not provided for batch Data';
        }
    } elseif ($_POST['type'] == "owner_contact_Data") {
        if (isset($_POST['id'])) {
            $batchId = $_POST['id'];
            $query = mysqli_query($conn, "SELECT owner_contact FROM houses WHERE house_id = $batchId");
            $fetchHousesData = '';
            while ($row = mysqli_fetch_assoc($query)) {
                $fetchHousesData .= "<option value='{$row['owner_contact']}'>{$row['owner_contact']}</option>";
            }
        } else {
            $fetchHousesData = 'ID not provided for batch Data';
        }
    }
} else {
    $fetchHousesData = 'Type parameter not set';
}

echo $fetchHousesData;



// =================== Start eGate_id_Data ===================


// if (isset($_POST['type'])) {
//     if ($_POST['type'] == "eGate_id_Data") {
//         // Fetch house data
//         $sql = "SELECT house_id, house_number FROM houses";
//         $query = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
//         while ($row = mysqli_fetch_assoc($query)) {
//             $houseOptions .= "<option value='{$row['house_id']}'>{$row['house_number']}</option>";
//         }

//         // Fetch shop data
//         $sql = "SELECT shop_id, shop_number FROM shops";
//         $query = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
//         while ($row = mysqli_fetch_assoc($query)) {
//             $shopOptions .= "<option value='{$row['shop_id']}'>{$row['shop_number']}</option>";
//         }

//         // Prepare the final output
//         $eGateData = "<optgroup label='House Number'>{$houseOptions}</optgroup>";
//         $eGateData .= "<optgroup label='Shop Number'>{$shopOptions}</optgroup>";
//     } else {
//         $eGateData = 'Type parameter value is invalid';
//     }
// } else {
//     $eGateData = 'Type parameter not set';
// }

// echo $eGateData;



if (isset($_POST['type'])) {
    if ($_POST['type'] == "eGate_id_Data") {
        // Fetch house data
        $sql = "SELECT house_id, house_number FROM houses";
        $query = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        while ($row = mysqli_fetch_assoc($query)) {
            $houseOptions .= "<option value='{$row['house_id']}'>{$row['house_number']}</option>";
        }

        // Fetch shop data
        $sql = "SELECT shop_id, shop_number FROM shops";
        $query = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        while ($row = mysqli_fetch_assoc($query)) {
            $shopOptions .= "<option value='{$row['shop_id']}'>{$row['shop_number']}</option>";
        }

        // Prepare the final output
        $eGateData = "<option value=''>--- Select House/Shop No ---</option>";
        $eGateData .= "<optgroup label='House Number'>{$houseOptions}</optgroup>";
        $eGateData .= "<optgroup label='Shop Number'>{$shopOptions}</optgroup>";
    } else {
        $eGateData = 'Type parameter value is invalid';
    }
} else {
    $eGateData = 'Type parameter not set';
}

echo $eGateData;

// ======================== add tenants

if (isset($_POST['type'])) {
    if ($_POST['type'] == "propertytype") {
        $sql = "SELECT DISTINCT house_or_shop FROM houses";
        $query = mysqli_query($conn, $sql) or die('Query unsuccessful');
        $tenant = '';
        while ($row = mysqli_fetch_assoc($query)) {
            $tenant .= "<option value='{$row['house_or_shop']}'>{$row['house_or_shop']}</option>";
        }
    } elseif ($_POST['type'] == "house_shop_id") {
        if (isset($_POST['id'])) {
            $house_data = $_POST['id'];
            $query = mysqli_query($conn, "SELECT * FROM `houses` WHERE `house_or_shop` = '$house_data'");
            $tenant .= "<option value=''>---</option>";
            while ($row = mysqli_fetch_assoc($query)) {
                $tenant .= "<option value='{$row['house_id']}'>{$row['house_number']}</option>";
            }
        } else {
            $tenant = 'ID not provided for House & Shop';
        }
    } else {
        $tenant = 'Invalid type parameter';
    }
} else {
    $tenant = 'Type parameter not set';
}

echo $tenant;



// =======================Maintenance page =======================
if (isset($_POST['type'])) {
    if ($_POST['type'] == "eGate_id_Data1") {
        // Fetch house data
        $houseOptions = '';
        $shopOptions = '';

        $sql = "SELECT house_id, house_number FROM houses";
        $query = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        while ($row = mysqli_fetch_assoc($query)) {
            $houseOptions .= "<option value='{$row['house_number']}'>{$row['house_number']}</option>";
        }

        // Fetch shop data
        $sql = "SELECT shop_id, shop_number FROM shops";
        $query = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        while ($row = mysqli_fetch_assoc($query)) {
            $shopOptions .= "<option value='{$row['shop_number']}'>{$row['shop_number']}</option>";
        }

        // Prepare the final output
        $eGateData = "<option value=''>--- Select House/Shop No ---</option>";
        $eGateData .= "<optgroup label='House Number'>{$houseOptions}</optgroup>";
        $eGateData .= "<optgroup label='Shop Number'>{$shopOptions}</optgroup>";

        echo $eGateData;
    } elseif ($_POST['type'] == "month_data" && isset($_POST['id'])) {
        $houseShopId = $_POST['id'];

        // Fetch the added date of the selected house/shop
        $sql = "SELECT * FROM houses WHERE  house_number = $houseShopId 
                UNION
                SELECT * FROM shops WHERE shop_number = $houseShopId ";
        $result = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        $row = mysqli_fetch_assoc($result);
        $added_date = $row['added_on'];

        // Calculate unpaid months
        $current_date = new DateTime();
        $added_date = new DateTime($added_date);
        $interval = $added_date->diff($current_date);
        $months_since_added = ($interval->y * 12) + $interval->m;

        $paid_months = [];
        $sql = "SELECT maintenance_month FROM maintenance_payments WHERE house_id = $houseShopId or shop_id = $houseShopId";
        $result = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        while ($row = mysqli_fetch_assoc($result)) {
            $paid_months[] = (new DateTime($row['maintenance_month']))->format('Y-m');
        }

        $monthOptions = "<option value=''>Select Month</option>";
        for ($i = 0; $i <= $months_since_added; $i++) {
            $month = clone $added_date;
            $month->modify("+$i months");
            $month_str = $month->format('Y-m');
            if (!in_array($month_str, $paid_months)) {
                $monthOptions .= "<option value='{$month_str}'>{$month->format('F Y')}</option>";
            }
        }

        echo $monthOptions;
    } elseif ($_POST['type'] == "owner_name" && isset($_POST['id'])) {
        $houseShopId = $_POST['id'];
        // Fetch the added date of the selected house/shop
        $sql = "SELECT house_id AS id, house_number AS number, owner_name,  owner_contact FROM houses 
         WHERE house_number = $houseShopId UNION
         SELECT shop_id AS id, shop_number AS number, owner_name, owner_contact FROM shops WHERE shop_number = $houseShopId;";
        $result = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        $result = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        while ($row = mysqli_fetch_assoc($result)) {
            $monthOptions .= "<option value='{$row['owner_name']}'>{$row['owner_name']}</option>";
        }
        echo $monthOptions;
    } elseif ($_POST['type'] == "owner_contact" && isset($_POST['id'])) {
        $houseShopId = $_POST['id'];
        // Fetch the added date of the selected house/shop
        $sql = "SELECT house_id AS id, house_number AS number, owner_name,  owner_contact FROM houses 
         WHERE house_number = $houseShopId UNION
         SELECT shop_id AS id, shop_number AS number, owner_name, owner_contact FROM shops WHERE shop_number = $houseShopId;";
        $result = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        $result = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        while ($row = mysqli_fetch_assoc($result)) {
            $monthOptions .= "<option value='{$row['owner_contact']}'>{$row['owner_contact']}</option>";
        }
        echo $monthOptions;
    } elseif ($_POST['type'] == "owner_cnic" && isset($_POST['id'])) {
        $houseShopId = $_POST['id'];
        // Fetch the added date of the selected house/shop
        $sql = "SELECT house_id AS id, house_number AS number, owner_cnic  FROM houses 
         WHERE house_number = $houseShopId UNION
         SELECT shop_id AS id, shop_number AS number, owner_cnic FROM shops WHERE shop_number = $houseShopId;";
        $result = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        $result = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        while ($row = mysqli_fetch_assoc($result)) {
            $monthOptions .= "<option value='{$row['owner_cnic']}'>{$row['owner_cnic']}</option>";
        }
        echo $monthOptions;
    } elseif ($_POST['type'] == "totalMaintenace" && isset($_POST['id'])) {
        $houseShopId = $_POST['id'];
        // Fetch the added date of the selected house/shop
        $sql = "SELECT house_id AS id, house_number AS number,  maintenance_charges FROM houses 
         WHERE house_number = $houseShopId UNION
         SELECT shop_id AS id, shop_number AS number, maintenance_charges FROM shops WHERE shop_number = $houseShopId;";
        $result = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        $result = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        while ($row = mysqli_fetch_assoc($result)) {
            $monthOptions .= "<option value='{$row['maintenance_charges']}'>{$row['maintenance_charges']}</option>";
        }
        echo $monthOptions;
    } else {
        echo 'Invalid request';
    }
} else {
    echo 'Type parameter not set';
}
// ==========================payroll page=====================
if (isset($_POST['type'])) {
    if ($_POST['type'] == "Employee_ID") {
        $sql = "SELECT employee_id FROM employees";
        $query = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        $fetchEmpolyeeData = '---';
        while ($row = mysqli_fetch_assoc($query)) {
            $fetchEmpolyeeData .= "<option value='{$row['employee_id']}'>{$row['employee_id']}</option>";
        }
    } elseif ($_POST['type'] == "Employee_Name") {
        if (isset($_POST['id'])) {
            $batchId = $_POST['id'];
            $query = mysqli_query($conn, "SELECT * FROM employees WHERE employee_id = $batchId");
            $fetchEmpolyeeData = '';
            while ($row = mysqli_fetch_assoc($query)) {
                $fetchEmpolyeeData .= "<option value='{$row['employee_full_name']}'>{$row['employee_full_name']}</option>";
            }
        } else {
            $fetchEmpolyeeData = 'ID not provided for batch Data';
        }
    } elseif ($_POST['type'] == "Employee_Salary") {
        if (isset($_POST['id'])) {
            $batchId = $_POST['id'];
            $query = mysqli_query($conn, "SELECT * FROM employees WHERE employee_id = $batchId");
            $fetchEmpolyeeData = '';
            while ($row = mysqli_fetch_assoc($query)) {
                $fetchEmpolyeeData .= "<option value='{$row['salary']}'>{$row['salary']}</option>";
            }
        } else {
            $fetchEmpolyeeData = 'ID not provided for batch Data';
        }
    }
} else {
    $fetchEmpolyeeData = 'Type parameter not set';
}

echo $fetchEmpolyeeData;
