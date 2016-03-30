jQuery.noConflict();
jQuery(document).ready(function($){
	jQuery(document).on('click', '.remove-slider', function(){
		var imageId 	= jQuery(this).attr('data-slide');
		var urlImage 	= jQuery(this).attr('data-url');
		if(imageId > 0 && urlImage != undefined) {
			if(confirm('Are you sure want to remove this slider image?')) {
				jQuery.get(urlImage, function(result){
					jQuery('#image-'+imageId).remove();
				});
			}
		}
	});
	if(jQuery('.carousel-logo').length > 0) {
		carouselSlide(0);
		jQuery(document).on('click', '.owl-carousel .owl-item-single', function(){
			var data_slide = jQuery(this).attr('data-slide');
			jQuery('.owl-item-single').removeClass('logoact');
			if(data_slide > 0) {
				jQuery(this).addClass('logoact');
				jQuery('.hide_all').removeClass('show').addClass('hide').fadeOut();
				jQuery('#company-div-'+data_slide).removeClass('hide').addClass('show').fadeIn('slow');
				var data_index = jQuery(this).attr('data-index');
				carouselSlide(data_index);
			}
		});
		
		
		$('.owl-carousel').owlCarousel({
			loop:false,
			margin:10,
			responsiveClass:true,
			responsive:{
				0:{
					items:1,
					nav:true
				},	 
				768:{
					items:2,
					nav:true
				}, 
				992:{
					items:4,
					nav:true
				},
				1200:{
					items:5,
					nav:true
				},
				1600:{
					items:6,
					nav:true
				}
			}
		});
		$(".fancybox").fancybox({
			prevEffect		: 'none',
			nextEffect		: 'none'
		});
	}
	function carouselSlide(num) {
		$('.slider-carousel'+num).owlCarousel({
			loop:true,
			margin:10,
			responsiveClass:true,
			responsive:{
				0:{
					items:1,
					nav:true
				},
				600:{
					items:3,
					nav:true
				},
				1000:{
					items:5,
					nav:true
				}
			}
		});
		$(".fancybox").fancybox({
			prevEffect		: 'none',
			nextEffect		: 'none'
		});
	}
});