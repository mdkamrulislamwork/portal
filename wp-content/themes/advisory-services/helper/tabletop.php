<?php 
function isJson($string) {
	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
}
function tabletopGetData($userId=0)
{
	global $wpdb;
	$userId = get_current_user_id();
	$table = 'table_top';
	$result = $wpdb->get_row('SELECT * FROM `'.$table.'` WHERE status = "active" AND user_id = '.$userId, ARRAY_A);

	foreach ($result as $key => $value) {
		if ( isJson($value) ) {
			$result[$key] = json_decode($value, JSON_OBJECT_AS_ARRAY) ;
		}
	}
	return $result;
}
function tabletopGetDataById($id=0)
{
	global $wpdb;
	$table = 'table_top';
	$result = $wpdb->get_row('SELECT * FROM `'.$table.'` WHERE id = '.$id, ARRAY_A);

	foreach ($result as $key => $value) {
		if ( isJson($value) ) {
			$result[$key] = json_decode($value, JSON_OBJECT_AS_ARRAY) ;
		}
	}
	return $result;
}
// save table top data
add_action('wp_ajax_table_top', 'advisory_ajax_tabletop_save');
function advisory_ajax_tabletop_save() {
	check_ajax_referer('advisory_nonce', 'security');
	global $wpdb;
	$data = $preparedData = [];
	$table = 'table_top';
	parse_str($_REQUEST['data'], $data);
	$data['user_id'] = get_current_user_id();
    $data['company_id'] = advisory_get_user_company_id($data['user_id']);
	// $data['user_id'] = 11;
	foreach ($data as $elementKey => $elementValue) {
		if ( !empty($elementValue) ) {
			if ( is_array($elementValue) ) {
				$data[$elementKey] = json_encode($elementValue);
			}
		}
	}

	// UPDATE OR INSERT
	if ( $wpdb->get_var("SELECT COUNT(*) FROM ".$table." WHERE status = 'active' AND  company_id = ". $data['company_id']) ) {
		if ( $wpdb->update($table, $data, ['status' => 'active', 'company_id' => $data['company_id']]) ) wp_send_json( 'updated' );
	} else {
		if ($wpdb->insert($table, $data)) wp_send_json( 'inserted' );
	}

	// SEND ERROR REPORT
	if ( $wpdb->last_error ) wp_send_json( $wpdb->last_error );
	else wp_send_json( false );
}
add_action('wp_ajax_tabletop_update', 'advisory_ajax_tabletop_update');
function advisory_ajax_tabletop_update() {
    check_ajax_referer('advisory_nonce', 'security');
    global $wpdb;
    $data = $preparedData = [];
    $table = 'table_top';
    $tabletopId = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
    if ( $tabletopId ) {
        parse_str($_REQUEST['data'], $data);
        // $data['user_id'] = 11;
        foreach ($data as $elementKey => $elementValue) {
            if ( !empty($elementValue) ) {
                if ( is_array($elementValue) ) {
                    $data[$elementKey] = json_encode($elementValue);
                }
            }
        }

        // UPDATE OR INSERT
        if ( $wpdb->update($table, $data, ['status' => 'published', 'id' => $tabletopId]) ) wp_send_json( 'updated' );
        else wp_send_json( $wpdb->last_error );
    }
    
    wp_send_json( false );
}

