$(document).ready( function() {

    if (typeof ($.fn.ionRangeSlider) === 'undefined') { return; }
    console.log('init_IonRangeSlider');

    $("#range_age").ionRangeSlider({
        type: "double",
        min: 0,
        max: 100,
        from: 18,
        to: 85,
        grid: true,
        grid_num: 10,
        grid_snap: false,
        onChange: function(data) {
            $('#from_value').val(data.from);
            $('#to_value').val(data.to);
        }
    });

    document.getElementById("timestart").value = '00:00:00';
    getSpotCity();

    function showTimeEnd(time) {
        document.getElementById("timeend").value = time;
    }

    function objTimer() {

        ActualDateTime = new Date()
        Actualhour = ActualDateTime.getHours()
        Actualminute = ActualDateTime.getMinutes()
        Actualsecond = ActualDateTime.getSeconds()

        var strTime = "";
        h = '0' + Actualhour;
        m = '0' + Actualminute;
        s = '0' + Actualsecond;
        strTime += h.substring(h.length - 2, h.length) + ':' + m.substring(m.length - 2, m.length) + ':'+ s.substring(s.length - 2, s.length);

        var checksec = (Actualsecond / 30)
        if (checksec % 1 == 0) {
            showTimeEnd(strTime);
            console.log(strTime);
        }
    }

    setInterval(objTimer, 1000);
    objTimer();
});

function getSpotCity() {
    let cityid = $('#cityId').val();
    let request = {
        option       : 'com_ajax',
        module       : 'spselectonline',  // to target: mod_spselectonline
        method       : 'getSpots',  // to target: function getSpotsAjax in class ModSPSelectOnlineHelper
        format       : 'json',
        data         : cityid
    };
    $.ajax({
        method: 'GET',
        data: request
    })
    .success(function(response){
        console.log('response: '+response.data);
        let object = response.data;
        let len = object.length;

        $("#selSpot").empty();
        $("#selSpot").append("<option value=''>All Spots</option>");
        for (let i = 0; i<len; i++) {
            let id = object[i][0];
            let name = object[i][1];

            $("#selSpot").append("<option value='"+id+"'>"+name+"</option>");
        }
    });
}

function getSensorSpot() {
    let spotid = $('#selSpot').val();
    let request = {
        option       : 'com_ajax',
        module       : 'spselectonline',  // to target: mod_spselectonline
        method       : 'getSensors',  // to target: function getSensorsAjax in class ModSPSelectOnlineHelper
        format       : 'json',
        data         : spotid
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            console.log('response: '+response.data);
            let object = response.data;
            let len = object.length;

            $("#selSensor").empty();
            $("#selSensor").append("<option value=''>All Sensors</option>");
            for (let i = 0; i<len; i++) {
                let id = object[i][0];
                let name = object[i][1];

                $("#selSensor").append("<option value='"+id+"'>"+name+"</option>");
            }
        });
}
