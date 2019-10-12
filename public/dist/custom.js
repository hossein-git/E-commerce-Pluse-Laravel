$(document).ready(function() {
	
	// enable fileupload plugin
	$('input[name="files"]').fileuploader({
        onSelect: function(item) {
            if (!item.html.find('.fileuploader-action-start').length)
                item.html.find('.fileuploader-action-remove').before('<a class="fileuploader-action fileuploader-action-start" title="Upload"><i></i></a>');
        },
		upload: {
            url: 'php/ajax_upload_file.php',
            data: null,
            type: 'POST',
            enctype: 'multipart/form-data',
            start: false,
            synchron: true,
            onSuccess: function(result, item) {
                item.html.find('.fileuploader-action-remove').addClass('fileuploader-action-success');
            },
            onError: function(item) {
                item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                    '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                ) : null;
            },
            onComplete: null,
        },
		onRemove: function(item) {
			// send POST request
			$.post('./php/ajax_remove_file.php', {
				file: item.name
			});
		}
	});
	
});