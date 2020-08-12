/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			12th August, 2020
	@created		7th April, 2020
	@package		SP Nas
	@subpackage		listnas.js
	@author			Adolfo Zignago <https://www.esmartit.es>	
	@copyright		Copyright (C) 2020. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

/* JS Document */

/***[JCBGUI.site_view.javascript_file.44.$$$$]***/
function closeModal() {
    $('#nasModal').modal('hide');
    if ($('.modal-backdrop').is(':visible')) {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }
}

jQuery(document).ready(function(){
    jQuery('#modalForm').submit(function(e) {
        nasAction();
        e.preventDefault();
    });
});

function nasAction() {
    $.ajax({
        data: { task: "nasCRUD", format: "json", view: "listnas",
            id: $(".modal-body #id").val(),
            opt: $(".modal-body #option").val(),
            name: $("#name").val(),
            shortName: $("#shortName").val(),
            type: $("#selType").val(),
            secret: $("#secret").val(),
            ports: $("#ports").val(),
            server: $("#server").val(),
            community: $("#community").val(),
            description: $("#description").val()
        },
        success: function(response, status, xhr) {

            console.log(response);
            let object = response.data[0];
            let section = object['section'];
            let data = object['data'];

            if (section == "error") {
                Joomla.renderMessages({'error': [data]});
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

jQuery(document).on("click", ".open-nasModal", function () {
    let title = $(this).data('title');
    let id = $(this).data('info').id;
    let name = $(this).data('info').name;
    let shortName = $(this).data('info').shortName;
    let type = $(this).data('info').type;
    let secret = $(this).data('info').secret;
    let ports = $(this).data('info').ports;
    let server = $(this).data('info').server;
    let community = $(this).data('info').community;
    let description = $(this).data('info').description;
    let option = $(this).data('info').option;

    $(".modal-title").text( title + ' Nas' );
    $(".modal-body #id").val(id);
    $(".modal-body #option").val(option);

    $("#name").val(name);
    $("#shortName").val(shortName);
    $("#selType").val(type);
    $("#secret").val(secret);
    $("#ports").val(ports);
    $("#server").val(server);
    $("#community").val(community);
    $("#description").val(description);

    $("#name").prop('disabled', false);
    $("#shortName").prop('disabled', false);
    $("#selType").prop('disabled', false);
    $("#secret").prop('disabled', false);
    $("#ports").prop('disabled', false);
    $("#server").prop('disabled', false);
    $("#community").prop('disabled', false);
    $("#description").prop('disabled', false);
    document.getElementById( 'btnSave' ).style.display = 'block';
    document.getElementById( 'btnSave' ).textContent = title;
    switch (option) {
        case "C":
            document.getElementById( 'btnSave' ).textContent = 'Save';
            break;
        case "R":
            document.getElementById( 'btnSave' ).style.display = 'none';
            $("#name").prop('disabled', true);
            $("#shortName").prop('disabled', true);
            $("#selType").prop('disabled', true);
            $("#secret").prop('disabled', true);
            $("#ports").prop('disabled', true);
            $("#server").prop('disabled', true);
            $("#community").prop('disabled', true);
            $("#description").prop('disabled', true);
            break;
        case "U":
            break;
        case "D":
            $("#name").prop('disabled', true);
            $("#shortName").prop('disabled', true);
            $("#selType").prop('disabled', true);
            $("#secret").prop('disabled', true);
            $("#ports").prop('disabled', true);
            $("#server").prop('disabled', true);
            $("#community").prop('disabled', true);
            $("#description").prop('disabled', true);
            break;
    }
});/***[/JCBGUI$$$$]***/
