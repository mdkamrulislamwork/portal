<?php
get_header();
global $user_switching;
$volnerabilityOptions = $threatOptions = ['1'=>'LOW', '2'=>'MED', '3'=>'HIGH'];
$impactOptions = ['1'=>'VERY LOW', '2'=>'LOW', '3'=>'MODERATE', '4'=>'HIGH', '5'=>'VERY HIGH'];
$transient_post_id = get_the_ID();
$areaId = !empty($_GET['area']) ? $_GET['area'] : 1;
$domainId = !empty($_GET['domain']) ? $_GET['domain'] : 1;

$opts = get_post_meta($transient_post_id, 'form_opts', true);
$area_meta = !empty($opts['areas'][$areaId]) ? $opts['areas'][$areaId] : null;
$domains = cloudVendorDomains($opts);
if (isset($_GET['edit']) && $_GET['edit'] == 'true') {
    $publish_btn = false;
    $prefix = 'edit=true&';
    $disabled = '';
    $select_attr = '';
} else if (get_the_author_meta( 'spuser', get_current_user_id()) && empty($user_switching->get_old_user())) {
    $_GET['edit'] = true;
    $_GET['view'] = false;
    $prefix = 'edit=true&';
    $publish_btn = true;
    $disabled = '';
    $select_attr = '';
} else if (get_the_author_meta( 'specialriskuser', get_current_user_id()) && empty($user_switching->get_old_user()) && ('archived' == get_post_status($transient_post_id))) {
    $_GET['edit'] = true;
    $_GET['view'] = false;
    $prefix = 'view=true&';
    $publish_btn = false;
    $disabled = 'disabled';
    $select_attr = 'disabled';
} else if (get_the_author_meta( 'specialriskuser', get_current_user_id()) && empty($user_switching->get_old_user())) {
    $_GET['edit'] = true;
    $_GET['view'] = false;
    $prefix = 'view=true&';
    $publish_btn = false;
    $disabled = '';
    $select_attr = 'disabled';
} else if (isset($_GET['view']) && $_GET['view'] == 'true') {
    $publish_btn = false;
    $prefix = 'view=true&';
    $disabled = 'disabled';
    $select_attr = 'disabled';
} else {
    $publish_btn = true;
    $prefix = '';
    $disabled = '';
    $select_attr = '';
}
$acCls = '';
$vulCls = '';
if ($disabled == '') {
    $acCls = 'assetsImpactedBtn ';
    $vulCls = 'vulnerabilityBtn ';
}
$excerptLength = 10;
$summaryLength = 60;
$questionOptions = ['Yes', 'No', 'Partial', 'Unsure', 'N/A'];
?>
<script src="<?php echo P3_TEMPLATE_URI. '/js/plugins/jquery.tinymce.min.js'; ?>"></script>
<div class="content-wrapper">
    <div class="page-title">
        <div> <h1><?php echo (!empty($area_meta['icon_title']) ? '<img src="' . $area_meta['icon_title'] . '"> ' : '') ?><?php echo $area_meta['name'] ?> <img class="pdfIcon" src="<?php echo get_template_directory_uri(); ?>/images/icon-pdf.png" alt=""> <a href="javascript:;" class="informationIcon"><i class="fa fa-info"></i></a></h1> </div>
        <?php if ($disabled == '') {
            echo '<div>';
                if($publish_btn == true) {
                    if (advisory_is_valid_form_submission($transient_post_id)) echo '<a class="btn btn-lg btn-info btn-publish is-bia" href="#" data-id="' . $transient_post_id . '">Publish</a>';
                    else echo '<a class="btn btn-lg btn-default btn-publish is-bia" href="#" data-id="' . $transient_post_id . '">Publish</a>';
                }
                echo '<a class="btn btn-lg btn-success btn-save-all" href="#">Save All</a>';
                if ($publish_btn == true) echo '<a class="btn btn-lg btn-warning btn-reset-all" href="#">Reset</a>';
            echo '</div>';
        } ?>
        <div>
            <ul class="breadcrumb">
                <li><i class="fa fa-home fa-lg"></i></li>
                <li><a href="#"><?php echo advisory_get_form_name($transient_post_id) ?></a></li>
                <?php if ($select_attr == 'disabled') {
                    if ($opts['areas']) {
                        $link = site_url('facility/'. $post->ID .'/?view=true&area=');
                        echo '<li class="locationSelect"><a><select id="itsmLocations">';
                        foreach($opts['areas'] as $area) {
                            $name = strtolower(str_replace(' ', '_', trim($area['name'])));
                            $selected = @$areaId == $name ? ' selected' : '';
                            $url = $link . $name;
                            echo '<option value="'. $url .'"'. $selected .'>'. $area['name'] .'</option>';
                        }
                        echo '</select></a></li>';
                    }
                } else {
                    echo '<li><a href="#">'. $area_meta['name']. $post->ID .'</a></li>';
                } ?>
            </ul>
        </div>
    </div>
    <?php 
    
    echo '<div class="card"> ';
        echo '<div class="card-body"> ';
            echo '<div class="row">';
                echo '<div class="col-sm-4">';
                    echo '<img src="'.IMAGE_DIR_URL.'cloud-vendor/governences.png" usemap="#image-map">';
                    echo '<map name="image-map">';
                        echo '<area href="'.$domains[1].'" coords="503,452,459,411,426,389,201,163,234,134,269,108,303,87,333,71,357,58,388,44,424,30,467,16,509,9,551,2,599,1,640,2,683,2,729,8,787,22,840,39,891,61,942,90,981,115,1017,144,1041,163,816,388,782,411,737,451,693,430,648,417,594,415,548,429" shape="poly">';
                        echo '<area href="'.$domains[2].'" coords="787,503,800,523,810,546,817,572,822,596,823,622,822,650,818,674,808,698,799,716,788,736,831,779,852,816,1076,1039,1112,1001,1142,958,1169,910,1195,856,1216,799,1230,736,1239,674,1241,621,1239,567,1229,494,1217,450,1196,387,1170,331,1147,289,1115,244,1078,200,854,425,832,459" shape="poly">';
                        echo '<area href="'.$domains[3].'" coords="201,1076,425,851,459,829,503,786,520,794,532,803,545,808,561,813,578,817,592,818,613,821,637,822,663,817,685,813,703,805,724,794,738,784,778,825,783,831,815,850,1040,1075,1020,1093,1001,1109,980,1127,959,1140,934,1155,908,1171,883,1183,864,1193,842,1201,818,1210,791,1218,758,1227,722,1231,690,1237,650,1241,589,1240,545,1235,511,1232,465,1222,404,1201,329,1170,267,1131" shape="poly">';
                        echo '<area href="'.$domains[4].'" coords="165,1040,390,815,409,782,454,736,442,716,432,698,424,676,417,650,415,631,415,612,416,594,420,577,425,557,433,539,444,516,455,503,411,459,390,425,165,200,136,232,105,273,82,311,57,360,32,424,13,498,1,580,2,657,14,747,39,837,80,925,112,978" shape="poly">';
                        echo '<area href="'.$domains[5].'" coords="457,736,435,697,424,660,421,622,421,595,427,568,439,532,456,505,475,483,496,464,514,450,539,438,559,430,582,424,611,420,639,419,663,422,683,429,706,439,727,451,750,467,771,487,792,515,806,545,817,583,821,630,814,673,804,701,787,734,766,759,738,782,707,801,678,813,661,815,639,821,611,818,583,815,551,808,517,791,487,769" shape="poly">';
                    echo '</map>';
                echo '</div>';
                echo '<div class="col-sm-8"><img src="'.IMAGE_DIR_URL.'cloud-vendor/banner-right.jpg" style="margin-top:50px"></div>';
            echo '</div>';
        echo '</div> ';
    echo '</div>';

    if ( !empty($areaId) && !empty($opts['areas']) ) {
        $threatCatId = 'area_'.$areaId . '_threatcat';
        if ( !empty($opts[$threatCatId][$domainId]) ) {
            $threatCat = $opts[$threatCatId][$domainId];
            $threatId = $threatCatId.'_'.$domainId.'_threat';
            if ( !empty($opts[$threatId]) ) {
                foreach ($opts[$threatId] as $threatSi => $threat) {
                    $questionId = $threatId .'_'.$threatSi.'_question';
                    if ( !empty($opts[$questionId]) ) {
                        $count = 1;
                        $default = advisory_form_default_values($transient_post_id, $questionId);
                        $ac  = !empty($default['ac']) ? ['value' => $default['ac'], 'cls'=>'active'] : ['value' => '', 'cls'=>''];
                        $vc  = !empty($default['vc']) ? ['value' => $default['vc'], 'cls'=>'active'] : ['value' => '', 'cls'=>''];
                        $PUCSummary = !empty($default['summary']) ? $default['summary'] : '';
                        $PUCHistoricalEvidence = !empty($default['historical_evidence']) ? $default['historical_evidence'] : '';
                        echo '<form class="form survey-form bia-bcp" method="post" data-meta="'. $questionId .'" data-id="'. $transient_post_id .'">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-title-w-btn">
                                            <h4 class="title"></h4>';
                                            if ($disabled == '') echo '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                        echo '</div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="avgContainer bg-green text-center font-120p">
                                                        <strong>Total Risk Level</strong> - 
                                                        <span class="avg-text"><strong>Avg: <span></span></strong></span>
                                                    </div>
                                                </div>
                                                <br><br>
                                            </div>';
                                            echo '<div class="table-responsive table-bcp-wrapper">';
                                                echo '<table class="table table-bordered table-survey mb-0">';
                                                    echo '<tr>';
                                                        echo '<td style="border-color:transparent;padding:0;width: 700px;"><img src="'.IMAGE_DIR_URL.'cloud-vendor/icon-'.$domainId.'.png"></td>';
                                                        echo '<td style="border-color:transparent; width:100px;">&nbsp;</td>';
                                                        echo '<td class="bigComment" isactive="'.$select_attr.'" style="border-color:transparent; width:100px;">';
                                                            echo '<img src="'. IMAGE_DIR_URL .'bcp/summary.png" class="img-responsive clickableIcon" alt="Summary" title="Summary">';
                                                                echo '<textarea class="hidden commentText" name="summary" excerpt_length='.$summaryLength.'>'. htmlentities($PUCSummary).'</textarea>';
                                                        echo '</td>';
                                                        echo '<td class="bigComment" isactive="'.$select_attr.'" style="border-color:transparent; width:100px;">';
                                                            echo '<img src="'. IMAGE_DIR_URL .'bcp/historical_evidence.png" class="img-responsive clickableIcon" alt="Historical Evidence" title="Historical Evidence">
                                                                <textarea class="hidden commentText" name="historical_evidence" excerpt_length='.$summaryLength.'>'. htmlentities($PUCHistoricalEvidence).'</textarea>';
                                                        echo '</td>';
                                                        echo '<td style="border-color:transparent;">&nbsp;</td>';
                                                    echo '</tr>';
                                                    echo '<tbody>';
                                                    echo '</tbody>';
                                                echo '</table>';
                                            echo '</div>';
                                            echo '<h3 class="title" style="margin: 20px 0 10px 0;">Control Domain: '.$threat['name'].'</h3> ';
                                            echo '<div class="table-responsive">
                                                <table class="table table-bordered table-survey">';
                                                    foreach ($opts[$questionId] as $questionSi => $question) {
                                                        $helperId           = $questionId .'_'.$questionSi.'_helper';
                                                        $volnerabilityVal   = !empty($default[$helperId . '_vulnerability']) ? $default[$helperId . '_vulnerability'] : 1;
                                                        $impactVal          = !empty($default[$helperId . '_impact']) ? $default[$helperId . '_impact'] : 1;
                                                        $threatVal          = !empty($default[$helperId . '_threat']) ? $default[$helperId . '_threat'] : 1;
                                                        $avg                = cloudVendor_risk_calc($volnerabilityVal, $impactVal, $threatVal);
                                                        $bigComment         = !empty($default[$helperId .'_comment']) ? $default[$helperId .'_comment'] : '';
                                                        echo '<thead>
                                                            <tr>
                                                                <th colspan="2" class="t-heading-dark w-120px"><big><strong>' . $question['name'] . '</big></strong></th>
                                                                <td colspan="6" class="t-heading-dark" style="height: 77px;"><big style="line-height: 1;">'.$question['desc'].'</big></td>
                                                            </tr>
                                                            <tr>';
                                                            echo '<th class="t-heading-sky text-uppercase font-110p strong" style="width: 150px;">Threat</th>';
                                                            echo '<th class="t-heading-sky text-uppercase font-110p strong" style="width: 150px;">Vulnerability</th>';
                                                            echo '<th class="t-heading-sky text-uppercase font-110p strong" style="width: 150px;">Impact</th>';
                                                            echo '<th class="t-heading-sky text-uppercase font-110p strong" style="width: 50px">Risk</th>';
                                                            echo '<th class="t-heading-sky text-uppercase font-110p strong">' . advisory_get_criteria_label('Comment') .'</th>';
                                                            echo '</tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>';
                                                                echo '<td class="no-padding angleContainer '.cloudVendorBackgroundByValue($threatVal, 'threat').'" data-type="threat"><div class="angularArea"></div> ' . advisory_opt_select($helperId.'_threat', $helperId.'_threat', 'riskTypes', $disabled, $threatOptions, $threatVal) . '</td>';
                                                                echo '<td class="no-padding angleContainer '.cloudVendorBackgroundByValue($volnerabilityVal, 'vulnerability').'" data-type="vulnerability"><div class="angularArea"></div>' . advisory_opt_select($helperId.'_vulnerability', $helperId.'_vulnerability', 'riskTypes', $disabled, $volnerabilityOptions, $volnerabilityVal) . '</td>';
                                                                echo '<td class="no-padding angleContainer '.cloudVendorBackgroundByValue($impactVal, 'impact').'" data-type="impact"><div class="angularArea"></div>' . advisory_opt_select($helperId.'_impact', $helperId.'_impact', 'riskTypes', $disabled, $impactOptions, $impactVal) . '</td>';
                                                                echo '<td class="text-center '.cloudVendorRiskBackground($avg).'"><span class="risk">'. $avg .'</span></td>';
                                                                
                                                                echo '<td class="bigComment" isactive="'.$disabled.'">';
                                                                    echo '<span class="commentExcerpt">'.get_excerpt($bigComment, $excerptLength, '<small>...more</small>').'</span>';
                                                                    echo '<textarea class="hidden commentText" name="'. $questionId . '_comment" excerpt_length='.$excerptLength.' title="Comment">'. htmlentities($bigComment).'</textarea>';
                                                                echo '</td>';
                                                            echo '</tr>';

                                                            if ( !empty($opts[$helperId]) ) {
                                                                foreach ($opts[$helperId] as $helperSi => $helper) {
                                                                    $helperAnsId = $helperId.'_'.$helperSi.'_answer';
                                                                    echo '<tr>';
                                                                        echo '<td colspan="5" class="no-padding">';
                                                                            // echo '<br><pre>'.print_r($default, true).'</pre>'; 
                                                                            echo '<table class="table table-bordered m-0"><tr>';
                                                                            echo '<td style="padding-left: 5px;">'.$helper['name'].'</td>';
                                                                            echo '<td style="background:transparent;padding:0;width:70px;">';
                                                                                echo advisory_opt_select($helperAnsId, $helperAnsId, '', $disabled.' style="padding:5px;color: #fff;background: #000000bf;"', $questionOptions, @$default[$helperAnsId]);
                                                                            echo '</td>';
                                                                            echo '</tr></table>';
                                                                        echo '</td>';
                                                                    echo '</tr>';
                                                                }
                                                            }
                                                        echo '</tbody>';
                                                        $count++;
                                                    }
                                                echo '<input type="hidden" name="nq" value="'. $count .'"></table>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">';
                                            if ($disabled == '') echo '<input type="hidden" name="avg" class="avg-input" value="'.( !empty($default['avg']) ? $default['avg'] : 0 ).'"><button class="btn btn-success btn-submit-primary" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                        echo '</div>
                                    </div>
                                </div>
                            </div>
                        </form>';
                    }
                }
            }
        }
    }
