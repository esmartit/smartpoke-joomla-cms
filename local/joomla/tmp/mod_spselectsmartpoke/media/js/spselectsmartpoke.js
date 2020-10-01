let smartpokeOpt = '1';
let tableOn = '';
let tableOff = '';
let tableDB = '';
let tableFile = '';
let campaignId = '';
let msgType = '1';

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
    document.getElementById("timeend").value = '23:59:59';
    getCampaigns();

    $('#datatable-online').DataTable({responsive: true});
    $('#datatable-offline').DataTable({responsive: true});
    $('#datatable-database').DataTable({responsive: true});
    $('#datatable-file').DataTable({responsive: true});
    // showTableColumns();
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
            $("#selSpot").append("<option value=''>All Data Lakes</option>");
            for (let i = 0; i<len; i++) {
                let id = object[i][0];
                let name = object[i][1];

                $("#selSpot").append("<option value='"+id+"'>"+name+"</option>");
            }
            // showTableColumns();
        });
}

function getSensorZoneHotSpotList() {
    getSensorList();
    getZoneList();
    getHotSpotList();
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

function getHotSpotList() {
    let spotid = $('#selSpot').val();
    let request = {
        option       : 'com_ajax',
        module       : 'spselectsmartpoke',  // to target: mod_spselectsmartpoke
        method       : 'getHotSpots',  // to target: function getHotSpotsAjax in class ModSPSelectSmartPokeeHelper
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

            $("#selHotSpot").empty();
            $("#selHotSpot").append("<option value=''>All HotSpots</option>");
            for (let i = 0; i<len; i++) {
                let id = object[i][1];
                let name = object[i][1];

                $("#selHotspot").append("<option value='"+id+"'>"+name+"</option>");
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
    $('#radioSMS').on('change', function () {
        let sms = $('#radioSMS').val();
        getCampaigns(sms);
        msgType = sms;
    });

    $('#radioEmail').on('change', function () {
        let email = $('#radioEmail').val();
        getCampaigns(email);
        msgType = email;
    });
});

function getCampaigns(smsemail = '1') {
    let request = {
        option       : 'com_ajax',
        module       : 'spselectsmartpoke',  // to target: mod_spselectsmartpoke
        method       : 'getCampaigns',  // to target: function getCampaignsAjax in class ModSPSelectSmartPokeHelper
        format       : 'json',
        data         : smsemail
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data;
            let len = object.length;

            $("#selCampaign").empty();
            $("#selCampaign").append("<option value='' selected disabled>Select Campaign</option>");
            for (let i = 0; i<len; i++) {
                let id = object[i][0];
                let name = object[i][1];

                $("#selCampaign").append("<option value='"+id+"'>"+name+"</option>");
            }
        });
}

function showTableColumns() {
    let countryId = $('#selCountryS').val();
    let stateId = $('#selStateS').val();
    let cityId = $('#selCityS').val();
    let zipcodeId = $('#selZipCodeS').val();
    let spot = $('#selSpot').val();
    let sensor = $('#selSensor').val();
    let zone = $('#selZone').val();

    let request = {
        option       : 'com_ajax',
        module       : 'spselectsmartpoke',  // to target: mod_spselectsmartpoke
        method       : 'getSpotSensors',  // to target: function getSpotSensorsAjax in class ModSPSelectSmartPokeHelper
        format       : 'json',
        data         : {
            'countryId': countryId, 'stateId': stateId, 'cityId': cityId, 'zipcodeId': zipcodeId,
            'spot': spot, 'sensor': sensor, 'zone': zone
        }
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data;
            let len = object.length;

            for (let i = 0; i<len; i++) {
                let spot = object[i][0];
                let sensor = object[i][1];
            }
        });
}

$(document).ready(function () {
    $('#spOnline').on('change', function () {
        showOnlineOpt();
        document.getElementById("smartpoke_form").reset();
    });

    $('#spOffline').on('change', function () {
        showOfflineOpt();
        document.getElementById("smartpoke_form").reset();
    });

    $('#spDataBase').on('change', function () {
        showDataBaseOpt();
        document.getElementById("smartpoke_form").reset();
    });

    $('#spFile').on('change', function () {
        showFileOpt();
        document.getElementById("smartpoke_form").reset();
    });
});

