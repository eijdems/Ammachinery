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
