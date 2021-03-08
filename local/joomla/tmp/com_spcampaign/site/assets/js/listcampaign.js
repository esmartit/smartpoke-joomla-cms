/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			30th July, 2020
	@created		6th April, 2020
	@package		SP Campaign
	@subpackage		listcampaign.js
	@author			Adolfo Zignago <https://www.esmartit.es>	
	@copyright		Copyright (C) 2020. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

/* JS Document */

/***[JCBGUI.site_view.javascript_file.40.$$$$]***/
function closeModal() {
    $('#campaignModal').modal('hide');
    if ($('.modal-backdrop').is(':visible')) {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }
}

jQuery(document).ready(function(){
    jQuery('#modalForm').submit(function(e) {
        campaignAction();
        e.preventDefault();
    });
});

jQuery(document).ready(function () {
    let smsemail = '';
    $('#radioSMS').on('change', function () {
        smsemail = $('#radioSMS').val();
        $('input[name="radioCampaign"]:radio:checked').val(smsemail);
    });

    $('#radioEmail').on('change', function () {
        smsemail = $('#radioEmail').val();
        $('input[name="radioCampaign"]:radio:checked').val(smsemail);
    });
});

jQuery(document).ready(function () {
    $('input[name="deferred"]').on('ifChanged', function () {
        let status = $('#deferred').val()
        if (status == 0)  {
            document.getElementById("dateDeferred").style.display = 'block';
            status = 1;
        } else {
            document.getElementById("dateDeferred").style.display = 'none';
            status = 0;
        }
        $('#deferred').val(status);
    });

    $('#validD').datetimepicker({
        ignoreReadonly: true,
        allowInputToggle: true,
        format: 'YYYY-MM-DD'
    });

    $('#deferredD').datetimepicker({
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
        inline: true,
        sideBySide: true,
        format: 'YYYY-MM-DD HH:mm'
    });
});

function showDeferredDate(status = null) {
    if (status == 0) {
        $('input[name=deferred]').iCheck('uncheck');
        document.getElementById("dateDeferred").style.display = 'none';
        $('#deferred').val(0);
    } else {
        $('input[name=deferred]').iCheck('check');
        document.getElementById("dateDeferred").style.display = 'block';
        $('#deferred').val(1);
    }
}

function campaignAction() {
    $.ajax({
        data: { task: "campaignCRUD", format: "json", view: "listcampaign",
            id: $(".modal-body #id").val(),
            opt: $(".modal-body #option").val(),
            name: $("#name").val(),
            validDate: $("#validDate").val(),
            smsEmail: $('input[name="radioCampaign"]:radio:checked').val(),
            messageType: document.getElementById("msgType").innerHTML,
            deferred: $("#deferred").val(),
            deferredDate: $("#deferredDate").val(),
            type: $("#selType").val()
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

jQuery(document).on("click", ".open-campaignModal", function () {
    let title = $(this).data('title');
    let id = $(this).data('info').id;
    let name = $(this).data('info').name;
    let validDate = $(this).data('info').validDate;
    let smsEmail = $(this).data('info').smsEmail;
    let messageSms = $(this).data('info').messageSms;
    let messageEmail = $(this).data('info').messageEmail;
    let type = $(this).data('info').type;
    let deferred = $(this).data('info').deferred;
    let deferredDate = $(this).data('info').deferredDate;
    let option = $(this).data('info').option;
    $(".modal-title").text( title + ' Campaign' );
    $(".modal-body #id").val(id);
    $(".modal-body #option").val(option);
    $("#name").val(name);
    $("#validDate").val(validDate);
    $('input[name="radioCampaign"]:radio:checked').val(smsEmail);
    if (smsEmail == 1) {
        document.getElementById("msgType").innerHTML = messageSms;
    } else {
        document.getElementById("msgType").innerHTML = messageEmail;
    }
    $("#deferred").val(deferred);
    showDeferredDate(deferred);
    $("#deferredDate").val(deferredDate);
    $("#selType").val(type);
    $("#name").prop('disabled', false);
    $("#validDate").prop('disabled', false);
    $('input[name="radioCampaign"]').prop("disabled", false);
    $("#messageText").prop('disabled', false);
    $("#msgType").prop('contenteditable', true);
    $('input[type="checkbox"]').attr('disabled', false);
    $("#deferredDate").prop('disabled', false);
    $("#selType").prop('disabled', false);
    document.getElementById( 'btnSave' ).style.display = 'block';
    document.getElementById( 'btnSave' ).textContent = title;
    switch (option) {
        case "C":
            document.getElementById( 'btnSave' ).textContent = 'Save';
            break;
        case "R":
            document.getElementById( 'btnSave' ).style.display = 'none';
            $("#name").prop('disabled', true);
            $("#validDate").prop('disabled', true);
            $('input[name="radioCampaign"]').prop("disabled", true);
            $("#messageText *").attr('disabled', 'disabled').off('click');
            $("#msgType").attr('contenteditable',false);
            $('input[type="checkbox"]').attr('disabled', true);
            $("#deferredDate").prop('disabled', true);
            $("#selType").prop('disabled', true);
            break;
        case "U":
            document.getElementById( 'btnSave' ).textContent = 'Save';
            break;
        case "D":
            $("#name").prop('disabled', true);
            $("#validDate").prop('disabled', true);
            $('input[name="radioCampaign"]').prop("disabled", true);
            $("#messageText *").attr('disabled', 'disabled').off('click');
            $("#msgType").attr('contenteditable',false);
            $('input[type="checkbox"]').attr('disabled', true);
            $("#deferredDate").prop('disabled', true);
            $("#selType").prop('disabled', true);
            break;
    }
});
/***[/JCBGUI$$$$]***/
