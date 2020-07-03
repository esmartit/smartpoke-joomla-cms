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
    // const seTimeConnectHotSpot = new EventSource("index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/today-hourly-device-presence?timezone="+userTimeZone);
    let spChart = echarts.init(document.getElementById('echart_timeconnect_hotspot'), theme);

    function echartTimeConnect() {
        var option = {
            title: {
                text: '',
                subtext: ''
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                x: 100,
                data: ['']
            },
            toolbox: {
                show: true,
                feature: {
                    saveAsImage: {
                        show: true,
                        title: 'Save Image'
                    }
                }
            },
            calculable: true,
            xAxis: [{
                type: 'value',
                boundaryGap: [0, 1]
            }],
            yAxis: [{
                type: 'category',
                data: ['[0-5]', '[6-15]', '[16-30]', '[31-60]', '[61-120]', '[121+]']
            }],
            series: [{
                name: 'Users',
                type: 'bar',
                data: [120, 100, 45, 12, 167, 17]
            }]
        };
        spChart.setOption(option);
    }

    // let newArr = [];
    // let oldArr = [];
    // let hoursArr = [];
    //
    // for (let x = 0; x < ; x++) {
    //     newArr[x] = 0;
    //     oldArr[x] = 0;
    //     hoursArr[x] = x;
    // }
    //
    // let totalAnt = 0;
    echartTimeConnect();
    // seTimeConnectHotSpot.onmessage = function (event) {
    //     let eventData = JSON.parse(event.data);
    //     let dataHours = (new Date(eventData.time)).getHours();
    //     let new_x = eventData.inCount;
    //     let old_x = eventData.outCount;
    //     let total_x = new_x + old_x;
    //
    //     newArr[dataHours] = new_x;
    //     oldArr[dataHours] = old_x;
    //     hoursArr[dataHours] = dataHours;
    //
    //     if (total_x !== totalAnt) {
    //         echartTimeConnect(hoursArr, newArr, oldArr);
    //         totalAnt = total_x;
    //     }
    //     // console.log(dataHours, device_x, in_x, limit_x, out_x);
    // }
})