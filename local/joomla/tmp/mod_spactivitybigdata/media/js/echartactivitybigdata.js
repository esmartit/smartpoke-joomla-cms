let seActivityBigDataR = '';
let seActivityBigDataC = '';
let spChartBigDataR = '';
let spChartBigDataC = '';

// let optionR = "";
// let optionC = "";

let inBigDataR = [];
let limitBigDataR = [];
let outBigDataR = [];
let deviceBigDataR = [];
let axisBigDataR = [];

// Arrays to compare
let inBigDataC = [];
let limitBigDataC = [];
let outBigDataC = [];
let deviceBigDataC = [];
let axisBigDataC = [];

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
        map: {
            itemStyle: {
                normal: {
                    areaStyle: {
                        color: '#ddd'
                    },
                    label: {
                        textStyle: {
                            color: '#c12e34'
                        }
                    }
                },
                emphasis: {
                    areaStyle: {
                        color: '#99d2dd'
                    },
                    label: {
                        textStyle: {
                            color: '#c12e34'
                        }
                    }
                }
            }
        },
        force: {
            itemStyle: {
                normal: {
                    linkStyle: {
                        strokeColor: '#408829'
                    }
                }
            }
        },
        chord: {
            padding: 4,
            itemStyle: {
                normal: {
                    lineStyle: {
                        width: 1,
                        color: 'rgba(128, 128, 128, 0.5)'
                    },
                    chordStyle: {
                        lineStyle: {
                            width: 1,
                            color: 'rgba(128, 128, 128, 0.5)'
                        }
                    }
                },
                emphasis: {
                    lineStyle: {
                        width: 1,
                        color: 'rgba(128, 128, 128, 0.5)'
                    },
                    chordStyle: {
                        lineStyle: {
                            width: 1,
                            color: 'rgba(128, 128, 128, 0.5)'
                        }
                    }
                }
            }
        },
        gauge: {
            startAngle: 225,
            endAngle: -45,
            axisLine: {
                show: true,
                lineStyle: {
                    color: [[0.2, '#86b379'], [0.8, '#68a54a'], [1, '#408829']],
                    width: 8
                }
            },
            axisTick: {
                splitNumber: 10,
                length: 12,
                lineStyle: {
                    color: 'auto'
                }
            },
            axisLabel: {
                textStyle: {
                    color: 'auto'
                }
            },
            splitLine: {
                length: 18,
                lineStyle: {
                    color: 'auto'
                }
            },
            pointer: {
                length: '90%',
                color: 'auto'
            },
            title: {
                textStyle: {
                    color: '#333'
                }
            },
            detail: {
                textStyle: {
                    color: 'auto'
                }
            }
        },
        textStyle: {
            fontFamily: 'Arial, Verdana, sans-serif'
        }
    };

    spChartBigDataR = echarts.init(document.getElementById('echart_activity_bigdata_r'), theme);
    spChartBigDataC = echarts.init(document.getElementById('echart_activity_bigdata_c'));
})

// function echartActivityBigDataR(axisR, deviceActR, inActR, limitActR, outActR) {
let optionR = {
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
                boundaryGap: true,
                data: axisBigDataR
            }
        ],
        yAxis: [
            {
                type: 'value',
                scale: true,
                name: 'Devices',
                min: 0,
                boundaryGap: [1, 1]
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
                data: deviceBigDataR,
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
                data: inBigDataR
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
                data: limitBigDataR
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
                data: outBigDataR
            }
        ]
    };
    // spChartBigDataR.setOption(optionR);
// }

// function echartActivityBigDataC(axisC, deviceActC, inActC, limitActC, outActC) {
let optionC = {
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
                boundaryGap: true,
                data: axisBigDataC
            }
        ],
        yAxis: [
            {
                type: 'value',
                scale: true,
                name: 'Devices',
                min: 0,
                boundaryGap: [1, 1]
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
                data: deviceBigDataC,
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
                data: inBigDataC
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
                data: limitBigDataC
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
                data: outBigDataC
            }
        ]
    };
    // spChartBigDataC.setOption(optionC);
// }

// function x_graph(opt) {
//     for (let i=0; i<1; i++) {
//         inBigDataR[i] = 0;
//         limitBigDataR[i] = 0;
//         outBigDataR[i] = 0;
//         deviceBigDataR[i] = 0;
//         axisBigDataR[i] = ''
//         // echartActivityBigDataR(axisBigDataR, deviceBigDataR, inBigDataR, limitBigDataR, outBigDataR);
//     }
//     if (opt == 'C') {
//         for (let i=0; i<1; i++) {
//             inBigDataC[i] = 0;
//             limitBigDataC[i] = 0;
//             outBigDataC[i] = 0;
//             deviceBigDataC[i] = 0;
//             axisBigDataC[i] = ''
//             // echartActivityBigDataC(axisBigDataC, deviceBigDataC, inBigDataC, limitBigDataC, outBigDataC);
//         }
//     }
// }

