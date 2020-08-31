/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			30th July, 2020
	@created		6th April, 2020
	@package		SP Brand
	@subpackage		listbrand.js
	@author			Adolfo Zignago <https://www.esmartit.es>	
	@copyright		Copyright (C) 2020. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

/* JS Document */

/***[JCBGUI.site_view.javascript_file.26.$$$$]***/
function closeModal() {
    $('#brandModal').modal('hide');
    if ($('.modal-backdrop').is(':visible')) {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }
}

jQuery(document).ready(function(){
    jQuery('#modalForm').submit(function(e) {
        brandAction();
        e.preventDefault();
    });
});

function brandAction() {
    $.ajax({
        data: { task: "brandCRUD", format: "json", view: "listbrand",
            id: $(".modal-body #id").val(),
            opt: $(".modal-body #option").val(),
            brand: $("#brand").val()
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

jQuery(document).on("click", ".open-brandModal", function () {
    let title = $(this).data('title');
    let id = $(this).data('info').id;
    let brand = $(this).data('info').brand;
    let option = $(this).data('info').option;
    $(".modal-title").text( title + ' Brand' );
    $(".modal-body #id").val(id);
    $(".modal-body #option").val(option);
    $("#brand").val(brand);
    $("#brand").prop( 'disabled', false );
    document.getElementById( 'btnSave' ).style.display = 'block';
    document.getElementById( 'btnSave' ).textContent = title;
    switch (option) {
        case "C":
            document.getElementById( 'btnSave' ).textContent = 'Save';
            break
        case "R":
            document.getElementById( 'btnSave' ).style.display = 'none';
            $("#brand").prop( 'disabled', true );
            break;
        case "U":
            document.getElementById( 'btnSave' ).textContent = 'Save';
            break;
        case "D":
            $("#brand").prop( 'disabled', true );
            break;
    }

});/***[/JCBGUI$$$$]***/
