$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    function showDevRegisteredTotal(value) {
        document.getElementById("devregisteredtotal").innerHTML = Intl.NumberFormat().format(value);;
    }

    function objTimer() {

        ActualDateTime = new Date()
        Actualsecond = ActualDateTime.getSeconds()

        unit = Math.floor((Math.random() * 2) + 1);
        checksec = (Actualsecond / 30);
        if (checksec % 1 == 0) {
            registeredtotal += unit;
            showDevRegisteredTotal(registeredtotal)
        }

    }
    registeredtotal = 0;
    setInterval(objTimer, 1000)
    objTimer()
});