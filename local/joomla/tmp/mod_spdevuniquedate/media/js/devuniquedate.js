$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    const sourceEvt = new EventSource("index.php?option=com_spserverevent&format=json&resource_path=/sensor-activity/daily-unique-devices-detected-count?timezone="+userTimeZone);
    let uniqueDate = 0;

    sourceEvt.onmessage = function (event) {
        uniqueDate = JSON.parse(event.data).count;
        document.getElementById("devuniquedate").innerHTML = Intl.NumberFormat().format(uniqueDate);
    }
});
