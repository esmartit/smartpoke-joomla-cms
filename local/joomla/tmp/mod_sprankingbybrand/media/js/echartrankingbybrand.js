let seRankingBrand = '';
let deviceBrand = [];

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
    seRankingBrand = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/today-brands?timezone="+userTimeZone);
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
        const index = deviceBrand.findIndex(brand => brand.name === 'Unknown' );
        deviceBrand.splice(index, 1)
        echartBrands(deviceBrand)
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