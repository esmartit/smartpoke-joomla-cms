$(document).ready( function() {
    const sourceEvt = new EventSource("index.php?option=com_spserverevent&format=json&resource_path=/sensor-activity/hourly-device-presence-delta");
    let inCount = 0;
    let limitCount = 0;
    let outCount = 0;
    let deviceNow = 0;

    sourceEvt.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        inCount = eventData.inCount;
        limitCount = eventData.limitCount;
        outCount = eventData.outCount;
        deviceNow = inCount + limitCount + outCount;
        document.getElementById("devuniquenow").innerHTML = Intl.NumberFormat().format(deviceNow);
    }
});
