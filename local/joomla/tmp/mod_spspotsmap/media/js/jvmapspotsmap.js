let seRankingCountry = '';
let deviceCountry = [];
let total = 0;
let countryList = [];

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

    let userTimeZone = document.getElementById('userTimeZone').innerText;
    //let dateS = $('#datestart').val();
    //let dateE = $('#dateend').val();
    let dateS = formatDate(Date.now());
    let dateE = formatDate(Date.now());

    let brands = encodeURIComponent("Apple,Huawei,LG,Motorola,Oppo,BQ,Samsung,Sony Ericsson,Xiaomi,ZTE,MAC Dynamic");
    seRankingCountry = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/v2/today-countries?startDate="+dateS+"%26endDate="+dateE+"%26brands="+encodeURIComponent(brands));
    // seRankingCountry = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/v2/today-countries?timezone="+userTimeZone+"%26startDate="+dateS+"%26endDate="+dateE+"%26brands="+encodeURIComponent(brands));
    getCountryList();

    function spotMap(dataCountries) {

        $('#vmap_world').vectorMap({
            map: 'world_en',
            backgroundColor: '#C1C1C1',
            color: '#ffffff',
            hoverOpacity: 0.7,
            selectedColor: '#666666',
            enableZoom: true,
            showTooltip: true,
            values: dataCountries,
            scaleColors: ['#C8EEFF', '#006491'],
            normalizeFunction: 'polynomial',
            hoverColor: true
        });
    }

    seRankingCountry.onmessage = function (event) {
        total = 0;
        document.getElementById('countries').innerHTML = '';
        deviceCountry = JSON.parse(event.data);
        deviceCountry.sort(compareValues('value', 'desc'));

        let len = deviceCountry.length;
        let dataMap = {};
        let dataList = [];
        let labels = ['name', 'value'];

        for (let i=0; i < len; i++) {
            let strName = deviceCountry[i].name;
            let value = deviceCountry[i].value;
            let name = strName.toLowerCase();

            total += value;
            dataMap[name] = value;
        }

        buildTable(labels, deviceCountry, document.getElementById('countries'));
        spotMap(dataMap);
        // console.log(hoursArr, deviceArr, inArr, limitArr, outArr);
    }
});

function compareValues(key, order = 'asc') {
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

function buildTable(cols, rows, container) {
    let table = document.createElement('table');
    let tbody = document.createElement('tbody');
    table.className = 'countries_list';

    for (let j = 0; j < rows.length; j++) {
        //getCountry(rows[j]['name']);
        let tbodyTr = document.createElement('tr');
        for (let k = 0; k < cols.length; k++) {
            let tbodyTd = document.createElement('td');
            if (k == 0) {
                let countryName = countryList.find(x => x.code === rows[j]['name']).name;
                //tbodyTd.innerHTML = rows[j][cols[k]];
                tbodyTd.innerHTML = countryName;
            } else {
                let devices = (rows[j][cols[k]]/total)*100;
                let percent = Math.round(devices*100/100);
                tbodyTd.className = 'fs15 fw700 text-right';
                tbodyTd.innerHTML = (percent) + '%';
            }
            tbodyTr.appendChild(tbodyTd);
        }
        tbody.appendChild(tbodyTr);
    }
    table.appendChild(tbody);
    container.appendChild(table);
}


function getCountryList() {
    let request = {
        option       : 'com_ajax',
        module       : 'spselectonline',  // to target: mod_spselectonline
        method       : 'getSpotCountry',  // to target: function getSpotCountryAjax in class ModSPSelectOnlineHelper
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
                let id = object[i][0];
                let name = object[i][1];

                countryList.push({code: id, name: name });
            }
        });
}
