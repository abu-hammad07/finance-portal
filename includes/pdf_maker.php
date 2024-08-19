<?php
require 'config.php';
include_once('../vendor/tecnickcom/tcpdf/tcpdf.php');

$MST_ID = $_GET['MAT_ID'];

$inv_mst_query = "SELECT * FROM maintenance_payments WHERE maintenance_id='" . $MST_ID . "' ";
$inv_mst_results = mysqli_query($conn, $inv_mst_query);
$count = mysqli_num_rows($inv_mst_results);

if ($count > 0) {
    $inv_mst_data_row = mysqli_fetch_array($inv_mst_results, MYSQLI_ASSOC);

    //----- Code for generate pdf
    $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont('helvetica');
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->AddPage(); //default A4 landscape

    $content = '';

    $content .= '
    <style type="text/css">
        body{
	font-size:12px;
	line-height:24px;
	font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
	color:#000;
	}
  
    </style>    
    ';

    $inv_det_query = "SELECT * FROM maintenance_payments WHERE maintenance_id='" . $MST_ID . "' ";
    $inv_det_results = mysqli_query($conn, $inv_det_query);
    while ($inv_det_data_row = mysqli_fetch_array($inv_det_results, MYSQLI_ASSOC)) {
        $content .= '

        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr >
            <td style="border-bottom: 1px solid #000;"  align="left"> <img  src="KDA.png" alt="Logo" /></td>
            <td style="border-bottom: 1px solid #000;"  align="center"><h2 >KDA Officer Co-Operative Housing Society<br/>Residents Welfare Association</h2>
 </td>
 <td  align="right" style="border-bottom: 1px solid #000;">
  <p>Email: <span>info@gmail.com</span></p>
                <p>Website: <span>www.example.com</span></p>
                <p>Phone: <span>034567238</span></p>
 </td>

        </tr>
            
        <tr><br>
        <td  colspan="3"><p>Received with thanks the sum of Rupees <strong> Only (' . $inv_det_data_row['maintenance_charges'] . '/-)</strong> on account of <strong> Monthly Maintenance</strong> in the month of <strong>' . $inv_det_data_row['maintenance_month'] . '</strong> from</p>
</td>
        </tr>
<br><br>
        <tr >
        <td  colspan="2">
        
  <span style="font-weight:bold; ">House or Shop:</span>
                <span class="value">' . $inv_det_data_row['house_or_shop'] . '</span>
                
   
<br> <br>

  <span style="font-weight:bold">House Number:</span>
             <span class="value">' . $inv_det_data_row['house_shop_id'] . '</span>
      

<br> <br>
       
  <span style="font-weight:bold">Maintenance Date:</span>
            <span class="value">' . $inv_det_data_row['maintenance_month'] . '</span>
       
<br> <br>


       
  <span style="font-weight:bold">Payment Type:</span>
            <span class="value">' . $inv_det_data_row['payment_type'] . '</span>
       
<br> <br>

      
  <span style="font-weight:bold">Maintenance Payment:</span>
<span class="value">' . $inv_det_data_row['maintenance_charges'] . '</span>       
        <br> <br>
    
  <span style="font-weight:bold">Added By:</span>
 <span class="value">' . $inv_det_data_row['updated_by'] . '</span>        
       <br> <br>
 </td>     

 <td align="right">
 <ol>
                    <li>All Funds are to be used for Society\'s Welfare.</li>
                    <li>Residents paying partial monthly Payments would be referred to as defaulters.</li>
                    <li>Donations are most welcome, ask for receipt when donating.</li>
                    <li>Association could not be held responsible for any mishap.</li>
                    <li>Complaints and Suggestions will only be entertained in written form.</li>
                </ol>
 </td>
        </tr>

        <tfoot>
        <tr>
        <td colspan="3" align="center">
        <p>This is a computer-generated receipt, no signature required.</p>
        </td>
        </tr>
        </tfoot>
          
      </table>                    
        ';
    }

    $pdf->writeHTML($content);

    $file_location = "/home/fbi1glfa0j7p/public_html/examples/generate_pdf/uploads/"; //add your full path of your server
    //$file_location = "/opt/lampp/htdocs/examples/generate_pdf/uploads/"; //for local xampp server

    $datetime = date('dmY_hms');
    $file_name = "INV_" . $datetime . ".pdf";
    ob_end_clean();

    if ($_GET['ACTION'] == 'VIEW') {
        $pdf->Output($file_name, 'I'); // I means Inline view
    } else if ($_GET['ACTION'] == 'DOWNLOAD') {
        $pdf->Output($file_name, 'D'); // D means download
    } else if ($_GET['ACTION'] == 'UPLOAD') {
        $pdf->Output($file_location . $file_name, 'F'); // F means upload PDF file on some folder
        echo "Upload successfully!!";
    }

    //----- End Code for generate pdf
} else {
    echo 'Record not found for PDF.';
}


