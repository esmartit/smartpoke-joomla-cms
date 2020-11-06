let t_devicesIn = [];
let t_devicesEx = [];
let t_devices = [];

$(document).ready( function() {

    getCountryList();
    getDeviceInList();
    getDeviceExList();

    document.getElementById("timestart").value = '00:00:00';
    document.getElementById("timeend").value = '23:59:59';
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

// $(document).ready(function () {
//     let type = '';
//     $('#radio15m').on('change', function () {
//         type = $('#radio15m').val();
//         $('input[name="radioGroup"]:radio:checked').val(type);
//         showGroup($('#radio15m').val())
//     });
//
//     $('#radio30m').on('change', function () {
//         type = $('#radio30m').val();
//         $('input[name="radioGroup"]:radio:checked').val(type);
//         showGroup($('#radio30m').val())
//     });
//
//     $('#radio60m').on('change', function () {
//         type = $('#radio60m').val();
//         $('input[name="radioGroup"]:radio:checked').val(type);
//         showGroup($('#radio60m').val())
//     });
//
// });

$(document).ready(function() {

    let datestart = moment().startOf('month');
    let dateend = moment();

    let cb = function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        datestart = start.format('YYYY-MM-DD');
        dateend = end.format('YYYY-MM-DD');
        $('#datestart').val(datestart);
        $('#dateend').val(dateend);
    };

    let optionSet1 = {
        startDate: moment().startOf('month'),
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

});

function sendForm() {
    getDeviceInList();
    getDeviceExList();
    let t_dateS = $('#datestart').val();
    let t_dateE = $('#dateend').val();
    let t_timeS = $('#timestart').val();
    let t_timeE = $('#timeend').val();
    let t_country = $('#selCountryS').val();
    let t_state = $('#selStateS').val();
    let t_city = $('#selCityS').val();
    let t_zipcode = $('#selZipCodeS').val();

    let t_spot = $('#selSpot').val();
    let t_sensor = $('#selSensor').val();
    let t_zone = $('#selZone').val();
    let t_type = $('#selType').val();

    let t_brands = '';
    let t_status = '';
    let t_presence = '';
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

    evtSourceDetailbyTimeBigData
    (
        t_dateS, t_dateE, t_timeS, t_timeE,
        t_country, t_state, t_city, t_zipcode,
        t_spot, t_sensor, t_zone, t_devicesIn, t_devicesEx,
        t_brands, t_status, t_presence,
        t_ageS, t_ageE, t_sex, t_zipcodes, t_member,
        userTimeZone
    );
}

function evtSourceDetailbyTimeBigData(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, inDevices, exDevices, brands, status, presence, ageS, ageE, sex,
                                zipcodes, member, userTZ) {

    let seActivityBigData = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/reports/listbytime?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zoneId="+zone+"%26includedDevices="+inDevices+"%26excludedDevices="+exDevices+
        "%26brands="+brands+"%26status="+status+"%26presence="+presence+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy=BY_HOUR");

    tableDetail = $('#datatable-buttons').DataTable({
        "destroy": true,
        "column": [
            {"data": "spotId"},
            {"data": "sensorId"},
            {"data": "groupDate"},
            {"data": "total"}
        ],
        "dom": 'Bfrtip',
        "buttons": [
            {
                "extend": 'copy',
                "className": 'btn-sm'
            },
            {
                "extend": 'csv',
                "className": 'btn-sm'
            },
            {
                "extend": 'excel',
                "className": 'btn-sm'
            },
            {
                "extend": 'pdfHtml5',
                "className": 'btn-sm'
            },
            {
                "extend": 'print',
                "className": 'btn-sm'
            },
        ],
        "responsive": true
    });

    NProgress.start();
    NProgress.set(0,4);
    tableDetail.clear();

    seActivityBigData.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let len = eventData.length;
        for (let x=0; x<len; x++) {
            let last = eventData[x].isLast;
            if (eventData[x].body != null) {
                let bodyData = eventData[x].body;
                tableDetail.row.add(
                    [
                        bodyData.spotId,
                        bodyData.sensorId,
                        bodyData.groupDate,
                        bodyData.total
                    ]).draw(false);
            } else {
                if (last) {
                    seActivityBigData.close();
                    NProgress.done();
                }
            }
        }
    }
}