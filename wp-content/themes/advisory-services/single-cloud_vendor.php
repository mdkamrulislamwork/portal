<?php
get_header();
global $post;
$areaId = !empty($_GET['area']) ? $_GET['area'] : 1;
$threatCatId = 'area_'.$areaId.'_threatcat';
$opts = get_post_meta($post->ID, 'form_opts', true);
$area_meta = !empty($opts['areas'][$areaId]) ? $opts['areas'][$areaId] : null;
$permission = cloudVendorInputController();
$areaIcon = !empty($area_meta['icon_title']) ? '<img src="'. $area_meta['icon_title'] .'">' : '<img src="'. IMAGE_DIR_URL .'icon-csma.png">';
$responses = ['0'=>'N/A', '1'=>'NO', '2'=>'YES', '3' => 'PARTIAL'];
$scores = ['0' => 'N/A', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'];
$company = advisory_get_user_company();
$titleBg = csmaFunctionBackground($areaId);

$domains = cloud_vendorDomains($opts);
// echo '<br><pre>'.print_r($domains, true).'</pre>'; exit();
?>
<script src="<?php echo P3_TEMPLATE_URI. '/js/plugins/jquery.tinymce.min.js'; ?>"></script>
<div class="content-wrapper">
    <!-- Page Title -->
    <div class="page-title">
        <div> <h1></h1> </div>
        <?php if ( $permission['edit'] ) {
            echo '<div>';
                if ( $permission['publish'] ) {
                    if ( advisory_is_valid_form_submission($post->ID) ) echo '<a class="btn btn-lg btn-info btn-publish" href="javascript:;" data-id="' . $post->ID . '">Publish</a>';
                    // else echo '<a class="btn btn-lg btn-default btn-publish" href="javascript:;" data-id="' . $post->ID . '">Publish</a>';
                }
                echo '<a class="btn btn-lg btn-success cloudVendor-save-all" data-id="'. $post->ID .'" href="javascript:;">Save All</a>';
                if ( $permission['publish'] ) echo '<a class="btn btn-lg btn-warning cloudVendor-reset-all" data-id="'. $post->ID .'" href="javascript:;">Reset</a>';
            echo '</div>';
        } ?>
        <div>
            <ul class="breadcrumb">
                <li><i class="fa fa-home fa-lg"></i></li>
                <li><a href="javascript:;"><?php echo advisory_get_form_name($post->ID) ?></a></li>
                <li><a href="javascript:;"><?php echo $area_meta['name'] ?></a></li>
            </ul>
        </div>
    </div>
    <?php
    echo '<div class="card"> ';
        echo '<div class="card-body"> ';
            echo '<div class="row">';
                echo '<div class="col-sm-4">';
                    echo '<img src="'.IMAGE_DIR_URL.'cloud-vendor/banner-left.png" usemap="#image-map" style="margin-top:100px">';
                    echo '<map name="image-map">';
                        echo '<area target="_self" alt="Governance" title="Governance" href="'.$domains[1].'" coords="506,456,459,413,421,388,202,167,238,132,298,92,345,67,405,44,481,19,541,9,608,1,666,1,741,12,806,27,862,46,906,67,936,84,974,109,996,126,1026,153,1040,163,816,389,784,411,738,459,705,436,668,422,618,417,571,421" shape="poly">';
                        echo '<area target="_self" alt="Operations" title="Operations" href="'.$domains[2].'" coords="786,506,830,462,852,427,1078,199,1103,230,1127,263,1144,291,1164,320,1184,360,1200,398,1214,436,1228,497,1238,551,1238,603,1238,678,1229,738,1210,812,1191,862,1165,917,1140,960,1109,1000,1076,1041,853,817,832,784,786,738,811,693,823,641,820,587,809,544" shape="poly">';
                        echo '<area target="_self" alt="Security &amp; Risk Management" title="Security &amp; Risk Management" href="'.$domains[3].'" coords="738,789,781,826,815,850,1041,1079,987,1122,929,1160,876,1185,821,1209,754,1226,686,1239,626,1239,560,1238,494,1229,420,1210,351,1181,293,1145,246,1115,201,1079,425,851,460,828,504,787,542,806,590,820,632,822,684,814,716,799" shape="poly">';
                        echo '<area target="_self" alt="People &amp; Process" title="People &amp; Process" href="'.$domains[4].'" coords="456,738,413,782,389,816,167,1041,121,990,88,940,58,880,35,825,18,768,9,714,2,658,2,603,4,552,14,485,33,427,49,380,71,336,95,289,123,252,163,197,391,426,411,459,456,503,433,542,419,609,422,660,432,699" shape="poly">';
                    echo '</map>';
                echo '</div>';
                echo '<div class="col-sm-8"><img src="'.IMAGE_DIR_URL.'cloud-vendor/banner-right.png" style="margin-top:0px"></div>';
            echo '</div>';
        echo '</div> ';
    echo '</div>';

    $str = '';
    $str .= '<div class="row">';
        $str .= '<div class="col-md-12">';
            $str .= '<div class="card">';
                $str .= '<div class="card-body">';
                    $str .= '<div class="table-responsive">';
                        $str .= '<table class="table table-csmaFunction">';
                            $str .= '<tr>';
                            $str .= '<td class="functionTitle"><h2 class="title">Category: '.$area_meta['name'].' </h2>'.( !empty($area_meta['desc']) ? '<p class="subTitle">'.$area_meta['desc'].'</p>' : '' ).'</td>';
                            $str .= '<td class="cloudVendorFuncAvg"><h4 class="title"> Category Average: </h4><span data-toggle="tooltip" data-placement="left" title=""></span></td>';
                            $str .= '</tr>';
                        $str .= '</table>';
                    $str .= '</div>';
                $str .= '</div>';
            $str .= '</div>';
        $str .= '</div>';
    $str .= '</div>';
    if ( !empty($opts[$threatCatId]) ) {
        foreach ( $opts[$threatCatId] as $threatCatSi => $threatCat ) {
            $threatId = $threatCatId.'_'.$threatCatSi.'_threat';
            $default = advisory_form_default_values($post->ID, $threatId);
            // $str .= '<br>'.$post->ID.' == '.$threatId.'<pre>'.print_r($default, true).'</pre>';
            $catAvg = !empty($default['avg']) && $default['avg'] != 'NaN' ? $default['avg'] : 0;
            $catAvgStatus = cloudVendorAvgStatus($catAvg);
            $comment = !empty($default['comment']) ? $default['comment'] : null;
            $str .= '<div class="row">';
                $str .= '<div class="col-md-12">';
                    $str .= '<form class="survey-form" method="post" data-meta="'. $threatId .'" data-id="'. $post->ID .'">';
                        $str .= '<div class="card">';
                            $str .= '<div class="table-responsive mb-10">';
                                $str .= '<table>';
                                    $str .= '<tr>';
                                    $str .= '<td class="csmaCatTitle '.$titleBg['cat'].'">';
                                        $str .= '<h4 class="title">Control Domain: '. $threatCat['name'] .'</h4>';
                                        if (!empty($threatCat['desc'])) $str .= '<p class="subTitle">'.$threatCat['desc'].'</p>';
                                    $str .= '</td>';
                                    $str .= '<td class="cloudVendorCatAvg">';
                                        $str .= '<h4 class="title"> Control Domain Average: </h4>';
                                        $str .= '<span class="'.$catAvgStatus['cls'].'" data-toggle="tooltip" data-placement="left" title="'.$catAvg.'">'.$catAvgStatus['text'].'</span>';
                                        $str .= '<input type="hidden" name="avg" value="'.$catAvg.'">';
                                    $str .= '</td>';
                                    if ($permission['edit']) $str .= '<td style="width: 84px;"><button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button></td>';
                                    $str .= '</tr>';
                                $str .= '</table>';
                            $str .= '</div>';
                            $str .= '<div class="card-body">';
                            if ( !empty($opts[$threatId]) ) {
                                $count = 1;
                                foreach ( $opts[$threatId] as $threatSi => $threat ) {
                                    $questionId = $threatId .'_'. $threatSi.'_question';
                                    if ( !empty($opts[$questionId]) ) {
                                        $threat['weight'] = !empty($threat['weight']) ? $threat['weight'] : 0;
                                        $desc = !empty($threat['desc']) && !empty(trim($threat['desc'])) ? ' <hr style="margin: 5px 0;"><small>'.$threat['desc'].'</small>' : '';
                                        $controlStatementAvg = !empty($default[$questionId.'_avg']) ? $default[$questionId.'_avg'] : 0;
                                        $defaultWeight = !empty($default[$questionId.'_weight']) ? $default[$questionId.'_weight'] : $threat['weight'];
                                        $controlStatementAvgStatus = cloudVendorAvgStatus($controlStatementAvg);
                                        $questionCounter = 1;

                                        // $str .= '<br><pre>'.print_r($default, true).'</pre>';

                                        $str .= '<div class="card innerCard">';
                                            $str .= '<div class="card-body">';
                                                $str .= '<div class="table-responsive">';
                                                    $str .= '<table class="table table-bordered table-survey table-csmaControlStatement">
                                                        <thead>';
                                                            $str .= '<tr class="controlStatementRating">';
                                                                $str .= '<td colspan="5" class="no-border pl-0">';
                                                                    // $str .= '<div>Control Domain: '.$threat['name'].'</div>';
                                                                    $str .= '<strong><big>Maturity Rating: </big> <span class="cloudVendorControlStatementAvgStatus '.$controlStatementAvgStatus['cls'].'" data-toggle="tooltip" data-placement="right" title="'.$controlStatementAvg.'"> '.$controlStatementAvgStatus['text'].' </span></strong>';
                                                                    $str .= '<input type="hidden" name="'.$questionId.'_avg" class="cloudVendorControlStatementAvg" value="'.$controlStatementAvg.'">';
                                                                    $str .= '<input type="hidden" name="'.$questionId.'_weight" class="weight" value="'.$defaultWeight.'" baseweight="'.$threat['weight'].'">';
                                                                $str .= '</td>';
                                                            $str .= '</tr>';
                                                            $str .= '<tr>';
                                                                $str .= '<th colspan="5" class="t-heading-dark controlStatementWrapper"><strong>Control Statement(s): '.$threat['name'].'</strong>'. $desc .'</th>';
                                                            $str .= '</tr>';
                                                        $str .= '</thead>';
                                                        $str .= '<tbody>';
                                                            $str .= '<tr class="inactive bg-deepblue">';
                                                                $str .= '<td>Questions</td>';
                                                                $str .= '<td style="width: 90px;">Response</td>';
                                                                $str .= '<td style="width: 60px;">Score</td>';
                                                                $str .= '<td style="width: 110px;">Comments</td>';
                                                            $str .= '</tr>';
                                                            foreach ( $opts[$questionId] as $questionSi => $question) {
                                                                $ansId = $questionId.'_'.$questionSi;
                                                                $defaultScore = !empty($default[$ansId.'_score']) ? $default[$ansId.'_score'] : 0;
                                                                $defaultResponse = !empty($default[$ansId.'_response']) ? $default[$ansId.'_response'] : 0;
                                                                $defaultComment = !empty($default[$ansId.'_comment']) ? htmlentities($default[$ansId.'_comment']) : '';
                                                                $str .= '<tr class="questionContainer">';
                                                                    $str .= '<td class="question">';
                                                                        $str .= '<span class="index">'. $questionCounter . '. </span><span class="name">'.$question['name'].'</span>';
                                                                    $str .= '</td>';
                                                                    $str .= '<td class="no-padding bg-black response">'. advisory_opt_select($ansId.'_response', $ansId.'_response', '', $permission['attr'], $responses, $defaultResponse) .'</td>';
                                                                    $str .= '<td class="no-padding score '.cloudVendorScoreBg($defaultScore).'">'. advisory_opt_select($ansId.'_score', $ansId.'_score', '', $permission['attr'], $scores, $defaultScore) .'</td>';
                                                                    $str .= '<td class="bigComment pointer '.($defaultComment ? 'bg-red':'bg-green').'" isactive="'.$permission['attr'].'"><textarea class="hidden commentText" name="'.$ansId.'_comment" title="Comment">' . $defaultComment . '</textarea></td>';
                                                                $str .= '</tr>';
                                                                $questionCounter++;
                                                            }
                                                        $str .= '</tbody>';
                                                    $str .= '</table>';
                                                $str .= '</div>';
                                            $str .= '</div>';
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
$str .= '</div>';
$str .= editableCommentModal();
echo $str;
get_footer(); ?>
<script>
(function($) {
    'use strict';
    const commentModal = $('#commentModal');
    const commentSave = commentModal.find('.saveBtn');
    const commentEdit = commentModal.find('.editBtn');
    cloudVendorFunctionAvg();
    $(document).on( 'change', '.score select', function() {
        let element = $(this);
        cloudVendorScoreBg(element);
        cloudVendorControlStagementAvg(element);
        cloudVendorCategoryAvg(element);
        cloudVendorFunctionAvg();
    })
    $(document).on( 'click', '.cloudVendor-save-all', function(e) {
        e.preventDefault();
        $('form').find('.btn-success').each(function(){
            $(this).click();
        })
    })
    $(document).on( 'click', '.cloudVendor-reset-all', function(e) {
        e.preventDefault();
        let button = $(this);
        let postId = parseInt(button.attr('data-id'));

        if ( postId ) {
            swal({
                title: "WARNING",
                text: "Activating a new assessment will reset all current values. Are you sure you want to proceed?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4caf50",
                confirmButtonText: "Yes",
                closeOnConfirm: false
            }, function() {
                jQuery.ajax({
                    type: 'POST',
                    url: object.ajaxurl + '?action=reset_cloud_vendor',
                    cache: false,
                    data: {id: postId, security: object.ajax_nonce },
                    beforeSend: function() { button.attr('disabled', true); },
                    success: function(response, status, xhr) {
                        button.attr('disabled', false);
                        if (response == true) {
                            swal("Success!", "New Assessment has been removed", "success")
                            setTimeout(function() {
                                window.location.reload()
                            }, 2000)
                        } else {
                            swal("Error!", "Something went wrong.", "error")
                        }
                    },
                    error: function(error) {
                        button.attr('disabled', false);
                    }
                })
            })
        }
    })
    // COMMENT
    $(document).on('click', '.bigComment', function(event) {
        event.preventDefault();
        $(this).addClass('active');
        commentEdit.addClass('hidden');
        commentSave.addClass('hidden');

        var comment = $(this).find('.commentText');
        var commentHTML = comment.val();
        if ( commentHTML.length < 1 ) commentHTML = '<p class="m-0 text-center">Please add details.</p>';
        var title = comment.attr('title');
        var textareaSelector = commentModal.find('.modal-body');
        var textarea = $(textareaSelector);
        var is_active = $('.bigComment.active').attr('isactive');

        $('#commentModal').find('.modal-title').html(title);
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
    function cloudVendorScoreBg(button) {
        let baseCls = 'no-padding score';
        let cls = ''
        switch (parseInt(button.val())) {
            case 1: cls = 'bg-red';          break;
            case 2: cls = 'bg-yellow';       break;
            case 3: cls = 'bg-green';        break;
            case 4: cls = 'bg-light-blue';   break;
            case 5: cls = 'bg-deepblue';     break;
            default: cls = 'bg-black';       break;
        }
        button.parent('td').removeClass().addClass(baseCls+' '+cls);
    }
    function cloudVendorControlStagementAvg(element) {
        var total = 0, counter = 0, avg = 0, cls = null, status = null;
        var table = element.parents('table');
        let questionContainers = table.find('.questionContainer');
        questionContainers.each(function() {
            let score = parseInt($(this).find('.score select').val());
            if ( score ) {
                total += score;
                counter++;
            }
            // console.log({'total': total, 'score': score, 'weight': weight })
        })
        if ( total ) avg = (total / counter).toFixed(1);
        // WEIGHT DISTRIBUTION
        cloudVendorDistributeWeight(element, avg);
        // ADD CLASS AND STATUS
        status = cloudVendorAvgStatus(avg);
        table.find('.cloudVendorControlStatementAvgStatus').removeClass().addClass('cloudVendorControlStatementAvgStatus '+ status.cls).text(status.text).attr('data-original-title',avg);
        table.find('.cloudVendorControlStatementAvg').val(avg);
    }
    function cloudVendorDistributeWeight(element, avg) {
        // CHANGE STATUS
        if ( avg <= 0 ) element.parents('.innerCard').addClass('inactive');
        else element.parents('.innerCard').removeClass('inactive');
        // WEIGHT DISTRIBUTION
        let totlalInactiveWeight = 0, individualAddition = 0;
        let table = element.parents('form');
        let activeStatements = table.find('.innerCard').not('.inactive');
        let inactiveStatements = table.find('.innerCard.inactive');
        if ( inactiveStatements.length > 0 && activeStatements.length > 0 ) {
            inactiveStatements.each(function(){
                let weight = $(this).find('.weight');
                totlalInactiveWeight += parseInt(weight.attr('baseweight'));
                weight.val(-1);
            })
            individualAddition = totlalInactiveWeight / activeStatements.length;
            activeStatements.each(function() {
                let weight = $(this).find('.weight');
                let baseweight = parseInt(weight.attr('baseweight'));
                weight.val(baseweight + individualAddition);
            })
        } else {
            activeStatements.each(function() {
                let weight = $(this).find('.weight');
                let baseweight = parseInt(weight.attr('baseweight'));
                weight.val(baseweight);
            })
        }

        // console.log(
        //     {
        //         'activeStatements': activeStatements,
        //         'inactiveStatements': inactiveStatements,
        //         'totlalInactiveWeight': totlalInactiveWeight,
        //         'individualAddition': individualAddition
        //     }
        // );
        // return false;
    }
    function cloudVendorCategoryAvg(element) {
        var total = 0, cls = null, status = null;
        let form = element.parents('form');
        let catAvg = form.find('.cloudVendorCatAvg');
        let activeStatements = form.find('.innerCard').not('.inactive');

        activeStatements.each(function() {
            let statementAvg = parseFloat($(this).find('.cloudVendorControlStatementAvg').val());
            let weight = parseFloat($(this).find('.weight').val());
            total += statementAvg * (weight / 100);
            // console.log( {'statementAvg' : statementAvg, 'weight' : weight} );
        })
        if ( total ) total = total.toFixed(1);
        // ADD CLASS AND STATUS
        status = cloudVendorAvgStatus(total);

        catAvg.find('span').removeClass().addClass(status.cls).text(status.text).attr('data-original-title',total);
        catAvg.find('input').val(total);
        // console.log( {'total' : total} );
    }
    function cloudVendorAvgStatus(total) {
        let status = {};
        if ( total >= 5 )       { status.cls = 'bg-dark-blue'; status.text = 'OPTIMIZED'; }
        else if ( total >= 4 )  { status.cls = 'bg-light-blue'; status.text = 'MANAGED'; }
        else if ( total >= 3 )  { status.cls = 'bg-green'; status.text = 'DEFINED'; }
        else if ( total >= 2 )  { status.cls = 'bg-yellow'; status.text = 'REPEATABLE'; }
        else                    { status.cls = 'bg-red'; status.text = 'INITIAL'; }
        return status;
    }
    function cloudVendorFunctionAvg() {
        var counter=0, total = 0, avg = 0;
        $('.cloudVendorCatAvg input').each(function() {
            total += parseFloat($(this).val());
            counter++;
            // console.log( parseFloat($(this).val()) );
        })
        if ( total ) avg = (total / counter).toFixed(1);
        var status = cloudVendorAvgStatus(avg);
        // console.log( {'total':total, 'counter':counter, 'avg':avg, 'status':status} );
        $('.cloudVendorFuncAvg span').removeClass().addClass(status.cls).text(status.text).attr('data-original-title',avg);
    }
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
}(jQuery))
</script>