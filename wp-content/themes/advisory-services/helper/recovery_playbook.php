<?php 
function recplayInputController()
{
    global $user_switching;
    $data = ['edit' => false, 'publish' => false, 'reset' => false, 'attr' => ' disabled'];
    if ( isset($_GET['view']) && $_GET['view'] == true ) return $data;
    else { $data = ['edit' => true, 'publish' => true, 'reset' => true, 'attr' => '']; }
    return $data;
}
function recplayInputController_backup()
{
    global $user_switching;
    $data = ['edit' => false, 'publish' => false, 'reset' => false, 'attr' => ' disabled'];
    if ( isset($_GET['view']) && $_GET['view'] == true ) return $data;
    else {
        $userId         = get_current_user_id();
        $oldUser        = $user_switching->get_old_user();
        $specialUser    = get_the_author_meta( 'specialbiauser', $userId );

        if ( !empty($oldUser) ) {
            $data['edit']    = true;
            $data['publish'] = true;
            $data['reset']   = true;
            $data['attr']    = null;
        } else if ( $specialUser ) {
            $data['edit']    = true;
            $data['attr']    = null;
        }
        // $data['test'] = [
        //     'userId' => $userId,
        //     'specialUser' => $specialUser,
        // ];
    }
    return $data;
}
function recplay_nextId($companyId=0)
{
	global $wpdb;
	$nextItemId = 10;
	$table = 'recovery_playbook';
	if ( !$companyId ) $companyId = advisory_get_user_company_id();
	$results = $wpdb->get_results("SELECT serial_no FROM ".$table." WHERE company_id = ". $companyId." ORDER BY `serial_no` ASC");

	if ( !empty($results) ) {
		foreach ($results as $result) {
			if ( $nextItemId != $result->serial_no) return $nextItemId;
			$nextItemId += 10;
		}
	}
	return $nextItemId;
}
// save table top data
add_action('wp_ajax_recplay_save', 'advisory_ajax_recplay_save');
function advisory_ajax_recplay_save() 
{
	check_ajax_referer('advisory_nonce', 'security');
	global $wpdb;
	$data = $preparedData = [];
	$playbookId = !empty($_REQUEST['id']) ? $_REQUEST['id'] : 0;
	$table = 'recovery_playbook';
	parse_str($_REQUEST['data'], $data);
	$userId = get_current_user_id();
    $data['company_id'] = advisory_get_user_company_id($userId);
	foreach ($data as $elementKey => $elementValue) {
		if ( !empty($elementValue) ) {
			if ( is_array($elementValue) ) {
				$data[$elementKey] = json_encode($elementValue);
			}
		}
	}
	// CHECKBOXES
	$data['configure_desktops'] = recplaySanitizeCheckbox($data, 'configure_desktops');
	$data['restore_peripherals'] = recplaySanitizeCheckbox($data, 'restore_peripherals');
	$data['restore_interfaces'] = recplaySanitizeCheckbox($data, 'restore_interfaces');
	// UPDATE OR INSERT
	if ( $playbookId ) {
		if ( $wpdb->update($table, $data, ['id' => $playbookId]) ) wp_send_json( true );
	} else {
		$data['serial_no'] = recplay_nextId($data['company_id']);
		if ($wpdb->insert($table, $data)) wp_send_json( 'inserted' );
	}

	// SEND ERROR REPORT
	if ( $wpdb->last_error ) wp_send_json( $wpdb->last_error );
	else wp_send_json( false );
}
function recplaySanitizeCheckbox($data, $name)
{
	return !empty($data[$name]) ? $data[$name] : null;;
}
function recplayGetActiveItem($companyId=0)
{
	global $wpdb;
	if ( !$companyId ) {
		$userId = get_current_user_id();
		$companyId = advisory_get_user_company_id($userId);
	}
	$table = 'recovery_playbook';
	$result = $wpdb->get_row('SELECT * FROM `'.$table.'` WHERE status = "active" AND company_id = '.$companyId, ARRAY_A);

	foreach ($result as $key => $value) {
		if ( isJson($value) ) {
			$result[$key] = json_decode($value, JSON_OBJECT_AS_ARRAY) ;
		}
	}
	return $result;
}
function recplayGetPublishedItems($companyId=0)
{
	global $wpdb;
	if ( !$companyId ) $companyId = advisory_get_user_company_id();
	$table = 'recovery_playbook';
	$result = $wpdb->get_results('SELECT id, serial_no FROM `'.$table.'` WHERE status = "published" AND company_id = '.$companyId.' ORDER BY `serial_no` ASC', ARRAY_A);
	return $result;
}
function recplayGetCurrentItems($companyId=0)
{
	global $wpdb;
	if ( !$companyId ) $companyId = advisory_get_user_company_id();
	$table = 'recovery_playbook';
	$result = $wpdb->get_results('SELECT * FROM `'.$table.'` WHERE status = "published" AND company_id = '.$companyId.' ORDER BY `serial_no` ASC');
	return $result;
}

