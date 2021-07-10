<?php
function advisory_generate_cloudVendor_form_threatcats() 
{
	if (is_admin() && is_edit_page()) {
		$id = @$_GET['post'];
        // cloudVendorDefaultAssessment($id);
		$meta = get_post_meta($id, 'form_opts', true);
		$data = [];
		$data[] = ['type' => 'notice', 'class' => 'danger', 'content' => 'Create Facilities and save. Then create Threat cats, Statements and Questions',];
		if (!empty($meta['areas'])) {
			foreach ($meta['areas'] as $areaSi => $area) {
				$data[] = array(
					'id' => 'area_'.$areaSi . '_threatcat',
					'type' => 'group',
					'title' => $area['name'],
					'desc' => 'Each Threats name should be unique',
					'button_title' => 'Add New',
					'accordion_title' => 'Add New',
					'fields' => [['id' => 'name', 'type' => 'text', 'title' => 'Name'], ['id' => 'desc', 'type' => 'textarea', 'title' => 'Description']],
				);
			}
		}
		return $data;
	}
}
function advisory_generate_cloudVendor_form_threats() 
{
    if (is_admin() && is_edit_page()) {
        $id = @$_GET['post'];
        $meta = get_post_meta($id, 'form_opts', true);
        $data = [];
        $data[] = ['type' => 'notice', 'class' => 'danger', 'content' => 'Create Facilities and save. Then create Threat cats, Statements and Questions'];
        if ( !empty($meta['areas']) ) {
            foreach ( $meta['areas'] as $areaSi => $area ) {
                $data[] = ['type' => 'subheading', 'content' => $area['name']];
                $threatCatId = 'area_'.$areaSi . '_threatcat';
                if ( $threatsCats = @$meta[$threatCatId] ) {
                    foreach ( $threatsCats as $threatCatSi => $threatCat ) {
                        $data[] = array(
                            'id' => $threatCatId .'_'. $threatCatSi . '_threat',
                            'type' => 'group',
                            'title' => $threatCat['name'],
                            'button_title' => 'Add New',
                            'accordion_title' => 'Add New',
                            'fields' => [['id' => 'name', 'type' => 'text', 'title' => 'Name']]
                        );
                    }
                }
            }
        }
        return $data;
    }
}
// area_1_threatcat_2_threat
function advisory_generate_cloudVendor_form_questions() 
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
                                    'fields' => [
                                        ['id' => 'name', 'type' => 'text', 'title' => 'Name'],
                                        ['id' => 'desc', 'type' => 'textarea', 'title' => 'Desc'],
                                    ]
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
function advisory_generate_cloudVendor_form_question_helpers() 
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
                        if ( $threats = @$meta[$threatId] ) {
                            foreach ($threats as $threatSi => $threat ) {
                                $questionId = $threatId .'_'.$threatSi.'_question';
                                $data[] = ['type' => 'subheading', 'content' => $threat['name'].' - '.$threatCat['name'].' - '.$area['name']];
                                if ( $questions = @$meta[$questionId] ) {
                                    foreach ($questions as $questionSi => $question ) {
                                        $data[] = array(
                                            'id' => $questionId .'_'.$questionSi.'_helper',
                                            'type' => 'group',
                                            'title' => $question['name'],
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
            }
        }
        return $data;
    }
}
function cloudVendorBackgroundByValue($val, $type='impact', $reverse=false) 
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
function cloudVendor_risk_calc($vulnerability, $impact, $probability) {
	if (!$vulnerability && !$impact && !$probability) return 1;
	if (!$impact) $impact = 1;
	if (!$probability) $probability = 1;
	if (!$vulnerability) $vulnerability = 1;
	$total = $impact * $vulnerability * $probability;
	if ($total < 2) return 1;
	return $total;
}
function cloudVendorRiskBackground(float $value) {
	if ( $value >= 30 )        { $cls = 'bg-red'; } 
	else if ( $value >= 20 )   { $cls = 'bg-orange'; } 
	else if ($value >= 11 )    { $cls = 'bg-yellow'; } 
	else if ($value >= 2 ) 	   { $cls = 'bg-green'; } 
	else                       { $cls = 'bg-blue'; }
	return $cls;
}
function cloudVendorHeatMap($char_arr) 
{
    $data = [];
    $steps = [1,2,6,11,16,20,26,30,36,41];
    foreach ($steps as $stepSI => $step) {
        $chars = [];
        $data[$stepSI]['start'] = $step;
        $data[$stepSI]['end'] = ($step == 41) ? 45 : $steps[$stepSI + 1] - 1;     
        $data[$stepSI]['range'] = $data[$stepSI]['start'] .' - '. $data[$stepSI]['end'];    
        $data[$stepSI]['color'] = cloudVendorRiskBackground($step); 
        for ($i=$data[$stepSI]['start']; $i <= $data[$stepSI]['end']; $i++) { 
            if ( array_key_exists($i, $char_arr) ) $chars[] = $char_arr[$i];
        }   
        $data[$stepSI]['char'] = $chars ? '<div class="score-list-value">(' . implode(', ', $chars) . ')</div>' : '';   
    }
    return $data;
}
function cloudVendor_get_formatted_data($post_id) {
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
                            if ( cloudVendorRegisterDefaultItemName($key) == 'impact' )        { $data[$index]['areas'][$index2]['impact'][] = $value; }
                            if ( cloudVendorRegisterDefaultItemName($key) == 'vulnerability' ) { $data[$index]['areas'][$index2]['vulnerability'][] = $value; }
                            if ( cloudVendorRegisterDefaultItemName($key) == 'threat' )        { $data[$index]['areas'][$index2]['threat'][] = $value; }
                        }
                    }
                }
            }
            $index++;
        }
    }
    return $data;
}
function cloudVendorRegisterDefaultItemName($key)
{
    if ( $key ) {
        $key = explode('_', $key);
        if ( !empty($key[count($key) - 1]) ) {
            return trim($key[count($key) - 1]);
        }
    }
    return false;
}
function cloudVendorHasPermission()
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
function cloudVendorDomains($opts)
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
function cloudVendorAvgColor($avg=0)
{
    if ( $avg >= 30 )      { $color = 'bg-red'; } 
    else if ( $avg >= 20 ) { $color = 'bg-orange'; } 
    else if ($avg >= 11 )  { $color = 'bg-yellow'; } 
    else if ($avg >= 2 )   { $color = 'bg-green'; } 
    else                   { $color = 'bg-blue'; }
    return $color;
}