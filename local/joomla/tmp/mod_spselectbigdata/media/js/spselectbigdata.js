$(document).ready( function() {

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
    getSpotCity();

});

function getSpotCity() {
    let cityid = $('#cityId').val();
    let request = {
        option       : 'com_ajax',
        module       : 'spselectbigdata',  // to target: mod_spselectbigdata
        method       : 'getSpots',  // to target: function getSpotsAjax in class ModSPSelectBigDataHelper
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
        });
}

function getSensorSpot() {
    let spotid = $('#selSpot').val();
    let request = {
        option       : 'com_ajax',
        module       : 'spselectbigdata',  // to target: mod_spselectbigdata
        method       : 'getSensors',  // to target: function getSensorsAjax in class ModSPSelectBigDataHelper
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
    $('#radioRange').on('change', function () {
        hideDaterange()
    });

    $('#radioCompare').on('change', function () {
        showDaterange()
    });
});

function showDaterange(){
    document.getElementById("rangeDate").style.display = 'block';
}
function hideDaterange(){
    document.getElementById("rangeDate").style.display = 'none';
};

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
        startDate: moment().subtract(1, 'days'),
        endDate: moment().subtract(1, 'days'),
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
    $('#radioDay').on('change', function () {
        showGraph($('#radioDay').val())
    });

    $('#radioWeek').on('change', function () {
        showGraph($('#radioWeek').val())
    });

    $('#radioMonth').on('change', function () {
        showGraph($('#radioMonth').val())
    });

    $('#radioYear').on('change', function () {
        showGraph($('#radioYear').val())
    });
});

function showGraph(type) {
    let graphType = type;
    let request = {
        option       : 'com_ajax',
        module       : 'spactivitybigdata',  // to target: mod_spactivitybigdata
        method       : 'showGraphBigData',  // to target: function showGraphBigDataAjax in class ModSPActivityBigDataHelper
        format       : 'json',
        data         : graphType
    };
    $.ajax({
        method: 'POST',
        data: request
    })
        .success(function(response) {
            console.log('call success '+graphType);
        })
        .error(function() {
            console.log('ajax call failed');
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
    let t_dateS = $('#datestart').val();
    let t_dateE = $('#dateend').val();
    let t_timeS = $('#timestart').val();
    let t_timeE = $('#timeend').val();
    let t_dateS2 = $('#datestart2').val();
    let t_dateE2 = $('#dateend2').val();
    let t_city = $('#cityId').val();
    let t_spot = $('#selSpot').val();
    let t_sensor = $('#selSensor').val();
    let t_brands = $('#selBrand').val();
    let t_status = $('#selStatus').val();
    let t_presence = $('#presence').val();
    let t_ageS = '';
    let t_ageE = '';
    let t_sex = '';
    let t_zipcodes = '';
    let t_member = '';
    if (document.getElementById("checkFilter").checked) {
        t_ageS = $('#from_value').val();
        t_ageE = $('#to_value').val();
        t_sex = $('#selSex').val();
        t_zipcodes = $('#selZipCode').val();
        t_member = $('#selMembership').val();
    }

    let dataForm = { "datestart": t_dateS, "dateend": t_dateE, "starttime": t_timeS, "endtime": t_timeE,
        "datestart2": t_dateS2, "dateend2": t_dateE2, "city": t_city,
        "spot": t_spot, "sensor": t_sensor, "brands": t_brands,
        "status": t_status, "presence": t_presence,
        "ageS": t_ageS, "ageE": t_ageE, "gender": t_sex,
        "zipcode": t_zipcodes, "membership": t_member }
    console.log(dataForm);
}
