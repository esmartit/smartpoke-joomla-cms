let seRankingBrand = '';
let deviceBrand = [];

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

    let theme = {
        color: [
            '#26B99A', '#34495E', '#BDC3C7', '#3498DB',
            '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7',
            '#f57641', '#e3225e'
        ],

        title: {
            itemGap: 4,
            textStyle: {
                fontWeight: 'normal',
                color: '#408829'
            }
        },

        textStyle: {
            fontFamily: 'Arial, Verdana, sans-serif'
        }
    };

    let userTimeZone = document.getElementById('userTimeZone').innerText;
    //let dateS = $('#datestart').val();
    //let dateE = $('#dateend').val();
    let dateS = formatDate(Date.now());
    let dateE = formatDate(Date.now());
    
    seRankingBrand = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/v2/today-brands?startDate="+dateS+"%26endDate="+dateE);
    // seRankingBrand = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/v2/today-brands?timezone="+userTimeZone+"%26startDate="+dateS+"%26endDate="+dateE);
    let spChart = echarts.init(document.getElementById('echart_rankingby_brand'), theme);

    function echartBrands(brands) {

        let option = {
            tooltip: {
                trigger: 'item',
                formatter: '{b} : {c} ({d}%)'
            },
            calculable: true,
            series: [
                {
                    name: 'Brand',
                    type: 'pie',
                    radius: ['50%', '57%'],
                    center: ['50%', '42%'],
                    avoidLabelOverlap: true,
                    label: {
                        show: false,
                        position: 'center'
                    },
                    emphasis: {
                        label: {
                            show: true,
                            fontSize: '10',
                            fontWeight: 'bold'
                        }
                    },
                    labelLine: {
                        show: false
                    },
                    data: brands
                }
            ]
        };
        spChart.setOption(option);

    }

    seRankingBrand.onmessage = function (event) {
        deviceBrand = JSON.parse(event.data);

        deviceBrand.sort(compareValues('value', 'desc'));
        echartBrands(deviceBrand)
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