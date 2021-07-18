<?php
$playbooks = recplayGetCurrentItems($user_company_id);
$playbookPermission = recplayInputController();
$playbookLink = site_url('/recovery-playbook/');
// echo '<br><pre>'.print_r($playbooks, true).'</pre>';
?>

<div class="modal fade" id="currentPlaybooks">
	<div class="modal-dialog modal-xl">
    	<div class="modal-content modal-inverse">
        	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            	<h4 class="modal-title">
                    <span>Current Playbooks</span>
                    <small class="message"></small>
                    <a href="#" class="hidden"><img style="width: 20px; float: right; margin-right: 15px;" src="<?php echo IMAGE_DIR_URL.'pdf/power_inverse.png' ?>"></a></h4>
        	</div>
        	<div class="modal-body" style="padding: 0 2px;">
<table class="table table-condensed panel-option-right bold">
    <thead> <tr> <th class="bold">ID</th> <th class="bold">Name</th> <th class="bold">Date</th> <th></th> </tr> </thead>
    <tbody>
    <?php if ( empty($playbooks) ) { echo '<tr> <td colspan="3">Nothing Found</td> </tr>'; }
    else {
        foreach ($playbooks as $playbook) {
            $title = 'title';
            echo '<tr class="playbook playbook_'.$playbook->id.'">';
            echo '<td class="no-padding text-center">PL-'. ($playbook->id * 10) .'</td>';
            echo '<td>'. $playbook->app_name .'</td>';
            echo '<td>'. date( get_option('date_format'), strtotime($playbook->published_at) ) .'</td>';
            echo '<td class="text-right">';
            echo ' <a class="btn btn-primary" href="'.$playbookLink.'?view=true&id='.$playbook->id.'" target="_blank" data-toggle="tooltip" title="View"><span class="fa fa-eye"></span></a>';
            if ( $playbookPermission['edit'] ) echo ' <a class="btn btn-warning" href="'.$playbookLink.'?edit=true&id='.$playbook->id.'" target="_blank" data-toggle="tooltip" title="Edit"><span class="fa fa-edit"></span></a>';
            if ( $playbookPermission['publish'] ) echo ' <a class="btn btn-danger delete-playbook" href="javascript:;" data-id="'. $playbook->id .'" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></a>';
            echo '</td>';
            echo '</tr>';
        }
    } ?>
    </tbody>
</table>
            </div>
        	<div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> </div>
    	</div>
	</div>
</div>
<script>
    jQuery(function($) {
        "use strict"
        $(document).on('click', '.currentPlaybooks', function (){
            $('#currentPlaybooks').modal('show');
        })
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


