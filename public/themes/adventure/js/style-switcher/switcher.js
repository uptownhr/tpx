  jQuery(document).ready(function($) {
    $('#colorpicker').ColorPicker({
			onShow: function (colpkr) {
				$(colpkr).fadeIn("fast");
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut("fast");
				return false;
			},
			onChange: function (hsb, hex, rgb) {
        var color = hex;
        var defaultPattern = "url(../images/bg1.jpg)";
        $('body').css({
            backgroundColor: '#' + color,
            backgroundImage : defaultPattern
        });     
        $.cookie("portable_cookie_color", color);   
        $.cookie("portable_cookie_pattern", null);   
        $.cookie("portable_cookie_defaultBg", defaultPattern);   
			},
    
    });    
    
    $('#style-switcher a.color-box').each(function (i) {
        var a = $(this);
        a.css({
            backgroundColor: '#' + a.attr('data-rel')
        })
    })    
    

   var switcher_skins = $('#style-switcher a.color-box');
   var switcher_link = $('#skins-switcher');
   switcher_skins.each(function(i) {
    var color = $(this).attr('data-rel');
    var defaultPattern = "url(images/body-bg-1.png)";
     
      
   });  
   
     /*STYLESHEETS LOAD STARTS*/ 
   switcher_skins.click(function(e) {
    var color = $(this).attr('data-rel');
    var skins;
    var defaultPattern = "url(images/body-bg-1.png)";
    
    if (color == "e64135") {
      switcher_link.attr('href',"css/style.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }

	if (color == "b5da69") {
      switcher_link.attr('href',"css/green-theme.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }

	if (color == "7ccce5") {
      switcher_link.attr('href',"css/blue-theme.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }

	if (color == "556074") {
      switcher_link.attr('href',"css/dark-blue-theme.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }
	
	if (color == "b576ad") {
      switcher_link.attr('href',"css/purple-theme.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }

	
	if (color == "f7941d") {
      switcher_link.attr('href',"css/orange-theme.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }

		if (color == "fce482") {
      switcher_link.attr('href',"css/yellow-theme.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }
	
	if (color == "736357") {
      switcher_link.attr('href',"css/brown-theme.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }
	
	
		if (color == "776890") {
      switcher_link.attr('href',"css/dark-purple-theme.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }
	
	if (color == "dadd21") {
      switcher_link.attr('href',"css/dark-yellow-theme.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }
	
	if (color == "771111") {
      switcher_link.attr('href',"css/dark-red-theme.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }
	if (color == "e26fb5") {
      switcher_link.attr('href',"css/light-purple-theme.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }
	if (color == "de5328") {
      switcher_link.attr('href',"css/dark-orange-theme.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }
	
	if (color == "babc8e") {
      switcher_link.attr('href',"css/light-brown-theme.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }
	if (color == "d83737") {
      switcher_link.attr('href',"css/pure-red-theme.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }
	if (color == "197b30") {
      switcher_link.attr('href',"css/dark-green-theme.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }
	
	if (color == "ed145b") {
      switcher_link.attr('href',"css/purple-theme-new.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }
	
	if (color == "603913") {
      switcher_link.attr('href',"css/brown-theme-new.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }
	
	if (color == "111111") {
      switcher_link.attr('href',"css/dark-theme-new.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }
	if (color == "d3f3ff") {
      switcher_link.attr('href',"css/blue-theme-new.css");
      var atrrHref = switcher_link.attr('href');
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });   
    }
	/*STYLESHEETS LOAD ENDS*/
	
	
	
	
     
    $.cookie("portable_cookie_pattern", null);   
    $.cookie("portable_cookie_bgimage",null);

    $.cookie("portable_cookie_color", color);  
    $.cookie("portable_cookie_skins", atrrHref);
    $.cookie("portable_cookie_defaultBg", defaultPattern);    
    return false;
	
   });  
   
  var color = $.cookie("portable_cookie_color");
  var portable_skins = $.cookie("portable_cookie_skins");
  var defaultPattern = $.cookie("portable_cookie_defaultBg");
  var pattern = $.cookie("portable_cookie_pattern");
  
  if (portable_skins) {
    $("#skins-switcher").attr("href",portable_skins);
    $('body').css({
        backgroundColor: '#' + color,
        backgroundImage : pattern
    });
  }

  $('#style-switcher a.pattern-box').click(function (e) {
      e.preventDefault();
      var patternUrl = 'url(images/pattern/' + $(this).attr('data-rel') + '.png)';
      $('body').css({
          backgroundImage: patternUrl,
          backgroundRepeat: "repeat"
      });
      $.cookie("portable_cookie_bgimage",null);
      $.cookie("portable_cookie_pattern", patternUrl)
  });
  
  var defaultPattern = $.cookie("portable_cookie_defaultBg");
  var color = $.cookie("portable_cookie_color");
  var background = $.cookie("portable_cookie_bgimage");
  if (color) {
      $('body').css({
          backgroundColor: '#' + color,
          backgroundImage : defaultPattern
      });
  }
  var pattern = $.cookie("portable_cookie_pattern");
  if (pattern) {
      $('body').css({
          backgroundImage: pattern,
          backgroundRepeat: "repeat"
      });
  } else {
    if (background) {
        $('body').css({
          backgroundImage: background,
          backgroundRepeat: "repeat",
          backgroundPosition: "top center",
        
        });
    }    
  }  

  $('#style-switcher a.bg-box').each(function (i) {
    var backgroundUrl = 'url(images/' + $(this).attr('data-rel') + '.png)';
    var a = $(this);
      a.css({
          backgroundImage: backgroundUrl
      })
  })
    
  $('#style-switcher a.bg-box').click(function (e) {
      e.preventDefault();
      var backgroundUrl = 'url(images/' + $(this).attr('data-rel') + '.png)';
      $('body').css({
          backgroundImage: backgroundUrl,
          backgroundRepeat: "repeat",
        
        
      });
    $.cookie("portable_cookie_bgimage",backgroundUrl)
  });

  var background = $.cookie("portable_cookie_bgimage");
  if (background) {
      $('body').css({
        backgroundImage: background,
        backgroundRepeat: "repeat",
      
      
      });
  }
         
});   
 