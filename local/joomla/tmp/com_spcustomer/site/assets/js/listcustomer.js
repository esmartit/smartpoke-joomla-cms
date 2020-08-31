/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			30th July, 2020
	@created		24th April, 2020
	@package		SP Customer
	@subpackage		listcustomer.js
	@author			Adolfo Zignago <https://esmartit.es>	
	@copyright		Copyright (C) 2020. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

/* JS Document */

/***[JCBGUI.site_view.javascript_file.42.$$$$]***/
function closeModal() {
    $('#customerModal').modal('hide');
    if ($('.modal-backdrop').is(':visible')) {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }
}

jQuery(document).ready(function(){
    jQuery('#modalForm').submit(function(e) {
        customerAction();
        e.preventDefault();
    });
});

jQuery(document).ready(function () {
    let optSex = '';
    $('#radioMan').on('change', function () {
        optSex = $('#radioMan').val();
        $('input[name="radioSex"]:radio:checked').val(optSex);
    });

    $('#radioWoman').on('change', function () {
        optSex = $('#radioWoman').val();
        $('input[name="radioSex"]:radio:checked').val(optSex);
    });
});

jQuery(document).ready(function () {
    $('input[name="communication"]').on('ifChanged', function () {
        let optComm = $('#communication').val()
        if (optComm == 0)  {
            optComm = 1;
        } else {
            optComm = 0;
        }
        $('#communication').val(optComm);
    });

    $('input[name="member"]').on('ifChanged', function () {
        let optMember = $('#member').val()
        if (optMember == 0)  {
            optMember = 1;
        } else {
            optMember = 0;
        }
        $('#member').val(optMember);
    });

    $('#birthD').datetimepicker({
        ignoreReadonly: true,
        allowInputToggle: true,
        format: 'YYYY-MM-DD'
    });
});

function customerAction() {
    $.ajax({
        data: { task: "customerCRUD", format: "json", view: "listcustomer",
            id: $(".modal-body #id").val(),
            opt: $(".modal-body #option").val(),
            spot: $("#selSpot").val(),
            userName: $("#userName").val(),
            firstName: $("#firstName").val(),
            lastName: $("#lastName").val(),
            mobilePhone: $("#mobilePhone").val(),
            email: $("#email").val(),
            birthDate: $("#birthDate").val(),
            sex: $('input[name="radioSex"]:radio:checked').val(),
            zipCode: $("#zipCode").val(),
            memberShip: $("#member").val(),
            communication: $("#communication").val()
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

function showComm(status = null) {
    if (status == 0) {
        $('input[name=communication]').iCheck('uncheck');
    } else {
        $('input[name=communication]').iCheck('check');
    }
    $('#communication').val(status);
}

function showMember(status = null) {
    if (status == 0) {
        $('input[name=member]').iCheck('uncheck');
    } else {
        $('input[name=member]').iCheck('check');
    }
    $('#member').val(status);
}


jQuery(document).on("click", ".open-customerModal", function () {
    let title = $(this).data('title');
    let id = $(this).data('info').id;
    let spot = $(this).data('info').spot;
    let userName = $(this).data('info').userName;
    let firstName = $(this).data('info').firstName;
    let lastName = $(this).data('info').lastName;
    let mobilePhone = $(this).data('info').mobilePhone;
    let email = $(this).data('info').email;
    let birthDate = $(this).data('info').birthDate;
    let sex = $(this).data('info').sex;
    let zipCode = $(this).data('info').zipcode;
    let memberShip = $(this).data('info').memberShip;
    let communication = $(this).data('info').communication;
    let option = $(this).data('info').option;
    $(".modal-title").text( title + ' Customer' );
    $(".modal-body #id").val(id);
    $(".modal-body #option").val(option);

    $("#selSpot").val(spot);
    $("#userName").val(userName);
    $("#firstName").val(firstName);
    $("#lastName").val(lastName);
    $("#mobilePhone").val(mobilePhone);
    $("#email").val(email);
    $("#birthDate").val(birthDate);
    $('input[name="radioSex"]:radio:checked').val(sex);
    $("#zipCode").val(zipCode);
    $("#member").val(memberShip);
    showMember(memberShip);
    $("#communication").val(communication);
    showComm(communication);

    $("#selSpot").prop('disabled', false);
    $("#userName").prop('disabled', false);
    $("#firstName").prop('disabled', false);
    $("#lastName").prop('disabled', false);
    $("#mobilePhone").prop('disabled', false);
    $("#email").prop('disabled', false);
    $("#birthDate").prop('disabled', false);
    $('input[name="radioSex"]:radio:checked').prop('disabled', false);
    $("#zipCode").prop('disabled', false);
    $("#member").prop('disabled', false);
    $("#communication").prop('disabled', false);
    document.getElementById( 'btnSave' ).style.display = 'block';
    document.getElementById( 'btnSave' ).textContent = title;
    switch (option) {
        case "C":
            document.getElementById( 'btnSave' ).textContent = 'Save';
            break;
        case "R":
            document.getElementById( 'btnSave' ).style.display = 'none';
            $("#selSpot").prop('disabled', true);
            $("#userName").prop('disabled', true);
            $("#firstName").prop('disabled', true);
            $("#lastName").prop('disabled', true);
            $("#mobilePhone").prop('disabled', true);
            $("#email").prop('disabled', true);
            $("#birthDate").prop('disabled', true);
            $('input[name="radioSex"]:radio:checked').prop('disabled', true);
            $("#zipCode").prop('disabled', true);
            $("#member").prop('disabled', true);
            $("#communication").prop('disabled', true);
            break;
        case "U":
            document.getElementById( 'btnSave' ).textContent = 'Save';
            $("#selSpot").prop('disabled', true);
            $("#userName").prop('disabled', true);
            $("#firstName").prop('disabled', true);
            $("#mobilePhone").prop('disabled', true);
            $("#email").prop('disabled', true);
            break;
        case "D":
            $("#selSpot").prop('disabled', true);
            $("#userName").prop('disabled', true);
            $("#firstName").prop('disabled', true);
            $("#lastName").prop('disabled', true);
            $("#mobilePhone").prop('disabled', true);
            $("#email").prop('disabled', true);
            $("#birthDate").prop('disabled', true);
            $('input[name="radioSex"]:radio:checked').prop('disabled', true);
            $("#zipCode").prop('disabled', true);
            $("#member").prop('disabled', true);
            $("#communication").prop('disabled', true);
            break;
    }
});/***[/JCBGUI$$$$]***/
