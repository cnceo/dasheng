
(function($) {
    "use strict";
    $(window).scroll(function(){ 
    	if($(document).scrollTop()>500){ 
		    $('.backtop').show()
    	}
    	else $('.backtop').hide()
    }) 
    $('.backtop').click(function() {
        $('html, body').animate({scrollTop: 0}, 500);
    });

    // Hero Section Slider
    function hero_slider_carousel() {
        var owl = $("#hero-slider-screen");
        owl.owlCarousel({
            loop: true,
            margin: 10,
            smartSpeed: 2000,
            responsiveClass: true,
            navigation: true,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            nav: true,
            items: 1,
            addClassActive: true,
            dots: false,
            autoplay: false,
            autoplayTimeout: 5000,
            stopOnHover: true,
            responsive: {
                0: {
                    dots: true,
                    nav: false,
                },

                768: {
                    dots: false,
                    nav: true,
                }
            }
        });
    }
    hero_slider_carousel();

    // Profile Item Tab Slider
    $('.profile-item-tab').on('click', function() {
        $('.profile-item-tab').removeClass('active');
        $(this).addClass('active');
    });

    // Video Item Tab Slider
    $('.video-tab').on('click', function() {
        $('.video-tab').removeClass('active');
        $(this).addClass('active');
    });

    //scrollReveal js Init
    window.sr = ScrollReveal({ duration: 800 });
    sr.reveal('.foo');
    sr.reveal('.bar');
}(jQuery));

//图片展示
$.loadImage = function(url) {
  var loadImage = function(deferred) {
    var image = new Image();

    image.onload = loaded;
    image.onerror = errored; // URL returns 404, etc
    image.onabort = errored; // IE may call this if user clicks "Stop"
     
    image.src = url;

    function loaded() {
      unbindEvents();
      deferred.resolve(image);
    }
    function errored() {
      unbindEvents();
      deferred.reject(image);
    }
    function unbindEvents() {
      image.onload = null;
      image.onerror = null;
      image.onabort = null;
    }
  };
  return $.Deferred(loadImage).promise();
};

