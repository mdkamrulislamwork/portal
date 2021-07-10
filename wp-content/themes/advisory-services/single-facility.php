<?php
get_header();
global $user_switching;
$volnerabilityOptions = $threatOptions = ['1'=>'LOW', '2'=>'MED', '3'=>'HIGH'];
$impactOptions = ['1'=>'VERY LOW', '2'=>'LOW', '3'=>'MODERATE', '4'=>'HIGH', '5'=>'VERY HIGH'];
$transient_post_id = get_the_ID();
$opts = get_post_meta($transient_post_id, 'form_opts', true);
$area_meta = advisory_area_exists($transient_post_id, advisory_id_from_string($_GET['area']));
$area_id = advisory_id_from_string($_GET['area']);
$permission = facilityInputController();
// help($permission);
$excerptLength = 10;
$summaryLength = 60;
$questionOptions = ['Yes', 'No', 'Partial', 'Unsure', 'N/A'];
?>
<script src="<?php echo P3_TEMPLATE_URI. '/js/plugins/jquery.tinymce.min.js'; ?>"></script>
<div class="content-wrapper">
    <div class="page-title">
        <div> <h1><?php echo (!empty($area_meta['icon_title']) ? '<img src="' . $area_meta['icon_title'] . '"> ' : '') ?><?php echo $area_meta['name'] ?> <img class="pdfIcon" src="<?php echo get_template_directory_uri(); ?>/images/icon-pdf.png" alt=""> <a href="javascript:;" class="informationIcon"><i class="fa fa-info"></i></a></h1> </div>
        <?php if ($permission['edit']) {
            echo '<div>';
                if($permission['publish']) {
                    if (advisory_is_valid_form_submission($transient_post_id)) echo '<a class="btn btn-lg btn-info btn-publish is-bia" href="#" data-id="' . $transient_post_id . '">Publish</a>';
                    else echo '<a class="btn btn-lg btn-default btn-publish is-bia" href="#" data-id="' . $transient_post_id . '">Publish</a>';
                }
                echo '<a class="btn btn-lg btn-success btn-save-all" href="#">Save All</a>';
                if ($permission['reset']) echo '<a class="btn btn-lg btn-warning btn-reset-all" href="#">Reset</a>';
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
                            $selected = @$_GET['area'] == $name ? ' selected' : '';
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
    <div class="card"> <div class="card-body"> <img src="<?php echo get_template_directory_uri()?>/images/risk_process.jpg" class="img-responsive"> </div> </div>
    <?php if ( !empty($opts['areas']) ) {
        foreach ( $opts['areas'] as $areaSi => $area ) {
            $areaSlug = advisory_id_from_string($area['name']);
            if (@$_GET['area'] != $areaSlug) { continue; }
            $threatCatId = 'area_'.$areaSi . '_threatcat';
            if ( !empty($opts[$threatCatId]) ) {
                foreach ( $opts[$threatCatId] as $threatCatSi => $threatCat ) {
                    $threatId = $threatCatId.'_'.$threatCatSi.'_threat';
                    if ( !empty($opts[$threatId]) ) {
                        $count = 1;
                        $default = advisory_form_default_values($transient_post_id, $threatId);
                        $ac  = !empty($default['ac']) ? ['value' => $default['ac'], 'cls'=>'active'] : ['value' => '', 'cls'=>''];
                        $vc  = !empty($default['vc']) ? ['value' => $default['vc'], 'cls'=>'active'] : ['value' => '', 'cls'=>''];
                        echo '<form class="form survey-form bia-bcp" method="post" data-meta="'. $threatId .'" data-id="'. $transient_post_id .'">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="card">
                                        <div class="card-title-w-btn">
                                            <h4 class="title">Threat Category: '. @$threatCat['name'] .'</h4>';
                                            if ($permission['edit']) echo '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                        echo '</div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <p class="text-left strong font-110p">'. @$threatCat['desc'] .'</p> 
                                                    <div class="avgContainer bg-green text-center font-120p">
                                                        <span class="total-bcp"><strong>Total Risk Level</strong></span> - 
                                                        <span class="total-facility-avg"><strong>Avg: <span></span></strong></span>
                                                    </div>
                                                </div>
                                                <br><br>
                                            </div>';
                                            echo '<div class="table-responsive table-bcp-wrapper">';
                                                echo '<table class="table table-bordered table-survey table-facility">';
                                                    echo '<tr>';
                                                    echo '<td class="inlineCommentContainer" rowspan="4" style="border-color:transparent;">';
                                                        $PUCSummary = !empty($default['summary']) ? $default['summary'] : '';

                                                        echo '<div class="bigComment" isactive="'.$permission['attr'].'">';
                                                            echo '<img src="'. IMAGE_DIR_URL .'bcp/summary.png" class="img-responsive clickableIcon" alt="Summary" title="Summary">';
                                                            echo '<textarea class="hidden commentText" name="summary" excerpt_length='.$summaryLength.'>'. htmlentities($PUCSummary).'</textarea>';
                                                        echo '</div>';
                                                        $PUCHistoricalEvidence = !empty($default['historical_evidence']) ? $default['historical_evidence'] : '';
                                                        echo '<div class="bigComment" isactive="'.$permission['attr'].'">
                                                            <img src="'. IMAGE_DIR_URL .'bcp/historical_evidence.png" class="img-responsive clickableIcon" alt="Historical Evidence" title="Historical Evidence">
                                                            <textarea class="hidden commentText" name="historical_evidence" excerpt_length='.$summaryLength.'>'. htmlentities($PUCHistoricalEvidence).'</textarea>
                                                        </div>';
                                                        echo '</td>';
                                                        echo '<th class="t-heading-sky text-uppercase font-110p strong" style="width:265px;">Asset Codes (Affected Assets)</th>';
                                                    echo '</tr>';
                                                    echo '<tr><td id="'.$threatId.'_assetsImpacted" class="csaPopupBtn '.$permission['access'].$ac['cls'].'"><input type="hidden" id="'.$threatId.'_assetsImpacted_text" name="ac" value="'.$ac['value'].'">&nbsp;</td></tr>';
                                                    echo '<tr><th class="t-heading-sky text-uppercase font-110p strong">Vulnerability Codes</th></tr>';
                                                    echo '<tr><td id="'.$threatId.'_vulnerability" class="csaPopupBtn '.$permission['vulnerability'].$vc['cls'].'"><input type="hidden" id="'.$threatId.'_vulnerability_text" name="vc" value="'.$vc['value'].'">&nbsp;</td></tr>';
                                                    echo '<tbody>';
                                                    echo '</tbody>';
                                                echo '</table>';
                                            echo '</div>';

                                            echo '<div class="table-responsive table-bcp-wrapper">
                                                <table class="table table-bordered table-survey table-facility">';
                                                    foreach ($opts[$threatId] as $threatSi => $threat) {
                                                        $questionId         = $threatId .'_'.$threatSi.'_question';
                                                        $volnerabilityVal   = !empty($default[$questionId . '_vulnerability']) ? $default[$questionId . '_vulnerability'] : 1;
                                                        $impactVal          = !empty($default[$questionId . '_impact']) ? $default[$questionId . '_impact'] : 1;
                                                        $threatVal          = !empty($default[$questionId . '_threat']) ? $default[$questionId . '_threat'] : 1;
                                                        $avg                = facility_risk_calc($volnerabilityVal, $impactVal, $threatVal);
                                                        $bigComment         = !empty($default[$questionId .'_comment']) ? $default[$questionId .'_comment'] : '';
                                                        echo '<thead>
                                                            <tr>
                                                                <th class="t-heading-dark w-120px"><big><strong>Statement ' . $count . '</big></strong></th>
                                                                <th colspan="7" class="t-heading-dark"><big><strong>'.$threat['name'].'</big></strong></th>
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
                                                                echo '<td class="no-padding angleContainer '.facilityBackgroundByValue($threatVal, 'threat').'" data-type="threat"><div class="angularArea"></div> ' . advisory_opt_select($questionId.'_threat', $questionId.'_threat', 'riskTypes', $permission['attr'], $threatOptions, $threatVal) . '</td>';
                                                                echo '<td class="no-padding angleContainer '.facilityBackgroundByValue($volnerabilityVal, 'vulnerability').'" data-type="vulnerability"><div class="angularArea"></div>' . advisory_opt_select($questionId.'_vulnerability', $questionId.'_vulnerability', 'riskTypes', $permission['attr'], $volnerabilityOptions, $volnerabilityVal) . '</td>';
                                                                echo '<td class="no-padding angleContainer '.facilityBackgroundByValue($impactVal, 'impact').'" data-type="impact"><div class="angularArea"></div>' . advisory_opt_select($questionId.'_impact', $questionId.'_impact', 'riskTypes', $permission['attr'], $impactOptions, $impactVal) . '</td>';
                                                                echo '<td class="text-center '.facilityRiskBackground($avg).'"><span class="risk">'. $avg .'</span></td>';
                                                                echo '<td class="bigComment" isactive="'.$permission['attr'].'">';
                                                                    echo '<span class="commentExcerpt">'.get_excerpt($bigComment, $excerptLength, '<small>...more</small>').'</span>';
                                                                    echo '<textarea class="hidden commentText" name="'. $questionId . '_comment" excerpt_length='.$excerptLength.' title="Comment">'. htmlentities($bigComment).'</textarea>';
                                                                echo '</td>';
                                                            echo '</tr>';

                                                            if ( !empty($opts[$questionId]) ) {
                                                                foreach ($opts[$questionId] as $questionSi => $question) {
                                                                    $questionAnsId = $questionId.'_'.$questionSi.'_answer';
                                                                    echo '<tr>';
                                                                        echo '<td colspan="5" class="no-padding">';
                                                                            // echo '<br><pre>'.print_r($default, true).'</pre>'; 
                                                                            echo '<table class="table table-bordered m-0"><tr>';
                                                                            echo '<td style="padding-left: 5px;">'.$question['name'].'</td>';
                                                                            echo '<td style="background:transparent;padding:0;width:70px;">';
                                                                                echo advisory_opt_select($questionAnsId, $questionAnsId, '', $permission['attr'].' style="padding:5px;color: #fff;background: #000000bf;"', $questionOptions, @$default[$questionAnsId]);
                                                                            echo '</td>';
                                                                            echo '</tr></table>';
                                                                        echo '</td>';
                                                                    echo '</tr>';
                                                                }
                                                            }
                                                        echo '</tbody>';
                                                        $count++;
                                                    }
                                                echo '<input type="hidden" name="nq" value="' . $count . '"></table>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">';
                                            if ($permission['edit']) echo '<input type="hidden" name="avg" class="threatAvg" value="'.( !empty($default['avg']) ? $default['avg'] : 0 ).'"><button class="btn btn-success btn-submit-primary" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
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
<div class="modal fade" id="BCPModal">
    <div class="modal-dialog modal-lg lg-plus" style="width: 1080px">
        <div class="modal-content modal-inverse" style="background: #000000bf;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Select options</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary saveAssetsImpacted">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="helpModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Asset & Vulnerability Definitions</h4>
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
    jQuery('.table-facility').each(function(e) {
        facility_calc_avg();
    })
    // facility Form Calc on Click
    jQuery('.table-facility select.riskTypes').on('change', function(e) {
        e.preventDefault()
        facility_calc(jQuery(this));
        facility_calc_avg();
    })
    function facility_calc(element, register=false) {
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
    function facility_calc_avg() {
        jQuery('.table-facility').each(function() {
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
            card.find('.total-bcp').find('strong').html(level)
            card.find('.total-facility-avg').find('span').html(avg)
            card.find('.threatAvg').val(avg)
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