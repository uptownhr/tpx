$(document).ready(function() {

	var next = 2;
	
	$('.battle-photo-cont').click(function() {
		var clicked = $(this).parent().attr('id');
		if (clicked == 'battle-girl1') {
			var change = '#battle-girl2 img';
		} else {
			var change = '#battle-girl1 img';
		}
		var nextimg = 'images/layout/battle/battle_' + next + '.jpg';
		$(change).attr('src',nextimg);
		next++;
		if (next == 11) {
			next = 0;
		}
	});
	
});