$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    // const seTrafficHotSpot = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/daily-unique-devices-detected-count?timezone="+userTimeZone);
    let totalTraffic = 1048576;
    let upTraffic = 314572.8;
    let downTraffic = 734003.2;

    gettoxByte(totalTraffic, 1);
    gettoxByte(upTraffic, 2);
    gettoxByte(downTraffic, 3);

    // seTrafficHotSpot.onmessage = function (event) {
    //     totalTraffic = JSON.parse(event.data).count;
    //     upTraffic = JSON.parse(event.data).count;
    //     downTraffic = JSON.parse(event.data).count;
    //     document.getElementById("totalTraffic").innerHTML = totalTraffic;
    //     document.getElementById("upTraffic").innerHTML = upTraffic;
    //     document.getElementById("downTraffic").innerHTML = downTraffic;
    // }
});

function gettoxByte(val, field) {
    let request = {
        option       : 'com_ajax',
        module       : 'sptraffichotspot',  // to target: mod_sptraffichotspot
        method       : 'toxByte',  // to target: function toxByteAjax in class ModSPTrafficHotSpotHelper
        format       : 'json',
        data         : val
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data;
            switch (field) {
                case 1: {
                    document.getElementById("totalTraffic").innerHTML = object;
                    break;
                }
                case 2: {
                    document.getElementById("upTraffic").innerHTML = object;
                    break;
                }
                case 3: {
                    document.getElementById("downTraffic").innerHTML = object;
                    break;
                }
            }
        });
}