function evtSourceActivityBigDataR(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, brands, status, presence, ageS, ageE, sex,
                                   zipcodes, member, userTZ, group) {
    // x_graph('R');
    inBigDataR[0] = 0;
    limitBigDataR[0] = 0;
    outBigDataR[0] = 0;
    deviceBigDataR[0] = 0;
    axisBigDataR[0] = ''
    spChartBigDataR.setOption(optionR);

    if (seActivityBigDataR.readyState != 2 && seActivityBigDataR != "") {
        seActivityBigDataR.close();
    }
    seActivityBigDataR = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/find?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zoneId="+zone+
        "%26brands="+brands+"%26status="+status+"%26presence="+presence+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);
    let pos = 0;
    let group_a = '';

    seActivityBigDataR.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let axisGroup = '';
        let group_x = eventData.group;
        let in_x = eventData.inCount;
        let limit_x = eventData.limitCount;
        let out_x = eventData.outCount;
        let last = eventData.isLast;

        switch (group) {
            case "BY_DAY":
                axisGroup = group_x.substr(group_x.length -5,group_x.length);
                break;
            case "BY_WEEK":
                axisGroup = group_x.substr(group_x.length -2,group_x.length);
                break;
            case "BY_MONTH":
                month = new Date(group_x+'/'+'01');
                axisGroup = month.toLocaleString('default', {month: 'short'});
                break;
            case "BY_YEAR":
                axisGroup = group_x;
                break;
        }

        if (group_x != group_a) {
            if (axisBigDataR.length > 0) {
                pos += 1;
            }
            group_a = group_x;
        }
        inBigDataR[pos] = in_x;
        limitBigDataR[pos] = limit_x;
        outBigDataR[pos] = out_x;
        deviceBigDataR[pos] = in_x + limit_x + out_x;
        axisBigDataR[pos] = axisGroup;

        spChartBigDataR.setOption(optionR);
        // echartActivityBigDataR(axisBigDataR, deviceBigDataR, inBigDataR, limitBigDataR, outBigDataR);
        // console.log(axisBigDataR, deviceBigDataR, inBigDataR, limitBigDataR, outBigDataR);
        if (last) {
            seActivityBigDataR.close();
        }
    }
}

function evtSourceActivityBigDataC(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, brands, status, presence, ageS, ageE, sex,
                                   zipcodes, member, userTZ, group) {
    // x_graph('C');
    inBigDataC[0] = 0;
    limitBigDataC[0] = 0;
    outBigDataC[0] = 0;
    deviceBigDataC[0] = 0;
    axisBigDataC[0] = ''
    spChartBigDataC.setOption(optionC);

    if (seActivityBigDataC.readyState != 2 && seActivityBigDataC != "") {
        seActivityBigDataC.close();
    }
    seActivityBigDataC = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/find?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zoneId="+zone+
        "%26brands="+brands+"%26status="+status+"%26presence="+presence+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);
    let pos = 0;
    let group_a = '';

    seActivityBigDataC.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let axisGroup = '';
        let group_x = eventData.group;
        let in_x = eventData.inCount;
        let limit_x = eventData.limitCount;
        let out_x = eventData.outCount;
        let last = eventData.isLast;

        switch (group) {
            case "BY_DAY":
                axisGroup = group_x.substr(group_x.length -5,group_x.length);
                break;
            case "BY_WEEK":
                axisGroup = group_x.substr(group_x.length -2,group_x.length);
                break;
            case "BY_MONTH":
                month = new Date(group_x+'/'+'01');
                axisGroup = month.toLocaleString('default', {month: 'short'});
                break;
            case "BY_YEAR":
                axisGroup = group_x;
                break;
        }

        if (group_x != group_a) {
            if (axisBigDataC.length > 0) {
                pos += 1;
            }
            group_a = group_x;
        }
        inBigDataC[pos] = in_x;
        limitBigDataC[pos] = limit_x;
        outBigDataC[pos] = out_x;
        deviceBigDataC[pos] = in_x + limit_x + out_x;
        axisBigDataC[pos] = axisGroup;

        spChartBigDataC.setOption(optionC);
        // echartActivityBigDataC(axisBigDataC, deviceBigDataC, inBigDataC, limitBigDataC, outBigDataC);
        // console.log(axisBigDataC, deviceBigDataC, inBigDataC, limitBigDataC, outBigDataC);
        if (last) {
            seActivityBigDataC.close();
        }

    }
}
