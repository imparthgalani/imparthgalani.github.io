jQuery(function($){

	$(".delete-rate-reminder").click(function(el){
		el.preventDefault();
		var data = {
			_ajax_nonce: preloader_plus_rate_reminder.nonce,
			action: 'preloader_plus_update_rate_reminder',
			notice: preloader_plus_rate_reminder.notice,
			update: 'preloader_plus_delete_rate_reminder',
		};

		$.post(preloader_plus_rate_reminder.ajaxurl, data, function(res) {
			if( ! res.error) {
				$('.' + preloader_plus_rate_reminder.notice).remove();
			} else {
				console.log('There was an error on deleting reminder');
			}
		}).fail(function(xhr, textStatus, e) {
			console.log(xhr.responseText);
		});
	});

	$(".ask-later").click(function(el){
		el.preventDefault();
		var data = {
			_ajax_nonce: preloader_plus_rate_reminder.nonce,
			action: 'preloader_plus_update_rate_reminder',
			notice: preloader_plus_rate_reminder.notice,
			update: 'preloader_plus_ask_later',
		};

		$.post(preloader_plus_rate_reminder.ajaxurl, data, function(res) {
			if( ! res.error) {
				$('.' + preloader_plus_rate_reminder.notice).remove();
			} else {
				console.log('There was an error on deleting reminder ' + res.error_type);
			}
		}).fail(function(xhr, textStatus, e) {
			console.log(xhr.responseText);
		});
	});

});
