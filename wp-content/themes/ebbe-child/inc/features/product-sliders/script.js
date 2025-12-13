jQuery(function ($) {

    function initSlider(selector, settings) {
        if ($(window).width() < settings.breakpoint) {
            if (!$(selector).hasClass('slick-initialized')) {
                $(selector).slick(settings.config);
            }
        } else {
            if ($(selector).hasClass('slick-initialized')) {
                $(selector).slick('unslick')
            }
        }
    }

    function initProductListSlider() {
        initSlider('.custom-products-list.grid', {
            breakpoint: 1030,
            config: {
                dots: false,
                infinite: true,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 4,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: { slidesToShow: 3, slidesToScroll: 3, dots: true, infinite: true, autoplaySpeed: 3000, arrows: false }
                    },
                    {
                        breakpoint: 700,
                        settings: { slidesToShow: 2, slidesToScroll: 2, dots: true, infinite: true, autoplaySpeed: 3000, arrows: false }
                    },
                    {
                        breakpoint: 480,
                        settings: { slidesToShow: 2, slidesToScroll: 2, dots: true, infinite: true, autoplaySpeed: 3000, arrows: false }
                    }
                ]
            }
        });
    }

    function initRelatedProductSlider() {
        initSlider(".related .products.columns-4", {
            breakpoint: 1030,
            config: {
                dots: false,
                infinite: true,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 4
            }
        });
    }

    function initCollectionSlider() {
        initSlider('.collectionParent_wrapper', {
            breakpoint: 1080,
            config: {
                dots: true,
                infinite: false,
                speed: 300,
                slidesToShow: 2,
                slidesToScroll: 1
            }
        });
    }

    function initBlogSlider() {
        initSlider(".blog-articles-container", {
            breakpoint: 1030,
            config: {
                dots: true,
                infinite: false,
                speed: 300,
                slidesToShow: 2,
                slidesToScroll: 1
            }
        });
    }

    function initializeAll() {
        initProductListSlider();
        initRelatedProductSlider();
        initCollectionSlider();
        initBlogSlider();
    }

    initializeAll();

    $(window).on('resize', initializeAll);
});