<?php
function advisory_sfiams_get_notes($default,  $select_attr='disabled') {
	$data = '';
    $data .= '<label for="name"><img src="'.IMAGE_DIR_URL.'sfia/assessment/notes.png" class="levelImg"></label>';
    $data .= '<textarea name="notes" cols="30" rows="8" class="form-control" placeholder="Notes"'.$select_attr.' style="resize:none">'.@$default['notes'].'</textarea>';
	return $data;
}
function advisory_sfiams_get_summary($default, $select_attr='disabled') {
	$data = '';
	$summaryCounter = $recommendationCounter = 0;
	$summaries = !empty($default['summaries']) ? $default['summaries'] : null;
	$recommendations = !empty($default['recommendations']) ? $default['recommendations'] : null;

	// FOR OLDER DATA
	if ( !empty($default['summary']) && empty($summaries) ) $summaries = [$default['summary']] ;
	if ( !empty($default['summary_2']) && empty($recommendations) ) $recommendations = [$default['summary_2']];
	// $data .= '<br><pre>'.print_r($default['summary'], true).'</pre>';
    $data .= '<div class="card">';
		$data .= '<div class="row mt-10">';
			$data .= '<div class="col-sm-10 card-title-w-btn"> <h4 class="title">Summary</h4> </div>';
			$data .= '<div class="col-sm-2 text-right">';
				$data .= '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
			$data .= '</div>';
		$data .= '</div>';
        $data .= '<div class="card-body">';
        	$data .= '<div class="summaryWrapper">';
        		do {
	        		$data .= '<div class="sfiams-summaryContainer">';
		        		$data .= '<textarea name="summaries[]" class="tinymce-editor">'.$summaries[$summaryCounter].'</textarea>';
		        		if (!$select_attr) $data .= '<div class="mt-10 text-right"><button type="button" class="btn btn-danger btn-sm sfiams-summaryRemove" disabled>X</button></div>';
	        		$data .= '</div>';
	        		$summaryCounter++;
        		} while ( !empty($summaries[$summaryCounter]) );
        	$data .= '</div>';
        	if (!$select_attr) $data .= '<div class="mt-10 text-right"><button type="button" class="btn btn-primary btn-sm sfiams-summaryaddMore">Add New</button></div>';
        $data .= '</div>';
		$data .= '<div class="card-title-w-btn" style="margin-top: 20px;"> <h4 class="title">Recommendations</h4> </div>';
        $data .= '<div class="card-body">';
        	$data .= '<div class="recommendationWrapper">';
        		do {
	        		$data .= '<div class="sfiams-recommendationContainer">';
		        		$data .= '<textarea name="recommendations[]" class="tinymce-editor">'.$recommendations[$recommendationCounter].'</textarea>';
		        		if (!$select_attr) $data .= '<div class="mt-10 text-right"><button type="button" class="btn btn-danger btn-sm sfiams-recommendationRemove" disabled>X</button></div>';
	        		$data .= '</div>';
	        		$recommendationCounter++;
        		} while ( !empty($recommendations[$recommendationCounter]) );
        	$data .= '</div>';
        	if (!$select_attr) $data .= '<div class="mt-10 text-right"><button type="button" class="btn btn-primary btn-sm sfiams-recommendationaddMore">Add New</button></div>';
        $data .= '</div>';
		$data .= '<div class="row mt-10">';
			$data .= '<div class="col-sm-12 text-right">';
				$data .= '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
			$data .= '</div>';
		$data .= '</div>';
    $data .= '</div>';
	return $data;
}
function advisory_sfiams_get_skills($post_id, $default, $select_attr='disabled') {
	$data = '';
	if ( !empty($default) ) {
		unset($default['time']);
		unset($default['notes']);
		unset($default['summaries']);
		unset($default['recommendations']);
	}
	$opts = get_post_meta($post_id, 'form_opts', true);
    $opts['display_name'] = !empty($opts['display_name']) ? $opts['display_name'] : get_the_title($post_id);
    $data .= '<div class="card"> <div class="card-body sfia-missing-skills">';
		$data .= '<table class="table-bordered skillWrapper">';
	        $data .= '<thead>';
	            $data .= '<tr class="titleWrapper">';
	                if (!$select_attr) $data .= '<td class="skill_number"> <h3 class="title">No.</h3> </td>';
	                $data .= '<td class="categoryTitle"> <h3 class="title">Category</h3> </td>';
	                $data .= '<td class="sub_categoryTitle"> <h3 class="title">Sub-category</h3> </td>';
	                $data .= '<td class="skillsTitle"> <h3 class="title">Skill</h3> </td>';
	                $data .= '<td class="codeTitle"> <h3 class="title">Code</h3> </td>';
	                $data .= '<td class="targetLevelTitle"> <h3 class="title">Target</h3> </td>';
	                $data .= '<td class="actionTitle"><h3 class="title">Actions</h3></td>';
	            $data .= '</tr>';
	        $data .= '</thead>';
	        $data .= '<tbody id="sortable">';
	        $data .= advisory_sfiams_get_skill_items($opts, 0, $default, $select_attr);
	        $data .= '</tbody>';
	    $data .= '</table>';
	    $data .= '<div class="clearfix"><br></div>';
	    if (!$select_attr) {
	        $data .= '<div class="row">';
	            $data .= '<div class="col-sm-12 text-right buttonWrapper">';
	                $data .= '<button type="button" class="btn btn-primary addMoreSkill"><i class="fa fa-lg fa-plus"></i> add skill</button> &nbsp;';
	                $data .= '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
	            $data .= '</div>';
	        $data .= '</div>';
	    }
    $data .= '</div> </div>';
    return $data;
}
function advisory_sfiams_get_skill_items($opts, $skillCount=0, $default=[], $select_attr='', $ajax_call=false) {
	$html = '';
	$loop = !empty($default) ? count($default) / 4 : 0;
	$deleteAttr = $loop > 1 || !empty($select_attr) || $ajax_call ? '' : 'disabled';
	do {
		$level_opts = [];
		$defaultCatId = !empty($default['category_'.$skillCount]) ? 'sections_'.$default['category_'.$skillCount] : '';
		$defaultCatClass= advisory_get_sfiams_category_class(@$default['category_'.$skillCount]);
		$html .= '<tr id="skillContainer_'.$skillCount.'" class="skillContainer '.$defaultCatClass.'" skillcount='.$skillCount.'>';
	        if (!$select_attr) $html .= '<td class="move">'. ($skillCount + 1) .'</td>';
	        $html .= '<td class="category_container">';
	        	$html .= advisory_generate_sfia_categories($opts, $skillCount, $default, $select_attr);
	        $html .= '</td>';
	        $skillsubCategoryId = !empty($default['subcategory_'.$skillCount]) ? $default['subcategory_'.$skillCount] : '';
	        $subcategoryAttr = empty($skillsubCategoryId) || !empty($select_attr) ? 'disabled' : '';
	        $html .= '<td class="sub_category_container">';
	            $html .= '<select name="subcategory_'.$skillCount.'" id="subcategory_'.$skillCount.'" class="subcategory" '.$subcategoryAttr.'>';
	                $html .= '<option value="0">Sub-Category</option>';
	                if (!empty($opts[$defaultCatId])) {
	                	foreach ($opts[$defaultCatId] as $subcategory) {
							$subcatId = advisory_id_from_string($subcategory['name']);
							$attr = $skillsubCategoryId == $subcatId ? 'selected' : '';
	                		$html .= '<option value="'.$subcatId.'" '.$attr.'>'.$subcategory['name'].'</option>';
	                	}
	                }
	            $html .= '</select>';
	        $html .= '</td>';
	        $skillskillId = !empty($default['skill_'.$skillCount]) ? $default['skill_'.$skillCount] : '';
	        $skillAttr = empty($skillskillId) || !empty($select_attr) ? 'disabled' : '';
	        $skill_opts = !empty($opts[$defaultCatId.'_tables_'.$skillsubCategoryId]) ? $opts[$defaultCatId.'_tables_'.$skillsubCategoryId] : [];
	        
	        $html .= '<td class="skills_container">';
	            $html .= '<select name="skill_'.$skillCount.'" id="skill_'.$skillCount.'" class="skills" '.$skillAttr.'>';
	                $html .= '<option value="0">default</option>';
	                if (!empty($skill_opts)) {
	                	foreach ($skill_opts as $skill) {
							$skillId = advisory_id_from_string($skill['name']);
							if ($skillskillId == $skillId) { 
								$level_opts = advisory_select_array($skill['levels']);
								$attr = 'selected';
								$code = $skill['code'];
							} else { $attr = ''; }
	                		$html .= '<option value="'.$skillId.'" code="'.$skill['code'].'" '.$attr.'>'.$skill['name'].'</option>';
	                	}
	                }
	            $html .= '</select>';
	        $html .= '</td>';
	        $html .= '<td class="code_container">';
	            $html .= '<div id="code_'.$skillCount.'" class="text-center code">'.$code.'</div>';
	        $html .= '</td>';

	        
	        $default_assess_level = isset($default['assess_level_'.$skillCount]) ? $default['assess_level_'.$skillCount] : '';
	        $default_target_level = isset($default['target_level_'.$skillCount]) ? $default['target_level_'.$skillCount] : '';

	        $html .= '<td class="target_level_container">';
	            $html .= '<select name="target_level_'.$skillCount.'" id="target_level_'.$skillCount.'" class="target_level" style="text-align-last: center;" '.$skillAttr.'>';
	                $html .= '<option value="">Target</option>';
	                if (!empty($level_opts)) {
	                	foreach ($level_opts as $levelId => $level) {
	                		$selectedLevel = $default_target_level == $levelId ? 'selected' : '';
	                		$html .= '<option value="'.$levelId.'" '.$selectedLevel.'>'.$level.'</option>';
	                	}
	                }
	            $html .= '</select>';
	        $html .= '</td>';
	        
	        // $infoImgLink = IMAGE_DIR_URL .'sfia/info/'.$skillskillId.'.png';
	        $infoImgLink = IMAGE_DIR_URL .'sfia/info/';
	        if ($code) {
		        $infoImgLink .= $code.'.pdf';
		        $SFIARemoveBtnAttr = '';
	        } else {
	        	$infoImgLink .= '';
		        $SFIARemoveBtnAttr = 'disabled';
	        }
	        $html .= '<td class="text-center actions_container">';
	        // $html .= '<span class="SFIALevelInfoBtn"><i class="fa fa-info-circle" aria-hidden="true"></i></span>';
	        $html .= '<button class="btn btn-primary SFIAInfoBtn" type="button" title="Information" data-skill="'.$infoImgLink.'" '.$SFIARemoveBtnAttr.'><span class="fa fa-info-circle"></span></button> ';
	        if (!$select_attr) $html .= '<button class="btn btn-danger SFIARemoveBtn" type="button" title="Delete row" '.$deleteAttr.'><span class="fa fa-trash"></span></button> ';
	        $html .= '</td>';
	    $html .= '</tr>';
	    $skillCount++;
	} while ( $skillCount < $loop);
    return $html;
}
add_action('wp_ajax_sfiams_add_new_skill', 'sfiams_add_new_skill');
function sfiams_add_new_skill() {
	$html = '';
	$post_id = !empty($_POST['post_id']) ? $_POST['post_id'] : false;
	$counter = !empty($_POST['counter']) ? $_POST['counter'] : false;
	if ($post_id && $counter) {
		$opts = get_post_meta($post_id, 'form_opts', true);
		$html .= advisory_sfiams_get_skill_items($opts, $counter, [], '', true);
	}
	echo $html; wp_die();
}
function advisory_get_sfiams_category_class($value) {
	$cls = '';
	switch ($value) {
		case 'strategy_and_architecture': 		$cls = 'bg-light-red'; 		break;
		case 'change_and_transformation': 		$cls = 'bg-light-pink'; 	break;
		case 'development_and_implementation': 	$cls = 'bg-light-orange'; 	break;
		case 'delivery_and_operation': 			$cls = 'bg-light-yellow'; 	break;
		case 'skills_and_quality': 				$cls = 'bg-light-blue'; 	break;
		case 'relationships_and_engagement': 	$cls = 'bg-light-green'; 	break;
		default: 								$cls = ''; 					break;
	}
	return $cls;
}
function advisory_sfiams_dashboard_scorecard() {
	$html = '';
	$skills = advisory_sfiams_dashboard_scorecard_skills();
	if ( !empty($skills) ) {
		$html .= '<a href="'. site_url('pdf') .'?pid=sfia_missing_skills" target="_blank" style="position: absolute;right: 14px;top: 39px;margin: 0 13px 0 0;"><img src="'.P3_TEMPLATE_URI.'/images/pdf/power.png" style="height:25px;"></a>';
		// $html .= '<a href="javascript:;" style="position: absolute;right: 14px;top: 39px;margin: 0 13px 0 0;"><img src="'.P3_TEMPLATE_URI.'/images/pdf/power.png" style="height:25px;"></a>';
		$html .= '<div class="text-center"><img src="'.IMAGE_DIR_URL.'sfia/dashboard/sfiams.png" class="img-responsive" style="margin: 16px auto 0px auto; width: 80%;"> </div> <br>';
		$html .= '<div class="table-responsive">';
			$html .= '<table class="table table-bordered m-1">';
				$html .= '<tbody>';
					foreach ($skills as $category_key => $category) {
						foreach ($category as $subcategory_key => $subcategory) {
							$html .= '<tr><th class="t-heading-dark h4" colspan="3"> '. advisory_string_from_id($category_key) .' - '. advisory_string_from_id($subcategory_key) .'</th></tr>';

							$html .= '<tr>';
								$html .= '<th class="t-heading-sky" style="width:68%">REQUIRED SKILL</th>';
								$html .= '<th class="t-heading-sky" style="width:5%">CODE</th>';
								$html .= '<th class="t-heading-sky" style="width:12%">TARGET</th>';
							$html .= '</tr>';
							foreach ($subcategory as $skill) {
								$html .= '<tr>';
									$html .= '<th class="'.$skill['class'].'">'.$skill['name'].'</th>';
									$html .= '<th class="'.$skill['class'].'">'.$skill['code'].'</th>';
									$html .= '<th class="bg-deepgreen"> Level '.$skill['target'].'</th>';
								$html .= '</tr>';
							}
						}
					}
				$html .= '<tbody>';
			$html .= '</table>';
		$html .= '</div>';
	}
	return $html;
}
function advisory_sfiams_dashboard_scorecard_skills($user_company_id=null) {
	$skills = [];
	if ( !$user_company_id ) $user_company_id = advisory_get_user_company_id();
	$post_id = advisory_sfia_get_active_post_id($user_company_id);
	$opts = get_post_meta($post_id, 'form_opts', true);
	$default = advisory_form_default_values($post_id, 'missing_skills');

	if ( !empty($default) ) { unset($default['time']); unset($default['notes']); unset($default['summaries']); unset($default['recommendations']); }
	$loop = !empty($default) ? count($default) / 4 : 0;

	for ($counter=0; $counter < $loop; $counter++) { 
		$code = advisory_sfia_dashboard_scorecard_get_skill_colde($opts, $default, $counter);
		$class = advisory_get_sfiar_category_class($default['category_'. $counter]);
		$table = 'sections_'.$default['category_'.$counter].'_tables_'.$default['subcategory_'.$counter];
		$skill_name = advisory_sfia_skill_name_from_id($opts[$table], $default['skill_'.$counter]);

		$skills[ $default['category_'.$counter] ][ $default['subcategory_'.$counter] ][$counter] = [
			'name' => $skill_name,
			'class' => $class,
			'code' => $code,
			'target' => $default['target_level_'.$counter],
		];
	}
	return $skills;
}
function advisory_sfiams_pdf_skills($opts, $default=null) {
	$skills = [];
	$loop = !empty($default) ? count($default) / 4 : 0;

	for ($counter=0; $counter < $loop; $counter++) { 
		$code 		= advisory_sfia_dashboard_scorecard_get_skill_colde($opts, $default, $counter);
		$class 		= advisory_get_sfiar_category_class($default['category_'. $counter]);

		$cat_name 	= advisory_sfia_name_from_id($opts['areas'], $default['category_'.$counter]);
		$section_id = 'sections_'.$default['category_'.$counter];
		$sub_cat 	= advisory_sfia_name_from_id($opts[$section_id], $default['subcategory_'.$counter]);
		$table_id 	= $section_id.'_tables_'.$default['subcategory_'.$counter];
		$skill_name = advisory_sfia_name_from_id($opts[$table_id], $default['skill_'.$counter]);

		$skills[$counter] = [
			'cat' 		=> $cat_name,
			'subcat' 	=> $sub_cat,
			'name' 		=> $skill_name,
			'class' 	=> $class,
			'code' 		=> $code,
			'target' 	=> $default['target_level_'.$counter],
		];
	}
	return $skills;
}