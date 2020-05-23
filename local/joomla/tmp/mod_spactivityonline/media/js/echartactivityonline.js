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

    const sourceEvt = new EventSource("index.php?option=com_spserverevent&format=json&resource_path=/sensor-activity/today-hourly-device-presence");
    var spChart = echarts.init(document.getElementById('echart_activity_online'), theme);

    function echartActivity(hoursAct, deviceAct, inAct, limitAct, outAct) {
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
                        hoursAct[0], hoursAct[1], hoursAct[2], hoursAct[3], hoursAct[4], hoursAct[5],
                        hoursAct[6], hoursAct[7], hoursAct[8], hoursAct[9], hoursAct[10], hoursAct[11],
                        hoursAct[12], hoursAct[13], hoursAct[14], hoursAct[15], hoursAct[16], hoursAct[17],
                        hoursAct[18], hoursAct[19], hoursAct[20], hoursAct[21], hoursAct[22], hoursAct[23],
                    ]
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

    sourceEvt.onmessage = function (event) {
        let dataHours = (new Date(JSON.parse(event.data).time)).getHours();
        let in_x = JSON.parse(event.data).inCount;
        let limit_x = JSON.parse(event.data).limitCount;
        let out_x = JSON.parse(event.data).outCount;
        let device_x = in_x + limit_x + out_x;

        inArr[dataHours] = in_x;
        limitArr[dataHours] = limit_x;
        outArr[dataHours] = out_x;
        deviceArr[dataHours] = in_x + limit_x + out_x;
        hoursArr[dataHours] = dataHours;

        if (device_x !== deviceAnt) {
            echartActivity(hoursArr, deviceArr, inArr, limitArr, outArr);
            deviceAnt = device_x;
        }
        // console.log(dataHours, device_x, in_x, limit_x, out_x);
    }
})