let seVisitsQualified = '';
let visitQualified = 0;
let axisVisitQ = [];
let inVisitQ = [];
let limitVisitQ = [];
let outVisitQ = [];
let deviceVisitQ = [];
let visitTotalQ = 0;

let seUniqueDevices = '';
let uniqueDevices = 1;

let visitFrequency  = 0;
let rateVF = 0;

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

let d1 = new Date(firstDay);
let d2 = new Date(lastDay);
let days = Math.round((d2 - d1) / (1000 * 3600 * 24));
for (let i=0; i<=days; i++) {
    let month = '' + (d1.getMonth() + 1);
    let day = '' + d1.getDate();
    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day =  '0' + day;
    axisVisitQ[i] = [month, day].join('-');
    inVisitQ[i] = 0;
    limitVisitQ[i] = 0;
    outVisitQ[i] = 0;
    deviceVisitQ[i] = 0;
    d1 = new Date(d1.setDate(d1.getDate() + 1));
}

$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    let brands = encodeURIComponent("Apple,Huawei,LG,Motorola,Oppo,BQ,Samsung,Sony Ericsson,Xiaomi,ZTE,MAC Dynamic");

    seVisitsQualified = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/v2/find-bigdata?"+
    "timezone="+userTimeZone+"%26startDate="+formatDate(firstDay)+"%26endDate="+formatDate(lastDay)+"%26startTime=00:00:00%26endTime=23:59:59"+
    "%26countryId=%26stateId=%26cityId=%26zipcodeId="+
    "%26spotId=%26sensorId=%26zone=%26includedDevices=%26excludedDevices="+
    "%26brands="+encodeURIComponent(brands)+"%26status=IN%26presence=%26ageStart=%26ageEnd=%26gender=%26zipCode=%26memberShip=%26groupBy=BY_DAY");

    seVisitsQualified.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let axisGroup = '';
        let group_x = eventData.group;
        let in_x = eventData.inCount;
        let limit_x = eventData.limitCount;
        let out_x = eventData.outCount;
        let isLast = eventData.isLast;

        if (!isLast) {
            axisGroup = group_x.substr(group_x.length -5,group_x.length);
            pos = axisVisitQ.indexOf(axisGroup);

            inVisitQ[pos] = in_x;
            limitVisitQ[pos] = limit_x;
            outVisitQ[pos] = out_x;
            deviceVisitQ[pos] = in_x + limit_x + out_x;

        } else {
            seVisitsQualified.close();

            let total_r = 0;
            let in_r = 0;
            let limit_r = 0;
            let out_r = 0;
            for (let i = 0, len = deviceVisitQ.length; i < len; i++) {
                total_r += deviceVisitQ[i];
                in_r += inVisitQ[i];
                limit_r += limitVisitQ[i];
                out_r += outVisitQ[i];
                visitTotalQ = in_r;
            }
            document.getElementById("visitqualified").innerHTML = Intl.NumberFormat().format(visitTotalQ);
        }
    }

    seUniqueDevices = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/v2/count-unique-devices?"+
    "timezone="+userTimeZone+"%26startDate="+formatDate(firstDay)+"%26endDate="+formatDate(lastDay)+"%26startTime=00:00:00%26endTime=23:59:59"+
    "%26countryId=%26stateId=%26cityId=%26zipcodeId="+
    "%26spotId=%26sensorId=%26zone=%26includedDevices=%26excludedDevices="+
    "%26brands="+encodeURIComponent(brands)+"%26status=IN%26presence=%26ageStart=%26ageEnd=%26gender=%26zipCode=%26memberShip=");

    seUniqueDevices.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        uniqueDevices = eventData.count;
        let last = eventData.isLast;

        if (!last) {
            if (uniqueDevices > 0) {
				rateVF = (parseInt(visitTotalQ)/parseInt(uniqueDevices));
                rateVF = Math.round(rateVF * 100) / 100;
                document.getElementById("uniquedevices").innerHTML = Intl.NumberFormat().format(uniqueDevices);
                document.getElementById("visitfrequency").innerHTML = Intl.NumberFormat().format(rateVF);
            }
        }

    }

});
