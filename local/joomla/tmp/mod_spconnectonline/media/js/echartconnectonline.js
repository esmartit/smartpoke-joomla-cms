let seConnectOnline = '';
let spChartConnectedOnline = '';

let arrConnected = [];
let arrRegistered = [];
let axisOnline = [];

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

let optionOL = {
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
        data:['Registered', 'Connected']
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
            data: axisOnline
        }
    ],
    yAxis: [
        {
            type: 'value',
            name: 'Users'
        }
    ],
    series: [
        {
            name: 'Registered',
            type: 'bar',
            smooth: false,
            itemStyle: {
                normal: {
                    areaStyle: {
                        type: 'default'
                    }
                }
            },
            data: arrRegistered
        },
        {
            name: 'Connected',
            type: 'bar',
            smooth: false,
            itemStyle: {
                normal: {
                    areaStyle: {
                        type: 'default'
                    }
                }
            },
            data: arrConnected
        }
    ]
};

function evtSourceConnectOnline(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, hotspot, ageS, ageE, sex,
                                   zipcodes, member, userTZ, group, connected) {
    let len = axisOnline.length;
    for (let i=0; i<len; i++) {
        optionOL.series[0].data.shift();
        optionOL.series[1].data.shift();
        optionOL.xAxis[0].data.shift();
        spChartConnectedOnline.setOption(optionOL);
    }

    let d1 = new Date(dateS);
    let d2 = new Date(dateE);
    let days = Math.round((d2 - d1) / (1000 * 3600 * 24));
    for (let i=0; i<=days; i++) {
        let month = '' + (d1.getMonth() + 1);
        let day = '' + d1.getDate();
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day =  '0' + day;
        axisOnline[i] = [month, day].join('-');
        d1 = new Date(d1.setDate(d1.getDate() + 1));
    }

    spChartConnectedOnline = echarts.init(document.getElementById('echart_connect_online'), theme);
    spChartConnectedOnline.setOption(optionOL);

    // seConnectOnline = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/smartpoke/connected-registered?"+
    //     "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
    //     "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
    //     "%26spotId="+spot+"%26ssid="+encodeURIComponent(hotspot)+"%26isConnected="+connected+
    //     "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);

    seConnectOnline = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/smartpoke/v2/connected-registered?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26ssid="+encodeURIComponent(hotspot)+"%26isConnected="+connected+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);

    let pos = 0;

    NProgress.start();
    NProgress.set(0,4);
    seConnectOnline.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let len = eventData.length;
        for (let x = 0; x < len; x++) {
            let last = eventData[x].isLast;
            if (!last) {
                let bodyData = eventData[x].body;
                let axisGroup = '';
                let group_x = bodyData.date;
                let connected_x = bodyData.connected;
                let registered_x = bodyData.registered;

                axisGroup = group_x.substr(5, 5);
                pos = axisOnline.indexOf(axisGroup);

                arrRegistered[pos] = registered_x;
                arrConnected[pos] = connected_x;

                spChartConnectedOnline.setOption(optionOL);
            } else {
                seConnectOnline.close();
                NProgress.done();
            }
        }
    }
}

