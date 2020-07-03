$(document).ready( function() {
    let theme = {
        color: [
            '#34495E', '#26B99A', '#3498DB', '#bdc3c7',
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

    let userTimeZone = document.getElementById('userTimeZone').innerText;
    const seActivityHotSpot = new EventSource("index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/today-hourly-device-presence?timezone="+userTimeZone);
    let spChart = echarts.init(document.getElementById('echart_activity_hotspot'), theme);

    function echartActivity(hoursAct, newAct, oldAct) {
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
                data:['New Users', 'Registered']
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
                        hoursAct[18], hoursAct[19], hoursAct[20], hoursAct[21], hoursAct[22], hoursAct[23]
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
                    name: 'New Users',
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
                        newAct[0],newAct[1],newAct[2],newAct[3],newAct[4],newAct[5],
                        newAct[6],newAct[7],newAct[8],newAct[9],newAct[10],newAct[11],
                        newAct[12],newAct[13],newAct[14],newAct[15],newAct[16],newAct[17],
                        newAct[18],newAct[19],newAct[20],newAct[21],newAct[22],newAct[23]
                    ]
                },
                {
                    name: 'Registered',
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
                        oldAct[0],oldAct[1],oldAct[2],oldAct[3],oldAct[4],oldAct[5],
                        oldAct[6],oldAct[7],oldAct[8],oldAct[9],oldAct[10],oldAct[11],
                        oldAct[12],oldAct[13],oldAct[14],oldAct[15],oldAct[16],oldAct[17],
                        oldAct[18],oldAct[19],oldAct[20],oldAct[21],oldAct[22],oldAct[23]
                    ]
                }
            ]
        };
        spChart.setOption(option);
    }

    let newArr = [];
    let oldArr = [];
    let hoursArr = [];

    for (let x = 0; x < 24; x++) {
        newArr[x] = 0;
        oldArr[x] = 0;
        hoursArr[x] = x;
    }

    let totalAnt = 0;

    seActivityHotSpot.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let dataHours = (new Date(eventData.time)).getHours();
        let new_x = eventData.inCount;
        let old_x = eventData.outCount;
        let total_x = new_x + old_x;

        newArr[dataHours] = new_x;
        oldArr[dataHours] = old_x;
        hoursArr[dataHours] = dataHours;

        if (total_x !== totalAnt) {
            echartActivity(hoursArr, newArr, oldArr);
            totalAnt = total_x;
        }
        // console.log(dataHours, device_x, in_x, limit_x, out_x);
    }
})