(function ( $ ) {
    $.fn.popupComment = function( options ) {
    	const commentModal = $('#commentModal');
    	const commentSave = commentModal.find('.saveBtn');
    	const commentEdit = commentModal.find('.editBtn');
        // This is the easiest way to have default options.
        var settings = $.extend({
        	element = '.bigComment',
        	excerpt = false,
        	colorChange = true,
        	modal = '#commentModal',
        	edit = '.editBtn',
        	save = '.saveBtn',
        	modalSize = 'default',
        	modalInverse = true,
        	commentEmptyMsg = 'Please add details.'
        	commentEmptyMsgClass = 'text-center'
        }, options );
        // Greenify the collection based on the settings variable.
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
	        commentArea.parents('form').find('.btn-success').click();
	        commentModal.modal('hide');
	    });
	    commentModal.on('hide.bs.modal', function() {
	        $('.bigComment.active').removeClass('active');
	        $(this).find('textarea').val('');
	    });
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
    };
}( jQuery ));