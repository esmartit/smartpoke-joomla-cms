let seActivityDate = '';
let spChartAct = '';

let inAct = [];
let limitAct = [];
let outAct = [];
let deviceAct = [];
let axisAct = [];

let dateS = new Date();
let dateE = new Date();
let newDay = new Date();

// function nameDate(theDay) {
//     var a = new Date(theDay);
//     var days = new Array(7);
//     days[0] = "Sun";
//     days[1] = "Mon";
//     days[2] = "Tue";
//     days[3] = "Wed";
//     days[4] = "Thu";
//     days[5] = "Fri";
//     days[6] = "Sat";
//     var r = days[a.getDay()];
//     return r;
// }

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

$(document).ready( function() {
    let theme = {
        color: [
            '#26B99A', '#34495E', '#bdc3c7', '#3498DB',
            '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
        ],

        title: {
            itemGap: 8,
            textStyle: {
                fontWeight: 'normal',
                color: '#408829'
            }
        },

        dataRange: {
            color: ['#1f610a', '#97b58d']
        },

        toolbox: {
            color: ['#408829', '#408829', '#408829', '#408829']
        },

        tooltip: {
            backgroundColor: 'rgba(0,0,0,0.5)',
            axisPointer: {
                type: 'line',
                lineStyle: {
                    color: '#408829',
                    type: 'dashed'
                },
                crossStyle: {
                    color: '#408829'
                },
                shadowStyle: {
                    color: 'rgba(200,200,200,0.3)'
                }
            }
        },

        dataZoom: {
            dataBackgroundColor: '#eee',
            fillerColor: 'rgba(64,136,41,0.2)',
            handleColor: '#408829'
        },
        grid: {
            borderWidth: 0
        },

        categoryAxis: {
            axisLine: {
                lineStyle: {
                    color: '#408829'
                }
            },
            splitLine: {
                lineStyle: {
                    color: ['#eee']
                }
            }
        },

        valueAxis: {
            axisLine: {
                lineStyle: {
                    color: '#408829'
                }
            },
            splitArea: {
                show: true,
                areaStyle: {
                    color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
                }
            },
            splitLine: {
                lineStyle: {
                    color: ['#eee']
                }
            }
        },
        timeline: {
            lineStyle: {
                color: '#408829'
            },
            controlStyle: {
                normal: { color: '#408829' },
                emphasis: { color: '#408829' }
            }
        },

        k: {
            itemStyle: {
                normal: {
                    color: '#68a54a',
                    color0: '#a9cba2',
                    lineStyle: {
                        width: 1,
                        color: '#408829',
                        color0: '#86b379'
                    }
                }
            }
        },
        textStyle: {
            fontFamily: 'Arial, Verdana, sans-serif'
        }
    };


    let option = {
        title: {
            text: '',
            subtext: ''
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross',
                label: {
                    backgroundColor: '#283b56'
                }
            }
        },
        legend: {
            data:['TOTAL', 'IN', 'LIMIT', 'OUT'],
            selected:{'TOTAL':true, 'IN':false,'LIMIT':false, 'OUT': false},

        },
        toolbox: {
            show: true,
            feature: {
                magicType: {
                    show: true,
                    title: {
                        line: 'Line',
                        bar: 'Bar'
                    },
                    type: ['line', 'bar']
                },
                restore: {
                    show: true,
                    title: 'Restore'
                },
                saveAsImage: {
                    show: true,
                    title: 'Save Image'
                }
            }
        },
        dataZoom: {
            show: false,
            start: 0,
            end: 100
        },
        xAxis: [
            {
                type: 'category',
                name: 'Days',
                min: 0,
                boundaryGap: [1, 1],
                data: axisAct
            }
        ],
        yAxis: [
            {
                type: 'value',
                scale: true,
                name: 'Visitors',
                min: 0,
                boundaryGap: [1, 1]
            }
        ],
        series: [
            {
                name: 'TOTAL',
                type: 'bar',
                smooth: true,
                itemStyle: {
                    normal: {
                        areaStyle: {
                            type: 'default'
                        }
                    }
                },
                data: deviceAct,
                markLine : {
                    data : [
                        {type : 'average', name: 'Avg'}
                    ]
                }
            },
            {
                name: 'IN',
                type: 'bar',
                smooth: true,
                itemStyle: {
                    normal: {
                        areaStyle: {
                            type: 'default'
                        }
                    }
                },
                data: inAct
            },
            {
                name: 'LIMIT',
                type: 'bar',
                smooth: true,
                itemStyle: {
                    normal: {
                        areaStyle: {
                            type: 'default'
                        }
                    }
                },
                data: limitAct
            },
            {
                name: 'OUT',
                type: 'bar',
                smooth: true,
                itemStyle: {
                    normal: {
                        areaStyle: {
                            type: 'default'
                        }
                    }
                },
                data: outAct
            }
        ]
    };

    let userTimeZone = document.getElementById('userTimeZone').innerText;
    let brands = encodeURIComponent("Apple,Huawei,LG,Motorola,Oppo,BQ,Samsung,Sony Ericsson,Xiaomi,ZTE,MAC Dynamic");
    // let dateWeek = $('#datestart').val();

    dateS.setDate(dateE.getDate() - 7);
    
    let d1 = new Date(dateS);
    let d2 = new Date(dateE);
    let days = Math.round((d2 - d1) / (1000 * 3600 * 24));
    for (let i=0; i<=days; i++) {
        let month = '' + (d1.getMonth() + 1);
        let day = '' + d1.getDate();
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day =  '0' + day;
        axisAct[i] = [month, day].join('-');
        inAct[i] = 0;
        limitAct[i] = 0;
        outAct[i] = 0;
        deviceAct[i] = 0;
        d1 = new Date(d1.setDate(d1.getDate() + 1));

    }

    dateS = formatDate(dateS);
    dateE = formatDate(dateE);

    spChartAct = echarts.init(document.getElementById('echart_activity_date'), theme);
    spChartAct.setOption(option);
    // seActivityDate = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/v2/now-detected?timezone="+userTimeZone+"%26brands="+encodeURIComponent(brands));
    seActivityDate = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/v2/find-bigdata?"+
    "timezone="+userTimeZone+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime=%26endTime="+
    "%26countryId=%26stateId=%26cityId=%26zipcodeId="+
    "%26spotId=%26sensorId=%26zone=%26includedDevices=%26excludedDevices="+
    "%26brands="+encodeURIComponent(brands)+"%26status=%26presence="+
    "%26ageStart=%26ageEnd=%26gender=%26zipCode=%26memberShip=%26groupBy=BY_DAY");

    seActivityDate.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let len = eventData.length;
        let axis_Act = '';
        let group_x = eventData.group;
        let last = eventData.isLast;
        let in_Act = eventData.inCount;
        let limit_Act = eventData.limitCount;
        let out_Act = eventData.outCount;
        axis_Act = group_x.substr(group_x.length -5,group_x.length);
        
        if (!last) {

            pos = axisAct.indexOf(axis_Act);

            inAct[pos] = in_Act;
            limitAct[pos] = limit_Act;
            outAct[pos] = out_Act;
            deviceAct[pos] = in_Act + limit_Act + out_Act;

        } else {
            seActivityDate.close();

        }

        // for (let i=0; i < len; i++) {
        //     let axisTime = (new Date(eventData[i]['time'])).toTimeString();
        //     let xTime = axisTime.substring(0,5);
        //     inAct[i] = eventData[i]['inCount'];
        //     limitAct[i] = eventData[i]['limitCount'];
        //     outAct[i] = eventData[i]['outCount'];
        //     deviceAct[i] = inAct[i] + limitAct[i] + outAct[i];
        //     axisAct[i] = xTime;
        // }

        spChartAct.setOption(option);
        // console.log(hoursArr, deviceArr, inArr, limitArr, outArr);
    }

});