add_action('wp_ajax_tabletop_reset', 'advisory_ajax_tabletop_reset');
function advisory_ajax_tabletop_reset()
{
	check_ajax_referer('advisory_nonce', 'security');
	global $wpdb;
	$table = 'table_top';
	$tabletopId = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	if ( $tabletopId ) {
		if ( $wpdb->delete($table, ['id' => $tabletopId]) ) wp_send_json( true );
		else wp_send_json( false );
	}
	wp_send_json( false );
}
add_action('wp_ajax_tabletop_publish', 'advisory_ajax_tabletop_publish');
function advisory_ajax_tabletop_publish()
{
	check_ajax_referer('advisory_nonce', 'security');
	global $wpdb;
	$table = 'table_top';
	$tabletopId = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	if ( $tabletopId ) {
		if ( $wpdb->update($table, ['status' => 'published'], ['id' => $tabletopId]) ) wp_send_json( true );
		else wp_send_json( false );
        // else wp_send_json( $wpdb->last_error );
	}
	wp_send_json( false );
}
add_action('wp_ajax_tabletop_delete', 'advisory_ajax_tabletop_delete');
function advisory_ajax_tabletop_delete()
{
    check_ajax_referer('advisory_nonce', 'security');
    global $wpdb;
    $table = 'table_top';
    $tabletopId = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
    if ( $tabletopId ) {
        if ( $wpdb->delete($table, ['id' => $tabletopId]) ) wp_send_json( true );
        else wp_send_json( false );
    }
    wp_send_json( false );
}
function tabletop_opt_radio($name = '', $opts='', $default = null, $attr = ''): string
{
	$str = '';
	if ( !empty($opts) && is_array($opts) ) {
		foreach ($opts as $opt) {
			$isChecked = !empty($default) && $opt == $default ? ' checked' : '';
			$str .= '<td class="text-center"><input name="'.$name.'" type="radio" value="'.$opt.'"'.$isChecked.$attr.'/></td>';
		}
	}
	return $str;
}


function tabletop_opt_checkbox($name='', $item = '', $default='', $attr='', $value=1)
{
	$str = $itemName = null;
	if ( !empty($item) ) {
		$itemName = $name.'['.$item.']';
	}
	$isChecked = !empty($default[$name][$item]) ? ' checked' : '';
	return '<td class="text-center"><input name="'.$itemName.'" type="checkbox" value="'.$value.'" '.$isChecked.$attr.'/></td>';
}

