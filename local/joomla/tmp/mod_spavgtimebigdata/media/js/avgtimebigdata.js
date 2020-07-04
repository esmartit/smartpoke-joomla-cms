$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    // const seAvgTimeBigData = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/unique-devices-detected-count");
    // let avgtimeBigData = 0;

    // seAvgTimeBigData.onmessage = function (event) {
    //     avgtimeBigData = JSON.parse(event.data).count;
    //     document.getElementById("avgtimebigdata").innerHTML = Intl.NumberFormat().format(avgtimeBigData);
    // }
    let avgTime = 86400;
    gettime2str(avgTime);

});

function gettime2str(val) {
    let request = {
        option       : 'com_ajax',
        module       : 'spavgtimebigdata',  // to target: mod_spavgtimebigdata
        method       : 'time2str',  // to target: function time2strAjax in class ModSPAvgTimeBigDataHelper
        format       : 'json',
        data         : val
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data;
            document.getElementById("avgtimebigdata").innerHTML = object;
        });
}