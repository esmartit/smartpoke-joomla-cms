/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			12th August, 2020
	@created		12th June, 2020
	@package		SP Limitation
	@subpackage		listlimitation.js
	@author			Adolfo Zignago <https://www.esmartit.es>	
	@copyright		Copyright (C) 2020. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

/* JS Document */

/***[JCBGUI.site_view.javascript_file.46.$$$$]***/
function closeModal() {
    $('#limitationModal').modal('hide');
    if ($('.modal-backdrop').is(':visible')) {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }
}

jQuery(document).ready(function(){
    jQuery('#modalForm').submit(function(e) {
        limitationAction();
        e.preventDefault();
    });
});

function limitationAction() {
    $.ajax({
        data: { task: "limitationCRUD", format: "json", view: "listlimitation",
            id: $(".modal-body #id").val(),
            opt: $(".modal-body #option").val(),
            name: $("#name").val(),
            maxUpload: $("#maxUpload").val(),
            upload: $("#selUpload").val(),
            maxDownload: $("#maxDownload").val(),
            download: $("#selDownload").val(),
            maxTraffic: $("#maxTraffic").val(),
            traffic: $("#selTraffic").val(),
            urlRedirect: $("#urlRedirect").val(),
            accessPeriod: $("#accessPeriod").val(),
            period: $("#selPeriod").val(),
            dailySession: $("#dailySession").val(),
            session: $("#selSession").val()
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

jQuery(document).on("click", ".open-limitationModal", function () {
    let title = $(this).data('title');
    let id = $(this).data('info').id;
    let name = $(this).data('info').name;
    let maxUpload = $(this).data('info').maxUpload;
    let upload = $(this).data('info').upload;
    let maxDownload = $(this).data('info').maxDownload;
    let download = $(this).data('info').download;
    let maxTraffic = $(this).data('info').maxTraffic;
    let traffic = $(this).data('info').traffic;
    let urlRedirect = $(this).data('info').urlRedirect;
    let accessPeriod = $(this).data('info').accessPeriod;
    let period = $(this).data('info').period;
    let dailySession = $(this).data('info').dailySession;
    let session = $(this).data('info').session;
    let option = $(this).data('info').option;

    $(".modal-title").text( title + ' Limitation' );
    $(".modal-body #id").val(id);
    $(".modal-body #option").val(option);

    $("#name").val(name);
    $("#maxUpload").val(maxUpload);
    $("#selUpload").val(upload);
    $("#maxDownload").val(maxDownload);
    $("#selDownload").val(download);
    $("#maxTraffic").val(maxTraffic);
    $("#selTraffic").val(traffic);
    $("#urlRedirect").val(urlRedirect);
    $("#accessPeriod").val(accessPeriod);
    $("#selPeriod").val(period);
    $("#dailySession").val(dailySession);
    $("#selSession").val(session);

    $("#name").prop('disabled', false);
    $("#maxUpload").prop('disabled', false);
    $("#selUpload").prop('disabled', false);
    $("#maxDownload").prop('disabled', false);
    $("#selDownload").prop('disabled', false);
    $("#maxTraffic").prop('disabled', false);
    $("#selTraffic").prop('disabled', false);
    $("#urlRedirect").prop('disabled', false);
    $("#accessPeriod").prop('disabled', false);
    $("#selPeriod").prop('disabled', false);
    $("#dailySession").prop('disabled', false);
    $("#selSession").prop('disabled', false);
    document.getElementById( 'btnSave' ).style.display = 'block';
    document.getElementById( 'btnSave' ).textContent = title;
    switch (option) {
        case "C":
            document.getElementById( 'btnSave' ).textContent = 'Save';
            break;
        case "R":
            document.getElementById( 'btnSave' ).style.display = 'none';
            $("#name").prop('disabled', true);
            $("#maxUpload").prop('disabled', true);
            $("#selUpload").prop('disabled', true);
            $("#maxDownload").prop('disabled', true);
            $("#selDownload").prop('disabled', true);
            $("#maxTraffic").prop('disabled', true);
            $("#selTraffic").prop('disabled', true);
            $("#urlRedirect").prop('disabled', true);
            $("#accessPeriod").prop('disabled', true);
            $("#selPeriod").prop('disabled', true);
            $("#dailySession").prop('disabled', true);
            $("#selSession").prop('disabled', true);
            break;
        case "U":
            $("#name").prop('disabled', true);
            break;
        case "D":
            $("#name").prop('disabled', true);
            $("#maxUpload").prop('disabled', true);
            $("#selUpload").prop('disabled', true);
            $("#maxDownload").prop('disabled', true);
            $("#selDownload").prop('disabled', true);
            $("#maxTraffic").prop('disabled', true);
            $("#selTraffic").prop('disabled', true);
            $("#urlRedirect").prop('disabled', true);
            $("#accessPeriod").prop('disabled', true);
            $("#selPeriod").prop('disabled', true);
            $("#dailySession").prop('disabled', true);
            $("#selSession").prop('disabled', true);
            break;
    }
});/***[/JCBGUI$$$$]***/
