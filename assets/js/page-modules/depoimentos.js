$( document ).ready(function() {
    $('.depoimentos__slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: false,
        prevArrow: '.depoimentos__arrow--prev',
        nextArrow: '.depoimentos__arrow--next'
    })
})