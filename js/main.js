/*==============================================================================

 * Template Name: Parth - Creative Personal Portfolio
 * Template URI:  Parth - (https://imparthgalani.me/)
 * Author: Parth - (https://imparthgalani.me/)
 * Description: Personal Portfolio
 * Version: 1.0
 * Copyright 2021 Parth

==============================================================================
    
    [Table of jQuery contents]
    ===================
	
    01. PreLoader Init
    02. ProjectFilter Init
    03. HeaderFixed Init
    04. CounterUp Init
    05. ResponsiveMenu Init
    06. NavActiveClass Init
        -- Smooth-Scroll Init
    07. AboutImg init
    08. ProjectDetails Init
    09. TestimonialCarousel Init
    10. BlogCarousel Init
    11. BackgroundImage Init
    12. Water Ripple Effect
    13. ScrollBottom TO ScrollTop Smooth-Scroll

==============================================================================*/


(function ($) {
    "use strict";

    $(window).on('load', function () {

        /* 01. PreLoader Init
        ============================ */
        function preLoader() {
            setTimeout(function () {
                $('#preloader .scroll-static').addClass('loaded');
                setTimeout(function () {
                    $('#preloader').addClass('loaded');
                    setTimeout(function () {
                        $('#preloader').remove();
                    }, 400);

                    /* Splitting js init
                    ============================ */
                    Splitting();

                }, 600);
            }, 1000);
        };
        preLoader();

        /* 02. ProjectFilter Init
        ============================ */
        function projectFilter() {
            var $gridt = $('.works');
            // $(".work_single_item").slice(0, 6).show();
            $gridt.isotope();
            $('.filter-buttons').on('click', 'button', function () {
                var filterValue = $(this).attr('data-filter');
                $gridt.isotope({
                    filter: filterValue
                });
                $(this).addClass('active').siblings().removeClass('active');
            });
        };
        projectFilter();

    });


    $(window).on('scroll', function () {

        /* 03. HeaderFixed Init
        ============================ */
        function headerFixed() {
            if ($(window).scrollTop() >= 1) {
                $('header').addClass('header_fixed');
            } else {
                $('header').removeClass('header_fixed');
            }
        };
        headerFixed();

    });


    $(document).ready(function () {

        /* 04. CounterUp Init
        ============================ */
        function countUp() {
            $('.counter-number').counterUp({
                delay: 10,
                time: 2000
            });
        };
        countUp();



        /* 05. ResponsiveMenu Init
        ============================ */
        function responsiveMenu() {
            $('.nav-btn').on('click', function () {
                $('header').toggleClass('header_bg');
                $('.nav-btn span').toggleClass('ion-android-close ion-android-menu');
                $('.menu_items').toggleClass('show');
                $('body').toggleClass('no-scroll');
            });
            $('.menu_item').on('click', function () {
                $('header').removeClass('header_bg');
                if ($('.nav-btn span').hasClass('ion-android-close')) {
                    $('.nav-btn span').toggleClass('ion-android-menu ion-android-close');
                };
                $('.menu_items').removeClass('show');
                $('body').removeClass('no-scroll');
            });
        };
        responsiveMenu();

        /* 06. NavActiveClass Init
        ============================ */
        function navActiveClass() {

            $('body').scrollspy({
                target: '#menu_items',
                offset: 50,
            });

            // Smooth-Scroll Init
            $('a.menu_item, a.go_top').on("click", function () {
                if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $("[name=" + this.hash.slice(1) + "]");
                    if (target.length) {
                        $("html, body").animate({
                            scrollTop: target.offset().top
                        }, 1000, "easeInOutExpo");
                        return false;
                    }
                }
                return false;
            });

        };
        navActiveClass();

        /* 07. AboutImg init
        ============================ */
        function aboutImg() {
            $('.about_img_2.bottom').on('click', function () {
                $(this).addClass('top').removeClass('bottom');
                $('.about_img_1').addClass('bottom').removeClass('top');
            });
            $('.about_img_1').on('click', function () {
                $(this).addClass('top').removeClass('bottom');
                $('.about_img_2').addClass('bottom').removeClass('top');
            });
        };
        aboutImg();

        /* 08. ProjectDetails Init
        ============================ */
        function projectDetails() {
            $('.ajax-popup-link').magnificPopup({
                settings: null,
                type: 'ajax',
                closeOnContentClick: false,
                closeBtnInside: false,
                callbacks: {
                    ajaxContentAdded: function () {
                        $(".mfp-content").find("*").addClass("mfp-prevent-close");
                    },
                    open: function () {
                        $('html').addClass('layout-fixed');
                    },
                    close: function () {
                        $('html').removeClass('layout-fixed');
                    }
                }
            });
        };
        projectDetails();

        /* 09. TestimonialCarousel Init
        ============================ */
        function testimonialCarousel() {
            $('.owl-carousel.testimonial_slider').owlCarousel({
                loop: true,
                items: 1,
                margin: 0,
                autoplay: true,
                nav: false,
                dots: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
            });
        };
        testimonialCarousel();

        /* 10. BlogCarousel Init
        ============================ */
        function blogCarousel() {
            $('.blog_slider').owlCarousel({
                loop: true,
                items: 3,
                margin: 0,
                autoplay: true,
                nav: false,
                dots: true,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                        nav: false
                    },
                    600: {
                        items: 2,
                        nav: false
                    },
                    1000: {
                        items: 3,
                        nav: false
                    }
                }

            });
        };
        blogCarousel();

        /* 11. CertifyCarousel Init
        ============================ */
        function certifyCarousel() {
            $('.certify_slider').owlCarousel({
                loop: true,
                items: 3,
                margin: 0,
                autoplay: true,
                nav: false,
                dots: true,
                autoplayTimeout: 1000,
                autoplayHoverPause: true,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                        nav: false
                    },
                    600: {
                        items: 2,
                        nav: false
                    },
                    1000: {
                        items: 4,
                        nav: false
                    }
                }

            });
        };
        certifyCarousel();


        /* 11. BackgroundImage Init
        ============================ */
        function bgImage() {
            $('.bg-img').each(function () {
                var src = $(this).attr('data-src');
                $(this).css({
                    'background-image': 'url(' + src + ')'
                });
            });
        };
        bgImage();

        /* 12. Water Ripple Effect
        ============================ */
        $('.effect').ripples({
            dropRadius: 12,
            perturbance: 0.05,

        });

        /* 13. ScrollBottom TO ScrollTop Smooth-Scroll
        ============================================== */
        var btn = $('#button');

        $(window).scroll(function () {
            if ($(window).scrollTop() > 300) {
                btn.addClass('show');
            } else {
                btn.removeClass('show');
            }
        });

        btn.on('click', function (e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0,
                behavior: 'smooth'
            }, '300');
        });

        // /* 14. Load More Blog
        // ============================ */
        // $(".work_single_item").slice(0, 3).show(); //showing 12 div
        // $(".loadMore").fadeIn();

        // $(".loadMore").on("click", function () {
        //     $(".work_single_item:hidden").slice(0, 3).show(); //showing 12 hidden div on click
        //     if ($(".work_single_item:hidden").length === 0) {
        //         $(".loadMore").fadeOut(); //this will hide
        //         //button when length is 0
        //     }
        // });


    });

})(jQuery);