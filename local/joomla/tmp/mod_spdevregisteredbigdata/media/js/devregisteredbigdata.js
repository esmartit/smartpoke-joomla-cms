$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    function showDevRegisteredBigData(value) {
        document.getElementById("devregisteredbigdata").innerHTML = Intl.NumberFormat().format(value);;
    }

    function objTimer() {

        ActualDateTime = new Date()
        Actualsecond = ActualDateTime.getSeconds()

        unit = Math.floor((Math.random() * 2) + 1);
        checksec = (Actualsecond / 30);
        if (checksec % 1 == 0) {
            registeredBigData += unit;
            showDevRegisteredBigData(registeredBigData)
        }

    }
    registeredBigData = 0;
    setInterval(objTimer, 1000)
    objTimer()
});