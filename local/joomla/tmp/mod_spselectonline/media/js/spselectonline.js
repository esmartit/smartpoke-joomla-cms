let t_devicesIn = [];
let t_devicesEx = [];
let t_devices = [];

$(document).ready( function() {

    getCountryList();
    getDeviceInList();
    getDeviceExList();

    if (typeof ($.fn.ionRangeSlider) === 'undefined') { return; }
    console.log('init_IonRangeSlider');

    $("#range_age").ionRangeSlider({
        type: "double",
        min: 0,
        max: 100,
        from: 18,
        to: 85,
        grid: true,
        grid_num: 10,
        grid_snap: false,
        onChange: function(data) {
            $('#from_value').val(data.from);
            $('#to_value').val(data.to);
        }
    });

    document.getElementById("timestart").value = '00:00:00';

    function showTimeEnd(time) {
        document.getElementById("timeend").value = time;
    }

    function objTimer() {

        ActualDateTime = new Date();
        Actualhour = ActualDateTime.getHours();
        Actualminute = ActualDateTime.getMinutes();
        Actualsecond = ActualDateTime.getSeconds();

        var strTime = "";
        h = '0' + Actualhour;
        m = '0' + Actualminute;
        s = '0' + Actualsecond;
        strTime += h.substring(h.length - 2, h.length) + ':' + m.substring(m.length - 2, m.length) + ':'+ s.substring(s.length - 2, s.length);

        var checksec = (Actualsecond / 1);
        if (checksec % 1 == 0) {
            showTimeEnd(strTime);
        }
    }

    setInterval(objTimer, 1000);
    objTimer();
});

function getCountryList() {
    let request = {
        option       : 'com_ajax',
        module       : 'spselectonline',  // to target: mod_spselectonline
        method       : 'getSpotCountry',  // to target: function getSpotCountryAjax in class ModSPSelectOnlineHelper
        format       : 'json'
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data;
            let len = object.length;

            $("#selCountryS").empty();
            $("#selCountryS").append("<option value='' selected>All Countries</option>");
            for (let i = 0; i<len; i++) {
                let id = object[i][0];
                let name = object[i][1];

                $("#selCountryS").append("<option value='"+id+"'>"+name+"</option>");
            }
            getStateList();
        });

}

function getStateList() {
    let countryId = $('#selCountryS').val();
    let request = {
        option       : 'com_ajax',
        module       : 'spselectonline',  // to target: mod_spselectonline
        method       : 'getSpotState',  // to target: function getSpotStateAjax in class ModSPSelectOnlineHelper
        format       : 'json',
        data         : countryId
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data;
            let len = object.length;

            $("#selStateS").empty();
            $("#selStateS").append("<option value='' selected>All States</option>");
            for (let i = 0; i<len; i++) {
                let id = object[i][0];
                let name = object[i][1];

                $("#selStateS").append("<option value='"+id+"'>"+name+"</option>");
            }
            getSpotList();
        });
}

function getCityList() {
    let countryId = $('#selCountryS').val();
    let stateId = $('#selStateS').val();
    let request = {
        option       : 'com_ajax',
        module       : 'spselectonline',  // to target: mod_spselectonline
        method       : 'getSpotCity',  // to target: function getSpotCityAjax in class ModSPSelectOnlineHelper
        format       : 'json',
        data         : {'countryId': countryId, 'stateId': stateId}
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data;
            let len = object.length;

            $("#selCityS").empty();
            $("#selCityS").append("<option value='' selected>All Cities</option>");
            for (let i = 0; i<len; i++) {
                let id = object[i][0];
                let name = object[i][1];

                $("#selCityS").append("<option value='"+id+"'>"+name+"</option>");
            }
            getSpotList();
        });
}

function getZipCodeList() {
    let countryId = $('#selCountryS').val();
    let stateId = $('#selStateS').val();
    let cityId = $('#selCityS').val();
    let request = {
        option       : 'com_ajax',
        module       : 'spselectonline',  // to target: mod_spselectonline
        method       : 'getSpotZipCode',  // to target: function getSpotZipCodeAjax in class ModSPSelectOnlineHelper
        format       : 'json',
        data         : {'countryId': countryId, 'stateId': stateId, 'cityId': cityId}
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data;
            let len = object.length;

            $("#selZipCodeS").empty();
            $("#selZipCodeS").append("<option value='' selected>All ZipCodes</option>");
            for (let i = 0; i<len; i++) {
                let id = object[i][0];
                let name = object[i][1];

                $("#selZipCodeS").append("<option value='"+id+"'>"+id+" - "+name+"</option>");
            }
        });
}

function getSpotList() {
    let countryId = $('#selCountryS').val();
    let stateId = $('#selStateS').val();
    let cityId = $('#selCityS').val();
    let zipcodeId = $('#selZipCodeS').val();

    let request = {
        option       : 'com_ajax',
        module       : 'spselectonline',  // to target: mod_spselectonline
        method       : 'getSpots',  // to target: function getSpotsAjax in class ModSPSelectOnlineHelper
        format       : 'json',
        data         : {'countryId': countryId, 'stateId': stateId, 'cityId': cityId, 'zipcodeId': zipcodeId}
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data;
            let len = object.length;

            $("#selSpot").empty();
            $("#selSpot").append("<option value=''>All Spots</option>");
            for (let i = 0; i<len; i++) {
                let id = object[i][0];
                let name = object[i][1];

                $("#selSpot").append("<option value='"+id+"'>"+name+"</option>");
            }
        });
}

