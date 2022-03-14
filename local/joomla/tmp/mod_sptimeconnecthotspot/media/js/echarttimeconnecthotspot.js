let seConnectedTime = '';
let spChartConnectedTime = '';
let spChartTraffic = '';

let totalUser = [];
let sessionTime = [];
let inputOctets = [];
let outputOctets = [];
let totalOctets = [];
let axisTime = [];

let themeT = {
    color: [
        '#3498DB', '#34495E', '#26B99A', '#9B59B6',
        '#bdc3c7', '#8abb6f', '#759c6a', '#bfd3b7'
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

let optionCT = {
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
        data:['Users', 'AvgTime']
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
            data: axisTime
        }
    ],
    yAxis: [
        {
            type: 'value',
            name: 'Users',
            min: 0,
            interval: 5,
            position: 'left'
        },
        {
            type: 'value',
            name: 'Min.',
            interval: 60
        }
    ],
    series: [
        {
            name: 'Users',
            type: 'bar',
            smooth: false,
            data: totalUser
        },
        {
            name: 'AvgTime',
            type: 'line',
            smooth: true,
            yAxisIndex: 1,
            data: sessionTime
        }
    ]
};

let optionT = {
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
        data:['Users', 'Total', 'UpLoad', 'DownLoad']
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
            data: axisTime
        }
    ],
    yAxis: [
        {
            type: 'value',
            name: 'Users',
            min: 0,
            interval: 5,
            position: 'left'
        },
        {
            type: 'value',
            name: 'Gb',
            interval: 1024
        }
    ],
    series: [
        {
            name: 'Users',
            type: 'bar',
            smooth: false,
            data: totalUser
        },
        {
            name: 'Total',
            type: 'line',
            yAxisIndex: 1,
            data: totalOctets
        },
        {
            name: 'UpLoad',
            type: 'line',
            data: inputOctets
        },
        {
            name: 'DownLoad',
            type: 'line',
            data: outputOctets
        }
    ]
};

function evtSourceConnectTime(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, hotspot, ageS, ageE, sex,
                              zipcodes, member, userTZ, group, connected) {
    let len = axisTime.length;
    for (let i=0; i<len; i++) {
        optionCT.series[0].data.shift();
        optionCT.series[1].data.shift();
        optionCT.xAxis[0].data.shift();
        spChartConnectedTime.setOption(optionCT);

        optionT.series[0].data.shift();
        optionT.series[1].data.shift();
        optionT.series[2].data.shift();
        optionT.series[3].data.shift();
        optionT.xAxis[0].data.shift();
        spChartTraffic.setOption(optionT);
    }

    let d1 = new Date(dateS);
    let d2 = new Date(dateE);
    let days = Math.round((d2 - d1) / (1000 * 3600 * 24));
    for (let i=0; i<=days; i++) {
        let month = '' + (d1.getMonth() + 1);
        let day = '' + d1.getDate();
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day =  '0' + day;
        axisTime[i] = [month, day].join('-');
        d1 = new Date(d1.setDate(d1.getDate() + 1));
    }

    spChartConnectedTime = echarts.init(document.getElementById('echart_timeconnect_hotspot'), themeT);
    spChartConnectedTime.setOption(optionCT);
    spChartTraffic = echarts.init(document.getElementById('echart_traffic_hotspot'), themeT);
    spChartTraffic.setOption(optionT);

    // seConnectedTime = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/smartpoke/total-time?"+
    //     "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
    //     "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
    //     "%26spotId="+spot+"%26ssid="+encodeURIComponent(hotspot)+"%26isConnected="+connected+
    //     "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);

    seConnectedTime = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/smartpoke/v2/total-time?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26ssid="+encodeURIComponent(hotspot)+"%26isConnected="+connected+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);
    let pos = 0;

    NProgress.start();
    NProgress.set(0,4);
    seConnectedTime.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let len = eventData.length;
        for (let x=0; x<len; x++) {
            let last = eventData[x].isLast;
            if (!last) {
                let bodyData = eventData[x].body;
                let axisGroup = '';
                let group_x = bodyData.date;
                let users_x = bodyData.TotalUsers;
                let session_x = bodyData.AvgSessionTime;
                let upload_x = bodyData.TotalInputOcts;
                let download_x = bodyData.TotalOutputOcts;
                let total_x = upload_x + download_x

                axisGroup = group_x.substr(group_x.length -5,group_x.length);
                pos = axisTime.indexOf(axisGroup);

                totalUser[pos] = users_x;
                sessionTime[pos] = time2str(session_x, 'M');
                inputOctets[pos] = toxGigaByte(upload_x, 'Gb');
                outputOctets[pos] = toxGigaByte(download_x, 'Gb');
                totalOctets[pos] = toxGigaByte(total_x, 'Gb');

                spChartConnectedTime.setOption(optionCT);
                spChartTraffic.setOption(optionT);
            } else {
                seConnectedTime.close();
                NProgress.done();
            }
        }
    }
}

function toxGigaByte(traffic, type) {
    let ret = 0;
    if ( type == 'Tb' ) {
        ret = (traffic / 1099511627776);
    }
    // Gigabytes
    if ( type == 'Gb' ) {
        ret = (traffic / 1073741824);
    }
    // Megabytes
    if ( type == 'Mb' ) {
        ret = (traffic / 1048576);
    }
    let value = Math.round(ret*100)/100;
    return value;
}

function time2str(session, type) {
    let ret = 0;
    // Hours
    if ( type == 'H' ) {
        ret = (session / 3600);
    }
    // Minuts
    if ( type == 'M' ) {
        ret = (session / 60);
    }
    // Seconds
    if ( type == 'S' ) {
        ret = session;
    }
    let value = Math.round(ret);
    return value;
}
