let smsemail = '1';
getSpotCity();
getCampaigns(smsemail);
getSmsEmailMonthly();
let monthly = '';

function getSpotCity() {
    let cityid = $('#cityId').val();
    let request = {
        option       : 'com_ajax',
        module       : 'spselectcampaigndetail',  // to target: spselectcampaigndetail
        method       : 'getSpots',  // to target: function getSpotsAjax in class ModSPSelectCampaignDetailHelper
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

    $('#datatable-cDetailed').DataTable();
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
        module       : 'spselectcampaigndetail',  // to target: mod_spselectcampaigndetail
        method       : 'getCampaigns',  // to target: function getCampaignsAjax in class ModSPSelectCampaignDetailHelper
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

function getSmsEmailMonthly(value = 'total_sms_month'){
    let request = {
        option       : 'com_ajax',
        module       : 'spselectcampaigndetail',  // to target: mod_spselectcampaigndetail
        method       : 'getSmsEmailMonth',  // to target: function getSmsEmailMonthAjax in class ModSPSelectCampaignDetailHelper
        format       : 'json',
        data         : value
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data;
            document.getElementById('total_smsemail_ini').innerHTML = Intl.NumberFormat().format(object);
            $('#totalsmsemailini').val(object);
        });
}

function getSmsEmailSent(dstart, dend, type){
    let request = {
        option       : 'com_ajax',
        module       : 'spselectcampaigndetail',  // to target: mod_spselectcampaigndetail
        method       : 'getMessagesMonth',  // to target: function getMessagesMonthAjax in class ModSPSelectCampaignDetailHelper
        format       : 'json',
        data         : { "dateStart": dstart, "dateEnd": dend, "smsEmail":type }
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let sent = 0;
            let ok = 0;
            let nok = 0;
            monthly = $('#totalsmsemailini').val();
            let object = response.data;
            let len = object.length;
            for (let i = 0; i<len; i++) {
                let status = object[i][0];
                let count = object[i][1];

                if (status == '0') {
                    nok = parseInt(count);
                }
                if (status == '1') {
                    ok =parseInt(count);
                }
                sent += parseInt(count);
            }
            monthly -= sent;
            document.getElementById('total_smsemail').innerHTML = Intl.NumberFormat().format(monthly);
            document.getElementById('total_smsemail_sent').innerHTML = Intl.NumberFormat().format(sent);
            document.getElementById('total_smsemail_ok').innerHTML = Intl.NumberFormat().format(ok);
            document.getElementById('total_smsemail_nok').innerHTML = Intl.NumberFormat().format(nok);
        });
}

function getCampaignSent(dstart, dend, campaign, city, spot){
    let request = {
        option       : 'com_ajax',
        module       : 'spselectcampaigndetail',  // to target: mod_spselectcampaigndetail
        method       : 'getMessagesCampaign',  // to target: function getMessagesCampaignAjax in class ModSPSelectCampaignDetailHelper
        format       : 'json',
        data         : { "dateStart": dstart, "dateEnd": dend, "campaignId":campaign, "cityId": city, "spotId": spot }
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let sent = 0;
            let ok = 0;
            let nok = 0;
            let object = response.data;
            let len = object.length;
            for (let i = 0; i<len; i++) {
                let status = object[i][0];
                let count = object[i][1];

                if (status == '0') {
                    nok = parseInt(count);
                }
                if (status == '1') {
                    ok =parseInt(count);
                }
                sent += parseInt(count);
            }
            document.getElementById('smsemail_sent').innerHTML = Intl.NumberFormat().format(sent);
            document.getElementById('smsemail_ok').innerHTML = Intl.NumberFormat().format(ok);
            document.getElementById('smsemail_nok').innerHTML = Intl.NumberFormat().format(nok);
        });
}

function getCampaignDetail(dstart, dend, campaign, city, spot){
    let request = {
        option       : 'com_ajax',
        module       : 'spselectcampaigndetail',  // to target: mod_spselectcampaigndetail
        method       : 'getCampaignDetail',  // to target: function getCampaignDetailAjax in class ModSPSelectCampaignDetailHelper
        format       : 'json',
        data         : { "dateStart": dstart, "dateEnd": dend, "campaignId":campaign, "cityId": city, "spotId": spot }
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
    let table = $('#datatable-cDetailed').DataTable( {
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
    let t_city = $('#cityId').val();
    let t_spot = $('#selSpot').val();
    let t_campaign = $('#selCampaign').val();

    getSmsEmailSent(t_dateS, t_dateE, smsemail);
    getCampaignSent(t_dateS, t_dateE, t_campaign, t_city, t_spot);
    getCampaignDetail(t_dateS, t_dateE, t_campaign, t_city, t_spot);
}