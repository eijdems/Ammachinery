define([
    'jquery',
    'slick'
], function ($) {
    'use strict';
    return function (config) {
        $('.altcon_hero_intro_outer .altcon_hero_div').slick(
            {
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                autoplay: parseInt(config.autoplay),
                autoplaySpeed: parseInt(config.autoplay_speed),
                pauseOnHover:false,
                arrows: true
            }
        );
    }
});
