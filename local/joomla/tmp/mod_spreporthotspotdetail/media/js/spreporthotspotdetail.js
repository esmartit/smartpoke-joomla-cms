let tableDetail = '';
let isSelected = false;
let modeExport = 'csv';
let exportData = [];
let exportDirect = false;

$(document).ready( function() {

    getCountryList();

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
            getHotSpotList();
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
            // showTableColumns();
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

                $("#selHotSpot").append("<option value='"+id+"'>"+name+"</option>");
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

    tableDetail = $('#datatable-buttons').DataTable({
        "destroy": true,
        "column": [
            {"data": "calledStationId"},
            {"data": "username"},
            {"data": "eventTimeStamp"},
            {"data": "session"},
            {"data": "inputOct"},
            {"data": "outputOct"},
            {"data": "statusType"},
            {"data": "serviceType"},
            {"data": "acctTerminateCause"},
            {"data": "callingStationId"}
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
    let t_dateS = $('#datestart').val();
    let t_dateE = $('#dateend').val();
    let t_timeS = $('#timestart').val();
    let t_timeE = $('#timeend').val();
    let t_country = $('#selCountryS').val();
    let t_state = $('#selStateS').val();
    let t_city = $('#selCityS').val();
    let t_zipcode = $('#selZipCodeS').val();
    let t_spot = $('#selSpot').val();
    let t_hotspot = $('#selHotSpot').val();
    // let t_ageS = $('#from_value').val();
    // let t_ageE = $('#to_value').val();
    // let t_sex = $('#selSex').val();
    // let t_zipcodes = $('#selZipCode').val();
    // let t_member = $('#selMembership').val();
    let t_ageS = '';
    let t_ageE = '';
    let t_sex = '';
    let t_zipcodes = '';
    let t_member = '';
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    let t_groupBy = 'BY_DAY';
    let t_isConnected = 1;
    t_hotspot = t_hotspot.split(' ').join('%7F');

    evtSourceDetailHotSpot(
        t_dateS, t_dateE, t_timeS, t_timeE,
        t_country, t_state, t_city, t_zipcode,
        t_spot, t_hotspot,
        t_ageS, t_ageE, t_sex, t_zipcodes, t_member,
        userTimeZone, t_groupBy, t_isConnected
    )
}

function downloadTextFile(text, name) {
    const a = document.createElement('a');
    const type = name.split(".").pop();
    a.href = URL.createObjectURL( new Blob([text], { type:`text/${type === "txt" ? "plain" : type}` }) );
    a.download = name;
    a.click();
}
function convertToCSVFile(data){
    let csv = '"HostSpot","Username","Time Start","Total Time","Upload","Download","Status","Service","Cause","Device"';
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
        csv += ',"' + data[i][9] + '"' + "\n";
    }
    return csv;
}

function evtSourceDetailHotSpot(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, hotspot, ageS, ageE, sex,
                                zipcodes, member, userTZ, group, connected) {
    let dataRows = [];

    let seActivityHotSpot = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/reports/list-radius?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26ssid="+hotspot+"%26isConnected="+connected+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);


    NProgress.start();
    NProgress.set(0,4);
    tableDetail.clear();
    tableDetail.draw(true);
    isSelected = false;
    exportData = [];
    exportDirect = false;
    $("#littleProgressBox").show();
    $("#littleProgress").text("Searching ...");

    seActivityHotSpot.onmessage = (event) => {
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
                let hotspot = bodyData.calledStationId;
                dataRows.push(
                    [
                        hotspot.substr(18, hotspot.length),
                        bodyData.userName,
                        bodyData.eventTimeStamp,
                        bodyData.session,
                        bodyData.inputOct,
                        bodyData.outputOct,
                        bodyData.statusType,
                        bodyData.serviceType,
                        bodyData.acctTerminateCause,
                        bodyData.callingStationId
                    ]);
            } else {
                if (exportDirect === false){
                    tableDetail = $('#datatable-buttons').DataTable({
                        "destroy": true,
                        data: dataRows,
                        "column": [
                            {"data": "calledStationId"},
                            {"data": "username"},
                            {"data": "eventTimeStamp"},
                            {"data": "session"},
                            {"data": "inputOct"},
                            {"data": "outputOct"},
                            {"data": "statusType"},
                            {"data": "serviceType"},
                            {"data": "acctTerminateCause"},
                            {"data": "callingStationId"}
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
                            downloadTextFile(convertToCSVFile(dataRows), 'Export Report HotSpot Detail.csv');
                        }else if(modeExport === 'json'){
                            downloadTextFile(JSON.stringify(dataRows), 'Export Report HotSpot Detail.json');
                        }else{
                            downloadTextFile(convertToCSVFile(dataRows), 'Export Report HotSpot Detail.csv');
                        }
                    }else{
                        $("#littleProgressBox").show();
                        exportData = dataRows;
                    }
                }
                $("#littleProgressBox").hide();
                seActivityHotSpot.close();
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
            downloadTextFile(convertToCSVFile(exportData), 'Export Report HotSpot Detail.csv');
        }else if(modeExport === 'json'){
            downloadTextFile(JSON.stringify(exportData), 'Export Report HotSpot Detail.json');
        }else{
            downloadTextFile(convertToCSVFile(exportData), 'Export Report HotSpot Detail.csv');
        }
    }
}