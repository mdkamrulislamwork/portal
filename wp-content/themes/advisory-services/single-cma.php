<?php 
get_header();
global $post;
$areaId = !empty($_GET['area']) ? $_GET['area'] : 1;
$domainId = !empty($_GET['domain']) ? $_GET['domain'] : 1;
$opts = get_post_meta($post->ID, 'form_opts', true);
$area_meta = !empty($opts['areas'][$areaId]) ? $opts['areas'][$areaId] : null;
$permission = cmaInputController();
$areaIcon = !empty($area_meta['icon_title']) ? '<img src="'. $area_meta['icon_title'] .'">' : '<img src="'. IMAGE_DIR_URL .'icon-cma.png">';
?>
<script src="<?php echo P3_TEMPLATE_URI. '/js/plugins/jquery.tinymce.min.js'; ?>"></script>
<div class="content-wrapper">
    <!-- Page Title -->
    <div class="page-title">
        <div> <h1>Cloud Maturity Assessment: <?php echo $area_meta['name'] ?></h1> </div>
        <?php if ( $permission['select_attr'] == '' ) { ?>
            <div>
                <?php if ( $permission['publish_btn'] == true ) {
                    if ( advisory_is_valid_form_submission($post->ID) ) {
                        echo '<a class="btn btn-lg btn-info btn-publish" href="#" data-id="' . $post->ID . '">Publish</a>';
                    } else {
                        echo '<a class="btn btn-lg btn-default btn-publish" href="#" data-id="' . $post->ID . '">Publish</a>';
                    }
                } ?>
                <!-- <a class="btn btn-lg btn-success btnSaveAllDisabled" href="#">Save All</a> -->
              <a class="btn btn-lg btn-success btn-save-all" href="#">Save All</a>

                <a class="btn btn-lg btn-warning btn-reset-all" href="#">Reset</a>
            </div>
        <?php } ?>
        <div>
            <ul class="breadcrumb">
                <li><i class="fa fa-home fa-lg"></i></li>
                <li><a href="#"><?php echo advisory_get_form_name($post->ID) ?></a></li>
                <li><a href="#"><?php echo $area_meta['name'] ?></a></li>
            </ul>
        </div>
    </div>
    <div class="panel">
        <div class="panel-body">
            <div class="panel-chart">
                <div class="row">
                    <div class="col-sm-5">
                        <?php echo cmaDomainMap($opts); ?>
                    </div>
                    <div class="col-sm-7 pl-0"> <img src="<?php echo IMAGE_DIR_URL. 'cma/top-right2.png'; ?>" alt=""> </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
    $str = '';
    $threatCatId = 'area_'.$areaId.'_threatcat';
    if ( !empty($opts[$threatCatId]) ) {
        foreach ( $opts[$threatCatId] as $threatCatSi => $threatCat ) {
            $threatId = $threatCatId.'_'.$threatCatSi.'_threat';
            $default = advisory_form_default_values($post->ID, $threatId);
            $avg = !empty($default['avg']) ? $default['avg'] : 0;
            $str .= '<div class="row">';
                $str .= '<div class="col-md-12">';
                    $str .= '<form class="survey-form single" method="post" data-meta="'. $threatId .'" data-id="'. $post->ID .'" data-areaid="'.$areaId.'">';
                        $str .= '<div class="card">';
                            $str .= '<div class="card-title-w-btn mb-0">';
                                $str .= '<h4 class="cmaTitle color-'.cmaCategoryColor($areaId).'"><img src="'.IMAGE_DIR_URL.'cma/icon-'. $areaId .'.png"><span>'. $area_meta['name'] .'</span></h4>';
                                $str .= '<div class="btn-group">';
                                    $str .= '<div class="btn btn-text">Average Rating: </div>';
                                    $str .= '<div class="btn btn-text btn-rating '.cmaAvgBackground($avg).'" style="margin-right:5px">'.$avg.'</div> ';
                                    $str .= '<div class="btn btn-primary btn-summary"><span class="fa fa-lg fa-list-alt"></span> Summary</div> ';
                                    if ($permission['select_attr'] == '') $str .= '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                $str .= '</div>';
                            $str .= '</div>';
                            $str .= '<div class="card-body">';
                            if ( !empty($opts[$threatId]) ) {
                                $threatCatDesc = !empty($threatCat['desc']) ? '<br><i> '.$threatCat['desc'].'</i>' : null;
                                $count = 1;
                                $str .= '<div class="table-responsive">';
                                $str .= '<table class="table table-bordered table-survey mb-0">
                                    <thead>';
                                        $str .= '<tr><th class="t-heading-dark" colspan="10" style="line-height: 1;"><big><strong>Domain: '.$threatCat['name'].'</strong></big>'.$threatCatDesc.'</th></tr>';
                                    $str .= '</thead>
                                    <tbody>';
                                        foreach ( $opts[$threatId] as $threatSi => $threat ) {
                                            $questionId = $threatId .'_'. $threatSi.'_question';
                                            $defaultCmm = isset($default[$questionId]) ? $default[$questionId] : 0;
                                            $info = isset($threat['info']) ? $threat['info'] : null;
                                            $isDisabled = empty($permission['question']) ? 'disabled ' : null;
                                            $isNotApplicable = $defaultCmm == -1 ? 'notApplicable' : null;
                                            $defaultComment = !empty($default[$questionId.'_comment']) ? $default[$questionId.'_comment'] : '';
                                            $commentCls = $defaultComment ? 'bg-black':'bg-light-black';
                                            $str .= '<tr id="'.$questionId.'" class="'.$isDisabled.$isNotApplicable.'">';
                                                $str .= '<td class="question">';
                                                    $str .= '<input type="hidden" name="'.$questionId.'" value="'. $defaultCmm .'">';
                                                    $str .= '<span class="index">'. $count . '. </span><span class="name">'.$threat['name'].'</span>';
                                                $str .= '</td>';
                                                $str .= '<td class="cmaNABtn">N/A <div class="btn-cma-na">X</div></td>';
                                                for ($i=0; $i <= 5; $i++) { 
                                                    $isAcitveBg = $defaultCmm == $i ? true : false;
                                                    $cmmClass = cmaDomainCMMBackground($i, $isAcitveBg);
                                                    $content = !empty($threat['cmm_'.$i]) ? $threat['cmm_'.$i] : null;
                                                    $str .= '<td class="cmaCMMBtn '. $cmmClass .'" value="'. $i .'" q-content="'.htmlspecialchars($content).'"> CMM '. $i .'</td>';
                                                }
                                                $str .= '<td class="cmmInfo" q-content="'.htmlspecialchars($info).'" title="Information"><button class="btn btn-info" type="button"'.( !$info ? ' disabled' : '' ).'><span class="fa fa-lg fa-info-circle"></span></button></td>';
                                                $str .= '<td class="bigComment '.$commentCls.'" title="Comment" style="padding:0;width:50px;" is_active="">';
                                                $str .= '<button class="btn btn-transparent" type="button"><span class="fa fa-lg fa-comment"></span></button>';
                                                $str .= '<textarea name="'.$questionId.'_comment" class="hidden">'.$defaultComment.'</textarea>';
                                                $str .= '</td>';
                                            $str .= '</tr>';
                                            $count++;
                                        }
                                    $str .= '</tbody>
                                </table>';
                                $str .= '</div>';
                            }
                            $str .= '</div>';
                            // TEMPORARY DATA TO INSERT ANOTHER FIELD
                            $userRole = $user_switching->get_old_user()->roles;
                            if ( false && array_intersect(['administrator', 'advisor'], $userRole ) ) {
                                if ( !empty($default['comment']) ) {
                                    $str .= '<br><h4>Old Comment: </h4>';
                                    $str .= '<div class="oldComment">'.$default['comment'].'</div>';
                                }
                            }
                            $str .= '<div class="card-footer text-right">';
                                $str .= '<input type="hidden" name="avg" class="hiddenAvg" value="'.  $avg .'">';
                                $str .= '<textarea name="comment" style="width:100%;height:100px;display:none;">'.@$default['comment'].'</textarea>';
                            $str .= '</div>
                        </div>
                    </form>
                </div>
            </div>';
        }
    }
