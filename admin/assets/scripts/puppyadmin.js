$(document).ready(function() {

	/*-----------------------------------/
	/*	TOP NAVIGATION AND LAYOUT
	/*----------------------------------*/
	$('.btn-toggle-fullwidth').on('click', function() {
		if(!$('body').hasClass('layout-fullwidth')) {
			$('body').addClass('layout-fullwidth');

		} else {
			$('body').removeClass('layout-fullwidth');
			$('body').removeClass('layout-default'); // also remove default behaviour if set
		}

		$(this).find('.lnr').toggleClass('lnr-arrow-left-circle lnr-arrow-right-circle');

		if($(window).innerWidth() < 1025) {
			if(!$('body').hasClass('offcanvas-active')) {
				$('body').addClass('offcanvas-active');
			} else {
				$('body').removeClass('offcanvas-active');
			}
		}
	});

	$(window).on('load', function() {
		if($(window).innerWidth() < 1025) {
			$('.btn-toggle-fullwidth').find('.icon-arrows')
			.removeClass('icon-arrows-move-left')
			.addClass('icon-arrows-move-right');
		}

		// adjust right sidebar top position
		$('.right-sidebar').css('top', $('.navbar').innerHeight());

		// if page has content-menu, set top padding of main-content
		if($('.has-content-menu').length > 0) {
			$('.navbar + .main-content').css('padding-top', $('.navbar').innerHeight());
		}

		// for shorter main content
		if($('.main').height() < $('#sidebar-nav').height()) {
			$('.main').css('min-height', $('#sidebar-nav').height());
		}
	});


	/*-----------------------------------/
	/*	SIDEBAR NAVIGATION
	/*----------------------------------*/

	$('.sidebar a[data-toggle="collapse"]').on('click', function() {
		if($(this).hasClass('collapsed')) {
			$(this).addClass('active');
		} else {
			$(this).removeClass('active');
		}
	});


	/*-----------------------------------/
	/*	PANEL FUNCTIONS
	/*----------------------------------*/

	// panel remove
	$('.panel .btn-remove').click(function(e){

		e.preventDefault();
		$(this).parents('.panel').fadeOut(300, function(){
			$(this).remove();
		});
	});

	// panel collapse/expand
	var affectedElement = $('.panel-body');

	$('.panel .btn-toggle-collapse').clickToggle(
		function(e) {
			e.preventDefault();

			// if has scroll
			if( $(this).parents('.panel').find('.slimScrollDiv').length > 0 ) {
				affectedElement = $('.slimScrollDiv');
			}

			$(this).parents('.panel').find(affectedElement).slideUp(300);
			$(this).find('i.lnr-chevron-up').toggleClass('lnr-chevron-down');
		},
		function(e) {
			e.preventDefault();

			// if has scroll
			if( $(this).parents('.panel').find('.slimScrollDiv').length > 0 ) {
				affectedElement = $('.slimScrollDiv');
			}

			$(this).parents('.panel').find(affectedElement).slideDown(300);
			$(this).find('i.lnr-chevron-up').toggleClass('lnr-chevron-down');
		}
	);


	/*-----------------------------------/
	/*	PANEL SCROLLING
	/*----------------------------------*/

	if( $('.panel-scrolling').length > 0) {
		$('.panel-scrolling .panel-body').slimScroll({
			height: '430px',
			wheelStep: 2,
		});
	}

	if( $('#panel-scrolling-demo').length > 0) {
		$('#panel-scrolling-demo .panel-body').slimScroll({
			height: '175px',
			wheelStep: 2,
		});
	}

	/*-----------------------------------/
	/*	TODO LIST
	/*----------------------------------*/

	$('.todo-list input').change( function() {
		if( $(this).prop('checked') ) {
			$(this).parents('li').addClass('completed');
		}else {
			$(this).parents('li').removeClass('completed');
		}
	});

	/*-----------------------------------/
	/*	Admin Menu Editor
	/*----------------------------------*/
	if ($('#menu-selected-items').length > 0) {
		$('#menu-selected-items').nestable({
			group: 1,
			noDragClass: 'menu_item_remove'
		}).on('change', );
	}
	$('#menu-add-pages').click(function(e){
		e.preventDefault();
		$('#menu-available-pages input:checked').each(function(){
			var value = $(this).val();
			var caption = $(this).next('span').text();
			var url = $(this).data('menu_url');
            $('#menu-selected-items').nestable('add', {
            	"menu_file": value,
            	"menu_url": url,
            	"menu_title": caption,
            	"content": caption + '<span class="fa fa-close menu_item_remove"></span>'
            });
		});

		$('#menu-available-pages input:checked').prop('checked', false);
	});

	$('#menu-add-link').click(function(e){
		e.preventDefault();
		var url = $('#mal-url').val();
		var caption = $('#mal-text').val();
		
		if (url == "" || caption == "") {
			bootbox.alert('You need to provide both URL and Link Text properly.');
		} else {
	        $('#menu-selected-items').nestable('add', {
	        	"menu_file": "",
	        	"menu_url": url,
	        	"menu_title": caption,
	        	"content": caption + '<span class="fa fa-close menu_item_remove"></span>'
	        });

	        $('#mal-url').val("");
			$('#mal-text').val("");
		}
	});

	$('#menu-select-all').click(function(e){
		e.preventDefault();
		$('#menu-available-pages input').prop('checked', true);
	})

	$('#menu-submit').click(function(e){
		var menu_items = $('#menu-selected-items').nestable('serialize');
		$('#created-menu-array').val(JSON.stringify(menu_items));
	});

	$(document).on('click', '.menu_item_remove', function(e){
		e.preventDefault();
		if ($(this).closest('.dd-list').find('li').length < 2) {
			if (!$(this).closest('.dd-list').hasClass('menu-selected-items-list')) {
				$(this).closest('.dd-list').remove();
			}
		}

		$(this).closest('.dd-item').remove();
		
	});

	$('#testty').click(function(e){
		e.preventDefault();
		var val = $('#theme-file-editor').val();
		alert(val);
	});
});