// ----------------------egat pdf---------------------


$egat_ID = $_GET['eGate_id'];

$inv_mst_query = "SELECT * FROM egate WHERE eGate_id='" . $egat_ID . "' ";
$inv_mst_results = mysqli_query($conn, $inv_mst_query);
$count = mysqli_num_rows($inv_mst_results);

if ($count > 0) {
    $inv_mst_data_row = mysqli_fetch_array($inv_mst_results, MYSQLI_ASSOC);

    //----- Code for generate pdf
    $pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont('helvetica');
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->AddPage(); //default A4 landscape

    $content = '';

    $inv_det_query = "SELECT * FROM egate WHERE eGate_id='" . $egat_ID . "' ";
    $inv_det_results = mysqli_query($conn, $inv_det_query);
    while ($inv_det_data_row = mysqli_fetch_array($inv_det_results, MYSQLI_ASSOC)) {
        $content .= '
       <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        width: 100%;
    }   
    .id-card {
        border: 2px solid #00796b;
        border-radius: 10px;
        overflow: hidden;
        background-color: #ffffff;
        width: 343px; /* Wallet-sized width in pixels */
        height: 150px; /* Wallet-sized height in pixels */
        margin: 0 auto;
        table-layout: fixed;
        padding: 10px;
        font-size: 8px; /* Adjusted font size to fit the smaller card */
        text-align: center;
    }
    .id-card td {
        padding: 5px;
    }
    .left {
        border-right: 2px solid #00796b;
        width: 50%;
        text-align: center;
    }
    .logo {
        width: 100px; /* Adjusted logo size */
        height: auto;
        margin-bottom: 5px;
    }
    .details p {
        margin: 3px 0;
        text-align: left;
        font-size: 7px; /* Smaller font size to fit text */
    }
    .signature {
        margin-top: 5px;
        font-size: 7px;
    }
    .qrcode {
        width: 60px; /* Adjusted QR code size */
        height: auto;
        margin-top: 5px;
    }
</style>

        <table class="id-card">
            <tr>
                <td class="left">
                    <img src="KDA.png" alt="KDA Housing Logo" class="logo">
                    <h3 style="font-size: 14px;">E-Gate Pass</h3>
                    <div class="details">
                        <p><strong>House/Shop Number:</strong> ' . $inv_det_data_row['house_id'] . '</p>
                        <p><strong>Vehicle Number:</strong> ' . $inv_det_data_row['vehicle_number'] . '</p>
                        <p><strong>Person Name:</strong> ' . $inv_det_data_row['vehicle_name'] . '</p>
                        <p><strong>CNIC Number:</strong> ' . $inv_det_data_row['eGate_cnic'] . '</p>
                        <p><strong>Charges Type:</strong> ' . $inv_det_data_row['eGate_charges_type'] . '</p>
                        <p><strong>Charges:</strong> ' . $inv_det_data_row['eGate_charges'] . '</p>
                        <p><strong>Bank/Cash:</strong> ' . $inv_det_data_row['payment_type'] . '</p>
                        <p><strong>Issue Date:</strong> ' . $inv_det_data_row['added_on'] . '</p>
                    </div>
                </td>
                <td>
                    <img src="KDA.png" alt="KDA Housing Logo" class="logo">
                    <p style="font-size: 10px;">The bearer whose photograph appears overleaf is a staff of</p>
                    <h3 style="font-size: 14px;">E-Gate Pass</h3>
                    <div class="signature">
                        <p>Authorised Signature</p>
                       
                    </div>
                  
                </td>
            </tr>
        </table>';
    }

    $pdf->writeHTML($content);

    $file_location = "/home/fbi1glfa0j7p/public_html/examples/generate_pdf/uploads/"; //add your full path of your server
    //$file_location = "/opt/lampp/htdocs/examples/generate_pdf/uploads/"; //for local xampp server

    $datetime = date('dmY_hms');
    $file_name = "INV_" . $datetime . ".pdf";
    ob_end_clean();

    if ($_GET['ACTION'] == 'VIEW') {
        $pdf->Output($file_name, 'I'); // I means Inline view
    } else if ($_GET['ACTION'] == 'DOWNLOAD') {
        $pdf->Output($file_name, 'D'); // D means download
    } else if ($_GET['ACTION'] == 'UPLOAD') {
        $pdf->Output($file_location . $file_name, 'F'); // F means upload PDF file on some folder
        echo "Upload successfully!!";
    }

    //----- End Code for generate pdf
} else {
    echo 'Record not found for PDF.';
}


