/*
 * Bones Scripts File
 * Author: Eddie Machado
 *
 * This file should contain any js scripts you want to add to the site.
 * Instead of calling it in the header or throwing it inside wp_head()
 * this file will be called automatically in the footer so as not to
 * slow the page load.
 *
 * There are a lot of example functions and tools in here. If you don't
 * need any of it, just remove it. They are meant to be helpers and are
 * not required. It's your world baby, you can do whatever you want.
*/

/*
 * Get Viewport Dimensions
 * returns object with viewport dimensions to match css in width and height properties
 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
*/
function updateViewportDimensions() {
	var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
	return { width:x,height:y };
}
// setting the viewport width
var viewport = updateViewportDimensions();


/*
 * Throttle Resize-triggered Events
 * Wrap your actions in this function to throttle the frequency of firing them off, for better performance, esp. on mobile.
 * ( source: http://stackoverflow.com/questions/2854407/javascript-jquery-window-resize-how-to-fire-after-the-resize-is-completed )
*/
var waitForFinalEvent = (function () {
	var timers = {};
	return function (callback, ms, uniqueId) {
		if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
		if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
		timers[uniqueId] = setTimeout(callback, ms);
	};
})();

// how long to wait before deciding the resize has stopped, in ms. Around 50-100 should work ok.
var timeToWaitForLast = 100;


/*
 * Here's an example so you can see how we're using the above function
 *
 * This is commented out so it won't work, but you can copy it and
 * remove the comments.
 *
 *
 *
 * If we want to only do it on a certain page, we can setup checks so we do it
 * as efficient as possible.
 *
 * if( typeof is_home === "undefined" ) var is_home = $('body').hasClass('home');
 *
 * This once checks to see if you're on the home page based on the body class
 * We can then use that check to perform actions on the home page only
 *
 * When the window is resized, we perform this function
 * $(window).resize(function () {
 *
 *    // if we're on the home page, we wait the set amount (in function above) then fire the function
 *    if( is_home ) { waitForFinalEvent( function() {
 *
 *	// update the viewport, in case the window size has changed
 *	viewport = updateViewportDimensions();
 *
 *      // if we're above or equal to 768 fire this off
 *      if( viewport.width >= 768 ) {
 *        console.log('On home page and window sized to 768 width or more.');
 *      } else {
 *        // otherwise, let's do this instead
 *        console.log('Not on home page, or window sized to less than 768.');
 *      }
 *
 *    }, timeToWaitForLast, "your-function-identifier-string"); }
 * });
 *
 * Pretty cool huh? You can create functions like this to conditionally load
 * content and other stuff dependent on the viewport.
 * Remember that mobile devices and javascript aren't the best of friends.
 * Keep it light and always make sure the larger viewports are doing the heavy lifting.
 *
*/

/*
 * We're going to swap out the gravatars.
 * In the functions.php file, you can see we're not loading the gravatar
 * images on mobile to save bandwidth. Once we hit an acceptable viewport
 * then we can swap out those images since they are located in a data attribute.
*/
function loadGravatars() {
  // set the viewport using the function above
  viewport = updateViewportDimensions();
  // if the viewport is tablet or larger, we load in the gravatars
  if (viewport.width >= 768) {
  jQuery('.comment img[data-gravatar]').each(function(){
    jQuery(this).attr('src',jQuery(this).attr('data-gravatar'));
  });
	}
} // end function

