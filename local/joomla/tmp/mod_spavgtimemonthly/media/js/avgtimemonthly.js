let seAvgTimeMonthly = '';
let avgtimeMonthly = 0;

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');
}

var date = new Date();
var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);

$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    let brands = encodeURIComponent("Apple,Huawei,LG,Motorola,Oppo,BQ,Samsung,Sony Ericsson,Xiaomi,ZTE,MAC Dynamic");

    seAvgTimeMonthly = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/v2/average-presence?"+
        "timezone="+userTimeZone+"%26startDate="+formatDate(firstDay)+"%26endDate="+formatDate(lastDay)+"%26startTime=00:00:00%26endTime=23:59:59"+
        "%26countryId=%26stateId=%26cityId=%26zipcodeId="+
        "%26spotId=%26sensorId=%26zone=%26includedDevices=%26excludedDevices="+
        "%26brands="+encodeURIComponent(brands)+"%26status=IN%26ageStart=%26ageEnd=%26gender=%26zipCode=%26memberShip=");

    seAvgTimeMonthly.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        avgtimeMonthly = eventData.value;
        avgtimeMonthly = parseInt(avgtimeMonthly);
        let last = eventData.isLast;

        if (avgtimeMonthly > 0) {
            gettime2str(avgtimeMonthly);
        }
        // if (last) {
        //     avgtimeMonthly.close();
        // }
    }
});

function gettime2str(val) {
    let request = {
        option       : 'com_ajax',
        module       : 'spavgtimemonthly',  // to target: mod_spavgtimemonthly
        method       : 'time2str',  // to target: function time2strAjax in class ModSPAvgTimeMonthlyHelper
        format       : 'json',
        data         : val
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            // let object = response.data;
            document.getElementById("avgtimemonthly").innerHTML = response.data;
        });
}
