require(['jquery'], function ($) {
    $(document).ready(function () {

        $(".product.data.items > .item.title > .switch").click(function() {
            var tabs = $('.tabs-cst-slider');
            if (tabs.length) {
                $('html,body').animate({
                        scrollTop: tabs.offset().top - 250
                    },
                    'slow');
            }
        });

        $(".filter-options-item .filter-options-title").click(function(e) {
            e.preventDefault();
        });


        $("a#quote-form").click(function () {
            if ($('#product-options-wrapper .field.configurable').length > 0) {
                var labelArr = [];
                $("#product-options-wrapper .field.configurable").each(function (index, element) {
                    var labelProduct = $(this).find(".label > span").text();
                    var selectProduct = $(this).find(".control > select option:selected").text();
                    labelArr.push(labelProduct + "#" + selectProduct);
                });
                $("#quote_option").val(labelArr.join(","));

            }
        });
    });
});

require(['jquery', 'jquery/ui'], function (jQuery) {
    // jQuery("#home-tabs").tabs({
    //     collapsible: true
    // });
});




require(['jquery'], function ($) {
$(document).ready(function() {

          $(".category-description").append('<div class="show-more">Read More</div>');
    $(".category-description").addClass("show-more-height");

    setTimeout(function() {
        $(".show-more").click(function () {
            var $this = $(this);
            $this.text($this.text() == "Read Less" ? "Read More" : "Read Less");
            $(".category-description").toggleClass("show-more-height");
        });
    }, 5000);
    
});
});