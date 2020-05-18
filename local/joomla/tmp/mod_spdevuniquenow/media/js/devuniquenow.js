$(document).ready( function() {
    const sourceEvt = new EventSource("index.php?option=com_spserverevent&format=json&resource_path=/sensor-activity/hourly-device-presence-count");
    let inCount = 0;
    let limitCount = 0;
    let outCount = 0;
    let devicenow = 0;
    let deviceant = 0;

    sourceEvt.onmessage = function (event) {
        inCount = JSON.parse(event.data).inCount;
        limitCount = JSON.parse(event.data).limitCount;
        outCount = JSON.parse(event.data).outCount;
        devicenow = inCount + limitCount + outCount;

        if (devicenow !== deviceant) {
            devicetotal = Math.abs(devicenow - deviceant);
            deviceant = devicenow;
        } else {
            devicetotal = devicenow;
        }
        document.getElementById("devuniquenow").innerHTML = Intl.NumberFormat().format(Math.abs(devicetotal));
        // console.log(devicenow, deviceant);
    }
});
