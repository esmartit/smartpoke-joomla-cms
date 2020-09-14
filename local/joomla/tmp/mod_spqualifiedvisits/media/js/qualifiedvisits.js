let seQualifiedVisits = '';
let visitTotal = 0;
let visitIn = 0;
let visitLimit = 0;
let visitOut = 0;
let visitHour = 0;
let visitHourNew = (new Date()).getHours();
let inDataAnt = 0;
let limitDataAnt = 0;
let outDataAnt = 0;


$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    seQualifiedVisits = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/today-detected?timezone="+userTimeZone);
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
            inDataAnt = inData;
            limitDataAnt = limitData;
            outDataAnt = outData;
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
    }});

function evtSourceQualifiedVisits(dateS, dateE, country, state, city, zipcode, spot, sensor, zone, inDevices, exDevices, brands, status, ageS, ageE, sex,
                                  zipcodes, member, userTZ) {
    if (seQualifiedVisits.readyState != 2) {
        seQualifiedVisits.close();
    }
    seQualifiedVisits = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/today-detected?"+
        "timezone="+userTZ+"%26startTime="+dateS+"%26endTime="+dateE+"%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zoneId="+zone+"%26includedDevices="+inDevices+"%26excludedDevices="+exDevices+
        "%26brands="+brands+"%26status="+status+"%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member);

    visitTotal = 0;
    visitIn = 0;
    visitLimit = 0;
    visitOut = 0;
    visitHour = 0;
    visitHourNew = (new Date()).getHours();
    inDataAnt = 0;
    limitDataAnt = 0;
    outDataAnt = 0;

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
            inDataAnt = inData;
            limitDataAnt = limitData;
            outDataAnt = outData;
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
}
