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
    getSpotCity();
    getCampaigns();

    function showTimeEnd(time) {
        document.getElementById("timeend").value = time;
    }

    function objTimer() {

        ActualDateTime = new Date()
        Actualhour = ActualDateTime.getHours()
        Actualminute = ActualDateTime.getMinutes()
        Actualsecond = ActualDateTime.getSeconds()

        var strTime = "";
        h = '0' + Actualhour;
        m = '0' + Actualminute;
        s = '0' + Actualsecond;
        strTime += h.substring(h.length - 2, h.length) + ':' + m.substring(m.length - 2, m.length) + ':'+ s.substring(s.length - 2, s.length);

        var checksec = (Actualsecond / 30)
        if (checksec % 1 == 0) {
            showTimeEnd(strTime);
            console.log(strTime);
        }
    }

    setInterval(objTimer, 1000);
    objTimer();
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
            $("#selCampaign").append("<option value=''>Select Campaing</option>");
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
    document.getElementById("daterange").style.display = 'none';
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
}

function showOfflineOpt(){
    document.getElementById("hourstart").style.display = 'block';
    document.getElementById("hourend").style.display = 'block';
    document.getElementById("daterange").style.display = 'block';
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
}

function showDataBaseOpt(){
    document.getElementById("hourstart").style.display = 'none';
    document.getElementById("hourend").style.display = 'none';
    document.getElementById("daterange").style.display = 'none';
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
}

function showFileOpt() {
    document.getElementById("hourstart").style.display = 'none';
    document.getElementById("hourend").style.display = 'none';
    document.getElementById("daterange").style.display = 'none';
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
}

$(document).ready(function() {

    var datestart;
    var dateend;
    var datestart2;
    var dateend2;

    var cb = function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        datestart = start.format('YYYY-MM-DD');
        dateend = end.format('YYYY-MM-DD');
        $('#datestart').val(datestart);
        $('#dateend').val(dateend);
    };

    var cb2 = function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange_right span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        datestart2 = start.format('YYYY-MM-DD');
        dateend2 = end.format('YYYY-MM-DD');
        $('#datestart2').val(datestart2);
        $('#dateend2').val(dateend2);

    };

    var optionSet1 = {
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

    $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    $('#reportrange').daterangepicker(optionSet1, cb);
    $('#reportrange').on('show.daterangepicker', function () {
        console.log("show event fired");
    });
    $('#reportrange').on('hide.daterangepicker', function () {
        console.log("hide event fired");
    });
    $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
        console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
    });
    $('#reportrange').on('cancel.daterangepicker', function (ev, picker) {
        console.log("cancel event fired");
    });
    $('#options1').click(function () {
        $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
    });
    $('#options2').click(function () {
        $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
    });
    $('#destroy').click(function () {
        $('#reportrange').data('daterangepicker').remove();
    });

    $('#reportrange_right span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

    $('#reportrange_right').daterangepicker(optionSet1, cb2);

    $('#reportrange_right').on('show.daterangepicker', function () {
        console.log("show event fired");
    });
    $('#reportrange_right').on('hide.daterangepicker', function () {
        console.log("hide event fired");
    });
    $('#reportrange_right').on('apply.daterangepicker', function (ev, picker) {
        console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
    });
    $('#reportrange_right').on('cancel.daterangepicker', function (ev, picker) {
        console.log("cancel event fired");
    });

    $('#options1').click(function () {
        $('#reportrange_right').data('daterangepicker').setOptions(optionSet1, cb2);
    });

    $('#options2').click(function () {
        $('#reportrange_right').data('daterangepicker').setOptions(optionSet2, cb2);
    });

    $('#destroy').click(function () {
        $('#reportrange_right').data('daterangepicker').remove();
    });

});

