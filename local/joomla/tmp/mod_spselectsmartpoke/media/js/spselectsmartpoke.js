let smartpokeOpt = '1';

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
    getCampaigns();
});

function getSpotCity() {
    let cityid = $('#cityId').val();
    let request = {
        option       : 'com_ajax',
        module       : 'spselectsmartpoke',  // to target: spselectsmartpoke
        method       : 'getSpots',  // to target: function getSpotsAjax in class ModSPSelectSmartPokeHelper
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
            $("#selSpot").append("<option value=''>All Data Lakes</option>");
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
        module       : 'spselectsmartpoke',  // to target: mod_spselectsmartpoke
        method       : 'getSensors',  // to target: function getSensorsAjax in class ModSPSelectSmartPokeHelper
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
    $('#radioSMS').on('change', function () {
        let sms = $('#radioSMS').val();
        getCampaigns(sms)
    });

    $('#radioEmail').on('change', function () {
        let email = $('#radioEmail').val();
        getCampaigns(email)
    });
});

function getCampaigns(smsemail = '1'){
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
            $("#selCampaign").append("<option value=''>Select Campaign</option>");
            for (let i = 0; i<len; i++) {
                let id = object[i][0];
                let name = object[i][1];

                $("#selCampaign").append("<option value='"+id+"'>"+name+"</option>");
            }
        });
}


$(document).ready(function () {
    $('#spOnline').on('change', function () {
        showOnlineOpt()
    });

    $('#spOffline').on('change', function () {
        showOfflineOpt()
    });

    $('#spDataBase').on('change', function () {
        showDataBaseOpt()
    });

    $('#spFile').on('change', function () {
        showFileOpt()
    });
});

function showOnlineOpt(){
    document.getElementById("hourstart").style.display = 'block';
    document.getElementById("hourend").style.display = 'block';
    $('#timeend').prop('disabled', true);
    document.getElementById("rangeDate").style.display = 'none';
    document.getElementById("selcountry").style.display = 'block';
    document.getElementById("selstate").style.display = 'block';
    document.getElementById("selcity").style.display = 'block';
    document.getElementById("selspots").style.display = 'block';
    document.getElementById("selsensors").style.display = 'block';
    document.getElementById("selbrands").style.display = 'block';
    document.getElementById("selposition").style.display = 'block';
    document.getElementById("selpresence").style.display = 'block';
    document.getElementById("datepresence").style.display = 'block';
    document.getElementById("filters").style.display = 'block';
    document.getElementById("selfile").style.display = 'none';
    document.getElementById("selcampaigns").style.display = 'block';
    smartpokeOpt = '1';
}

function showOfflineOpt(){
    document.getElementById("hourstart").style.display = 'block';
    document.getElementById("hourend").style.display = 'block';
    $('#timeend').prop('disabled', false);
    document.getElementById("rangeDate").style.display = 'block';
    document.getElementById("selcountry").style.display = 'block';
    document.getElementById("selstate").style.display = 'block';
    document.getElementById("selcity").style.display = 'block';
    document.getElementById("selspots").style.display = 'block';
    document.getElementById("selsensors").style.display = 'block';
    document.getElementById("selbrands").style.display = 'block';
    document.getElementById("selposition").style.display = 'block';
    document.getElementById("selpresence").style.display = 'block';
    document.getElementById("datepresence").style.display = 'block';
    document.getElementById("filters").style.display = 'block';
    document.getElementById("selfile").style.display = 'none';
    document.getElementById("selcampaigns").style.display = 'block';
    smartpokeOpt = '2';
}

function showDataBaseOpt(){
    document.getElementById("hourstart").style.display = 'none';
    document.getElementById("hourend").style.display = 'none';
    document.getElementById("rangeDate").style.display = 'none';
    document.getElementById("selcountry").style.display = 'block';
    document.getElementById("selstate").style.display = 'block';
    document.getElementById("selcity").style.display = 'block';
    document.getElementById("selspots").style.display = 'block';
    document.getElementById("selsensors").style.display = 'none';
    document.getElementById("selbrands").style.display = 'none';
    document.getElementById("selposition").style.display = 'none';
    document.getElementById("selpresence").style.display = 'none';
    document.getElementById("datepresence").style.display = 'none';
    document.getElementById("filters").style.display = 'block';
    document.getElementById("selfile").style.display = 'none';
    document.getElementById("selcampaigns").style.display = 'block';
    smartpokeOpt = '3';
}

function showFileOpt() {
    document.getElementById("hourstart").style.display = 'none';
    document.getElementById("hourend").style.display = 'none';
    document.getElementById("rangeDate").style.display = 'none';
    document.getElementById("selcountry").style.display = 'none';
    document.getElementById("selstate").style.display = 'none';
    document.getElementById("selcity").style.display = 'none';
    document.getElementById("selspots").style.display = 'none';
    document.getElementById("selsensors").style.display = 'none';
    document.getElementById("selbrands").style.display = 'none';
    document.getElementById("selposition").style.display = 'none';
    document.getElementById("selpresence").style.display = 'none';
    document.getElementById("datepresence").style.display = 'none';
    document.getElementById("filters").style.display = 'none';
    document.getElementById("selfile").style.display = 'block';
    document.getElementById("selcampaigns").style.display = 'block';
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

    let t_timeS = '';
    let t_timeE = '';
    let t_dateS = '';
    let t_dateE = '';
    let t_city = '';
    let t_spot = '';
    let t_sensor = '';
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

    if (smartpokeOpt == '1' || smartpokeOpt == '2') {  // Online and Offline option
        t_timeS = $('#timestart').val();
        t_timeE = $('#timeend').val();
        t_city = $('#cityId').val();
        t_spot = $('#selSpot').val();
        t_sensor = $('#selSensor').val();
        t_brands = $('#selBrand').val();
        t_status = $('#selStatus').val();
        t_presence = $('#presence').val();
        t_dateS2 = $('#datestart2').val();
        t_dateE2 = $('#dateend2').val();
        if (smartpokeOpt == '2') {          // Only Offline option
            t_dateS = $('#datestart').val();
            t_dateE = $('#dateend').val();
        }
    }
    if (smartpokeOpt != '4') {  // Not File option
        if (document.getElementById("checkFilter").checked) {
            t_ageS = $('#from_value').val();
            t_ageE = $('#to_value').val();
            t_sex = $('#selSex').val();
            t_zipcodes = $('#selZipCode').val();
            t_member = $('#selMembership').val();
        }
    }
    if (smartpokeOpt == '4') { // Only File option
        formFile = document.getElementById('selFile');
        formFileJson = formFile.files[0];
    }

    let dataForm = { "dateStart": t_dateS, "dateEnd": t_dateE, "startTime": t_timeS, "endTime": t_timeE,
        "dateStart2": t_dateS2, "dateEnd2": t_dateE2, "cityId": t_city,
        "spotId": t_spot, "sensorId": t_sensor, "brands": t_brands,
        "status": t_status, "presence": t_presence,
        "ageStart": t_ageS, "ageEnd": t_ageE, "gender": t_sex,
        "zipCode": t_zipcodes, "memberShip": t_member, "file": formFileJson }
    console.log(dataForm);
}