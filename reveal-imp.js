jQuery(document).ready(function() {
	jQuery('body').prepend('<div id="movingAlong" class="reveal-modal">'
			+ '<p class="lead">'+zs_wm_msg+'</p>'
			+ '<a class="close-reveal-modal">&#215;</a>'
		+'</div>');
		
	jQuery('#movingAlong').reveal();
});