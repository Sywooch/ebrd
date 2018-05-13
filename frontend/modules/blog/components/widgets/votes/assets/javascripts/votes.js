 var rating = 0;

 function move(e, obj){
    var summ = 0;
    var id = obj.next().attr('id').substr(1);
    var progress = e.pageX - obj.offset().left;
    var width = $('.stars').width();
    rating = Math.ceil(progress * 5 / width);
    $('#param'+id).text(rating.toFixed(1));
    obj.next().width((width / 5) * rating);
 }

function fixRate(value) {
    var width = $('.stars').width();
    var newWidth = (width / 5) * value;
    console.log(newWidth);
    $('.rate_progress').width(newWidth);
}


 $('#rating .stars').click(function(e){
    var $this = $(this);
    summ = parseFloat($('#summ').text());
    var Id = $('#rating').data('id');
    var isBlogPost = $('#rating').data('post');
    jQuery.post('/blog/common/add-vote', {
        Id: Id,
        rating: rating,
        isBlogPost: isBlogPost
    })
    .done(function (r)
    {
        var answer = r.rating;
        if (!isNaN(answer)){
            $this.addClass('fixed');
            $('#rating .rating').text(answer);
        }       
    })
    .fail(function (r) {
        console.log('Fail');
    });
 });

 $('#rating .stars').on('mousemove', function(e){
    if ($(this).hasClass('fixed')==false) move(e, $(this));
 });

var currenRating = $('#rating .rating').text();
    fixRate(currenRating);