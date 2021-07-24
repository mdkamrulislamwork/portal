<?php 
$playbooks = recplayGetCurrentItems($user_company_id);
$playbookPermission = recplayInputController();
$playbookLink = site_url('/recovery-playbook/');
// echo '<br><pre>'.print_r($playbooks, true).'</pre>'; 
?>
<div class="card">
    <div class="card-header-tabs-line scorecard-tab pb-8">
        <div class="custom-title" style="margin:10px 0 20px 0">
            <h1 class="title" style="text-transform: capitalize;line-height: 42px;">Current Playbooks</h1>
            <h6 class="sub-title"><span>Recovery Playbooks</span></h6>
        </div>
    </div>
    <!-- <img src="<?php// echo P3_TEMPLATE_URI; ?>/images//tabletop_exercise.png" alt="" class="img-responsive"> -->
    <div class="card-body">
    	<table class="table table-condensed panel-option-right bold">
    		<thead> <tr> <th class="bold">ID</th> <th class="bold">Name</th> <th class="bold">Date</th> <th></th> </tr> </thead>
    		<tbody>
    			<?php 
    			if ( empty($playbooks) ) { echo '<tr> <td colspan="3">Nothing Found</td> </tr>'; }
    			else {
    				foreach ($playbooks as $playbook) {
		    			$title = 'title';
		    			echo '<tr class="playbook playbook_'.$playbook->id.'">';
			    			echo '<td class="no-padding text-center">PL-'. $playbook->serial_no .'</td>';
			    			echo '<td>'. $playbook->app_name .'</td>';
			    			echo '<td>'. date( get_option('date_format'), strtotime($playbook->published_at) ) .'</td>';
			    			echo '<td class="text-right">';
                                echo ' <a class="btn btn-primary" href="'.$playbookLink.'?view=true&id='.$playbook->id.'" target="_blank" data-toggle="tooltip" title="View"><span class="fa fa-eye"></span></a>';
                                if ( $playbookPermission['edit'] ) echo ' <a class="btn btn-warning" href="'.$playbookLink.'?edit=true&id='.$playbook->id.'" target="_blank" data-toggle="tooltip" title="Edit"><span class="fa fa-edit"></span></a>';
                                if ( $playbookPermission['publish'] ) echo ' <a class="btn btn-danger delete-playbook" href="javascript:;" data-id="'. $playbook->id .'" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></a>';
                            echo '</td>';
		    			echo '</tr>';
    				}
    			}
    			?>
    		</tbody>
    	</table>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready( function( $ ) {
    "use strict";
    $(document).on('click', '.delete-playbook', function(e) {
        e.preventDefault();
        let button = $(this);
        let playbookId = button.attr('data-id');
        if ( !playbookId ) swal("Error!", "Something went wrong!", "error");
        else {
        	swal({
            title: "Are you sure?",
            text: "You will not be able to revert this action",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#4caf50",
            confirmButtonText: "Yes, Delete!",
            closeOnConfirm: false
        }, function() {
            jQuery.ajax({
                type: 'POST',
                url: object.ajaxurl + '?action=recplay_reset',
                cache: false,
                data: {id: playbookId, security: object.ajax_nonce },
                beforeSend: function() { button.prop('disabled',true); },
                success: function(response, status, xhr) {
                    console.log( response )
                    if (response == true) {
                        swal("Success!", "Deleted successfully.", "success");
                        setTimeout(function() { window.location.reload(); }, 2000)
                    } else {
                        swal("Error!", "Something went wrong.", "error");
                        button.prop('disabled',false);
                    }
                },
                error: function(error) {
                    button.prop('disabled',false);
                }
            })
        })
        }
    })
	// END OF DOCUMENT READY
})
</script>