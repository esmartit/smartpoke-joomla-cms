$(document).ready( function() {
    const sourceEvt = new EventSource("index.php?option=com_spserverevent&format=json&resource_path=/sensor-activity/minute-device-total-count");
    let deviceNow = 0;

    sourceEvt.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        deviceNow = eventData.count;
        document.getElementById("devuniquenow").innerHTML = Intl.NumberFormat().format(deviceNow);
    }
});
