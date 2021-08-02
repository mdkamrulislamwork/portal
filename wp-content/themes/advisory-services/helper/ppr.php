<?php
function ppr_form_threatcats()
{
	if (is_admin() && is_edit_page()) {
		$id = @$_GET['post'];
		$meta = get_post_meta($id, 'form_opts', true);
        // help($meta);
		$data = [];
		$data[] = ['type' => 'notice', 'class' => 'danger', 'content' => 'Create Domains and save.',];
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
function ppr_form_statements()
{
	if (is_admin() && is_edit_page()) {
		$id = @$_GET['post'];
		$meta = get_post_meta($id, 'form_opts', true);
		$data = [];
		$data[] = ['type' => 'notice', 'class' => 'danger', 'content' => 'Create Questions and save.'];
		if ( !empty($meta['areas']) ) {
			foreach ( $meta['areas'] as $areaSi => $area ) {
				$data[] = ['type' => 'subheading', 'content' => $area['name']];
				$threatCatId = 'area_'.$areaSi . '_threatcat';
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
                                    ['id' => 'value', 'type' => 'text', 'title' => 'Value']
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

function pprBackgroundByValue($val, $type='impact', $reverse=false)
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
function ppr_risk_calc($vulnerability, $impact, $probability) {
	if (!$vulnerability && !$impact && !$probability) return 1;
	if (!$impact) $impact = 1;
	if (!$probability) $probability = 1;
	if (!$vulnerability) $vulnerability = 1;
	$total = $impact * $vulnerability * $probability;
	if ($total < 2) return 1;
	return $total;
}
function pprRiskBackground(float $value) {
	if ( $value >= 30 )        { $cls = 'bg-red'; }
	else if ( $value >= 20 )   { $cls = 'bg-orange'; }
	else if ($value >= 11 )    { $cls = 'bg-yellow'; }
	else if ($value >= 2 ) 	   { $cls = 'bg-green'; }
	else                       { $cls = 'bg-blue'; }
	return $cls;
}
function pprHeatMap($char_arr)
{
    $data = [];
    $steps = [1,2,6,11,16,20,26,30,36,41];
    foreach ($steps as $stepSI => $step) {
        $chars = [];
        $data[$stepSI]['start'] = $step;
        $data[$stepSI]['end'] = ($step == 41) ? 45 : $steps[$stepSI + 1] - 1;
        $data[$stepSI]['range'] = $data[$stepSI]['start'] .' - '. $data[$stepSI]['end'];
        $data[$stepSI]['color'] = pprRiskBackground($step);
        for ($i=$data[$stepSI]['start']; $i <= $data[$stepSI]['end']; $i++) {
            if ( array_key_exists($i, $char_arr) ) $chars[] = $char_arr[$i];
        }
        $data[$stepSI]['char'] = $chars ? '<div class="score-list-value">(' . implode(', ', $chars) . ')</div>' : '';
    }
    return $data;
}
function ppr_get_formatted_data($post_id) {
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
                            if ( pprRegisterDefaultItemName($key) == 'impact' )        { $data[$index]['areas'][$index2]['impact'][] = $value; }
                            if ( pprRegisterDefaultItemName($key) == 'vulnerability' ) { $data[$index]['areas'][$index2]['vulnerability'][] = $value; }
                            if ( pprRegisterDefaultItemName($key) == 'threat' )        { $data[$index]['areas'][$index2]['threat'][] = $value; }
                        }
                    }
                }
            }
            $index++;
        }
    }
    return $data;
}
function pprRegisterDefaultItemName($key)
{
    if ( $key ) {
        $key = explode('_', $key);
        if ( !empty($key[count($key) - 1]) ) {
            return trim($key[count($key) - 1]);
        }
    }
    return false;
}
function pprHasPermission()
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
function pprDomains($opts)
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

