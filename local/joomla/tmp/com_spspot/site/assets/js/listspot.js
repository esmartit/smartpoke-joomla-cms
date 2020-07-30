/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.2
	@build			29th July, 2020
	@created		14th April, 2020
	@package		SP Spot
	@subpackage		listspot.js
	@author			Adolfo Zignago <https://www.esmartit.es>	
	@copyright		Copyright (C) 2020. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

/* JS Document */

/***[JCBGUI.site_view.javascript_file.30.$$$$]***/
function closeModal() {
    $('#spotModal').modal('hide');
    if ($('.modal-backdrop').is(':visible')) {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }
}

jQuery(document).ready(function(){
    jQuery('#modalForm').submit(function(e) {
        spotAction();
        e.preventDefault();
    });
});

function spotAction() {
    $.ajax({
        data: { task: "spotCRUD", format: "json", view: "listspot",
            id: $(".modal-body #id").val(),
            opt: $(".modal-body #option").val(),
            spotId: $("#spotId").val(),
            spotName: $("#spotName").val(),
            businessId: $("#selBusiness").val(),
            latitude: $("#latitude").val(),
            longitude: $("#longitude").val(),
            countryId: $("#selCountry").val(),
            stateId: $("#selState").val(),
            cityId: $("#selCity").val(),
            zipCode: $("#selZipCode").val(),
        },
        success: function(response, status, xhr) {

            console.log(response);
            let object = response.data[0];
            let section = object['section'];
            let data = object['data'];

            if (section == "error") {
                Joomla.renderMessages({'alert': [data]});
            } else {
                closeModal();
                location.reload();
                Joomla.renderMessages({'success': [data]});
            }
        },
        error: function() {
            console.log('ajax call failed');
        },
    });
}

function getStates(state = null) {
    $.ajax({
        data: { task: "spotCRUD", format: "json", view: "liststate",
            countryId: $("#selCountry").val()
        },
        success: function(response, status, xhr) {

            console.log(response);
            let object = response.data;
            let len = object.length;

            $("#selState").empty();
            $("#selState").append("<option value='' selected disabled>Select State</option>");
            for (let i = 0; i<len; i++) {

                let id = object[i]['state_code'];
                let name = object[i]['name'];

                if (state == id) {
                    $("#selState").append("<option value='"+id+"' selected>"+name+"</option>");
                } else {
                    $("#selState").append("<option value='"+id+"'>"+name+"</option>");
                }

            }
        },
        error: function() {
            console.log('ajax call failed');
        },
    });
}

function getCities(state = null, city = null) {
    if (state == null) {
        state = $("#selState").val();
    }
    $.ajax({
        data: { task: "spotCRUD", format: "json", view: "listcity",
            stateId: state
        },
        success: function(response, status, xhr) {

            console.log(response);
            let object = response.data;
            let len = object.length;

            $("#selCity").empty();
            $("#selCity").append("<option value='' selected disabled>Select City</option>");
            for (let i = 0; i<len; i++) {

                let id = object[i]['city_code'];
                let name = object[i]['name'];

                if (city == id) {
                    $("#selCity").append("<option value='" + id + "' selected>" + name + "</option>");
                } else {
                    $("#selCity").append("<option value='" + id + "'>" + name + "</option>");
                }
            }
        },
        error: function() {
            console.log('ajax call failed');
        },
    });
}

function getZipCodes(city = null, zipcode = null) {
    if(city == null) {
        city = $("#selCity").val();
    }
    $.ajax({
        data: { task: "spotCRUD", format: "json", view: "listzipcode",
            cityId: city
        },
        success: function(response, status, xhr) {

            console.log(response);
            let object = response.data;
            let len = object.length;

            $("#selZipCode").empty();
            $("#selZipCode").append("<option value='' selected disabled>Select ZipCode</option>");
            for (let i = 0; i<len; i++) {

                let id = object[i]['zipcode'];
                let name = object[i]['location'];

                if (zipcode == id) {
                    $("#selZipCode").append("<option value='"+id+"' selected>"+id+" - "+name+"</option>");
                } else {
                    $("#selZipCode").append("<option value='"+id+"'>"+id+" - "+name+"</option>");
                }
            }
        },
        error: function() {
            console.log('ajax call failed');
        },
    });
}

jQuery(document).on("click", ".open-spotModal", function () {
    let title = $(this).data('title');
    let id = $(this).data('info').id;
    let spotId = $(this).data('info').spotId;
    let spotName = $(this).data('info').spotName;
    let businessId = $(this).data('info').businessId;
    let latitude = $(this).data('info').latitude;
    let longitude = $(this).data('info').longitude;
    let countryId = $(this).data('info').countryId;
    let stateId = $(this).data('info').stateId;
    let cityId = $(this).data('info').cityId;
    let zipCode = $(this).data('info').zipcode;
    let option = $(this).data('info').option;
    $(".modal-title").text( title + ' Spot' );
    $(".modal-body #id").val(id);
    $(".modal-body #option").val(option);

    $("#spotId").val(spotId);
    $("#spotName").val(spotName);
    $("#selBusiness").val(businessId);
    $("#latitude").val(latitude);
    $("#longitude").val(longitude);
    $("#selCountry").val(countryId);
    getStates(stateId);
    // $("#selState").val(stateId);
    getCities(stateId, cityId);
    // $("#selCity").val(cityId);
    getZipCodes(cityId, zipCode);
    // $("#selZipCode").val(zipCode);

    $("#spotId").prop('disabled', false);
    $("#spotName").prop('disabled', false);
    $("#selBusiness").prop('disabled', false);
    $("#latitude").prop('disabled', false);
    $("#longitude").prop('disabled', false);
    $("#selCountry").prop('disabled', false);
    $("#selState").prop('disabled', false);
    $("#selCity").prop('disabled', false);
    $("#selZipCode").prop('disabled', false);
    document.getElementById( 'btnSave' ).style.display = 'block';
    document.getElementById( 'btnSave' ).textContent = title;
    switch (option) {
        case "C":
            document.getElementById( 'btnSave' ).textContent = 'Save';
            break;
        case "R":
            document.getElementById( 'btnSave' ).style.display = 'none';
            $("#spotId").prop('disabled', true);
            $("#spotName").prop('disabled', true);
            $("#selBusiness").prop('disabled', true);
            $("#latitude").prop('disabled', true);
            $("#longitude").prop('disabled', true);
            $("#selCountry").prop('disabled', true);
            $("#selState").prop('disabled', true);
            $("#selCity").prop('disabled', true);
            $("#selZipCode").prop('disabled', true);
            break;
        case "U":
            $("#spotId").prop('disabled', true);
            $("#selCountry").prop('disabled', true);
            $("#selState").prop('disabled', true);
            $("#selCity").prop('disabled', true);
            $("#selZipCode").prop('disabled', true);
            break;
        case "D":
            $("#spotId").prop('disabled', true);
            $("#spotName").prop('disabled', true);
            $("#selBusiness").prop('disabled', true);
            $("#latitude").prop('disabled', true);
            $("#longitude").prop('disabled', true);
            $("#selCountry").prop('disabled', true);
            $("#selState").prop('disabled', true);
            $("#selCity").prop('disabled', true);
            $("#selZipCode").prop('disabled', true);
            break;
    }
});/***[/JCBGUI$$$$]***/
