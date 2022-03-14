function formatDate(date) {

    var hoy = new Date(date),
        year = hoy.getFullYear(),
        month = '' + (hoy.getMonth() + 1),
        day = '' + hoy.getDate();

    console.log(date);
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [year, month, day].join('-');
}

$(document).ready( function() {
    //let dateS = $('#datestart').val();
    //let dateE = $('#dateend').val();
    let dateS = formatDate(Date.now());
    let dateE = formatDate(Date.now());
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    let brands = encodeURIComponent("Apple,Huawei,LG,Motorola,Oppo,BQ,Samsung,Sony Ericsson,Xiaomi,ZTE,MAC Dynamic");
    let seUniqueDate = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/v2/today-detected-count?timezone="+userTimeZone+"%26startDate="+dateS+"%26endDate="+dateE+"%26brands="+encodeURIComponent(brands));
    // let seUniqueDate = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/today-detected-count?timezone="+userTimeZone+"%26startDate="+dateS+"%26endDate="+dateE+"%26brands="+encodeURIComponent(brands));
    let uniqueDate = 0;

    seUniqueDate.onmessage = function (event) {
        uniqueDate = JSON.parse(event.data).count;
        document.getElementById("devuniquedate").innerHTML = Intl.NumberFormat().format(uniqueDate);
    }
});