$(function(){
	var page = 0,
		per_page = 100,
		photo_default_size = 300,
		picture_width = photo_default_size,
		picture_height = photo_default_size,
		max_w_photos, max_h_photos,
		data = response;
    var imgWidth = photo_default_size, imgHeight = photo_default_size, imgW = photo_default_size, imgH = photo_default_size;

	var win = $(window),
		loading = $('#loading'),
		gallery = $('#gallery');
		gallery.trigger('data-ready');

	gallery.on('data-ready window-resized page-turned', function(event, direction){
		var cache = [],
			deferreds = [];

		gallery.trigger('loading');

		var set = data.slice(get_page_start(), get_page_start() + get_per_page());
		var list = '';

		$.each(set, function(e){
			deferreds.push($.loadImage("http://www.xcxyao.com/activity/europe/"+set[e]));

			list = '<div class="gallery-item" style="width:' + picture_width + 'px;height:' + picture_height + 'px;" ><a href="http://www.xcxyao.com/activity/europe/' + set[e] + '" class="item-a"><img src="http://www.xcxyao.com/activity/europe/' + set[e] + '" ></a></div>'
			cache.push(list);
		});
		if(is_prev_page()){
			cache.unshift('<a class="btn-gallery-prev" ></a>');
		}

		if(is_next_page()){
			cache.push('<a class="btn-gallery-next" ></a>');
		}

		if(!cache.length){
			return false;
		}

		$.when.apply($, deferreds).always(function(){

			if(event.type == 'window-resized'){

				gallery.html(cache.join(''));
				show_photos_static();
				reset_images_WH();

				$('.gallery-masonry .item-a').lightBox();
			}
			else{
				gallery.fadeOut(function(){
					gallery.html(cache.join(''));

					if(event.type == 'page-turned' && direction == 'br'){
						show_photos_with_animation_br();
					}
					else{
						show_photos_with_animation_tl();
					}
					$('.gallery-masonry .item-a').lightBox();

					gallery.show();
				});
			}
			gallery.trigger('loading-finished');
		});
	});

	gallery.on('loading',function(){
		loading.show();
	});
	gallery.on('loading-finished',function(){
		loading.hide();
	});
	gallery.on('click', '.btn-gallery-next', function(){
		page++;
		gallery.trigger('page-turned',['br']);
	});
	gallery.on('click', '.btn-gallery-prev', function(){
		page--;
		gallery.trigger('page-turned',['tl']);
	});

	win.on('resize', function(e){
		var width = win.width(),
			height = 600,
			//height = win.height(),
			gallery_width, gallery_height,
			difference;

		max_w_photos = Math.ceil(width/photo_default_size);
		difference = (max_w_photos * photo_default_size - width) / max_w_photos;
		picture_width = Math.ceil(photo_default_size - difference);
		gallery_width = max_w_photos * picture_width;
		max_h_photos = Math.ceil(height/photo_default_size);
		difference = (max_h_photos * photo_default_size - height) / max_h_photos;
		picture_height = Math.ceil(photo_default_size - difference);
		gallery_height = max_h_photos * picture_height;
		per_page = max_w_photos*max_h_photos;
		gallery.width(gallery_width).height(gallery_height);

		gallery.trigger('window-resized');

	}).resize();

	function reset_images_WH(){
		var imgs = $('.gallery-masonry .item-a img');
		imgs.each(function(e){
			imgHeight = imgs[e].height;
			imgWidth = imgs[e].width;
			imgH = Math.ceil(photo_default_size*imgHeight / imgWidth);
			imgW = Math.ceil(photo_default_size*imgWidth / imgHeight);
			if(imgH < photo_default_size){
				imgs[e].height = photo_default_size;
				imgs[e].style.marginLeft = -(imgW-photo_default_size)/2+"px"
			}
			if(imgW < photo_default_size){
				imgs[e].width = photo_default_size;
				imgs[e].style.marginTop = -(imgH-photo_default_size)/2+"px"
			}
		})
	}

	function show_photos_static(){
		gallery.find('.gallery-item').addClass('static');
	}

	function show_photos_with_animation_tl(){
		var photos = gallery.find('.gallery-item'),
			imgs = photos.find('img');
		for(var i=0; i<max_w_photos + max_h_photos; i++){
			var j = i;
			for(var l = 0; l < max_h_photos; l++){
				if(j < l*max_w_photos) break;
				(function(j){
					setTimeout(function(){
						photos.eq(j).addClass('show');
						if(imgs[j]){
							imgHeight = imgs[j].height;
							imgWidth = imgs[j].width;
							imgH = Math.ceil(photo_default_size*imgHeight / imgWidth);
							imgW = Math.ceil(photo_default_size*imgWidth / imgHeight);
							if(imgH < photo_default_size){
								imgs[j].height = photo_default_size;
								imgs[j].style.marginLeft = -(imgW-photo_default_size)/2+"px"
							}
							if(imgW < photo_default_size){
								imgs[j].width = photo_default_size;
								imgs[j].style.marginTop = -(imgH-photo_default_size)/2+"px"
							}
						}
					}, i*50);
				})(j);
				j += max_w_photos - 1;
			}
		}
	}

	function show_photos_with_animation_br(){
		var photos = gallery.find('.gallery-item'),
			imgs = photos.find('img');
		for(var i=0; i<max_w_photos + max_h_photos; i++){
			var j = per_page - i;
			for(var l = max_h_photos-1; l >= 0; l--){
				if(j > (l+1)*max_w_photos-1) break;
				(function(j){
					setTimeout(function(){
						photos.eq(j).addClass('show');
						if(imgs[j]){
							imgHeight = imgs[j].height;
							imgWidth = imgs[j].width;
							imgH = Math.ceil(photo_default_size*imgHeight / imgWidth);
							imgW = Math.ceil(photo_default_size*imgWidth / imgHeight);
							if(imgH < photo_default_size){
								imgs[j].height = photo_default_size;
								imgs[j].style.marginLeft = -(imgW-photo_default_size)/2+"px"
							}
							if(imgW < photo_default_size){
								imgs[j].width = photo_default_size;
								imgs[j].style.marginTop = -(imgH-photo_default_size)/2+"px"
							}
						}
					}, i*50);
				})(j);
				j -= max_w_photos - 1;
			}
		}
	}

	function get_per_page(){
		if(page == 0){
			return per_page;
		}
		if(get_page_start() + per_page > data.length){
			return per_page;
		}
		return per_page;
	}

	function get_page_start(p){
		if(p === undefined){
			p = page;
		}
		if(p == 0){
			return 0;
		}
		return (per_page - 2)*p + 1;
	}
	function is_next_page(){
		return data.length > get_page_start(page + 1);
	}
	function is_prev_page(){
		return page > 0;
	}
});