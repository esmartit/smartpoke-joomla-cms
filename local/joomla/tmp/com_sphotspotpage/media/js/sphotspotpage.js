jQuery(document).ready(function () {
    hide();
});

function show(){
    document.getElementById("selCountryCode").disabled = true;
    document.getElementById("mobilephone").disabled = true;
    document.getElementById("register").style.display = 'block';
    jQuery('#pin').prop('readonly', false);
    jQuery('#email_cli').prop('readonly', false);
    jQuery('#firstname').prop('readonly', false);
    jQuery('#chkboxTC').prop('readonly', false);
    document.getElementById("btnlogin").style.display = 'none';
    document.getElementById("btnregister").style.display = 'block';
}

function hide(){
    document.getElementById("selCountryCode").disabled = false;
    document.getElementById("mobilephone").disabled = false;
    document.getElementById("register").style.display = 'none';
    jQuery('#pin').prop('readonly', true);
    jQuery('#email_cli').prop('readonly', true);
    jQuery('#firstname').prop('readonly', true);
    jQuery('#chkboxTC').prop('readonly', true);
    document.getElementById("btnlogin").style.display = 'block';
    document.getElementById("btnregister").style.display = 'none';
}

let clicked = 'r';
jQuery(document).ready(function () {
    jQuery('#btnlogin').on('click', function() {
        clicked = 'l';
    })
    jQuery('#btnregister').on('click', function() {
        clicked = 'r';
    })
    jQuery('#btnaccept').on('click', function() {
        document.getElementById("chkboxTC").checked = true;
    })

    jQuery('#login_form').submit(function(e) {
        switch (clicked) {
            case "l":
                userLogin();
                break;
            case "r":
                showModal();
                userRegister();
                break;
        }
        e.preventDefault();
    });
});

jQuery(document).ready(function(){
    let url = jQuery("#adsVideo").attr('src');

    jQuery("#adsModal").on('hide.bs.modal', function(){
        jQuery("#adsVideo").attr('src', '');
    });

    jQuery("#adsModal").on('show.bs.modal', function(){
        jQuery("#adsVideo").attr('src', url);
    });
});

function showModal() {
    jQuery('#adsModal').modal('show');
    setTimeout(function() {
        jQuery('#adsModal').modal('hide'); }, 5000);
}

function userLogin() {
    jQuery.ajax({
        data: { task: "validUser", format: "json", view: "login",
            countrycode: jQuery('#selCountryCode option:selected').text(),
            phonecode: jQuery('#selCountryCode').val(),
            mobile: jQuery('#mobilephone').val(),
            client_mac: jQuery('#client_mac').val(),
            spot_id: jQuery('#spot_id').val(),
            hotspot_name: jQuery('#hotspot_name').val(),
            groupname: jQuery('#groupname').val()
        },
        success: function(response, status, xhr) {
            console.log(response);
            let object = response.data[0];
            let section = object['section'];
            let data = object['data'];
            let user = jQuery('#selCountryCode option:selected').text()+jQuery("#mobilephone").val();
            let loginUrl = jQuery("#loginUrl").val();

            if (section == "error") {
                jQuery("#errorPhone").text(data);
                document.getElementById("errorPhone").style.display = 'block';
            } else {
                setUser(user, data);
                if (section == "go") {
                    document.getElementById("login_form").action = loginUrl;
                    document.getElementById("login_form").submit();
                } else {
                    document.getElementById("errorPhone").style.display = 'none';
                    alert('Your PIN NUMBER'+': '+data);
                    show();
                }
            }
        },
        error: function() {
            console.log('ajax call failed');
        },
    });
}

function userRegister() {
    document.getElementById("selCountryCode").disabled = false;
    document.getElementById("mobilephone").disabled = false;
    jQuery.ajax({
        data: { task: "validUser", format: "json", view: "register",
            countrycode: jQuery('#selCountryCode option:selected').text(),
            phonecode: jQuery('#selCountryCode').val(),
            mobile: jQuery('#mobilephone').val(),
            client_mac: jQuery('#client_mac').val(),
            username: jQuery('#username').val(),
            password: jQuery('#password').val(),
            email_cli: jQuery('#email_cli').val(),
            firstname: jQuery('#firstname').val(),
            lastname: jQuery('#lastname').val(),
            bdate: jQuery('#bdate').val(),
            sex: jQuery('#sex').val(),
            membership: jQuery('#membership').val(),
            zipcode: jQuery('#zipcode').val(),
            spot_id: jQuery('#spot_id').val(),
            hotspot_name: jQuery('#hotspot_name').val(),
            groupname: jQuery('#groupname').val()
        },
        success:function(response, status, xhr) {

            console.log(response);
            let object = response.data[0];
            let section = object['section'];
            let data = object['data'];
            let user = jQuery('#selCountryCode option:selected').text()+jQuery("#mobilephone").val();
            let loginUrl = jQuery("#loginUrl").val();

            if (section == "error") {
                jQuery("#errorPhone").text(data);
                document.getElementById("errorPhone").style.display = 'block';
            } else {
                setUser(user, data);
                if (section == "go") {
                    document.getElementById("login_form").action = loginUrl;
                    document.getElementById("login_form").submit();
                }
            }
        },
        error: function() {
            console.log('ajax call failed');
        },
    });
}

function validPin(){
    let vpin = jQuery("#pin").val();
    let vpass = jQuery("#password").val();
    let result = jQuery("#resultPin");
    result.text("");

    document.getElementById("resultPin").style.display = 'none';
    if (vpin != vpass) {
        result.text("PIN number is not correct");
        document.getElementById("resultPin").style.display = 'block';
        document.getElementById("pin").focus();
        return false;
    }
}

function validateEmail(email) {
    let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validate() {
    let result = jQuery("#resultEmail");
    let email = jQuery("#email_cli").val();
    result.text("");

    document.getElementById("resultEmail").style.display = 'none';
    if (!validateEmail(email)) {
        result.text("Invalid email format");
        document.getElementById("resultEmail").style.display = 'block';
        document.getElementById("email_cli").focus();
        return false;
    }
}

function setUser(username, password) {
    jQuery('input[name=username]').val(username);
    jQuery('input[name=password]').val(password);
}



