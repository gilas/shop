jQuery(document).ready(function()
{	
	// INITIALIZE METADATA OBJECT
	// It is a bridge between HTML and JavaScript to pass some user settings from admin panel
	var metadata = jQuery('#metadata.metadata').metadata();
	
	
	// INITIALIZE CUFON FONT REPLACEMENT	
//	if(metadata.general_enable_font_replacement && metadata.general_enable_font_replacement == 1) {		
//		Cufon.replace('h1, h2, h3, h4, h5, h6, .button', { hover: 'true' });
//	}
	
	
	// INITIALIZE DROPDOWN MENU
	jQuery('.dd-menu li:has(ul) > a').addClass('dd-submenu-title').append('<span class="dd-arrow"></span>');	
	jQuery('.dd-menu li').hover(function(){	
			// HOVER IN HANDLER
	
			jQuery('ul:first', this).css({visibility: "visible",display: "none"}).slideDown(250);									
			var path_set = jQuery(this).parents('.dd-menu li').find('a:first');
			jQuery(path_set).addClass('dd-path');						
			jQuery('.dd-menu li a.dd-path').not(path_set).removeClass('dd-path');
			
		},function(){			
			// HOVER OUT HANDLER		
			jQuery('ul:first', this).css({visibility: "hidden"});				
	});
	jQuery('.dd-menu').hover(function() {
			// HOVER IN HANDLER
			
		}, function() {			
			// HOVER OUT HANDLER		
			jQuery('a.dd-path', this).removeClass('dd-path');			
	});
	
	
		
	// INITIALIZE FANCY FRAMES
	jQuery('.frame').each(function(){
		
		var frameHandler = this;
		
		// Compose proper markup if aligned image
		jQuery('img', this).each(function(){
			if(jQuery(this).hasClass('alignleft')) {
				jQuery(frameHandler).addClass('alignleft');
				jQuery(this).removeClass('alignleft');			
			}			
			if(jQuery(this).hasClass('alignleft')) {
				jQuery(frameHandler).addClass('alignleft');
				jQuery(this).removeClass('alignleft');			
			}
		});	
		
		jQuery(this).append('<span class="helper1"></span><span class="helper2"></span>');
	});
	
	
		
	// REPLACE SUBMIT BUTTONS WITH SOMETHING EASIER TO STYLE:)
	jQuery('input[type=submit]').each(function() {		
	
		var val = jQuery(this).val();
		var a = jQuery('<a class="button primary small"><span>' + val + '</span></a>');
		var input = jQuery(this);
		
		input.after(a);
		input.hide();
		
		a.click(function() {			
			input.trigger('click');
		});
	});

	
	
	// COLLECT USER SETTINGS FOR HOME SLIDERS
	var home_cycle_speed 		= parseInt(metadata.home_cycle_speed);
	var home_cycle_timeout 		= parseInt(metadata.home_cycle_timeout);
	var home_cycle_pause		= parseInt(metadata.home_cycle_pause);		
	
	// INITIALIZE COIN SLIDER
	jQuery('#slider.slider-coin').each(function(){
		var slider = this;
		
		// Build slider navigation
		var sliderNav = new Array(
				'<div class="nav">',
					'<ul>',
					'</ul>',
				'</div>'
		).join("\n");
		jQuery(this).append(sliderNav);
		
		// Start slider
		jQuery('.slides', this).cycle({
			fx:			'fade',
			
			speed:		home_cycle_speed,
			timeout:	home_cycle_timeout,
			pause:		home_cycle_pause,
			
			pager:		jQuery('.nav ul', slider),
			pagerAnchorBuilder: function(idx, slide) {            
				return '<li><a class="coin" href="#"></a></li>';
	        }		
		});
	});
	
	
	// INITIALIZE THUMB SLIDER
	jQuery('#slider.slider-thumb .slides').cycle({
		fx:			'fade',		
		
		speed:		home_cycle_speed,
		timeout:	home_cycle_timeout,
		pause:		home_cycle_pause,
		
		pager:		'#slider.slider-thumb .nav ul',		
		pagerAnchorBuilder: function(idx, slide) {            
            return '#slider.slider-thumb .nav ul li:eq(' + (idx) +  ') a';
        }		
	});	
	
	
	// INITIALIZE PRETTYPHOTO PLUGIN
	//jQuery("a[rel^='prettyPhoto']").prettyPhoto();	
	
		
	// INITIALIZE PORTFOLIO DELAY
	if(metadata.portfolio_enable_delay && metadata.portfolio_enable_delay == 1) {
		jQuery('.folio-2-columns .c-6').css({opacity: 0, visibility: "visible", display: "block", 'background-color': "white"}).each(function(index){	
			jQuery(this).delay(index*250).animate({opacity: 1}, 500);		
		});
		
		jQuery('.folio-3-columns .c-4').css({opacity: 0, visibility: "visible", display: "block", 'background-color': "white"}).each(function(index){	
			jQuery(this).delay(index*250).animate({opacity: 1}, 500);		
		});
		
		jQuery('.folio-4-columns .c-3').css({opacity: 0, visibility: "visible", display: "block", 'background-color': "white"}).each(function(index){	
			jQuery(this).delay(index*250).animate({opacity: 1}, 500);		
		});
		
	}
	
	
	// -----------------------------------------------------------------------------------------
	// Internet Explorer doesn't understand some CSS selectors, so we need some helpful classes
	// -----------------------------------------------------------------------------------------
	if(jQuery.browser.msie) {
		jQuery('input[type=text]').addClass('input-text');
		jQuery('input[type=password]').addClass('input-password');
		jQuery('input[type=checkbox]').addClass('input-checkbox');
		jQuery('input[type=radio]').addClass('input-radio');
		jQuery('input[type=submit]').addClass('input-submit');
		jQuery('input[type=image]').addClass('input-image');
		jQuery('input[type=file]').addClass('input-file');
	}
	
	   
});
