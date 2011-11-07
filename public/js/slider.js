$(document).ready(function() {

	var currentPosition = 0;
	var slideWidth = 640;
	var slideHeight = 405;
	var slideHeight2 = 135;
	var slideHeight3 = 135;
	var slides = $('.slide');
	var slides2 = $('.slide2');
	var slides3 = $('.slide3');
	var numberOfSlides = slides.length;
	var numberOfSlides2 = slides2.length;
	var numberOfSlides3 = slides3.length;
	
	// Remove scrollbar in JS
	$('#slidesContainer').css('overflow', 'hidden');
	$('#slidesContainer2').css('overflow', 'hidden');
	
	// Wrap all .slides with #slideInner div
	slides
	.wrapAll('<div id="slideInner"></div>')
	// Float left to display horizontally, readjust .slides width
	.css({
	  'float' : 'left',
	  'height' : slideHeight
	});
	
	slides2
	.wrapAll('<div id="slideInner2"></div>')
	// Float left to display horizontally, readjust .slides width
	.css({
	  'float' : 'left',
	  'height': slideHeight2
	});
	
	slides3
	.wrapAll('<div id="slideInner3"></div>')
	// Float left to display horizontally, readjust .slides width
	.css({
	  'float' : 'left',
	  'height': slideHeight3
	});
	
	var slidesContent = $('#slideInner').html();
	var slidesContent2 = $('#slideInner2').html();
	var slidesContent3 = $('#slideInner3').html();
	
	// Set #slideInner width equal to total width of all slides
	$('#slideInner').css('height', slideHeight * numberOfSlides);
	
	$('#slideInner2').css('height', slideHeight2 * numberOfSlides2);
	
	$('#slideInner3').css('height', slideHeight3 * numberOfSlides3);
	
	// Insert controls in the DOM
	$('#slideshow')
	.prepend('<span class="control" id="leftControl"></span>')
	.append('<span class="control" id="rightControl"></span>');
	
	var slide2Last = $(".slide2:last").html();
	var slide2First = $(".slide2:first").html();
	
	$('#slideInner2')
	.prepend('<div class="slide2">' + slide2Last +'</div>');
	 /* $('#slideInner2')
	.append('<div class="slide2">' + slide2First +'</div>'); */
	
	// $('#slideContainer2').prepend(slidesContent2);
	
	// Hide left arrow control on first load
	manageControls(currentPosition);
	
	// Create event listeners for .controls clicks
	$('.control')
	.bind('click', function(){
		abortTimer();
	// Determine new position
	currentPosition = ($(this).attr('id')=='rightControl') ? 	currentPosition+1 : currentPosition-1;
	
	// Hide / show controls
	manageControls(currentPosition);
	// Move slideInner using margin-left
	$('#slideInner').animate({
	  'marginTop' : slideHeight*(-currentPosition)
	});
	$('#slideInner2').animate({
	  'marginTop' : slideHeight2*(-currentPosition)
	});
	$('#slideInner3').animate({
	  'marginTop' : slideHeight3*(-currentPosition)
	});
	});
	
	// set interval
	var tid = setInterval(mycode, 5000);
	function mycode() {
		currentPosition++;
		if (currentPosition == numberOfSlides ) {
		//currentPosition = 0; 
		}	
		manageControls(currentPosition);
		$('#slideInner').animate({
			'marginTop' : slideHeight*(-currentPosition)
		});
		$('#slideInner2').animate({
			'marginTop' : slideHeight2*(-currentPosition)
		});
		$('#slideInner3').animate({
			'marginTop' : slideHeight3*(-currentPosition)
		});
	}
	function abortTimer() { // to be called when you want to stop the timer
	  clearInterval(tid);
	}
	
	var slidesCounter = 1;
	// manageControls: Hides and Shows controls depending on currentPosition
	function manageControls(position){
	// Hide left arrow if position is first slide
	if(position==0){ 
		$('#leftControl').hide() 
		//$("#slidesContainer").prepend(slidesContent);
		//$("#slidesContainer2").prepend(slidesContent2);
		// $("#slidesContainer3").prepend(slidesContent3);
	} else {
		$('#leftControl').show()
	}
		// Hide right arrow if position is last slide
	if(position==(numberOfSlides * slidesCounter) - 2){
		//$('#rightControl').hide();
		$("#slidesContainer").append(slidesContent);
		var temp = $("#slidesContainer2").html();
		$("#slideInner2").append(slidesContent2);
		$("#slidesContainer3").append(slidesContent3);
		slidesCounter++;
	}
	
	var currentselector = '#dot-' + position;
	$(".dot").removeClass("dot-on");
	$(currentselector).addClass("dot-on");
	
	}

});