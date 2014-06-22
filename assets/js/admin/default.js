// Init vars
var closedBoxesCookiePrefix = "DefaultClosedBoxes_";
var boxPositionCookiePrefix = "DefaultColumnBoxes_";
var deletedBoxesCookiePrefix = "DefaultDeletedBoxes_";
var themeCookie = "DefaultTheme";
var menuCookie = "DefaultMenu";
var cookieExpiration = 365;

var screenWidth = $(document).width();
var screenHeigth =  $(document).height();

// check for theme cookie first and switch theme
$(document).ready(function(){
	var themeCkie = $.cookie(themeCookie);
	if (themeCkie && themeCkie != '')	{
		switchTheme(null, themeCkie);
	}
	
	// menu cookie
	var menuCkie = $.cookie(menuCookie);
	if (menuCkie && menuCkie != '')	{
		
		if(menuCkie == 2) {
			$(".sidenav-style-2").parent().parent().attr("class","nav nav-tabs nav-stacked");		
			$(".sidenav-style-2").parent().parent().parent().removeClass("well");
		}
	}
});



$(document).ready(function(){
	
	// switch menu style
	$(".sidenav-style-1").click(function(e){
		// modify overlaying div
		$(this).parent().parent().attr("class","nav nav-list");
		if(!$(this).parent().parent().parent().hasClass("well")) {
			$(this).parent().parent().parent().addClass("well");		
		}
		$.cookie(menuCookie, "1", { expires: cookieExpiration });
	});
	
	// switch menu style
	$(".sidenav-style-2").click(function(e){
		// modify overlaying div
		$(this).parent().parent().attr("class","nav nav-tabs nav-stacked");		
		$(this).parent().parent().parent().removeClass("well");
		$.cookie(menuCookie, "2", { expires: cookieExpiration });		
	});
	
	// Control funtion for portlet (box) buttons clicks
	function setControls(ui) {		
		//$('[class="box-btn"][title="toggle"]').click(function() {
		$('.box-btn').click(function() {
			var e = $(this);
			//var p = b.next('a');
			// Control functionality
			switch(e.attr('title').toLowerCase()) {
				case 'config':
					widgetConfig('b', 'p');
					break;
				
				case 'toggle':
					widgetToggle(e);
					break;
				
				case 'close':
					widgetClose(e);
					break;
			}
		});
	}
	
	// Toggle button widget
	function widgetToggle(e) {
		// Make sure the bottom of the box has rounded corners
		e.parent().toggleClass("round-all");
		e.parent().toggleClass("round-top");
		
		// replace plus for minus icon or the other way around
		if(e.html() == "<i class=\"icon-plus\"></i>") {
			e.html("<i class=\"icon-minus\"></i>");
		} else {
			e.html("<i class=\"icon-plus\"></i>");
		}
		
		// close or open box	
		e.parent().next(".box-container-toggle").toggleClass("box-container-closed");
		
		// store closed boxes in cookie
		var closedBoxes = [];
		var i = 0;
		$(".box-container-closed").each(function() 
		{
				closedBoxes[i] = $(this).parent(".box").attr("id");
				i++;		
		});
		$.cookie(closedBoxesCookiePrefix + $("body").attr("id"), closedBoxes, { expires: cookieExpiration });
        
		//Prevent the browser jump to the link anchor
		return false; 
		
	}
	
	// Close button widget with dialog
	function widgetClose(e) {
		// get box element
		var box = e.parent().parent();
		
		// prompt user to confirm
		bootbox.confirm("Are you sure?", function(confirmed) {
			// remove box
			box.remove();
			
			// store removal in cookie
			$.cookie(deletedBoxesCookiePrefix + $("body").attr("id") + "_" + box.attr('id'), "yes", { expires: cookieExpiration });
   		});	
	}
	
	$('#box-close-modal .btn-success').click(function(e) {
		   // e is the element that triggered the event
		   console.log(e.target); // outputs an Object that you can then explore with Firebug/developer tool.
		   // for example e.target.firstChild.wholeText returns the text of the button
		});
	
	// Modify button widget
	function widgetConfig(w, p) {		
		$("#dialog-config-widget").dialog({
			resizable: false,
			modal: true,
			width: 500,
			buttons: {
				"Save changes": function(e, ui) {
					/* code the functionality here, could store in a cookie */					
					$(this).dialog("close");
				},
				Cancel: function() {					
					$(this).dialog("close");
				}
			}
		});
	}$('#tab').tab('show');
	
	// set portlet comtrols
	setControls();
	
	// Portlets (boxes)
    $(".column").sortable({
        connectWith: '.column',
		iframeFix: false,
		items:'div.box',	
		opacity:0.8,
		helper:'original',
		revert:true,
		forceHelperSize:true,	
		placeholder: 'box-placeholder round-all',
		forcePlaceholderSize:true,
		tolerance:'pointer'
    });
	
	// Store portlet update (move) in cookie
    $(".column").bind('sortupdate', function() {
        $('.column').each(function() {
            $.cookie(boxPositionCookiePrefix + $("body").attr("id") + ($(this).attr('id')), $(this).sortable('toArray'), { expires: cookieExpiration });
        });
    });
	
	// Portlets | INIT | check for closed portlet cookie
	var ckie = $.cookie(closedBoxesCookiePrefix+$("body").attr("id"));
	if (ckie && ckie != '')	{
		// get cookie and split in array
		var list = ckie.split(',');
		
		// loop over boxes in cookie and do actions
		for (var x = 0; x < list.length; x++) {	
		 	var box = $("#"+list[x]);
			// close box
			box.find(".box-container-toggle").toggleClass("box-container-closed");
			// make closed box round
			box.find(".box-header").toggleClass("round-top").toggleClass("round-all");
			// find toggle button and change icon
			box.find('a[title="toggle"]').html("<i class=\"icon-plus\"></i>");
		}
	}
	
	// Tooltip 
	$('a[rel=tooltip]').tooltip();
	
	// Popovers
	$('[rel=popover]').popover();
	
	// Datepicker 
	$(".datepicker").datepicker();
	
	
	// Uniform
	$(".uniform_on").uniform();
	
	// Chosen multiselect
	$(".chzn-select").chosen();
	
	// Delete Cookies
	$(".cookie-delete").click(function() {
	  deleteCookies();
	});
			
	// funtion to get all cookies
	function getCookiesArray() {
	    var cookies = { };
	 
		if (document.cookie && document.cookie != '') {
	        var split = document.cookie.split(';');
        	for (var i = 0; i < split.length; i++) {
	            var name_value = split[i].split("=");
	            name_value[0] = name_value[0].replace(/^ /, '');
	            cookies[decodeURIComponent(name_value[0])] = decodeURIComponent(name_value[1]);
	        }
	    }
 
	    return cookies;  
	}
	
	// function to delete all cookies
	function deleteCookies() {
		var cookies = getCookiesArray();
		for(var name in cookies) {
		  $.cookie(name, null);
		}
	}
});

