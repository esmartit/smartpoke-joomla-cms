$(document).ready( function() {
    let userTimeZone = document.getElementById('userTimeZone').innerText;
    let brands = encodeURIComponent("Apple,Huawei,LG,Motorola,Oppo,Others,Samsung,Sony Ericsson,Xiaomi,ZTE,MAC Dynamic");
    let seUniqueDate = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/today-detected-count?timezone="+userTimeZone+"%26brands="+encodeURIComponent(brands));
    let uniqueDate = 0;

    seUniqueDate.onmessage = function (event) {
        uniqueDate = JSON.parse(event.data).count;
        document.getElementById("devuniquedate").innerHTML = Intl.NumberFormat().format(uniqueDate);
    }
});
