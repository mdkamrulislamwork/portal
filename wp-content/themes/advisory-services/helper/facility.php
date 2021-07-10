<?php
function advisory_generate_facility_form_threats() 
{
	if (is_admin() && is_edit_page()) {
		$id = @$_GET['post'];
		// update_post_meta($id, 'form_opts', facility_example_data());
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
// area_1_threatcat_2_threat
function advisory_generate_facility_form_statements() 
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
function advisory_generate_facility_form_questions() 
{
	if (is_admin() && is_edit_page()) {
		$id = @$_GET['post'];
		$meta = get_post_meta($id, 'form_opts', true);
		$data = [];
		// help($meta);
		$data[] = ['type' => 'notice', 'class' => 'danger', 'content' => 'Create Facilities and save. Then create Threat cats, Statements and Questions'];
		if ( !empty($meta['areas']) ) {
			foreach ( $meta['areas'] as $areaSi => $area ) {
				$threatCatId = 'area_'.$areaSi . '_threatcat';
				$data[] = ['type' => 'subheading', 'content' => $area['name']];
				if ( $threatsCats = @$meta[$threatCatId] ) {
					foreach ( $threatsCats as $threatCatSi => $threatCat ) {
						$threatId = $threatCatId.'_'.$threatCatSi.'_threat';
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
function facilityBackgroundByValue($val, $type='impact', $reverse=false) 
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
function facility_risk_calc($vulnerability, $impact, $probability) {
	if (!$vulnerability && !$impact && !$probability) return 1;
	if (!$impact) $impact = 1;
	if (!$probability) $probability = 1;
	if (!$vulnerability) $vulnerability = 1;
	$total = $impact * $vulnerability * $probability;
	if ($total < 2) return 1;
	return $total;
}
function facilityRiskBackground(float $value) {
	if ( $value >= 30 )        { $cls = 'bg-red'; } 
	else if ( $value >= 20 )   { $cls = 'bg-orange'; } 
	else if ($value >= 11 )    { $cls = 'bg-yellow'; } 
	else if ($value >= 2 ) 	   { $cls = 'bg-green'; } 
	else                       { $cls = 'bg-blue'; }
	return $cls;
}
function facilityHeatMap($char_arr) 
{
    $data = [];
    $steps = [1,2,6,11,16,20,26,30,36,41];
    foreach ($steps as $stepSI => $step) {
        $chars = [];
        $data[$stepSI]['start'] = $step;
        $data[$stepSI]['end'] = ($step == 41) ? 45 : $steps[$stepSI + 1] - 1;     
        $data[$stepSI]['range'] = $data[$stepSI]['start'] .' - '. $data[$stepSI]['end'];    
        $data[$stepSI]['color'] = facilityRiskBackground($step); 
        for ($i=$data[$stepSI]['start']; $i <= $data[$stepSI]['end']; $i++) { 
            if ( array_key_exists($i, $char_arr) ) $chars[] = $char_arr[$i];
        }   
        $data[$stepSI]['char'] = $chars ? '<div class="score-list-value">(' . implode(', ', $chars) . ')</div>' : '';   
    }
    return $data;
}
function advisory_get_formatted_frr_data($post_id) {
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
                            if ( facilityRegisterDefaultItemName($key) == 'impact' )        { $data[$index]['areas'][$index2]['impact'][] = $value; }
                            if ( facilityRegisterDefaultItemName($key) == 'vulnerability' ) { $data[$index]['areas'][$index2]['vulnerability'][] = $value; }
                            if ( facilityRegisterDefaultItemName($key) == 'threat' )        { $data[$index]['areas'][$index2]['threat'][] = $value; }
                        }
                    }
                }
            }
            $index++;
        }
    }
    return $data;
}
function facilityRegisterDefaultItemName($key)
{
    if ( $key ) {
        $key = explode('_', $key);
        if ( !empty($key[count($key) - 1]) ) {
            return trim($key[count($key) - 1]);
        }
    }
    return false;
}

function facilityInputController()
{
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