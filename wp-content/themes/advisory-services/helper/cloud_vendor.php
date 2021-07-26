<?php
function cloud_vendor_form_threatcats()
{
    if (is_admin() && is_edit_page()) {
        $id = @$_GET['post'];
        $meta = get_post_meta($id, 'form_opts', true);
        // help($meta);
        $data = [];
        $data[] = ['type' => 'notice', 'class' => 'danger', 'content' => 'Create Categories and save.',];
        if (!empty($meta['areas'])) {
            foreach ($meta['areas'] as $areaSi => $area) {
                if ( !empty($area['name']) ) {
                    $data[] = array(
                        'id' => 'area_'.$areaSi . '_threatcat',
                        'type' => 'group',
                        'title' => $area['name'],
                        'desc' => 'Each Domain name should be unique',
                        'button_title' => 'Add New',
                        'accordion_title' => 'Add New',
                        'fields' => [
                            ['id' => 'name', 'type' => 'text', 'title' => 'Name'],
                            ['id' => 'desc', 'type' => 'textarea', 'title' => 'Desc']
                        ],
                    );
                }
            }
        }
        return $data;
    }
}
// area_1_threatcat_2_threat
function cloud_vendor_form_threats()
{
    if (is_admin() && is_edit_page()) {
        $id = @$_GET['post'];
        $meta = get_post_meta($id, 'form_opts', true);
        $data = [];
        $data[] = ['type' => 'notice', 'class' => 'danger', 'content' => 'Create Control Statements and save.'];
        if ( !empty($meta['areas']) ) {
            foreach ( $meta['areas'] as $areaSi => $area ) {
                $data[] = ['type' => 'subheading', 'content' => $area['name']];
                $threatCatId = 'area_'.$areaSi .'_threatcat';
                if ( $threatsCats = @$meta[$threatCatId] ) {
                    foreach ( $threatsCats as $threatCatSi => $threatCat ) {
                        if ( !empty($threatCat['name']) ) {
                            $data[] = array(
                                'id' => $threatCatId .'_'. $threatCatSi . '_threat',
                                'type' => 'group',
                                'title' => $threatCat['name'],
                                'button_title' => 'Add New',
                                'accordion_title' => 'Add New',
                                'fields' => [
                                    ['id' => 'name', 'type' => 'text', 'title' => 'Name'],
                                    ['id' => 'weight', 'type' => 'number', 'title' => 'Weight', 'default' => 100],
                                    ['id' => 'desc', 'type' => 'textarea', 'title' => 'Desc'],
                                ]
                            );
                        }
                    }
                }
            }
        }
        return $data;
    }
}
function cloud_vendor_form_statements()
{
    if (is_admin() && is_edit_page()) {
        $id = @$_GET['post'];
        $meta = get_post_meta($id, 'form_opts', true);
        $data = [];
        // help($meta);
        $data[] = ['type' => 'notice', 'class' => 'danger', 'content' => 'Create Questions and save.'];
        if ( !empty($meta['areas']) ) {
            foreach ( $meta['areas'] as $areaSi => $area ) {
                $threatCatId = 'area_'.$areaSi . '_threatcat';
                if ( $threatsCats = @$meta[$threatCatId] ) {
                    foreach ( $threatsCats as $threatCatSi => $threatCat ) {
                        $threatId = $threatCatId.'_'.$threatCatSi.'_threat';
                        $data[] = ['type' => 'subheading', 'content' => $threatCat['name'].' - '.$area['name']];
                        if ( $threats = @$meta[$threatId] ) {
                            foreach ($threats as $threatSi => $threat ) {
                                $data[] = array(
                                    'id' => $threatId .'_'.$threatSi.'_question',
                                    'type' => 'group',
                                    'title' => $threat['name'],
                                    'button_title' => 'Add New',
                                    'accordion_title' => 'Add New',
                                    'fields' => [['id' => 'name', 'type' => 'text', 'title' => 'Name']]
                                );
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }
}
function cloud_vendorBackgroundByValue($val, $type='impact', $reverse=false)
{
    $cl = 'bg-blue';
    if ( !empty($val) && !empty($type) ) {
        if ( $type == 'impact' ) {
            switch ($val) {
                case '1': $cl = 'bg-blue'; break;
                case '2': $cl = 'bg-green'; break;
                case '3': $cl = 'bg-yellow'; break;
                case '4': $cl = 'bg-orange'; break;
                case '5': $cl = 'bg-red'; break;
                default: $cl = 'bg-blue'; break;
            }
        } elseif ( $type == 'vulnerability' || $type == 'threat' ) {
            switch ($val) {
                case '1': $cl = 'bg-blue'; break;
                case '2': $cl = 'bg-yellow'; break;
                case '3': $cl = 'bg-red'; break;
                default: $cl = 'bg-blue'; break;
            }
        }
    }
    return $cl;
}
function cloud_vendor_risk_calc($vulnerability, $impact, $probability) {
    if (!$vulnerability && !$impact && !$probability) return 1;
    if (!$impact) $impact = 1;
    if (!$probability) $probability = 1;
    if (!$vulnerability) $vulnerability = 1;
    $total = $impact * $vulnerability * $probability;
    if ($total < 2) return 1;
    return $total;
}
function cloud_vendorRiskBackground(float $value) {
    if ( $value >= 30 )        { $cls = 'bg-red'; }
    else if ( $value >= 20 )   { $cls = 'bg-orange'; }
    else if ($value >= 11 )    { $cls = 'bg-yellow'; }
    else if ($value >= 2 )     { $cls = 'bg-green'; }
    else                       { $cls = 'bg-blue'; }
    return $cls;
}
function cloud_vendorHeatMap($char_arr)
{
    $data = [];
    $steps = [1,2,6,11,16,20,26,30,36,41];
    foreach ($steps as $stepSI => $step) {
        $chars = [];
        $data[$stepSI]['start'] = $step;
        $data[$stepSI]['end'] = ($step == 41) ? 45 : $steps[$stepSI + 1] - 1;
        $data[$stepSI]['range'] = $data[$stepSI]['start'] .' - '. $data[$stepSI]['end'];
        $data[$stepSI]['color'] = cloud_vendorRiskBackground($step);
        for ($i=$data[$stepSI]['start']; $i <= $data[$stepSI]['end']; $i++) {
            if ( array_key_exists($i, $char_arr) ) $chars[] = $char_arr[$i];
        }
        $data[$stepSI]['char'] = $chars ? '<div class="score-list-value">(' . implode(', ', $chars) . ')</div>' : '';
    }
    return $data;
}
function cloud_vendor_get_formatted_data($post_id) {
    $meta = get_post_meta($post_id, 'form_opts', true);
    $data = [];
    $index = 0;
    if ( !empty($meta['areas']) ) {
        foreach ( $meta['areas'] as $areaSi => $area ) {
            $index2 = 0;
            $threatCatId = 'area_'.$areaSi . '_threatcat';
            if ( $threatsCats = @$meta[$threatCatId] ) {
                foreach ( $threatsCats as $threatCatSi => $threatCat ) {
                    $index2++;
                    $threatId = $threatCatId.'_'.$threatCatSi.'_threat';
                    $default = advisory_form_default_values($post_id, $threatId);
                    if ($default) {
                        $data[$index]['cat'] = $area['name'];
                        $data[$index]['base'] = $area['base'];
                        $data[$index]['areas'][$index2]['name'] = @$threatCat['name'];
                        $data[$index]['areas'][$index2]['c_summary'] = @$default['summary'];
                        $data[$index]['areas'][$index2]['c_historical_evidence'] = @$default['historical_evidence'];
                        $data[$index]['areas'][$index2]['rd'] = $threatCat['desc'];
                        $data[$index]['areas'][$index2]['lad'] = get_the_time(get_option( 'date_format'), $post_id);
                        $data[$index]['areas'][$index2]['avg'] = $default['avg'];
                        $data[$index]['areas'][$index2]['rw'] = @$default['ac'];
                        $data[$index]['areas'][$index2]['ai'] = @$default['vc'];
                        $data[$index]['areas'][$index2]['impact'] = [];
                        $data[$index]['areas'][$index2]['vulnerability'] = [];
                        $data[$index]['areas'][$index2]['threat'] = [];
                        $data[$index]['areas'][$index2]['nq'] = @$default['nq'];
                        // $data[$index]['areas'][$index2]['test'] = $default;
                        foreach ($default as $key => $value) {
                            if ( cloud_vendorRegisterDefaultItemName($key) == 'impact' )        { $data[$index]['areas'][$index2]['impact'][] = $value; }
                            if ( cloud_vendorRegisterDefaultItemName($key) == 'vulnerability' ) { $data[$index]['areas'][$index2]['vulnerability'][] = $value; }
                            if ( cloud_vendorRegisterDefaultItemName($key) == 'threat' )        { $data[$index]['areas'][$index2]['threat'][] = $value; }
                        }
                    }
                }
            }
            $index++;
        }
    }
    return $data;
}
function cloud_vendorRegisterDefaultItemName($key)
{
    if ( $key ) {
        $key = explode('_', $key);
        if ( !empty($key[count($key) - 1]) ) {
            return trim($key[count($key) - 1]);
        }
    }
    return false;
}
function cloud_vendorHasPermission()
{
    global $post;
    $opts = get_post_meta($post->ID, 'form_opts', true);
    if ( isset($_GET['edit']) ) {
        if ( advisory_has_survey_edit_permission($post->ID) && !empty($opts['areas'][$_GET['area']]) ) return true;
        else return false;
    }

    if ( advisory_has_survey_view_permission($post->ID) && !empty($opts['areas'][$_GET['area']]) ) return true;
    return false;
}
function cloud_vendorDomains($opts)
{
    global $post;
    $pageLink = site_url('cloud_vendor/'.$post->ID.'');
    $links = [1=>null, 2=>null, 3=>null, 4=>null, 5=>null];
    if ( !empty($opts['areas']) ) {
        $vendors = $opts['areas'];
        foreach ( $vendors as $domainSi => $domain ) {
            $links[$domainSi] = $pageLink.'?area='.$domainSi;
        }
        $links[count($links)] = $pageLink.'?area='.$_GET['area'];
    }
    return $links;
}
function cloud_vendorDomains_backup($opts)
{
    global $post;
    $pageLink = site_url('cloud_vendor/'.$post->ID.'');
    $links = [1=>null, 2=>null, 3=>null, 4=>null, 5=>null];
    if ( !empty($_GET['area']) && !empty($opts['areas']) ) {
        $vendors = $opts['areas'];
        foreach ( $vendors as $domainSi => $domain ) {
            $links[$domainSi] = $pageLink.'?area='.$_GET['area'].'&domain='.$domainSi;
        }
        $links[count($links)] = $pageLink.'?area='.$_GET['area'];
    }
    return $links;
}
function cloud_vendorDomainMap($opts)
{
    $str = null;
    $areaId = !empty($_GET['area']) ? $_GET['area'] : 1;
    if ( !empty($opts['areas']) ) {
        global $post;
        $defaultItem = ['name'=>null, 'link' => null];
        $data = [];
        $postLink = site_url('cloud_vendor/'. $post->ID).'/?area=';

        $data[1] = !empty($opts['areas'][1]['name']) ? ['name' => $opts['areas'][1]['name'], 'link' => $postLink.'1', 'coords' => '347,212,396,128,357,128,356,1,690,1,690,222,546,270,533,233,467,307,458,286,448,265,428,243,403,226,376,216'] : $defaultItem;
        $data[2] = !empty($opts['areas'][2]['name']) ? ['name' => $opts['areas'][2]['name'], 'link' => $postLink.'2', 'coords' =>'467,309,565,330,552,293,689,247,688,679,604,681,477,507,510,483,418,444,432,434,444,424,454,407,462,391,470,371,473,344,473,329'] : $defaultItem;
        $data[3] = !empty($opts['areas'][3]['name']) ? ['name' => $opts['areas'][3]['name'], 'link' => $postLink.'3', 'coords' =>'275,445,263,542,231,520,117,680,576,681,460,522,428,542,417,445,406,451,391,458,373,464,349,468,323,466,302,461'] : $defaultItem;
        $data[4] = !empty($opts['areas'][4]['name']) ? ['name' => $opts['areas'][4]['name'], 'link' => $postLink.'4', 'coords' =>'222,310,126,330,138,292,1,249,1,681,88,679,213,507,180,484,273,443,260,436,248,424,236,409,227,384,218,364,218,336'] : $defaultItem;
        $data[5] = !empty($opts['areas'][5]['name']) ? ['name' => $opts['areas'][5]['name'], 'link' => $postLink.'5', 'coords' => '2,226,0,0,333,3,333,128,293,128,344,214,319,216,300,222,284,230,267,239,256,249,250,258,241,267,234,277,228,290,223,307,156,234,144,269'] : $defaultItem;



        $str .='<img src="'. IMAGE_DIR_URL .'eva.png" class="img-responsive text-center" usemap="#image-map" hidefocus="true" />';
        $str .='<map name="image-map">';
            for ($i=1; $i <=5 ; $i++) {
                $str .='<area title="'.$data[$i]['name'].'" href="'.$data[$i]['link'].'" coords="'.$data[$i]['coords'].'" shape="poly">';
            }
            $str .='<area title="Cybersecurity Assessment" href="javascript:;" coords="220,338,222,320,228,301,235,281,245,265,256,253,269,241,286,231,303,223,321,217,339,217,357,216,372,217,388,221,403,227,416,237,427,243,441,258,451,274,459,289,466,310,471,326,471,349,467,369,464,383,457,399,450,409,438,428,418,443,401,454,383,459,368,464,355,465,342,466,326,465,309,462,297,456,280,447,266,438,251,424,239,411,230,389,224,373,220,359" shape="poly">';
        $str .='</map>';
    }
    // $str .= '<br><pre>'.print_r($data, true).'</pre>';
    return $str;
}
function cloud_vendorDomainCMMBackground($itemSi=0, $value=null)
{
    if ( $itemSi == 5 ) return $value ? 'bg-deepblue' : 'bg-blue';
    if ( $itemSi == 4 ) return $value ? 'bg-deepgreen' : 'bg-light-green';
    if ( $itemSi == 3 ) return $value ? 'bg-deepyellow' : 'bg-light-yellow';
    if ( $itemSi == 2 ) return $value ? 'bg-orange' : 'bg-light-orange';
    if ( $itemSi == 1 ) return $value ? 'bg-red' : 'bg-light-red';
    else               return $value ? 'bg-black' : 'bg-light-black';
}
function cloud_vendorCategoryColor($categorySi=0)
{
    if ($categorySi > 3)        return 'red';
    else if ($categorySi > 2)   return 'purple';
    else if ($categorySi > 1)   return 'orange';
    else                        return 'deepblue';
}
function cloud_vendorAvgBackground($avg)
{
    $text = $cls = '';
    if ( $avg >= 5 )     { $text = 'Optimized'; $cls  = 'bg-blue'; }
    else if ( $avg >= 4 ){ $text = 'Measured'; $cls  = 'bg-green'; }
    else if ( $avg >= 3 ){ $text = 'Defined'; $cls  = 'bg-yellow'; }
    else if ( $avg >= 2 ){ $text = 'Repeatable'; $cls  = 'bg-orange'; }
    else if ( $avg >= 1 ){ $text = 'Initial'; $cls  = 'bg-red'; }
    else                 { $text = 'Legacy'; $cls  = 'bg-black'; }
    return $cls;
}
function cloud_vendorSidebarMenu($form, $areaParam=null)
{
    if ( $form ) {
        global $user_switching;
        $str = null;
        $form_meta = get_post_meta($form, 'form_opts', true);
        $icon = '<img src="'.IMAGE_DIR_URL.'cloud_vendor/icon-menu.png" alt="">';
        $postLink = get_the_permalink($form);
        // PERMISSION
        // $param = 'view=true&';
        // $userId         = get_current_user_id();
        // $oldUser        = $user_switching->get_old_user();
        // $superUser      = get_the_author_meta( 'spuser', $userId );
        // $specialUser    = get_the_author_meta( 'specialcloud_vendoruser', $userId );
        // $specialUser    = 0;
        // if ( $oldUser || $superUser || $specialUser ) $param = '';
        // $str .= $param;
        $str .= '<li><a href="javascript:;">'. $icon .'<span>'. advisory_get_form_name($form) .'</span></a>';
            if (!empty($form_meta['areas'])) {
                $str .= '<ul class="treeview-menu">';
                foreach ( $form_meta['areas'] as $areaSi => $area ) {
                    $areaIcon = empty($area['icon_menu']) ? $icon : $area['icon_menu'];
                    $str .= '<li><a href="'. $postLink .'?'.$areaParam.'area='. $areaSi .'">'.$icon.'<span>'. $area['name'] . '</span></a></li>';
                }
                $str .= '</ul>';
            }
        $str .= '</li>';
        return $str;
    }
    return false;
}
function cloud_vendorInputController()
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
        $superUser      = get_the_author_meta( 'spuser', $userId );
        $specialUser    = get_the_author_meta( 'specialcybersecurityuser', $userId );
        $specialihcuser = get_the_author_meta( 'specialihcuser', $userId );
        $specialmtauser = get_the_author_meta( 'specialmtauser', $userId );

        if ( !empty($oldUser) || $superUser ) {
            $data['edit']    = true;
            $data['publish'] = true;
            $data['reset']   = null;
            $data['attr']    = null;
        } else if ( $specialUser || $specialihcuser || $specialmtauser ) {
            $data['edit']    = true;
            $data['attr']    = null;
        }
        // $data['test'] = [
        //     'userId' => $userId,
        //     'superUser' => $superUser,
        //     'specialUser' => $specialUser,
        //     'specialihcuser' => $specialihcuser,
        //     'specialmtauser' => $specialmtauser,
        // ];
    }
    return $data;
}
function cloud_vendorFunctionBackground($functionId = 1)
{
    $data = null;
    if ( $functionId == 5 ) $data = ['func' => 'bg-dark-olive', 'cat' => 'bg-light-olive'];
    else if ( $functionId == 4 ) $data = ['func' => 'bg-dark-red', 'cat' => 'bg-light-red'];
    else if ( $functionId == 3 ) $data = ['func' => 'bg-dark-brandyPunch', 'cat' => 'bg-light-brandyPunch'];
    else if ( $functionId == 2 ) $data = ['func' => 'bg-dark-purple', 'cat' => 'bg-light-purple'];
    else $data = ['func' => 'bg-dark-blue', 'cat' => 'bg-blue'];
    return $data;
}
function cloud_vendorScoreBg($score=0)
{
    $cl = '';
    switch (intval($score)) {
        case 1: $cl = 'bg-red';         break;
        case 2: $cl = 'bg-yellow';      break;
        case 3: $cl = 'bg-green';       break;
        case 4: $cl = 'bg-light-blue';  break;
        case 5: $cl = 'bg-deepblue';    break;
        default: $cl = 'bg-black';      break;
    }
    return $cl;
}
function cloud_vendorAvgStatus($avg=0)
{
    $data['count'] = floatval($avg);
    if ( $avg >= 5 )        { $data['cls'] = 'bg-dark-blue'; $data['text'] = 'OPTIMIZED'; }
    else if ( $avg >= 4 )   { $data['cls'] = 'bg-light-blue'; $data['text'] = 'MANAGED'; }
    else if ( $avg >= 3 )   { $data['cls'] = 'bg-green'; $data['text'] = 'DEFINED'; }
    else if ( $avg >= 2 )   { $data['cls'] = 'bg-yellow'; $data['text'] = 'REPEATABLE'; }
    else                    { $data['cls'] = 'bg-red'; $data['text'] = 'INITIAL'; }
    return $data;
}
function cloud_vendorResponseBg(int $response=0)
{
    if ( $response == 1 ) return 'bg-green';
    else if ( $response == 3 ) return 'bg-yellow';
    else return 'bg-red';
}
function cloud_vendorCsSummary($opts, $questionId, $default)
{
    $str = null;
    // $str .= '<br><pre>'.print_r($opts[$questionId], true).'</pre>';
    // $questionId = $threatId .'_'. $threatSi.'_question';
    if ( !empty($opts[$questionId]) ) {
        $responses = ['0'=>'NO', '1'=>'YES', '3' => 'PARTIAL'];
        $str .= '<div class="table-responsive">';
            $str .= '<table class="table table-bordered mb-0">';
                foreach ( $opts[$questionId] as $questionSi => $question) {
                    $ansId = $questionId.'_'.$questionSi;
                    $response = !empty($default[$ansId.'_response']) ? $default[$ansId.'_response'] : 0;
                    $comment = !empty($default[$ansId.'_comment']) ? $default[$ansId.'_comment'] : 'N/A';
                    $str .= '<tr>';
                        $str .= '<th class="t-heading-dark"><big>'.$questionSi.'. '.$question['name'].'</big></th>';
                        $str .= '<td class="text-center bg-black"><big>'.$responses[$response].'</big></td>';
                    $str .= '</tr>';
                    $str .= '<tr>';
                        $str .= '<td colspan="2"><big><strong>Comment: </strong></big>'.$comment.'</td>';
                    $str .= '</tr>';
                }
            $str .= '</table>';
        $str .= '</div>';
    }
    return $str;
}
add_action('wp_ajax_reset_cloud_vendor', 'cloud_vendor_ajax_reset');
function cloud_vendor_ajax_reset()
{
    check_ajax_referer('advisory_nonce', 'security');
    $errors = [];
    $postId = isset($_REQUEST['id']) && !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
    if ( $postId ) {
        if (!advisory_has_survey_delete_permission($postId)) wp_send_json(false);
        $opts = get_post_meta($postId, 'form_opts', true);
        if (!empty($opts['areas'])) {
            foreach ($opts['areas'] as $areaSi => $area) {
                $threatCatId = 'area_'.$areaSi.'_threatcat';
                if ( !empty($opts[$threatCatId]) ) {
                    foreach ( $opts[$threatCatId] as $threatCatSi => $threatCat ) {
                        $threatId = $threatCatId.'_'.$threatCatSi.'_threat';
                        $deleted = delete_post_meta($postId, $threatId);
                        $errors[$threatId] = $deleted;
                    }
                }
            }
            wp_send_json(true);
        }
    }
    wp_send_json(false);
}
function cloud_vendorArchivedMenu() {
    $postType = 'cloud_vendor';
    $title='Cybersecurity Register';
    $pageTitle='Cybersecurity Register';
    $image = '<img src="'.P3_TEMPLATE_URI.'/images/registers/icon-blue-dark.png" alt="'. @$title .' Icon">';
    $page = get_page_by_title($pageTitle);
    if ( $page ) {
        $companyId = advisory_get_user_company_id();
        if (advisory_metrics_in_progress($companyId, [$postType])) {
            $rr_form_id = advisory_get_active_forms($companyId, [$postType]);
        } else {
            $id = new WP_Query([
                'post_type' => $postType,
                'post_status' => 'archived',
                'posts_per_page' => 1,
                'meta_query' => [[
                    'key' => 'assigned_company',
                    'value' => $companyId,
                ]],
                'fields' => 'ids',
            ]);
            if ($id->found_posts > 0) $rr_form_id = $id->posts;
        }
        if (!empty($rr_form_id[0])) {
            $meta = get_post_meta($rr_form_id[0], 'form_opts', true);
            if (!empty($meta['areas'])) {
                echo '<li id="riskMenu_'. $rr_form_id[0] .'""><a href="javascript:;">'. $image .' '. $title .'</a>';
                    echo '<ul class="treeview-menu">';
                    foreach ($meta['areas'] as $areaSi => $area) {
                        echo '<li><a href="'. get_permalink($page) .'?area='. $areaSi .'"><span>' . $area['name'] . '</span></a></li>';
                    }
                    echo '</ul>';
                echo '</li>';
            }
        }
    }
}
function cloud_vendorRegisterData($post_id)
{
    $data = [];
    $meta = get_post_meta($post_id, 'form_opts', true);
    if (!empty($meta['areas'])) {
        foreach ($meta['areas'] as $areaSi => $area) {
            $threatCatId = 'area_'.$areaSi . '_threatcat';
            if ( $threatsCats = @$meta[$threatCatId] ) {
                foreach ( $threatsCats as $threatCatSi => $threatCat ) {
                    $threatId = $threatCatId.'_'.$threatCatSi.'_threat';
                    $default = advisory_form_default_values($post_id, $threatId);
                    if ($default || 1) {
                        $data[$areaSi]['name'] = $area['name'];
                        $data[$areaSi]['cats'][$threatCatSi]['name'] = $threatCat['name'];
                        $data[$areaSi]['cats'][$threatCatSi]['avg'] = $default[$threatId.'_avg'];
                    }
                }
            }
        }
    }
    return $data;
}
function cloud_vendorGetActiveOrArchivedAssessmentId()
{
    $company_id = advisory_get_user_company_id();
    if (advisory_metrics_in_progress($company_id, array('cloud_vendor'))) {
        $form_id = advisory_get_active_forms($company_id, array('cloud_vendor'));
    } else {
        $id = new WP_Query([
            'post_type'         => 'cloud_vendor',
            'post_status'       => 'archived',
            'posts_per_page'    => 1,
            'meta_query'        => [['key' => 'assigned_company', 'value' => $company_id]],
            'fields'            => 'ids',
        ]);
        if ($id->found_posts > 0) { $form_id = $id->posts; }
    }
    if ( !empty($form_id[0]) ) return $form_id[0];
    return false;
}
function cloud_vendorPriorityBg($value=0)
{
    if ( $value >= 3 )      { return 'bg-red'; }
    else if ( $value >= 2 ) { return 'bg-yellow'; }
    else                    { return 'bg-green'; }
}
function cloud_vendorrInputController()
{
    global $user_switching;
    $data = [
        'edit'    => false,
        'publish' => false,
        'reset'   => false,
        'attr'    => ' disabled',
        'summary' => false,
    ];
    if ( isset($_GET['view']) && $_GET['view'] == true ) return $data;
    else {
        $userId         = get_current_user_id();
        $oldUser        = $user_switching->get_old_user();
        $specialUser    = get_the_author_meta( 'specialcybersecurityuser', $userId );

        if ( !empty($oldUser) ) {
            $data['edit']    = true;
            $data['publish'] = true;
            $data['reset']   = null;
            $data['attr']    = null;
            $data['summary'] = true;
        } else if ( $specialUser ) {
            $data['edit']    = true;
            $data['attr']    = null;
            $data['summary'] = true;
        }
        // $data['test'] = [
        //     'userId' => $userId,
        //     'specialUser' => $specialUser,
        // ];
    }
    return $data;
}
function cloud_vendor_pdf_get_data($postId=0, $areaId=0)
{
    $data = $averages = $comments = [];
    if ( $postId && $areaId ) {
        $company = advisory_get_user_company();
        $opts = get_post_meta($postId, 'form_opts', true);
        if ( !empty($opts['areas'][$areaId]) ) {
            $threatCatId = 'area_'.$areaId.'_threatcat';
            if ( $threatsCats = @$opts[$threatCatId] ) {
                // return $threatsCats;
                foreach ( $threatsCats as $threatCatSi => $threatCat ) {
                    if ( !empty($threatCat['name']) ) {
                        $threatId = $threatCatId.'_'.$threatCatSi.'_threat';
                        if ( !empty($opts[$threatId]) ) {
                            $default = advisory_form_default_values($postId, $threatId);
                            $averages[$threatId] = $default['avg'];
                        }
                    }
                }
            }
        }
        $avg = number_format(array_sum($averages) / count($averages), 1);

        // SUMMARY
        $summaries = advisory_form_default_values( $company->term_id, 'area_'.$areaId.'_comments');
        $headerBg = cloud_vendorFunctionBackground($areaId);
        $data['summaries'] = !empty(trim($summaries['comment_1'])) || !empty(trim($summaries['comment_2'])) ? $summaries : false;
        $data['function'] = $opts['areas'][$areaId];
        $data['avg'] = cloud_vendorAvgStatus($avg);
        $data['date'] = get_the_time(get_option( 'date_format'), $postId);
        $data['company'] = !empty($company->name) ? $company->name : '';
        $data['function']['bg'] = $headerBg['func'];
        $data['test'] = ['registerId' => $registerId];
    }
    return $data;
}