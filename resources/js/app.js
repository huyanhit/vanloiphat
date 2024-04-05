import 'jquery/dist/jquery.min.js';
import 'lightbox2/dist/js/lightbox.min.js';
import './bootstrap';
import './jquery.nivo.slider'
import './owl.carousel.min'
$(document).ready(function () {
    $(document).on('click', '#close-cart', function () {
        $("[data-toggle=popover]").popover('hide')
    })

    $("[data-toggle=popover]").popover({
        html: true,
        container: '.cart-container',
        offset: '0 -100px',
        content: function () {
            return getCart("my-cart");
        }
    });
    $('.service-carousel').owlCarousel({
        loop: true,
        margin: 10,
        dots: false,
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
        }
    })
    $('.product-carousel').owlCarousel({
        loop: true,
        margin: 10,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    })
    $('.customer-carousel').owlCarousel({
        loop: true,
        dots: false,
        margin: 0,
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 4
            },
            1000: {
                items: 6
            }
        }
    })
    $('#slider').nivoSlider({
        effect: 'fade', // Specify sets like: 'fold,fade,sliceDown'
        animSpeed: 2000, // Slide transition speed
        pauseTime: 4000, // How long each slide will show
        startSlide: 0, // Set starting Slide (0 index)
        directionNav: false, // Next & Prev navigation
        controlNav: false, // 1,2,3... navigation
        controlNavThumbs: false, // Use thumbnails for Control Nav
        pauseOnHover: false // Stop animation while hovering
    });
})


