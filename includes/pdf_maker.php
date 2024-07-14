<?php
require 'config.php'; 
include_once('../vendor/tecnickcom/tcpdf/tcpdf.php');

$MST_ID = $_GET['MAT_ID'];

$inv_mst_query = "SELECT * FROM maintenance_payments WHERE maintenance_id='".$MST_ID."' ";             
$inv_mst_results = mysqli_query($conn, $inv_mst_query);   
$count = mysqli_num_rows($inv_mst_results);  

if ($count > 0) {
    $inv_mst_data_row = mysqli_fetch_array($inv_mst_results, MYSQLI_ASSOC);

    //----- Code for generate pdf
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 12);  
    $pdf->AddPage(); //default A4
    //$pdf->AddPage('P','A5'); //when you require custom page size 

    $content = ''; 

    $content .= '
    <style type="text/css">
        .main_header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-direction: row;
            border-bottom: 1px solid #ccc;
        }
        .main_header .title h2 {
            font-size: 20px;
            font-weight: bold;
        }
        .main_header .contact p {
            margin: 0 0;
        }
        .main_form {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .info {
            margin-bottom: 10px;
        }
        .info .label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .info .value {
            display: inline-block;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        ol li {
            margin-bottom: 15px;
        }
    </style>    
    ';

    $inv_det_query = "SELECT * FROM maintenance_payments WHERE maintenance_id='".$MST_ID."' ";
    $inv_det_results = mysqli_query($conn, $inv_det_query);    
    while ($inv_det_data_row = mysqli_fetch_array($inv_det_results, MYSQLI_ASSOC)) {  
        $content .= '
        <div class="main_header">
            <img src="KDA.png" alt="Logo"/>
            <h2>KDA Officer Co-Operative Housing Society<br/>Residents Welfare Association</h2>
            <div class="contact">
                <p>Email: <span>info@gmail.com</span></p>
                <p>Website: <span>www.example.com</span></p>
                <p>Phone: <span>034567238</span></p>
            </div>
        </div>
        
        <div class="main_form">
            <div class="data">
                <div class="info">
                    <p>Received with thanks the sum of Rupees <strong> Only ('.$inv_det_data_row['maintenance_charges'].'/-)</strong> on account of <strong> Monthly Maintenance</strong> in the month of <strong>'.$inv_det_data_row['maintenance_month'].'</strong> from</p>
                </div>
                <div class="info">
                    <span class="label">House or Shop:</span>
                    <span class="value">'.$inv_det_data_row['house_or_shop'].'</span>
                </div>
                <div class="info">
                    <span class="label">House Number:</span>
                    <span class="value">'.$inv_det_data_row['house_shop_id'].'</span>
                </div>
                <div class="info">
                    <span class="label">Maintenance Date:</span>
                    <span class="value">'.$inv_det_data_row['maintenance_month'].'</span>
                </div>
                <div class="info">
                    <span class="label">Maintenance Payment:</span>
                    <span class="value">'.$inv_det_data_row['maintenance_charges'].'</span>
                </div>
                <div class="info">
                    <span class="label">Added By:</span>
                    <span class="value">'.$inv_det_data_row['updated_by'].'</span>
                </div>
            </div>
            <div class="description">
                <ol>
                    <li>All Funds are to be used for Society\'s Welfare.</li>
                    <li>Residents paying partial monthly Payments would be referred to as defaulters.</li>
                    <li>Donations are most welcome, ask for receipt when donating.</li>
                    <li>Association could not be held responsible for any mishap.</li>
                    <li>Complaints and Suggestions will only be entertained in written form.</li>
                </ol>
            </div>
        </div>

        <div class="footer">
            <p>This is a computer-generated receipt, no signature required.</p>
        </div>
        ';
    }

    $pdf->writeHTML($content);

    $file_location = "/home/fbi1glfa0j7p/public_html/examples/generate_pdf/uploads/"; //add your full path of your server
    //$file_location = "/opt/lampp/htdocs/examples/generate_pdf/uploads/"; //for local xampp server

    $datetime = date('dmY_hms');
    $file_name = "INV_".$datetime.".pdf";
    ob_end_clean();

    if ($_GET['ACTION'] == 'VIEW') {
        $pdf->Output($file_name, 'I'); // I means Inline view
    } else if ($_GET['ACTION'] == 'DOWNLOAD') {
        $pdf->Output($file_name, 'D'); // D means download
    } else if ($_GET['ACTION'] == 'UPLOAD') {
        $pdf->Output($file_location.$file_name, 'F'); // F means upload PDF file on some folder
        echo "Upload successfully!!";
    }

    //----- End Code for generate pdf
} else {
    echo 'Record not found for PDF.';
}
?>
