$(window).scroll(function() {
    var wintop = $(window).scrollTop(), 
    docheight = $('body').height(), 
    winheight = $(window).height();
    var totalScroll = (wintop/(docheight-winheight))*100;
    $(".progress_bar").css("width",totalScroll+"%");
    if(wintop >= 450){
        $('.blog_menu_widget').addClass('blog_menu_widget_open');
    }else if(wintop < 450){
        $('.blog_menu_widget').removeClass('blog_menu_widget_open');
    }
});