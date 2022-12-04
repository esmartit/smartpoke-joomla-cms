let t_devicesIn = [];
let t_devicesEx = [];

let tableDetailDaily = '';
let isSelected = false;
let modeExport = 'csv';
let exportData = [];
let exportDirect = false;



$(document).ready( function() {

    getCountryList();
    getDeviceInList();
    getDeviceExList();

    document.getElementById("timestart").value = '00:00:00';
    document.getElementById("timeend").value = '23:59:59';

    //$('#datatable-buttons').DataTable({responsive: true});
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

$(document).ready(() => {

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
    tableDetailDaily = $('#datatable-buttons').DataTable({
        "destroy": true,
        "column": [
            {"data": "spotId"},
            {"data": "sensorId"},
            {"data": "clientMac"},
            {"data": "username"},
            {"data": "dateAtZone"},
            {"data": "minTime"},
            {"data": "maxTime"},
            {"data": "status"},
            {"data": "totalTime"},
            {"data": "gender"},
            {"data": "age"},
            {"data": "userZipCode"},
            {"data": "countryId"},
            {"data": "stateId"},
            {"data": "cityId"},
            {"data": "zipCode"}
        ],
        "dom": 'Bfrtip',
        "buttons": [
            {
                "extend": 'csv',
                "className": 'btn-sm'
            },
            {
                "extend": 'excel',
                "className": 'btn-sm'
            }
        ],
        "responsive": true
    });
    $("#littleProgressBox").hide();
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

    evtSourceDetailBigDataDaily
    (
        t_dateS, t_dateE, t_timeS, t_timeE,
        t_country, t_state, t_city, t_zipcode,
        t_spot, t_sensor, t_zone, t_devicesIn, t_devicesEx,
        t_brands, t_status, t_presence,
        t_ageS, t_ageE, t_sex, t_zipcodes, t_member,
        userTimeZone
    );
}

function hashFnv32a(str, asString, seed) {
    /*jshint bitwise:false */
    var i, l,
        hval = (seed === undefined) ? 0x811c9dc5 : seed;

    for (i = 0, l = str.length; i < l; i++) {
        hval ^= str.charCodeAt(i);
        hval += (hval << 1) + (hval << 4) + (hval << 7) + (hval << 8) + (hval << 24);
    }
    if( asString ){
        // Convert to 8 digit hex string
        return ("0000000" + (hval >>> 0).toString(16)).substr(-8);
    }
    return hval >>> 0;
}

function toHHMMSS(milis){
    let sec = milis / 1000;
    let sec_num = parseInt(sec, 10);
    let hours = Math.floor(sec_num / 3600);
    let minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    let seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours < 10) hours = "0" + hours;
    if (minutes < 10) minutes = "0" + minutes;
    if (seconds < 10) seconds = "0" + seconds;

    return hours+':'+minutes+':'+seconds;
}

function downloadTextFile(text, name) {
    const a = document.createElement('a');
    const type = name.split(".").pop();
    a.href = URL.createObjectURL( new Blob([text], { type:`text/${type === "txt" ? "plain" : type}` }) );
    a.download = name;
    a.click();
}
function convertToCSVFile(data){
    let csv = '"SpotId","SensorId","Device","UserName","Date","First Time","Last Time","Total Time","Status","Sex","Age","ZipCode","CountryId","StateId","CityId","ZipCode"';
    csv += "\n";
    for(let i = 0; i < data.length; i++){
        csv += '"' + data[i][0] + '"';
        csv += ',"' + data[i][1] + '"';
        csv += ',"' + data[i][2] + '"';
        csv += ',"' + data[i][3] + '"';
        csv += ',"' + data[i][4] + '"';
        csv += ',"' + data[i][5] + '"';
        csv += ',"' + data[i][6] + '"';
        csv += ',"' + data[i][7] + '"';
        csv += ',"' + data[i][8] + '"';
        csv += ',"' + data[i][9] + '"';
        csv += ',"' + data[i][10] + '"';
        csv += ',"' + data[i][11] + '"';
        csv += ',"' + data[i][12] + '"';
        csv += ',"' + data[i][13] + '"';
        csv += ',"' + data[i][14] + '"';
        csv += ',"' + data[i][15] + '"' + "\n";
    }
    return csv;
}

function evtSourceDetailBigDataDaily(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, inDevices, exDevices, brands, status, presence, ageS, ageE, sex,
                                zipcodes, member, userTZ) {
    let dataRows = [];

    let seActivityBigDataDaily = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/reports/v2/list?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zone="+zone+"%26includedDevices="+inDevices+"%26excludedDevices="+exDevices+
        "%26brands="+brands+"%26status="+status+"%26presence="+presence+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy=BY_DAY");

    NProgress.start();
    NProgress.set(0,4);
    tableDetailDaily.clear();
    tableDetailDaily.draw(true);
    isSelected = false;
    exportData = [];
    exportDirect = false;
    $("#littleProgressBox").show();
    $("#littleProgress").text("Searching ...");

    seActivityBigDataDaily.onmessage = (event) => {
        let eventData = JSON.parse(event.data);
        let len = eventData.length;
        if (dataRows.length >= 80000 && isSelected === false && exportDirect === false){
            $("#myModal").show();
            exportDirect = true;
        }
        $("#littleProgress").text("receiving " + dataRows.length + " ...");
        for (let x=0; x<len; x++) {
            let last = eventData[x].isLast;
            if (!last) {
                let bodyData = eventData[x].body;
                let miTime = new Date(bodyData.minTime);
                let maTime = new Date(bodyData.maxTime);
                let minTime = ("0"+miTime.getHours()).slice(-2)+':'+("0"+miTime.getMinutes()).slice(-2)+':'+("0"+miTime.getSeconds()).slice(-2);
                let maxTime = ("0"+maTime.getHours()).slice(-2)+':'+("0"+maTime.getMinutes()).slice(-2)+':'+("0"+maTime.getSeconds()).slice(-2);
                let timeHHMMSS = toHHMMSS(bodyData.totalTime);
                let userName = bodyData.username;
                let gender = bodyData.gender;
                let age = bodyData.age;
                let userZipCode = bodyData.userZipCode;
                let countryId = bodyData.countryId;
                let stateId = bodyData.stateId;
                let cityId = bodyData.cityId;
                let zipCode = bodyData.zipCode;
                if ( userName == null) {
                    userName = '';
                    gender = '';
                    age = '';
                    userZipCode = '';
                }
                if (countryId == null) countryId = '';
                if (stateId == null) stateId = '';
                if (cityId == null) cityId = '';
                if (zipCode == null) zipCode = '';

                dataRows.push([
                    bodyData.spotId,
                    bodyData.sensorId,
                    bodyData.clientMac.substr(-8)+'-'+hashFnv32a(bodyData.clientMac, true, 'eSmartIT'),
                    userName,
                    bodyData.groupDate,
                    minTime,
                    maxTime,
                    timeHHMMSS,
                    bodyData.status,
                    gender,
                    age,
                    userZipCode,
                    countryId,
                    stateId,
                    cityId,
                    zipCode
                ]);
            } else {
                if (exportDirect === false){
                    tableDetailDaily = $('#datatable-buttons').DataTable({
                        "destroy": true,
                        data: dataRows,
                        "column": [
                            {"data": "spotId"},
                            {"data": "sensorId"},
                            {"data": "clientMac"},
                            {"data": "username"},
                            {"data": "dateAtZone"},
                            {"data": "minTime"},
                            {"data": "maxTime"},
                            {"data": "status"},
                            {"data": "totalTime"},
                            {"data": "gender"},
                            {"data": "age"},
                            {"data": "userZipCode"},
                            {"data": "countryId"},
                            {"data": "stateId"},
                            {"data": "cityId"},
                            {"data": "zipCode"}
                        ],
                        "dom": 'Bfrtip',
                        "buttons": [
                            {
                                "extend": 'csv',
                                "className": 'btn-sm'
                            },
                            {
                                "extend": 'excel',
                                "className": 'btn-sm'
                            }
                        ],
                        "responsive": true
                    });
                }else{
                    if (isSelected){
                        if (modeExport === 'csv'){
                            downloadTextFile(convertToCSVFile(dataRows), 'Export Big Data Detail Daily.csv');
                        }else if(modeExport === 'json'){
                            downloadTextFile(JSON.stringify(dataRows), 'Export Big Data Detail Daily.json');
                        }else{
                            downloadTextFile(convertToCSVFile(dataRows), 'Export Big Data Detail Daily.csv');
                        }
                    }else{
                        $("#littleProgressBox").show();
                        exportData = dataRows;
                    }
                }
                $("#littleProgressBox").hide();
                seActivityBigDataDaily.close();
                NProgress.done();
            }
        }
    }
}

function goToExport(type){
    if(type === 'csv' || type === 'json'){
        modeExport = type;
    }else{
        modeExport = 'csv';
    }
    isSelected = true;
    $("#myModal").hide();
    if(exportData.length !== 0){
        if (modeExport === 'csv'){
            downloadTextFile(convertToCSVFile(exportData), 'Export Big Data Detail Daily.csv');
        }else if(modeExport === 'json'){
            downloadTextFile(JSON.stringify(exportData), 'Export Big Data Detail Daily.json');
        }else{
            downloadTextFile(convertToCSVFile(exportData), 'Export Big Data Detail Daily.csv');
        }
    }
}