function showOnlineOpt(){
    document.getElementById("hourstart").style.display = 'block';
    document.getElementById("hourend").style.display = 'block';
    $('#timeend').prop('disabled', true);
    document.getElementById("rangeDate").style.display = 'none';
    document.getElementById("selUbiGeo").style.display = 'block';
    document.getElementById("spotSelect").style.display = 'block';
    document.getElementById("sensorSelect").style.display = 'block';
    document.getElementById("zoneSelect").style.display = 'block';
    document.getElementById("hotspotSelect").style.display = 'block';
    document.getElementById("typeSelect").style.display = 'block';
    document.getElementById("selbrands").style.display = 'block';
    document.getElementById("selposition").style.display = 'block';
    document.getElementById("selpresence").style.display = 'block';
    document.getElementById("datepresence").style.display = 'block';
    document.getElementById("filters").style.display = 'block';
    document.getElementById("selfile").style.display = 'none';
    document.getElementById("selcampaigns").style.display = 'block';
    document.getElementById("online").style.display = 'block';
    document.getElementById("offline").style.display = 'none';
    document.getElementById("database").style.display = 'none';
    document.getElementById("file").style.display = 'none';
    smartpokeOpt = '1';
}

function showOfflineOpt(){
    document.getElementById("hourstart").style.display = 'block';
    document.getElementById("hourend").style.display = 'block';
    $('#timeend').prop('disabled', false);
    document.getElementById("rangeDate").style.display = 'block';
    document.getElementById("selUbiGeo").style.display = 'block';
    document.getElementById("spotSelect").style.display = 'block';
    document.getElementById("sensorSelect").style.display = 'block';
    document.getElementById("zoneSelect").style.display = 'block';
    document.getElementById("hotspotSelect").style.display = 'block';
    document.getElementById("typeSelect").style.display = 'block';
    document.getElementById("selbrands").style.display = 'block';
    document.getElementById("selposition").style.display = 'block';
    document.getElementById("selpresence").style.display = 'block';
    document.getElementById("datepresence").style.display = 'block';
    document.getElementById("filters").style.display = 'block';
    document.getElementById("selfile").style.display = 'none';
    document.getElementById("selcampaigns").style.display = 'block';
    document.getElementById("online").style.display = 'none';
    document.getElementById("offline").style.display = 'block';
    document.getElementById("database").style.display = 'none';
    document.getElementById("file").style.display = 'none';
    smartpokeOpt = '2';
}

function showDataBaseOpt(){
    document.getElementById("hourstart").style.display = 'none';
    document.getElementById("hourend").style.display = 'none';
    document.getElementById("rangeDate").style.display = 'none';
    document.getElementById("selUbiGeo").style.display = 'block';
    document.getElementById("spotSelect").style.display = 'block';
    document.getElementById("sensorSelect").style.display = 'none';
    document.getElementById("zoneSelect").style.display = 'none';
    document.getElementById("hotspotSelect").style.display = 'none';
    document.getElementById("typeSelect").style.display = 'none';
    document.getElementById("selbrands").style.display = 'none';
    document.getElementById("selposition").style.display = 'none';
    document.getElementById("selpresence").style.display = 'none';
    document.getElementById("datepresence").style.display = 'none';
    document.getElementById("filters").style.display = 'block';
    document.getElementById("selfile").style.display = 'none';
    document.getElementById("selcampaigns").style.display = 'block';
    document.getElementById("online").style.display = 'none';
    document.getElementById("offline").style.display = 'none';
    document.getElementById("database").style.display = 'block';
    document.getElementById("file").style.display = 'none';
    smartpokeOpt = '3';
}

