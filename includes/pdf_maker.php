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
