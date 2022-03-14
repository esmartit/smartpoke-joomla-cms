let seConnectedDate = '';
let connectedDate = 0;

function evtSourceConnectedDate(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, hotspot, ageS, ageE, sex,
                                zipcodes, member, userTZ, group, connected) {

    if (seConnectedDate.readyState == 1 ) {
        seConnectedDate.close();
    }

    // seConnectedDate = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/smartpoke/today-connected-count?"+
    //     "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
    //     "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
    //     "%26spotId="+spot+"%26ssid="+encodeURIComponent(hotspot)+"%26isConnected="+connected+
    //     "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);

    seConnectedDate = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/smartpoke/v2/today-connected-count?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26ssid="+encodeURIComponent(hotspot)+"%26isConnected="+connected+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);

    seConnectedDate.onmessage = function (event) {
        connectedDate = JSON.parse(event.data).count;
        document.getElementById("connecteddate").innerHTML = Intl.NumberFormat().format(connectedDate);
    }
}
