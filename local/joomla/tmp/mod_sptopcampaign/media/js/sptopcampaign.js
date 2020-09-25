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
let existIN = 0;


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

function getPresenceUsersCampaign(idCampaign, user){
    let request = {
        option       : 'com_ajax',
        module       : 'spselectcampaigneffectiveness',  // to target: mod_spselectcampaigneffectiveness
        method       : 'getPresenceUsers',  // to target: function getPresenceUsersAjax in class ModSPSelectCampaignEffectivenessHelper
        format       : 'json',
        data         : { "campaignId":idCampaign, "username": user }
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            existIN = response.data;
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

            if (len > 0) {
                for (let i = 0; i<len; i++) {
                    id = object[i]['campaign_id'];
                    name = object[i]['name'];
                    sent = object[i]['sent'];
                    valid = object[i]['validdate'];
                    total = object[i]['total'];

                    percent = 0;
                    campaign.push({"id":id, "name":name, "total":total, "value":percent});

                    evtSourceUniqueTopIN(sent, valid, timeStart, timeEnd,
                        '', '', '', '',
                        '', '', '',
                        '', 'IN', '1',
                        '', '', '', '', '',
                        userTimeZone, 'BY_DAY', id);
                }
                campaign.sort(sortValues('name', 'asc'));
            } else {
                campaign.push({"id":1, "name":"", "total":0, "value":0});
                campaign.push({"id":2, "name":"", "total":0, "value":0});
                campaign.push({"id":3, "name":"", "total":0, "value":0});
                campaign.push({"id":4, "name":"", "total":0, "value":0});
            }
            topCampaign();
        });
}

function evtSourceUniqueTopIN(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, brands, status, presence, ageS, ageE, sex,
                              zipcodes, member, userTZ, group, t_campaign) {

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
            let username = bodyData.username;
            let status = bodyData.status;
            let group_x = new Date(bodyData.seenTime);

            let month = '' + (group_x.getUTCMonth() + 1);
            let day = '' + group_x.getUTCDate();
            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day =  '0' + day;
            axisGroup = [month, day].join('/') + ' ' + username + ' ' + t_campaign;
            getPresenceUsersCampaign(t_campaign, username);

            if (existIN == 1) {
                if (status == 'IN') {
                    pos = bigDataTopIN.map(function(o) { return o.id; }).indexOf(axisGroup);
                    // pos = bigDataTopIN.indexOf(axisGroup);
                    if (pos == -1) {
                        bigDataTopIN.push({"id":axisGroup, "campaignId":t_campaign, "in":1});
                        pos = campaign.map(function(o) { return o.id; }).indexOf(t_campaign);
                        uniqueTopIN += 1;

                        let value = (uniqueTopIN / campaign[pos]['total']) * 100;
                        let roundValue = Math.round(value * 10) / 10;
                        campaign[pos]['value'] = roundValue;

                        //campaign[pos]['value'] = Math.round10(((uniqueTopIN / campaign[pos]['total']) * 100), -1);
                    }
                }
            }
        } else {
            if (last) {
                // percent = (uniqueTopIN / total) * 100;
                // pos = campaign.map(function(o) { return o.id; }).indexOf(t_campaign);
                // percent = (uniqueTopIN / campaign[pos]['total']) * 100;
                // campaign[pos]['value'] = percent;
                uniqueTopIN = 0;
                existIN = 0;
            }
            seUniqueTopIN.close();
            campaign.sort(sortValues('value', 'desc'));
            topCampaign();
            campaign.sort(sortValues('name', 'asc'));
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