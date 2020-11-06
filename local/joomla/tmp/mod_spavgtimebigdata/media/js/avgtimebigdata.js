let seAvgTimeBigData = '';
let avgtimeBigData = 0;

$(document).ready( function() {
    // let userTimeZone = document.getElementById('userTimeZone').innerText;
    // seAvgTimeBigData = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/average-presence?timezone="+userTimeZone);
    //
    // seAvgTimeBigData.onmessage = function (event) {
    //     let eventData = JSON.parse(event.data);
    //     avgtimeBigData = eventData.value * 100;
    //     avgtimeBigData = parseInt(avgtimeBigData);
    //     gettime2str(avgtimeBigData);
    // }

});

function gettime2str(val) {
    let request = {
        option       : 'com_ajax',
        module       : 'spavgtimebigdata',  // to target: mod_spavgtimebigdata
        method       : 'time2str',  // to target: function time2strAjax in class ModSPAvgTimeBigDataHelper
        format       : 'json',
        data         : val
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            // let object = response.data;
            document.getElementById("avgtimebigdata").innerHTML = response.data;
        });
}

function evtSourceAvgTimeBigData(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, inDevices, exDevices, brands, status, presence, ageS, ageE, sex,
                                zipcodes, member, userTZ, group) {

    // if (seAvgTimeBigData.readyState != 2) {
    //     seAvgTimeBigData.close();
    // }

    seAvgTimeBigData = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/average-presence?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zoneId="+zone+"%26includedDevices="+inDevices+"%26excludedDevices="+exDevices+
        "%26brands="+brands+"%26status="+status+"%26presence="+presence+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);

    seAvgTimeBigData.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        avgtimeBigData = eventData.value;
        avgtimeBigData = parseInt(avgtimeBigData);
        let last = eventData.isLast;

        if (avgtimeBigData > 0) {
            gettime2str(avgtimeBigData);
        }
        if (last) {
            seAvgTimeBigData.close();
        }
    }
}