function tabletop_opt_textarea($name, $default='', $attr='')
{
	return '<td style="width: 450px;" class="no-padding"><textarea name="'.$name.'" style="resize: none;" class="form-control" rows="4"'.$attr.'>'.$default.'</textarea></td>';
}
function tabletopInputController()
{
    global $user_switching;
    $data = [
        'edit'    => false,
        'publish' => false,
        'reset'   => false,
        'attr'    => ' disabled',
    ];
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
function tabletopActionItems($permission, $data)
{
    $str = '';
    for ($itemSi=1; $itemSi <=5 ; $itemSi++) { 
        $str .= '<tr>';
            $str .= '<td style="color: #fff;background: #000000db;text-align: center;">'.$itemSi.'</td>';
            $str .= '<td class="no-padding"><input name="action_items['.$itemSi.'][name]" type="text" class="form-control" value="'.@$data['action_items'][$itemSi]['name'].'"'.$permission['attr'].' /></td>';
            $str .= '<td style="width: 100px;" class="popupComment '.(!empty($data['action_items'][$itemSi]['desc']) ? 'bg-red' : 'bg-green').'" isactive="'.$permission['attr'].'">';
                $str .= '<textarea name="action_items['.$itemSi.'][desc]" class="hidden">'.@$data['action_items'][$itemSi]['desc'].'</textarea>';
            $str .= '</td>';
            $str .= '<td class="no-padding"><input name="action_items['.$itemSi.'][responsibility]" type="text" class="form-control" value="'.@$data['action_items'][$itemSi]['responsibility'].'"'.$permission['attr'].' /></td>';
            $str .= '<td class="no-padding"><input name="action_items['.$itemSi.'][date]" type="text" class="form-control" value="'.@$data['action_items'][$itemSi]['date'].'"'.$permission['attr'].' /></td>';
            $str .= '<td>'.advisory_opt_select('action_items['.$itemSi.'][completed]', 'action_items_'.$itemSi.'_completed', 'no-padding', $permission['attr'], ['','YES', 'NO', 'PARTIAL'], @$data['action_items'][$itemSi]['completed']).'</td>';
        $str .= '</tr>';
    }
    return $str;
}
// PDF FUNCTIONS
function tabletop_pdf_header($data)
{
    $str = '';
    $str .= '<table class="bordered header" style="width: 100%;">';
        $str .= '<tr>';
            $str .= '<td rowspan="2" style="background-color: #8b133f; text-align: center;border-left: 0;width:100px;"><img src="'.IMAGE_DIR_URL.'tabletop/logo.png" style="height: 100px; "></td>';
            $str .= '<td rowspan="2" style="background-color: #8b133f; text-align: center; vertical-align: top; color: #fff; padding: 20px 0 0 0;width:240px;">';
                $str .= '<h3>Tabletop Exercise Name</h3>';
                $str .= '<p style="margin-top:5px; font-weight:700;font-size:24px;">'.@$data['plan_name'].'</p>';
            $str .= '</td>';
            $str .= '<td style="background:#000;"> <strong>Test Method:</strong> '.@$data['test']['method'].' </td>';
            $str .= '<td style="border-right:0;background:#000;">';
                $str .= '<p class="m-0 testLeader"><strong>Test Leader:</strong> '.$data['test']['leader'].' </p>';
                $str .= '<p class="m-0 testDate"><strong>Date of Report:</strong> '.$data['date_of_excercise'].'</p>';
            $str .= '</td>';
        $str .= '</tr>';
        $str .= '<tr>';
            $str .= '<td colspan="2" style="border-right:0;background:#000;">';
                $str .= '<p class="m-0"><strong>Scenario Name:</strong> '.$data['scenario']['name'].'</p>';
                $str .= '<p class="m-0"><strong>Description:</strong> '.$data['scenario']['desc'].'</p>';
            $str .= '</td>';
        $str .= '</tr>';
    $str .= '</table>';
    return $str;
}
function tabletop_pdf_actionItem2($item, $itemSi=1)
{
    $str = '';
    if ( !empty($item) && !empty($item['name']) ) {
        $padding = !empty($item['desc']) ? 'padding-bottom:0;' : '';
        $status = ['', 'YES', 'NO', 'PARTIAL'];
        $completed = !empty($item['completed']) ? $status[$item['completed']] : '';
        // $str .= '<table style="color:#000; width:100%">';
            $str .= '<tr>';
                $str .= '<td style="'.$padding.'">';
                    $str .= '<strong style="font-size:18px;font-weight:700;margin-top:0;line-height:1;color:#2184be;">'.$item['name'].'</strong>';
                    $str .= '<p class="m-0"><strong>Responsibility: </strong>'.$item['responsibility'].'</p>';
                $str .= '</td>';
                $str .= '<td style="vertical-align:top;width:160px;text-align:center;padding-top:19px;"> <strong>Due Date: </strong> <br>'.$item['date'].' </td>';
                $str .= '<td style="vertical-align:top;width:50px;text-align:center;padding-top:19px;"> <strong>Completed: </strong> <br>'.$completed.' </td>';
            $str .= '</tr>';
            // if ( !empty($item['desc']) ) {
            //     $str .= '<tr>';
            //         $str .= '<td colspan="3" style="padding-top:0">';
            //             $str .= '<p class="descTitle"><strong>Description:</strong> </p>';
            //             $str .= '<div class="descText"> '.$item['desc'].'</div>';
            //         $str .= '</td>';
            //     $str .= '</tr>';
            // }
            if ( !($itemSi == 3 || $itemSi == 5) ) {
                $str .= '<tr>';
                    $str .= '<td colspan="3" style="padding-top:0;padding-bottom:0;"><p style="margin:0;border-bottom:2px solid #fff;font-size:10px;">&nbsp;</p></td>';
                $str .= '</tr>';
            }
        // $str .= '</table>';
    }
    return $str;
}
function tabletop_pdf_actionItem($item, $itemSi=1)
{
    $str = '';
    if ( !empty($item) && !empty($item['name']) ) {
        $padding = !empty($item['desc']) ? 'padding-bottom:0;' : '';
        $status = ['', 'YES', 'NO', 'PARTIAL'];
        $completed = !empty($item['completed']) ? $status[$item['completed']] : '';
        // $str .= '<table style="color:#000; width:100%">';
            $str .= '<tr>';
                $str .= '<td style="font-size:18px;font-weight:700;margin-top:0;line-height:1;color:#2184be;font-weight:bold;padding-bottom:0;">'.$item['name'].'</td>';
                $str .= '<td style="vertical-align:top;width:160px;text-align:center;font-weight:bold;padding-bottom:0;"> Due Date: </td>';
                $str .= '<td style="vertical-align:top;width:50px;text-align:center;font-weight:bold;padding-bottom:0;"> Completed: </td>';
            $str .= '</tr>';
            $str .= '<tr>';
                $str .= '<td style="'.$padding.'padding-top:0;vertical-align:top;">';
                    $str .= '<p class="m-0"><strong>Responsibility: </strong>'.$item['responsibility'].'</p>';
                $str .= '</td>';
                $str .= '<td style="vertical-align:top;width:160px;text-align:center;padding-top:0;">'.$item['date'].' </td>';
                $str .= '<td style="vertical-align:top;width:50px;text-align:center;padding-top:0;">'.$completed.' </td>';
            $str .= '</tr>';
            if ( !empty($item['desc']) ) {
                $str .= '<tr>';
                    $str .= '<td colspan="3" style="padding-top:0">';
                        $str .= '<p class="descTitle"><strong>Description:</strong> </p>';
                        $str .= '<div class="descText"> '.$item['desc'].'</div>';
                    $str .= '</td>';
                $str .= '</tr>';
            }
            $str .= '<tr class="border">';
                $str .= '<td colspan="3" style="padding-top:0;padding-bottom:0;"><p style="margin:0;border-bottom:2px solid #fff;font-size:0px;">&nbsp;</p></td>';
            $str .= '</tr>';
            // if ( !($itemSi == 3 || $itemSi == 5) ) {
            // }
        // $str .= '</table>';
    }
    return $str;
}
function tabletop_pdf_exercise_results($item_text, $itemSi=1)
{
    $str = '';
    if ( !empty($item_text) ) {
    	$titles = [
    		1 => 'Key Objectives',
    		2 => 'What Worked Well',
    		3 => 'What Did Not Work Well',
    		4 => 'Major Lessons Learned',
    		5 => 'Arrangements to Update Plans',
    		6 => 'Independent Observer Findings',
    	];
    	$border = '';
        // $border = !( $itemSi == 3 || $itemSi == 6 ) ? 'border-bottom:2px solid #fff;' : '';
        $str .= '<div class="exerciseResult" style="padding: 10px 0;'.$border.'">';
	        $str .= '<h4 style="font-size:17px;font-weight:700;margin-bottom:10px;color:#2184be;">'.$titles[$itemSi].'</h4>';
	        $str .= '<div class="descText">'.$item_text.'</div>';
        $str .= '</div>';
    }
    return $str;
}
// DOCUMENT LIBRARY
function tabletop_get_published_items($companyId=0)
{
    global $wpdb;
    if (!$companyId) $companyId = advisory_get_user_company_id();
    $table = 'table_top';
    $result = $wpdb->get_results('SELECT * FROM `'.$table.'` WHERE status = "published" AND company_id = '.$companyId.' ORDER BY id DESC', ARRAY_A);
    // foreach ($result as $key => $value) {
    //     if ( isJson($value) ) {
    //         $result[$key] = json_decode($value, JSON_OBJECT_AS_ARRAY) ;
    //     }
    // }
    // echo '<br><pre>'.print_r($result, true).'</pre>'; 
    return $result;

}