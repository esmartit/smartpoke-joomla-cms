$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    const sourceEvt = new EventSource("index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/now-registered-count?timezone="+userTimeZone);
    let registerednow = 0;

    sourceEvt.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        registerednow = eventData.count;
        document.getElementById("devregisterednow").innerHTML = Intl.NumberFormat().format(registerednow);
    }
});