// ----------------------empolyee pdf---------------------

$empolyee_id = $_GET['employee_id'];

$inv_mst_query = "SELECT * FROM employees WHERE employee_id='" . $empolyee_id . "' ";
$inv_mst_results = mysqli_query($conn, $inv_mst_query);
$count = mysqli_num_rows($inv_mst_results);

if ($count > 0) {
    $inv_mst_data_row = mysqli_fetch_array($inv_mst_results, MYSQLI_ASSOC);

    //----- Code for generate pdf
    $pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont('helvetica');
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->AddPage(); //default A4 landscape

    $content = '';

    $inv_det_query = "SELECT * FROM employees WHERE employee_id='" . $empolyee_id . "' ";
    $inv_det_results = mysqli_query($conn, $inv_det_query);
    while ($inv_det_data_row = mysqli_fetch_array($inv_det_results, MYSQLI_ASSOC)) {
        $content .= '
        <style>

        body {
        font-family: Arial, sans-serif;
        font-size: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        width: 100%;
    }   
    .id-card {
        border: 2px solid #00796b;
        border-radius: 10px;
        overflow: hidden;
        background-color: #ffffff;
        width: 343px; /* Wallet-sized width in pixels */
        height: 150px; /* Wallet-sized height in pixels */
        margin: 0 auto;
        table-layout: fixed;
        padding: 10px;
        font-size: 8px; /* Adjusted font size to fit the smaller card */
        text-align: center;
    }
    .id-card td {
        padding: 5px;
    }
    .left {
        border-right: 2px solid #00796b;
        width: 50%;
        text-align: center;
    }
    .logo {
        width: 100px; /* Adjusted logo size */
        height: auto;
        margin-bottom: 5px;
    }
    .details p {
        margin: 3px 0;
        text-align: left;
        font-size: 7px; /* Smaller font size to fit text */
    }
    .signature {
        margin-top: 5px;
        font-size: 7px;
    }
    .qrcode {
        width: 60px; /* Adjusted QR code size */
        height: auto;
        margin-top: 5px;
    }
        </style>
        <table class="id-card">
            <tr>
                <td class="left">
                    <img src="KDA.png" alt="KDA Housing Logo" class="logo">
                    <h3 style="font-size: 14px;">Employee Card</h3>
                    <div class="details">
                        <p><strong>Employee ID:</strong> ' . $inv_det_data_row['employeeID'] . '</p>
                        <p><strong>Full Name:</strong> ' . $inv_det_data_row['employee_full_name'] . '</p>
                        <p><strong>CNIC:</strong> ' . $inv_det_data_row['employee_cnic'] . '</p>
                        <p><strong>Phone Number:</strong> ' . $inv_det_data_row['employee_contact'] . '</p>
                        <p><strong>Email:</strong> ' . $inv_det_data_row['employee_email'] . '</p>
                        <p><strong>Department</strong> ' . $inv_det_data_row['department'] . '</p>
                        <p><strong>Designation</strong> ' . $inv_det_data_row['designation'] . '</p>
                        <p><strong>Appointment Date:</strong> ' . $inv_det_data_row['appointment_date'] . '</p>
                    </div>
                </td>
                <td>
                    <img src="KDA.png" alt="KDA Housing Logo" class="logo">
                    <p style="font-size: 10px;">The bearer whose photograph appears overleaf is a staff of</p>
                    <h3 style="font-size: 14px;">Employee</h3>
                    <div class="signature">
                        <p>Authorised Signature</p>
                       
                    </div>
                  
                </td>
            </tr>
        </table>';
    }

    $pdf->writeHTML($content);

    $file_location = "/home/fbi1glfa0j7p/public_html/examples/generate_pdf/uploads/"; //add your full path of your server
    //$file_location = "/opt/lampp/htdocs/examples/generate_pdf/uploads/"; //for local xampp server

    $datetime = date('dmY_hms');
    $file_name = "INV_" . $datetime . ".pdf";
    ob_end_clean();

    if ($_GET['ACTION'] == 'VIEW') {
        $pdf->Output($file_name, 'I'); // I means Inline view
    } else if ($_GET['ACTION'] == 'DOWNLOAD') {
        $pdf->Output($file_name, 'D'); // D means download
    } else if ($_GET['ACTION'] == 'UPLOAD') {
        $pdf->Output($file_location . $file_name, 'F'); // F means upload PDF file on some folder
        echo "Upload successfully!!";
    }

    //----- End Code for generate pdf
} else {
    echo 'Record not found for PDF.';
}