function showFileOpt() {
    document.getElementById("hourstart").style.display = 'none';
    document.getElementById("hourend").style.display = 'none';
    document.getElementById("rangeDate").style.display = 'none';
    document.getElementById("selUbiGeo").style.display = 'none';
    document.getElementById("spotSelect").style.display = 'none';
    document.getElementById("sensorSelect").style.display = 'none';
    document.getElementById("zoneSelect").style.display = 'none';
    document.getElementById("hotspotSelect").style.display = 'none';
    document.getElementById("typeSelect").style.display = 'none';
    document.getElementById("selbrands").style.display = 'none';
    document.getElementById("selposition").style.display = 'none';
    document.getElementById("selpresence").style.display = 'none';
    document.getElementById("datepresence").style.display = 'none';
    document.getElementById("filters").style.display = 'none';
    document.getElementById("selfile").style.display = 'block';
    document.getElementById("selcampaigns").style.display = 'block';
    document.getElementById("online").style.display = 'none';
    document.getElementById("offline").style.display = 'none';
    document.getElementById("database").style.display = 'none';
    document.getElementById("file").style.display = 'block';
    smartpokeOpt = '4';
}

$(document).ready(function() {

    let datestart;
    let dateend;
    let datestart2;
    let dateend2;

    let cb = function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        datestart = start.format('YYYY-MM-DD');
        dateend = end.format('YYYY-MM-DD');
        $('#datestart').val(datestart);
        $('#dateend').val(dateend);
    };

    let cb2 = function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#daterange_right span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        datestart2 = start.format('YYYY-MM-DD');
        dateend2 = end.format('YYYY-MM-DD');
        $('#datestart2').val(datestart2);
        $('#dateend2').val(dateend2);

    };

    let optionSet1 = {
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/1970',
        linkedCalendars:false,
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'right',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        format: 'MM/DD/YYYY',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    };

    $('#daterange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    $('#daterange').daterangepicker(optionSet1, cb);
    $('#daterange').on('show.daterangepicker', function () {
        console.log("show event fired");
    });
    $('#daterange').on('hide.daterangepicker', function () {
        console.log("hide event fired");
    });
    $('#daterange').on('apply.daterangepicker', function (ev, picker) {
        console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
    });
    $('#daterange').on('cancel.daterangepicker', function (ev, picker) {
        console.log("cancel event fired");
    });
    $('#options1').click(function () {
        $('#daterange').data('daterangepicker').setOptions(optionSet1, cb);
    });
    $('#options2').click(function () {
        $('#daterange').data('daterangepicker').setOptions(optionSet2, cb);
    });
    $('#destroy').click(function () {
        $('#daterange').data('daterangepicker').remove();
    });

    $('#daterange_right span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

    $('#daterange_right').daterangepicker(optionSet1, cb2);

    $('#daterange_right').on('show.daterangepicker', function () {
        console.log("show event fired");
    });
    $('#daterange_right').on('hide.daterangepicker', function () {
        console.log("hide event fired");
    });
    $('#daterange_right').on('apply.daterangepicker', function (ev, picker) {
        console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
    });
    $('#daterange_right').on('cancel.daterangepicker', function (ev, picker) {
        console.log("cancel event fired");
    });

    $('#options1').click(function () {
        $('#daterange_right').data('daterangepicker').setOptions(optionSet1, cb2);
    });

    $('#options2').click(function () {
        $('#daterange_right').data('daterangepicker').setOptions(optionSet2, cb2);
    });

    $('#destroy').click(function () {
        $('#daterange_right').data('daterangepicker').remove();
    });

});

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

    let t_timeS = '';
    let t_timeE = '';
    let t_dateS = '';
    let t_dateE = '';
    let t_country = '';
    let t_state = '';
    let t_city = '';
    let t_zipcode = '';
    let t_spot = '';
    let t_sensor = '';
    let t_zone = '';
    let t_hotspot = '';
    let t_type = '';
    let t_brands = '';
    let t_status = '';
    let t_presence = '';
    let t_dateS2 = '';
    let t_dateE2 = '';

    let t_ageS = '';
    let t_ageE = '';
    let t_sex = '';
    let t_zipcodes = '';
    let t_member = '';

    let formFile = '';
    let formFileJson = '';
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    campaignId = $('#selCampaign').val();

    if (smartpokeOpt == '1' || smartpokeOpt == '2') {  // Online and Offline option
        t_timeS = $('#timestart').val();
        t_timeE = $('#timeend').val();
        t_sensor = $('#selSensor').val();
        t_zone = $('#selZone').val();
        t_hotspot = $('#selHotSpot').val();
        t_type = $('#selType').val();
        t_sensor = $('#selSensor').val();
        t_brands = $('#selBrand').val();
        t_status = $('#selStatus').val();
        t_presence = $('#presence').val();
        t_dateS2 = $('#datestart2').val();
        t_dateE2 = $('#dateend2').val();

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
        if (smartpokeOpt == '2') {          // Only Offline option
            t_dateS = $('#datestart').val();
            t_dateE = $('#dateend').val();
        }
    }
    if (smartpokeOpt != '4') {  // Not File option
        t_country = $('#selCountryS').val();
        t_state = $('#selStateS').val();
        t_city = $('#selCityS').val();
        t_zipcode = $('#selZipCodeS').val();
        t_spot = $('#selSpot').val();
        if (document.getElementById("checkFilter").checked) {
            t_ageS = $('#from_value').val();
            t_ageE = $('#to_value').val();
            t_sex = $('#selSex').val();
            t_zipcodes = $('#selZipCode').val();
            t_member = $('#selMembership').val();
        }
    }

    if (campaignId != '') {
        switch (smartpokeOpt) {
            case '1':
                smartpokeOnline
                (
                    t_dateS, t_dateE, t_timeS, t_timeE,
                    t_country, t_state, t_city, t_zipcode,
                    t_spot, t_sensor, t_zone, t_hotpsot, t_devicesIn, t_devicesEx,
                    t_brands, t_status, t_presence, t_ageS, t_ageE, t_sex, t_zipcodes, t_member,
                    userTimeZone
                );
                break;
            case '2':
                smartpokeOffline
                (
                    t_dateS, t_dateE, t_timeS, t_timeE, t_dateS2, t_dateE2,
                    t_country, t_state, t_city, t_zipcode,
                    t_spot, t_sensor,  t_zone, t_hotspot, t_devicesIn, t_devicesEx,
                    t_brands, t_status, t_presence, t_ageS, t_ageE, t_sex, t_zipcodes, t_member,
                    userTimeZone
                );
                break;
            case '3':
                smartpokeDB
                (
                    t_country, t_state, t_city, t_zipcode,
                    t_spot,
                    t_ageS, t_ageE, t_sex, t_zipcodes, t_member
                );
                break;
            case '4':
                smartpokeFile();
                break;
        }

        let dataForm =
            {
                "dateStart": t_dateS, "dateEnd": t_dateE, "startTime": t_timeS, "endTime": t_timeE,
                "dateStart2": t_dateS2, "dateEnd2": t_dateE2,
                "countryId": t_country, "stateId": t_state, "cityId": t_city, "zipcodeId": t_zipcode,
                "spotId": t_spot, "sensorId": t_sensor, "zoneId": t_zone, "hotspotId": t_hotspot,
                "brands": t_brands, "status": t_status, "presence": t_presence,
                "ageStart": t_ageS, "ageEnd": t_ageE, "gender": t_sex, "zipCode": t_zipcodes, "memberShip": t_member,
                "file": formFileJson,
                "timeZone": userTimeZone
            }

    } else {
        Joomla.renderMessages({'warning': ['Select a campaign, please!']});
    }
}

