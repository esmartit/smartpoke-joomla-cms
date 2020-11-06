$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    const seConnectedDate = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/smartpoke/today-connected-count?timezone="+userTimeZone);
    let connectedDate = 0;

    seConnectedDate.onmessage = function (event) {
        connectedDate = JSON.parse(event.data).count;
        document.getElementById("connecteddate").innerHTML = Intl.NumberFormat().format(connectedDate);
    }
});


