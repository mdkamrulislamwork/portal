<?php 
/* Template Name: Cloud Vendor Report */
require_once get_template_directory() . '/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$postId = !empty($_GET['pid']) ? base64_decode($_GET['pid']) : false;
$areaId = !empty($_GET['area']) ? base64_decode($_GET['area']) : false;

$data = cloud_vendor_pdf_get_data($postId, $areaId);
// echo '<br><pre>'.print_r($data, true).'</pre>'; exit();

$filename   = "Cloud Vendor Report";
$dompdf     = new Dompdf();
// PDF DATA
$str = ''; 
if ($data) {
    
    $str .= '<style type="text/css">';
        $str .= '@import url("https://fonts.googleapis.com/css?family=Roboto:400,500,700");';
        $str .= ' *{font-family: "Roboto", sans-serif !important;line-height:1.1;font-size: 11px; font-weight:bold;}';
        $str .= '*{margin: 0;padding: 0;line-height:1.1;}';
        $str .= 'body { margin: 0;padding: 0; font-size:14px;}';
        $str .= 'strong { font-size:15px; }';
        $str .= 'table { border-collapse: collapse;border-spacing: 0; width: 100%; }';
        $str .= 'table tr td { padding: 10px;}';
        $str .= 'table.bordered tr td { border: 2px solid #fff;}';
        $str .= 'ul { padding-left:20px; margin-bottom:5px; }';
        $str .= 'ol { padding-left:25px; margin-bottom:5px; }';
        $str .= 'h1, h2, h3, h4 { margin: 0;line-height: 1; font-weight:700;}';
        // COLORS - FUNCTION AVERAGE
        $str .= '.bg-red { background-color: #ed2227; }';
        $str .= '.bg-purple { background: #854599; }';
        $str .= '.bg-orange { background-color: #f77e28; }';
        $str .= '.bg-deepblue { background-color: #1176bc; }';
        $str .= '.bg-green { background-color: #64bc46; }';
        $str .= '.bg-yellow { background-color: #ffdc5d; }';
        $str .= '.bg-red { background-color: #ed2227; }';

        // COLORS - FUNCTION BACKGROUNDS
        // $str .= '.bg-dark-blue { background-color: #169ad7; }';
        $str .= '.bg-dark-blue { background-color: #006997; }';
        $str .= '.bg-dark-blue { background-color: #006997; }';
        $str .= '.bg-dark-olive { background-color:#7b935a; }';
        $str .= '.bg-dark-red { background-color:#c42b20; }';
        $str .= '.bg-dark-brandyPunch { background-color:#cb8b2e; }';
        $str .= '.bg-dark-purple { background-color:#633d5f; }';
        // SUMMARY
        $str .= '.summary p { margin-bottom:5px; }';
       
    $str .= '</style>';
    $str .= '<div class="container" style="margin: 0 auto;">';
        $str .= '<table style="width: 100%;">';
            $str .= '<tr>';
                $str .= '<td rowspan="2" style="border-left: 0;text-align:center;width:100px;"><img src="'.IMAGE_DIR_URL.'cloud-vendor/report/'.$areaId.'.png" style="height: 100px;weight:auto; "></td>';
                $str .= '<td rowspan="2" style="vertical-align: top;width:300px;padding-bottom:0;">';
                    $str .= '<p style="font-size:18px;">'.$data['company'].'</p>';
                    $str .= '<p style="margin-top:5px;font-size:14px;">Cloud Vendor Maturity</p>';
                    $str .= '<p style="margin-top:5px;font-size:14px;">Executive Summary</p>';

                    $str .= '<table>';
                    $str .= '<tr>';
                    $str .= '<td style="width:180px;float: left;padding-left: 0;vertical-align: bottom;">';
                        $str .= '<p style="font-size:14px;margin-top: 20px;">'.$data['date'].'</p>';
                    $str .= '</td>';
                    $str .= '<td style="text-align:center;width:110px;float:right;">';
                        $str .= '<p style="font-size:12px;">Category Average:</p>';
                        $str .= '<p class="'.($data['avg']['cls'] ? $data['avg']['cls'] : '').'" style="margin: 2px auto 0 auto;font-size:11px;padding:5px 10px; border-radius:3px;width:70px;color:#ffffff;">'.($data['avg']['text'] ? $data['avg']['text'] : '').'</p>';
                    $str .= '</td>';
                    $str .= '</tr>';
                    $str .= '</table>';
                $str .= '</td>';
                $str .= '<td class="'.($data['function']['bg'] ? $data['function']['bg'] : '').'" style="border-left: 0;vertical-align:top;color:#fff;">';
                    $str .= '<p style="font-size:18px;font-weight:700;margin-bottom:5px;">Category: '.($data['function']['name'] ? $data['function']['name'] : '').'</p>';
                    $str .= '<p style="margin:0;">'.($data['function']['desc'] ? $data['function']['desc'] : '').'</p>';
                $str .= '</td>';
            $str .= '</tr>';
            $str .= '<tr>';
                $str .= '<td class="'.($data['function']['bg'] ? $data['function']['bg'] : '').'" style="border-left: 0;vertical-align:bottom;color:#fff;">';
                    $str .= '<p style="font-size:18px;font-weight:700;margin-bottom:5px;text-align: center;">Vendor: '.($data['vendor'] ? $data['vendor'] : '').'</p>';
                $str .= '</td>';
            $str .= '</tr>';
        $str .= '</table>';
    // SUMMARY
    if ( !empty($data['summaries']) ) {
        $str .= '<table class="summary" style="margin: 0;border-top: 2px solid #000;border-bottom: 2px solid #000;">';
            $str .= '<tr>';
                $str .= '<td style="border-right: 2px solid #000; width: 50%;vertical-align:top;">';
                    if ( !empty($data['summaries']['comment_1']) ) { $str .= $data['summaries']['comment_1']; }
                $str .= '</td>';
                $str .= '<td style="vertical-align:top;">';
                    if ( !empty($data['summaries']['comment_2']) ) { $str .= $data['summaries']['comment_2']; }
                $str .= '</td>';
            $str .= '</tr>';
        $str .= '</table>';
    }
        
    $str .= '</div>';

    $dompdf->loadHtml($str);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->set_option("isPhpEnabled", true);
    $dompdf->set_option("isRemoteEnabled", true);
    $dompdf->render();
    // $dompdf->get_canvas()->page_text(595, 10, "EXECUTIVE SUMMARY (CONFIDENTIAL)--Not for External Distribution", '', 7, array(0,0,0));
    // $dompdf->get_canvas()->page_text(770, 572, "Page : {PAGE_NUM} of {PAGE_COUNT}", '', 8, array(0,0,0));
}
$dompdf->stream($filename,array("Attachment"=>0));
echo $str;
?>