$str .= '</div>';
// Modal
$str .= cmaSummaryModal();
$str .= cmaCmmModal();
$str .= cmaInformationModal();
$str .= editableCommentModal();
echo $str;
?>
<?php get_footer(); ?>
<script src="<?php echo P3_TEMPLATE_URI. '/js/plugins/jquery.tinymce.min.js'; ?>"></script>
<script>
(function($) {
    'use strict';
    const modal = $('#modal-cma');
    const infoModal = $('#cmmInfoModal');
    const commentModal = $('#commentModal');
    const commentSave = commentModal.find('.saveBtn');
    const commentEdit = commentModal.find('.editBtn');
    const activeComment = $('.bigComment.active');
    const permission = <?php echo json_encode($permission) ?>;

    $(document).on('click', '.btnSaveAll', function() {
        let button = $(this);
        button.attr('disabled', true);
        $('form.survey-form.single').each(function() {
            $(this).submit();
        })
        setTimeout(function() {
            button.attr('disabled', false);
        }, 4000);
    })
    $('#modal-cma .btn-save').on('click', function() {
        var button = $(this);
        var isActiveCSA = button.parents('.modal-footer').find('#areaSelect:checked').val();
        if (!isActiveCSA) alert('You haven\'t choose the option.');
        else {
            var questionRow = $( '#'+button.attr('area') );
            questionRow.find('input').val(button.attr('value'));
            setQuestionCMMBg(questionRow);
            cmaCalculateAvg(questionRow.parents('table'));
            modal.modal('hide');
        }
    });

    $(document).on('click', '.cmaNABtn', function(event) {
        event.preventDefault();
        var questionRow = null;
        var q_value = null;
        var questionRow = $(this).parents('tr');
        if ( !questionRow.is('.disabled')) {
            if ( questionRow.is('.notApplicable') ) {
                q_value = 0;
                questionRow.removeClass('notApplicable');
            } else {
                q_value = -1;
                questionRow.addClass('notApplicable');
            }
            questionRow.find('input').val(q_value);
            setQuestionCMMBg(questionRow);
            cmaCalculateAvg(questionRow.parents('table'));
        }
    });
    $(document).on('click', '.cmaCMMBtn', function(event) {
        event.preventDefault();
        var button = $(this);
        var questionRow = button.parents('tr');
        if ( !questionRow.is('.disabled') ) {
            var activeValue = button.parents('tr').find('input').val();
            if ( activeValue == -1 ) swal("Disabled item", "Please enable the question first", "info");
            else {
                var questionRowId = questionRow.attr('id');
                var itemValue = button.attr('value');

                modal.find('.modal-title').text(button.text());
                modal.find('.modal-body').html(button.attr('q-content'));
                modal.find('.btn-save').attr({'area':questionRowId, 'value': itemValue});

                if ( itemValue == activeValue ) modal.find('#areaSelect').prop('checked', true);
                else modal.find('#areaSelect').prop('checked', false);

                modal.modal('show');
            }
        }
    });
    
     $(".btn-save-all").on('click', function(){
       $("Form").each(function(){
        $(this).submit();
       });
    });
    
    
    modal.on('hide.bs.modal', function() {
        modal.find('.modal-title').text('');
        modal.find('.modal-body').html('');
        modal.find('#areaSelect').prop('checked', false);
        modal.find('.btn-save').attr({'area':'', 'value': ''});
    });
    // INFORMATION
    $(document).on('click', '.cmmInfo', function(event) {
        event.preventDefault();
        if ( !$(this).find('button').attr('disabled') ) {
            let question = $(this).parents('tr').find('.question .name').text();
            infoModal.find('.modal-title').text(question);
            infoModal.find('.modal-body').html($(this).attr('q-content'));
            infoModal.modal('show');
        }
    });
    // COMMENT
    $(document).on('click', '.bigComment', function(event) {
        event.preventDefault();
        $(this).addClass('active');
        commentEdit.addClass('hidden');
        commentSave.addClass('hidden');

        var comment = $(this).find('textarea');
        var commentHTML = comment.val();
        if ( !commentHTML || commentHTML.length < 1 ) commentHTML = '<p class="m-0 text-center">Please add details.</p>';
        var title = comment.attr('title');
        var textareaSelector = commentModal.find('.modal-body');
        var textarea = $(textareaSelector);
        var is_active = $('.bigComment.active').attr('isactive');

        commentModal.find('.modal-title').html(title);
        textarea.html('<div style="font-size: 16px; padding: 15px;">'+ commentHTML +'</div>');
        if (is_active && is_active.length > 0) commentEdit.addClass('hidden');
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
        if ( commentHTML && commentHTML.length > 0 ) commentArea.removeClass('bg-light-black').addClass('bg-black');
        else commentArea.removeClass('bg-black').addClass('bg-light-black');
        commentArea.find('textarea').val(commentHTML);
        commentArea.parents('form').submit();
        commentModal.modal('hide');
    });
    commentModal.on('hide.bs.modal', function() {
        $('.bigComment.active').removeClass('active');
        $(this).find('textarea').val('');
    });
    $(document).on('click', '.btn-summary', function() {
        let summary = '';
        let cmaSummaryModal = $('#cmaSummaryModal');
        let commentAreas = $(this).parents('.card').find('.card-body table tbody tr');
        commentAreas.each(function(index, element) {
            let questionSi = index + 1;
            let question = $(element).find('.question .name').text();
            let comment = $(element).find('.bigComment textarea').val();
            // console.log( {'question':question, 'comment':comment} )
            if ( comment && comment.length > 0 ) {
                summary += '<div class="summary summary_'+ questionSi +'">';
                    summary += '<h4 class="question">'+ questionSi +'. '+ question +'</h4>';
                    summary += '<div class="comment">'+ comment +'</div>';
                summary += '</div>';
            }
        })
        // console.log( summary )
        cmaSummaryModal.find('.modal-body').html(summary);
        cmaSummaryModal.modal('show');
    })
    // REQUIRE FUNCTIONS
    function cmaCalculateAvg(domain) {
        var total = 0, counter = 0, avg = 0, text = '', cls = '';
        var card = domain.parents('.card');
        domain.find('tbody tr').each(function(index, element) {
            let questionValue = parseInt($(element).find('input').val());
            if ( questionValue != -1 ) {
                total += questionValue;
                counter++;
            }
        });
        if ( counter > 0 ) {
            avg = (total / counter);
            if ( avg > 0 ) avg = avg.toFixed(1)
        }
        if ( avg >= 5 )     { text = 'Optimized'; cls  = 'bg-blue'; } 
        else if ( avg >= 4 ){ text = 'Measured'; cls  = 'bg-green'; }
        else if ( avg >= 3 ){ text = 'Defined'; cls  = 'bg-deepyellow'; }
        else if ( avg >= 2 ){ text = 'Repeatable'; cls  = 'bg-orange'; }
        else if ( avg >= 1 ){ text = 'Initial'; cls  = 'bg-red'; }
        else                { text = 'Legacy'; cls  = 'bg-black'; }

        console.log( {'total' : total, 'counter' : counter, 'avg' : avg, 'text' : text, 'cls' : cls })
        card.find('.btn-rating').removeClass().addClass('btn btn-text btn-rating '+cls).text(avg);
        card.find('.hiddenAvg').val(avg);
    }
    function cmaDomainCMMBackground(itemSi=0, hasAcitveBg=false) {
        if ( itemSi == 5 ) return hasAcitveBg ? 'bg-deepblue' : 'bg-blue';
        if ( itemSi == 4 ) return hasAcitveBg ? 'bg-deepgreen' : 'bg-light-green';
        if ( itemSi == 3 ) return hasAcitveBg ? 'bg-deepyellow' : 'bg-light-yellow';
        if ( itemSi == 2 ) return hasAcitveBg ? 'bg-orange' : 'bg-light-orange';
        if ( itemSi == 1 ) return hasAcitveBg ? 'bg-red' : 'bg-light-red';
        else               return hasAcitveBg ? 'bg-black' : 'bg-light-black';
    }
    function setQuestionCMMBg(questionRow) {
       var selectedValue = questionRow.find('input').val();
        questionRow.find('.cmaCMMBtn').each(function(index, element) {
            let hasAcitveBg = selectedValue == index ? true : false;
            let classes = 'cmaCMMBtn ' + cmaDomainCMMBackground(index, hasAcitveBg);
            // console.log( {'index' : index, 'selectedValue' : selectedValue, 'classes' : classes })
            $(element).removeClass().addClass(classes)
        })
    }
    function tinymce() {
        tinyMCE.init({
            selector: '.tinymce',
            height: 450,
            menubar: false,
            branding: false,
            // paste_as_text: true,
            toolbar_drawer: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            convert_fonts_to_spans: true,
            paste_retain_style_properties: "all",
            paste_convert_middot_lists: true,
            plugins: 'lists link autolink paste',
            toolbar: 'bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
            paste_word_valid_elements: "b,strong,i,em,h1,h2,u,p,ol,ul,li,a[href],span,color,font-size,font-color,font-family,mark,table,tr,td",
            content_style: ".mce-content-body {font-size:16px;line-height:1;font-family: 'Roboto', sans-serif;}",
            setup : function(editor) {
                editor.on("change keyup", function(e) {
                    editor.save(); // updates this instance's textarea
                    $(editor.getElement()).trigger('change'); // for garlic to detect change
                });
            }
        });
    }
}(jQuery))
</script>