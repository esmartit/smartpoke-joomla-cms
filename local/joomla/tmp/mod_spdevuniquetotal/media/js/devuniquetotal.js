$(document).ready( function() {
    const sourceEvt = new EventSource("index.php?option=com_spserverevent&format=json&resource_path=/sensor-activity/unique-devices-detected-count");
    let uniquetotal = 0;
    let currentMax = 0;

    sourceEvt.onmessage = function (event) {
        uniquetotal = JSON.parse(event.data).count;

        if (uniquetotal > currentMax) {
            document.getElementById("devuniquetotal").innerHTML = Intl.NumberFormat().format(uniquetotal);
            currentMax = uniquetotal;
        }
        // console.log(uniquetotal, currentMax);
    }
});