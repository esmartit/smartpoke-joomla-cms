$(document).ready( function() {
    function showDevRegisteredNow(value) {
        document.getElementById("devregisterednow").innerHTML = Intl.NumberFormat().format(value);;
    }

    function objTimer() {

        ActualDateTime = new Date()
        Actualsecond = ActualDateTime.getSeconds()

        unit = Math.floor((Math.random() * 2) + 1);
        checksec = (Actualsecond / 30);
        if (checksec % 1 == 0) {
            registerednow = unit;
            showDevRegisteredNow(registerednow)
        }

    }
    registerednow = 0;
    setInterval(objTimer, 1000)
    objTimer()
});
