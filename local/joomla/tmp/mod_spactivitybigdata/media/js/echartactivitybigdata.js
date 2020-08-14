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

Date.prototype.getWeek = function() {
    let onejan = new Date(this.getFullYear(),0,1);
    return Math.ceil((((this - onejan) / 86400000) + onejan.getDay()+1)/7);
}

function evtSourceActivityBigDataR(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, brands, status, presence, ageS, ageE, sex,
                                   zipcodes, member, userTZ, group) {
    let len = axisBigDataR.length;
    for (let i=0; i<len; i++) {
        optionR.series[0].data.shift();
        optionR.series[1].data.shift();
        optionR.series[2].data.shift();
        optionR.series[3].data.shift();
        optionR.xAxis[0].data.shift();
        spChartBigDataR.setOption(optionR);
    }
    switch (group) {
        case "BY_DAY":
            let d1 = new Date(dateS + 'Z12:00:00');
            let d2 = new Date(dateE + 'Z12:00:00');
            let days = Math.round((d2 - d1) / (1000 * 3600 * 24));
            for (let i=0; i<=days; i++) {
                let month = '' + (d1.getMonth() + 1);
                let day = '' + d1.getDate();
                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day =  '0' + day;
                axisBigDataR[i] = [month, day].join('/');
                inBigDataR[i] = 0;
                limitBigDataR[i] = 0;
                outBigDataR[i] = 0;
                deviceBigDataR[i] = 0;
                d1 = new Date(d1.setDate(d1.getDate() + 1));
            }
            break;
        case "BY_WEEK":
            let dw1 = new Date(dateS + 'Z12:00:00');
            let dw2 = new Date(dateE + 'Z12:00:00');
            let weeks = Math.round((dw2 - dw1) / (1000 * 3600 * 24 * 7));
            let week = dw1.getWeek();
            for (let i=0; i<=weeks; i++) {
                inBigDataR[i] = 0;
                limitBigDataR[i] = 0;
                outBigDataR[i] = 0;
                deviceBigDataR[i] = 0;
                axisBigDataR[i] = week.toString();
                if (week < 10) {
                    axisBigDataR[i] = '0' + week.toString();
                }
                week += 1;
            }
            break;
        case "BY_MONTH":
            let months;
            let date1 = new Date(dateS);
            let date2 = new Date(dateE);
            months = (date2.getFullYear() - date1.getFullYear()) * 12;
            months -= date1.getMonth();
            months += date2.getMonth();
            months <= 0 ? 0 : months;
            for (let i=0; i<=months; i++) {
                inBigDataR[i] = 0;
                limitBigDataR[i] = 0;
                outBigDataR[i] = 0;
                deviceBigDataR[i] = 0;
                axisBigDataR[i] = date1.toLocaleString('default', {month: 'short'});
                date1 = new Date(date1.setMonth(date1.getMonth() + 1));
            }
            break;
        case "BY_YEAR":
            let yearObj1 = new Date(dateS);
            let yearObj2 = new Date(dateE);
            let y1 = yearObj1.getFullYear();
            let y2 = yearObj2.getFullYear();
            inBigDataR[0] = 0;
            limitBigDataR[0] = 0;
            outBigDataR[0] = 0;
            deviceBigDataR[0] = 0;
            axisBigDataR[0] = y2.toString();
            inBigDataR[1] = 0;
            limitBigDataR[1] = 0;
            outBigDataR[1] = 0;
            deviceBigDataR[1] = 0;
            axisBigDataR[1] = y1.toString();
            if (y1 == y2) {
                y1 -= 1;
                axisBigDataR[1] = y1.toString();
            }
            break;
    }

    spChartBigDataR = echarts.init(document.getElementById('echart_activity_bigdata_r'), theme);
    spChartBigDataR.setOption(optionR);

    seActivityBigDataR = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/find?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zoneId="+zone+
        "%26brands="+brands+"%26status="+status+"%26presence="+presence+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);
    let pos = 0;

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

        pos = axisBigDataR.indexOf(axisGroup);

        inBigDataR[pos] = in_x;
        limitBigDataR[pos] = limit_x;
        outBigDataR[pos] = out_x;
        deviceBigDataR[pos] = in_x + limit_x + out_x;

        spChartBigDataR.setOption(optionR);
        if (last) {
            seActivityBigDataR.close();
        }
    }
}

