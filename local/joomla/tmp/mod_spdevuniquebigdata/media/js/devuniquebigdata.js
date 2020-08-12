let seUniqueBigData = '';

$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
});

function evtSourceUniqueBigData(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, brands, status, presence, ageS, ageE, sex,
                                zipcodes, member, userTZ, group) {
    if (seUniqueBigData.readyState != 2 && seUniqueBigData != "") {
        seUniqueBigData.close();
    }
    seUniqueBigData = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/find?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zoneId="+zone+
        "%26brands="+brands+"%26status="+status+"%26presence="+presence+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);

    let group_a = '';
    let uniqueBigData = 0;
    seUniqueBigData.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let group_x = eventData.group;
        let in_x = eventData.inCount;
        let limit_x = eventData.limitCount;
        let out_x = eventData.outCount;
        let totalDevice = in_x + limit_x + out_x;
        let last = eventData.isLast;

        if (!last) {
            if (group_x != group_a) {
                group_a = group_x;
                uniqueBigData += totalDevice;
            }
            document.getElementById("devuniquebigdata").innerHTML = Intl.NumberFormat().format(uniqueBigData);
        } else {
            seUniqueBigData.close();
        }
        // console.log(dataHours, device_x, in_x, limit_x, out_x);

    }
}