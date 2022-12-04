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
let flag = 0;
let rateIn = 0;
let rateLimit = 0;
let rateOut = 0;

function formatDate(date) {

    var hoy = new Date(date),
        year = hoy.getFullYear(),
        month = '' + (hoy.getMonth() + 1),
        day = '' + hoy.getDate();

    console.log(date);
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [year, month, day].join('-');
}

$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    let brands = "Apple%2CBQ%2CHuawei%2CLG%2CMotorola%2COppo%2CSamsung%2CSony%20Ericsson%2CXiaomi%2CZTE,MAC%20Dynamic";
    //let dateS = $('#datestart').val();
    //let dateE = $('#dateend').val();
    let dateS = formatDate(Date.now());
    let dateE = formatDate(Date.now());

    if (flag == 0) {

        // seQualifiedVisits = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/today-detected?timezone="+userTimeZone+"&brands="+brands);
        seQualifiedVisits = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/v2/find-bigdata?"+
            "timezone="+userTimeZone+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime=00:00:00%26endTime=23:59:59"+
            "%26countryId=%26stateId=%26cityId=%26zipcodeId="+
            "%26spotId=%26sensorId=%26zone=%26includedDevices=%26excludedDevices="+
            "%26brands="+encodeURIComponent(brands)+"%26status=%26ageStart=%26ageEnd=%26gender=%26zipCode=%26memberShip=%26groupBy=BY_DAY");

        seQualifiedVisits.onmessage = function (event) {
            let eventData = JSON.parse(event.data);
            visitHour = (new Date(eventData.time)).getHours();
            let inData = eventData.inCount;
            let limitData = eventData.limitCount;
            let outData = eventData.outCount;
            let isLast = eventData.isLast;

            if (!isLast) {
                visitTotal = inData + limitData + outData;
                document.getElementById("totalVisits").innerHTML = Intl.NumberFormat().format(visitTotal);
                document.getElementById("inVisits").innerHTML = Intl.NumberFormat().format(inData);
                document.getElementById("limitVisits").innerHTML = Intl.NumberFormat().format(limitData);
                document.getElementById("outVisits").innerHTML = Intl.NumberFormat().format(outData);

                rateIn = (parseInt(inData)/parseInt(visitTotal))*100;
                rateIn = Math.round(rateIn * 1) / 1;
                rateLimit = (parseInt(limitData)/parseInt(visitTotal))*100;
                rateLimit = Math.round(rateLimit * 1) / 1;
                rateOut = (parseInt(outData)/parseInt(visitTotal))*100;
                rateOut = Math.round(rateOut * 1) / 1;
                document.getElementById("rateIn").innerHTML = Intl.NumberFormat().format(rateIn) + '%';
                document.getElementById("rateLimit").innerHTML = Intl.NumberFormat().format(rateLimit) + '%';
                document.getElementById("rateOut").innerHTML = Intl.NumberFormat().format(rateOut) + '%';
            }
        }
    }
});

function evtSourceQualifiedVisits(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, inDevices, exDevices, brands, status, ageS, ageE, sex,
                                  zipcodes, member, userTZ) {
    if (seQualifiedVisits.readyState == 1 ) {
        seQualifiedVisits.close();
    }
    document.getElementById("title").innerHTML = "Qualified Visits";

    // seQualifiedVisits = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/today-detected?"+
    //     "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
    //     "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
    //     "%26spotId="+spot+"%26sensorId="+sensor+"%26zone="+zone+"%26includedDevices="+inDevices+"%26excludedDevices="+exDevices+
    //     "%26brands="+encodeURIComponent(brands)+"%26status="+status+"%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member);

    seQualifiedVisits = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/v2/today-detected?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zone="+zone+"%26includedDevices="+inDevices+"%26excludedDevices="+exDevices+
        "%26brands="+encodeURIComponent(brands)+"%26status="+status+"%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member);

    visitTotal = 0;
    visitIn = 0;
    visitLimit = 0;
    visitOut = 0;
    visitHour = 0;
    visitHourNew = (new Date()).getHours();
    inDataAnt = 0;
    limitDataAnt = 0;
    outDataAnt = 0;

    NProgress.start();
    NProgress.set(0,4);
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

        rateIn = (parseInt(visitIn)/parseInt(visitTotal))*100;
        rateIn = Math.round(rateIn * 1) / 1;
        rateLimit = (parseInt(visitLimit)/parseInt(visitTotal))*100;
        rateLimit = Math.round(rateLimit * 1) / 1;
        rateOut = (parseInt(visitOut)/parseInt(visitTotal))*100;
        rateOut = Math.round(rateOut * 1) / 1;
        document.getElementById("rateIn").innerHTML = Intl.NumberFormat().format(rateIn) + '%';
        document.getElementById("rateLimit").innerHTML = Intl.NumberFormat().format(rateLimit) + '%';
        document.getElementById("rateOut").innerHTML = Intl.NumberFormat().format(rateOut) + '%';
    }
    flag = 1;
    NProgress.done();
}
