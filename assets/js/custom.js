$(document).ready(function() {	

	$("#connecter .fieldset--submit").click(function() {
		$("#connecter .lrm-form-message").insertBefore($("#connecter .fieldset--submit"))
		$("#connecter .lrm-form-message").addClass("hide");
		$("#connecter .lrm-form-message").first().removeClass("hide");
	});
	$("#inscription .link.submit").click(function() {
		$("#inscription .lrm-form-message-wrap").insertBefore($("#inscription div.bottom"))
		$('#inscription .lrm-is-error').each(function() {
			var txt = $(this).text();
			if (seen[txt])
				$(this).remove();
			else
				seen[txt] = true;
		});
	});
  // MENU FIXED //
	$(window).scroll(function () {
		var posScroll = $(document).scrollTop();
		if (posScroll > 50) {
			$('.headerTop ').addClass('sticky')
		} else {
			$('.headerTop ').removeClass('sticky')
		}
		// if(!$("input[name=isHome]").val()) {
		// 	var posScroll = $(document).scrollTop();
		// 	if (posScroll > 50) {
		// 		$('.headerTop ').addClass('sticky')
		// 	} else {
		// 		$('.headerTop ').removeClass('sticky')
		// 	}
		// } else {
		// 	$('.headerTop ').addClass('sticky')
		// }
		
	});

	$(window).scroll(function () {
		var posScroll = $(document).scrollTop();
		if (posScroll > 200) {
			$('.zone-search ').addClass('sticky')
		} else {
			$('.zone-search ').removeClass('sticky')
		}
		// if(!$("input[name=isHome]").val()) {
		// 	var posScroll = $(document).scrollTop();
		// 	if (posScroll > 50) {
		// 		$('.headerTop ').addClass('sticky')
		// 	} else {
		// 		$('.headerTop ').removeClass('sticky')
		// 	}
		// } else {
		// 	$('.headerTop ').addClass('sticky')
		// }
		
	});


	// MENU MOBILE //
	$(".wrapMenuMobile").click(function() {
		$(this).toggleClass('active');
		$(".menuMobile").toggleClass('active');
		$(".menu ul").fadeToggle();
		$(".sub").css('display','none');
		$(".menu li i").removeClass('active');
		$('.listService').toggleClass('z-index')
		$('.scrollDown').toggleClass('active')
	});		
	// SLIDER HOME //
	$('#slider').slick({
			dots:false,
			infinite:true,
			autoplaySpeed:4000,
			speed:500,
			arrows:false,
			autoplay:true,
			pauseOnHover:false,
			slidesToShow: 1,
	        slidesToScroll: 1,
			cssEase:'linear',
			fade:true,
			
	});
	$('#cagnotte-publique').slick({
			dots:false,
			infinite:true,
			autoplaySpeed:4000,
			speed:500,
			arrows:true,
			autoplay:true,
			pauseOnHover:false,
			slidesToShow: 3,
	        slidesToScroll: 3,
			cssEase:'linear',
			responsive: [
			{ 
			  breakpoint: 1175,
			  settings: {
				slidesToShow: 2,
        slidesToScroll: 2,

			  }
			},
			{
			  breakpoint: 768,
			   settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight: true,

			  }
			},  
		 ]
	});
	$('.AproposMobile').slick({
			dots:false,
			infinite:true,
			autoplaySpeed:4000,
			speed:500,
			arrows:false,
			autoplay:true,
			pauseOnHover:false,
			slidesToShow: 3,
	        slidesToScroll: 1,
			cssEase:'linear',
			responsive: [
			{ 
			  breakpoint: 1025,
			  settings: {
				slidesToShow: 2,
				dots:true,
			  }
			},
			{
			  breakpoint: 768,
			   settings: {
				slidesToShow: 1,
				dots:true,
				adaptiveHeight: true,

			  }
			},  
		 ]
	});
	$('#slide-chiffre').slick({
			dots:false,
			infinite:true,
			autoplaySpeed:4000,
			speed:500,
			arrows:false,
			autoplay:false,
			pauseOnHover:false,
			slidesToShow: 3,
	        slidesToScroll: 1,
			cssEase:'linear',
			responsive: [
			{ 
			  breakpoint: 1175,
			  settings: {
				slidesToShow: 3,
				dots:true,
			  }
			},
			{ 
			  breakpoint: 768,
			  settings: {
				slidesToShow: 2,
				dots:true,
			  }
			},

			{
			  breakpoint:600,
			   settings: {
				slidesToShow: 1,
				dots:true,

			  }
			},  
		 ]
	});

	$('.slidePayement').slick({
			dots:false,
			infinite:true,
			autoplaySpeed:4000,
			speed:500,
			arrows:false,
			autoplay:true,
			pauseOnHover:false,
			slidesToShow: 4,
	        slidesToScroll: 1,
			cssEase:'linear',
			responsive: [
			{ 
			  breakpoint: 1025,
			  settings: {
				slidesToShow:5,
				dots:true,
			  }
			},
			{ 
			  breakpoint: 768,
			  settings: {
				slidesToShow: 4,
				dots:true,
			  }
			},

			{
			  breakpoint:600,
			   settings: {
				slidesToShow: 3,
				dots:true,

			  }
			},  

			{
			  breakpoint:481,
			   settings: {
				slidesToShow: 2,
				dots:true,

			  }
			},  
		 ]
	});

	$('#slide-img').slick({
			dots:false,
			infinite:true,
			autoplaySpeed:4000,
			speed:500,
			arrows:true,
			autoplay:true,
			pauseOnHover:false,
			slidesToShow: 6,
	        slidesToScroll: 1,
			cssEase:'linear',
			responsive: [
			{ 
			  breakpoint: 1076,
			  settings: {
				slidesToShow:5,
				arrows:true,
				
			  }
			},
			{ 
			  breakpoint: 915,
			  settings: {
				slidesToShow: 4,
				arrows:true,
				
			  }
			},

			{
			  breakpoint:751,
			   settings: {
				slidesToShow: 3,
				arrows:true,
			  }
			},  

			{
			  breakpoint:575,
			   settings: {
				slidesToShow: 2,
				arrows:true,

			  }
			},
			{
			  breakpoint:435,
			   settings: {
				slidesToShow: 1,
				arrows:true,

			  }
			},  
		 ]
	});

	$('#slide-qsn').slick({
			dots:false,
			infinite:true,
			autoplaySpeed:4000,
			speed:500,
			arrows:true,
			autoplay:true,
			pauseOnHover:false,
			slidesToShow: 1,
	        slidesToScroll: 1,
			cssEase:'linear',
			fade:true,
					
	});


	$(".fancybox").fancybox({
        fitToView: false,
        autoSize: false,
        closeClick: false,
        openEffect: 'none',
        closeEffect: 'none',
        fitToView:false,
	 });

	// $(".lst-faq .s-titre").click(function() {
	// 	$(this).toggleClass('active');
	// 	$(".lst-faq").find('.txt' ).slideUp();
	// 	if($(this).hasClass("active")){
	// 		$(".lst-faq .s-titre").removeClass('active');
	// 		$(this).next().slideToggle();
	// 		$(this).toggleClass('active');
	// 	}
	// }); 

	// SCROLL //
	$(".scroll").click(function() {
		var c = $(this).attr("href");
		$('html, body').animate({ scrollTop: $(c).offset().top -250}, 1000, "linear");
		return false;
	});



	$('.scrollbar-inner').scrollbar();

	$('.parallax-window').parallax({imageSrc: '../images/bg-left.png'});
	$('.parallax-window2').parallax({imageSrc: '../images/bg-right.png'});

	// $('.parallax-window').parallax({imageSrc: '../images/bg-left.png'});
	// $('.parallax-window2').parallax({imageSrc: '../images/deco2.png'});
	// $('.parallax-window3').parallax({imageSrc: '../images/deco3.png'});


	$(window).scroll(function () {
		var posScroll = $(document).scrollTop();
		if (posScroll > 200) {
			$('.blc-slider-range ').addClass('sticky');
			$('.scrollDown').addClass('show');
		} else {
			$('.blc-slider-range ').removeClass('sticky');
			$('.scrollDown').removeClass('show');
		}
	});

	$(".lst-choix-cond-part .item .content").click(function() {
		var vis = $(this);	
		if(vis.parent().hasClass("active")){
			vis.parent().removeClass("active");
		}else{
			$(".lst-choix-cond-part .item .content").parent().removeClass('active');
			vis.parent().addClass('active');	
		}
	});	


	$(".lst-securite .item .titre").click(function() {
		var vis = $(this);	
		if(vis.parent().hasClass("active")){
			vis.parent().removeClass("active");
		}else{
			$(".lst-securite .item .titre").parent().removeClass('active');
			vis.parent().addClass('active');	
		}
	});	


		if($('.ico-percent').hasClass("cloturer")){
			$('.ico-percent').prev().css("opacity" , '0');
		}else{
			$('.ico-percent').prev().css('opacity' , '1');	
		}	





	// $(".lst-type .item .content").click(function() {
	// 	var vis = $(this);	
	// 	if(vis.parent().hasClass("active")){
	// 		vis.parent().removeClass("active");
	// 	}else{
	// 		$(".lst-type .item .content").parent().removeClass('active');
	// 		vis.parent().addClass('active');	
	// 	}
	// });	

	$(".menu-cagnotte").click(function() {
		var vis = $(this);	
		if(vis.parent().next().hasClass("active")){
			vis.parent().next().removeClass("active");
		}else{
			$(".menu-cagnotte").parent().next().removeClass('active');
			vis.parent().next().addClass('active');	
		}
	});	

	$(window).scroll(function () {
		if ($(window).scrollTop() + $(window).height() > $('#footer').offset().top) {
		   $('.blc-slider-range.sticky').addClass('in');
		} else {
		$('.blc-slider-range.sticky').removeClass('in');
		}
	});
	
	$('.counter').counterUp({
	    delay: 50,
	    time: 3000
	});

	 var exist = $('.textEdit').length
	    if (exist) {
	        $('.textEdit').summernote({
	            height: 400,
	            tabsize: 2
	          });
	    }
	  /* wow animation */
    new WOW({
        mobile:false, 
    }).init()

   // Show the first tab and hide the rest
	$('.tab-nav li:first-child').addClass('active');
	$('.tab-content').hide();
	$('.tab-content:first').show();

	// Click function
	$('.tab-nav li').click(function(){
	  $('.tab-nav li').removeClass('active');
	  $(this).addClass('active');
	  $('.tab-content').hide();
	  $('.tab-content').removeClass('show');

	  
	  var activeTab = $(this).find('a').attr('href');
	  $(activeTab).fadeIn();
	  $(activeTab).addClass('show');
	  return false;
	});
	if ( $('.percent').length ){
		$('.percent').percentageLoader({
		  bgColor:'#fff',
		  ringColor:'#885297',
		  textColor:'#fbbd36',
		  valElement:'p',
	  	  fontSize:'12px',
	  	  strokeWidth: 3,
		});
	}

	// SCROLL CAGNOTTE //
	$(".lst-type .item").click(function() {
		$(this).addClass("active");
		var k = ("#formulaire");
		$(".menu-cagnotte").html($(this).find('.inner').html());
		var classe = $(this).find('.inner').attr("class").replace("inner ", "");
		$(".menu-cagnotte").attr("class", "menu-cagnotte "+classe);
		$('html, body').animate({ scrollTop: $(k).offset().top - 350 }, 1000, "linear");
		return false;
	});

	//  INPUT FILE //
	fileInit();
	fileInitOter();
	reset_file_upload();

	function fileInit(){
		$('.input-file').change(function() {
			iz=$(this)
			val=iz.val()
			par=iz.parent(".cont-file")
			txtExt=par.find("span")
			txtBroswer=par.find("i")
			txtExt.text(val) 
			txtBroswer.text("changer")
		});
	}
	function fileInitOter(){
		$('.input-file').each(function(){
			$(this).change(function() {
			$(this).parents(".cont-file").addClass('uploaded');	
			iz=$(this)
			resetBtn=iz.siblings('.reset');
			val=iz.val()
			if(val!=""){
				par=iz.parent(".cont-file")
				txtExt=par.find("span")
				txtBroswer=par.find("i")

				txtExt.text(val) 
				txtBroswer.text("changer")
				resetBtn.show()
				resetBtn.text('Suppr')
			}
		})
		})
	}

	function reset_file_upload(){
		$('.reset').each(function(){
			$('.reset').on('click', function(){
				reset = $(this);

				btnChanger = $(this).siblings('i');
				inputFile  = $(this).siblings('.input-file');
				fakeText   = $(this).siblings('span');
				btnChanger.text("Parcourir");
				inputFile.val('');
				fakeText.text("Aucun fichier sélectionné");

				if ( reset.parents('#spn_inputs').length == 1 ){
					reset.parent('.cont-file').remove();
				}else{
					reset.hide();
				}
				return false;
			});
		});
	}

	$('.reset').click(function () {
		$('.cont-file').removeClass('uploaded');
	})

	// SCROLL CAGNOTTE //
	$(".acc").click(function() {
		$(this).toggleClass("active");
	});

	// SCROLL DOWN
	$(".scrollDown").click(function() {
	    $('html,body').animate({
	        scrollTop: $("#footer").offset().top - 90},
	        1500);
	})

	$(".scrollDown-pp").click(function() {
	    var container = $('.fancybox-overlay');
	    var scrollTo = $("#form-pp-connecter");
	    
	    // Or you can animate the scrolling:
	    container.animate({
	        scrollTop: scrollTo.offset().top - container.offset().top + container.scrollTop()
	    }, 3000);
	    return false;
	});

});

