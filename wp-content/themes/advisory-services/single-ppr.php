<?php
get_header();
global $user_switching;
$ppf = advisory_ppf_get_form_by($_GET['ppf']);
if ($ppf) :
$transient_post_id = get_the_ID();
$opts = get_post_meta($transient_post_id, 'form_opts', true);
$permission = advisory_ppr_input_controller();
$projectStatus = ['not_approved' => 'Not Approved', 'not_started' => 'Not Started', 'in_progress' => 'In Progress', 'complete' => 'Complete'];
$ppr = advisory_ppr_get_form_by($ppf->id);
$prioritization_value = !empty($ppr->prioritization_value) ? $ppr->prioritization_value : 0;

//help($ppr);
$questionOptions = ['No', 'Yes'];
?>
<style>
    .table-borderless table.table tr td{ border: 0; }
    .heading table.table tr td{ font-size: 18px; font-weight: bold; }
    .heading table.table tr td #prioritization_value{ font-size: 22px; color: #fff;padding: 5px 0;}
    .table-responsive table.table tr td{ font-size: 17px; }
    .table-responsive table.table tr td#ppr_answer{padding:  0px;}
    .table-responsive table.table tr td#ppr_answer select.answer{padding: 0px;text-align-last:center;}
    .table-responsive table.table tr td#ppr_note{padding: 0px;}
    .border-bottom-only{ border-top-color: transparent !important; border-left-color: transparent !important; border-right-color: transparent !important; }
    .card{padding: 20px 20px 20px 10px;}
