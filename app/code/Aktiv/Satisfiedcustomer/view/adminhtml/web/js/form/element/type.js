define([
    'jquery',
    'underscore',
    'uiRegistry',
    'Magento_Ui/js/form/element/select'
], function ($, _, uiRegistry, select) {
    'use strict';
    return select.extend({
 
        initialize: function (){
            var status = this._super().initialValue;
            this.fieldDepend(status);
            return this;
        },
 
 
        /**
         * On value change handler.
         *
         * @param {String} value
         */
        onUpdate: function (value) {
 
            this.fieldDepend(value);
            return this._super();
        },
 
        /**
         * Update field dependency
         *
         * @param {String} value
         */
        fieldDepend: function (value) {
            setTimeout(function () {
                console.log(value);
                var video = uiRegistry.get('index = video');
                var image = uiRegistry.get('index = image');
                var text = uiRegistry.get('index = text');
                var sourceimage = uiRegistry.get('index = sourceimage');
                // for video type
                if (value == 0) {
                    video.show();
                    sourceimage.show();
                    image.hide();
                    text.hide();
                } else if (value == 1){
                    sourceimage.hide();
                    video.hide();
                    image.show();
                    text.hide();
                }
                else {
                    sourceimage.hide();
                    video.hide();
                    image.hide();
                    text.show();
                }
            }, 500);
            return this;
        }
    });
});