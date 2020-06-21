jQuery(document).ready(function() {

});

function show(){
    document.getElementById("selCountryCode").disabled = true;
    document.getElementById("mobilephone").disabled = true;
    document.getElementById("register").style.display = 'block';
    document.getElementById("pin").disabled = false;
    document.getElementById("email").disabled = false;
    document.getElementById("firstname").disabled = false;
    document.getElementById("checkbox1").disabled = false;
    document.getElementById("btnlogin").style.display = 'none';
    document.getElementById("btnregister").style.display = 'block';
}

function hide(){
    document.getElementById("selCountryCode").disabled = false;
    document.getElementById("mobilephone").disabled = false;
    document.getElementById("register").style.display = 'none';
    document.getElementById("pin").disabled = true;
    document.getElementById("email").disabled = true;
    document.getElementById("firstname").disabled = true;
    document.getElementById("checkbox1").disabled = true;
    document.getElementById("btnlogin").style.display = 'block';
    document.getElementById("btnregister").style.display = 'none';
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
                    alert('This is your PIN'+': '+data);
                    show();
                }
            }
        },
        error: function() { console.log('ajax call failed'); },
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
            email: jQuery('#email').val(),
            firstname: jQuery('#firstname').val(),
            lastname: jQuery('#lastname').val(),
            bdate: jQuery('#bdate').val(),
            sex: jQuery('#sex').val(),
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
        error: function() { console.log('ajax call failed'); },
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
    let email = jQuery("#email").val();
    result.text("");

    document.getElementById("resultEmail").style.display = 'none';
    if (!validateEmail(email)) {
        result.text("Invalid email format");
        document.getElementById("resultEmail").style.display = 'block';
        document.getElementById("email").focus();
        return false;
    }
}

function setUser(username, password) {
    jQuery('input[name=username]').val(username);
    jQuery('input[name=password]').val(password);
}