function evtSourceActivityBigDataC(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, brands, status, presence, ageS, ageE, sex,
                                   zipcodes, member, userTZ, group) {

    let len = axisBigDataC.length;
    for (let i=0; i<len; i++) {
        optionC.series[0].data.shift();
        optionC.series[1].data.shift();
        optionC.series[2].data.shift();
        optionC.series[3].data.shift();
        optionC.xAxis[0].data.shift();
        spChartBigDataC.setOption(optionC);
    }
    switch (group) {
        case "BY_DAY":
            let d1 = new Date(dateS + 'Z12:00:00');
            let d2 = new Date(dateE + 'Z12:00:00');
            let days = Math.round((d2 - d1) / (1000 * 3600 * 24));
            for (let i=0; i<=days; i++) {
                let month = '' + (d1.getMonth() + 1);
                let day = '' + d1.getDate();
                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day =  '0' + day;
                axisBigDataC[i] = [month, day].join('/');
                inBigDataC[i] = 0;
                limitBigDataC[i] = 0;
                outBigDataC[i] = 0;
                deviceBigDataC[i] = 0;
                d1 = new Date(d1.setDate(d1.getDate() + 1));
            }
            break;
        case "BY_WEEK":
            let dw1 = new Date(dateS + 'Z12:00:00');
            let dw2 = new Date(dateE + 'Z12:00:00');
            let weeks = Math.round((dw2 - dw1) / (1000 * 3600 * 24 * 7));
            let week = dw1.getWeek();
            for (let i=0; i<=weeks; i++) {
                inBigDataC[i] = 0;
                limitBigDataC[i] = 0;
                outBigDataC[i] = 0;
                deviceBigDataC[i] = 0;
                axisBigDataC[i] = week.toString();
                if (week < 10) {
                    axisBigDataC[i] = '0' + week.toString();
                }
                week += 1;
            }
            break;
        case "BY_MONTH":
            let months;
            let date1 = new Date(dateS);
            let date2 = new Date(dateE);
            months = (date2.getFullYear() - date1.getFullYear()) * 12;
            months -= date1.getMonth();
            months += date2.getMonth();
            months <= 0 ? 0 : months;
            for (let i=0; i<=months; i++) {
                inBigDataC[i] = 0;
                limitBigDataC[i] = 0;
                outBigDataC[i] = 0;
                deviceBigDataC[i] = 0;
                axisBigDataC[i] = date1.toLocaleString('default', {month: 'short'});
                date1 = new Date(date1.setMonth(date1.getMonth() + 1));
            }
            break;
        case "BY_YEAR":
            let yearObj1 = new Date(dateS);
            let yearObj2 = new Date(dateE);
            let y1 = yearObj1.getFullYear();
            let y2 = yearObj2.getFullYear();
            inBigDataC[0] = 0;
            limitBigDataC[0] = 0;
            outBigDataC[0] = 0;
            deviceBigDataC[0] = 0;
            axisBigDataC[0] = y2.toString();
            inBigDataC[1] = 0;
            limitBigDataC[1] = 0;
            outBigDataC[1] = 0;
            deviceBigDataC[1] = 0;
            axisBigDataC[1] = y1.toString();
            if (y1 == y2) {
                y1 -= 1;
                axisBigDataC[1] = y1.toString();
            }
            break;
    }
    spChartBigDataC = echarts.init(document.getElementById('echart_activity_bigdata_c'));
    spChartBigDataC.setOption(optionC);

    seActivityBigDataC = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/find?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zoneId="+zone+
        "%26brands="+brands+"%26status="+status+"%26presence="+presence+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);
    let pos = 0;

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

        pos = axisBigDataC.indexOf(axisGroup);

        inBigDataC[pos] = in_x;
        limitBigDataC[pos] = limit_x;
        outBigDataC[pos] = out_x;
        deviceBigDataC[pos] = in_x + limit_x + out_x;

        spChartBigDataC.setOption(optionC);
        if (last) {
            seActivityBigDataC.close();
        }

    }
}
