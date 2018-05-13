$('#js-add-event-to-user').on('click',function () {
    var $this = $(this);
    var value = $this.data('id');
    $.ajax({
        type: "GET",
        timeout: 50000,
        url: '/blog/event/bind?eventId='+value
    })
        .done(function(r) {
            $this.addClass('subscribed');
            $this.text(r.message);
        })
        .fail(function(r) {

        });

});
