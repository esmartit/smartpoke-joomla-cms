let seUniqueBigData = '';

$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    seUniqueBigData = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/unique-devices-detected-count?timezone="+userTimeZone);
    let uniqueBigData = 0;

    seUniqueBigData.onmessage = function (event) {
        uniqueBigData = JSON.parse(event.data).count;
        document.getElementById("devuniquebigdata").innerHTML = Intl.NumberFormat().format(uniqueBigData);
    }
});

function evtSourceUniqueBigData(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, brands, status, presence, ageS, ageE, sex,
                                  zipcodes, member, userTZ, group) {
    if (seUniqueBigData.readyState != 2) {
        seUniqueBigData.close();
    }
    seUniqueBigData = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/find?"+
        "timezone="+userTZ+"startDate="+dateS+"endDate="+dateE+"&startTime="+timeS+"&endTime="+timeE+
        "&countryId="+country+"&stateId="+state+"&cityId="+city+"&zipcodeId="+zipcode+
        "&spotId="+spot+"&sensorId="+sensor+"&zoneId="+zone+
        "&brands="+brands+"&status="+status+"presence="+presence+
        "&ageStart="+ageS+"&ageEnd="+ageE+"&gender="+sex+"&zipCode="+zipcodes+"&memberShip="+member);

    seUniqueBigData.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let uniqueBigData = 0;

        document.getElementById("devuniquebigdata").innerHTML = Intl.NumberFormat().format(uniqueBigData);

        // console.log(dataHours, device_x, in_x, limit_x, out_x);
    }
}