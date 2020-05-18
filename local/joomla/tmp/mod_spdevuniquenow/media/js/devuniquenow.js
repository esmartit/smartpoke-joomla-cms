$(document).ready( function() {
    const sourceEvt = new EventSource("index.php?option=com_spserverevent&format=json&resource_path=/sensor-activity/daily-unique-devices-detected-count");
    const today = new Date();
    let uniquedate = 0;
    let currentMax = 0;

    sourceEvt.onmessage = function (event) {
        uniquedate = JSON.parse(event.data).count;

        if (uniquedate > currentMax) {
            document.getElementById("devuniquedate").innerHTML = Intl.NumberFormat().format(uniquedate);
            currentMax = uniquedate
        }
        // console.log(uniquedate, currentMax);
    }
});
