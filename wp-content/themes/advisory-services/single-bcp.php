<?php
get_header();
global $user_switching;
$transient_post_id = get_the_ID();
$opts = get_post_meta($transient_post_id, 'form_opts', true);
$area_meta = advisory_area_exists($transient_post_id, advisory_id_from_string($_GET['area']));
$area_id = advisory_id_from_string($_GET['area']);
$permission = bcpInputController();
$excerptLength = 10;
$summaryLength = 60;
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
                <?php if (!$permission['edit']) {
                    if ($opts['areas']) {
                        $link = site_url('bcp/'. $post->ID .'/?view=true&area=');
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
    <?php if ($opts['areas']) {
        foreach ($opts['areas'] as $threat_cat) {
            if (@$_GET['area'] != advisory_id_from_string($threat_cat['name'])) { continue; }
            // echo '<br><pre>'.print_r($opts, true).'</pre>';
            $cat_id = advisory_id_from_string($threat_cat['name']);
            if ($threats = $opts[$cat_id . '_threats']) {
                foreach ($threats as $threat) {
                    $threat_id = $cat_id . '_' . advisory_id_from_string($threat['name']);
                    $default = advisory_form_default_values($transient_post_id, $threat_id);
                    $ac  = !empty($default['ac']) ? ['value' => $default['ac'], 'cls'=>'active'] : ['value' => '', 'cls'=>''];
                    $vc = !empty($default['vc']) ? ['value' => $default['vc'], 'cls'=>'active'] : ['value' => '', 'cls'=>''];
                    echo '<form class="form survey-form bia-bcp" method="post" data-meta="' . $threat_id . '" data-id="'. $transient_post_id .'">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="card">
                                    <div class="card-title-w-btn">
                                        <h4 class="title">Threat: '. @$threat['name'] .'</h4>';
                                        if ($permission['edit']) echo '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                    echo '</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12"> 
                                                <p class="text-left strong font-110p">' . @$threat['desc'] . '</p> 
                                                <div class="avgContainer color-four text-center font-120p">
                                                    <span class="total-bcp"><strong>Total Risk Level</strong></span> - 
                                                    <span class="total-bcp-avg"><strong>Avg: <span></span></strong></span>
                                                </div>
                                            </div>
                                            <br><br>
                                        </div>';
                                        echo '<div class="table-responsive table-bcp-wrapper">';
                                            echo '<table class="table table-bordered table-survey table-bia-bcp">';
                                                echo '<tr>';
                                                echo '<td class="inlineCommentContainer" rowspan="4" style="border-color:transparent;">';
                                                    $PUCSummary = !empty($default['summary']) ? $default['summary'] : '';
                                                    echo '<div class="bigComment2" isactive="'.$select_attr.'">';
                                                        echo '<img src="'. IMAGE_DIR_URL .'bcp/summary.png" class="img-responsive clickableIcon" alt="Summary" title="Summary">';
                                                        echo '<textarea class="hidden bigComment_text" name="summary" excerpt_length='.$summaryLength.'>'. htmlentities($PUCSummary).'</textarea>';
                                                    echo '</div>';
                                                    $PUCHistoricalEvidence = !empty($default['historical_evidence']) ? $default['historical_evidence'] : '';
                                                    echo '<div class="bigComment2" isactive="'.$select_attr.'">
                                                        <img src="'. IMAGE_DIR_URL .'bcp/historical_evidence.png" class="img-responsive clickableIcon" alt="Historical Evidence" title="Historical Evidence">
                                                        <textarea class="hidden bigComment_text" name="historical_evidence" excerpt_length='.$summaryLength.'>'. htmlentities($PUCHistoricalEvidence).'</textarea>
                                                    </div>';
                                                    echo '</td>';
                                                    echo '<th class="t-heading-sky text-uppercase font-110p strong" style="width:265px;">Asset Codes (Affected Assets)</th>';
                                                echo '</tr>';
                                                echo '<tr><td id="'.$threat_id.'_assetsImpacted" class="csaPopupBtn '.$permission['access'].$ac['cls'].'"><input type="hidden" id="'.$threat_id.'_assetsImpacted_text" name="ac" value="'.$ac['value'].'">&nbsp;</td></tr>';
                                                echo '<tr><th class="t-heading-sky text-uppercase font-110p strong">Vulnerability Codes</th></tr>';
                                                echo '<tr><td id="'.$threat_id.'_vulnerability" class="csaPopupBtn '.$permission['vulnerability'].$vc['cls'].'"><input type="hidden" id="'.$threat_id.'_vulnerability_text" name="vc" value="'.$vc['value'].'">&nbsp;</td></tr>';
                                                echo '<tbody>';
                                                echo '</tbody>';
                                            echo '</table>';
                                        echo '</div>';

                                        echo '<div class="table-responsive table-bcp-wrapper">
                                            <table class="table table-bordered table-survey table-bia-bcp">';
                                                $questions = @$opts[$cat_id . '_threat_' . advisory_id_from_string($threat['name']) . '_fields'];
                                                if ($questions) {
                                                    $count = 0;
                                                    foreach ($questions as $question) {
                                                        $count++;
                                                        $q_id = $threat_id . '_q' . $count;
                                                        $volnerabilityVal   = !empty($default[$q_id . '_vulnerability']) ? $default[$q_id . '_vulnerability'] : 0;
                                                        $impactVal          = !empty($default[$q_id . '_impact']) ? $default[$q_id . '_impact'] : 0;
                                                        $probabilityVal     = !empty($default[$q_id . '_probability']) ? $default[$q_id . '_probability'] : 0;
                                                        $avg                = bcp_risk_calc($volnerabilityVal, $impactVal, $probabilityVal);
                                                        echo '<thead>
                                                            <tr>
                                                                <th class="t-heading-dark w-120px"><big><strong>Question ' . $count . '</big></strong></th>
                                                                <th colspan="7" class="t-heading-dark"><big><strong>' . $question['name'] . '</big></strong></th>
                                                            </tr>
                                                            <tr>';
                                                            echo '<th class="t-heading-sky text-uppercase font-110p strong" style="width: 150px;">Vulnerability</th>';
                                                            echo '<th class="t-heading-sky text-uppercase font-110p strong" style="width: 150px;">' . advisory_get_criteria_label('impact') . '</th>';
                                                            echo '<th class="t-heading-sky text-uppercase font-110p strong" style="width: 150px;">' . advisory_get_criteria_label('probability') . '</th>';
                                                            echo '<th class="t-heading-sky text-uppercase font-110p strong" style="width: 50px">Risk</th>';
                                                            echo '<th class="t-heading-sky text-uppercase font-110p strong">' . advisory_get_criteria_label('Comment') .'</th>';
                                                            echo '</tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>';
                                                                $volnerabilityOptions = ['1'=>'NONE', '2'=>'LOW', '3'=>'MODERATE', '4'=>'HIGH', '5'=>'VERY HIGH'];
                                                                echo '<td class="no-padding angleContainer '.BCPcolorByValue($volnerabilityVal).'"><div class="angularArea"></div>' . advisory_opt_select($q_id.'_vulnerability', $q_id.'_vulnerability', '', $permission['attr'], $volnerabilityOptions, $volnerabilityVal) . '</td>';
                                                                $impactOptions = ['1'=>'NONE', '2'=>'MINOR', '3'=>'NOTICEABLE', '4'=>'SEVERE', '5'=>'DEVASTATING'];
                                                                echo '<td class="no-padding angleContainer '.BCPcolorByValue($impactVal).'"><div class="angularArea"></div>' . advisory_opt_select($q_id.'_impact', $q_id.'_impact', '', $permission['attr'], $impactOptions, $impactVal) . '</td>';
                                                                $probablityOptions = ['1'=>'POSSIBLE', '2'=>'PREDICTED', '3'=>'ANTICIPATED', '4'=>'EXPECTED', '5'=>'CONFIRMED'];
                                                                echo '<td class="no-padding angleContainer '.BCPcolorByValue($probabilityVal).'"><div class="angularArea"></div> ' . advisory_opt_select($q_id.'_probability', $q_id.'_probability', '', $permission['attr'], $probablityOptions, $probabilityVal) . '</td>';
                                                                echo '<td class="text-center '.bcp_risk_class($avg).'"><span class="bcp">'. $avg .'</span></td>';
                                                                $bigComment = !empty($default[$q_id .'_comment']) ? $default[$q_id .'_comment'] : '';
                                                                echo '<td class="bigComment" isactive="'.$permission['attr'].'"><span>'.get_excerpt($bigComment, $excerptLength, '<small>...more</small>').'</span><input type="hidden" class="no-border bigComment_text" name="'. $q_id . '_comment" value="'. htmlentities($bigComment).'" excerpt_length='.$excerptLength.' title="Comment"></td>';
                                                            echo '</tr>
                                                        </tbody>';
                                                    }
                                                }
                                            echo '<input type="hidden" name="nq" value="' . $count . '"></table>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">';
                                        if ($permission['edit']) echo '<input type="hidden" name="avg" class="hidden-avg" value="0"><button class="btn btn-success btn-submit-primary" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                    echo '</div>
                                </div>
                            </div>
                        </div>
                    </form>';
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
                <h4 class="modal-title" id="helpModal">Asset & Vulnerability Definitions</h4>
            </div>
            <div class="modal-body"><iframe width="100%" height="600" src="<?php echo IMAGE_DIR_URL ?>pdf/Asset_and_Vulnerability_Codes.pdf"></iframe></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="informationModal" tabindex="-1" role="dialog" aria-labelledby="helpModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="helpModal"></h4>
            </div>
            <div class="modal-body"><img src="<?php echo IMAGE_DIR_URL ?>risk_definitions.png"/></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="bigCommentModal">
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
<div class="modal fade" id="bigCommentModal2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-inverse">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Comment</h4>
            </div>
            <div class="modal-body no-padding"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary saveBtn2">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="threatQuestionsModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content modal-inverse">
            <form class="form survey-form" method="post" data-meta="<?php echo $cat_id ?>" data-id="'. $transient_post_id .'">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Threat Questions</h4>
                </div>
                <div class="modal-body">
                    <?php 
                    if ( !empty($opts[$cat_id.'_questions']) ) {
                        $threatOptions = ['YES', 'NO', 'PARTIAL', 'N/A'];
                        echo '<table class="table table-bordered threatQueationWrapper">';
                            foreach ( $opts[$cat_id.'_questions'] as $question_id => $question ) {
                                echo '<tr class="question">';
                                    echo '<td>'. $question['name'] .'</td>';
                                    echo '<td class="no-padding"><select name="">';
                                        echo '<option>Select</option>';
                                        foreach ($threatOptions as $threatOption) {
                                            echo '<option value="'.$threatOption.'">'.$threatOption.'</option>';
                                        }
                                    echo '</select></td>';
                                echo '</tr>';
                            }
                            echo '<tr class="comment">';
                                echo '<td colspan="2"> <textarea rows="3" style="width: 100%; padding: 10px;font-size: 16px;" class="no-border" placeholder="Comment"></textarea></td>';
                            echo '</tr>';
                        echo '</table>';
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary save">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
jQuery(function($) {
    "use strict"
    $(document).on('change', '#itsmLocations', function(event) {
        event.preventDefault();
        var url = $(this).val();
        window.location.href = url;
    });
    $(document).on('click', '.pdfIcon', function(event) {
        event.preventDefault();
        $('#helpModal').modal('show');
    });
    $(document).on('click', '.informationIcon', function(event) {
        event.preventDefault();
        $('#informationModal').modal('show');
    });
    // COMMENT
    $(document).on('click', '.bigComment', function(event) {
        event.preventDefault();
        $(this).addClass('active');

        var comment = $('.bigComment.active .bigComment_text');
        var modal = $('#bigCommentModal');
        var commentHTML = comment.val();
        var excerpt_length = comment.attr('excerpt_length');
        var title = comment.attr('title');
        var textareaSelector = modal.find('.modal-body');
        var textarea = $(textareaSelector);
        var is_active = $('.bigComment.active').attr('isactive');

        $('#bigCommentModal').find('.modal-title').html(title);
        if (is_active.length > 0) {
            modal.find('.saveBtn').addClass('hide');
            textarea.html('<div style="font-size: 16px; padding: 15px;">'+ commentHTML +'</div>');
        } else {
            modal.find('.saveBtn').removeClass('hide');
            // textarea.html('<textarea rows="18" excerpt_length='+excerpt_length+'>'+ commentHTML +'</textarea>');
            textarea.html('<textarea rows="18" style="width: 100%; padding: 10px;font-size: 16px;" class="no-border" excerpt_length='+excerpt_length+'>'+ commentHTML +'</textarea>');
            tinymce();
        }

        modal.modal('show');
    });
    $('#bigCommentModal').on('hide.bs.modal', function() {
        $('.bigComment').removeClass('active');
        $(this).find('textarea').val('');
    });
    $('#bigCommentModal .saveBtn').on('click', function() {
        var comment = $('#bigCommentModal textarea');
        var commentText = comment.val();
        var excerptLength = comment.attr('excerpt_length');
        var excerpt = commentText.split(" ").length > excerptLength ? commentText.split(" ").splice(0,excerptLength).join(" ") + '<small>...more</small>' : commentText;
        $('#bigCommentModal textarea').html('');
        $('.bigComment.active span').html(excerpt);
        $('.bigComment.active .bigComment_text').val(commentText);
        // alert(excerpt); return false; 
        $('#bigCommentModal').modal('hide');
    });
    // SUMMARY
    $(document).on('click', '.threatQuestions', function(event) {
        event.preventDefault();
        $(this).addClass('active');
        $('#threatQuestionsModal').modal('show')
    })
    $(document).on('click', '.bigComment2', function(event) {
        event.preventDefault();
        $(this).addClass('active');

        var comment = $('.bigComment2.active .bigComment_text');
        var modal = $('#bigCommentModal2');
        var commentHTML = comment.val();
        var excerpt_length = comment.attr('excerpt_length');
        var title = comment.attr('title');
        var textareaSelector = modal.find('.modal-body');
        var textarea = $(textareaSelector);
        var is_active = $('.bigComment2.active').attr('isactive');

        $('#bigCommentModal2').find('.modal-title').html(title);
        if (is_active.length > 0) {
            modal.find('.saveBtn2').addClass('hide');
            textarea.html('<div style="font-size: 16px; padding: 15px;">'+ commentHTML +'</div>');
        } else {
            modal.find('.saveBtn2').removeClass('hide');
            textarea.html('<textarea rows="18" excerpt_length='+excerpt_length+'>'+ commentHTML +'</textarea>');
            tinymce();
        }

        modal.modal('show');
    });
    $(document).on('click', '.PUCSummary, .PUCHistoricalEvidence', function(event) {
        event.preventDefault();
        $(this).addClass('active');

        var comment = $('.bigComment2.active .bigComment_text');
        var modal = $('#bigCommentModal2');
        var commentHTML = comment.val();
        var excerpt_length = comment.attr('excerpt_length');
        var title = comment.attr('title');
        var textareaSelector = modal.find('.modal-body');
        var textarea = $(textareaSelector);
        var is_active = $('.bigComment2.active').attr('isactive');

        $('#bigCommentModal2').find('.modal-title').html(title);
        if (is_active.length > 0) {
            modal.find('.saveBtn2').addClass('hide');
            textarea.html('<div style="font-size: 16px; padding: 15px;">'+ commentHTML +'</div>');
        } else {
            modal.find('.saveBtn2').removeClass('hide');
            textarea.html('<textarea rows="18" excerpt_length='+excerpt_length+'>'+ commentHTML +'</textarea>');
            tinymce();
        }

        modal.modal('show');
    });
    $('#bigCommentModal2').on('hide.bs.modal', function() {
        $('.bigComment2').removeClass('active');
        $(this).find('textarea').val('');
    });
    $('#bigCommentModal2 .saveBtn2').on('click', function() {
        var comment = $('#bigCommentModal2 textarea');
        var commentHTML = tinyMCE.activeEditor.getContent();
        var commentText = commentHTML.replace(/(<([^>]+)>)/ig,"");
        var excerptLength = comment.attr('excerpt_length');
        var excerpt = commentText.split(" ").length > excerptLength ? commentText.split(" ").splice(0,excerptLength).join(" ") + '...' : commentText;

        comment.html('');
        $('.bigComment2.active span').html(excerpt);
        $('.bigComment2.active .bigComment_text').val(commentHTML);
        // alert(excerpt); return false; 
        $('#bigCommentModal2').modal('hide');
    });
    $('#threatQuestionsModal form').on('submit', function(event) {
        event.preventDefault();
        alert('threatQuestionsModal');
    });
    function tinymce() {
        tinyMCE.init({
            selector: '#bigCommentModal2 textarea',
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