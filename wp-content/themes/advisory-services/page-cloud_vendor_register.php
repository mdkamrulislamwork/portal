<?php /* Template Name: Cloud Vendor Register */
get_header();
global $user_switching;
$permission = cloudVendorRgeisterInputController();
$areaId = !empty($_GET['area']) ? $_GET['area'] : 1;
$threatCatId = 'area_'.$areaId.'_threatcat';
$cloudVendorAssessmentId = cloudVendorGetActiveOrArchivedAssessmentId();
$opts = get_post_meta($cloudVendorAssessmentId, 'form_opts', true);
$area_meta = !empty($opts['areas'][$areaId]) ? $opts['areas'][$areaId] : null;
$titleBg = cloudVendorFunctionBackground($areaId);
$priorities = ['1'=>'LOW', '2'=>'MEDIUM', '3'=>'HIGH'];
$registerId = '32218'.advisory_get_user_company_id();
$dateFormat = get_option( 'date_format');
$funcDefault = advisory_form_default_values($registerId, $threatCatId);
$reportLink = site_url('cloud-vendor-report/').'?pid='.base64_encode($cloudVendorAssessmentId).'&area='.base64_encode($areaId);
?>
<script src="<?php echo P3_TEMPLATE_URI. '/js/plugins/jquery.tinymce.min.js'; ?>"></script>
<div class="content-wrapper">
    <div class="page-title">
        <div> <h1><img class="dashboardIcon" src="<?php echo get_template_directory_uri(); ?>/images/icon-rr.png" alt=""><?php _e('Cloud Vendor Maturity Register', 'advisory'); ?></h1> </div>
        <?php 
        if ( $permission['edit'] ) {
            echo '<div>';
                echo '<a class="btn btn-lg btn-success csmr-save-all" data-id="'.$registerId.'" href="javascript:;">Save All</a>';
            echo '</div>';
        }
        ?>
        <div> <ul class="breadcrumb"> <li><i class="fa fa-home fa-lg"></i></li> <li><a href="#"><?php _e('Cloud Vendor Register', 'advisory'); ?></a></li> </ul> </div>
    </div>
    <?php
    if ($cloudVendorAssessmentId) {
        $funcSummary = !empty($funcDefault['summary']) ? trim($funcDefault['summary']) : '';
        $funcSummaryBg = !empty($funcSummary) ? 'bg-red' : 'bg-green';
        $str = '';
        $str .= '<div class="row">';
            $str .= '<div class="col-md-12">';
                $str .= '<form class="survey-form" method="post" data-meta="'. $threatCatId .'" data-id="'. $registerId .'">';
                    $str .= '<div class="card">';
                        $str .= '<div class="card-body">';
                            $str .= '<div class="table-responsive">';
                                $str .= '<table class="table table-csmaFunction">';
                                    $str .= '<tr>';
                                        $str .= '<td class="functionTitle"><h2 class="title">Function: '.$area_meta['name'].' </h2>'.( !empty($area_meta['desc']) ? '<p class="subTitle">'.$area_meta['desc'].'</p>' : '' ).'</td>';
                                        $str .= '<td class="csmaFuncSummary">';
                                            $str .= '<h4 class="title"> Function Summary: </h4>';
                                            $str .= '<a class="btn btn-md btn-primary" target="_blank" href="'.$reportLink.'"><i class="fa fa-lg fa-eye"></i> Preview</a>';
                                        $str .= '</td>';
                                    $str .= '</tr>';
                                $str .= '</table>';
                            $str .= '</div>';
                        $str .= '</div>';
                    $str .= '</div>';
                $str .= '</form>';
            $str .= '</div>';
        $str .= '</div>';

        if ( !empty($opts[$threatCatId]) ) {
            foreach ( $opts[$threatCatId] as $threatCatSi => $threatCat ) {
                $threatId = $threatCatId.'_'.$threatCatSi.'_threat';
                $registerDefault = advisory_form_default_values($cloudVendorAssessmentId, $threatId);
                $default = advisory_form_default_values($registerId, $threatId);
                $updatedAt = !empty($default['updated_at']) ? date($dateFormat, $default['updated_at']) : 'Please save updates';
                // $str .= '<br>'.$registerId.' == '.$threatId.'<pre>'.print_r($default, true).'</pre>';
                // $str .= '<br>'.$cloudVendorAssessmentId.' == '.$threatId.'<pre>'.print_r($registerDefault, true).'</pre>';
                $str .= '<div class="row">';
                    $str .= '<div class="col-md-12">';
                        $str .= '<form class="survey-form" method="post" data-meta="'. $threatId .'" data-id="'. $registerId .'">';
                            $str .= '<input type="hidden" name="updated_at" value="'.time().'">';
                            $str .= '<div class="card">';
                                $str .= '<div class="table-responsive mb-10">';
                                    $str .= '<table>';
                                        $str .= '<tr>';
                                            $str .= '<td class="csmaCatTitle '.$titleBg['cat'].'">';
                                                $str .= '<h4 class="title">Category: '. $threatCat['name'] .'</h4>';
                                                if (!empty($threatCat['desc'])) $str .= '<p class="subTitle">'.$threatCat['desc'].'</p>';
                                            $str .= '</td>';
                                            $str .= '<td class="csmrUpdateTime"><h4 class="title">Last updated</h4><p class="date">'.$updatedAt.'</p></td>';
                                            if ($permission['edit']) $str .= '<td style="width: 84px;"><button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button></td>';
                                        $str .= '</tr>';
                                    $str .= '</table>';
                                $str .= '</div>';
                                $str .= '<div class="card-body">';
                                if ( !empty($opts[$threatId]) ) {
                                    foreach ( $opts[$threatId] as $threatSi => $threat ) {
                                        $questionId = $threatId .'_'. $threatSi.'_question';
                                        if ( !empty($opts[$questionId]) ) {
                                            $desc = !empty(trim($threat['desc'])) ? ' <small>( '.$threat['desc'].' )' : '';
                                            $controlStatementAvg = !empty($registerDefault[$questionId.'_avg']) ? $registerDefault[$questionId.'_avg'] : 0;
                                            $controlStatementAvgStatus = cloudVendorAvgStatus($controlStatementAvg);
                                            $controlStatementSummary = cloudVendorCsSummary($opts, $questionId, $registerDefault);
                                            $defaultPriority = !empty($default[$questionId.'_priority']) ? $default[$questionId.'_priority'] : '';
                                            $defaultSummary = !empty($default[$questionId.'_summary']) ? $default[$questionId.'_summary'] : '';
                                            $defaultResponse = !empty($default[$questionId.'_response']) ? $default[$questionId.'_response'] : '';

                                            // $str .= '<br><pre>'.print_r($controlStatementSummary, true).'</pre>'; 

                                            $str .= '<div class="table-responsive">';
                                                $str .= '<table class="table table-bordered table-survey table-csmaControlStatement">';
                                                        $str .= '<tr>';
                                                            $str .= '<th colspan="9" class="t-heading-dark controlStatementWrapper"><big>Control Statement: '.$threat['name'].'</big>'. $desc .'</th>';
                                                            $str .= '<th colspan="" class="t-heading-dark controlStatementWrapper">Summary</th>';
                                                        $str .= '</tr>';
                                                        $str .= '<tr>';
                                                            $str .= '<td style="width: 173px;background: #f1f1f1;text-transform:uppercase;text-align:center">Maturity Rating:</td>';
                                                            $str .= '<td style="width: 120px;" class="text-center '.$controlStatementAvgStatus['cls'].'">'.$controlStatementAvgStatus['text'].'</td>';
                                                            $str .= '<td style="width: 42px; text-align:center;" class="'.$controlStatementAvgStatus['cls'].'">'.$controlStatementAvgStatus['count'].'</td>';
                                                            $str .= '<td style="width: 235px;background: #f1f1f1;text-transform:uppercase;text-align:center">Response (Action Plan): </td>';
                                                            $str .= '<td style="width: 70px;" class="pointer bigComment '.($defaultResponse ? 'bg-red' : 'bg-green' ).'" isactive=""><textarea class="hidden commentText" name="'.$questionId.'_response">'.$defaultResponse.'</textarea></td>';
                                                            $str .= '<td style="width: 103px;background: #f1f1f1;text-transform:uppercase;text-align:center">Priority:</td>';
                                                            $str .= '<td class="'.cloudVendorPriorityBg($defaultPriority).'" style="width: 143px;padding:0;">'. advisory_opt_select($questionId.'_priority', $questionId.'_priority', 'text-center priority', '', $priorities, $defaultPriority) .'</td>';
                                                            $str .= '<td style="width: 100px;background: #f1f1f1;text-transform:uppercase;text-align:center">Accountable:</td>';
                                                            $str .= '<td style="padding:0;"><input class="csmrAccountable" type="text" name="'.$questionId.'_accountable" value="'.@$default[$questionId.'_accountable'].'"></td>';
                                                            $str .= '<td style="width: 70px;" class="pointer bigComment '.($controlStatementSummary ? 'bg-red' : 'bg-green' ).'" isactive="disabled"><textarea class="hidden commentText" title="Summary"'.$controlStatementSummary.'</textarea></td>';
                                                        $str .= '</tr>';
                                                $str .= '</table>';
                                            $str .= '</div>';
                                        }
                                    }
                                }
                                $str .= '</div>';
                            $str .= '</div>';
                        $str .= '</form>';
                    $str .= '</div>';
                $str .= '</div>';
            }
        }

        if ( $permission['summary'] ) {
            $summariesId = 'area_'.$areaId.'_comments';
            $summaryDefault = advisory_form_default_values($registerId, $summariesId);
            $defaultSummary1 = !empty($summaryDefault['comment_1']) ? $summaryDefault['comment_1'] : '';
            $defaultSummary2 = !empty($summaryDefault['comment_2']) ? $summaryDefault['comment_2'] : '';

            $str .= '<div class="row">';
                $str .= '<div class="col-md-12">';
                    $str .= '<div class="card">';
                        $str .= '<div class="card-title-w-btn mb-10">';
                            $str .= '<h3 class="mb-0"> Summary </h3>';
                            $str .= '<div class="btn-group"><a class="btn btn-primary" target="_blank" href="'.$reportLink.'"><i class="fa fa-lg fa-eye"></i> Preview</a></div>';
                        $str .= '</div>';

                        $str .= '<div class="card-body">';
                            $str .= '<form class="survey-form" method="post" data-meta="'.$summariesId.'" data-id="'. $registerId .'">';
                                $str .= '<div class="summaryContainer">';
                                $str .= '<ul class="list-inline ml-0">';
                                    $str .= '<li class="p-0 inline-item bigComment '. ($defaultSummary1 ? 'bg-red' : 'bg-green' ) .' mr-10" isactive="'.$permission['attr'].'" data-title="Summary 1">';
                                        $str .= '<button class="btn btn-lg btn-transparent" type="button"><i class="fa fa-lg fa-list-alt"></i> Summary 1</button>';
                                        $str .= '<textarea class="hidden commentText" name="comment_1">'.$defaultSummary1.'</textarea>';
                                    $str .= '</li>';
                                    $str .= '<li class="p-0 inline-item bigComment '. ($defaultSummary2 ? 'bg-red' : 'bg-green' ) .'" isactive="'.$permission['attr'].'" data-title="Summary 2">';
                                        $str .= '<button class="btn btn-lg btn-transparent" type="button"><i class="fa fa-lg fa-list-alt"></i> Summary 2</button>';
                                        $str .= '<textarea class="hidden commentText" name="comment_2">'.$defaultSummary2.'</textarea>';
                                    $str .= '</li>';
                                $str .= '</ul>';
                                $str .= '</div>';
                            $str .= '</form>';
                        $str .= '</div>';
                    $str .= '</div>';
                $str .= '</div>';
            $str .= '</div>';
        }
        $str .= editableCommentModal();
        echo $str;
    } else {
        echo '<p>' . __('Cloud Vendor Maturity Register Not Available Yet') . '</p>';
    } ?>
