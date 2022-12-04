$(document).ready( function() {
    let startDate = formatDate(Date())
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    let brands = encodeURIComponent("Apple,Huawei,LG,Motorola,Oppo,BQ,Samsung,Sony Ericsson,Xiaomi,ZTE,MAC Dynamic");
    let seUniqueNew = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/v2/new-devices-today?timezone="+userTimeZone+"%26startDate="+startDate+"%26endDate="+startDate+"%26brands="+encodeURIComponent(brands));
    let deviceNew = 0;

    seUniqueNew.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        deviceNew = eventData.count;
        document.getElementById("devuniquenew").innerHTML = Intl.NumberFormat().format(deviceNew);
    }
});

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');
}
