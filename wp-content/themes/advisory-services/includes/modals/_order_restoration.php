<style type="text/css">
    #orderRestorationModal { font-size: 16px; }
    #orderRestorationModal .mainTitle {padding: 7px 10px;font-weight:bold;font-size: 22px;color: #fff;}
    #orderRestorationModal .title {padding: 7px 10px;font-weight:bold;font-size: 19px;color: #fff;margin-top: 10px;}
    #orderRestorationModal .table-bordered textarea {border:0; resize: none;}
    #orderRestorationModal .table-bordered textarea:focus {outline: none;}
</style>
<div class="modal fade" id="orderRestorationModal">
	<div class="modal-dialog modal-xlg">
    	<div class="modal-content modal-inverse">
        	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            	<h4 class="modal-title">
                    <span>Order of Restoration Table</span>
                    <small class="message"></small> 
                    <a href="#" class="hidden"><img style="width: 20px; float: right; margin-right: 15px;" src="<?php echo IMAGE_DIR_URL.'pdf/power_inverse.png' ?>"></a></h4>
        	</div>
        	<div class="modal-body" style="padding: 0 2px;">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td style="color:#000;font-style: italic;"> Instructions for recovery personnel that detail the restoration order of core infrastructure components. It should consider accound application dependencies, authentication, middleware, database and third-party elements and list restoration items by system or service type. Ensure this order of restoration in understood before engaging in recovery activities. </td>
                    </tr>
                </table>
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <td class="bg-palm-leaf title" style="padding: 0; text-align: center; width: 70px;">Ref.#</td>
                            <td class="bg-palm-leaf title" style="padding: 0; text-align: center; width: 265px;">Playbook</td>
                            <td class="bg-palm-leaf title" style="width: 200px;">Activity</td>
                            <td class="bg-palm-leaf title">System/Service Description</td>
                            <td class="bg-palm-leaf title" style="width: 75px;">Notes</td>
                            <?php if ($permission['edit']) { echo '<td class="bg-palm-leaf title" style="padding-right: 5px;width:110px"><button type="button" class="btn btn-sm btn-success pull-right btn-orderRestorationAdd"><span class="fa fa-lg fa-plus"></span> Add New</button></td>';
                            } else { echo '<td class="bg-palm-leaf title" style="padding-right: 5px;width:50px"></td>'; } ?>
                        </tr>
                    </thead>
                    <tbody><?php echo orderRestorationItemsHtml(); ?></tbody>
                </table> 
            </div>
        	<div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> </div>
    	</div>
	</div>