// ----------------------servant pdf---------------------

$servants_id = $_GET['servants_id'];

$inv_mst_query = "SELECT * FROM servants WHERE servant_id='" . $servants_id . "' ";
$inv_mst_results = mysqli_query($conn, $inv_mst_query);
$count = mysqli_num_rows($inv_mst_results);

if ($count > 0) {
    $inv_mst_data_row = mysqli_fetch_array($inv_mst_results, MYSQLI_ASSOC);

    //----- Code for generate pdf
    $pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont('helvetica');
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->AddPage(); //default A4 landscape

    $content = '';

    $inv_det_query = "SELECT * FROM servants WHERE servant_id='" . $servants_id . "' ";
    $inv_det_results = mysqli_query($conn, $inv_det_query);
    while ($inv_det_data_row = mysqli_fetch_array($inv_det_results, MYSQLI_ASSOC)) {
        $content .= '
        <style>

       body {
        font-family: Arial, sans-serif;
        font-size: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        width: 100%;
    }   
    .id-card {
        border: 2px solid #00796b;
        border-radius: 10px;
        overflow: hidden;
        background-color: #ffffff;
        width: 343px; /* Wallet-sized width in pixels */
        height: 150px; /* Wallet-sized height in pixels */
        margin: 0 auto;
        table-layout: fixed;
        padding: 10px;
        font-size: 8px; /* Adjusted font size to fit the smaller card */
        text-align: center;
    }
    .id-card td {
        padding: 5px;
    }
    .left {
        border-right: 2px solid #00796b;
        width: 50%;
        text-align: center;
    }
    .logo {
        width: 100px; /* Adjusted logo size */
        height: auto;
        margin-bottom: 5px;
    }
    .details p {
        margin: 3px 0;
        text-align: left;
        font-size: 7px; /* Smaller font size to fit text */
    }
    .signature {
        margin-top: 5px;
        font-size: 7px;
    }
    .qrcode {
        width: 60px; /* Adjusted QR code size */
        height: auto;
        margin-top: 5px;
    }
        </style>
        <table class="id-card">
            <tr>
                <td class="left">
                    <img src="KDA.png" alt="KDA Housing Logo" class="logo">
                    <h3 style="font-size: 14px;">Servant Card</h3>
                    <div class="details">
                        <p><strong>House/Shop Number:</strong> ' . $inv_det_data_row['house_id'] . '</p>
                        <p><strong>Phone Number:</strong> ' . $inv_det_data_row['employee_cnic'] . '</p>
                        <p><strong>Designation:</strong> ' . $inv_det_data_row['servantDesignation'] . '</p>
                        <p><strong>Fees:</strong> ' . $inv_det_data_row['servantFees'] . '</p>
                        <p><strong>Payment Type</strong> ' . $inv_det_data_row['payment_type'] . '</p>
                        <p><strong>Issue Date</strong> ' . $inv_det_data_row['added_on'] . '</p>
                      
                    </div>
                </td>
                <td>
                    <img src="KDA.png" alt="KDA Housing Logo" class="logo">
                    <p style="font-size: 10px;">The bearer whose photograph appears overleaf is a staff of</p>
                    <h3 style="font-size: 14px;">Servant</h3>
                    <div class="signature">
                        <p>Authorised Signature</p>
                       
                    </div>
                  
                </td>
            </tr>
        </table>';
    }

    $pdf->writeHTML($content);

    $file_location = "/home/fbi1glfa0j7p/public_html/examples/generate_pdf/uploads/"; //add your full path of your server
    //$file_location = "/opt/lampp/htdocs/examples/generate_pdf/uploads/"; //for local xampp server

    $datetime = date('dmY_hms');
    $file_name = "INV_" . $datetime . ".pdf";
    ob_end_clean();

    if ($_GET['ACTION'] == 'VIEW') {
        $pdf->Output($file_name, 'I'); // I means Inline view
    } else if ($_GET['ACTION'] == 'DOWNLOAD') {
        $pdf->Output($file_name, 'D'); // D means download
    } else if ($_GET['ACTION'] == 'UPLOAD') {
        $pdf->Output($file_location . $file_name, 'F'); // F means upload PDF file on some folder
        echo "Upload successfully!!";
    }

    //----- End Code for generate pdf
} else {
    echo 'Record not found for PDF.';
}