function smartpokeOnline(dateS, dateE, country, state, city, zipcode, spot, sensor, zone, t_hotspot, inDevices, exDevices, brands, status, ageS, ageE, sex,
                         zipcodes, member, userTZ) {

    console.log(dateS, dateE, country, state, city, zipcode, spot, sensor, zone, t_hotspot, inDevices, exDevices, brands, status, ageS, ageE, sex,
        zipcodes, member, userTZ);

}

function smartpokeOffline(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, t_hotspot, inDevices, exDevices, brands, status, presence, ageS, ageE, sex,
                          zipcodes, member, userTZ, group) {

    console.log(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, t_hotspot, inDevices, exDevices, brands, status, presence, ageS, ageE, sex,
        zipcodes, member, userTZ, group);
}

function smartpokeDB(country, state, city, zipcode, spot, ageS, ageE, sex, zipcodes, member) {
    let request = {
        option       : 'com_ajax',
        module       : 'spselectsmartpoke',  // to target: mod_spselectsmartpoke
        method       : 'getUserList',  // to target: function getUserListAjax in class ModSPSelectSmartPokeHelper
        format       : 'json',
        data         : {
            "countryId": country, "stateId": state, "cityId": city, "zipcodeId": zipcode,
            "spotId": spot,
            "ageStart": ageS, "ageEnd": ageE, "gender": sex, "zipCode": zipcodes, "memberShip": member
        }
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let data = response.data
            tableDB = $('#datatable-database').DataTable({
                "destroy": true,
                "aaData": data,
                "columnDefs": [
                    {
                        "targets": 0,
                        "bSortable": false,
                        "searchable": false,
                        "orderable": false,
                        "className": 'dt-body-center',
                        "render": function (data, type, row, meta) {
                            return '<input type="checkbox" name="id[]" value="' + row['mobile_phone'] + '-' + row['firstname'] + '/' + row['username'] + '|' + row['email'] + '">';
                        }
                    },
                    {"data": "firstname", "targets": 1},
                    {"data": "lastname", "targets": 2},
                    {"data": "mobile_phone", "targets": 3},
                    {"data": "email", "targets": 4},
                    {"data": "username", "targets": 5},
                    {"data": "age", "targets": 6},
                    {
                        "data": "sex", "targets": 7,
                        "render": function (data, type) {
                            if (data == '0') {
                                return "<div align='center'><span class='fa fa-male'> </span></div>";
                            } else {
                                return "<div align='center'><span class='fa fa-female'> </span></div>";
                            }
                        }
                    },
                    {"data": "zipcode", "targets": 8},
                    {
                        "data": "membership", "targets": 9,
                        "render": function (data, type) {
                            if (data == '0') {
                                return "<div align='center'><span class='glyphicon glyphicon-remove' style='color:#FF0000'> </span></div>";
                            } else {
                                return "<div align='center'><span class='glyphicon glyphicon-ok' style='color:#00FF00'> </span></div>";
                            }
                        }
                    },
                    {"data": "name", "targets": 10}
                ],
                "responsive": true
            });
        });
}

