jQuery(document).ready(function($) {
	$('.menu-item-has-children').click(function(){
		// Remove class for root items not clicked
		$('.nav-main > .menu-item-has-children').not(this).removeClass('toggle-on');
		// Remove class for non-parent of target
		$(this).not().parents().removeClass('toggle-on');
		// Toggle class for target
		$(this).toggleClass('toggle-on');
	});
});