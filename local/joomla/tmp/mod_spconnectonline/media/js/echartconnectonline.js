$(document).ready( function() {
    var theme = {
        color: [
            '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7',
            '#26B99A', '#34495E', '#bdc3c7', '#3498DB'
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

    let userTimeZone = document.getElementById('userTimeZone').innerText;
    const seConnectOnline = new EventSource("index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/today-hourly-device-presence?timezone="+userTimeZone);
    var spChart = echarts.init(document.getElementById('echart_connect_online'), theme);

    function echartConnect(hoursCon, deviceCon, inCon, limitCon, outCon) {
        var option = {
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
                    data: [
                        hoursCon[0], hoursCon[1], hoursCon[2], hoursCon[3], hoursCon[4], hoursCon[5],
                        hoursCon[6], hoursCon[7], hoursCon[8], hoursCon[9], hoursCon[10], hoursCon[11],
                        hoursCon[12], hoursCon[13], hoursCon[14], hoursCon[15], hoursCon[16], hoursCon[17],
                        hoursCon[18], hoursCon[19], hoursCon[20], hoursCon[21], hoursCon[22], hoursCon[23]
                    ]
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    scale: true,
                    name: 'Connected',
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
                    data: [
                        deviceCon[0],deviceCon[1],deviceCon[2],deviceCon[3],deviceCon[4],deviceCon[5],
                        deviceCon[6],deviceCon[7],deviceCon[8],deviceCon[9],deviceCon[10],deviceCon[11],
                        deviceCon[12],deviceCon[13],deviceCon[14],deviceCon[15],deviceCon[16],deviceCon[17],
                        deviceCon[18],deviceCon[19],deviceCon[20],deviceCon[21],deviceCon[22],deviceCon[23]
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
                        inCon[0],inCon[1],inCon[2],inCon[3],inCon[4],inCon[5],
                        inCon[6],inCon[7],inCon[8],inCon[9],inCon[10],inCon[11],
                        inCon[12],inCon[13],inCon[14],inCon[15],inCon[16],inCon[17],
                        inCon[18],inCon[19],inCon[20],inCon[21],inCon[22],inCon[23]
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
                        limitCon[0],limitCon[1],limitCon[2],limitCon[3],limitCon[4],limitCon[5],
                        limitCon[6],limitCon[7],limitCon[8],limitCon[9],limitCon[10],limitCon[11],
                        limitCon[12],limitCon[13],limitCon[14],limitCon[15],limitCon[16],limitCon[17],
                        limitCon[18],limitCon[19],limitCon[20],limitCon[21],limitCon[22],limitCon[23]
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
                        outCon[0],outCon[1],outCon[2],outCon[3],outCon[4],outCon[5],
                        outCon[6],outCon[7],outCon[8],outCon[9],outCon[10],outCon[11],
                        outCon[12],outCon[13],outCon[14],outCon[15],outCon[16],outCon[17],
                        outCon[18],outCon[19],outCon[20],outCon[21],outCon[22],outCon[23]
                    ]
                }
            ]
        };
        spChart.setOption(option);
    }


    let inArr = [];
    let limitArr = [];
    let outArr = [];
    let deviceArr = [];
    let hoursArr = [];

    for (var x = 0; x < 24; x++) {
        inArr[x] = 0;
        limitArr[x] = 0;
        outArr[x] = 0;
        deviceArr[x] = 0;
        hoursArr[x] = x;
    }

    let deviceAnt = 0;

    seConnectOnline.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let dataHours = (new Date(eventData.time)).getHours();
        let in_x = eventData.inCount;
        let limit_x = eventData.limitCount;
        let out_x = eventData.outCount;
        let device_x = in_x + limit_x + out_x;

        inArr[dataHours] = in_x;
        limitArr[dataHours] = limit_x;
        outArr[dataHours] = out_x;
        deviceArr[dataHours] = in_x + limit_x + out_x;
        hoursArr[dataHours] = dataHours;

        if (device_x !== deviceAnt) {
            echartConnect(hoursArr, deviceArr, inArr, limitArr, outArr);
            deviceAnt = device_x;
        }
        // console.log(dataHours, device_x, in_x, limit_x, out_x);
    }
})