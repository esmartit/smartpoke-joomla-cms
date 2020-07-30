$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;

    let seUniqueNow = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/v2/now-detected-count?timezone="+userTimeZone);
    let deviceNow = 0;

    seUniqueNow.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        deviceNow = eventData.count;
        document.getElementById("devuniquenow").innerHTML = Intl.NumberFormat().format(deviceNow);
    }
});
