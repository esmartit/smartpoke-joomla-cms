/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			23rd July, 2020
	@created		14th April, 2020
	@package		SP Value
	@subpackage		listvalue.js
	@author			Adolfo Zignago <https://www.esmartit.es>	
	@copyright		Copyright (C) 2020. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

/* JS Document */

/***[JCBGUI.site_view.javascript_file.32.$$$$]***/
function closeModal() {
    $('#valueModal').modal('hide');
    if ($('.modal-backdrop').is(':visible')) {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }
}

jQuery(document).ready(function(){
    jQuery('#modalForm').submit(function(e) {
        valueAction();
        e.preventDefault();
    });
});

function valueAction() {
    $.ajax({
        data: { task: "valueCRUD", format: "json", view: "listvalue",
            id: $(".modal-body #id").val(),
            opt: $(".modal-body #option").val(),
            name: $("#name").val(),
            code: $("#code").val(),
            value: $("#value").val()
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

jQuery(document).on("click", ".open-valueModal", function () {
    let title = $(this).data('title');
    let id = $(this).data('info').id;
    let name = $(this).data('info').name;
    let code = $(this).data('info').code;
    let value = $(this).data('info').value;
    let option = $(this).data('info').option;
    $(".modal-title").text( title + ' Value' );
    $(".modal-body #id").val(id);
    $(".modal-body #option").val(option);
    $("#name").val(name);
    $("#code").val(code);
    $("#value").val(value);
    $("#name").prop( 'disabled', false );
    $("#code").prop( 'disabled', false );
    $("#value").prop( 'disabled', true );
    document.getElementById( 'btnSave' ).style.display = 'block';
    document.getElementById( 'btnSave' ).textContent = title;
    switch (option) {
        case "C":
            document.getElementById( 'btnSave' ).textContent = 'Save';
            break;
        case "R":
            document.getElementById( 'btnSave' ).style.display = 'none';
            $("#name").prop( 'disabled', true );
            $("#code").prop( 'disabled', true );
            $("#value").prop( 'disabled', true );
            break;
        case "U":
            $("#name").prop( 'disabled', true );
            $("#code").prop( 'disabled', true );
            if (code == 'daily_goal_device' || code == 'daily_goal_registered') {
                $("#value").prop( 'disabled', false );
            }
            break;
        case "D":
            $("#name").prop( 'disabled', true );
            $("#code").prop( 'disabled', true );
            $("#value").prop( 'disabled', true );
            break;
    }

});/***[/JCBGUI$$$$]***/
