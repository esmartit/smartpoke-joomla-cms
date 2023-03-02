let seTrafficHotSpot = '';
let totalTraffic = 0;
let upTraffic = 0;
let downTraffic = 0;

$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;

    gettoxByte(totalTraffic, 1);
    gettoxByte(upTraffic, 2);
    gettoxByte(downTraffic, 3);
});

function evtSourceTrafficHotSpot(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, hotspot, ageS, ageE, sex,
                                 zipcodes, member, userTZ, group, connected) {

    seTrafficHotSpot = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/smartpoke/total-traffic?"+
        "startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26ssid="+hotspot+"%26isConnected="+connected+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);

    totalTraffic = 0;
    upTraffic = 0;
    downTraffic = 0;

    NProgress.start();
    NProgress.set(0,4);
    seTrafficHotSpot.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let len = eventData.length;
        for (let x=0; x<len; x++) {
            let last = eventData[x].isLast;
            if (!last) {
                let bodyData = eventData[x].body;
                upTraffic = bodyData.TotalInputOcts;
                downTraffic = bodyData.TotalOutputOcts;
                totalTraffic = upTraffic + downTraffic;

                gettoxByte(totalTraffic, 1);
                gettoxByte(upTraffic, 2);
                gettoxByte(downTraffic, 3);
            } else {
                seTrafficHotSpot.close();
                NProgress.done();
            }
        }
    }
}


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
