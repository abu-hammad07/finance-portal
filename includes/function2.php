<?php
include_once("config.php");
require('./fpdf/fpdf.php');
// -----------add penalty----------
function addPenalty()
{
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $penalty_type = mysqli_real_escape_string($conn, $_POST['penalty_type']);
        $penalty_cnic = mysqli_real_escape_string($conn, $_POST['penalty_cnic']);
        $penalty_charges = mysqli_real_escape_string($conn, $_POST['penalty_charges']);

        $added_by = $_SESSION['username'];
        $added_on = date("Y-m-d");

        $insertQuery = "INSERT INTO penalty(penalty_type, penalty_cnic, penalty_charges, created_date,
          created_by) VALUES ('$penalty_type','$penalty_cnic','$penalty_charges',
          '$added_on','$added_by')";

        $query = mysqli_query($conn, $insertQuery);
        if ($query) {
            $_SESSION['success_message_house'] = "$penalty_type Added Successfully";
            header('location: addpenalty');
            exit();
        } else {
            $_SESSION['error_message_house'] = "Something went wrong. Please try again.";
            header('location: addpenalty');
            exit();
        }
    }
}
// -----------update penalty----------
function updatePenalty()
{
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $penalty_id = mysqli_real_escape_string($conn, $_POST['penalty_id']);
        $penalty_type = mysqli_real_escape_string($conn, $_POST['penalty_type']);
        $penalty_cnic = mysqli_real_escape_string($conn, $_POST['penalty_cnic']);
        $penalty_charges = mysqli_real_escape_string($conn, $_POST['penalty_charges']);

        $update_by = $_SESSION['username'];

        $insertQuery = "
        UPDATE penalty SET penalty_type = '{$penalty_type}',
         penalty_cnic = '{$penalty_cnic}',penalty_charges = '{$penalty_charges}',
         updated_date = NOW(), updated_by = '{$update_by}'
        WHERE id = '{$penalty_id}'";

        $query = mysqli_query($conn, $insertQuery);
        if ($query) {
            $_SESSION['success_updated_penalty'] = "$penalty_type updated Successfully";
            header('location: penalty');
            exit();
        } else {
            $_SESSION['success_updated_penalty'] = "Something went wrong. Please try again.";
            header('location: penalty');
            exit();
        }
    }
}
// -----------Delete penalty----------
function penaltyDelete()
{
    global $conn;
    if (isset($_GET['penalty_delete_id'])) {
        $delete_id = mysqli_real_escape_string($conn, $_GET['penalty_delete_id']);
        $deleteQuery = "DELETE FROM penalty where id = ('{$delete_id}')";
        $deleteSQL = mysqli_query($conn, $deleteQuery);
        if ($deleteSQL) {
            $_SESSION['success_updated_penalty'] = "Servant Deleted Successfully";
            header('location: penalty');
            exit();
        } else {
            $_SESSION['success_updated_penalty'] = "Servant Not Deleted";
            header('location: penalty');
            exit();
        }
    }
}

// =============maintenance================
function addMaintenance()
{
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $house_or_shop = mysqli_real_escape_string($conn, $_POST['house_or_shop']);
        $house_shop_id = mysqli_real_escape_string($conn, $_POST['house_shop_id']);
        $maintenace_month = mysqli_real_escape_string($conn, $_POST['maintenace_month']);
        $maintenace_charges = mysqli_real_escape_string($conn, $_POST['maintenace_charges']);

        $added_by = $_SESSION['username'];
        $added_on = date("Y-m-d");

        if ($house_or_shop === 'house') {
            $insertQuery = "INSERT INTO maintenance_payments (house_id, house_or_shop, maintenance_month, maintenance_peyment, added_on, added_by) 
                            VALUES ('$house_shop_id', '$house_or_shop', '$maintenace_month', '$maintenace_charges', '$added_on', '$added_by')";
        } elseif ($house_or_shop === 'shop') {
            $insertQuery = "INSERT INTO maintenance_payments (shop_id, house_or_shop, maintenance_month, maintenance_peyment, added_on, added_by) 
                            VALUES ('$house_shop_id', '$house_or_shop', '$maintenace_month', '$maintenace_charges', '$added_on', '$added_by')";
        } else {
            $_SESSION['error_message_house'] = "Invalid house or shop selection.";
            header('location: addMaintenance');
            exit();
        }

        // Debugging: Check if $insertQuery is set properly
        if (isset($insertQuery)) {
            $query = mysqli_query($conn, $insertQuery);
            if ($query) {
                $_SESSION['success_message_house'] = "$maintenace_month Added Successfully";
                header('location: addMaintenance');
                exit();
            } else {
                $_SESSION['error_message_house'] = "Something went wrong. Please try again.";
                header('location: addMaintenance');
                exit();
            }
        } else {
            $_SESSION['error_message_house'] = "Insert query not set. Please check your input.";
            header('location: addMaintenance');
            exit();
        }
    }
}

