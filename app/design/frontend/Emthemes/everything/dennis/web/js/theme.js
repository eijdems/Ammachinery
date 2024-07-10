/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'jquery',
    'mage/smart-keyboard-handler',
    'mage/mage',
    'mage/ie-class-fixer',
    'domReady!'
], function ($, keyboardHandler) {
    'use strict';

    if ($('body').hasClass('checkout-cart-index')) {
        if ($('#co-shipping-method-form .fieldset.rates').length > 0 && $('#co-shipping-method-form .fieldset.rates :checked').length === 0) {
            $('#block-shipping').on('collapsiblecreate', function () {
                $('#block-shipping').collapsible('forceActivate');
            });
        }
    }

    $('.cart-summary').mage('sticky', {
        container: '#maincontent'
    });
    setTimeout(function(){
          $('.header-wrapper-container ul.links').clone().appendTo('#store\\.links');
    },1500)  


    keyboardHandler.apply();
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

