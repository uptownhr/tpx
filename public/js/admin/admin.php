
/** onready events **/

$(document).ready(function(){

  	// enable dropdown
  	$('#profile').dropdown();

  	// enable active menu highlighting
  	$('#main_menu li').removeClass('active');

  	// login event
  	$('#login_form').submit(function(e){
		e.preventDefault();
		var form = site.util.serializeForm($(this));
		$.post("/auth/login", form, function(res){
			if(res.result.code == 200){
				window.location.href = '/admin/dashboard';
			}else{
				alert('invalid user/pass');
				$('#login_form input[name=username]').focus();
			}

		});
  	});

  	// logout event
  	$('.trig_logout').click(function(e){
  		e.preventDefault();
  		$.post("/auth/logout", function(res){
  			window.location.href = '/admin';
  		});
  	});

  	// save form event
  	$('form.trig_save').submit(function(e){
		e.preventDefault();
		var data = jien.util.serializeForm(this);
		$.post("/admin/data", data, function(res){
			if(res.status.code == 200){
				jien.ui.growl('Saved!');
				history.go(-1);
			}else{
				jien.ui.growl(res.status.text, 'error');
			}
		});
  	});

  	// delete event
  	$('a.trig_delete').click(function(e){
  		e.preventDefault();
  		var c = confirm('Are you sure?');
  		if(c){
	  		var opts = jien.util.parseRel($(this).attr('rel'));
	  		opts.cmd = 'delete';
	  		var self = this;
	  		$.post("/admin/data", opts, function(res){
	  			if(res.status.code == 200){
	  				jien.ui.growl('Deleted');
	  				$(self).parent().parent().slideUp();
	  			}else{
	  				jien.ui.growl(res.status.text, 'error');
	  			}
	  		});
  		}
  	});

  	// go back
  	$('.back').click(function(e){
  		e.preventDefault();
  		history.go(-1);
  	});

    // forms
    $(".datepicker").datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true, showAnim: 'fadeIn'});

    // wysiwyg
    var config = {
		toolbar_Basic: ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink']
	};
	$('.wysiwyg').ckeditor(config);


	/* admin lists events */

	$('.filter.dropdown').change(function(e){
		e.preventDefault();
		var url = window.location.href;
		var filter = $(this).attr('rel');
		var value = $(this).attr('value');
		var q = url.split('?');
		url = q[0];
		url += "?filter=" + filter + ":" + value;
		window.location.href = url;
	});


});