/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    "jquery",
    "matchMedia",
    "jquery/ui",
    "jquery/jquery.mobile.custom",
    "mage/translate"
], function ($, mediaCheck) {
    'use strict';

    /**
     * Menu Widget - this widget is a wrapper for the jQuery UI Menu
     */
    $.widget('mage.menu', $.ui.menu, {
        options: {
            responsive: false,
            expanded: false,
            delay: 300
        },
        _create: function () {
            var self = this;

            this._super();
            $(window).on('resize', function () {
                self.element.find('.submenu-reverse').removeClass('submenu-reverse');
            });
        },

        _init: function () {
            $(".row-fluid").removeClass("ui-menu-item");
            $(".dropmenu-content").removeClass("ui-menu-item");

            $(".row-fluid").each(function(i, items_list){
                $(items_list).find('div').each(function(j, div){
                    if($(div).children('ul').hasClass('em-submenu'))
                    {
                        $(div).addClass("ui-menu-item");
                    }else{
                        $(div).children('ul').removeClass("ui-menu ui-widget ui-widget-content ui-corner-all expanded");
                        $(div).children('ul').addClass("detail-ul");
                        $(div).children('ul').removeAttr("style role aria-expanded");
                    }
                });
            });           
            this._super();
            this.delay = this.options.delay;

            if (this.options.expanded === true) {
                this.isExpanded();
            }

            this._assignControls()._listen();
        },

        _assignControls: function () {
            this.controls = {
                toggleBtn: $('[data-action="toggle-nav"]'),
                swipeArea: $('.nav-sections')
            };

            return this;
        },

        _listen: function () {
            var controls = this.controls;
            var toggle = this.toggle;

            this._on(controls.toggleBtn, {'click': toggle});
            this._on(controls.swipeArea, {'swipeleft': toggle});
        },

        toggle: function () {
            if ($('html').hasClass('nav-open')) {
                $('html').removeClass('nav-open');
                setTimeout(function () {
                    $('html').removeClass('nav-before-open');
                }, 300);
            } else {
                $('html').addClass('nav-before-open');
                setTimeout(function () {
                    $('html').addClass('nav-open');
                }, 42);
            }
        },

        //Add class for expanded option
        isExpanded: function () {
            var subMenus = this.element.find(this.options.menus),
                expandedMenus = subMenus.find('ul');
            console.log(expandedMenus.hasClass('em-submenu'));
            if(expandedMenus.hasClass('em-submenu')){
                expandedMenus.addClass('expanded');
            }
        },

        _activate: function (event) {
            window.location.href = this.active.find('> a').attr('href');
            this.collapseAll(event);
        },

        _keydown: function (event) {

            var match, prev, character, skip, regex,
                preventDefault = true;

            function escape(value) {
                return value.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&");
            }

            if (this.active.closest('ul').attr('aria-expanded') != 'true') {

                switch (event.keyCode) {
                    case $.ui.keyCode.PAGE_UP:
                        this.previousPage(event);
                        break;
                    case $.ui.keyCode.PAGE_DOWN:
                        this.nextPage(event);
                        break;
                    case $.ui.keyCode.HOME:
                        this._move("first", "first", event);
                        break;
                    case $.ui.keyCode.END:
                        this._move("last", "last", event);
                        break;
                    case $.ui.keyCode.UP:
                        this.previous(event);
                        break;
                    case $.ui.keyCode.DOWN:
                        if (this.active && !this.active.is(".ui-state-disabled")) {
                            this.expand(event);
                        }
                        break;
                    case $.ui.keyCode.LEFT:
                        this.previous(event);
                        break;
                    case $.ui.keyCode.RIGHT:
                        this.next(event);
                        break;
                    case $.ui.keyCode.ENTER:
                    case $.ui.keyCode.SPACE:
                        this._activate(event);
                        break;
                    case $.ui.keyCode.ESCAPE:
                        this.collapse(event);
                        break;
                    default:
                        preventDefault = false;
                        prev = this.previousFilter || "";
                        character = String.fromCharCode(event.keyCode);
                        skip = false;

                        clearTimeout(this.filterTimer);

                        if (character === prev) {
                            skip = true;
                        } else {
                            character = prev + character;
                        }

                        regex = new RegExp("^" + escape(character), "i");
                        match = this.activeMenu.children(".ui-menu-item").filter(function () {
                            return regex.test($(this).children("a").text());
                        });
                        match = skip && match.index(this.active.next()) !== -1 ?
                            this.active.nextAll(".ui-menu-item") :
                            match;

                        // If no matches on the current filter, reset to the last character pressed
                        // to move down the menu to the first item that starts with that character
                        if (!match.length) {
                            character = String.fromCharCode(event.keyCode);
                            regex = new RegExp("^" + escape(character), "i");
                            match = this.activeMenu.children(".ui-menu-item").filter(function () {
                                return regex.test($(this).children("a").text());
                            });
                        }

                        if (match.length) {
                            this.focus(event, match);
                            if (match.length > 1) {
                                this.previousFilter = character;
                                this.filterTimer = this._delay(function () {
                                    delete this.previousFilter;
                                }, 1000);
                            } else {
                                delete this.previousFilter;
                            }
                        } else {
                            delete this.previousFilter;
                        }
                }
            } else {
                switch (event.keyCode) {
                    case $.ui.keyCode.DOWN:
                        this.next(event);
                        break;
                    case $.ui.keyCode.UP:
                        this.previous(event);
                        break;
                    case $.ui.keyCode.RIGHT:
                        if (this.active && !this.active.is(".ui-state-disabled")) {
                            this.expand(event);
                        }
                        break;
                    case $.ui.keyCode.ENTER:
                    case $.ui.keyCode.SPACE:
                        this._activate(event);
                        break;
                    case $.ui.keyCode.LEFT:
                    case $.ui.keyCode.ESCAPE:
                        this.collapse(event);
                        break;
                    default:
                        preventDefault = false;
                        prev = this.previousFilter || "";
                        character = String.fromCharCode(event.keyCode);
                        skip = false;

                        clearTimeout(this.filterTimer);

                        if (character === prev) {
                            skip = true;
                        } else {
                            character = prev + character;
                        }

                        regex = new RegExp("^" + escape(character), "i");
                        match = this.activeMenu.children(".ui-menu-item").filter(function () {
                            return regex.test($(this).children("a").text());
                        });
                        match = skip && match.index(this.active.next()) !== -1 ?
                            this.active.nextAll(".ui-menu-item") :
                            match;

                        // If no matches on the current filter, reset to the last character pressed
                        // to move down the menu to the first item that starts with that character
                        if (!match.length) {
                            character = String.fromCharCode(event.keyCode);
                            regex = new RegExp("^" + escape(character), "i");
                            match = this.activeMenu.children(".ui-menu-item").filter(function () {
                                return regex.test($(this).children("a").text());
                            });
                        }

                        if (match.length) {
                            this.focus(event, match);
                            if (match.length > 1) {
                                this.previousFilter = character;
                                this.filterTimer = this._delay(function () {
                                    delete this.previousFilter;
                                }, 1000);
                            } else {
                                delete this.previousFilter;
                            }
                        } else {
                            delete this.previousFilter;
                        }
                }
            }

            if (preventDefault) {
                event.preventDefault();
            }
        },

        _delay: function(handler, delay) {
            var instance = this,
                handlerProxy = function () {
                return (typeof handler === "string" ? instance[handler] : handler)
                    .apply(instance, arguments);
            };
            
            return setTimeout(handlerProxy, delay || 0);
        }
    });


    $.widget('mage.navigation', $.mage.menu, {

        options: {
            responsiveAction: 'wrap', //option for responsive handling
            maxItems: null, //option to set max number of menu items
            container: '#menu', //container to check against navigation length
            moreText: $.mage.__('more'),
            breakpoint: 768
        },

        _init: function () {
            this._super();

            var that = this,
                moreMenu = $('[responsive=more]'),
                responsive = this.options.responsiveAction;

            this.element
                .addClass('ui-menu-responsive')
                .attr('responsive', 'main');

            this.setupMoreMenu();
            this.setMaxItems();

            //check responsive option
            if (responsive == "onResize") {
                $(window).on('resize', function () {
                    if ($(window).width() > that.options.breakpoint) {
                        that._responsive();
                        $('[responsive=more]').show();
                    } else {
                        that.element.children().show();
                        $('[responsive=more]').hide();
                    }
                });
            } else if (responsive == "onReload") {
                this._responsive();
            }
        },

        setupMoreMenu: function () {
            var moreListItems = this.element.children().clone(),
                moreLink = $('<a>' + this.options.moreText + '</a>');

            moreListItems.hide();

            moreLink.attr('href', '#');

            this.moreItemsList = $('<ul>')
                .append(moreListItems);

            this.moreListContainer = $('<li>')
                .append(moreLink)
                .append(this.moreItemsList);

            this.responsiveMenu = $('<ul>')
                .addClass('ui-menu-more')
                .attr('responsive', 'more')
                .append(this.moreListContainer)
                .menu({
                    position: {
                        my: "right top",
                        at: "right bottom"
                    }
                })
                .insertAfter(this.element);
        },

        _responsive: function () {
            var container = $(this.options.container),
                containerSize = container.width(),
                width = 0,
                items = this.element.children('li'),
                more = $('.ui-menu-more > li > ul > li a');


            items = items.map(function () {
                var item = {};

                item.item = $(this);
                item.itemSize = $(this).outerWidth();
                return item;
            });

            $.each(items, function (index, item) {
                var itemText = items[index].item
                    .find('a:first')
                    .text();

                width += parseInt(items[index].itemSize, null);

                if (width < containerSize) {
                    items[index].item.show();

                    more.each(function () {
                        var text = $(this).text();
                        if (text === itemText) {
                            $(this).parent().hide();
                        }
                    });
                } else if (width > containerSize) {
                    items[index].item.hide();

                    more.each(function () {
                        var text = $(this).text();
                        if (text === itemText) {
                            $(this).parent().show();
                        }
                    });
                }
            });
        },

        setMaxItems: function () {
            var items = this.element.children('li'),
                itemsCount = items.length,
                maxItems = this.options.maxItems,
                overflow = itemsCount - maxItems,
                overflowItems = items.slice(overflow);

            overflowItems.hide();

            overflowItems.each(function () {
                var itemText = $(this).find('a:first').text();

                $(this).hide();

                $('.ui-menu-more > li > ul > li a').each(function () {
                    var text = $(this).text();
                    if (text === itemText) {
                        $(this).parent().show();
                    }
                });
            });
        }
    });

    return {
        menu: $.mage.menu,
        navigation: $.mage.navigation
    };

});