function getSensorZoneList() {
    getSensorList();
    getZoneList();
}

function getSensorList() {
    let spotid = $('#selSpot').val();
    let request = {
        option       : 'com_ajax',
        module       : 'spselectonline',  // to target: mod_spselectonline
        method       : 'getSensors',  // to target: function getSensorsAjax in class ModSPSelectOnlineHelper
        format       : 'json',
        data         : spotid
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data;
            let len = object.length;

            $("#selSensor").empty();
            $("#selSensor").append("<option value=''>All Sensors</option>");
            for (let i = 0; i<len; i++) {
                let id = object[i][0];
                let name = object[i][1];

                $("#selSensor").append("<option value='"+id+"'>"+name+"</option>");
            }
        });
}

function getZoneList() {
    let spotid = $('#selSpot').val();
    let request = {
        option       : 'com_ajax',
        module       : 'spselectonline',  // to target: mod_spselectonline
        method       : 'getZones',  // to target: function getZonesAjax in class ModSPSelectOnlineHelper
        format       : 'json',
        data         : spotid
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data;
            let len = object.length;

            $("#selZone").empty();
            $("#selZone").append("<option value=''>All Zones</option>");
            for (let i = 0; i<len; i++) {
                let id = object[i][0];
                let name = object[i][1];

                $("#selZone").append("<option value='"+id+"'>"+name+"</option>");
            }
        });
}

function getDeviceInList() {
    let request = {
        option       : 'com_ajax',
        module       : 'spselectonline',  // to target: mod_spselectonline
        method       : 'getDevices',  // to target: function getDevicesAjax in class ModSPSelectOnlineHelper
        format       : 'json',
        data         : 1
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data;
            let len = object.length;
            t_devicesIn = [];

            for (let i = 0; i<len; i++) {
                t_devicesIn.push(object[i]['device']);

            }
        });
}

function getDeviceExList() {
    let request = {
        option       : 'com_ajax',
        module       : 'spselectonline',  // to target: mod_spselectonline
        method       : 'getDevices',  // to target: function getDevicesAjax in class ModSPSelectOnlineHelper
        format       : 'json',
        data         : 0
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data;
            let len = object.length;
            t_devicesEx = [];

            for (let i = 0; i<len; i++) {
                t_devicesEx.push(object[i]['device']);

            }
        });
}

$(document).ready(function () {
    $('#checkFilter').on('change', function () {
        filters();
    });
});

function filters() {
    document.getElementById("filterAge").style.display = 'none';
    document.getElementById("filterSex").style.display = 'none';
    document.getElementById("filterZipCode").style.display = 'none';
    document.getElementById("filterMember").style.display = 'none';
    if (document.getElementById("checkFilter").checked) {
        document.getElementById("filterAge").style.display = 'block';
        document.getElementById("filterSex").style.display = 'block';
        document.getElementById("filterZipCode").style.display = 'block';
        document.getElementById("filterMember").style.display = 'block';
    }
}

function sendForm() {
    getDeviceInList();
    getDeviceExList();
    let t_dateS = $('#timestart').val();
    let t_dateE = $('#timeend').val();
    let t_country = $('#selCountryS').val();
    let t_state = $('#selStateS').val();
    let t_city = $('#selCityS').val();
    let t_zipcode = $('#selZipCodeS').val();

    let t_spot = $('#selSpot').val();
    let t_sensor = $('#selSensor').val();
    let t_zone = $('#selZone').val();
    let t_type = $('#selType').val();
    let t_brands = $('#selBrand').val();
    let t_status = $('#selStatus').val();
    let t_ageS = '';
    let t_ageE = '';
    let t_sex = '';
    let t_zipcodes = '';
    let t_member = '';
    let userTimeZone = document.getElementById('userTimeZone').innerText;

    switch (t_type) {
        case '0':
            t_devicesIn = [];
            break;
        case '1':
            t_devicesEx = [];
            break;
        default:
            t_devicesIn = [];
            t_devicesEx = [];
            break;
    }

    if (document.getElementById("checkFilter").checked) {
        t_ageS = $('#from_value').val();
        t_ageE = $('#to_value').val();
        t_sex = $('#selSex').val();
        t_zipcodes = $('#selZipCode').val();
        t_member = $('#selMembership').val();
    }

    evtSourceActivityOnline
    (
        t_dateS, t_dateE,
        t_country, t_state, t_city, t_zipcode,
        t_spot, t_sensor, t_zone, t_devicesIn, t_devicesEx,
        t_brands, t_status, t_ageS, t_ageE, t_sex, t_zipcodes, t_member,
        userTimeZone
    );

    evtSourceActivityHotSpot
    (
        t_dateS, t_dateE,
        t_country, t_state, t_city, t_zipcode,
        t_spot, t_sensor, t_zone, t_devicesIn, t_devicesEx,
        t_brands, t_status, t_ageS, t_ageE, t_sex, t_zipcodes, t_member,
        userTimeZone
    );

    evtSourceQualifiedVisits
    (
        t_dateS, t_dateE,
        t_country, t_state, t_city, t_zipcode,
        t_spot, t_sensor, t_zone, t_devicesIn, t_devicesEx,
        t_brands, t_status, t_ageS, t_ageE, t_sex, t_zipcodes, t_member,
        userTimeZone
    );

}
