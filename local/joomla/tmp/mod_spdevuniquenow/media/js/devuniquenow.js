$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    let inAct = 0;
    let limitAct = 0;
    let outAct = 0;

    // let seUniqueNow = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/now-detected-count?timezone="+userTimeZone);
    let seUniqueNow = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/now-detected?timezone="+userTimeZone);
    let deviceNow = 0;

    seUniqueNow.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        inAct = eventData.inCount;
        limitAct = eventData.limitCount;
        outAct = eventData.outCount;
        deviceNow = inAct + limitAct + outAct;

        // deviceNow = eventData.count;
        document.getElementById("devuniquenow").innerHTML = Intl.NumberFormat().format(deviceNow);
    }
});
