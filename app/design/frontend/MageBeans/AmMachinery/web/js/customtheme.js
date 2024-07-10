require(['jquery','domReady!','cwsmenu'],
    function ($) {

         $(document).ready(function(){

            if ($(window).width() < 1200) {
                    $('.custom_click').on('click', function(e){
                    e.preventDefault();
                   $(this).parent().toggleClass('c_show'); 
                });
            }
            
            if ($(window).width() > 1199) {
                $('.custom_click').mouseenter(function(e){
                    e.preventDefault();
                    $(this).parent().addClass('c_show'); 
                });
            }
        });
        $(window).on('scroll',function() {    
            var scroll = $(window).scrollTop();
            if (scroll >= 100) {
                $(".catalog-product-view").addClass("priceSticky");
            } else {
                $(".catalog-product-view").removeClass("priceSticky");
            }
        });
        // View Dekra product page
        $("#product-addtocart-button1").click(function(){
           $("#product-addtocart-button").trigger('click');
        });
        $(".view_dekra").click(function() {
            $('.dekra_available_show').addClass('active');
            $('body').addClass('dekra_body');
        });
        $('.d_cross').click( function(){
           $('.dekra_available_show').removeClass('active');
           $('body').removeClass('dekra_body');
        });

        $( ".hamburgermenu-ammachinery " ).append('<div class="footer-hamburgermenu-close"></div>');
        $('.hamburgermenu').click(function() {
            $( ".hamburgermenu-ammachinery" ).toggleClass('active');
            $( "body" ).toggleClass('modal-open');
        });

        $("ul.header.links").hide();
        
        $( "body" ).on( "click", ".footer-hamburgermenu-close", function() {
            $( ".hamburgermenu-ammachinery" ).toggleClass('active');
            $( "body" ).toggleClass('modal-open');
        });
        $('.footer-left-section h3').click(function(event){
          $(this).toggleClass('active-tab');
        });

        $('.search_click').click(function(){
            $('.search_add').toggleClass('open');
        });
        
        $('label:contains("Recommended repairs")').closest('li').addClass('pdp-containt-text');


                $(window).scroll(function(){
            var screenTop = 150;
            var screenBottom = 180;
            if ($(window).scrollTop() >= screenTop) {
                $('.page-header').addClass('sticky');
            }
            else {
              $('.page-header').removeClass('sticky');
            }
            if ($(window).scrollTop() >= screenBottom) {
                $('.page-header').addClass('fixed-header');
                $('.top-banner').addClass('fixed-header');
                $('.page-header').removeClass('sticky');
            }
            else {
                $('.page-header').removeClass('fixed-header');
                $('.top-banner').removeClass('fixed-header');
            }
        });

         // contact button toggle
        $('.contact-wrapper > .contactbtn').click(function(e) {
            e.preventDefault();
          
            var $this = $(this);
          
            if ($this.parent().hasClass('showblock')) {
                $this.parent().removeClass('showblock');
                $this.next().slideUp(430);
            } else {
                $this.parent().removeClass('showblock');
                $this.parent().find('.salesinfo').removeClass('showblock');
                $this.parent().find('.salesinfo').slideUp(430);
                $this.parent().toggleClass('showblock');
                $this.next().slideToggle(430);
            }
        });
        
        $(".close").on("click", function() {
          $(".contact-wrapper").removeClass("showblock");
          $(".salesinfo").slideUp(430);
        });
        
        // responsive menu toggle
        $('.sections.nav-sections .arrow-span').click(function(e) {
            // alert("clicked");
            e.preventDefault();
            var $this = $(this);
            
            if ($this.parent().hasClass('show')) {
                $this.parent().removeClass('show');
                $this.next().slideUp(350);
            } else {
                $this.parent().removeClass('show');
                $this.parent().find('.menu-ul .ui-corner-all').removeClass('show');
                // $this.parent().find('.menu-ul .ui-corner-all').slideUp(350);
                $this.parent().toggleClass('show');
                // $this.next().slideToggle(350);
            }
        });
        
        $(".menu-ul > li").click(function(event){
            event.stopPropagation();
          });
        // responsive menu toggle end  
        var gid = '#cwsMenu-1';
        $('#cwsMenu-1').cwsmenu({
                group_id : '#cwsMenu-1',
                menu_type:'mega-menu',
                responsive_breakpoint:'767px',
        });
    }
);
