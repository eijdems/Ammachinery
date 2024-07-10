define([
    "jquery",
    "jquery/ui",
    'mage/mage',
    'mage/validation'
], function ($) {
    "use strict";

    function main(config, element) {

        var $element = $(element);
        var AjaxUrl = config.AjaxUrl;

        $(document).ready(function () {

            $(document).on('click', '.emtabs-ajaxblock-loaded .em-tabs a.data.switch', function (e) {

                e.preventDefault();

                var cat_id = $(this).data('cat_id');
                var href = $(this).attr('href');

                $(this).data('cat_id', '');

                if (cat_id) {
                    $('div' + href).html('<p class="loader_section">Loading ... </p>');
                    $.ajax({
                        type: "POST",
                        url: AjaxUrl,
                        data: {cat_id: cat_id},
                        success: function (data, status, xhr) {
                            var objJSON = JSON.parse(JSON.stringify(data));
                            if (objJSON.output) {
                                $('div' + href).html(objJSON.output);
                            } else {
                                console.log('Error')
                            }

                        },
                        error: function (xhr, status, errorThrown) {
                            console.log(errorThrown);
                            return true;
                        }
                    });
                }
            });

            return false;

        });

    };
    return main;
});