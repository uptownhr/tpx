
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

    // forms
    $(".datepicker").datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true, showAnim: 'fadeIn'});

});