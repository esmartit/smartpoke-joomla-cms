let smsemail = '1';
getSpotCity();
getCampaigns(smsemail);

$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    const seRegisteredTotal = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/total-registered-count?timezone="+userTimeZone);
    let registeredtotal = 0;

    seRegisteredTotal.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        registeredtotal = eventData.count;
        document.getElementById("registeredUsers").innerHTML = Intl.NumberFormat().format(registeredtotal);
    }
});

function getSpotCity() {
    let cityid = $('#cityId').val();
    let request = {
        option       : 'com_ajax',
        module       : 'spselectcampaigneffectiveness',  // to target: mod_spselectcampaigneffectiveness
        method       : 'getSpots',  // to target: function getSpotsAjax in class ModSPSelectCampaignEffectivenessHelper
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

$(document).ready(function () {

    $('#datatable-cEffectivenes').DataTable();
    $('#radioSMS').on('change', function () {
        smsemail = $('#radioSMS').val();
        getCampaigns(smsemail);
        getSmsEmailMonthly('total_sms_month');
    });

    $('#radioEmail').on('change', function () {
        smsemail = $('#radioEmail').val();
        getCampaigns(smsemail);
        getSmsEmailMonthly('total_email_month');
    });
});

function getCampaigns(smsemailValue = '1'){
    let request = {
        option       : 'com_ajax',
        module       : 'spselectcampaigneffectiveness',  // to target: mod_spselectcampaigneffectiveness
        method       : 'getCampaigns',  // to target: function getCampaignsAjax in class ModSPSelectCampaignEffectivenessHelper
        format       : 'json',
        data         : smsemailValue
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

function getSmsEmailTotal(){
    let campaign = $('#selCampaign').val();
    let request = {
        option       : 'com_ajax',
        module       : 'spselectcampaigneffectiveness',  // to target: mod_spselectcampaigneffectiveness
        method       : 'getSmsEmailTotal',  // to target: function getSmsEmailTotalAjax in class ModSPSelectCampaignEffectivenessHelper
        format       : 'json',
        data         : campaign
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data;
            document.getElementById('totalMessage').innerHTML = Intl.NumberFormat().format(object);
        });
}

function getCampaignDetail(dstart, dend, campaign, country, state, city, spot){
    let request = {
        option       : 'com_ajax',
        module       : 'spselectcampaigneffectiveness',  // to target: mod_spselectcampaigneffectiveness
        method       : 'getCampaignDetail',  // to target: function getCampaignDetailAjax in class ModSPSelectCampaignEffectivenessHelper
        format       : 'json',
        data         : { "dateStart": dstart, "dateEnd": dend, "campaignId":campaign,
            "countryId": country, "stateId": state, "cityId": city, "spotId": spot }
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data
            createTable(object);
        });
}

function createTable(data) {
    let table = $('#datatable-cEffectivenes').DataTable( {
        "destroy": true,
        "aaData": data,
        "columns": [
            { "data": "name" },
            { "data": "device_sms" },
            { "data": "username" },
            { "data": "senddate" },
            { "data": "status",
                "render": function(data, type) {
                    if (data == '0') {
                        return "<div align='center'><span class='glyphicon glyphicon-remove' style='color:#FF0000'> </span></div>";
                    } else {
                        return "<div align='center'><span class='glyphicon glyphicon-ok' style='color:#00FF00'> </span></div>";
                    }
                }
            },
            { "data": "description" },
            { "data": "spot" }
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
    })
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

    let selCountry = document.getElementById('countryId');
    let selectedCountry = selCountry.options[selCountry.selectedIndex];
    let t_country = selectedCountry.getAttribute('countryid');
    if (t_country === null) {
        t_country = '';
    }

    let selState = document.getElementById('stateId');
    let selectedState = selState.options[selState.selectedIndex];
    let t_state = selectedState.getAttribute('stateid');
    if (t_state === null) {
        t_state = '';
    } else {
        t_state = t_state.substr(1, t_state.length-2)
    }

    let t_city = $('#cityId').val();
    let t_spot = $('#selSpot').val();
    let t_campaign = $('#selCampaign').val();

    getCampaignDetail(t_dateS, t_dateE, t_campaign, t_country, t_state, t_city, t_spot);
}