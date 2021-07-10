<?php 
$tabletopItems = tabletop_get_published_items($user_company_id);
$permission = tabletopInputController();
$tabletopLink = site_url('tabletop');
?>
<div class="card">
    <img src="<?php echo P3_TEMPLATE_URI; ?>/images/tabletop/tabletop_exercise.png" alt="" class="img-responsive">
    <div class="card-body">
    	<table class="table table-condensed panel-option-right bold">
    		<thead> <tr> <th class="bold">Name</th> <th class="bold">Date</th> <th></th> </tr> </thead>
    		<tbody>
    			<?php 
    			if ( empty($tabletopItems) ) { echo '<tr> <td colspan="3">Nothing Found</td> </tr>'; }
    			else {
    				foreach ($tabletopItems as $tabletopItem) {
		    			$title = 'title';
		    			echo '<tr class="tabletop tabletop_'.$tabletopItem['id'].'">';
			    			echo '<td>'. $tabletopItem['plan_name'] .'</td>';
			    			echo '<td>'. date( get_option('date_format'), strtotime($tabletopItem['updated_at']) ) .'</td>';
			    			echo '<td class="text-right">';
                                echo ' <a class="btn btn-primary" href="'.$tabletopLink.'?view=true&id='.$tabletopItem['id'].'" target="_blank" data-toggle="tooltip" title="View"><span class="fa fa-eye"></span></a>';
                                if ( $permission['edit'] ) echo ' <a class="btn btn-warning" href="'.$tabletopLink.'?edit=true&id='.$tabletopItem['id'].'" target="_blank" data-toggle="tooltip" title="Edit"><span class="fa fa-edit"></span></a>';
                                if ( $permission['publish'] ) echo ' <a class="btn btn-danger delete-tabletop" href="javascript:;" data-id="'. $tabletopItem['id'] .'" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></a>';
                                
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
    $(document).on('click', '.delete-tabletop', function(e) {
        e.preventDefault();
        let button = $(this);
        let tabletopId = button.attr('data-id');
        if ( !tabletopId ) swal("Error!", "Something went wrong!", "error");
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
                url: object.ajaxurl + '?action=tabletop_delete',
                cache: false,
                data: {id: tabletopId, security: object.ajax_nonce },
                beforeSend: function() { button.prop('disabled',true); },
                success: function(response, status, xhr) {
                    console.log( response )
                    if (response == true) {
                        swal("Success!", "Deleted successfully.", "success");
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000)
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