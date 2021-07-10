<?php
get_header();
global $post;
$areaId = !empty($_GET['area']) ? $_GET['area'] : 1;
$threatCatId = 'area_'.$areaId.'_threatcat';
$opts = get_post_meta($post->ID, 'form_opts', true);
$area_meta = !empty($opts['areas'][$areaId]) ? $opts['areas'][$areaId] : null;
$permission = csmaInputController();
$areaIcon = !empty($area_meta['icon_title']) ? '<img src="'. $area_meta['icon_title'] .'">' : '<img src="'. IMAGE_DIR_URL .'icon-csma.png">';
$responses = ['0'=>'N/A', '1'=>'NO', '2'=>'YES', '3' => 'PARTIAL'];
$scores = ['0' => 'N/A', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'];
$company = advisory_get_user_company();
$titleBg = csmaFunctionBackground($areaId);
// echo '<br><pre>'.print_r('var', true).'</pre>'; exit();

$domains = cloudVendorDomains($opts);
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
                echo '<a class="btn btn-lg btn-success csma-save-all" data-id="'. $post->ID .'" href="javascript:;">Save All</a>';
                if ( $permission['publish'] ) echo '<a class="btn btn-lg btn-warning csma-reset-all" data-id="'. $post->ID .'" href="javascript:;">Reset</a>';
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

    $str = '';
    $str .= '<div class="row">';
        $str .= '<div class="col-md-12">';
            $str .= '<div class="card">';
                $str .= '<div class="card-body">';
                    $str .= '<div class="table-responsive">';
                        $str .= '<table class="table table-csmaFunction">';
                            $str .= '<tr>';
                            $str .= '<td class="functionTitle"><h2 class="title">Function: '.$area_meta['name'].' </h2>'.( !empty($area_meta['desc']) ? '<p class="subTitle">'.$area_meta['desc'].'</p>' : '' ).'</td>';
                            $str .= '<td class="csmaFuncAvg"><h4 class="title"> Function Average: </h4><span data-toggle="tooltip" data-placement="left" title=""></span></td>';
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
            $catAvgStatus = csmaAvgStatus($catAvg);
            $comment = !empty($default['comment']) ? $default['comment'] : null;
            $str .= '<div class="row">';
                $str .= '<div class="col-md-12">';
                    $str .= '<form class="survey-form" method="post" data-meta="'. $threatId .'" data-id="'. $post->ID .'">';
                        $str .= '<div class="card">';
                            $str .= '<div class="table-responsive mb-10">';
                                $str .= '<table>';
                                    $str .= '<tr>';
                                    $str .= '<td class="csmaCatTitle '.$titleBg['cat'].'">';
                                        $str .= '<h4 class="title">Category: '. $threatCat['name'] .'</h4>';
                                        if (!empty($threatCat['desc'])) $str .= '<p class="subTitle">'.$threatCat['desc'].'</p>';
                                    $str .= '</td>';
                                    $str .= '<td class="csmaCatAvg">';
                                        $str .= '<h4 class="title"> Category Average: </h4>';
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
                                        $desc = !empty($threat['desc']) && !empty(trim($threat['desc'])) ? ' <small>( '.$threat['desc'].' )' : '';
                                        $controlStatementAvg = !empty($default[$questionId.'_avg']) ? $default[$questionId.'_avg'] : 0;
                                        $defaultWeight = !empty($default[$questionId.'_weight']) ? $default[$questionId.'_weight'] : $threat['weight'];
                                        $controlStatementAvgStatus = csmaAvgStatus($controlStatementAvg);
                                        $questionCounter = 1;

                                        // $str .= '<br><pre>'.print_r($default, true).'</pre>';

                                        $str .= '<div class="card innerCard">';
                                            $str .= '<div class="card-body">';
                                                $str .= '<div class="table-responsive">';
                                                    $str .= '<table class="table table-bordered table-survey table-csmaControlStatement">
                                                        <thead>';
                                                            $str .= '<tr class="controlStatementRating">';
                                                                $str .= '<td colspan="5" class="no-border pl-0">';
                                                                    $str .= '<strong><big>Maturity Rating: </big> <span class="csmaControlStatementAvgStatus '.$controlStatementAvgStatus['cls'].'" data-toggle="tooltip" data-placement="right" title="'.$controlStatementAvg.'"> '.$controlStatementAvgStatus['text'].' </span></strong>';
                                                                    $str .= '<input type="hidden" name="'.$questionId.'_avg" class="csmaControlStatementAvg" value="'.$controlStatementAvg.'">';
                                                                    $str .= '<input type="hidden" name="'.$questionId.'_weight" class="weight" value="'.$defaultWeight.'" baseweight="'.$threat['weight'].'">';
                                                                $str .= '</td>';
                                                            $str .= '</tr>';
                                                            $str .= '<tr>';
                                                                $str .= '<th colspan="5" class="t-heading-dark controlStatementWrapper"><strong>Control Statement: '.$threat['name'].'</strong>'. $desc .'</th>';
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
                                                                    $str .= '<td class="no-padding score '.csmaScoreBg($defaultScore).'">'. advisory_opt_select($ansId.'_score', $ansId.'_score', '', $permission['attr'], $scores, $defaultScore) .'</td>';
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
    csmaFunctionAvg();
    $(document).on( 'change', '.score select', function() {
        let element = $(this);
        csmaScoreBg(element);
        csmaControlStagementAvg(element);
        csmaCategoryAvg(element);
        csmaFunctionAvg();
    })
    $(document).on( 'click', '.csma-save-all', function(e) {
        e.preventDefault();
        $('form').find('.btn-success').each(function(){
            $(this).click();
        })
    })
    $(document).on( 'click', '.csma-reset-all', function(e) {
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
                    url: object.ajaxurl + '?action=reset_csma',
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
    function csmaScoreBg(button) {
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
    function csmaControlStagementAvg(element) {
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
        csmaDistributeWeight(element, avg);
        // ADD CLASS AND STATUS
        status = csmaAvgStatus(avg);
        table.find('.csmaControlStatementAvgStatus').removeClass().addClass('csmaControlStatementAvgStatus '+ status.cls).text(status.text).attr('data-original-title',avg);
        table.find('.csmaControlStatementAvg').val(avg);
    }
    function csmaDistributeWeight(element, avg) {
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
    function csmaCategoryAvg(element) {
        var total = 0, cls = null, status = null;
        let form = element.parents('form');
        let catAvg = form.find('.csmaCatAvg');
        let activeStatements = form.find('.innerCard').not('.inactive');

        activeStatements.each(function() {
            let statementAvg = parseFloat($(this).find('.csmaControlStatementAvg').val())
            let weight = parseFloat($(this).find('.weight').val());
            total += statementAvg * (weight / 100);
            // console.log( {'statementAvg' : statementAvg, 'weight' : weight} )
        })
        if ( total ) total = total.toFixed(1);
        // ADD CLASS AND STATUS
        status = csmaAvgStatus(total);

        catAvg.find('span').removeClass().addClass(status.cls).text(status.text).attr('data-original-title',total);
        catAvg.find('input').val(total);
        // console.log( {'total' : total} )
    }
    function csmaAvgStatus(total) {
        let status = {};
        if ( total >= 5 )       { status.cls = 'bg-dark-blue'; status.text = 'OPTIMIZED'; }
        else if ( total >= 4 )  { status.cls = 'bg-light-blue'; status.text = 'MANAGED'; }
        else if ( total >= 3 )  { status.cls = 'bg-green'; status.text = 'DEFINED'; }
        else if ( total >= 2 )  { status.cls = 'bg-yellow'; status.text = 'REPEATABLE'; }
        else                    { status.cls = 'bg-red'; status.text = 'INITIAL'; }
        return status;
    }
    function csmaFunctionAvg() {
        var counter=0, total = 0, avg = 0;
        $('.csmaCatAvg input').each(function() {
            total += parseFloat($(this).val());
            counter++;
            // console.log( parseFloat($(this).val()) );
        })
        if ( total ) avg = (total / counter).toFixed(1);
        var status = csmaAvgStatus(avg);
        // console.log( {'total':total, 'counter':counter, 'avg':avg, 'status':status} );
        $('.csmaFuncAvg span').removeClass().addClass(status.cls).text(status.text).attr('data-original-title',avg);
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