// toggle function
$.fn.clickToggle = function( f1, f2 ) {
	return this.each( function() {
		var clicked = false;
		$(this).bind('click', function() {
			if(clicked) {
				clicked = false;
				return f2.apply(this, arguments);
			}

			clicked = true;
			return f1.apply(this, arguments);
		});
	});

}

// URL validation
function isUrlValid(url) {
    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
}



/*-----------------------------------/
/* Admin Page Editor
/*----------------------------------*/
function renameFile(current_name, name, path){
	bootbox.prompt({
		title : "Rename '"+current_name+"' into",
		value : current_name,
		callback: function(str){
			var type = typeof(str);
			if (str == "") {
	    		bootbox.alert("You must type a name.");
	    	} else if (str != "" && type != 'object') {
		        $.ajax({
				    type: "POST",
				    url: "functions.php",
				    data: "fileRename=" + str + "&oldName="+name + "&path="+path,
				    success : function(text){
			    	    bootbox.alert({
					        message: "File successfully renamed",
					        callback: function () {
					            window.location.reload();
					        }
					    })
				    }
				});
	    	}
		}
	});
}

function renameFolder(name, path){
	bootbox.prompt({
		title : "Rename '"+name+"' into",
		value : name,
		callback: function(str){
			var type = typeof(str);
			if (str == "") {
	    		bootbox.alert("You must type a name.");
	    	} else if (str != "" && type != 'object') {
		        $.ajax({
				    type: "POST",
				    url: "functions.php",
				    data: "renameFolder=" + str + "&oldFolder="+name + "&path="+path,
				    success : function(text){
			    	    bootbox.alert({
					        message: "Folder successfully renamed",
					        callback: function () {
					            window.location.reload();
					        }
					    });
				    }
				});
	    	}
		}
	});
}

function deleteFile(name, path) {
	bootbox.confirm({
		title: 'Delete File',
        message: 'Are you sure you want to delete "'+ name +'" file?',
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-danger'
            },
            cancel: {
                label: 'No',
                className: 'btn-default'
            }
        },
        callback: function (result) {
            if (result == true) {
            	$.ajax({
				    type: "POST",
				    url: "functions.php",
				    data: "deleteFile=" + name + "&path="+path,
				    success : function(text){
				    	bootbox.alert({
					        message: "File successfully removed!",
					        callback: function () {
					            window.location.reload();
					        }
					    });
				    }
				});
            }
        }
    });
}

function deleteFolder(name) {
	bootbox.confirm({
		title: 'Delete Folder',
        message: 'Are you sure you want to delete "'+ name +'" folder? You will lose everything inside it!',
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-danger'
            },
            cancel: {
                label: 'No',
                className: 'btn-default'
            }
        },
        callback: function (result) {
            if (result == true) {
            	$.ajax({
				    type: "POST",
				    url: "functions.php",
				    data: "deleteFolder=" + name,
				    success : function(text){
				    	bootbox.alert({
					        message: "Folder successfully removed!",
					        callback: function () {
					            window.location.reload();
					        }
					    });
				    }
				});
            }
        }
    });
}

function addNew(path) {
	bootbox.prompt({
		title : "Create a page <br/>use lower case text and spaces between words <br/>e.g.'my page name'",
		callback: function(str){
			var type = typeof(str);
			if (str == "") {
	    		bootbox.alert("You must type a name.");
	    	} else if (str != "" && type != 'object') {
		        $.ajax({
				    type: "POST",
				    url: "functions.php",
				    data: "addNew=" + str + "&path="+path,
				    success : function(text){
			    	    var loc = "edit.php?name="+ text;
				        window.location = loc;
				    }
				});
	    	}
		}
	});
}

function addFolder(path) {
	bootbox.prompt({
		title : "Create a folder<br/> use lower case text and spaces between words<br/> e.g.'my folder name'",
		callback: function(str){
			var type = typeof(str);
			if (str == "") {
	    		bootbox.alert("You must type a name.");
	    	} else if (str != "" && type != 'object') {
		        $.ajax({
				    type: "POST",
				    url: "functions.php",
				    data: "addFolder=" + str + "&path="+path,
				    success : function(text){
				    	bootbox.alert({
					        message: "Folder successfully created",
					        callback: function () {
					            window.location.reload();
					        }
					    });
				    }
				});
	    	}
		}
	});
}