/* Dashboard page */

/* portlets.html specific script */
$(document).ready(function(){	
	if($("body").attr("id") == "portlets") {
		var boxHeight = $("#box-4").find('.box-content').height();
		$('.box-content').height(boxHeight);
		
	}
});

/* typography.html specific script */
$(document).ready(function(){	
	if($("body").attr("id") == "typography") {
		//Pretty print make code pretty
   		window.prettyPrint && prettyPrint();		
	}
});

/* gallery.html specific script */
$(document).ready(function(){	
	if($("body").attr("id") == "gallery") {
		'use strict';
	
		// Start slideshow button:
		$('#start-slideshow').button().click(function () {
			var options = $(this).data(),
				modal = $(options.target),
				data = modal.data('modal');
			if (data) {
				$.extend(data.options, options);
			} else {
				options = $.extend(modal.data(), options);
			}
			modal.find('.modal-slideshow').children()
				.removeClass('icon-play')
				.addClass('icon-pause');
			modal.modal(options);
		});
	
		// Toggle fullscreen button:
		$('#toggle-fullscreen').button().click(function () {
			var button = $(this),
				root = document.documentElement;
			if (!button.hasClass('active')) {
				$('#modal-gallery').addClass('modal-fullscreen');
				if (root.webkitRequestFullScreen) {
					root.webkitRequestFullScreen(
						window.Element.ALLOW_KEYBOARD_INPUT
					);
				} else if (root.mozRequestFullScreen) {
					root.mozRequestFullScreen();
				}
			} else {
				$('#modal-gallery').removeClass('modal-fullscreen');
				(document.webkitCancelFullScreen ||
					document.mozCancelFullScreen ||
					$.noop).apply(document);
			}
		});
	
	}
});
	