function updateMaintenance()
{
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $edit_id = mysqli_real_escape_string($conn, $_POST['maintenace_edit_id']);
        $house_or_shop = mysqli_real_escape_string($conn, $_POST['house_or_shop']);
        $house_shop_id = mysqli_real_escape_string($conn, $_POST['house_shop_id']);
        $maintenance_month = mysqli_real_escape_string($conn, $_POST['maintenace_month']);
        $maintenance_charges = mysqli_real_escape_string($conn, $_POST['maintenace_charges']);

        $updated_by = $_SESSION['username'];
        $updated_on = date("Y-m-d");

        if ($house_or_shop === 'house') {
            $updateQuery = "UPDATE maintenance_payments 
                            SET house_id = '$house_shop_id', 
                                house_or_shop = '$house_or_shop', 
                                maintenance_month = '$maintenance_month', 
                                maintenance_peyment = '$maintenance_charges', 
                                updated_on = '$updated_on', 
                                updated_by = '$updated_by'
                            WHERE maintenance_id = '$edit_id'";
        } elseif ($house_or_shop === 'shop') {
            $updateQuery = "UPDATE maintenance_payments 
                            SET shop_id = '$house_shop_id', 
                                house_or_shop = '$house_or_shop', 
                                maintenance_month = '$maintenance_month', 
                                maintenance_peyment = '$maintenance_charges', 
                                updated_on = '$updated_on', 
                                updated_by = '$updated_by'
                            WHERE maintenance_id = '$edit_id'";
        } else {
            $_SESSION['error_message_Maintenance'] = "Invalid house or shop selection.";
            header('location: maintenanceCharges');
            exit();
        }

        // Debugging: Check if $updateQuery is set properly
        if (isset($updateQuery)) {
            $query = mysqli_query($conn, $updateQuery);
            if ($query) {
                $_SESSION['success_updated_Maintenance'] = "Maintenance record updated successfully.";
                header('location: maintenanceCharges');
                exit();
            } else {
                $_SESSION['error_message_Maintenance'] = "Something went wrong. Please try again.";
                header('location: maintenanceCharges');
                exit();
            }
        } else {
            $_SESSION['error_message_Maintenance'] = "Update query not set. Please check your input.";
            header('location: maintenanceCharges');
            exit();
        }
    }
}


