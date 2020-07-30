/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			30th July, 2020
	@created		14th April, 2020
	@package		SP Sensor
	@subpackage		listsensor.js
	@author			Adolfo Zignago <https://www.esmartit.es>	
	@copyright		Copyright (C) 2020. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

/* JS Document */

/***[JCBGUI.site_view.javascript_file.36.$$$$]***/
function closeModal() {
    $('#sensorModal').modal('hide');
    if ($('.modal-backdrop').is(':visible')) {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }
}

jQuery(document).ready(function() {
    if (typeof ($.fn.ionRangeSlider) === 'undefined') { return; }
    console.log('init_IonRangeSlider');

    $("#range_pwrIn").ionRangeSlider({
        min: -99,
        max: -2,
        from: -45,
        grid: true,
        grid_num: 10,
        grid_snap: false
    });
    $("#range_pwrLimit").ionRangeSlider({
        min: -99,
        max: -2,
        from: -48,
        grid: true,
        grid_num: 10,
        grid_snap: false
    });
    $("#range_pwrOut").ionRangeSlider({
        min: -99,
        max: -2,
        from: -65,
        grid: true,
        grid_num: 10,
        grid_snap: false
    });

});

jQuery(document).ready(function(){
    jQuery('#modalForm').submit(function(e) {
        sensorAction();
        e.preventDefault();
    });
});

function sensorAction() {
    $.ajax({
        data: { task: "sensorCRUD", format: "json", view: "listsensor",
            id: $(".modal-body #id").val(),
            opt: $(".modal-body #option").val(),
            spot: $("#selSpot").val(),
            sensor: $("#sensorId").val(),
            location: $("#location").val(),
            zone: $("#selZone").val(),
            pwrIn: $("#range_pwrIn").val(),
            pwrLimit: $("#range_pwrLimit").val(),
            pwrOut: $("#range_pwrOut").val()
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

jQuery(document).on("click", ".open-sensorModal", function () {
    let title = $(this).data('title');
    let id = $(this).data('info').id;
    let spot = $(this).data('info').spot;
    let sensorId = $(this).data('info').sensorId;
    let location = $(this).data('info').location;
    let zoneId = $(this).data('info').zoneId;
    let pwrIn = $(this).data('info').pwrIn;
    let pwrLimit = $(this).data('info').pwrLimit;
    let pwrOut = $(this).data('info').pwrOut;
    let option = $(this).data('info').option;
    $(".modal-title").text( title + ' Sensor' );
    $(".modal-body #id").val(id);
    $(".modal-body #option").val(option);

    $("#selSpot").val(spot);
    $("#sensorId").val(sensorId);
    $("#location").val(location);
    $("#selZone").val(zoneId);
    let iIn = $("#range_pwrIn").data("ionRangeSlider");
    iIn.update({from: pwrIn});
    let iLimit = $("#range_pwrLimit").data("ionRangeSlider");
    iLimit.update({from: pwrLimit});
    let iOut = $("#range_pwrOut").data("ionRangeSlider");
    iOut.update({from: pwrOut});

    $("#selSpot").prop( 'disabled', false );
    $("#sensorId").prop( 'disabled', false );
    $("#location").prop( 'disabled', false );
    $("#selZone").prop( 'disabled', false );
    $("#range_pwrIn").prop( 'disabled', false );
    $("#range_pwrLimit").prop( 'disabled', false );
    $("#range_pwrOut").prop( 'disabled', false );
    document.getElementById( 'btnSave' ).style.display = 'block';
    document.getElementById( 'btnSave' ).textContent = title;
    switch (option) {
        case "C":
            document.getElementById( 'btnSave' ).textContent = 'Save';
            break;
        case "R":
            document.getElementById( 'btnSave' ).style.display = 'none';
            $("#selSpot").prop( 'disabled', true );
            $("#sensorId").prop( 'disabled', true );
            $("#location").prop( 'disabled', true );
            $("#selZone").prop( 'disabled', true );
            $("#range_pwrIn").prop( 'disabled', true );
            $("#range_pwrLimit").prop( 'disabled', true );
            $("#range_pwrOut").prop( 'disabled', true );
            break;
        case "U":
            break;
        case "D":
            $("#selSpot").prop( 'disabled', true );
            $("#sensorId").prop( 'disabled', true );
            $("#location").prop( 'disabled', true );
            $("#selZone").prop( 'disabled', true );
            $("#range_pwrIn").prop( 'disabled', true );
            $("#range_pwrLimit").prop( 'disabled', true );
            $("#range_pwrOut").prop( 'disabled', true );
            break;
    }

});/***[/JCBGUI$$$$]***/
