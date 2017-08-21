"use strict";
	//Main custom script file
	jQuery(document).ready(function($){
		
		'use strict';
		
		// fixed sticky navbar
		try {
			$('#fixed-main-menu').sticky({
				topSpacing: 0,
				className: 'sticky'
			});
			$('#fixed-main-menu').onePageNav({
					scrollSpeed: 0,
					scrollOffset: 0
				})
		} catch (err) {

		}
		
		//Smooth Scroll
		try {
			$('.navbar-nav li a').smoothScroll();
			$('.go-button a').smoothScroll();
		} catch (err) {

		}
		
		//Auto Close Responsive Navbar on Click
		function close_toggle() {
			if ($(window).width() <= 767) {
			  $('.navbar-collapse li').on('click', function(){
				  $('.navbar-collapse').collapse('hide');
			  });
			}
			else {
				$('.navbar .navbar-default a').off('click');
			}
		}
		close_toggle();

		$(window).resize(close_toggle);
		
		//Active Menu Item on Page Scroll
		var sections = $('section')
		  , nav = $('header')
		  , nav_height = nav.outerHeight();
		 
		$(window).on('scroll', function () {
		  var cur_pos = $(this).scrollTop();
		 
		  sections.each(function() {
			var top = $(this).offset().top - nav_height,
				bottom = top + $(this).outerHeight();
				
			if (cur_pos >= top && cur_pos <= bottom) {
			  nav.find('a').removeClass('current');
			  sections.removeClass('current');
		 
			  $(this).addClass('current');
			  nav.find('a[href="#'+$(this).attr('id')+'"]').addClass('current');
			}
		  });
		});
		
		//Header small
		$(window).scroll(function() {
			if ($(this).scrollTop() > 5){ 
				$('#main-menu').addClass("navbar-small");
			}
			else{
				$('#main-menu').removeClass("navbar-small");
			}
		});
		
		//Counter up
		$('.counter').counterUp({
			delay: 8,
			time: 1000
		});
		
		//owl carousal
		$('#owl-client').owlCarousel({
			autoPlay: true,
			navigation : false,
			pagination: false,
			item: 7
		});
		
		// slides
		$('#products').slides({
			autoPlay: true,
			preload: true,
			preloadImage: 'images/loading.gif',
			effect: 'slide, fade',
			crossfade: true,
			slideSpeed: 500,
			fadeSpeed: 500,
			generateNextPrev: true,
			generatePagination: false
		});
		
		// form validation
		$('#form').parsley();
		
		//Google map
		$("#map").gmap3({
			marker:{    
				address:"Alun-Alun Pasuruan Jl. Alun-Alun Selatan, Kebonsari, Pasuruan, Jawa Timur 67116, Indonesia"
				},
			map:{
				options:{
				zoom: 17,
				scrollwheel:false,
				draggable: true 
				}
			}
		});
		
		//contact form
		$('#contactform').submit(function(){
			var action = $(this).attr('action');
			$("#message").slideUp(250,function() {
				$('#message').hide();
				$('#submit')
					.after('<img src="images/contact-form-loader.gif" class="loader" />')
					.attr('disabled','disabled');
				$.post(action, {
						name: $('#name').val(),
						email: $('#email').val(),
						website: $('#website').val(),
						capcha: $('#capcha').val(),
						comments: $('#comments').val(),
					},
					function(data){
						document.getElementById('message').innerHTML = data;
						$('#message').slideDown(250);
						$('#contactform img.loader').fadeOut('slow',function(){$(this).remove()});
						$('#submit').removeAttr('disabled');
						if(data.match('success') != null) $('#contactform').slideUp(850, 'easeInOutExpo');
					}
				);
			});
			return false;
		});
		
		// go to top
		$(window).scroll(function() {
			if($(this).scrollTop() != 0) {
				$('#toTop, #backtotop').fadeIn();	
			} else {
				$('#toTop, #backtotop').fadeOut();
			}
		});
		
		$('#toTop').on('click',function() {
			$('body,html').animate({scrollTop:0},800);
		});
		
	});
	
	//window load function
	$(window).load(function(){
		
		// init Isotope
		var $container = $('.isotope-container').isotope({
			itemSelector: '.item',
			layoutMode: 'masonry',
			masonry: {
				gutter: 20
			},
			transitionDuration: '0.5s',
			// only opacity for reveal/hide transition
			hiddenStyle: {
			  opacity: 0
			},
			visibleStyle: {
			  opacity: 1
			}
		});
		
		// filter functions
		var filterFns = {
			// show if number is greater than 50
			numberGreaterThan50: function() {
			  var number = $(this).find('.number').text();
			  return parseInt( number, 10 ) > 50;
			},
			// show if name ends with -ium
			ium: function() {
			  var name = $(this).find('.name').text();
			  return name.match( /ium$/ );
			}
		};
		
		// bind filter button click
		$('#filters').on( 'click', 'button', function() {
			var filterValue = $( this ).attr('data-filter');
			// use filterFn if matches value
			filterValue = filterFns[ filterValue ] || filterValue;
			$container.isotope({ filter: filterValue });
		});

		// change is-checked class on buttons
		$('.button-group').each( function( i, buttonGroup ) {
			var $buttonGroup = $( buttonGroup );
			$buttonGroup.on( 'click', 'button', function() {
			  $buttonGroup.find('.is-checked').removeClass('is-checked');
			  $( this ).addClass('is-checked');
			});
		});
		
	});