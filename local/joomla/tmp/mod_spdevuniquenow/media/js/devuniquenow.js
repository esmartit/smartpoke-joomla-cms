$(document).ready( function() {
    const sourceEvt = new EventSource("index.php?option=com_spserverevent&format=json&resource_path=/sensor-activity/hourly-device-presence-delta");
    let inCount = 0;
    let limitCount = 0;
    let outCount = 0;
    let deviceNow = 0;

    sourceEvt.onmessage = function (event) {
        inCount = JSON.parse(event.data).inCount;
        limitCount = JSON.parse(event.data).limitCount;
        outCount = JSON.parse(event.data).outCount;
        deviceNow = inCount + limitCount + outCount;
        document.getElementById("devuniquenow").innerHTML = Intl.NumberFormat().format(deviceNow);
    }
});
