$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    const seUniqueBigData = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/unique-devices-detected-count");
    let uniqueBigData = 0;

    seUniqueBigData.onmessage = function (event) {
        uniqueBigData = JSON.parse(event.data).count;
        document.getElementById("devuniquebigdata").innerHTML = Intl.NumberFormat().format(uniqueBigData);
    }
});