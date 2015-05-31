/**
 * Handles toggling the navigation menu for small screens.
 */
(function($) {
    var cont = $( '#site-navigation' );
    var n_btn=$('button.menu-toggle');
    var s_btn=$('button.search-toggle');
    n_btn.click(function(){
        if(cont.hasClass('main-small-navigation')){
            cont.removeClass('main-small-navigation').addClass('main-navigation');
            n_btn.find('i').removeClass('fa-remove').addClass('fa fa-navicon');

        }else{
            cont.removeClass('main-navigation').addClass('main-small-navigation');
            n_btn.find('i').removeClass('fa-navicon').addClass('fa-remove');
        }
    });
    s_btn.click(function(){
        $('.nav-search-box:not(:visible)','#masthead').toggle().find('.s').focus();
    });
    $("body").bind("mouseup", function (b) {
        var c = $(".nav-search-box:visible");
        if (!c.is(b.target) && c.has(b.target).length === 0 && c.length) {
            c.fadeOut();
            b.stopPropagation()
        }
    })
})(jQuery);
/*slider on front page*/
jQuery(function($) {
    var slider= $('.slider-rotate');
    var slides = slider.children().length;
    if (slides <= 1) {
        $('.slider-nav').hide(0)
    } else {
        $('.slider-nav').show(0)
    }
    $(window).load(function () {
        if(slider.length&&$(window).width()>361) {
        slider.cycle({
             fx: 'fade',
             prev: '.slide-prev',
             next: '.slide-next',
             activePagerClass: 'active',
             timeout: 5,
             speed: 2000,
             pause: 1,
             pauseOnPagerHover: 1,
             width: '100%',
             containerResize: 0,
             slideResize:1,
             fit: 1,
             cleartypeNoBg: true,
             after: function () {
             $(this).parent().css("height", $(this).height());
             }
             });
        }
    });
} );/*end jquery*/

jQuery(function($) {
/*smooth scroll*/
$("a[href*=#]:not([href=#])").click(function () {
    if (location.pathname.replace(/^\//, "") == this.pathname.replace(/^\//, "") && location.hostname == this.hostname) {
        var a = $(this.hash);
        a = a.length ? a : $("[name=" + this.hash.slice(1) + "]");
        if (a.length) {
            $("html,body").animate({scrollTop: a.offset().top}, 600);
            return false
        }
    }
});
/*move to top*/
var ttop=$(".scroll-top");
$(window).scroll(function (a) {
    if ($(window).scrollTop() > 800) {
        ttop.css({bottom:"30px"});
    } else {
        ttop.css({bottom:"-100px"});
    }
    a.stopPropagation();
});
    /*hide/show comment form help*/
    $('textarea#comment',"#commentform").click(function(){
        $('p.form-allowed-tags',"#commentform").slideDown('fast');
    });

    /*esc to cancel floating form*/
    $(window).keydown(function (a) {
        if (a.keyCode == 27) {
             $('.floating-form:visible').fadeOut();
            $('.float-btn:not(:visible)').show();
            a.stopPropagation();
        }
    });

    /*fix header on scroll */
    if($('body').hasClass('home')){
        control_fixed_header();
    }
    /*wrap into a function to avoid conflicts*/
    function control_fixed_header(){
        var mh=$("#masthead");
        var mhh=mh.height();
        var sl=$("#featured-slider");
        var pg=$("#page");
        var hi = sl.offset().top + sl.height();
        $(window).scroll(function (a) {
            if($(window).width()>768){
                if ($(window).scrollTop() > hi) {
                    mh.addClass("h-fixed");
                    pg.css('padding-top',mhh);
                } else {
                    pg.css('padding-top',85);
                    mh.removeClass("h-fixed");
                }
                a.stopPropagation();
            }
        });
    }

} );/*end jquery*/
