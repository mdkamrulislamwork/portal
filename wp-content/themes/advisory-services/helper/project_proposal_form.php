<?php
// ORDER OF RESTORATION
add_action('wp_ajax_ppf_validate_form_submission', 'advisory_ajax_ppf_validate_form_submission');
function advisory_ajax_ppf_validate_form_submission(){
    check_ajax_referer('advisory_nonce', 'security');
    parse_str($_REQUEST['data'], $data);
    foreach ($data as $itemId => $item) {
        if (!$item) wp_send_json($itemId);
    }
    wp_send_json(true);
}
add_action('wp_ajax_ppf_delete', 'advisory_ajax_ppf_delete');
function advisory_ajax_ppf_delete(){
    check_ajax_referer('advisory_nonce', 'security');
    global $wpdb;
    $post_id = $_REQUEST['post_id'];
    if ( $post_id && $wpdb->delete('project_proposal_form', ['id' => $post_id]) ) wp_send_json(true);
    wp_send_json(false);
}
add_action('wp_ajax_ppf_publish', 'advisory_ajax_ppf_publish');
function advisory_ajax_ppf_publish(){
    check_ajax_referer('advisory_nonce', 'security');
    global $wpdb;
    $post_id = $_REQUEST['post_id'];
    parse_str($_REQUEST['data'], $data);
    if( $post_id && $wpdb->update('project_proposal_form', ['status'  => 'published'], ['id' => $post_id]) ) wp_send_json(true);
    wp_send_json(false);
}
add_action('wp_ajax_ppf_save', 'advisory_ajax_ppf_save');
function advisory_ajax_ppf_save(){
    check_ajax_referer('advisory_nonce', 'security');
    global $wpdb;
    $post_id = $_REQUEST['post_id'];
    parse_str($_REQUEST['data'], $data);
    if($post_id) {
        $arr = [
            'company_id'=>$post_id,
            'project_name'=>$data['project_name'],
            'project_status'=>$data['project_status'],
            'current_state'=>$data['current_state'],
            'future_state'=>$data['future_state'],
            'proposed_solution'=>$data['proposed_solution'],
            'operating'=>$data['operating'],
            'capital'=>$data['capital'],
            'options'=>$data['options'],
            'benefits_and_measures'=>$data['benefits_and_measures'],
            'resource_impacts'=>$data['resource_impacts'],
        ];
        if ( !empty($data['ppf_id']) ) {
            if ($wpdb->update('project_proposal_form', $arr, ['id' => $data['ppf_id']])) wp_send_json('updated');
        }
        else {
            if ($wpdb->insert('project_proposal_form', $arr)) wp_send_json('created');
        }
    }
    wp_send_json(false);
}

function advisory_ppf_get_forms($companyId){
    global $wpdb;
    $table = 'project_proposal_form';
    return $wpdb->get_results("SELECT * FROM project_proposal_form WHERE company_id=".$companyId);
}
function advisory_ppf_get_active_form($companyId) {
    global $wpdb;
    return $wpdb->get_row("SELECT * FROM project_proposal_form WHERE status = 'active' && company_id=".$companyId);
}
function advisory_ppf_get_form_by($form_id) {
    global $wpdb;
    return $wpdb->get_row("SELECT * FROM project_proposal_form WHERE id=".$form_id);
}

function project_prioritization_requirements($id) {
    global $wpdb;
    return $wpdb->get_row("SELECT prioritization_value FROM project_prioritization_requirements WHERE project_proposal_form_id=".$id);
}

function advisory_ppf_project_status_bg($status) {
    if ($status == 'not_approved') { $cls = 'bg-blue'; }
    else if ($status == 'not_started') { $cls = 'bg-red'; }
    else if ($status == 'in_progress') { $cls = 'bg-orange'; }
    else if ($status == 'complete') { $cls = 'bg-green'; }
    else { $cls = 'bg-red'; }
    return $cls;
}
function advisorypprHasPermission()
{
	return 1;
}
function advisory_ppr_input_controller() {
    global $user_switching;
    $data = [
        'edit'          => false,
        'publish'       => false,
        'reset'         => false,
        'attr'          => ' disabled',
        'access'        => null,
        'vulnerability' => null,
    ];
    // if ( !empty($_GET['view']) && $_GET['view'] == 'true') return $data;

    $userId         = get_current_user_id();
    $oldUser        = $user_switching->get_old_user();
    $superUser      = get_the_author_meta( 'spuser', $userId );
    $specialUser    = get_the_author_meta( 'specialfacilityuser', $userId );

    if ( !empty($oldUser) || ( empty($oldUser) && ( $superUser || $specialUser ) ) ) {
        $data['edit']           = true;
        $data['publish']        = true;
        $data['attr']           = null;
        $data['access']         = 'assetsImpactedBtn ';
        $data['vulnerability']  = 'vulnerabilityBtn ';
    }

    if ( !empty($oldUser) || $superUser ) $data['reset'] = true;

    // $data['test'] = ['superUser' => $superUser, 'specialUser' => $specialUser];
    return $data;
}
function advisory_ppr_answer_bg($value=0){
    if ($value) return 'bg-red';
    return 'bg-green';
}

add_action('wp_ajax_ppr_save', 'advisory_ajax_ppr_save');
function advisory_ajax_ppr_save(){
    check_ajax_referer('advisory_nonce', 'security');
    global $wpdb;
    $project_proposal_form_id = $_REQUEST['project_proposal_form_id'] ? intval($_REQUEST['project_proposal_form_id']) : 0;
    if($project_proposal_form_id) {
        $arr = [
            'project_proposal_form_id' => $project_proposal_form_id,
            'requirements' => $_REQUEST['data'],
            'prioritization_value' => $_REQUEST['prioritization_value']
        ];
        if ( !empty($wpdb->get_row("SELECT * FROM project_prioritization_requirements WHERE project_proposal_form_id = ".$project_proposal_form_id)) ) {
            if ( $wpdb->update('project_prioritization_requirements', $arr, ['project_proposal_form_id' => $project_proposal_form_id]) ) wp_send_json('updated');
        }
        else {
            if ($wpdb->insert('project_prioritization_requirements', $arr)) wp_send_json('created');
        }
    }
    wp_send_json(false);
}
function advisory_ppr_get_form_by($form_id) {
    global $wpdb;
    $result = $wpdb->get_row("SELECT * FROM project_prioritization_requirements WHERE project_proposal_form_id=".$form_id);
    if ( $result ) parse_str($result->requirements, $result->requirements);
    return $result;
}

function cmp($a, $b) {
    return $a->prioritization_value < $b->prioritization_value;
}
add_action('wp_ajax_ppr_delete', 'advisory_ajax_ppr_delete');
function advisory_ajax_ppr_delete(){
    check_ajax_referer('advisory_nonce', 'security');
    global $wpdb;
    $post_id = $_REQUEST['post_id'];
    if ( $post_id && $wpdb->delete('project_prioritization_requirements', ['id' => $post_id]) ) wp_send_json(true);
    wp_send_json(false);
}