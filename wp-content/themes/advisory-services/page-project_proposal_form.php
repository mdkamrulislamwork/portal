<?php 
/* Template Name: Project Proposal Form */
get_header();
$page_title = 'Project Proposal Form';
$companyId = advisory_get_user_company_id();
if ( !empty($_GET['id']) )
$default = !empty($_GET['id']) ? advisory_ppf_get_form_by($_GET['id']) : null;
$projectStatus = ['not_approved' => 'Not Approved', 'not_started' => 'Not Started', 'in_progress' => 'In Progress', 'complete' => 'Complete'];
$form_id = advisory_get_active_forms($companyId, ['ppr']);
?>
<style>
    .content-wrapper { font-size: 18px; font-weight: bold; color: #000; }
    .content-wrapper textarea {width: 100%;}
    .content-wrapper textarea:focus-visible { outline: none; }
    textarea,input{font-weight: normal;}

</style>
<div class="content-wrapper">
    <div class="page-title">
        <div> <h1><img class="dashboardIcon" src="<?php echo get_template_directory_uri(); ?>/images/icon-rr.png" alt=""><?php echo $page_title; ?></h1> </div>
        <?php if (!empty($default)) {
            echo '<div>';
                echo '<a class="btn btn-lg btn-info btn-publish-ppf" href="javascript:;" data-id="'.$default->id.'">Publish</a>';
                echo '<a class="btn btn-lg btn-success btn-save-all" href="javascript:;" data-id="'.$default->id.'">Save</a>';
                echo '<a class="btn btn-lg btn-danger btn-delete-ppf" href="javascript:;" data-id="'.$default->id.'">Delete</a>';
                if ( $default && !empty($form_id[0]) ) echo '<a class="btn btn-lg btn-primary" href="'.site_url('ppr/'.$form_id[0].'/').'?ppf='.$default->id.'&edit='.$_GET['edit'].'">Evaluation</a>';
            echo '</div>';
        } ?>
        <div> <ul class="breadcrumb"> <li><i class="fa fa-home fa-lg"></i></li> <li><a href="javascript:;"><?php echo $page_title; ?></a></li> </ul> </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <form class="projectProposalForm" method="post" data-id="<?php echo $companyId;?>">
                <?php if ( !empty($default) ) echo '<input type="hidden" name="ppf_id" value="'.$default->id.'">'; ?>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <table><tr><td style="width: 120px;background-color: #000;color: #fff; padding: 5px 0 5px 3px;">Project Name:</td> <td style="padding: 0"><input type="text" name="project_name" style="width: fit-content;height:40px;" value="<?php echo @$default->project_name; ?>"></td></tr></table>
                            </div>
                            <div class="col-sm-4 pull-right text-right" style="text-align: right;">
                                <level>Project Status:</level>
                                <select class="project_status <?php echo advisory_ppf_project_status_bg($default->project_status); ?>" name="project_status" style="width: 130px;padding: 3px 9px;">
                                    <?php foreach ($projectStatus as $itemId => $item ) {
                                        $selected = $itemId == $default->project_status ? ' selected' : '';
                                        echo '<option value="'.$itemId.'">'.$item.'</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-20">
                            <div class="col-sm-6">
                                <p style="background-color: #003d9b;color: #fff;margin-bottom: 0;padding: 8px 0 8px 8px;">Current State/Contenxt:</p>
                                <textarea required name="current_state" cols="30" rows="5"><?php echo @$default->current_state; ?></textarea>
                            </div>
                            <div class="col-sm-6">
                                <p style="background-color: #003d9b;color: #fff;margin-bottom: 0;padding: 8px 0 8px 8px;">Future State:</p>
                                <textarea required name="future_state" cols="30" rows="5"><?php echo @$default->future_state; ?></textarea>
                            </div>
                            <div class="col-sm-12 mt-20">
                                <p style="background-color: #003d9b;color: #fff;margin-bottom: 0;padding: 8px 0 8px 8px;">Proposed Solution:</p>
                                <textarea required name="proposed_solution" cols="30" rows="5"><?php echo @$default->proposed_solution; ?></textarea>
                            </div>
                        </div>
                        <div class="row mt-20">
                            <div class="col-sm-3">
                                <p style="background-color: #003d9b;color: #fff;margin-bottom: 0;padding: 8px 0 8px 8px;">Budget Impact</p>
                                <table class="table table-borderless m-0">
                                    <tr>
                                        <td style="width: 75px; background-color: #aad6f0;border-bottom: 10px solid #fff;border-top: 10px solid #fff;color: #000;"><small>Operating:</small></td>
                                        <td style="padding: 0 0 0 8px;"><input name="operating" type="text" style="width: 100%;height: 40px;" value="<?php echo @$default->operating; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 75px; background-color: #aad6f0;color: #000;border-bottom: 10px solid #fff;border-top: 10px solid #fff;"><small>Capital:</small></td>
                                        <td style="padding: 0 0 0 8px;"><input name="capital" type="text" style="width: 100%;height: 40px;" value="<?php echo @$default->capital; ?>"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-9">
                                <p style="background-color: #003d9b;color: #fff;margin-bottom: 0;padding: 8px 0 8px 8px;">Options:</p>
                                <textarea required name="options" cols="30" rows="3"><?php echo @$default->options; ?></textarea>
                            </div>
                        </div>
                        <div class="row mt-20">
                            <div class="col-sm-8">
                                <p style="background-color: #003d9b;color: #fff;margin-bottom: 0;padding: 8px 0 8px 8px;">Benefits and Measures:</p>
                                <textarea required name="benefits_and_measures" cols="30" rows="5"><?php echo @$default->benefits_and_measures; ?></textarea>
                            </div>
                            <div class="col-sm-4">
                                <p style="background-color: #003d9b;color: #fff;margin-bottom: 0;padding: 8px 0 8px 8px;">Resource Impacts:</p>
                                <textarea required name="resource_impacts" cols="30" rows="5"><?php echo @$default->resource_impacts; ?></textarea>
                            </div>
                        </div>
                        <div class="row text-right mt-10">
                            <div class="col-sm-12"><button type="submit" class="btn btn-md btn-success">Save</button></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript"> jQuery(document).ready(function($) {
    $(document).on('change', '.project_status', function (e){
        e.preventDefault();
        let cls = null;
        let status = $(this).val();
        if (status == 'not_approved') { cls = 'bg-blue'; }
        else if (status == 'not_started') { cls = 'bg-red'; }
        else if (status == 'in_progress') { cls = 'bg-orange'; }
        else if (status == 'complete') { cls = 'bg-green'; }
        else { cls = 'bg-red'; }
        $(this).removeClass().addClass('project_status '+cls);
    })
    jQuery('.btn-publish-ppf').on('click', function(e) {
		e.preventDefault()
        var formData = jQuery('.projectProposalForm').serialize();
        var formID = jQuery(this).attr('data-id');
		jQuery.post(object.ajaxurl + '?action=ppf_validate_form_submission', {
            data: formData,
			security: object.ajax_nonce
		}, function(response) {
            console.log(response);
			if (response == true) {
				swal({
					title: "Are you sure?",
					text: "You will not be able to revert this action",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#4caf50",
					confirmButtonText: "Yes, Publish!",
					closeOnConfirm: false
				}, function() {
					jQuery.post(object.ajaxurl + '?action=ppf_publish', {
						post_id: formID,
						security: object.ajax_nonce
					}, function(response) {
					    console.log(response);
						if (response == true) {
							swal("Success!", "Published Successfully.", "success");
							setTimeout(function() {window.location.href = object.home_url}, 2000)
						}
						else {
							swal("Error!", "Something went wrong.", "error");
						}
					})
				})
			} else {
				swal("Error!", "Please fill out all sections", "error")
			}
		})
	})
    jQuery('.btn-save-all').on('click', function(e) {
        e.preventDefault();
        jQuery('.projectProposalForm').submit();
    })
    jQuery('.btn-delete-ppf').on('click', function(e) {
		e.preventDefault()
		var postID = jQuery(this).attr('data-id')
		swal({
			title: "Are you sure?",
			text: "You want to delete this Project Proposal Form. You will not be able to revert this action",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#4caf50",
			confirmButtonText: "Delete",
			closeOnConfirm: false
		}, function() {
			jQuery.post(object.ajaxurl + '?action=ppf_delete', {
				post_id: postID,
				security: object.ajax_nonce
			}, function(response) {
				if (response == true) {
					swal("Success!", "Survey has been deleted.", "success")
					setTimeout(function() { window.location.reload() }, 2000)
				} else {
					swal("Error!", "Something went wrong.", "error")
				}
			})
		})
	})
    jQuery('.projectProposalForm').on('submit', function(e) {
		e.preventDefault()
		var formData = jQuery(this).serialize()
		var postID = jQuery(this).attr('data-id')
		jQuery(this).find('.btn-success').addClass('loading')
		jQuery.post(object.ajaxurl + '?action=ppf_save', {
			data: formData,
			post_id: postID,
			security: object.ajax_nonce
		}, function(response) {
		    console.log(response)
			jQuery('.btn-success').removeClass('loading')
			if (response == 'created') { jQuery.notify({title: "Update Complete : ", message: "Something cool is created!", icon: 'fa fa-check'}, {type: "success"}); setTimeout(function() {window.location.href = object.project_prioritization}, 2000); }
			else if (response == 'updated') { jQuery.notify({title: "Update Complete : ", message: "Something cool is just updated!", icon: 'fa fa-check'}, {type: "success"})}
			else { jQuery.notify({ title: "Update Failed : ", message: "Something wrong! Or you changed nothing!", icon: 'fa fa-times'}, {type: "danger"})}
		})
	})
})</script>
<?php
get_footer();
