<?php 
/* Template Name: Table Top PDF */
require_once get_template_directory() . '/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
// $tabletopId = !empty($_GET['id']) ? $_GET['id'] : false;
if ( !empty($_GET['id']) ) $data = tabletopGetDataById($_GET['id']);
else $data = tabletopGetData();

// echo '<br><pre>'.print_r($data, true).'</pre>'; exit(); 
$filename   = "Tabletop Report";
$dompdf     = new Dompdf();
// PDF DATA
$str = ''; 
if ($data) {
    
    $str .= '<style type="text/css">';
        $str .= '@import url("https://fonts.googleapis.com/css?family=Roboto:400,500,700");';
        $str .= ' *{font-family: "Roboto", sans-serif !important;line-height:1.1;}';
        $str .= '*{margin: 0;padding: 0;line-height:1.1;}';
        $str .= 'body { color: #fff; margin: 0;padding: 0; font-size:14px;}';
        $str .= 'body .header { font-size:15px; }';
        $str .= 'body .header strong { font-size:16px; }';
        $str .= 'strong { font-size:15px; }';
        $str .= 'table { border-collapse: collapse;border-spacing: 0; width: 100%; }';
        $str .= 'table tr td { padding: 10px;}';
        $str .= 'table.bordered tr td { border: 2px solid #fff;}';
        $str .= 'ul { padding-left:20px; }';
        $str .= 'h1, h2, h3, h4 { margin: 0;line-height: 1; font-weight:700;}';
        $str .= '.bl-0 { border-left: 0; }';
        $str .= '.br-0 { border-right: 0; }';
        $str .= '.m-0 { margin: 0; }';
        $str .= '.mb-0 { margin-bottom: 0; }';
        $str .= '.actionItemsTitle { background: #525252; padding: 10px;border-top:1px solid #fff;font-weight:bold;font-size:20px; }';
        $str .= '.actionItems tr.border:last-child { display:none; }';
        $str .= '.exerciseResults .exerciseResult { border-bottom:2px solid #fff; }';
        $str .= '.exerciseResults .exerciseResult:last-child { border-bottom:0px solid #fff; }';
    $str .= '</style>';
    $str .= '<div class="container" style="margin: 0 auto;">';
        $str .= tabletop_pdf_header($data);
        $str .= '<div class="actionItemsTitle"> Exercise Results </div>';
        $str .= '<table style="background: #efefef; color: #000; margin: 0;">';
            $str .= '<tr>';
                $str .= '<td class="exerciseResults" style="border-right: 5px solid #fff; width: 50%;padding:0 10px;vertical-align:top;">';
                        $str .= tabletop_pdf_exercise_results($data['excercise_results'][1], 1);
                        $str .= tabletop_pdf_exercise_results($data['excercise_results'][2], 2);
                        $str .= tabletop_pdf_exercise_results($data['excercise_results'][3], 3);
                $str .= '</td>';
                $str .= '<td class="exerciseResults" style="padding:0 10px;vertical-align:top;">';
                        $str .= tabletop_pdf_exercise_results($data['excercise_results'][4], 4);
                        $str .= tabletop_pdf_exercise_results($data['excercise_results'][5], 5);
                        $str .= tabletop_pdf_exercise_results($data['excercise_results'][6], 6);
                $str .= '</td>';
            $str .= '</tr>';
        $str .= '</table>';
        $str .= '<div style="page-break-before: always;"></div>';
        $str .= tabletop_pdf_header($data);
        $str .= '<div class="actionItemsTitle"> Action Items </div>';
        $str .= '<table style="background: #efefef; color: #000; margin: 0;">';
            $str .= '<tr>';
                $str .= '<td style="border-right: 5px solid #fff; width: 50%;padding:0;vertical-align:top;">';
                    $str .= '<table class="actionItems" style="color:#000; width:100%">';
                        $str .= tabletop_pdf_actionItem($data['action_items'][1], 1);
                        $str .= tabletop_pdf_actionItem($data['action_items'][2], 2);
                        $str .= tabletop_pdf_actionItem($data['action_items'][3], 3);
                    $str .= '</table>';
                $str .= '</td>';
                $str .= '<td style="padding: 0;vertical-align:top;">';
                    $str .= '<table class="actionItems" style="color:#000; width:100%">';
                        // $str .= tabletop_pdf_actionItem($data['action_items'][1], 1);
                        $str .= tabletop_pdf_actionItem($data['action_items'][4], 4);
                        $str .= tabletop_pdf_actionItem($data['action_items'][5], 5);
                    $str .= '</table>';
                $str .= '</td>';
            $str .= '</tr>';
        $str .= '</table>';
        
    $str .= '</div>';

    $dompdf->loadHtml($str);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->set_option("isPhpEnabled", true);
    $dompdf->set_option("isRemoteEnabled", true);
    $dompdf->render();
    $dompdf->get_canvas()->page_text(595, 10, "EXECUTIVE SUMMARY (CONFIDENTIAL)--Not for External Distribution", '', 7, array(0,0,0));
    $dompdf->get_canvas()->page_text(770, 572, "Page : {PAGE_NUM} of {PAGE_COUNT}", '', 8, array(0,0,0));
}
$dompdf->stream($filename,array("Attachment"=>0));
echo $str;
?>