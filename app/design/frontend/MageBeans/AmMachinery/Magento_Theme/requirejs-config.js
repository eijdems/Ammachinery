var config = {
    paths: {
        'bootstrap':'js/bootstrap.min',
        'owlcarousel': "Magento_Theme/js/owl.carousel",
        'scroll': 'js/Scrollbar',
        // 'jquery.slick': '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min'
    },
    shim: {
        'owlcarousel': {
            deps: ['jquery']
        },
        'bootstrap': {
            deps: ['jquery']
        },
        'scroll':{
            deps: ['owlcarousel']
        },
        // 'jquery.slick': {
        //     "deps": ['jquery']
        // }
    }
};
