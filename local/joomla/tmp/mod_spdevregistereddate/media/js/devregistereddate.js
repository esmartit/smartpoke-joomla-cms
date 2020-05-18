$(document).ready( function() {
    function showDevRegisteredDate(value) {
        document.getElementById("devregistereddate").innerHTML = Intl.NumberFormat().format(value);;
    }

    function objTimer() {

        ActualDateTime = new Date()
        Actualsecond = ActualDateTime.getSeconds()

        unit = Math.floor((Math.random() * 5) + 1);
        checksec = (Actualsecond / 30);
        if (checksec % 1 == 0) {
            registereddate += unit;
            showDevRegisteredDate(registereddate)
        }

    }
    registereddate = 31;
    setInterval(objTimer, 1000)
    objTimer()
});

