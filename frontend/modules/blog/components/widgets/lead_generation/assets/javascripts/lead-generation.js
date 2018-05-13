var static_comp = $('.comp_container input[type=range]').val();
var static_range = $('.range_container input[type=range]').val();
$('.range_calc').text(static_range);
getPrice(static_comp, static_range);

$(document).on('input','.comp_container input',function(){
    $('.my_grade').removeClass('grade_visible');
    $('.grade_'+this.value).addClass('grade_visible');
    var range = $('.range_container input[type=range]').val();
    getPrice(this.value, range);
});
$(document).on('input','.range_container input',function(){
    $('.range_calc').text(this.value);
    var complex = $('.comp_container input[type=range]').val();
    getPrice(complex, this.value);
});

function getPrice(complex, range){
    if(complex == 1){
        complex = 42;
    }else if(complex == 2){
        complex = 46;
    }else if(complex == 3){
        complex = 104;
    }else if(complex == 4){
        complex = 177;
    }
    $('#result_generation').val(complex * range);
    $('.display_result').text(complex * range);
}

$('#lead_generation_form').on('beforeSubmit', function(e) {
    var form = $(this);
    var formData = form.serialize();
    form.find('button[type="submit"]').attr('disabled','disabled');
    $('.lead_generation_thanks').addClass('lead_generation_thanks_open');
    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: formData,
        success: function (data) {
            form.find('button[type="submit"]').removeAttr('disabled');
            $('.js_clear').val('');
            setTimeout(function(event){
                $('.lead_generation_thanks').removeClass('lead_generation_thanks_open');
                $('.lead_generation_overlay').removeClass('lead_generation_overlay_open');
            },3000);
        }
    });
}).on('submit', function(e){
    e.preventDefault();
});