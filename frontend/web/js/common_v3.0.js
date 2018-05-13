$.get('/sass/ebrd/svg_sprite.svg', function(data){
  $('body').prepend(data);
},'html');

$('.btn_add_link').on('click',function(event){
    var i;
    if($('.nav_js_report').is(':empty')) {
        i = 0;
    }else{
        var x = $('.input_link_container').last().attr('data-text');
        i = parseInt(x) + 1;
    }
    $('.nav_js_report').append('<div class="input_link_container"><div class="link_input"><input class="name_report_json" placeholder="Page Name" type="text"></div><div class="link_input"><input placeholder="Page URL" class="value_report_json" type="text"></div><div class="remove_cross">X</div></div>');
});

$('.report_link_inside').eq(0).addClass('active_frame_nav');

$('.new_thank_right').html('<img src="https://aimarketing.info/images/thanks.gif">')

$('.thanks_social').each(function(index){
        var id = $(this).attr('data-svg');
        $(this).find('a').prepend('<svg><use xlink:href="#'+id+'"></use></svg>')
});

$('.image_indu').each(function(index){
        var id = $(this).attr('data-svg');
        $(this).prepend('<svg><use xlink:href="#'+id+'"></use></svg>')
});

$('.demo_container_user').addClass('visible_demo');

$('.report_link_inside').on('click',function(){
    $('.report_link_inside').removeClass('active_frame_nav');
    $(this).addClass('active_frame_nav');
});

$('.nav_js_report').on('click','.remove_cross',function(event){
    $(this).parents('.input_link_container').remove();
});

$('.link_frame_nav').on('click',function(event){
    event.preventDefault();
    $('.report_view_container').find('iframe').attr('src',$(this).attr('href'));
});

$('#my_form_js').submit(function(event) {
    var data = {};
    $('.input_link_container').each(function(index){
        var name = $('.input_link_container').eq(index).find('.name_report_json').val(),
            value = $('.input_link_container').eq(index).find('.value_report_json').val();

        data[index] = {name: name, value: value};
    });
    var json = JSON.stringify(data);
    $('#json_get').val(json);
});

var cta = function(){
    var wintop = $(window).scrollTop();
    if(wintop >= 450){
        $('.cta_fixed').removeClass('cta_hidden');
    }else if(wintop < 450){
        $('.cta_fixed').addClass('cta_hidden');
    }
}

$(window).on('scroll', cta);

$('.cta_close').on('click',function(event){
    $('.cta_fixed').addClass('cta_hidden');
    $(window).off('scroll',cta);
});

$('.blog_search_btn').on('click',function(event){
    event.preventDefault();
    $('.blog_search').slideToggle();
});

$('.create_team_alert').on('click',function(event){
    var isAdmin = confirm("Create company?");
    if(!isAdmin){
        event.preventDefault();
    }
});

$('.admin_main_drop li.active').parents('.has_child').addClass('active')

$('.btn_glass').on('click',function(){
        if($('#form_search').hasClass('opened_search')){
            $('.js_submitting').submit();
        }
	$('#form_search').addClass('opened_search');
        setTimeout(function(event){
            $('#form_search').find('input').focus();
        },100)
	$(document).click(function(event) {
            if ($(event.target).closest(".btn_glass,#form_search").length) return;
            $('#form_search').removeClass('opened_search');
            event.stopPropagation();
	});
        $(document).keyup(function(e) {
            if (e.keyCode == 27) {
                $('#form_search').removeClass('opened_search');
            }
        });
});

$(".parent_block").on('mouseenter',function() {
    var self = $(this);
    var timerId = setTimeout(function() {
        self.find(".menu_block,.menu_block_child").addClass('main_menu_fade_in');
    }, 100)
    self.on('mouseleave',function() {
        clearTimeout(timerId);
        self.find(".menu_block,.menu_block_child").removeClass('main_menu_fade_in');
    });
});

$(document).on('click','.scrolling',function(event){
    event.preventDefault();
    var root = $('html, body'),
        coords;
    if($.attr(this, 'href') === '#bottom_scroll'){
        coords = $(window).height();
    }else{
        coords = 0;
    }
    root.stop().animate({
        scrollTop: $( $.attr(this, 'href') ).offset().top - coords
    }, 400);
});

$(document).on('click' ,'.open_popup' ,function(event){
    $('.myModalContainer').addClass('opened_magick');
});

$(document).click(function(event) {
    if ($(event.target).closest('.myModal,.open_popup').length) return;
    $('.myModalContainer').removeClass('opened_magick');
    $('#customModal').html('');
    event.stopPropagation();
});

$(document).on('click', '.all_product_member a', function (e) {
    e.preventDefault();
    var forTabs = $(this).parent().parent().find(".all_product_contect>div");
    for (let i=0, max=forTabs.length; i<max; i++) {
        forTabs[i].style.display="none";
    }
    forTabs[$(this).index()].style.display = "block";
});

$('.btn-mobile_container').click(function (e) {
    e.preventDefault();
    $('.main_menu_s_container').toggleClass('main_menu_s_active');
    $('.btn-mobile_container').toggleClass('btn_main_menu_s_active');
});


$('.social_tab').on('click',function(event){
	event.preventDefault();
	var width = 740,
		height = 740,
		url = $(this).attr('href');
	window.open( url, '', 'width=' + width + ',height=' + height + ',left=' + ((window.innerWidth - width)/2) + ',top=' + ((window.innerHeight - height)/2) );
});

$('.admin-btn-mobile').click(function (e) {
    e.preventDefault();
    $(this).parents().find('.admin_main_menu').toggleClass('admin_main_menu_mob');
});

// conjoint select diagram

$(document).on('change', '#diagram_select', function (e) {
    e.stopPropagation();
    var id_ = $(this).attr('data-ref');
    var gallery =  $('div[data-id='+id_+']');
    var count_images = gallery.find(".diagram").length;
    var currentItem =  gallery.find(".diagram.showing").index();

    var setIndex = this.selectedIndex;

    $('div[data-id='+id_+']').find('.diagram').removeClass('showing');
    $('div[data-id='+id_+']').children().eq(setIndex).addClass('showing');

    $(".for_tabs_conj_wrap>div").hide();
    $(".for_tabs_conj_wrap div[data-id="+ id_ + "]").show();
});

$('.href_action_blog').on('click',function(event){
    var location = $(this).attr('data-href');
    window.location.href = location;
});
$(window).on('load', function() {
   Pizza.init();
});

function sendYandexLogin(){
	yaCounter47926829.reachGoal('login-form');
	return true;
}

function sendYandexSignup(){
	yaCounter47926829.reachGoal('form-signup');
	return true;
}

$(document).on('click' ,'.chat-opener' ,function(event){
    $('.chat').toggleClass('chat__showed');
});
$(document).on('click' ,'.chat__close' ,function(event){
    $('.chat').removeClass('chat__showed');
});
