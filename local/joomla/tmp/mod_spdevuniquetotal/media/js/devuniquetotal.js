$(document).ready( function() {
    const sourceEvt = new EventSource("index.php?option=com_spserverevent&format=json&resource_path=/sensor-activity/unique-devices-detected-count");
    let uniqueTotal = 0;
    let currentMax = 0;

    sourceEvt.onmessage = function (event) {
        uniqueTotal = JSON.parse(event.data).count;

        if (uniqueTotal > currentMax) {
            document.getElementById("devuniquetotal").innerHTML = Intl.NumberFormat().format(uniqueTotal);
            currentMax = uniqueTotal;
        }
        // console.log('Total', uniqueTotal, currentMax);
    }
});