</style>
<script src="<?php echo P3_TEMPLATE_URI. '/js/plugins/jquery.tinymce.min.js'; ?>"></script>
<div class="content-wrapper">
    <div class="page-title">
        <div> <h1>Project Evaluation</h1> </div>
        <?php if ($permission['edit']) {
            echo '<div>';
                echo '<a class="btn btn-lg btn-info" href="'.site_url('project-prioritization/').'">Prioritizations</a>';
                echo '<a class="btn btn-lg btn-success btn-save" href="#">Save</a>';
                if ($permission['reset']) echo '<a class="btn btn-lg btn-warning btn-reset" href="javascript:;"  data-id="'.$ppr->id.'">Reset</a>';
                echo '<a class="btn btn-lg btn-primary" href="'.site_url('project-proposal-form/').'?id='.$ppf->id.'&edit='.@$_GET['edit'].'">Form</a>';
            echo '</div>';
        } ?>
        <div>
            <ul class="breadcrumb">
                <li><i class="fa fa-home fa-lg"></i></li>
                <li><a href="javascript:;">Project Prioritization Requirements</a></li>
            </ul>
        </div>
    </div>
    <!--PAGE TITLE END-->
    <img src="<?=get_template_directory_uri().'/images/single-ppr/header_image_evaluation.png'?>" alt="">
    <?php
    /*echo '<div class="row">';
        echo '<div class="col-md-8">';
            echo '<div class="card">';
                echo '<div class="card-body heading">';
                    echo '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>';
                    echo '<div class="bg-black" style="height: 6px;margin-bottom: 15px;"></div>';
                    echo '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.</p>';
                    echo '<p>Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>';
                    echo '<p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>';
                    echo '<div class="bg-black" style="height: 15px;margin-bottom: 0px;"></div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

    echo '<div class="row">';
        echo '<div class="col-md-8">';
            echo '<div class="card">';
                echo '<div class="card-body heading">';
                    echo '<table class="table m-0 table-borderless">';
                        echo '<tr>';
                            echo '<td>';
                                echo '<div style="background-color: #0c0c0c;color: #f9f9f9;padding: 8px 3px;margin-bottom: 10px;font-weight: normal;"><b>Project Name:</h3></b><span style="font-weight: normal;"> '.$ppf->project_name.'</span></div>';
                                echo '<div class="status_container"><span style="color: #f9f9f9;background-color: #0c0c0c;padding: 4px 3px;">Status:</span> <div id="ppf_status" class="'.advisory_ppf_project_status_bg($ppf->project_status).'" style="display: inline-block; padding: 2px 5px; ">'.$projectStatus[$ppf->project_status].'</div></div>';
                            echo '</td>';
                            echo '<td style="width: 175px;">Prioritization Value</td>';
                            echo '<td class="no-padding" style=" width: 75px; text-align: center;"><div id="prioritization_value" class="bg-black">'.$prioritization_value.'</div></td>';
                        echo '</tr>';
                    echo '</table>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';*/
    if ( !empty($opts['areas']) ) {
        echo '<form class="form" method="post" data-id="'. $ppf->id .'">';
            //echo '<input type="hidden" id="prioritization_value" value="0">';
            foreach ( $opts['areas'] as $areaSi => $area ) {
                $threatCatId = 'area_'.$areaSi . '_threatcat';
                if ( !empty($opts[$threatCatId]) ) {
                    echo '<div class="row">';
                        echo '<div class="col-md-8">';
                            echo '<div class="card">';
                                echo '<div class="card-title-w-btn mb-5"">';
                                    echo '<h4 class="title" style="background-color: #0c0c0c;color: #f9f9f9;padding: 10px 150px 10px 5px;min-width: 400px;">'. @$area['name'] .'</h4>';
                                    if ($permission['edit']) echo '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                echo '</div>';
                                echo '<div class="card-body ppr-categories" style="padding-bottom: 10px;">';
                                    foreach ( $opts[$threatCatId] as $threatCatSi => $threatCat ) {
                                        $threatId = $threatCatId.'_'.$threatCatSi.'_threat';
                                        if ( !empty($opts[$threatId]) ) {
                                            echo '<div class="table-responsive">';
                                                 echo '<table class="table table-bordered">';
                                                    echo '<tr>';
                                                        echo '<td class="border-bottom-only pl-0" style="padding-bottom: 20px;"><strong style="background-color: #a45000;color: #f9f9f9;padding: 15px 140px 15px 5px;">'.$threatCat['name'].'</strong></td>';
                                                        echo '<td class="border-bottom-only" style="width: 70px;"><strong>Yes/No</strong></td>';
                                                        echo '<td class="border-bottom-only" style="width: 70px;"><strong>Notes</strong></td>';
                                                    echo '</tr>';
                                                    foreach ($opts[$threatId] as $threatSi => $threat) {
                                                        $questionId = $threatId . '_' . $threatSi . '_question';
                                                        $answer_weight = $threat['value'] ? $threat['value'] : 0;
                                                        $answer_val = !empty($ppr->requirements[$questionId . '_answer']) ? $ppr->requirements[$questionId . '_answer'] : 0;
                                                        $note = !empty($ppr->requirements[$questionId . '_note']) ? $ppr->requirements[$questionId . '_note'] : '';
                                                        echo '<tr>';
                                                            echo '<td>'.$threat['name'].'</td>';
                                                            echo '<td id="ppr_answer" class="'.advisory_ppr_answer_bg($answer_val).'" data-weight="'.$answer_weight.'">'.advisory_opt_select($questionId.'_answer', $questionId.'_answer', 'answer', $permission['attr'], $questionOptions, $answer_val).'</strong></td>';
                                                            echo '<td class="bigComment '.advisory_ppr_answer_bg($note).'" isactive="'.$permission['attr'].'">';
                                                                echo '<textarea class="hidden commentText" name="'.$questionId . '_note'.'">'. htmlentities($note).'</textarea>';
                                                            echo '</td>';
                                                        echo '</tr>';
                                                    }
                                                 echo '</table>';
                                            echo '</div>';
                                        }
                                    }
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }
            }
        echo '</form>';
    } ?>
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
    $(document).on('change', '#ppr_answer select', function(event) {
        event.preventDefault();
        advisory_ppr_answer_bg($(this));
        advisory_ppr_prioritization_value();
    });
    function advisory_ppr_answer_bg(element) {
        if ( parseInt(element.val()) ) element.parent().removeClass('bg-green').addClass('bg-red');
        else element.parent().removeClass('bg-red').addClass('bg-green');
    }
    function advisory_ppr_prioritization_value() {
        let total = 0;
        let categories = 1;
        $('.ppr-categories').each(function(index, catItem) {
            let ppr_answers_total = 0;
            $(catItem).find('#ppr_answer select').each(function (selectIndex) {
                if ( parseInt($(this).val()) ) ppr_answers_total = ppr_answers_total + parseInt($(this).parent().attr('data-weight'));
            })
            if( ppr_answers_total > 0 ) categories = ppr_answers_total * categories;
            //console.log([ppr_answers_total, categories])
        })
        // $('#ppr_answer select').each(function () {
        //     if ( parseInt($(this).val()) ) total = total + parseInt($(this).parent().attr('data-weight'));
        // })
        $('#prioritization_value').html(categories);
    }

    // FORM
    $(document).on('submit', 'form.form', function (e){
        e.preventDefault();
        let button = $('.btn-success');
        let data = $(this).serialize();
        let prioritization_value = parseInt($('#prioritization_value').text());
        let project_proposal_form_id = parseInt($(this).attr('data-id'));

        $.ajax({
            type: 'POST',
            url: object.ajaxurl + '?action=ppr_save',
            cache: false,
            data: { 'project_proposal_form_id': project_proposal_form_id, 'data':data, 'prioritization_value':prioritization_value, security: object.ajax_nonce },
            beforeSend: function() { button.prop('disabled',true).addClass('loading')},
            success: function(response, status, xhr) {
                jQuery.notify({title: "Update Complete : ", message: "Something cool is just updated!", icon: 'fa fa-check'}, {type: "success"})
                button.prop('disabled',false).removeClass('loading');
            },
            error: function(error) {
                jQuery.notify({ title: "Update Failed : ", message: "Something wrong! Or you changed nothing!", icon: 'fa fa-times'}, {type: "danger"})
                button.prop('disabled',false).removeClass('loading');
            }
        })
    })

    // TOP BUTTONS
    jQuery('.btn-save').on('click', function(e) {
        e.preventDefault();
        jQuery('form.form').submit();
    })
    jQuery('.btn-reset').on('click', function(e) {
		e.preventDefault()
		var postID = jQuery(this).attr('data-id')
		swal({
			title: "Are you sure?",
			text: "You want to delete this Project Prioritization Requirements. You will not be able to revert this action",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#4caf50",
			confirmButtonText: "Delete",
			closeOnConfirm: false
		}, function() {
			jQuery.post(object.ajaxurl + '?action=ppr_delete', {
				post_id: postID,
				security: object.ajax_nonce
			}, function(response) {
				if (response == true) {
					swal("Success!", "Project Prioritization Requirements has been deleted.", "success")
					setTimeout(function() { window.location.reload() }, 2000)
				} else {
					swal("Error!", "Something went wrong.", "error")
				}
			})
		})
	})

    // COMMENT
    const commentModal = $('#commentModal');
    const commentModalSave = commentModal.find('.saveBtn');
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

        if ( commentHTML.length > 0 ) { commentArea.removeClass('bg-green').addClass('bg-red'); }
        else { commentArea.removeClass('bg-red').addClass('bg-green'); }
        commentArea.find('.commentText').val(commentHTML);
        console.log( [commentHTML] );
        commentModal.modal('hide');
    });
    commentModal.on('hide.bs.modal', function() {
        $('.bigComment.active').removeClass('active');
        $(this).find('textarea').val('');
    });
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
<?php endif; get_footer(); ?>