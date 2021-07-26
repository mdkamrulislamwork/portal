<?php
// ORDER OF RESTORATION
function orderRestorationAll() {
    global $wpdb;
    return $wpdb->get_results('SELECT *  FROM `order_of_restoration` WHERE `company_id` = '.advisory_get_user_company_id().' ORDER BY `serial_no` ASC');
}
function orderRestorationAllWithPlaybookSi() {
    global $wpdb;
    //$sql = 'SELECT *  FROM `order_of_restoration` WHERE `company_id` = '.advisory_get_user_company_id().' ORDER BY `serial_no` ASC';
    $sql = '';
    $sql .= ' SELECT';
    $sql .= ' oor.id as id, oor.company_id as company_id, oor.serial_no as serial_no, oor.activity as activity,';
    $sql .= ' oor.playbook_id as playbook_id, oor.description as description, oor.notes as notes, rp.serial_no as playbook_si, rp.app_name as app_name';

    $sql .= ' FROM order_of_restoration as oor LEFT JOIN recovery_playbook AS rp ON oor.playbook_id = rp.id';
    $sql .= ' WHERE oor.company_id = '.advisory_get_user_company_id();
    $sql .= ' ORDER BY oor.serial_no ASC';
    return $wpdb->get_results($sql);
}
function orderRestorationGetDataById($id=0)
{
    global $wpdb;
    $table = 'order_of_restoration';
    $data = $wpdb->get_row('SELECT * FROM `'.$table.'` WHERE id = '.$id);
    if ( $data->playbook_id ) $recovery_playbook = $wpdb->get_row('SELECT * FROM `recovery_playbook` WHERE id = '.$data->playbook_id);
    if ($recovery_playbook->id) $data->app_name = $recovery_playbook->app_name;
    return $data;
}
function orderRestorationNextId($companyId=0)
{
    global $wpdb;
    $nextItemId = 10;
    $table = 'order_of_restoration';
    if ( !$companyId ) $companyId = advisory_get_user_company_id();
    $results = $wpdb->get_results("SELECT serial_no FROM ".$table." WHERE company_id = ". $companyId ." ORDER BY `serial_no` ASC");

    if ( !empty($results) ) {
        foreach ($results as $result) {
            if ( $nextItemId != $result->serial_no) return $nextItemId;
            $nextItemId += 10;
        }
    }
    return $nextItemId;
}
function orderRestorationModal($size="modal-lg")
{
	$str = null;
	$str .= '<div class="modal fade" id="orderRestorationModal">';
    	$str .= '<div class="modal-dialog '.$size.'">';
        	$str .= '<div class="modal-content modal-inverse">';
            	$str .= '<div class="modal-header">';
                	$str .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
                	$str .= '<h4 class="modal-title">Order of Restoration</h4>';
            	$str .= '</div>';
            	$str .= '<div class="modal-body no-padding"></div>';
            	$str .= '<div class="modal-footer">';
                	$str .= '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                	$str .= '<button type="button" class="btn btn-primary saveBtn">Save changes</button>';
            	$str .= '</div>';
        	$str .= '</div>';
    	$str .= '</div>';
	$str .= '</div>';
	return $str;
}
add_action('wp_ajax_orderRestorationAdd', 'advisory_ajax_orderRestorationAdd');
function advisory_ajax_orderRestorationAdd()
{
    check_ajax_referer('advisory_nonce', 'security');
    $playbooks = recplayGetPublishedItems();
    $str = '';
    $str .= '<tr class="orderRestorationInput">';
        $str .= '<td class="bg-black">N/A</td>';
        $str .= '<td class="no-padding">';
            $str .= '<select class="playbook_id">';
                $str .= '<option>Select</option>';
                if ( !empty($playbooks) ) {
                    foreach ($playbooks as $playbook) {
                        $str .= '<option value="'.$playbook['id'].'" app_name="'.$playbook['app_name'].'">PL-'.$playbook['serial_no'].'</option>';
                    }
                }
            $str .= '</select>';
        $str .= '</td>';
    $str .= '<td class="no-padding app_name"></td>';
    $str .= '<td class="no-padding"><textarea class="activity"></textarea></td>';
        $str .= '<td class="no-padding"><textarea class="description"></textarea></td>';
        $str .= '<td class="no-padding bg-green orderRestorationNotes"><textarea class="hidden notes"></textarea></td>';
        $str .= '<td class="no-padding text-center">';
            $str .= '<button type="button" class="btn btn-sm btn-success btn-orderRestorationSave" title="Save"><span class="fa fa-lg fa-floppy-o""></span></button>';
            $str .= '<button type="button" class="btn btn-sm btn-danger btn-orderRestorationCancel"><span class="fa fa-lg fa-close"></span></button>';
        $str .= '</td>';
    $str .= '</tr>';
    echo $str;
    wp_die();
}
add_action('wp_ajax_orderRestorationSave', 'advisory_ajax_orderRestorationSave');
function advisory_ajax_orderRestorationSave()
{
    check_ajax_referer('advisory_nonce', 'security');
    global $wpdb;
    $data = [];
    $restorationId  = !empty($_POST['id']) ? intval($_POST['id']) : 0;
    $data['playbook_id']  = !empty($_POST['playbook_id']) ? intval($_POST['playbook_id']) : 0;
    $data['activity']     = !empty($_POST['activity']) ? $_POST['activity'] : '';
    $data['description']  = !empty($_POST['description']) ? $_POST['description'] : '';
    $data['notes']        = !empty($_POST['notes']) ? $_POST['notes'] : '';

    $table = 'order_of_restoration';
    if ( $restorationId ) {
        if ( $wpdb->update($table, $data, ['id' => $restorationId]) ) { echo orderRestorationItemsHtml(); wp_die(); }
    } else {
        $data['company_id']   = advisory_get_user_company_id();
        $data['serial_no'] = orderRestorationNextId($data['company_id']);
        if ( $wpdb->insert($table, $data) ) { echo orderRestorationItemsHtml(); wp_die(); }
    }

    wp_send_json( false );
}
add_action('wp_ajax_orderRestorationEdit', 'advisory_ajax_orderRestorationEdit');
function advisory_ajax_orderRestorationEdit()
{
    check_ajax_referer('advisory_nonce', 'security');
    $orderRestorationId = !empty($_REQUEST['id']) ? $_REQUEST['id'] : 0;
    if ( $orderRestorationId ) {
        $orderRestoration = orderRestorationGetDataById($orderRestorationId);
        $playbooks = recplayGetPublishedItems();
        $notesClass = !empty($orderRestoration->notes) ? 'bg-red': 'bg-green';
        $str = '';
        $str .= '<tr class="orderRestorationInput">';
            $str .= '<td class="bg-black">RT-'.$orderRestoration->serial_no.'<input type="hidden" class="orderRestorationId" value="'.$orderRestoration->id.'"></td>';
            $str .= '<td class="no-padding">';
                $str .= '<select class="playbook_id">';
                    $str .= '<option>Select</option>';
                    if ( !empty($playbooks) ) {
                        foreach ($playbooks as $playbook) {
                            $isSelected = $playbook['id'] == $orderRestoration->playbook_id ? ' selected' : '';
                            $str .= '<option value="'.$playbook['id'].'"'.$isSelected.' app_name="'.$playbook['app_name'].'">PL-'.$playbook['serial_no'].' ('.$playbook['app_name'].')</option>';
                        }
                    }
                $str .= '</select>';
            $str .= '</td>';
            $str .= '<td class="no-padding"><textarea class="activity">'.$orderRestoration->activity.'</textarea></td>';
            $str .= '<td class="no-padding"><textarea class="description">'.$orderRestoration->description.'</textarea></td>';
            $str .= '<td class="no-padding '.$notesClass.' orderRestorationNotes"><textarea class="hidden notes">'.$orderRestoration->notes.'</textarea></td>';
            $str .= '<td class="no-padding text-center">';
                $str .= '<button type="button" class="btn btn-sm btn-success btn-orderRestorationSave" title="Save"><span class="fa fa-lg fa-floppy-o""></span></button>';
                $str .= '<button type="button" class="btn btn-sm btn-danger btn-orderRestorationCancel"><span class="fa fa-lg fa-close"></span></button>';
            $str .= '</td>';
        $str .= '</tr>';
        echo $str;
        wp_die();
    }
    wp_send_json( false );
}
add_action('wp_ajax_orderRestorationDelete', 'advisory_ajax_orderRestorationDelete');
function advisory_ajax_orderRestorationDelete()
{
    check_ajax_referer('advisory_nonce', 'security');
    global $wpdb;
    $table = 'order_of_restoration';
    $id = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
    if ( $id ) {
        if ( $wpdb->delete($table, ['id' => $id]) ) wp_send_json( true );
        else wp_send_json( false );
    }
    wp_send_json( false );
}
function orderRestorationNotesModal($size="modal-lg")
{
    $str = null;
    $str .= '<div class="modal fade" id="orderRestorationNotesModal">';
        $str .= '<div class="modal-dialog '.$size.'">';
            $str .= '<div class="modal-content modal-inverse">';
                $str .= '<div class="modal-header">';
                    $str .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
                    $str .= '<h4 class="modal-title">Notes</h4>';
                $str .= '</div>';
                $str .= '<div class="modal-body no-padding"></div>';
                $str .= '<div class="modal-footer">';
                    $str .= '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                    $str .= '<button type="button" class="btn btn-primary saveBtn">Save changes</button>';
                $str .= '</div>';
            $str .= '</div>';
        $str .= '</div>';
    $str .= '</div>';
    return $str;
}
function orderRestorationNotesViewModal($size="modal-lg")
{
    $str = null;
    $str .= '<div class="modal fade" id="orderRestorationNotesViewModal">';
        $str .= '<div class="modal-dialog '.$size.'">';
            $str .= '<div class="modal-content modal-inverse">';
                $str .= '<div class="modal-header">';
                    $str .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
                    $str .= '<h4 class="modal-title">Notes</h4>';
                $str .= '</div>';
                $str .= '<div class="modal-body"></div>';
                $str .= '<div class="modal-footer">';
                    $str .= '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                $str .= '</div>';
            $str .= '</div>';
        $str .= '</div>';
    $str .= '</div>';
    return $str;
}
function orderRestorationItemsHtml()
{
    $str = '';
    $orderRestorations = orderRestorationAllWithPlaybookSi();
    if ( !empty($orderRestorations) ) {
        $permission = recplayInputController();
        $reportUrl = site_url('recovery-playbook-report/').'?id=';
        foreach ($orderRestorations as $orderRestoration) {
            $ortCommentClass = !empty($orderRestoration->notes) ? 'bg-red' : 'bg-green';
            $playbook_number = !empty($orderRestoration->playbook_si) ? 'PL-'.$orderRestoration->playbook_si : 'N/A';
            $app_name = !empty($orderRestoration->app_name) ? ' ('.$orderRestoration->app_name.')' : '';
            $str .= '<tr class="orderRestorationItem orderRestorationItem'.$orderRestoration->id.'" data-id="'.$orderRestoration->id.'">';
                $str .= '<td class="bg-black">RT-'.$orderRestoration->serial_no.'</td>';
                $str .= '<td>'.$playbook_number.$app_name.'</td>';
            $str .= '<td>'.$orderRestoration->activity.'</td>';
                $str .= '<td>'.$orderRestoration->description.'</td>';
                $str .= '<td class="ortCommentView '.$ortCommentClass.'"><textarea class="hidden">'.$orderRestoration->notes.'</textarea></td>';
                $str .= '<td class="no-padding text-center">';
                    if ( $orderRestoration->playbook_id ) $str .= '<a href="'.$reportUrl.$orderRestoration->playbook_id.'" class="btn btn-sm btn-primary" target="_target"><span class="fa fa-lg fa-eye"></span></a>';
                    else $str .= '<button type="button" class="btn btn-sm btn-primary" disabled><span class="fa fa-lg fa-eye"></span></button>';
                    if ( $permission['edit'] ) {
                        $str .= '<button type="button" class="btn btn-sm btn-warning btn-orderRestorationEdit"><span class="fa fa-lg fa-edit"></span></button>';
                        $str .= '<button type="button" class="btn btn-sm btn-danger btn-orderRestorationDelete"><span class="fa fa-lg fa-trash"></span></button>';
                    }
                $str .= '</td>';
            $str .= '</tr>';
        }
    }
    return $str;
}