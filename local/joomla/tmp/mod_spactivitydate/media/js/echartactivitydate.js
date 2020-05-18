$(document).ready( function() {
    var theme = {
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

    const sourceEvt = new EventSource("index.php?option=com_spserverevent&format=json&resource_path=/sensor-activity/hourly-device-presence-count");
    let inAct = 0;
    let limitAct = 0;
    let outAct = 0;
    let deviceAct = 0;
    let hourAnt = 0;

    var spChart = echarts.init(document.getElementById('echart_activity_date'), theme);

    var option = {
        title: {
            text: 'ACTIVITY',
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
        dataZoom: {
            show: false,
            start: 0,
            end: 100
        },
        xAxis: [
            {
                type: 'category',
                boundaryGap: true,
                data: (function (){
                    var now = new Date();
                    var res = [];
                    var len = 60;
                    while (len--) {
                        res.unshift(now.toLocaleTimeString().replace(/^\D*/,''));
                        now = new Date(now - 600000);
                    }
                    return res;
                })()
            },
            {
                type: 'category',
                boundaryGap: true,
                data: (function (){
                    var res = [];
                    var len = 60;
                    while (len--) {
                        res.push(60 - len - 1);
                    }
                    return res;
                })()
            }
        ],
        yAxis: [
            {
                type: 'value',
                scale: true,
                name: 'Devices',
                min: 0,
                boundaryGap: [0.2, 0.2]
            },
            {
                type: 'value',
                scale: true,
                name: 'Total',
                min: 0,
                boundaryGap: [0.2, 0.2]
            }
        ],
        series: [
            {
                name: 'TOTAL',
                type: 'bar',
                xAxisIndex: 1,
                yAxisIndex: 1,
                data: (function (){
                    var res = [];
                    var len = 60;
                    while (len--) {
                        res.push(deviceAct);
                    }
                    return res;
                })()
            },
            {
                name: 'IN',
                type: 'line',
                smooth: true,
                data: (function (){
                    var res = [];
                    var len = 0;
                    while (len < 60) {
                        res.push(inAct);
                        len++;
                    }
                    return res;
                })()
            },
            {
                name: 'LIMIT',
                type: 'line',
                smooth: true,
                data: (function (){
                    var res = [];
                    var len = 0;
                    while (len < 60) {
                        res.push(limitAct);
                        len++;
                    }
                    return res;
                })()
            },
            {
                name: 'OUT',
                type: 'line',
                smooth: true,
                data: (function (){
                    var res = [];
                    var len = 0;
                    while (len < 60) {
                        res.push(outAct);
                        len++;
                    }
                    return res;
                })()
            }

        ]
    };

    let count = 61;

    sourceEvt.onmessage = function (event) {
        var axisData = (new Date()).toLocaleTimeString().replace(/^\D*/, '');
        inAct = JSON.parse(event.data).inCount;
        limitAct = JSON.parse(event.data).limitCount;
        outAct = JSON.parse(event.data).outCount;
        hourAnt = JSON.parse(event.data).time;
        deviceAct = inAct + limitAct + outAct;

        var data0 = option.series[0].data;
        var data1 = option.series[1].data;
        var data2 = option.series[2].data;
        var data3 = option.series[3].data;
        data0.shift();
        data0.push(deviceAct);
        data1.shift();
        data1.push(inAct);
        data2.shift();
        data2.push(limitAct);
        data3.shift();
        data3.push(outAct);
        option.xAxis[0].data.shift();
        option.xAxis[0].data.push(axisData);
        option.xAxis[1].data.shift();
        // option.xAxis[1].data.push(count++);

        spChart.setOption(option);
    }

})