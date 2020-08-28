let smsemail = '1';
let seUniqueIN = '';
let devUniqueIN = [];
let bigDataIN = [];
let userTimeZone = '';


$(document).ready( function() {
    userTimeZone = document.getElementById('userTimeZone').innerText;
    let seRegisteredTotal = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/total-registered-count?timezone="+userTimeZone);
    let registeredtotal = 0;

    seRegisteredTotal.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        registeredtotal = eventData.count;
        document.getElementById("registeredUsers").innerHTML = Intl.NumberFormat().format(registeredtotal);
    }
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

$(document).ready(function () {
    getCountryList();
    getCampaigns(smsemail);

    $('#datatable-cEffectivenes').DataTable();
    $('#radioSMS').on('change', function () {
        smsemail = $('#radioSMS').val();
        getCampaigns(smsemail);
        getSmsEmailTotal();
    });

    $('#radioEmail').on('change', function () {
        smsemail = $('#radioEmail').val();
        getCampaigns(smsemail);
        getSmsEmailTotal();
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
            $("#selCampaign").append("<option value='' selected disabled>Select Campaign</option>");
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
            $('#itotalMessage').val(object);
        });
}

function getCampaignDetail(dstart, dend, campaign, country, state, city, zipcode, spot){
    let request = {
        option       : 'com_ajax',
        module       : 'spselectcampaigndetail',  // to target: mod_spselectcampaigndetail
        method       : 'getCampaignDetail',  // to target: function getCampaignDetailAjax in class ModSPSelectCampaignDetailHelper
        format       : 'json',
        data         : { "dateStart": dstart, "dateEnd": dend, "campaignId":campaign,
            "countryId": country, "stateId": state, "cityId": city, "zipcodeId": zipcode, "spotId": spot }
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

function getNewUsersCampaign(dstart, dend, campaign, type){
    let request = {
        option       : 'com_ajax',
        module       : 'spselectcampaigneffectiveness',  // to target: mod_spselectcampaigneffectiveness
        method       : 'getNewUsers',  // to target: function getNewUsersAjax in class ModSPSelectCampaignEffectivenessHelper
        format       : 'json',
        data         : { "dateStart": dstart, "dateEnd": dend, "campaignId":campaign, "type": type }
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data
            if (type == 'T') {
                document.getElementById('targetNew').innerHTML = Intl.NumberFormat().format(object);
                $('#itargetNew').val(object);
            } else {
                document.getElementById('newUsers').innerHTML = Intl.NumberFormat().format(object);
                $('#inewUsers').val(object);
            }
            newUsersPercentage();
        });
}

function newUsersPercentage(){
    let targetNew = $('#itargetNew').val();
    let newUsers = $('#inewUsers').val();

    let totalUsers = parseInt(targetNew) + parseInt(newUsers);
    document.getElementById('totalUsers').innerHTML = totalUsers;
    $('#itotalUsers').val(totalUsers);

    let totalTarget = $('#itotalMessage').val();
    let newUsersPercentage = (parseInt(totalUsers)/parseInt(totalTarget))*100;
    document.getElementById('newUserPercentage').innerHTML = Intl.NumberFormat().format(newUsersPercentage)+' %';

}

function percentageIN(){
    let totalTarget = $('#itotalMessage').val();
    let totalIN = $('#itotalIn').val();
    let percentageIN = (parseInt(totalIN)/parseInt(totalTarget))*100;
    document.getElementById("percentageIN").innerHTML = Intl.NumberFormat().format(percentageIN)+' %';
}

function evtSourceUniqueIN(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, brands, status, presence, ageS, ageE, sex,
                                zipcodes, member, userTZ, group) {
    let len = bigDataIN.length;
    for (let i=0; i<len; i++) {
        bigDataIN[i] = '';
        devUniqueIN[i] = 0;
    }
    let d1 = new Date(dateS + 'Z12:00:00');
    let d2 = new Date(dateE + 'Z12:00:00');
    let days = Math.round((d2 - d1) / (1000 * 3600 * 24));
    for (let i=0; i<=days; i++) {
        let month = '' + (d1.getMonth() + 1);
        let day = '' + d1.getDate();
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day =  '0' + day;
        bigDataIN[i] = [month, day].join('/');
        devUniqueIN[i] = 0;
        d1 = new Date(d1.setDate(d1.getDate() + 1));
    }

    seUniqueIN = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/find?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zoneId="+zone+
        "%26brands="+brands+"%26status="+status+"%26presence="+presence+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);

    let pos = 0;
    let uniqueIN = 0;
    seUniqueIN.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let axisGroup = '';
        let group_x = eventData.group;
        let in_x = eventData.inCount;
        let last = eventData.isLast;

        axisGroup = group_x.substr(group_x.length -5,group_x.length);
        pos = bigDataIN.indexOf(axisGroup);
        devUniqueIN[pos] = in_x;
        uniqueIN = in_x;

        document.getElementById("totalIn").innerHTML = Intl.NumberFormat().format(uniqueIN);
        if (last) {
            for(let i = 0, len = devUniqueIN.length; i < len; i++) {
                uniqueIN += devUniqueIN[i];
                document.getElementById("totalIn").innerHTML = Intl.NumberFormat().format(uniqueIN);
                $("#itotalIn").val(uniqueIN);
            }
            seUniqueIN.close();
            percentageIN();
        }
    }
}

function sendForm() {
    let t_dateS = $('#datestart').val();
    let t_dateE = $('#dateend').val();

    let t_country = $('#selCountryS').val();
    let t_state = $('#selStateS').val();
    let t_city = $('#selCityS').val();
    let t_zipcode = $('#selZipCodeS').val();

    let t_spot = $('#selSpot').val();
    let t_campaign = $('#selCampaign').val();

    evtSourceUniqueIN(t_dateS, t_dateE, '', '',
        t_country, t_state, t_city, t_zipcode,
        t_spot, '', '',
        '', 'IN', '1',
        '', '', '', '', '',
        userTimeZone, 'BY_DAY'
    );
    getNewUsersCampaign(t_dateS, t_dateE, t_campaign, 'T');
    getNewUsersCampaign(t_dateS, t_dateE, t_campaign, 'U');
    getCampaignDetail(t_dateS, t_dateE, t_campaign, t_country, t_state, t_city, t_zipcode, t_spot);
}