function recplayGetDataById($id=0)
{
	global $wpdb;
	$table = 'recovery_playbook';
	$result = $wpdb->get_row('SELECT * FROM `'.$table.'` WHERE id = '.$id, ARRAY_A);

	foreach ($result as $key => $value) {
		if ( isJson($value) ) {
			$result[$key] = json_decode($value, JSON_OBJECT_AS_ARRAY) ;
		}
	}
	return $result;
}

// INPUT ITEMS
function recplayInputText($name, $default=null, $permission=null, $other='')
{
	$value = !empty($default[$name]) ? trim($default[$name]) : '';
	$attr = !empty($permission['attr']) ? $permission['attr'] : '';
	// $other = !empty($other) ? ' '.$other : '';
	return '<input type="text" name="'.$name.'" value="'.$value.'"'.$attr.$other.'>';
}
function recplayInputTextarea($name, $default=null, $permission=null, $other='')
{
	$value = !empty($default[$name]) ? trim($default[$name]) : '';
	$attr = !empty($permission['attr']) ? $permission['attr'] : '';
	return '<textarea name="'.$name.'"'.$attr.$other.'>'.$value.'</textarea>';
}
function recplaycheckbox($name, $default=null, $permission=null)
{
	$checked = !empty($default[$name]) ? ' checked' : '';
	$attr = !empty($permission['attr']) ? $permission['attr'] : '';
	return '<input class="form-check-input" type="checkbox" id="'.$name.'" name="'.$name.'" value="1"'.$attr.' '.$checked.'>';
}
function recplayRecoveryProducts($default=null, $permission=null)
{
	$str = '';
	$attr = !empty($permission['attr']) ? $permission['attr'] : '';
	$loop = !empty($default['recovery_procedures']) ? count($default['recovery_procedures']) : 1;
	$deleteAttr = $loop <= 1 ? ' disabled' : '';

	for ($i=0; $i < $loop; $i++) { 
		$desc = !empty($default['recovery_procedures'][$i]['desc']) ? trim($default['recovery_procedures'][$i]['desc']) : '';
		$link = !empty($default['recovery_procedures'][$i]['link']) ? trim($default['recovery_procedures'][$i]['link']) : '';
        $str .= '<tr>';
            $str .= '<td class="bg-light-grey" style="width: 70px;">Step.<span>'.($i+1).'</span></td>';
            $str .= '<td class="no-padding desc"><textarea name="recovery_procedures['.$i.'][desc]" cols="30" rows="2"'.$attr.'>'.$desc.'</textarea></td>';
            $str .= '<td class="no-padding link"><textarea name="recovery_procedures['.$i.'][link]" cols="30" rows="2"'.$attr.'>'.$link.'</textarea></td>';
            if ( $permission['edit'] ) $str .= '<td style="width: 50px;padding:0;text-align:center;background:#f33123;"><button type="button" class="btn btn-md btn-danger btn-removeStep"'.$deleteAttr.'><span class="fa fa-lg fa-trash"></span></button></td>';
        $str .= '</tr>';
    }
    return $str;
}
add_action('wp_ajax_recplay_publish', 'advisory_ajax_recplay_publish');
function advisory_ajax_recplay_publish()
{
	check_ajax_referer('advisory_nonce', 'security');
	global $wpdb;
	$table = 'recovery_playbook';
	$recplayId = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	if ( $recplayId ) {
		if ( $wpdb->update($table, ['status' => 'published', 'published_at' => date('Y-m-d h:m:s')], ['id' => $recplayId]) ) wp_send_json( true );
		else wp_send_json( false );
        // else wp_send_json( $wpdb->last_error );
	}
	wp_send_json( false );
}
add_action('wp_ajax_recplay_reset', 'advisory_ajax_recplay_reset');
function advisory_ajax_recplay_reset()
{
	check_ajax_referer('advisory_nonce', 'security');
	global $wpdb;
	$table = 'recovery_playbook';
	$recplayId = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	if ( $recplayId ) {
		if ( $wpdb->delete($table, ['id' => $recplayId]) ) wp_send_json( true );
		else wp_send_json( false );
	}
	wp_send_json( false );
}
