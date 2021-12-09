import Vue from 'vue';

import { BCarousel, BCarouselSlide } from 'bootstrap-vue';
Vue.component('b-carousel', BCarousel);
Vue.component('b-carousel-slide', BCarouselSlide);

require('./components');
require('./../app');

$(document).on("scroll", window, function () {
    if ($(window).scrollTop()>120)
    {
        $("#header-app").addClass('scroll');
    }
    else
    {
        $("#header-app").removeClass('scroll');
    }
});


