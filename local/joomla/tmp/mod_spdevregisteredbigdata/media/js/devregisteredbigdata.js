let seRegisteredBigData = '';
$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    seRegisteredBigData = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/total-registered-count?timezone="+userTimeZone);
    let registeredbigdata = 0;

    seRegisteredBigData.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        registeredbigdata = eventData.count;
        document.getElementById("devregisteredbigdata").innerHTML = Intl.NumberFormat().format(registeredbigdata);
    }
});

function countRegisteredBigData(dateS, dateE, country, state, city, zipcode, spot, ageS, ageE, sex, zipcodes, member) {
    if (seRegisteredBigData.readyState != 2) {
        seRegisteredBigData.close();
    }

    let request = {
        option       : 'com_ajax',
        module       : 'spdevregisteredbigdata',  // to target: mod_spdevregisteredbigdata
        method       : 'getUsersRegistered',  // to target: function getUsersRegisteredAjax in class ModSPDevRegisteredBigDataHelper
        format       : 'json',
        data         : { "dateStart": dateS, "dateEnd": dateE,
            "countryId": country, "stateId": state, "cityId": city, "zipcodeId": zipcode,
            "spotId": spot,
            "ageStart": ageS, "ageEnd": ageE, "gender": sex, "zipCode": zipcodes, "memberShip": member
        }
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let data = response.data;
            document.getElementById("devregisteredbigdata").innerHTML = Intl.NumberFormat().format(data);
        });
}