function smartpokeFile() {
    let formFile = document.getElementById('selFile');
    let formFileJson = formFile.files[0];
    let formData = new FormData();
    formData.append('file', formFileJson);

    // for (let pair of formData.entries()) {
    //     console.log(pair[0]+ ', ' + pair[1]);
    // }

    // let xhr = new XMLHttpRequest;
    // xhr.open('POST', '/index.php?option=com_ajax&module=spselectsmartpoke&format=json&method=saveFile', true);
    // xhr.send(formData);

    $.ajax({
        url: "/index.php?option=com_ajax&module=spselectsmartpoke&format=json&method=saveFile", // point to server-side PHP script
        type: "POST",
        data: formData,
        cache: false,
        processData: false,
        contentType: false
    })
        .success(function(response){
            let object = response.data;
            let status = object.status;
            let message = object.message;
            let file = object.file;
            if (status == 0) {
                Joomla.renderMessages({'error': [message]});
            } else {
                Joomla.renderMessages({'success': [message]});
                tableFile = $('#datatable-file').DataTable({
                    "destroy": true,
                    "ajax": '/tmpfiles/'+file,
                    "columnDefs": [
                        {
                            "targets": 0,
                            "searchable": false,
                            "orderable": false,
                            "className": 'dt-body-center',
                            "render": function (data, type, row, meta) {
                                return '<input type="checkbox" name="id[]" value="' + row['0'] + row['2'] + '-' + row['3'] + '/' + row['1'] + row['2'] + '|' + row['5'] + '">';
                            }
                        },
                        {"targets": 1,
                            "render": function (data, type, row, meta) {
                                return "<div>" + row['3'] + "</div>";
                            }
                        },
                        {"targets": 2,
                            "render": function (data, type, row, meta) {
                                return "<div>" + row['4'] + "</div>";
                            }
                        },
                        {"targets": 3,
                            "render": function (data, type, row, meta) {
                                return "<div align='center'>" + row['0'] + row['2'] + "</div>";
                            }
                        },
                        {"targets": 4,
                            "render": function (data, type, row, meta) {
                                return "<div>" + row['5'] + "</div>";
                            }
                        }
                    ],
                    "responsive": true
                });
            }
        });
}

