$(document).ready(function () {
    $(".fancybox").fancybox();
    $('#ask').html($('#ask_tab_content').html());
    var galleryThumbs = new Swiper('.gallery-thumbs', {
        spaceBetween: 10,
        slidesPerView: 'auto',
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
        direction: 'vertical',
        navigation: {
            prevEl: '.thumbs-button-prev',
            nextEl: '.thumbs-button-next',
        },
    });
    var galleryTop = new Swiper('.gallery-top', {
        loop: true,
        effect: 'fade',
        thumbs: {
            swiper: galleryThumbs
        },
        on: {
            init: function() {
                $('.gallery-thumbs').css('height', $('.gallery-top').height());
                galleryThumbs.update();
            },
            resize: function() {
                $('.gallery-thumbs').css('height', $('.gallery-top').height());
                galleryThumbs.update();
            }
        }
    });
})