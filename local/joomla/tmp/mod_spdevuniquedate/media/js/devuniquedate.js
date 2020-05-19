$(document).ready( function() {
    const sourceEvt = new EventSource("index.php?option=com_spserverevent&format=json&resource_path=/sensor-activity/daily-unique-devices-detected-count");
    let uniqueDate = 0;
    let currentMax = 0;
    let currentDate = new Date();

    sourceEvt.onmessage = function (event) {
        uniqueDate = JSON.parse(event.data).count;
        let today = new Date(JSON.parse(event.data).time);
        let sameDate = (currentDate.getDate() === today.getUTCDate());

        if (sameDate) {
            if (uniqueDate > currentMax) {
                document.getElementById("devuniquedate").innerHTML = Intl.NumberFormat().format(uniqueDate);
                currentMax = uniqueDate;
            }
        }
        // console.log(currentDate.getDate(), today.getDate(), uniqueDate, currentMax);
    }
});
