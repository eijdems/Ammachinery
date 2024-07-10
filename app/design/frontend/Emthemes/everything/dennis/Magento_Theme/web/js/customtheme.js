require(['jquery'], function ($) {
    $(document).ready(function () {
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
    $(document).ready(function () {
        $(".category-description").append('<div class="show-more">Read More</div>');
        $(".category-description").addClass("show-more-height");
        setTimeout(function () {
            $(".show-more").click(function () {
                var $this = $(this);
                $this.text($this.text() == "Read Less" ? "Read More" : "Read Less");
                $(".category-description").toggleClass("show-more-height");
            });
        }, 5000);

        $(".category-gallery .media").click(function() {
            window.location = $(this).find("a").attr("href");
            return false;
        });


        $('.sections.nav-sections .em-menu-content > li.menu span.ui-menu-icon').click(function(e) {
            e.preventDefault();
            var $this = $(this);
          
            if ($this.parent().hasClass('show')) {
                $this.parent().removeClass('show');
                $this.next().slideUp(350);
            } else {
                $this.parent().removeClass('show');
                $this.parent().find('.em-submenu-content').removeClass('show');
                $this.parent().find('.em-submenu-content').slideUp(350);
                $this.parent().toggleClass('show');
                $this.next().slideToggle(350);
            }
        });
    });

});