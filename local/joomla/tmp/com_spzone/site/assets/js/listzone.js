/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			23rd July, 2020
	@created		14th April, 2020
	@package		SP Zone
	@subpackage		listzone.js
	@author			Adolfo Zignago <https://www.esmartit.es>	
	@copyright		Copyright (C) 2020. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

/* JS Document */

/***[JCBGUI.site_view.javascript_file.34.$$$$]***/
function closeModal() {
    $('#zoneModal').modal('hide');
    if ($('.modal-backdrop').is(':visible')) {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }
}

jQuery(document).ready(function(){
    jQuery('#modalForm').submit(function(e) {
        zoneAction();
        e.preventDefault();
    });
});

function zoneAction() {
    $.ajax({
        data: { task: "zoneCRUD", format: "json", view: "listzone",
            id: $(".modal-body #id").val(),
            opt: $(".modal-body #option").val(),
            zone: $("#zone").val()
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

jQuery(document).on("click", ".open-zoneModal", function () {
    let title = $(this).data('title');
    let id = $(this).data('info').id;
    let zone = $(this).data('info').zone;
    let option = $(this).data('info').option;
    $(".modal-title").text( title + ' Zone' );
    $(".modal-body #id").val(id);
    $(".modal-body #option").val(option);
    $("#zone").val(zone);
    $("#zone").prop( 'disabled', false );
    document.getElementById( 'btnSave' ).style.display = 'block';
    document.getElementById( 'btnSave' ).textContent = title;
    switch (option) {
        case "C":
            document.getElementById( 'btnSave' ).textContent = 'Save';
            break;
        case "R":
            document.getElementById( 'btnSave' ).style.display = 'none';
            $("#zone").prop( 'disabled', true );
            break;
        case "U":
            break;
        case "D":
            $("#zone").prop( 'disabled', true );
            break;
    }

});/***[/JCBGUI$$$$]***/
