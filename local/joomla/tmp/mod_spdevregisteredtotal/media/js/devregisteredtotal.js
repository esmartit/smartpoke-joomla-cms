$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    const seRegisteredTotal = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/total-registered-count?timezone="+userTimeZone);
    let registeredtotal = 0;

    seRegisteredTotal.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        registeredtotal = eventData.count;
        document.getElementById("devregisteredtotal").innerHTML = Intl.NumberFormat().format(registeredtotal);
    }
});
