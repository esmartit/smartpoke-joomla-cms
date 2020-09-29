let campaign = [];


$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
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
            campaign = response.data;
            let len = campaign.length;

            if (len == 0) {
                campaign.push({"id":1, "name":"", "value":0});
                campaign.push({"id":2, "name":"", "value":0});
                campaign.push({"id":3, "name":"", "value":0});
                campaign.push({"id":4, "name":"", "value":0});
            }
            topCampaign();
        });
}
