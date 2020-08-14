let seUniqueBigData = '';
let devUniqueBigData = [];
let bigDataR = [];


$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
});

Date.prototype.getWeek = function() {
    let onejan = new Date(this.getFullYear(),0,1);
    return Math.ceil((((this - onejan) / 86400000) + onejan.getDay()+1)/7);
}

function evtSourceUniqueBigData(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, brands, status, presence, ageS, ageE, sex,
                                zipcodes, member, userTZ, group) {
    let len = bigDataR.length;
    for (let i=0; i<len; i++) {
        bigDataR[i] = '';
        devUniqueBigData[i] = 0;
    }
    switch (group) {
        case "BY_DAY":
            let d1 = new Date(dateS + 'Z12:00:00');
            let d2 = new Date(dateE + 'Z12:00:00');
            let days = Math.round((d2 - d1) / (1000 * 3600 * 24));
            for (let i=0; i<=days; i++) {
                let month = '' + (d1.getMonth() + 1);
                let day = '' + d1.getDate();
                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day =  '0' + day;
                bigDataR[i] = [month, day].join('/');
                devUniqueBigData[i] = 0;
                d1 = new Date(d1.setDate(d1.getDate() + 1));
            }
            break;
        case "BY_WEEK":
            let dw1 = new Date(dateS + 'Z12:00:00');
            let dw2 = new Date(dateE + 'Z12:00:00');
            let weeks = Math.round((dw2 - dw1) / (1000 * 3600 * 24 * 7));
            let week = dw1.getWeek();
            for (let i=0; i<=weeks; i++) {
                bigDataR[i] = week.toString();
                devUniqueBigData[i] = 0;
                if (week < 10) {
                    bigDataR[i] = '0' + week.toString();
                }
                week += 1;
            }
            break;
        case "BY_MONTH":
            let months;
            let date1 = new Date(dateS);
            let date2 = new Date(dateE);
            months = (date2.getFullYear() - date1.getFullYear()) * 12;
            months -= date1.getMonth();
            months += date2.getMonth();
            months <= 0 ? 0 : months;
            for (let i=0; i<=months; i++) {
                devUniqueBigData[i] = 0;
                bigDataR[i] = date1.toLocaleString('default', {month: 'short'});
                date1 = new Date(date1.setMonth(date1.getMonth() + 1));
            }
            break;
        case "BY_YEAR":
            let yearObj1 = new Date(dateS);
            let yearObj2 = new Date(dateE);
            let y1 = yearObj1.getFullYear();
            let y2 = yearObj2.getFullYear();
            devUniqueBigData[0] = 0;
            bigDataR[0] = y2.toString();
            devUniqueBigData[1] = 0;
            bigDataR[1] = y1.toString();
            if (y1 == y2) {
                y1 -= 1;
                bigDataR[1] = y1.toString();
            }
            break;
    }

    seUniqueBigData = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/find?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zoneId="+zone+
        "%26brands="+brands+"%26status="+status+"%26presence="+presence+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);

    let pos = 0;
    let uniqueBigData = 0;
    seUniqueBigData.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let axisGroup = '';
        let group_x = eventData.group;
        let in_x = eventData.inCount;
        let limit_x = eventData.limitCount;
        let out_x = eventData.outCount;
        let last = eventData.isLast;

        switch (group) {
            case "BY_DAY":
                axisGroup = group_x.substr(group_x.length -5,group_x.length);
                break;
            case "BY_WEEK":
                axisGroup = group_x.substr(group_x.length -2,group_x.length);
                break;
            case "BY_MONTH":
                month = new Date(group_x+'/'+'01');
                axisGroup = month.toLocaleString('default', {month: 'short'});
                break;
            case "BY_YEAR":
                axisGroup = group_x;
                break;
        }

        pos = bigDataR.indexOf(axisGroup);
        devUniqueBigData[pos] = in_x + limit_x + out_x;
        uniqueBigData = in_x + limit_x + out_x;

        document.getElementById("devuniquebigdata").innerHTML = Intl.NumberFormat().format(uniqueBigData);
        if (last) {
            for(var i = 0, len = devUniqueBigData.length; i < len; i++) {
                uniqueBigData += devUniqueBigData[i];
                document.getElementById("devuniquebigdata").innerHTML = Intl.NumberFormat().format(uniqueBigData);
            }
            seUniqueBigData.close();
        }
    }
}