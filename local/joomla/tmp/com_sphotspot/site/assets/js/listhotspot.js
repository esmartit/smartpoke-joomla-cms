/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.1
	@build			1st October, 2020
	@created		1st October, 2020
	@package		SP HotSpot
	@subpackage		listhotspot.js
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
    $('#hotspotModal').modal('hide');
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
        hotspotAction();
        e.preventDefault();
    });
});

function hotspotAction() {
    $.ajax({
        data: { task: "hotspotCRUD", format: "json", view: "listhotspot",
            id: $(".modal-body #id").val(),
            opt: $(".modal-body #option").val(),
            spot: $("#selSpot").val(),
            name: $("#name").val(),
            tags: $("#tags_1").val()
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

jQuery(document).on("click", ".open-hotspotModal", function () {
    let title = $(this).data('title');
    let id = $(this).data('info').id;
    let spot = $(this).data('info').spot;
    let name = $(this).data('info').name;
    let tags = $(this).data('info').tags;
    let option = $(this).data('info').option;
    $(".modal-title").text( title + ' HotSpot' );
    $(".modal-body #id").val(id);
    $(".modal-body #option").val(option);

    $("#selSpot").val(spot);
    $("#name").val(name);
    $("#tags_1").val(tags);

    $("#selSpot").prop( 'disabled', false );
    $("#name").prop( 'disabled', false );
    $("#tags_1").prop( 'disabled', false );
    document.getElementById( 'btnSave' ).style.display = 'block';
    document.getElementById( 'btnSave' ).textContent = title;
    switch (option) {
        case "C":
            document.getElementById( 'btnSave' ).textContent = 'Save';
            break;
        case "R":
            document.getElementById( 'btnSave' ).style.display = 'none';
            $("#selSpot").prop( 'disabled', true );
            $("#name").prop( 'disabled', true );
            $("#tags_1").prop( 'disabled', true );
            break;
        case "U":
            document.getElementById( 'btnSave' ).textContent = 'Save';
            break;
        case "D":
            $("#selSpot").prop( 'disabled', true );
            $("#name").prop( 'disabled', true );
            $("#tags_1").prop( 'disabled', true );
            break;
    }

});/***[/JCBGUI$$$$]***/
