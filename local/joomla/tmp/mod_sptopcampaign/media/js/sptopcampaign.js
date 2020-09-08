let timeStart = '00:00:00';
let timeEnd = '23:59:59';
let seUniqueTopIN = '';
let devUniqueTopIN = [];
let bigDataTopIN = [];
let userTimeZone = '';
let uniqueTopIN = 0;
let campaign = [];
let id = '';
let name = '';
let sent = '';
let valid = '';
let total = '';
let percent = 0;

$(document).ready( function() {
    userTimeZone = document.getElementById('userTimeZone').innerText;
    getTopCampaignList();
});

function topCampaign() {
    document.getElementById("campaign_0").innerHTML = campaign[0]['name']+' ('+Intl.NumberFormat().format(campaign[0]['value'])+'%)';
    document.getElementById("value_0").setAttribute("data-transitiongoal", Intl.NumberFormat().format(campaign[0]['value']));
    document.getElementById("value_0").style.width = Intl.NumberFormat().format(campaign[0]['value'])+'%';
    document.getElementById("campaign_1").innerHTML = campaign[1]['name']+' ('+Intl.NumberFormat().format(campaign[1]['value'])+'%)';
    document.getElementById("value_1").setAttribute("data-transitiongoal", Intl.NumberFormat().format(campaign[1]['value']));
    document.getElementById("value_1").style.width = Intl.NumberFormat().format(campaign[1]['value'])+'%';
    document.getElementById("campaign_2").innerHTML = campaign[2]['name']+' ('+Intl.NumberFormat().format(campaign[2]['value'])+'%)';
    document.getElementById("value_2").setAttribute("data-transitiongoal", Intl.NumberFormat().format(campaign[2]['value']));
    document.getElementById("value_2").style.width = Intl.NumberFormat().format(campaign[2]['value'])+'%';
    document.getElementById("campaign_3").innerHTML = campaign[3]['name']+' ('+Intl.NumberFormat().format(campaign[3]['value'])+'%)';
    document.getElementById("value_3").setAttribute("data-transitiongoal", Intl.NumberFormat().format(campaign[3]['value']));
    document.getElementById("value_3").style.width = Intl.NumberFormat().format(campaign[3]['value'])+'%';
}

function getPresenceUsersCampaign(campaign, user){
    let request = {
        option       : 'com_ajax',
        module       : 'spselectcampaigneffectiveness',  // to target: mod_spselectcampaigneffectiveness
        method       : 'getPresenceUsers',  // to target: function getPresenceUsersAjax in class ModSPSelectCampaignEffectivenessHelper
        format       : 'json',
        data         : { "campaignId":campaign, "username": user }
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data;
            $("#itotalIn").val(object);
        });
}

function getTopCampaignList() {
    let request = {
        option       : 'com_ajax',
        module       : 'sptopcampaign',  // to target: mod_sptopcampaign
        method       : 'getTopCampaigns',  // to target: function getTopCampaignsAjax in class ModSPTopCampaignHelper
        format       : 'json'
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let object = response.data;
            let len = object.length;

            for (let i = 0; i<len; i++) {
                id = object[i]['campaign_id'];
                name = object[i]['name'];
                sent = object[i]['sent'];
                valid = object[i]['validdate'];
                total = object[i]['total'];

                percent = (uniqueTopIN / total) * 100;
                campaign.push({"id":id, "name":name, "value":percent});

                evtSourceUniqueTopIN(sent, valid, timeStart, timeEnd,
                    '', '', '', '',
                    '', '', '',
                    '', 'IN', '1',
                    '', '', '', '', '',
                    userTimeZone, 'BY_DAY', id);
            }
            campaign.sort(sortValues('id', 'desc'));
            topCampaign();
        });
}

function evtSourceUniqueTopIN(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, brands, status, presence, ageS, ageE, sex,
                           zipcodes, member, userTZ, group, t_campaign) {
    let len = bigDataTopIN.length;
    for (let i=0; i<len; i++) {
        bigDataTopIN[i] = '';
    }

    seUniqueTopIN = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/reports/find?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zoneId="+zone+
        "%26brands="+brands+"%26status="+status+"%26presence="+presence+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);

    let pos = 0;
    uniqueTopIN = 0;
    seUniqueTopIN.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let axisGroup = '';
        let last = eventData.isLast;
        if (eventData.body != null) {
            let bodyData = eventData.body;
            let userInfo = bodyData.userInfo;

            if (userInfo != null) {
                let group_x = new Date(bodyData.seenTime);
                let position = bodyData.position;
                let username = userInfo.username;

                let month = '' + (group_x.getMonth() + 1);
                let day = '' + group_x.getDate();
                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day =  '0' + day;
                axisGroup = [month, day].join('/') + ' ' + username;
                getPresenceUsersCampaign(t_campaign, username);
                existIN = $("#itotalIn").val();

                if (existIN > 0) {
                    if (position == 'IN') {
                        pos = bigDataTopIN.indexOf(axisGroup);
                        if (pos == -1) {
                            bigDataTopIN.push(axisGroup);
                            uniqueTopIN += 1;
                        }
                    }
                }
            }
        }

        if (last) {
            percent = (uniqueTopIN / total) * 100;
            pos = campaign.map(function(o) { return o.id; }).indexOf(t_campaign);
            campaign[pos]['value'] = percent;
            campaign.sort(sortValues('value', 'desc'));
            topCampaign();
            seUniqueTopIN.close();
            campaign.sort(sortValues('id', 'desc'));
            $("#itotalIn").val(0);
        }
    }
}

function sortValues(key, order = 'asc') {
    return function innerSort(a, b) {
        if (!a.hasOwnProperty(key) || !b.hasOwnProperty(key)) {
            // property doesn't exist on either object
            return 0;
        }

        const varA = (typeof a[key] === 'string')
            ? a[key].toUpperCase() : a[key];
        const varB = (typeof b[key] === 'string')
            ? b[key].toUpperCase() : b[key];

        let comparison = 0;
        if (varA > varB) {
            comparison = 1;
        } else if (varA < varB) {
            comparison = -1;
        }
        return (
            (order === 'desc') ? (comparison * -1) : comparison
        );
    };
}