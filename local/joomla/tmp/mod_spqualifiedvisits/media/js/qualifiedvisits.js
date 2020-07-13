let seQualifiedVisits = '';

$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    seQualifiedVisits = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/today-detected?timezone="+userTimeZone);

    let visitTotal = 0;
    let visitIn = 0;
    let visitLimit = 0;
    let visitOut = 0;
    let visitHour = 0;
    let visitHourNew = (new Date()).getHours();
    let inDataAnt = 0;
    let limitDataAnt = 0;
    let outDataAnt = 0;

    seQualifiedVisits.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        visitHour = (new Date(eventData.time)).getHours();
        let inData = eventData.inCount;
        let limitData = eventData.limitCount;
        let outData = eventData.outCount;
        if (visitHour != visitHourNew) {
            visitIn += inData;
            visitLimit += limitData;
            visitOut += outData;
            visitHourNew = visitHour
        } else {
            if (inData != inDataAnt || limitData != limitDataAnt || outData != outDataAnt) {
                visitIn = (visitIn + inData) - inDataAnt;
                visitLimit = (visitLimit + limitData) - limitDataAnt;
                visitOut = (visitOut + outData) - outDataAnt;
                inDataAnt = inData;
                limitDataAnt = limitData;
                outDataAnt = outData;
            } else {
                visitIn += 0;
                visitLimit += 0;
                visitOut += 0;
            }
        }
        visitTotal = visitIn + visitLimit + visitOut;
        document.getElementById("totalVisits").innerHTML = Intl.NumberFormat().format(visitTotal);
        document.getElementById("inVisits").innerHTML = Intl.NumberFormat().format(visitIn);
        document.getElementById("limitVisits").innerHTML = Intl.NumberFormat().format(visitLimit);
        document.getElementById("outVisits").innerHTML = Intl.NumberFormat().format(visitOut);
    }
});

function evtSourceQualifiedVisits(dateS, dateE, country, state, city, spot, sensor, brands, status, ageS, ageE, sex,
                                  zipcodes, member, userTZ) {
    if (seQualifiedVisits.readyState != 2) {

        seQualifiedVisits.close();
        seActivityOnline = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/today-detected?"+
            "timezone="+userTZ+"&startTime="+dateS+"&endTime="+dateE+"&countryId="+country+"&stateId="+state+"&cityId="+city+
            "&spotId="+spot+"&sensorId="+sensor+"&brands="+brands+"&status="+status+"&ageStart="+ageS+"&ageEnd="+ageE+"&gender="+sex+
            "&zipCode="+zipcodes+"&memberShip="+member);
    }
}