$(document).ready(function() {
    // Handle click on "Select all" control
    $('#smartpoke_select_all_db').on('click', function(){
        // Check/uncheck all checkboxes in the table
        let rows = tableDB.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    // Handle click on checkbox to set state of "Select all" control
    $('#datatable-database tbody').on('change', 'input[type="checkbox"]', function(){
        // If checkbox is not checked
        if(!this.checked){
            let el = $('#smartpoke_select_all_db').get(0);
            // If "Select all" control is checked and has 'indeterminate' property
            if(el && el.checked && ('indeterminate' in el)){
                // Set visual state of "Select all" control
                // as 'indeterminate'
                el.indeterminate = true;
            }
        }
    });

    // Handle click on "Select all" control
    $('#smartpoke_select_all_fl').on('click', function(){
        // Check/uncheck all checkboxes in the table
        let rows = tableFile.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    // Handle click on checkbox to set state of "Select all" control
    $('#datatable-file tbody').on('change', 'input[type="checkbox"]', function(){
        // If checkbox is not checked
        if(!this.checked){
            let el = $('#smartpoke_select_all_fl').get(0);
            // If "Select all" control is checked and has 'indeterminate' property
            if(el && el.checked && ('indeterminate' in el)){
                // Set visual state of "Select all" control
                // as 'indeterminate'
                el.indeterminate = true;
            }
        }
    });

    $('#smartpoke_form').on('submit', function(e){
        let form = this;

        switch (smartpokeOpt) {
            case "1": {
                break;
            }
            case "2": {
                break;
            }
            case "3": {
                // Iterate over all checkboxes in the table
                tableDB.$('input[type="checkbox"]').each(function(){
                    // If checkbox doesn't exist in DOM
                    if(!$.contains(document, this)){
                        // If checkbox is checked
                        if (this.checked) {
                            // Create a hidden element
                            $(form).append(
                                $('<input>')
                                    .attr('type', 'hidden')
                                    .attr('name', this.name)
                                    .val(this.value)
                            );
                        }
                    }
                });
                break;
            }
            case "4": {
                // Iterate over all checkboxes in the table
                tableFile.$('input[type="checkbox"]').each(function(){
                    // If checkbox doesn't exist in DOM
                    if(!$.contains(document, this)){
                        // If checkbox is checked
                        if (this.checked) {
                            // Create a hidden element
                            $(form).append(
                                $('<input>')
                                    .attr('type', 'hidden')
                                    .attr('name', this.name)
                                    .val(this.value)
                            );
                        }
                    }
                });
                break;
            }
        }

        // Output form data to a console
        let str = JSON.parse(JSON.stringify($(form).serializeArray()));
        let request = '';
        if (msgType == '1') {
            request = {
                option       : 'com_ajax',
                module       : 'spselectsmartpoke',  // to target: mod_spselectsmartpoke
                method       : 'sendSMS',  // to target: function sendSMSAjax in class ModSPSelectSmartPokeHelper
                format       : 'json',
                data         : {str, 'campaign': campaignId }
            };
        } else {
            request = {
                option       : 'com_ajax',
                module       : 'spselectsmartpoke',  // to target: mod_spselectsmartpoke
                method       : 'sendEmail',  // to target: function sendEmailAjax in class ModSPSelectSmartPokeHelper
                format       : 'json',
                data         : {str, 'campaign': campaignId }
            };
        }

        $.ajax({
            method: 'GET',
            data: request
        })
            .success(function(response){
                let object = response.data
                Joomla.renderMessages({'success': [object]});
            });

        $('#example-console').text($(form).serialize());
        console.log("Form submission", $(form).serialize());

        // Prevent actual form submission
        e.preventDefault();
        document.getElementById("smartpoke_form").reset();
    });
});
