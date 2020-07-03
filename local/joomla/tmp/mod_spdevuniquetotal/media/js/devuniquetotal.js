$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    const seUniqueTotal = new EventSource("index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/unique-devices-detected-count?timezone="+userTimeZone);
    let uniqueTotal = 0;

    seUniqueTotal.onmessage = function (event) {
        uniqueTotal = JSON.parse(event.data).count;
        document.getElementById("devuniquetotal").innerHTML = Intl.NumberFormat().format(uniqueTotal);
    }
});