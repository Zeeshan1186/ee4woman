/*
Template Name: Charitio
Author: wpoceans
Version: 1.0
*/

(function($){
'use strict';

/*----- ELEMENTOR LOAD FUNTION CALL ---*/

$( window ).on( 'elementor/frontend/init', function() {

    var hero_slide = function(){

         // HERO SLIDER
        var menu = [];
        jQuery('.swiper-slide').each( function(index){
            menu.push( jQuery(this).find('.slide-inner').attr("data-text") );
        });
        var interleaveOffset = 0.5;
        var swiperOptions = {
            loop: true,
            speed: 1000,
            parallax: true,
            autoplay: {
                delay: 6500,
                disableOnInteraction: false,
            },
            watchSlidesProgress: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            on: {
                progress: function() {
                    var swiper = this;
                    for (var i = 0; i < swiper.slides.length; i++) {
                        var slideProgress = swiper.slides[i].progress;
                        var innerOffset = swiper.width * interleaveOffset;
                        var innerTranslate = slideProgress * innerOffset;
                        swiper.slides[i].querySelector(".slide-inner").style.transform =
                        "translate3d(" + innerTranslate + "px, 0, 0)";
                    }      
                },

                touchStart: function() {
                  var swiper = this;
                  for (var i = 0; i < swiper.slides.length; i++) {
                    swiper.slides[i].style.transition = "";
                  }
                },

                setTransition: function(speed) {
                    var swiper = this;
                    for (var i = 0; i < swiper.slides.length; i++) {
                        swiper.slides[i].style.transition = speed + "ms";
                        swiper.slides[i].querySelector(".slide-inner").style.transition =
                        speed + "ms";
                    }
                }
            }
        };

        var swiper = new Swiper(".swiper-container", swiperOptions);

        // DATA BACKGROUND IMAGE
        var sliderBgSetting = $(".slide-bg-image");
        sliderBgSetting.each(function(indx){
            if ($(this).attr("data-background")){
                $(this).css("background-image", "url(" + $(this).data("background") + ")");
            }
        });



    }; // end
    

    var happy_client_slider = function(){
  
       /*------------------------------------------
            = Testimonial SLIDER
        -------------------------------------------*/
        if ($(".wpo-happy-client-slide").length) {
            $(".wpo-happy-client-slide").owlCarousel({
                autoplay: true,
                smartSpeed: 300,
                margin: 0,
                loop:true,
                autoplayHoverPause:true,
                dots: false,
                nav: false,
                items:5,
                responsive: {
                    0 : {
                        items: 3
                    },

                    500 : {
                        items: 3
                    },

                    768 : {
                        items: 3,
                    },

                    1200 : {
                        items: 4
                    },

                    1400 : {
                        items: 5
                    },

                }
            });
        }


    }; // end

    var case_study_slider = function(){
  
   
     /*------------------------------------------
         CAUSE SLIDER
        -------------------------------------------*/
        if ($(".wpo-case-slider").length) {
            $(".wpo-case-slider").owlCarousel({
                loop:true,
                margin: 20,
                nav: true,
                navText: ['<i class="fi ti-angle-left"></i>','<i class="fi ti-angle-right"></i>'],
                dots: false,
                responsive:{
                    0 : {
                        items: 1,
                    },
                    
                    550 : {
                        items: 2,
                        center: false,
                        margin: 10
                    },
                    
                    992:{
                        items:3
                    },
                    
                    1200:{
                        items:3
                    }
                }
            });
        }


    }; // end



    var wpo_funfact = function(){
  
        /*------------------------------------------
            = FUNFACT
        -------------------------------------------*/
        if ($(".odometer").length) {
            $('.odometer').appear();
            $(document.body).on('appear', '.odometer', function(e) {
                var odo = $(".odometer");
                odo.each(function() {
                    var countNumber = $(this).attr("data-count");
                    $(this).html(countNumber);
                });
            });
        }


    }; // end



    var team_slider = function(){
  
        /*------------------------------------------
        = Testimonial SLIDER
        -------------------------------------------*/
        if ($(".team-slider").length) {
            $(".team-slider").owlCarousel({
                autoplay: true,
                smartSpeed: 300,
                margin: 20,
                loop:true,
                center:true,
                autoplayHoverPause:true,
                dots: false,
                nav: false,
                responsive: {
                    0 : {
                        items: 1
                    },

                    500 : {
                        items: 1
                    },

                    768 : {
                        items: 2,
                    },

                    1200 : {
                        items: 3
                    },

                    1400 : {
                        items: 4
                    },

                }
            });
        }


    }; // end


    var testimonial_slider = function(){
  
       /*------------------------------------------
        = Testimonial SLIDER
        -------------------------------------------*/
        if ($(".testimonial-slider").length) {
            $(".testimonial-slider").owlCarousel({
                autoplay: true,
                smartSpeed: 300,
                margin: 100,
                loop:true,
                autoplayHoverPause:true,
                dots: false,
                nav: true,
                navText: ['<i class="fi flaticon-left-arrow"></i>','<i class="fi flaticon-right-arrow"></i>'],
                items:2,
                responsive: {
                    0 : {
                        items: 1,
                    },

                    767 : {
                        items: 2
                    },
                    1200 : {
                        items: 2
                    },
                    1300 : {
                        items: 2
                    },

                    1400 : {
                        items: 2,
                    },
                    1500 : {
                        items: 2
                    },

                }
            });
        }


    }; // end


    var testimonial_slider_two = function(){
  
       /*------------------------------------------
        = Testimonial SLIDER S2
    -------------------------------------------*/
    if ($(".testimonial-slider-s2").length) {
        $(".testimonial-slider-s2").owlCarousel({
            autoplay: true,
            smartSpeed: 300,
            margin: 30,
            loop:true,
            autoplayHoverPause:true,
            dots: false,
            nav: true,
            navText: ['<i class="fi flaticon-left-arrow"></i>','<i class="fi flaticon-right-arrow"></i>'],
            items:2,
            responsive: {
                0 : {
                    items: 1,
                },

                767 : {
                    items: 2
                },
                1200 : {
                    items: 2
                },
                1300 : {
                    items: 2
                },

                1400 : {
                    items: 2,
                },
                1500 : {
                    items: 3
                },

            }
        });
    }


    }; // end


    var partners_slider = function(){

      /*------------------------------------------
            = PARTNERS SLIDER
        -------------------------------------------*/
        if ($(".partners-slider").length) {
            $(".partners-slider").owlCarousel({
                autoplay:true,
                smartSpeed: 300,
                margin: 30,
                loop:true,
                autoplayHoverPause:true,
                dots: false,
                nav:false,
                responsive: {
                    0 : {
                        items: 2
                    },

                    550 : {
                        items: 3
                    },

                    992 : {
                        items: 4
                    },

                    1200 : {
                        items: 6
                    }
                }
            });
        }

    }; // end


    var project_masonary  = function(){

      /*------------------------------------------
        = FUNCTION FORM SORTING GALLERY
        -------------------------------------------*/
        function sortingGallery() {
            if ($(".sortable-gallery .gallery-filters").length) {
                var $container = $('.gallery-container');
                $container.isotope({
                    filter:'*',
                    animationOptions: {
                        duration: 750,
                        easing: 'linear',
                        queue: false,
                    }
                });

                $(".gallery-filters li a").on("click", function() {
                    $('.gallery-filters li .current').removeClass('current');
                    $(this).addClass('current');
                    var selector = $(this).attr('data-filter');
                    $container.isotope({
                        filter:selector,
                        animationOptions: {
                            duration: 750,
                            easing: 'linear',
                            queue: false,
                        }
                    });
                    return false;
                });
            }
        }

        sortingGallery();

    }; // end

    var project_gallery  = function(){

         /*------------------------------------------
            = Gallery SLIDER
        -------------------------------------------*/
        if ($(".gallery-active").length) {
            $(".gallery-active").owlCarousel({
                autoplay:true,
                smartSpeed: 300,
                margin: 0,
                loop:true,
                autoplayHoverPause:true,
                dots: false,
                nav:false,
                responsive: {
                    0 : {
                        items: 1
                    },

                    550 : {
                        items: 2
                    },

                    992 : {
                        items: 2
                    },

                    1200 : {
                        items: 3
                    },
                    1400 : {
                        items: 4
                    }
                }
            });
        }

    }; // end



    //Slider
    elementorFrontend.hooks.addAction( 'frontend/element_ready/wpo-charitio_slider.default', function($scope, $){
        hero_slide();
    } );

    //happy_client_slider
    elementorFrontend.hooks.addAction( 'frontend/element_ready/wpo-charitio_hero.default', function($scope, $){
        happy_client_slider();
    } );


    //case_study_slider
    elementorFrontend.hooks.addAction( 'frontend/element_ready/wpo-charitio_causes.default', function($scope, $){
        case_study_slider();
    } );

    //wpo_funfact
    elementorFrontend.hooks.addAction( 'frontend/element_ready/wpo-charitio_funfact.default', function($scope, $){
        wpo_funfact();
    } );

    //team_slider
    elementorFrontend.hooks.addAction( 'frontend/element_ready/wpo-charitio_team.default', function($scope, $){
        team_slider();
    } );

    //testimonial_slider
    elementorFrontend.hooks.addAction( 'frontend/element_ready/wpo-charitio_testimonial.default', function($scope, $){
        testimonial_slider();
    } );

    //testimonial_slider 2
    elementorFrontend.hooks.addAction( 'frontend/element_ready/wpo-charitio_testimonial.default', function($scope, $){
        testimonial_slider_two();
    } );

    //partners_slider 
    elementorFrontend.hooks.addAction( 'frontend/element_ready/wpo-charitio_client.default', function($scope, $){
        partners_slider();
    } );

    //project_masonary 
    elementorFrontend.hooks.addAction( 'frontend/element_ready/wpo-charitio_project.default', function($scope, $){
        project_masonary();
    } );

    //project_gallery 
    elementorFrontend.hooks.addAction( 'frontend/element_ready/wpo-charitio_project.default', function($scope, $){
        project_gallery();
    } );

  

    
    
    
} );


})(jQuery);  