function MaintenanceDelete()
{
    global $conn;
    if (isset($_GET['Maintenance_delete_id'])) {
        $delete_id = mysqli_real_escape_string($conn, $_GET['Maintenance_delete_id']);
        $deleteQuery = "DELETE FROM maintenance_payments where maintenance_id = ('{$delete_id}')";
        $deleteSQL = mysqli_query($conn, $deleteQuery);
        if ($deleteSQL) {
            $_SESSION['success_updated_Maintenance'] = "Servant Deleted Successfully";
            header('location: maintenanceCharges');
            exit();
        } else {
            $_SESSION['success_updated_Maintenance'] = "Servant Not Deleted";
            header('location: maintenanceCharges');
            exit();
        }
    }
}
// ================add payroll=============
// Adjust the path to where you placed the fpdf.php file
function addPayroll()
{
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
        $month_year = mysqli_real_escape_string($conn, $_POST['month_year']);
        $employee_salary = mysqli_real_escape_string($conn, $_POST['employee_salary']);
        $total_working_days = mysqli_real_escape_string($conn, $_POST['total_working_days']);
        $days_absent = mysqli_real_escape_string($conn, $_POST['days_absent']);
        $days_leave = mysqli_real_escape_string($conn, $_POST['days_leave']);
        $days_present = mysqli_real_escape_string($conn, $_POST['days_present']);
        $total_salary = mysqli_real_escape_string($conn, $_POST['total_salary']);
        $added_by = $_SESSION['username'];
        $added_on = date("Y-m-d");

        // Check if payroll entry for this employee and month already exists
        $checkQuery = "SELECT * FROM Payroll WHERE employee_id = '$employee_id' AND month_year = '$month_year'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $_SESSION['error_message'] = "Payroll entry for this employee and month already exists.";
            header('location: addPayroll.php'); // Adjust the redirect location as needed
            exit();
        } else {
            // Insert the payroll entry
            $insertQuery = "INSERT INTO Payroll (employee_id,employee_salary, month_year, total_working_days, days_absent, days_leave, days_present, total_salary, added_on, added_by)
                            VALUES ('$employee_id', '$employee_salary','$month_year', '$total_working_days', '$days_absent', '$days_leave', '$days_present', '$total_salary', '$added_on', '$added_by')";

            if (mysqli_query($conn, $insertQuery)) {
                // Get the inserted payroll ID
                $payroll_id = mysqli_insert_id($conn);

                // Generate the PDF
                $pdf = new FPDF();
                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Cell(40, 10, "Payroll Details for Employee ID: $employee_id");
                $pdf->Ln();
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(40, 10, "Month-Year: $month_year");
                $pdf->Ln();
                $pdf->Cell(40, 10, "Total Working Days: $total_working_days");
                $pdf->Ln();
                $pdf->Cell(40, 10, "Days Absent: $days_absent");
                $pdf->Ln();
                $pdf->Cell(40, 10, "Days Leave: $days_leave");
                $pdf->Ln();
                $pdf->Cell(40, 10, "Days Present: $days_present");
                $pdf->Ln();
                $pdf->Cell(40, 10, "Total Salary: $total_salary");
                $pdf->Ln();
                $pdfContent = $pdf->Output('S');

                // Save the PDF to the Payroll_pdfs table
                $insertPdfQuery = "INSERT INTO payroll_pdfs (payroll_id, payroll_pdf) VALUES (?, ?)";
                $stmt = mysqli_prepare($conn, $insertPdfQuery);
                mysqli_stmt_bind_param($stmt, 'is', $payroll_id, $pdfContent);
                mysqli_stmt_execute($stmt);

                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    $_SESSION['success_message'] = "$month_year Payroll Added Successfully";
                    // Set the URLs for download and view
                    $pdfDownloadUrl = "download_pdf.php?payroll_id=$payroll_id"; // Ensure this script handles the PDF download
                    $pdfViewUrl = "view_pdf.php?payroll_id=$payroll_id"; // Ensure this script handles PDF viewing

                    // Set the JavaScript message
                    $_SESSION['alert_script'] = "
                        <script>
                            window.onload = function() {
                                if (confirm('Payroll added successfully! Click OK to download the PDF, or Cancel to view it.')) {
                                    window.location.href = '$pdfDownloadUrl';
                                } else {
                                    window.location.href = '$pdfViewUrl';
                                }
                            };
                        </script>";
                } else {
                    $_SESSION['error_message'] = "Failed to save PDF.";
                }
            } else {
                $_SESSION['error_message'] = "Something went wrong. Please try again.";
            }
            header('location: addPayroll.php'); // Redirect after processing
            exit();
        }
    }
}
// ===============payroll Update============

