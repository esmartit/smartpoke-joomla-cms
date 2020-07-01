$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    const sourceEvt = new EventSource("index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/daily-registered-count?timezone="+userTimeZone);
    let registereddate = 0;

    sourceEvt.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        registereddate = eventData.count;
        document.getElementById("devregistereddate").innerHTML = Intl.NumberFormat().format(registereddate);
    }
});


