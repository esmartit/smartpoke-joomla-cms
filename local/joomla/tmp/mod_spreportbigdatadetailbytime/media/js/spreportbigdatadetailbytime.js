$(document).ready(function() {
    document.getElementById("timestart").value = '00:00:00';
    document.getElementById("timeend").value = '23:59:59';
});

function setSpotCity() {
    $('#cityId').val('');
    getSpotCity();
}

function getSpotCity() {
    let cityid = $('#cityId').val();
    let request = {
        option       : 'com_ajax',
        module       : 'spreportbigdatadetailbytime',  // to target: mod_spreportbigdatadetailbytime
        method       : 'getSpots',  // to target: function getSpotsAjax in class ModSPReportBigDataDetailByTimeHelper
        format       : 'json',
        data         : cityid
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
            getSensorSpot();
        });
}

function getSensorSpot() {
    let spotid = $('#selSpot').val();
    let request = {
        option       : 'com_ajax',
        module       : 'spreportbigdatadetailbytime',  // to target: mod_spreportbigdatadetailbytime
        method       : 'getSensors',  // to target: function getSensorsAjax in class ModSPReportBigDataDetailByTimeHelper
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

$(document).ready(function () {
    $('#radio15m').on('change', function () {
        showGroup($('#radio15m').val())
    });

    $('#radio30m').on('change', function () {
        showGroup($('#radio15m').val())
    });

    $('#radio15m').on('change', function () {
        showGroup($('#radio60m').val())
    });

});

function showGroup(type) {
    let groupType = type;
    let request = {
        option       : 'com_ajax',
        module       : 'spreportbigdatadetailbytime',  // to target: mod_spreportbigdatadetailbytime
        method       : 'showGroupBigData',  // to target: function showGroupBigDataAjax in class ModSPReportBigDataDetailByTimeHelper
        format       : 'json',
        data         : groupType
    };
    $.ajax({
        method: 'POST',
        data: request
    })
        .success(function(response) {
            console.log('call success '+groupType);
        })
        .error(function() {
            console.log('ajax call failed');
        });
}

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
        minDate: '01/01/2012',
        maxDate: '12/31/2050',
        dateLimit: {
            days: 365
        },
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
    let t_dateS = $('#datestart').val();
    let t_dateE = $('#dateend').val();
    let t_timeS = $('#timestart').val();
    let t_timeE = $('#timeend').val();
    let t_city = $('#cityId').val();
    let t_spot = $('#selSpot').val();
    let t_group = $('#selGroup').val();
    let t_sensor = $('#selSensor').val();
    let userTimeZone = document.getElementById('userTimeZone').innerText;

    let dataForm = { "dateStart": t_dateS, "dateEnd": t_dateE, "startTime": t_timeS, "endTime": t_timeE,
        "cityId": t_city, "spotId": t_spot, "sensorId": t_sensor, "group": t_group, "timeZone": userTimeZone }
    console.log(dataForm);
}