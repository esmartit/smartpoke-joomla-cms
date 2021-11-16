let seActivityOnline = '';

let spChartOnline = '';
let inOnline = [];
let limitOnline = [];
let outOnline = [];
let deviceOnline = [];
let hoursOnline = [];

for (let x = 0; x < 24; x++) {
    inOnline[x] = 0;
    limitOnline[x] = 0;
    outOnline[x] = 0;
    deviceOnline[x] = 0;
    hoursOnline[x] = x;
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

    // let userTimeZone = document.getElementById('userTimeZone').innerText;
    // seActivityOnline = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/today-detected?timezone="+userTimeZone);
    spChartOnline = echarts.init(document.getElementById('echart_activity_online'), theme);
    // seActivityOnline.onmessage = function (event) {
    //     let eventData = JSON.parse(event.data);
    //     let dataHours = (new Date(eventData.time)).getHours();
    //     let in_x = eventData.inCount;
    //     let limit_x = eventData.limitCount;
    //     let out_x = eventData.outCount;
    //
    //     inOnline[dataHours] = in_x;
    //     limitOnline[dataHours] = limit_x;
    //     outOnline[dataHours] = out_x;
    //     deviceOnline[dataHours] = in_x + limit_x + out_x;
    //     hoursOnline[dataHours] = dataHours;
    //
    //     echartActivityOnline(hoursOnline, deviceOnline, inOnline, limitOnline, outOnline);
    //     // console.log(dataHours, device_x, in_x, limit_x, out_x);
    // }
})

function echartActivityOnline(hoursAct, deviceAct, inAct, limitAct, outAct) {
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
            data:['TOTAL', 'IN', 'LIMIT', 'OUT']
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
                boundaryGap: false,
                data: [
                    hoursAct[0], hoursAct[1], hoursAct[2], hoursAct[3], hoursAct[4], hoursAct[5],
                    hoursAct[6], hoursAct[7], hoursAct[8], hoursAct[9], hoursAct[10], hoursAct[11],
                    hoursAct[12], hoursAct[13], hoursAct[14], hoursAct[15], hoursAct[16], hoursAct[17],
                    hoursAct[18], hoursAct[19], hoursAct[20], hoursAct[21], hoursAct[22], hoursAct[23]
                ]
            }
        ],
        yAxis: [
            {
                type: 'value',
                name: 'Visitors'
            }
        ],
        series: [
            {
                name: 'TOTAL',
                type: 'line',
                smooth: true,
                itemStyle: {
                    normal: {
                        areaStyle: {
                            type: 'default'
                        }
                    }
                },
                data: [
                    deviceAct[0],deviceAct[1],deviceAct[2],deviceAct[3],deviceAct[4],deviceAct[5],
                    deviceAct[6],deviceAct[7],deviceAct[8],deviceAct[9],deviceAct[10],deviceAct[11],
                    deviceAct[12],deviceAct[13],deviceAct[14],deviceAct[15],deviceAct[16],deviceAct[17],
                    deviceAct[18],deviceAct[19],deviceAct[20],deviceAct[21],deviceAct[22],deviceAct[23]
                ],
                markLine : {
                    data : [
                        {type : 'average', name: 'Avg'}
                    ]
                }
            },
            {
                name: 'IN',
                type: 'line',
                smooth: true,
                itemStyle: {
                    normal: {
                        areaStyle: {
                            type: 'default'
                        }
                    }
                },
                data: [
                    inAct[0],inAct[1],inAct[2],inAct[3],inAct[4],inAct[5],
                    inAct[6],inAct[7],inAct[8],inAct[9],inAct[10],inAct[11],
                    inAct[12],inAct[13],inAct[14],inAct[15],inAct[16],inAct[17],
                    inAct[18],inAct[19],inAct[20],inAct[21],inAct[22],inAct[23]
                ]
            },
            {
                name: 'LIMIT',
                type: 'line',
                smooth: true,
                itemStyle: {
                    normal: {
                        areaStyle: {
                            type: 'default'
                        }
                    }
                },
                data: [
                    limitAct[0],limitAct[1],limitAct[2],limitAct[3],limitAct[4],limitAct[5],
                    limitAct[6],limitAct[7],limitAct[8],limitAct[9],limitAct[10],limitAct[11],
                    limitAct[12],limitAct[13],limitAct[14],limitAct[15],limitAct[16],limitAct[17],
                    limitAct[18],limitAct[19],limitAct[20],limitAct[21],limitAct[22],limitAct[23]
                ]
            },
            {
                name: 'OUT',
                type: 'line',
                smooth: true,
                itemStyle: {
                    normal: {
                        areaStyle: {
                            type: 'default'
                        }
                    }
                },
                data: [
                    outAct[0],outAct[1],outAct[2],outAct[3],outAct[4],outAct[5],
                    outAct[6],outAct[7],outAct[8],outAct[9],outAct[10],outAct[11],
                    outAct[12],outAct[13],outAct[14],outAct[15],outAct[16],outAct[17],
                    outAct[18],outAct[19],outAct[20],outAct[21],outAct[22],outAct[23]
                ]
            }
        ]
    };
    spChartOnline.setOption(option);
}

function evtSourceActivityOnline(dateS, dateE, country, state, city, zipcode, spot, sensor, zone, inDevices, exDevices, brands, status, ageS, ageE, sex,
                                 zipcodes, member, userTZ) {
    if (seActivityOnline.readyState == 1) {
        seActivityOnline.close();
    }

    seActivityOnline = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/today-detected?"+
        "timezone="+userTZ+"%26startTime="+dateS+"%26endTime="+dateE+"%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zoneId="+zone+"%26includedDevices="+inDevices+"%26excludedDevices="+exDevices+
        "%26brands="+encodeURIComponent(brands)+"%26status="+status+"%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member);

    for (let x = 0; x < 24; x++) {
        inOnline[x] = 0;
        limitOnline[x] = 0;
        outOnline[x] = 0;
        deviceOnline[x] = 0;
        hoursOnline[x] = x;
    }

    NProgress.start();
    NProgress.set(0,4);
    seActivityOnline.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let dataHours = (new Date(eventData.time)).getHours();
        let in_x = eventData.inCount;
        let limit_x = eventData.limitCount;
        let out_x = eventData.outCount;

        inOnline[dataHours] = in_x;
        limitOnline[dataHours] = limit_x;
        outOnline[dataHours] = out_x;
        deviceOnline[dataHours] = in_x + limit_x + out_x;
        hoursOnline[dataHours] = dataHours;

        echartActivityOnline(hoursOnline, deviceOnline, inOnline, limitOnline, outOnline);
        // console.log(dataHours, device_x, in_x, limit_x, out_x);
    }
    NProgress.done();
}