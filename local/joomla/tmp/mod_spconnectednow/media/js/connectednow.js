$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;

    function showConnectedNow(value) {
        document.getElementById("connectednow").innerHTML = Intl.NumberFormat().format(value);;
    }

    function objTimer() {

        ActualDateTime = new Date()
        Actualsecond = ActualDateTime.getSeconds()

        unit = Math.floor((Math.random() * 2) + 1);
        checksec = (Actualsecond / 30);
        if (checksec % 1 == 0) {
            connectednow = unit;
            showConnectedNow(connectednow)
        }

    }
    connectednow = 0;
    setInterval(objTimer, 1000)
    objTimer()
});