</div>
<?php echo orderRestorationNotesViewModal(); ?>
<?php echo orderRestorationNotesModal(); ?>
<script>
jQuery(function($) {
    "use strict"
    const permission = <?php echo json_encode($permission) ?>;
    const orderRestorationModal = $('#orderRestorationModal');
    const orderRestorationNotesModal = $('#orderRestorationNotesModal');
    const orderRestorationNotesModalSaveBtn = orderRestorationNotesModal.find('.saveBtn');
    const orderRestorationNotesViewModal = $('#orderRestorationNotesViewModal');

    // POPUP COMMENTS
    $(document).on('click', '.ortCommentView', function(event) {
        event.preventDefault();
        var commentHTML = $(this).find('textarea').val();

        orderRestorationNotesViewModal.find('.modal-body').html(commentHTML);

        tinymce();
        orderRestorationModal.modal('hide');
        orderRestorationNotesViewModal.modal('show');
    });
    orderRestorationNotesViewModal.on('hide.bs.modal', function() {
        orderRestorationModal.modal('show');
    });

    $(document).on('click', '.orderRestorationNotes', function(event) {
        event.preventDefault();
        $(this).addClass('focused');
        var commentHTML = $(this).find('textarea').val();

        var textareaSelector = orderRestorationNotesModal.find('.modal-body');
        textareaSelector.html('<textarea rows="18" style="width: 100%; padding: 10px;font-size: 16px;" class="no-border tinymce">'+ commentHTML +'</textarea>');

        tinymce();
        orderRestorationModal.modal('hide');
        orderRestorationNotesModal.modal('show');
    });
    orderRestorationNotesModalSaveBtn.on('click', function() {
        var commentArea = $('.orderRestorationNotes.focused');
        var commentHTML = tinyMCE.activeEditor.getContent();
        var commentAreaClass = commentHTML && commentHTML.length > 0 ? 'commentHTML' : '<p class="m-0 text-center">Please add details.</p>';
        // SET VALUES
        if ( commentHTML && commentHTML.length > 0 ) commentArea.removeClass('bg-green').addClass('bg-red');
        else commentArea.removeClass('bg-red').addClass('bg-greeen');
        commentArea.find('textarea').val(commentHTML);
        orderRestorationNotesModal.modal('hide');
        orderRestorationModal.modal('show');
    });

    // ORDER RESTORATION 
    $(document).on('click', '.orderRestoration', function(e) {
        orderRestorationModal.modal('show');
    })
    $(document).on('click', '.btn-orderRestorationAdd', function(e) {
        e.preventDefault();
        $('.orderRestorationInput').remove();
        let button = $(this);
        let table = $(this).parents('table');
        $.ajax({
            type: 'POST',
            url: object.ajaxurl + '?action=orderRestorationAdd',
            cache: false,
            data: { security: object.ajax_nonce },
            beforeSend: function() { button.prop('disabled',true).addClass('loading')},
            success: function(response, status, xhr) {
                table.find('tbody').prepend(response);
                button.prop('disabled',false).removeClass('loading');
            },
            error: function(error) {
                button.prop('disabled',false).removeClass('loading');
            }
        })
    })
    $(document).on('click', '.btn-orderRestorationCancel', function(e) {
        e.preventDefault();
        $(this).parents('tr').remove();
        $('.orderRestorationItem').removeClass('hidden');
        statusMessage(true, 'Operation cancelled');
    })

    $(document).on('change', '.orderRestorationInput select.playbook_id', function(event) {
        event.preventDefault();
        let app_name = $(this).children(':selected').attr('app_name');
        $(this).parents('tr').find('.app_name').text(app_name);
    });
    $(document).on('click', '.btn-orderRestorationSave', function(e) {
        e.preventDefault();
        let button = $(this);
        let row = button.parents('tr');
        let table = $(this).parents('table');
        let orderRestorationId = parseInt(row.find('.orderRestorationId').val());
        let playbook_id = parseInt(row.find('.playbook_id').val());
        let activity = row.find('.activity').val();
        let description = row.find('.description').val();
        let notes = row.find('.notes').val();

        $.ajax({
            type: 'POST',
            url: object.ajaxurl + '?action=orderRestorationSave',
            cache: false,
            data: { 'id': orderRestorationId, 'playbook_id':playbook_id, 'activity':activity, 'description':description, 'notes':notes, security: object.ajax_nonce },
            beforeSend: function() { button.prop('disabled',true).addClass('loading')},
            success: function(response, status, xhr) {
                console.log( response )
                if ( !response ) statusMessage()
                else {
                    row.remove();
                    // table.find('tbody').prepend(response);
                    table.find('tbody').html(response);
                    statusMessage(true);
                }
                button.prop('disabled',false).removeClass('loading');
            },
            error: function(error) {
                button.prop('disabled',false).removeClass('loading');
            }
        })
    })
    $(document).on('click', '.btn-orderRestorationEdit', function(e) {
        e.preventDefault();
        $('.orderRestorationInput').remove();
        let button = $(this);
        let row = $(this).parents('tr');
        let id = parseInt(row.attr('data-id'));
        if ( id ) {
            let table = $(this).parents('table');
            $.ajax({
                type: 'POST',
                url: object.ajaxurl + '?action=orderRestorationEdit',
                cache: false,
                data: { id: id, security: object.ajax_nonce },
                beforeSend: function() { button.prop('disabled',true).addClass('loading')},
                success: function(response, status, xhr) {
                    button.prop('disabled',false).removeClass('loading');
                    row.addClass('hidden');
                    table.find('tbody').prepend(response);
                },
                error: function(error) {
                    button.prop('disabled',false).removeClass('loading');
                }
            })
        }
    })
    $(document).on('click', '.btn-orderRestorationDelete', function(e) {
        e.preventDefault();
        let button = $(this);
        let row = button.parents('tr');
        let orderRestorationId = parseInt(row.attr('data-id'))
        let table = $(this).parents('table');
        if ( orderRestorationId ) {
            $.ajax({
                type: 'POST',
                url: object.ajaxurl + '?action=orderRestorationDelete',
                cache: false,
                data: { id: orderRestorationId, security: object.ajax_nonce },
                beforeSend: function() { button.prop('disabled',true).addClass('loading')},
                success: function(response, status, xhr) {
                    if ( !response ) statusMessage(); 
                    else {
                        row.remove();
                        statusMessage(true);
                    }
                },
                error: function(error) {
                    button.prop('disabled',false).removeClass('loading');
                }
            })
        }
    })
    function statusMessage(success=false, message='') {
        return false;
        let messageContainer = $('.message');
        if ( message ) {
            if ( !success ) messageContainer.html('<span class="btn-danger" style="padding:2px 5px;border-radius:3px;">'+message+'</span>');
            else messageContainer.html('<span class="btn-success" style="padding:2px 5px;border-radius:3px;">'+message+'</span>');
        } else {
            if ( !success ) messageContainer.html('<span class="btn-danger" style="padding:2px 5px;border-radius:3px;"> <strong>Error!</strong> Please try again</span>');
            else messageContainer.html('<span class="btn-success" style="padding:2px 5px;border-radius:3px;"> <strong>Success!</strong> Something cool updated</span>');
        }
        setTimeout(function() { messageContainer.find('span').fadeOut(800).delay(1000).prent('small').html('') }, 2000);
    }
    function tinymce() {
        tinyMCE.init({
            selector: '.tinymce',
            height: 450,
            plugins: 'lists link autolink code',
            toolbar: '"styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link code',
            menubar: false,
            branding: false,
            toolbar_drawer: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            content_style: ".mce-content-body { font-size:18px; font-family: 'Roboto', sans-serif; }",
        });
    }
    function orderRestorationItemsReset(argument) {
        $('.orderRestorationInput').remove();
        $('.orderRestorationItem').removeClass('hidden');
    }
})
</script>