/*
 * Put all your regular jQuery in here.
*/
jQuery(document).ready(function($) {
	
	var win = $(window);

	// Check what page we're on
	if (typeof isHome === "undefined") var isHome = $('body').hasClass('home');
	if (typeof isFilmFestPage === "undefined") var isFilmFestPage = $('body').hasClass('film-festival-page');
	if (typeof isProgramPage === "undefined") var isProgramPage = $('body').hasClass('page-template-page-program');

	/*
	* Let's fire off the gravatar function
	* You can remove this if you don't need it
	*/
	loadGravatars();
	
	win.resize(function() {
		waitForFinalEvent( function() {
			adminBarMove = $('#wpadminbar').outerHeight()-1;
			mobileDeviceBodyClass();
			setGalleryOvSize();
			headerHeight();
			if (isFilmFestPage) {
				setScreeningListHeight();
			}
		}, timeToWaitForLast, 'resizeWindow');
	});
	
	win.scroll(function() {
		headerHeight();
	});
	
	function mobileDeviceType() {
		if (win.width() > 1024) {
			return false;
		} else if (win.width() < 768) {
			return 'mobile';
		} else {
			return 'tablet';
		}
	}
	function mobileDeviceBodyClass() {
		if (mobileDeviceType() == 'mobile') {
			$('body').addClass('mobile').removeClass('tablet');
		} else if (mobileDeviceType() == 'tablet') {
			$('body').addClass('tablet').removeClass('mobile');
		} else {
			$('body').removeClass('mobile tablet');
		}
	}
	mobileDeviceBodyClass();
	
	function headerHeight() {
		if (win.scrollTop() > 100) {
			$('body').addClass('scrolled');
		} else {
			$('body').removeClass('scrolled');
		}
	}
	
	/************************
	// CAROUSEL
	************************/
	var carouselInterval;
	var carouselNavTimeout;
	function carouselInit(container) {
		carouselAutoSwitch(container);
		container.find('.CAROUSEL_NAV a').click(function(e) {
			e.preventDefault();
			clearInterval(carouselInterval);
			clearTimeout(carouselNavTimeout);
			carouselGoToPane(container, $(this).hasClass('PREV') ? 'prev' : 'next');
			carouselNavTimeout = setTimeout(function() {
				carouselAutoSwitch(container);
			}, 25000); // 25 seconds until the animated carousel starts up again
		});
		container.mousemove(function(e) {
			carouselFadeNav(container, e);
		});
		/*if (mobileDeviceType() != 'mobile' && mobileDeviceType() != 'tablet') {
			
		}*/
	}
	function carouselAutoSwitch(container) {
		carouselInterval = setInterval(function() {
			carouselGoToPane(container, 'next');
		}, 8000); // 8 seconds per pane
	}
	function carouselGoToPane(container, pane) {
		var currentPane = container.find('.PANES > .active');
		var prevPane = currentPane.prev().length > 0 ? currentPane.prev() : currentPane.siblings().last();
		var nextPane = currentPane.next().length > 0 ? currentPane.next() : currentPane.siblings().first();
		var newPane = pane == 'next' ? nextPane : pane == 'prev' ? prevPane : pane;
		currentPane.addClass('deactivating');
		setTimeout(function() {
			currentPane.removeClass('active deactivating');
		}, 500);
		newPane.addClass('active');
	}
	function carouselFadeNav(container, e) {
		$('.CAROUSEL_NAV a').each(function() {
			var vertDistance = $(this).offset().top - e.pageY;
			vertDistance = -vertDistance > 0 ? -vertDistance : vertDistance;
			var horizDistance = $(this).offset().left - e.pageX;
			horizDistance = -horizDistance > 0 ? -horizDistance : horizDistance;
			var totalDistance = Math.sqrt(Math.pow(vertDistance, 2) + Math.pow(horizDistance, 2));
			//console.log(totalDistance);
			if (totalDistance < 300) {
				$(this).addClass('active');
			} else {
				$(this).removeClass('active');
			}
			/* This made the button opacity relative to the distance from the cursor...farther the cursor, more transparent the button. I didn't work well.
			var opacity = -1/500*totalDistance + (6/5);
			opacity = opacity > 1 ? 1 : opacity < 0 ? 0 : opacity;
			console.log(opacity);
			$(this).css('opacity',opacity);
			*/
		});
		container.mouseout(function() {
			$('.CAROUSEL_NAV a').removeClass('active');
			// was using this before with the above relative opacity code $('.CAROUSEL_NAV a').css('opacity',0);
			//container.off('mousemove');
		});
	}
	carouselInit($('.CAROUSEL'));
	
	/************************
	// GALLERY
	************************/
	
	// GALLERY OVERLAY
	var readyCount = 0;
	$('#gallery_item_ov').dialog({
		autoOpen:false,
		close: function(e,ui) {
			$('body').removeClass('height-locked');
		},
		dialogClass:'gallery-item-ov-wrap ov-wrap',
		modal:true,
		hide:130,
		show:250,
		open: function(e,ui) {
			$('body').addClass('height-locked');
			setGalleryOvSize();
			thisDialog = $(this);
			$('.ui-widget-overlay').click(function() {
				thisDialog.dialog('close');
			});
			/*$(this).closest('.gallery-item-ov-wrap').css({
				margin:'-'+($(this).closest('.gallery-item-ov-wrap').height()/2)+'px 0 0 -'+($(this).closest('.gallery-item-ov-wrap').width()/2)+'px'
			})*/
		},
		width:'auto'
	}).on('click', '.PREV, .NEXT', function(e) {
		e.preventDefault();
		if ($(this).hasClass('disabled')) { return false; }
		if ($(this).hasClass('PREV')) {
			$('#gallery_item_ov').data('current').prev().click();
		} else if ($(this).hasClass('NEXT')) {
			$('#gallery_item_ov').data('current').next().click();
		}
		//setGalleryOvSize();
	});
	$('.GALLERY').on('click', '.gallery-item', function(e) {
		e.preventDefault();
		var galOv = $('#gallery_item_ov');
		galOv.removeClass('ready');
		readyCount = 0;
		var thisItem = $(this);
		var imgSrc = thisItem.find('.IMG_SRC').val();
		$.imgpreload(imgSrc, function() {			
			showImageWhenReady(galOv);
		});
		/*$.imgpreload([thisItem.prev().find('.IMG_SRC').val(), thisItem.next().find('.IMG_SRC').val()], function() {
			console.log('loaded');
		});*/
		setTimeout(function() {
			galOv.find('img').attr({
				'src':imgSrc,
				'alt':$(this).find('img').attr('alt')
			})
			galOv.data({
				'width':thisItem.find('.IMG_WIDTH').val(),
				'height':thisItem.find('.IMG_HEIGHT').val(),
				'current':thisItem
			}).dialog('open')
			if (thisItem.is(':first-child')) {
				$('#gallery_item_ov .PREV').addClass('disabled');
			} else {
				$('#gallery_item_ov .PREV').removeClass('disabled');
			}
			if (thisItem.is(':last-child')) {
				$('#gallery_item_ov .NEXT').addClass('disabled');
			} else {
				$('#gallery_item_ov .NEXT').removeClass('disabled');
			}
			showImageWhenReady(galOv);
		}, 500);
	});
	function showImageWhenReady(galOv) {
		readyCount ++;
		if (readyCount > 1) {
			setGalleryOvSize();
			galOv.addClass('ready');
		}
	}
	$('body').keyup(function(e) {
		var galleryItemOv = $('#gallery_item_ov');
		if (galleryItemOv.dialog('isOpen')) {
			if (e.keyCode == 37 || e.which == 37) {
				galleryItemOv.find('.actions .PREV').click();
			} else if (e.keyCode == 39 || e.which == 39) {
				galleryItemOv.find('.actions .NEXT').click();
			}
		}
	});
	
	function setGalleryOvSize() {
		var ov = $('#gallery_item_ov');
		var ratio = ov.data('width') / ov.data('height');
		//var border = win.width() > 480 ? 15 : 0;
		border = 0;
		var margin = win.width() > 480 ? 40 : 0;
		var width, height
		if (win.width() - margin < ov.data('width') || win.height() - margin < ov.data('height')) {
			if (ratio >= win.width() / win.height()) {
				width = win.width()-margin;
				height = (win.width()-margin) / ratio
			} else {
				width = (win.height()-margin) * ratio
				height = win.height()-margin
			}
		} else {
			width = ov.data('width')
			height = ov.data('height')
		}
		ov.width(width).height(height).closest('.gallery-item-ov-wrap').css('margin','-'+((height/2)+border)+'px 0 0 -'+((width/2)+border)+'px')
		ov.find('img').width(width).height(height)
	}
	
	// used for Partners list on home page
	var scrollCarInterval;
	function scrollCarousel(container, intervalTime, hoverPause) {
		var carousel =  container.children('ul');
		carWidth = 0;
		carousel.data('paused', false).children().each(function() {
			carWidth += $(this).outerWidth();
		});
		carousel.width(carWidth);
		scrollCarInterval = setInterval(function() {
			scrollCarouselScroll(carousel, 'left');
		}, intervalTime);
		if (hoverPause) {
			carousel.hover(function() {
				carousel.data('paused', true);
			}, function () {
				carousel.data('paused', false);
			});
		}
	}
	function scrollCarouselScroll(carousel, direction) {
		if (carousel.data('paused') == true) {return false};
		var directionMultiplier = direction == 'left' ? -1 : 1;
		var departingPane = direction == 'left' ? carousel.children().first() : carousel.children().last();
		carousel.animate({'left': departingPane.outerWidth() * directionMultiplier}, 500, function() {
			if (direction == 'left') {
				departingPane.appendTo(carousel);
			} else {
				departingPane.prependTo(carousel);
			}
			carousel.css('left',0);
		});
	}
	function setScreeningListHeight() {
		var screeningList = $('.SWITCH_LISTS')
		var screeningListHeight = screeningList.outerHeight();
		$('.SWITCH_LIST:first > li').each(function() {
			screeningListHeight += $(this).outerHeight();
		});
		$('.SWITCH_LISTS').height(screeningListHeight);
	}
	
	if (isHome) {
		scrollCarousel($('.SCROLL_CAROUSEL'), 3000, true);
	}
	
	if (isFilmFestPage || isProgramPage) {
		console.log('WORKED');
		setScreeningListHeight();
		// animates toggling from screening films list by schedule to alphabetical
		$('.TABS > li').click(function() {
			if ($(this).hasClass('active')) { return; }
			$(this).add($(this).siblings()).add('.SWITCH_LIST').toggleClass('active');
		});
	}
	
	// Hide wp admin bar
	var adminBarMove = $('#wpadminbar').outerHeight()-1
	$('#wpadminbar').animate({
		'top':'-='+adminBarMove
	}, 2000,function() {
	}).hover(
		function(){
			$('#wpadminbar').stop().css('top','0').toggleClass('wpadminbar-shown');
		},
		function(){
			$('#wpadminbar').animate({
				'top':'-='+adminBarMove
			}, 2000).toggleClass('wpadminbar-shown');
		}
	).append('<div class="wpadminbar-activator"></div>');
	
	$('.TRIGGER_NAV').click(function(e) {
		e.preventDefault();
		$(this).add('.MAIN_NAV').toggleClass('active');
		$('html').toggleClass('mobile-nav-active');
	});
	
	$('.MAIN_NAV').on('click','a',function(e) {
		if (mobileDeviceType()) {
			$('.TRIGGER_NAV').click();
		}
	});


}); /* end of as page load scripts */
