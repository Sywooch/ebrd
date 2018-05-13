function lockUser(e, userId){
	var target = $(e.target).parent('a');
	var initialHtml = target.html();
	console.log();
	setSpinner(target);
	e.preventDefault();
	$.get({
		'url' : '/user/default/block',
		'data' : {
			'id':userId
		}
	}).done(function(responce){
		var result = $.parseJSON(responce);
		console.log();
		if (result.success){
			$('#us_status_' + result.userId).html(result.status);
			target.attr('onclick', result.parentOnclick);
			target.attr('title', result.parentTitle);
			target.html(result.icon);
		} else {
			target.html(initialHtml);
		}
	});
};

function unlockUser(e, userId){
	var target = $(e.target).parent('a');
	var initialHtml = target.html();
	console.log();
	setSpinner(target);
	e.preventDefault();
	$.get({
		'url' : '/user/default/unblock',
		'data' : {
			'id':userId
		}
	}).done(function(responce){
		var result = $.parseJSON(responce);
		console.log();
		if (result.success){
			$('#us_status_' + result.userId).html(result.status);
			target.attr('onclick', result.parentOnclick);
			target.attr('title', result.parentTitle);
			target.html(result.icon);
		} else {
			target.html(initialHtml);
		}
	});
};

function setSpinner(target){
	$(target).html('<i class="fa fa-spinner fa-spin"></i>');
};


$('.profile_input').on('click',function(event){
    if($(this).hasClass('editible')){
        $(this).text('').removeClass('editible').prepend('<input class="saving_val" value="'+ $(this).attr("data-val") +'"><i class="profile_save glyphicon glyphicon-floppy-disk save_ico"></i>');
    }
});

$('.profile_input').on('click','.profile_save',function(event){
    var val = $(this).parents('.profile_input').find('.saving_val').val();
    var flag = $(this).parents('.profile_input').attr('data-flag');
    var delegate = $(this).parents('.profile_info_line').find('.profile_input');
    setTimeout(function(){
        delegate.addClass('editible');
    },100);
    $(this).parents('.profile_input').attr("data-val",val).html(val+'<i class="profile_pencil glyphicon glyphicon-pencil edit_ico"></i>');
    $.post({
            url : '/user/profile/save',
            data : {val:val,flag:flag}
    }).done(function(response){
        console.log('saved');
    });
});


$('#profile-avatar').change(function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#profile-avatar-img').attr('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    }
});


// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var placeSearch, autocomplete;
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
};

function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.

    autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('profile-city')),
        {types: ['(cities)']});

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
        });
    }
}
$('.ajax-change-club-status').click(function(){
	var action = $(this).attr('data-action');
	var user_id = $(this).attr('data-user_id');
    $.ajax({
		type: 'POST',
		cache: false,
		url: '/user/default/ajax-change-club-status',
		data: {
			'action': action,
			'user_id': user_id
		},
		success: function(response){
			console.log(response);
		}
	});
});