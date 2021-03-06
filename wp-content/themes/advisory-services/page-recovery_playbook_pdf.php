<?php /* Template Name: Recovery Playbook Report */
require_once get_template_directory() . '/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$itemId = !empty($_GET['id']) ? intval($_GET['id']) : 0;
$default = recplayGetDataById($itemId);
if ( !empty($default) ) {
    $filename = "Recovery Playbook Report";
    $dompdf   = new Dompdf();

    $configure_desktops = !empty($default['configure_desktops']) ? '<div class="checkbox checked">YES</div>' : '<div class="checkbox unchecked">NO</div>';
    $restore_peripherals = !empty($default['restore_peripherals']) ? '<div class="checkbox checked">YES</div>' : '<div class="checkbox unchecked">NO</div>';
    $restore_interfaces = !empty($default['restore_interfaces']) ? '<div class="checkbox checked">YES</div>' : '<div class="checkbox unchecked">NO</div>';

    $str = '<html>';
    $str .= '<head>';
        $str .= '<style>';
            $str .= '@import url("https://fonts.googleapis.com/css?family=Roboto:400,500,700");';
            $str .= ' *{font-family: "Roboto", sans-serif !important;line-height:1.1;font-weight:500;}';
            $str .= '*{margin: 0;padding: 0;line-height:1.1;}';
            $str .= 'html{margin:80px 5px 20px 5px;position:relative;}';
            $str .= 'body { color: #000; margin: 0;padding: 0; font-size:14px;}';
            $str .= 'table { border-collapse: collapse;border-spacing: 0; width: 100%; }';
            $str .= 'table tr td { padding: 10px;}';
            $str .= 'ul { padding-left:20px; }';
            $str .= 'h1, h2, h3, h4 { margin: 0;line-height: 1; font-weight:700;}';
            $str .= '.mt-0 {margin-top: 0px !important;}';
            $str .= '.mt-10 {margin-top: 10px !important;}';
            $str .= '.pt-0 {padding-top: 0px !important;}';
            $str .= '.pl-0 {padding-left: 0px !important;}';
            $str .= '.pb-0 {padding-bottom: 0px !important;}';
            $str .= '.noBreak{page-break-inside: avoid}';
            $str .= '.text-center{text-align:center;}';
            // BACKGROUND_COLOR
            $str .= '.bg-light-grey { background: #d9d9d9; }';
            $str .= '.bg-dark-grey { background: #404040; }';

            $str .= 'header { position: fixed; left: 0px; top: -75px; right: 0px; }';

            $str .= '.recoveryPlaybook {font-size: 16px;font-weight: 500;}';
            $str .= 'strong { font-weight: 700 !important; }';
            $str .= 'table{ margin-bottom: 20px; width:100%;}';
            $str .= '.note {font-size: 16px;font-style: italic;padding-left:0;}';
            $str .= '.mainTitle {padding: 7px 10px;font-weight:bold;font-size: 22px;color: #fff;background: #385623;}';
            // $str .= '.title {padding: 7px 10px;font-weight:bold;font-size: 19px;color: #fff;margin-top: 10px;background: #000;}';
            $str .= '.title {padding: 10px;font-weight:bold;font-size: 19px;color: #fff;background: #000;border:1px solid #000;}';
            $str .= 'td:has(input) { display: none;; }';
            $str .= 'input, textarea { width: 100%; background: #dde4ff; border: none; padding-left: 5px; }';
            $str .= 'input[type="text"] { height: 37px; display: block; }';
            $str .= 'textarea { display: block; resize: none; }';
            $str .= 'input:focus, textarea:focus { outline: none; }';
            $str .= 'input[type="checkbox"] {width: 38px;height: 38px;margin: 0;vertical-align: bottom;margin-right: 60px;margin-left: 0px;}';
            $str .= '.table-sp { margin-bottom: 0; }';
            // $str .= '.table-sp tr td { border-bottom: 1px solid #000; border-right: 1px solid #000; border-top: 0; }';
            // $str .= '.table-sp tr td:first-child { border-left: 1px solid #000;}';

            $str .= '.table-sp tr td { border-bottom: 1px solid #000; border-right: 1px solid #000; border-top: 0; }';
            $str .= '.table-sp tr td:last-child { border-right: 0px solid #000;}';

            $str .= '.table-borderless { margin-bottom: 0; }';
            $str .= '.table-borderless tr td { border-top: 0px solid #000; }';
            $str .= '.checklistTitle {width: 170px;color: #fff;background: #404040;font-family: "Roboto", sans-serif !important;}';
            $str .= '.checklistDesc {width: 50px;padding: 0;}';
            $str .= '.checkbox {width: 50px; height: 38px; line-height: 30px; margin-right: 50px;text-align: center;font-size:14px;font-weight:700;}';
            $str .= '.checkbox.checked {background: #0075ff; color: #fff;}';
            $str .= '.checkbox.unchecked {background: #d9d9d9; color: red;}';

            $str .= '.bg-input{background: #dde4ff;}';
            // $str .= '.recoveryPlaybook{width:1000px;}';
            $str .= '.recoveryPlaybook{ position:relative; }';
            $str .= '.test{background:red}';
        $str .= '</style>';
    $str .= '</head>';
    $str .= '<body>';
        $str .= '<header>';
                $str .= '<table class="table table-borderless mb-0" style="margin-bottom: 0px;">';
                    $str .= '<tr>';
                        $str .= '<td class="bg-palm-leaf mainTitle" style="width: 700px;"> System/Application Recovery Playbook </td>';
                        $str .= '<td class=""> </td>';
                        $str .= '<td class="bg-dark-yellow" style="width: 115px;background-color:#ffff00;"> Playbook ID# </td>';
                        $str .= '<td class="bg-light-grey" style="width: 65px; padding: 0; text-align: center;"> PL - '.$default['serial_no'].' </td>';
                    $str .= '</tr>';
                    $str .= '<tr><td class="pb-0 note" colspan="4"><strong>Note: </strong> This Playbook should be used with the Disaster Management Forms</td></tr>';
                $str .= '</table>';
        $str .= '</header>';
        $str .= '<div class="recoveryPlaybook">';
            $str .= '<table class="table table-sp mt-10">';
                $str .= '<tr><td class="title" colspan="2">Support Profile</td></tr>';
                $str .= '<tr>';
                    // $str .= '<td class="bg-light-grey" style="width: 40px;"> REF# </td>';
                    // $str .= '<td class="" style="width: 30px;"> RT- </td>';
                    // $str .= '<td class="bg-input text-center" style="width: 40px;"> '.$default['ref'].' </td>';
                    $str .= '<td class="bg-light-grey" style="width: 190px;"> System/Application Name: </td>';
                    $str .= '<td class="bg-input"> '.$default['app_name'].' </td>';
                $str .= '</tr>';
            $str .= '</table>';
            $str .= '<table class="table table-sp">';
                $str .= '<tr>';
                    $str .= '<td class="bg-light-grey" style="width: 90px;">Description:</td>';
                    $str .= '<td class="bg-input">'.$default['app_desc'].'</td>';
                $str .= '</tr>';
            $str .= '</table>';
            $str .= '<table class="table table-sp">';
                $str .= '<tr>';
                    $str .= '<td class="bg-light-grey" style="width: 170px;">Vendor Name/Contact: </td>';
                    $str .= '<td class="bg-input">'.$default['vendor_name'].'</td>';
                $str .= '</tr>';
            $str .= '</table>';
            $str .= '<table class="table table-sp">';
                $str .= '<tr>';
                    $str .= '<td class="bg-light-grey" style="width: 80px;"> Licensing: </td>';
                    $str .= '<td class="bg-input">'.$default['licensing'].'</td>';
                    $str .= '<td class="bg-light-grey" style="width: 125px;"> Current Version: </td>';
                    $str .= '<td class="bg-input">'.$default['current_version'].'</td>';
                    $str .= '<td class="bg-light-grey" style="width: 70px;"> Location: </td>';
                    $str .= '<td class="bg-input">'.$default['location'].'</td>';
                $str .= '</tr>';
            $str .= '</table>';
            $str .= '<table class="table table-sp mt-10">';
                $str .= '<tr><td class="title" colspan="2">Tecnical Support Information</td></tr>';
                $str .= '<tr>';
                    $str .= '<td class="bg-light-grey" style="width: 210px;"> Primary Support Contract(s): </td>';
                    $str .= '<td class="bg-input">'.$default['primary_support'].'</td>';
                $str .= '</tr>';
            $str .= '</table>';
            $str .= '<table class="table table-sp">';
                $str .= '<tr>';
                    $str .= '<td class="bg-light-grey" style="width: 230px;"> Secondary Support Contract(s): </td>';
                    $str .= '<td class="bg-input">'.$default['secondary_support'].'</td>';
                $str .= '</tr>';
            $str .= '</table>';
            $str .= '<table class="table table-sp mt-10 noBreak">';
                $str .= '<tr>';
                    $str .= '<td class="title" style="width: 50%;"> Architecture Notes and Assumptions (if applicable) </td>';
                    $str .= '<td class="title"> Backup Schedules/Notes (if applicable) </td>';
                $str .= '</tr>';
                $str .= '<tr>';
                    $str .= '<td class="bg-input" style="vertical-align:top;">'.$default['architecture_notes'].'</td>';
                    $str .= '<td class="bg-input" style="vertical-align:top;">'.$default['backup_notes'].'</td>';
                $str .= '</tr>';
            $str .= '</table>';

            $str .= '<table class="table table-borderless mt-10 noBreak">';
                $str .= '<tr><td class="title" colspan="7">Additional Considerations Checklist (if applicable)</td></tr>';
                $str .= '<tr><td class="note" colspan="7">Please check appropriate items if required for the full recovery of the system/application</td></tr>';
                $str .= '<tr>';
                    $str .= '<td class="checklistTitle">Configure Desktops</td>';
                    $str .= '<td class="checklistDesc">'.$configure_desktops.'</td>';
                    $str .= '<td class="checklistTitle">Restore Peripherals</td>';
                    $str .= '<td class="checklistDesc">'.$restore_peripherals.'</td>';
                    $str .= '<td class="checklistTitle">Restore Interfaces</td>';
                    $str .= '<td class="checklistDesc">'.$restore_interfaces.'</td>';
                    $str .= '<td></td>';
                $str .= '</tr>';
            $str .= '</table>';
            // $str .= '<br><pre>'.print_r($default['recovery_procedures'], true).'</pre>';  
            $str .= '<table class="table table-sp table-recoveryProcedures noBreak mt-10">'; 
                $str .= '<tr><td class="title" colspan="3"> Recovery Procedures </td></tr>';
                if ( !empty($default['recovery_procedures']) ) {
                    foreach ($default['recovery_procedures'] as $rpSi => $rp) {
                        $str .= '<tr>';
                            $str .= '<td class="bg-light-grey" style="width: 50px;">Step.<span>'.($rpSi+1).'</span></td>';
                            $str .= '<td class="bg-input">'.$rp['desc'].'</td>';
                            $str .= '<td class="bg-input">'.$rp['link'].'</td>';
                        $str .= '</tr>';
                    }
                }
            $str .= '</table>';
        $str .= '</div>';
    $str .= '</body>';
    $str .= '</html>';
    // GENERATE PDF
    $dompdf->loadHtml($str);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->set_option("isPhpEnabled", true);
    $dompdf->set_option("isRemoteEnabled", true);
    $dompdf->render();
    $dompdf->get_canvas()->page_text(770, 572, "Page : {PAGE_NUM} of {PAGE_COUNT}", '', 8, array(0,0,0));
    $dompdf->stream($filename,array("Attachment"=>0));
    echo $str;
}