let inNow = [];
let limitNow = [];
let outNow = [];

$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    let brands = encodeURIComponent("Apple,Huawei,LG,Motorola,Oppo,BQ,Samsung,Sony Ericsson,Xiaomi,ZTE,MAC Dynamic");
    // let seUniqueNow = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/v2/now-detected-count?timezone="+userTimeZone+"%26brands="+encodeURIComponent(brands));
    seUniqueNow = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/v2/now-detected?timezone="+userTimeZone+"%26brands="+encodeURIComponent(brands));
    let deviceNow = 0;

    // seUniqueNow.onmessage = function (event) {
    //     let eventData = JSON.parse(event.data);
    //     deviceNow = eventData.count;
    //     document.getElementById("devuniquenow").innerHTML = Intl.NumberFormat().format(deviceNow);
    // }


    seUniqueNow.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let len = eventData.length;
        let dataNow = len - 5;
        deviceNow = 0;

        for (let i=0; i < len; i++) {
            if (i > dataNow) {
                inNow[i] = eventData[i]['inCount'];
                limitNow[i] = eventData[i]['limitCount'];
                outNow[i] = eventData[i]['outCount'];
                deviceNow = deviceNow + (inNow[i] + limitNow[i] + outNow[i]);
            }
        }

        document.getElementById("devuniquenow").innerHTML = Intl.NumberFormat().format(deviceNow);
    }

});
