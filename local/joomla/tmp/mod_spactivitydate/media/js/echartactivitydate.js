let seActivityDate = '';
let spChartAct = '';

let inAct = [];
let limitAct = [];
let outAct = [];
let deviceAct = [];
let axisAct = [];



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
                type: 'line',
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
                type: 'line',
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
                type: 'line',
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
                type: 'line',
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

    spChartAct = echarts.init(document.getElementById('echart_activity_date'), theme);
    seActivityDate = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/v2/now-detected?timezone="+userTimeZone);

    seActivityDate.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let len = eventData.length;

        for (let i=0; i < len; i++) {
            let axisTime = (new Date(eventData[i]['time'])).toTimeString();
            let xTime = axisTime.substring(0,5);
            inAct[i] = eventData[i]['inCount'];
            limitAct[i] = eventData[i]['limitCount'];
            outAct[i] = eventData[i]['outCount'];
            deviceAct[i] = inAct[i] + limitAct[i] + outAct[i];
            axisAct[i] = xTime;
        }

        spChartAct.setOption(option);
        // console.log(hoursArr, deviceArr, inArr, limitArr, outArr);
    }

});