</div>
<script>
jQuery(function($) {
    "use strict"
    const commentModal = $('#commentModal');
    const commentSave = commentModal.find('.saveBtn');
    const commentEdit = commentModal.find('.editBtn');
    $(document).on('change', '.priority', function(event) {
        let cls = null;
        let priority = $(this).val();
        if ( priority >= 3 )      { cls = 'bg-red'; }
        else if ( priority >= 2 ) { cls = 'bg-yellow'; }
        else                    { cls = 'bg-green'; }
        $(this).parent('td').removeClass().addClass(cls);
    })
    $(document).on('click', '.bigComment', function(event) {
        event.preventDefault();
        $(this).addClass('active');
        commentEdit.addClass('hidden');
        commentSave.addClass('hidden');

        var is_active = $(this).attr('isactive');
        var title = $(this).attr('data-title');
        title = title && title.length > 0 ? title : 'Comment';

        var comment = $(this).find('.commentText');
        var commentHTML = comment.val();
        if ( commentHTML.length < 1 ) commentHTML = '<p class="m-0 text-center">Please add details.</p>';
        var textareaSelector = commentModal.find('.modal-body');
        var textarea = $(textareaSelector);

        commentModal.find('.modal-title').html(title);
        textarea.html('<div style="font-size: 16px; padding: 15px;">'+ commentHTML +'</div>');
        if (is_active.length > 0) commentEdit.addClass('hidden');
        else commentEdit.removeClass('hidden');
        commentModal.modal('show');
    });
    commentEdit.on('click', function() {
        var commentHTML = $('.bigComment.active textarea').val();

        var textareaSelector = commentModal.find('.modal-body');
        var textarea = $(textareaSelector);
        textarea.html('<textarea rows="18" style="width: 100%; padding: 10px;font-size: 16px;" class="no-border tinymce">'+ commentHTML +'</textarea>');
        commentEdit.addClass('hidden');
        commentSave.removeClass('hidden');
        tinymce();
    });
    commentSave.on('click', function() {
        var commentArea = $('.bigComment.active');
        var commentHTML = tinyMCE.activeEditor.getContent();
        if ( commentHTML.length > 0 ) commentArea.removeClass('bg-green').addClass('bg-red');
        else commentArea.removeClass('bg-red').addClass('bg-green');
        commentArea.find('.commentText').val(commentHTML);
        commentArea.parents('form').submit();
        commentModal.modal('hide');
    });
    commentModal.on('hide.bs.modal', function() {
        $('.bigComment.active').removeClass('active');
        $(this).find('textarea').val('');
    });
    // HEADER BUTTONS
    $(document).on( 'click', '.csmr-save-all', function(e) {
        e.preventDefault();
        $('form').each(function(){
            $(this).submit();
        })
    })
    function tinymce() {
        tinyMCE.init({
            selector: '.tinymce',
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