function updatePayroll()
{
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $payroll_id = mysqli_real_escape_string($conn, $_POST['payroll_id']);
        $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
        $employee_salary = mysqli_real_escape_string($conn, $_POST['employee_salary']);
        $month_year = mysqli_real_escape_string($conn, $_POST['month_year']);
        $total_working_days = mysqli_real_escape_string($conn, $_POST['total_working_days']);
        $days_absent = mysqli_real_escape_string($conn, $_POST['days_absent']);
        $days_leave = mysqli_real_escape_string($conn, $_POST['days_leave']);
        $days_present = mysqli_real_escape_string($conn, $_POST['days_present']);
        $total_salary = mysqli_real_escape_string($conn, $_POST['total_salary']);
        $updated_by = $_SESSION['username'];
        $updated_on = date("Y-m-d");

        // Check if a payroll entry with this employee and month exists, excluding the current one
        $checkQuery = "SELECT * FROM Payroll WHERE employee_id = '$employee_id' AND month_year = '$month_year' AND payroll_id != '$payroll_id'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $_SESSION['error_message'] = "Payroll entry for this employee and month already exists.";
            header("location: Payroll_edit.php?payroll_id=$payroll_id"); // Adjust the redirect location as needed
            exit();
        } else {
            // Update the payroll entry
            $updateQuery = "UPDATE Payroll SET 
                                employee_id = '$employee_id', 
                                employee_salary = '$employee_salary', 
                                month_year = '$month_year', 
                                total_working_days = '$total_working_days', 
                                days_absent = '$days_absent', 
                                days_leave = '$days_leave', 
                                days_present = '$days_present', 
                                total_salary = '$total_salary', 
                                updated_on = '$updated_on', 
                                updated_by = '$updated_by' 
                            WHERE payroll_id = '$payroll_id'";

            if (mysqli_query($conn, $updateQuery)) {
                // Get the inserted payroll ID
                $payroll_id = mysqli_insert_id($conn);

                // Generate the PDF
                $pdf = new FPDF();
                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Cell(40, 10, "Payroll Details for Employee ID: $employee_id");
                $pdf->Ln();
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(40, 10, "Month-Year: $month_year");
                $pdf->Ln();
                $pdf->Cell(40, 10, "Total Working Days: $total_working_days");
                $pdf->Ln();
                $pdf->Cell(40, 10, "Days Absent: $days_absent");
                $pdf->Ln();
                $pdf->Cell(40, 10, "Days Leave: $days_leave");
                $pdf->Ln();
                $pdf->Cell(40, 10, "Days Present: $days_present");
                $pdf->Ln();
                $pdf->Cell(40, 10, "Total Salary: $total_salary");
                $pdf->Ln();
                $pdfContent = $pdf->Output('S');

                // Save the PDF to the Payroll_pdfs table
                $insertPdfQuery = "INSERT INTO payroll_pdfs (payroll_id, payroll_pdf) VALUES (?, ?)";
                $stmt = mysqli_prepare($conn, $insertPdfQuery);
                mysqli_stmt_bind_param($stmt, 'is', $payroll_id, $pdfContent);
                mysqli_stmt_execute($stmt);

                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    $_SESSION['success_message'] = "$month_year Payroll Update Successfully";
                    // Set the URLs for download and view
                    $pdfDownloadUrl = "download_pdf.php?payroll_id=$payroll_id"; // Ensure this script handles the PDF download
                    $pdfViewUrl = "view_pdf.php?payroll_id=$payroll_id"; // Ensure this script handles PDF viewing

                    // Set the JavaScript message
                    $_SESSION['alert_script'] = "
            <script>
                window.onload = function() {
                    if (confirm('Payroll added successfully! Click OK to download the PDF, or Cancel to view it.')) {
                        window.location.href = '$pdfDownloadUrl';
                    } else {
                        window.location.href = '$pdfViewUrl';
                    }
                };
            </script>";
                } else {
                    $_SESSION['error_message'] = "Failed to save PDF.";
                }
            } else {
                $_SESSION['error_message'] = "Something went wrong. Please try again.";
            }
            header('location: addPayroll.php'); // Redirect after processing
            exit();
        }
    }
}

// ===============payroll Delete===========
function payrollDelete()
{
    global $conn;
    if (isset($_GET['payroll_id'])) {
        $delete_id = mysqli_real_escape_string($conn, $_GET['payroll_id']);
        $deleteQuery = "DELETE FROM payroll where payroll_id = ('{$delete_id}')";
        $deleteSQL = mysqli_query($conn, $deleteQuery);
        if ($deleteSQL) {
            $_SESSION['success_updated_payroll'] = "Payroll Deleted Successfully";
            header('location: payroll');
            exit();
        } else {
            $_SESSION['error_updated_payroll'] = "payroll Not Deleted";
            header('location: payroll');
            exit();
        }
    }
}
