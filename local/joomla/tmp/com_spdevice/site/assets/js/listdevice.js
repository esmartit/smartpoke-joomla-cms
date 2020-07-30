/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			23rd July, 2020
	@created		14th April, 2020
	@package		SP Device
	@subpackage		listdevice.js
	@author			Adolfo Zignago <https://www.esmartit.es>	
	@copyright		Copyright (C) 2020. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

/* JS Document */

/***[JCBGUI.site_view.javascript_file.38.$$$$]***/
function closeModal() {
    $('#deviceModal').modal('hide');
    if ($('.modal-backdrop').is(':visible')) {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }
}

jQuery(document).ready(function(){
    jQuery('#modalForm').submit(function(e) {
        deviceAction();
        e.preventDefault();
    });
});

function deviceAction() {
    $.ajax({
        data: { task: "deviceCRUD", format: "json", view: "listdevice",
            id: $(".modal-body #id").val(),
            opt: $(".modal-body #option").val(),
            device: $("#device").val(),
            type: $('input[name="deviceType"]:radio:checked').val()
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

jQuery(document).ready(function () {
    let type = '';
    $('#typeOther').on('change', function () {
        type = $('#typeOther').val();
        $('input[name="deviceType"]:radio:checked').val(type);
    });

    $('#typeFM').on('change', function () {
        type = $('#typeFM').val();
        $('input[name="deviceType"]:radio:checked').val(type);
    });
});

jQuery(document).on("click", ".open-deviceModal", function () {
    let title = $(this).data('title');
    let id = $(this).data('info').id;
    let device = $(this).data('info').device;
    let type = $(this).data('info').type;
    let option = $(this).data('info').option;
    $(".modal-title").text( title + ' Device' );
    $(".modal-body #id").val(id);
    $(".modal-body #option").val(option);
    $("#device").val(device);
    $('input[name="deviceType"]:radio:checked').val(type);
    $("#device").prop( 'disabled', false );
    $('input[name="deviceType"]').prop("disabled", false);
    document.getElementById( 'btnSave' ).style.display = 'block';
    document.getElementById( 'btnSave' ).textContent = title;
    switch (option) {
        case "C":
            document.getElementById( 'btnSave' ).textContent = 'Save';
            break;
        case "R":
            document.getElementById( 'btnSave' ).style.display = 'none';
            $("#device").prop( 'disabled', true );
            $('input[name="deviceType"]').prop("disabled", true);
            break;
        case "U":
            break;
        case "D":
            $("#device").prop( 'disabled', true );
            $('input[name="deviceType"]').prop("disabled", true);
            break;
    }

});/***[/JCBGUI$$$$]***/
