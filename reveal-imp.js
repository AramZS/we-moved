jQuery(document).ready(function() {

	if (zs_wm_closer == 'closable'){
		jQuery('body').prepend('<div id="movingAlong" class="reveal-modal">'
				+ '<p class="lead">'+zs_wm_msg+'</p>'
				+ '<a class="close-reveal-modal">&#215;</a>'
			+'</div>');
		
		jQuery('#movingAlong').reveal();	
	} else {
		jQuery('body').prepend('<div id="movingAlong" class="reveal-modal">'
				+ '<p class="lead">'+zs_wm_msg+'</p>'
			+'</div>');
			
		jQuery('#movingAlong').reveal({
			closeonbackgroundclick: false
		});	
	}
	if (zs_forward_link.length > 0){
		jQuery('#movingAlong').append('<p><a href="'+zs_forward_link+'" target="_self">Click here to continue.</a></p>');
	}
	// closeonbackgroundclick: true, 
});