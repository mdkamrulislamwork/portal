<?php 
/* Template Name: Project Prioritization */
$companyId = advisory_get_user_company_id();
if ( !$companyId ) { wp_redirect(site_url('dashboard'), 302); exit();}
get_header();
$page_title = 'Project Prioritization';
$all = advisory_ppf_get_forms($companyId);
$assessments = advisory_get_active_forms($companyId, ['ppr']);
if ( !empty($assessments) ) $assessmentId = $assessments[0];
else $assessmentId = 0;
$ppf_page_url = site_url('project-proposal-form/');
$projectStatus = ['not_approved' => 'Not Approved', 'not_started' => 'Not Started', 'in_progress' => 'In Progress', 'complete' => 'Complete'];
//help($all);
?>
<style>
    .content-wrapper { font-size: 18px; font-weight: bold; color: #000; }
    .content-wrapper textarea {width: 100%;}
    .project_status_circle {
        height: 20px;
        width: 20px;
        border-radius: 50%;
        margin: 0 auto;
    }
</style>
<div class="content-wrapper">
    <div class="page-title">
        <div> <h1><img class="dashboardIcon" src="<?php echo get_template_directory_uri(); ?>/images/icon-rr.png" alt=""><?php echo $page_title; ?></h1> </div>
        <div> <ul class="breadcrumb"> <li><i class="fa fa-home fa-lg"></i></li> <li><a href="javascript:;"><?php echo $page_title; ?></a></li> </ul> </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <a href="<?php echo $ppf_page_url; ?>" class="btn btn-default">Create new</a>
        </div>
        <div class="col-sm-8">
            <ul class="list-inline">
                <?php foreach ( $projectStatus as $itemId => $itemName ) {
                    $itemBg = '<div class="project_status_circle '. advisory_ppf_project_status_bg($itemId).'" data-toggle="tooltip" title="'.$itemName.'" style="display:inline-block;">&nbsp;</div>';
                    echo '<li class="inline-item">'.$itemBg.' '.$itemName.'</li>';
                } ?>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered table-hover table-striped">
                <tr class="bg-dark">
                    <th style="background: #000;color: #fff">Project</th>
                    <th style="background: #000;color: #fff;width: 64px;">Status</th>
                    <th style="background: #000;color: #fff;width: 58px;">Rank</th>
                    <th style="background: #000;color: #fff">Description</th>
                    <th style="background: #000;color: #fff;width: 200px;">&nbsp;</th>
                </tr>
                <?php if ($all) {
                    foreach ($all as $item) {
                        $rank = project_prioritization_requirements($item->id);
                        if ($rank !=null) $item->prioritization_value = $rank->prioritization_value;;

                    }
                    usort($all, "cmp");
                    foreach ($all as $item) {
                        $project_prioritization = null;
                        if (property_exists($item,'prioritization_value')) $project_prioritization = $item->prioritization_value;
                        echo '<tr>';
                            echo '<td>'.$item->project_name.'</td>';
                            echo '<td> <div class="project_status_circle '. advisory_ppf_project_status_bg($item->project_status).'" data-toggle="tooltip" title="'.$projectStatus[$item->project_status].'">&nbsp;</div></td>';
                            echo '<td>'.$project_prioritization.'</td>';
                            echo '<td>'.$item->current_state.'</td>';
                            echo '<td class="text-center">';
                                echo ' <a class="btn btn-primary" href="'.$ppf_page_url.'?id='.$item->id.'&edit=false" data-toggle="tooltip" title="view"><span class="fa fa-eye"></span></a>';
                                echo ' <a class="btn btn-warning" href="'.$ppf_page_url.'?id='.$item->id.'&edit=true" data-toggle="tooltip" title="Edit"><span class="fa fa-edit"></span></a>';
                                echo ' <a class="btn btn-danger btn-delete-ppf" href="#" data-id="'.$item->id.'" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a>';
                                echo ' <a class="btn btn-success" href="'.site_url('ppr/'.$assessmentId.'/').'?ppf='.$item->id.'&edit=true" data-toggle="tooltip" title="Requirements">R</a>';
                            echo '</td>';
                        echo '</tr>';
                    }
                } ?>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript"> jQuery(document).ready(function($) {

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

})</script>
<?php
get_footer();
