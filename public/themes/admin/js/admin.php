<?php
session_start();
?>
/** admin vars **/
var admin = {};
admin.params = {};
admin.filters = {};

// adds get params to admin.params
(function () {
    var e,
        a = /\+/g,  // Regex for replacing addition symbol with a space
        r = /([^&=]+)=?([^&]*)/g,
        d = function (s) { return decodeURIComponent(s.replace(a, " ")); },
        q = window.location.search.substring(1);

    while (e = r.exec(q))
       admin.params[d(e[1])] = d(e[2]);
})();

/** onready events **/

$(document).ready(function(){

  	// enable dropdown
  	$('ul.nav').dropdown();

  	// enable active menu highlighting
  	$('#main_menu li').removeClass('active');

  	// login event
  	$('#login_form').submit(function(e){
		e.preventDefault();
		var form = jien.util.serializeForm($(this));
		$.post("/auth/login", form, function(res){
			if(res.status.code == 200){
				$().toastmessage('showSuccessToast', 'Success');
				window.location.href = form.redir;
			}else{
				$().toastmessage('showErrorToast', res.result.msg);
				$('#login_form input[name='+res.result.focus+']').focus();
			}
		});
	});

	$('#register_form').submit(function(e){
		e.preventDefault();
		var form = jien.util.serializeForm($(this));
		$.post("/auth/register", form, function(res){
			if(res.status.code == 200){
				$().toastmessage('showSuccessToast', 'Success');
				if(form.redir){
					window.location.href = form.redir;
				}
			}else{
				$().toastmessage('showErrorToast', res.result.msg);
				$('#register_form input[name='+res.result.focus+']').focus();
			}
		});
	});

	$('#user_login_show').click(function(e){
		$('.login_register_show').hide();
		$('.login_register').hide();
		$('#user_register_show').show();
		$('#user_login').show();
	});

	$('#user_register_show').click(function(e){
		$('.login_register_show').hide();
		$('.login_register').hide();
		$('#user_login_show').show();
		$('#user_register').show();
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

	admin.filterRedir = function(filters, params){
		var url = window.location.href;
		var q = url.split('?');
		var pairs = [];

		url = q[0];

		$.each(filters, function(k, filter){
			if(!filter.value){
				delete(params[filter.key]);
			}else{
				params[filter.key] = filter.value;
			}
		});
		$.each(params, function(k, v){
			pairs.push(k + '=' + v);
		});
		var query_string = '';
		query_string = pairs.join('&');
		if(query_string != ''){
			url += "?" + pairs.join('&');
		}
		window.location.href = url;
	};

	/* admin lists events */
	$('.filter.dropdown').change(function(e){
		e.preventDefault();
		var filter = $(this).attr('rel');
		var value = $(this).attr('value');
		admin.filterRedir([{key: filter, value: value}], admin.params);
	});

	// table sorter
	if(admin.params.order_by){
		var order_by = admin.params.order_by;
		var sort_by = admin.params.sort_by;
		var sort_class = '';
		if(sort_by == 'desc'){
			sort_class = 'headerSortUp';
		}else{
			sort_class = 'headerSortDown';
		}
		$(".header[rel='"+order_by+"']").addClass(sort_class);
	}

	$('.header').click(function(e){
		e.preventDefault();
		var field = $(this).attr('rel');
		var sort = '';
		if( $(this).hasClass('headerSortUp') ){
			sort = 'asc';
		}else{
			sort = 'desc';
		}
		admin.filterRedir([{key: 'order_by', value: field},{key: 'sort_by', value: sort}], admin.params);
	});

});