echo '</div>';
?>
<div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="helpModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="helpModal">Asset & Vulnerability Definitions</h4>
            </div>
            <div class="modal-body">
                <iframe class="pdfIframe" width="100%" height="600" src="<?php echo IMAGE_DIR_URL ?>pdf/Asset_and_Vulnerability_Codes.pdf"></iframe>
                <img class="informationImage" src="<?php echo IMAGE_DIR_URL ?>risk_definitions.png"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="commentModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-inverse">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Comment</h4>
            </div>
            <div class="modal-body no-padding"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary saveBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script>
jQuery(function($) {
    "use strict"
    const commentModal = $('#commentModal');
    const commentModalSave = commentModal.find('.saveBtn');
    const helpModal = $('#helpModal');

    $(document).on('change', '#itsmLocations', function(event) {
        event.preventDefault();
        var url = $(this).val();
        window.location.href = url;
    });
    $(document).on('click', '.pdfIcon, .informationIcon', function(event) {
        event.preventDefault();
        if ( $(this).is('.pdfIcon') ) {
            helpModal.find('.modal-title').text('Asset & Vulnerability Definitions');
            helpModal.find('.pdfIframe').removeClass('hidden');
            helpModal.find('.informationImage').addClass('hidden');
        } else {
            helpModal.find('.modal-title').text('');
            helpModal.find('.informationImage').removeClass('hidden');
            helpModal.find('.pdfIframe').addClass('hidden');
        }
        helpModal.modal('show');
    });
    // COMMENT
    $(document).on('click', '.bigComment', function(event) {
        event.preventDefault();
        $(this).addClass('active');

        var comment = $(this).find('.commentText');
        var commentHTML = comment.val();
        var excerpt_length = comment.attr('excerpt_length');
        var title = comment.attr('title');
        var textareaSelector = commentModal.find('.modal-body');
        var textarea = $(textareaSelector);
        var is_active = $('.bigComment.active').attr('isactive');

        $('#commentModal').find('.modal-title').html(title);
        if (is_active.length > 0) {
            commentModal.find('.saveBtn').addClass('hide');
            textarea.html('<div style="font-size: 16px; padding: 15px;">'+ commentHTML +'</div>');
        } else {
            commentModal.find('.saveBtn').removeClass('hide');
            textarea.html('<textarea rows="18" style="width: 100%; padding: 10px;font-size: 16px;" class="no-border tinymce" excerpt_length='+excerpt_length+'>'+ commentHTML +'</textarea>');
            tinymce();
        }

        commentModal.modal('show');
    });
    commentModalSave.on('click', function() {
        var modalTextarea = commentModal.find('textarea');
        var commentArea = $('.bigComment.active');

        var commentHTML = tinyMCE.activeEditor.getContent();
        var commentText = commentHTML.replace(/(<([^>]+)>)/ig,"");
        var excerptLength = modalTextarea.attr('excerpt_length');
        var excerpt = commentText.split(" ").length > excerptLength ? commentText.split(" ").splice(0,excerptLength).join(" ") + '...more' : commentText;

        commentArea.find('.commentExcerpt').html(excerpt);
        commentArea.find('.commentText').val(commentHTML);
        console.log( [commentHTML, excerpt] );
        commentModal.modal('hide');
    });
    commentModal.on('hide.bs.modal', function() {
        $('.bigComment.active').removeClass('active');
        $(this).find('textarea').val('');
    });
    jQuery('.table-survey').each(function(e) {
        cloudVendor_calc_avg();
    })
    // facility Form Calc on Click
    jQuery('select.riskTypes').on('change', function(e) {
        e.preventDefault()
        cloudVendor_calc(jQuery(this));
        cloudVendor_calc_avg();
    })
    function cloudVendor_calc(element, register=false) {
        var data = {}
        var reverse = element.hasClass('reverse')
        var increment = element.hasClass('increment')
        var val = element.val()
        var type = element.parent('td').attr('data-type');
        if (reverse) { val = String(Number(val) + 1) }
        if (increment && val == '0') { val = String(Number(val) + 1) }

        element.parent('td').removeClass('bg-red bg-orange bg-yellow bg-green bg-blue').addClass(facilityBackgroundByValue(val, type))
        element.parents('tr').find('select.riskTypes').each(function(i, e) {
            var val = Number(jQuery(this).val())
            data[i] = val
        })
        var calc = facilityRiskCalculation(data);
        if (register) element.parents('table').find('.bcprAvg').removeClass('bg-red bg-orange bg-yellow bg-green bg-blue').addClass(calc.cls)
        else element.parents('tr').find('.risk').html(calc.count).parent('td').removeClass().addClass('text-center ' + calc.cls);
    }
    function facilityBackgroundByValue(val, type='impact', reverse=false) {
        let cl = 'color-blue';
        if ( val && type ) {
            if ( type == 'impact' ) {
                switch (val) {
                    case '1': cl = 'bg-blue'; break;
                    case '2': cl = 'bg-green'; break;
                    case '3': cl = 'bg-yellow'; break;
                    case '4': cl = 'bg-orange'; break;
                    case '5': cl = 'bg-red'; break;
                    default:  cl = 'color-blue'; break;
                }
            } else if ( type == 'vulnerability' || type == 'threat' ) {
                switch (val) {
                    case '1': cl = 'bg-blue'; break;
                    case '2': cl = 'bg-yellow'; break;
                    case '3': cl = 'bg-red'; break;
                    default:  cl = 'color-blue'; break;
                }
            } 
        }
        return cl
    }
    function facilityRiskCalculation(obj) {
        var data = {count:1, avg:1};
        data.count = Number(obj[0]) * Number(obj[1]) * Number(obj[2]);
        if (data.count > 1) data.avg = Number(data.count / 3).toFixed(1);
        else data.count = 1;

        if ( data.count >= 30 )      { data.cls = 'bg-red'; } 
        else if ( data.count >= 20 ) { data.cls = 'bg-orange'; } 
        else if (data.count >= 11 )  { data.cls = 'bg-yellow'; } 
        else if (data.count >= 2 )   { data.cls = 'bg-green'; } 
        else                         { data.cls = 'bg-blue'; }
        return data
    }
    function cloudVendor_calc_avg() {
        jQuery('.table-survey').each(function() {
            var count = 0
            var total = 0
            var color
            var level
            var card = jQuery(this).parents('.card');
            jQuery(this).find('.risk').each(function() {
                count += 1
                total += Number(jQuery(this).html())
            })
            var avg = Math.round(total / count).toFixed(1)
            if (isNaN(avg)) { avg = (1).toFixed(1); }

            if ( avg >= 30 )      { color = 'bg-red'; level = 'Very High'; } 
            else if ( avg >= 20 ) { color = 'bg-orange'; level = 'High'; } 
            else if (avg >= 11 )  { color = 'bg-yellow'; level = 'Moderate'; } 
            else if (avg >= 2 )   { color = 'bg-green'; level = 'Low'; } 
            else                  { color = 'bg-blue'; level = 'Very Low'; }

            card.find('.avgContainer').removeClass('bg-red bg-orange bg-yellow bg-green bg-blue').addClass(color);
            card.find('.avg-text').find('span').html(avg)
            card.find('.avg-input').val(avg)
        })
    }
    function tinymce() {
        tinyMCE.init({
            selector: '#bigCommentModal2 textarea, .tinymce',
            height: 450,
            plugins: 'lists link autolink',
            toolbar: '"styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
            menubar: false,
            branding: false,
            toolbar_drawer: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            content_style: ".mce-content-body {font-size:18px; font-family: 'Roboto', sans-serif;}",
            // height:"350px",
            // width:"600px"
        });
    }
});
</script>
<?php get_footer(); ?>