function pprDomainMap($opts)
{
    $str = null;
    $areaId = !empty($_GET['area']) ? $_GET['area'] : 1;
    if ( !empty($opts['areas']) ) {
        global $post;
        $defaultItem = ['name'=>null, 'link' => null];
        $data = [];
        $postLink = site_url('ppr/'. $post->ID).'/?area=';
        $data[1] = !empty($opts['areas'][1]['name']) ? ['name' => $opts['areas'][1]['name'], 'link' => $postLink.'1'] : $defaultItem;
        $data[2] = !empty($opts['areas'][2]['name']) ? ['name' => $opts['areas'][2]['name'], 'link' => $postLink.'2'] : $defaultItem;
        $data[3] = !empty($opts['areas'][3]['name']) ? ['name' => $opts['areas'][3]['name'], 'link' => $postLink.'3'] : $defaultItem;
        $data[4] = !empty($opts['areas'][4]['name']) ? ['name' => $opts['areas'][4]['name'], 'link' => $postLink.'4'] : $defaultItem;
        $str .='<img src="'. IMAGE_DIR_URL .'ppr/banner-left2.jpg" class="img-responsive text-center" usemap="#image-map" hidefocus="true" />';
        $str .='<map name="image-map">';
            $str .='<area title="'.$data[1]['name'].'" href="'.$data[1]['link'].'" coords="1110,489,1117,507,1135,503,1149,491,1165,480,1186,470,1204,470,1222,474,1241,493,1253,513,1263,539,1261,564,1253,588,1241,605,1220,621,1202,627,1176,623,1157,611,1137,594,1123,586,1115,597,1112,1099,602,1101,593,1093,599,1081,620,1065,632,1046,638,1016,636,998,628,981,616,967,595,953,573,947,540,945,512,959,486,979,475,1008,479,1040,490,1061,510,1077,516,1089,510,1101,-1,1097,3,969,-1,263,-1,4,1108,0" shape="poly">';
            $str .='<area title="'.$data[2]['name'].'" href="'.$data[2]['link'].'" coords="1113,2,2222,2,2224,1099,1713,1101,1705,1110,1717,1132,1740,1165,1740,1197,1731,1224,1697,1246,1664,1250,1625,1244,1591,1211,1589,1175,1607,1148,1623,1124,1630,1112,1625,1099,1113,1099,1115,597,1127,590,1139,603,1155,619,1172,627,1196,633,1218,625,1241,609,1259,588,1267,570,1271,544,1267,521,1253,495,1231,476,1206,464,1178,468,1161,474,1137,493,1115,487" shape="poly">';
            $str .='<area title="'.$data[3]['name'].'" href="'.$data[3]['link'].'" coords="1115,2205,1113,1694,1100,1690,1080,1704,1066,1722,1045,1726,1021,1726,1001,1718,982,1700,970,1680,966,1659,968,1637,978,1612,994,1592,1007,1578,1031,1572,1053,1578,1070,1594,1090,1604,1108,1616,1115,1103,1619,1103,1630,1108,1626,1122,1613,1130,1595,1152,1585,1175,1583,1197,1595,1219,1607,1230,1619,1240,1630,1248,1658,1254,1685,1250,1709,1242,1733,1224,1742,1207,1746,1185,1748,1167,1735,1144,1727,1130,1711,1112,2216,1103,2220,2205" shape="poly">';
            $str .='<area title="'.$data[4]['name'].'" href="'.$data[4]['link'].'" coords="-1,2205,1,1103,510,1105,522,1093,510,1071,494,1053,481,1036,481,1012,488,996,494,981,506,971,520,963,543,953,567,953,591,959,606,967,624,981,634,1012,628,1042,614,1061,602,1071,593,1089,602,1103,1108,1105,1112,1610,1102,1612,1088,1602,1076,1586,1058,1574,1037,1568,1019,1570,999,1580,982,1598,966,1627,964,1653,964,1674,972,1698,988,1712,1005,1731,1023,1733,1047,1733,1076,1722,1094,1700,1110,1694,1112,2203" shape="poly">';
        $str .='</map>';
    }
    return $str;
}
function pprDomainMap2($opts)
{
    $str = null;
    if ( !empty($opts['areas']) ) {
        global $post;
        $defaultItem = ['name'=>null, 'link' => null];
        $data = [];
        $postLink = site_url('ppr/'. $post->ID).'/?area=';
        foreach ( $opts['areas'] as $areaSi => $value) {
            if ( empty($opts['areas'][$areaSi]['name']) ) $data[$areaSi] = $defaultItem;
            else {
                $data[$areaSi] = [
                    'name' => $opts['areas'][$areaSi]['name'],
                    'link' => $postLink.$areaSi,
                    'color' => pprCategoryColor($areaSi),
                    'image' => IMAGE_DIR_URL.'ppr/icon-'. $areaSi .'.png',
                    'desc' => $opts['areas'][$areaSi]['desc'],
                ];
            }
        }
        $str .= '<div class="cloud-main-thum">';
            $str .= '<div class="item bg-purple text-center">';
                $str .= '<a href="organizational-readiness.html">';
                    $str .= '<h3 class="text-white">Organizational Readiness</h3>';
                    $str .= '<div class="cloud-main-icon text-center">';
                        $str .= '<img src="assets/media/icons/or.png" alt="">';
                    $str .= '</div>';
                $str .= '</a>';
                $str .= '<div class="cloud-thum-icon one">';
                    $str .= '<div class="ribbon-shape purple"></div>';
                $str .= '</div>';
            $str .= '</div>';
            $str .= '<div class="item bg-orange text-center">';
                $str .= '<a href="technology-readiness.html">';
                    $str .= '<h3 class="text-white">Technology Readiness</h3>';
                    $str .= '<div class="cloud-main-icon text-center">';
                        $str .= '<img src="assets/media/icons/tr.png" alt="">';
                    $str .= '</div>';
                $str .= '</a>';
                $str .= '<div class="cloud-thum-icon two">';
                    $str .= '<div class="ribbon-shape orange"></div>';
                $str .= '</div>';
            $str .= '</div>';
            $str .= '<div class="item bg-olive text-center">';
                $str .= '<a href="recovery-planning.html">';
                    $str .= '<h3 class="text-white">Recovery Planning</h3>';
                    $str .= '<div class="cloud-main-icon text-center">';
                        $str .= '<img src="assets/media/icons/rp.png" alt="">';
                    $str .= '</div>';
                $str .= '</a>';
                $str .= '<div class="cloud-thum-icon three">';
                    $str .= '<div class="ribbon-shape olive"></div>';
                $str .= '</div>';
            $str .= '</div>';
            $str .= '<div class="item bg-blue text-center">';
                $str .= '<a href="maintenance-improvement.html">';
                    $str .= '<h3 class="text-white">Maintenance &amp; Continuous Improvement</h3>';
                    $str .= '<div class="cloud-main-icon text-center">';
                        $str .= '<img src="assets/media/icons/mci.png" alt="">';
                    $str .= '</div>';
                $str .= '</a>';
                $str .= '<div class="cloud-thum-icon four">';
                    $str .= '<div class="ribbon-shape blue"></div>';
                $str .= '</div>';
            $str .= '</div>';
        $str .= '</div>';
    }
    return $str;
}
function pprDomainCMMBackground($itemSi=0, $value=null)
{
    if ( $itemSi == 5 ) return $value ? 'bg-deepblue' : 'bg-blue';
    if ( $itemSi == 4 ) return $value ? 'bg-deepgreen' : 'bg-light-green';
    if ( $itemSi == 3 ) return $value ? 'bg-deepyellow' : 'bg-light-yellow';
    if ( $itemSi == 2 ) return $value ? 'bg-orange' : 'bg-light-orange';
    if ( $itemSi == 1 ) return $value ? 'bg-red' : 'bg-light-red';
    else               return $value ? 'bg-black' : 'bg-light-black';
}
function pprCategoryColor($categorySi=0)
{
    if ($categorySi > 3)        return 'red';
    else if ($categorySi > 2)   return 'purple';
    else if ($categorySi > 1)   return 'orange';
    else                        return 'deepblue';
}
function pprAvgBackground($avg)
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
function pprInputController()
{
    global $user_switching;
    $data = [
        'publish_btn'   => false,
        'select_attr'   => 'disabled',
        'prefix'        => '',
        'disabled'      => 'disabled',
        'question'      => false,
        'comment'       => false,
    ];
    $userId         = get_current_user_id();
    $oldUser        = $user_switching->get_old_user();
    $superUser      = get_the_author_meta( 'spuser', $userId);
    $specialUser    = get_the_author_meta( 'specialppruser', $userId);

    if ( empty($oldUser) && ( $superUser || $specialUser ) ) {
        $_GET['edit'] = true;
        $_GET['view'] = false;
    }

    if (isset($_GET['view']) && $_GET['view'] == 'true') {
        $data['publish_btn'] = true;
    } elseif (isset($_GET['edit']) && $_GET['edit'] == 'true') {
        $data['select_attr'] = '';
        $data['question'] = true;
        $data['comment'] = true;
    } else {
        $data['select_attr'] = '';
        $data['publish_btn'] = true;
        $data['question'] = true;
        $data['comment'] = true;
    }
    return $data;
}
function pprInformationModal()
{
    $str = null;
    $str .= '<div id="cmmInfoModal" class="modal fade">';
        $str .= '<div class="modal-dialog modal-lg">';
            $str .= '<div class="modal-content modal-inverse">';
                $str .= '<div class="modal-header">';
                    $str .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
                    $str .= '<h4 class="modal-title">Information</h4>';
                $str .= '</div>';
                $str .= '<div class="modal-body" style="color: #000;font-weight: 500;"></div>';
                $str .= '<div class="modal-footer">';
                        $str .= '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                $str .= '</div>';
            $str .= '</div>';
        $str .= '</div>';
    $str .= '</div>';
    return $str;
}
function pprCmmModal()
{
    $str = null;
    $str .= '<div id="modal-ppr" class="modal fade">';
        $str .= '<div class="modal-dialog">';
            $str .= '<div class="modal-content modal-inverse">';
                $str .= '<div class="modal-header">';
                    $str .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
                    $str .= '<h4 class="modal-title">Select options</h4>';
                $str .= '</div>';
                $str .= '<div class="modal-body" style="color: #000;font-weight: 500;"></div>';
                $str .= '<div class="row modal-footer">';
                    $str .= '<div class="col-sm-6 text-left"><label> <input style="float: left;width: 20px;" type="checkbox" id="areaSelect"> Select this area </label></div>';
                    $str .= '<div class="col-sm-6">';
                        $str .= '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                        $str .= '<button type="button" class="btn btn-primary btn-save">Save changes</button>';
                    $str .= '</div>';
                $str .= '</div>';
            $str .= '</div>';
        $str .= '</div>';
    $str .= '</div>';
    return $str;
}
function pprSummaryModal()
{
    $str = null;
    $str .= '<div id="pprSummaryModal" class="modal fade">';
        $str .= '<div class="modal-dialog modal-llg">';
            $str .= '<div class="modal-content modal-inverse">';
                $str .= '<div class="modal-header">';
                    $str .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
                    $str .= '<h4 class="modal-title">Summary</h4>';
                $str .= '</div>';
                $str .= '<div class="modal-body" style="color: #000;font-weight: 500;"></div>';
                $str .= '<div class="modal-footer">';
                        $str .= '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                $str .= '</div>';
            $str .= '</div>';
        $str .= '</div>';
    $str .= '</div>';
    return $str;
}