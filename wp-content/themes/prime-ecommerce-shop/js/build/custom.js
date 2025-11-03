jQuery(document).ready(function ($) {

	var owl = jQuery('.banner .owl-carousel');
		owl.owlCarousel({
			margin:20,
			nav: true,
			autoplay : true,
			lazyLoad: true,
			autoplayTimeout: 3000,
			loop: false,
			dots:true,
			navText : ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i> '],
			responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		},
		autoplayHoverPause : true,
		mouseDrag: true
	});

	var owl = jQuery('.our-classes .owl-carousel');
		owl.owlCarousel({
			margin:40,
			nav: false,
			autoplay : false,
			lazyLoad: false,
			autoplayTimeout: 3000,
			loop: false,
			dots:false,
			navText : ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i> '],
			responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1000: {
				items: 4
			}
		},
		autoplayHoverPause : true,
		mouseDrag: true
	});

	$('.mobile-nav .toggle-button').on( 'click', function() {
		$('.mobile-nav .main-navigation').slideToggle();
	});

	$('.mobile-nav-wrap .close ').on( 'click', function() {
		$('.mobile-nav .main-navigation').slideToggle();

	});

	$('<button class="submenu-toggle"></button>').insertAfter($('.mobile-nav ul .menu-item-has-children > a'));
	$('.mobile-nav ul li .submenu-toggle').on( 'click', function() {
		$(this).next().slideToggle();
		$(this).toggleClass('open');
	});

// dropdown category
jQuery(document).ready(function(){
  jQuery(".category-dropdown").hide();
  
  jQuery("button.category-btn").click(function(){
    jQuery(".category-dropdown").toggle();
  });

  // Handle focus using Tab and Shift+Tab
  jQuery(".category-btn, .category-dropdown").on("keydown", function(e) {
    var dropdownItems = jQuery(".category-dropdown").find("a"); // Assuming dropdown items are represented by <a> tags
    
    if (e.keyCode === 9) { // Tab key
      if (!e.shiftKey && document.activeElement === dropdownItems.last().get(0)) {
        e.preventDefault();
        jQuery(".category-btn").focus();
      } else if (e.shiftKey && document.activeElement === dropdownItems.first().get(0)) {
        e.preventDefault();
        jQuery(".category-btn").focus();
      }
    }
  });
});
	//accessible menu for edge
	 $("#site-navigation ul li a").on( 'focus', function() {
	   $(this).parents("li").addClass("focus");
	}).on( 'blur', function() {
	    $(this).parents("li").removeClass("focus");
	 });
});

var btn = jQuery('#button');

jQuery(window).scroll(function() {
  if (jQuery(window).scrollTop() > 300) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});
btn.on('click', function(e) {
  e.preventDefault();
  jQuery('html, body').animate({scrollTop:0}, '300');
});

window.addEventListener('load', (event) => {
    jQuery(".preloader").delay(1000).fadeOut("slow");
});

jQuery(window).scroll(function() {
    var data_sticky = jQuery(' #masthead').attr('data-sticky');

    if (data_sticky == 1) {
      if (jQuery(this).scrollTop() > 1){  
        jQuery('#masthead').addClass("sticky-head");
      } else {
        jQuery('#masthead').removeClass("sticky-head");
      }
    }
});

function preloderFunction() {
    setTimeout(function() {           
        document.getElementById("page-top").scrollIntoView();
        
        $('#ctn-preloader').addClass('loaded');  
        // Once the preloader has finished, the scroll appears 
        $('body').removeClass('no-scroll-y');

        if ($('#ctn-preloader').hasClass('loaded')) {
            // It is so that once the preloader is gone, the entire preloader section will removed
            $('#preloader').delay(1000).queue(function() {
                $(this).remove();
                
                // If you want to do something after removing preloader:
                afterLoad();
                
            });
        }
    }, 3000);
}
function afterLoad() {
    // After Load function body!
}

function dealscountdown($timer,mydate){
    // Set the date we're counting down to
    var countDownDate = new Date(mydate).getTime();
    // Update the count down every 1 second
    var x = setInterval(function() {
        // Get todays date and time
        var now = new Date().getTime();
        // Find the distance between now an the count down date
        var distance = countDownDate - now;
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        // Output the result in an element with id="timer"
        $timer.html( "<div class='numbers'>" + days + "<br><span class='nofont'>Day</span>" + "</div>" + "   " +"<div class='numbers'>" + hours + "<br><span class='nofont'>Hrs</span>" + "</div>" + "   " + "<div class='numbers'>" + minutes + "<br><span class='nofont'>Min</span>" + "</div>" + "   " + "<div class='numbers'>" + seconds + "<br><span class='nofont'>Sec</spn" + "</div>");
        
        // If the count down is over, write some text 
        if (distance < 0) {
            clearInterval(x);
            $timer.html("Timer Up -EVENT EXPIRED");
        }
    }, 1000);
}
jQuery('document').ready(function(){

  jQuery('.count').each(function () {
      jQuery(this).prop('Counter',0).animate({
          Counter: jQuery(this).text()
      }, {
          duration: 8000,
          easing: 'swing',
          step: function (now) {
             jQuery(this).text(Math.ceil(now));
          }
      });
  });   
  var mydate =jQuery('.date').val();
  jQuery(".countdown").each(function(){
      dealscountdown(jQuery(this),mydate);
  });
  });
