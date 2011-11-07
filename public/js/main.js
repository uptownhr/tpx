	(function ($) {
	// VERTICALLY ALIGN FUNCTION
	$.fn.vAlign = function() {
		return this.each(function(i){
		var ah = $(this).height();
		var ph = $(this).parent().height();
		var mh = Math.ceil((ph-ah) / 2);
		$(this).css('margin-top', mh);
		});
	};
	})(jQuery);

$(document).ready(function() {
	

	Cufon.replace('#menu, .twitter-header a', { fontFamily: 'HelveticaSTDLightCondensed', hover: { color: '#EA2440' } } );
	Cufon.replace('#battle-menu li', { fontFamily: 'HelveticaSTDBlackCondensed', hover: { color: '#ffffff' } } );
	Cufon.replace('#battle-compare, .battle-username, #start-your-profile, .battle-stats, .widget h2, .rightcol h3, .middlecol, #login, #create-account,.home-question-top,.home-question,.home-question-stat,.home-question-answer,#twitter-header-title,.footer-list strong', { fontFamily: 'HelveticaSTDBlackCondensed' } );
	//	Cufon.replace('.home-question-answer', { fontFamily: 'HelveticaSTDBlackCondensed', fontStyle: 'italic' } );
	
	$('.middlecol .cat1,.rightcol .cat1, .middlecol .cat3,.rightcol .cat3').hide(); 
	$('.leftcol li:nth-child(2)').addClass('hit');
	
	$('.leftcol li div').hover(function() {
		$('.rightcol li').hide();
		var selector = '.rightcol li.' + $(this).attr('class');
		$(selector).show();
		$('.middlecol li').hide();
		var selector = '.middlecol li.' + $(this).attr('class');
		$(selector).show();
		$('.leftcol li').removeClass('hit');
		$(this).parent().addClass('hit');
	});
	
});