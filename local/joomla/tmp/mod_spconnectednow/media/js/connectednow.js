let seConnectedNow = '';
let connectedNow = 0;

function evtSourceConnectedNow(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, hotspot, ageS, ageE, sex,
                                zipcodes, member, userTZ, group, connected) {

    if (seConnectedNow.readyState == 1 ) {
        seConnectedNow.close();
    }

    // seConnectedNow = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/smartpoke/now-connected-count?"+
    //     "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
    //     "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
    //     "%26spotId="+spot+"%26ssid="+encodeURIComponent(hotspot)+"%26isConnected="+connected+
    //     "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);

    seConnectedNow = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/smartpoke/v2/today-connected?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26ssid="+encodeURIComponent(hotspot)+"%26isConnected="+connected+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);

    seConnectedNow.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let in_x = eventData.inCount;
        let limit_x = eventData.limitCount;
        let out_x = eventData.outCount;
        connectedNow = in_x + limit_x + out_x;
        document.getElementById("connectednow").innerHTML = Intl.NumberFormat().format(connectedNow);
    }
}
