$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;

    let seConnectedNow = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/smartpoke/now-connected-count?timezone="+userTimeZone);
    let connectedNow = 0;

    seConnectedNow.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        connectedNow = eventData.count;
        document.getElementById("connectednow").innerHTML = Intl.NumberFormat().format(connectedNow);
    }
});