/* DataTables Extensions for Bootstrap */
/* Default class modification */
$.extend( $.fn.dataTableExt.oStdClasses, {
	"sSortAsc": "header headerSortDown",
	"sSortDesc": "header headerSortUp",
	"sSortable": "header"
} );

/* API method to get paging information */
$.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
{
	return {
		"iStart":         oSettings._iDisplayStart,
		"iEnd":           oSettings.fnDisplayEnd(),
		"iLength":        oSettings._iDisplayLength,
		"iTotal":         oSettings.fnRecordsTotal(),
		"iFilteredTotal": oSettings.fnRecordsDisplay(),
		"iPage":          Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
		"iTotalPages":    Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
	};
}

/* Bootstrap style pagination control */
$.extend( $.fn.dataTableExt.oPagination, {
	"bootstrap": {
		"fnInit": function( oSettings, nPaging, fnDraw ) {
			var oLang = oSettings.oLanguage.oPaginate;
			var fnClickHandler = function ( e ) {
				e.preventDefault();
				if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
					fnDraw( oSettings );
				}
			};

			$(nPaging).addClass('pagination').append(
				'<ul>'+
					'<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
					'<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
				'</ul>'
			);
			var els = $('a', nPaging);
			$(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
			$(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
		},

		"fnUpdate": function ( oSettings, fnDraw ) {
			var iListLength = 5;
			var oPaging = oSettings.oInstance.fnPagingInfo();
			var an = oSettings.aanFeatures.p;
			var i, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);

			if ( oPaging.iTotalPages < iListLength) {
				iStart = 1;
				iEnd = oPaging.iTotalPages;
			}
			else if ( oPaging.iPage <= iHalf ) {
				iStart = 1;
				iEnd = iListLength;
			} else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
				iStart = oPaging.iTotalPages - iListLength + 1;
				iEnd = oPaging.iTotalPages;
			} else {
				iStart = oPaging.iPage - iHalf + 1;
				iEnd = iStart + iListLength - 1;
			}

			for ( i=0, iLen=an.length ; i<iLen ; i++ ) {
				// Remove the middle elements
				$('li:gt(0)', an[i]).filter(':not(:last)').remove();

				// Add the new list items and their event handlers
				for ( j=iStart ; j<=iEnd ; j++ ) {
					sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
					$('<li '+sClass+'><a href="#">'+j+'</a></li>')
						.insertBefore( $('li:last', an[i])[0] )
						.bind('click', function (e) {
							e.preventDefault();
							oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
							fnDraw( oSettings );
						} );
				}

				// Add / remove disabled classes from the static elements
				if ( oPaging.iPage === 0 ) {
					$('li:first', an[i]).addClass('disabled');
				} else {
					$('li:first', an[i]).removeClass('disabled');
				}

				if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
					$('li:last', an[i]).addClass('disabled');
				} else {
					$('li:last', an[i]).removeClass('disabled');
				}
			}
		}
	}
} );

/* Table initialisation */
$(document).ready(function() {
	$('.bootstrap-datatable').dataTable( {
		"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "_MENU_ records per page"
		}
	} );
} );