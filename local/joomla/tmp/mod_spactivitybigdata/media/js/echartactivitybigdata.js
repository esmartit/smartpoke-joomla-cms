let seActivityBigDataR = '';
let seActivityBigDataC = '';
let spChartBigDataR = '';
let spChartBigDataC = '';

let seAvgTimeBigDataR = '';
let avgtimeBigDataR = 0;
let seAvgTimeBigDataC = '';
let avgtimeBigDataC = 0;

let seUniqueBigDataR = '';
let devUniqueBigDataR = [];
let bigDataR = [];

let seUniqueBigDataC = '';
let devUniqueBigDataC = [];
let bigDataC = [];

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
            boundaryGap: false,
            data: axisBigDataR
        }
    ],
    yAxis: [
        {
            type: 'value',
            name: 'Visitors'
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
            boundaryGap: false,
            data: axisBigDataC
        }
    ],
    yAxis: [
        {
            type: 'value',
            name: 'Visitors'
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

function gettime2str(val, opt) {
    let request = {
        option       : 'com_ajax',
        module       : 'spactivitybigdata',  // to target: mod_spavgtimebigdata
        method       : 'time2str',  // to target: function time2strAjax in class ModSPAvgTimeBigDataHelper
        format       : 'json',
        data         : val
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            if (opt == 'r') document.getElementById("avgtimebigdata_r").innerHTML = response.data;
            else document.getElementById("avgtimebigdata_c").innerHTML = response.data;

        });
}

Date.prototype.getWeek = function() {
    let onejan = new Date(this.getFullYear(),0,1);
    return Math.ceil((((this - onejan) / 86400000) + onejan.getDay()+1)/7);
};

function getWeekNumber(d) {
    // Copy date so don't modify original
    d = new Date(+d);
    d.setHours(0, 0, 0, 0);
    // Set to nearest Thursday: current date + 4 - current day number
    // Make Sunday's day number 7
    d.setDate(d.getDate() + 4 - (d.getDay() || 7));
    // Get first day of year
    let yearStart = new Date(d.getFullYear(), 0, 1);
    // Calculate full weeks to nearest Thursday
    let weekNo = Math.ceil((((d - yearStart) / 86400000) + 1) / 7)
    // Return array of year and week number
    return [d.getFullYear(), weekNo];
}

function weeksInYear(year) {
    let month = 11,
        day = 31,
        week;

    // Find week that 31 Dec is in. If is first week, reduce date until
    // get previous week.
    do {
        d = new Date(year, month, day--);
        week = getWeekNumber(d)[1];
    } while (week == 1);

    return week;
}

function evtSourceActivityBigDataR(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, inDevices, exDevices, brands, status, presence, ageS, ageE, sex,
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
            let d1 = new Date(dateS);
            let d2 = new Date(dateE);
            let days = Math.round((d2 - d1) / (1000 * 3600 * 24));
            for (let i=0; i<=days; i++) {
                let month = '' + (d1.getMonth() + 1);
                let day = '' + d1.getDate();
                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day =  '0' + day;
                axisBigDataR[i] = [month, day].join('-');
                inBigDataR[i] = 0;
                limitBigDataR[i] = 0;
                outBigDataR[i] = 0;
                deviceBigDataR[i] = 0;
                d1 = new Date(d1.setDate(d1.getDate() + 1));
            }
            break;
        case "BY_WEEK":
            let dw1 = new Date(dateS);
            let dw2 = new Date(dateE);
            let weeks = Math.round((dw2 - dw1) / (1000 * 3600 * 24 * 7));
            let week = dw1.getWeek();
            let weekYear = weeksInYear(dw1.getFullYear());
            let newWeek = 0;
            for (let i=0; i<=weeks; i++) {
                inBigDataR[i] = 0;
                limitBigDataR[i] = 0;
                outBigDataR[i] = 0;
                deviceBigDataR[i] = 0;
                if (week > weekYear) {
                    newWeek = week - weekYear;
                } else {
                    newWeek = week;
                }
                axisBigDataR[i] = newWeek.toString();
                if (newWeek < 10) {
                    axisBigDataR[i] = '0' + newWeek.toString();
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

    seActivityBigDataR = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/v2/find-bigdata?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zoneId="+zone+"%26includedDevices="+inDevices+"%26excludedDevices="+exDevices+
        "%26brands="+encodeURIComponent(brands)+"%26status="+status+"%26presence="+presence+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);
    let pos = 0;

    NProgress.start();
    NProgress.set(0,4);
    seActivityBigDataR.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        let axisGroup = '';
        let group_x = eventData.group;
        let in_x = eventData.inCount;
        let limit_x = eventData.limitCount;
        let out_x = eventData.outCount;
        let last = eventData.isLast;

        if (!last) {
            switch (group) {
                case "BY_DAY":
                    axisGroup = group_x.substr(group_x.length -5,group_x.length);
                    break;
                case "BY_WEEK":
                    axisGroup = group_x.substr(group_x.length -2,group_x.length);
                    break;
                case "BY_MONTH":
                    month = new Date(group_x+'-'+'01');
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

            document.getElementById("totalVisits_r").innerHTML = Intl.NumberFormat().format(deviceBigDataR[pos]);
            document.getElementById("inVisits_r").innerHTML = Intl.NumberFormat().format(in_x);
            document.getElementById("limitVisits_r").innerHTML = Intl.NumberFormat().format(limit_x);
            document.getElementById("outVisits_r").innerHTML = Intl.NumberFormat().format(out_x);

            spChartBigDataR.setOption(optionR);
        } else {
            seActivityBigDataR.close();

            let total_r = 0;
            let in_r = 0;
            let limit_r = 0;
            let out_r = 0;
            for (let i = 0, len = deviceBigDataR.length; i < len; i++) {
                total_r += deviceBigDataR[i];
                in_r += inBigDataR[i];
                limit_r += limitBigDataR[i];
                out_r += outBigDataR[i];
                document.getElementById("totalVisits_r").innerHTML = Intl.NumberFormat().format(total_r);
                document.getElementById("inVisits_r").innerHTML = Intl.NumberFormat().format(in_r);
                document.getElementById("limitVisits_r").innerHTML = Intl.NumberFormat().format(limit_r);
                document.getElementById("outVisits_r").innerHTML = Intl.NumberFormat().format(out_r);
            }
            NProgress.done();
        }
    }
}

function countRegisteredBigDataR(dateS, dateE, country, state, city, zipcode, spot, ageS, ageE, sex, zipcodes, member) {

    let request = {
        option       : 'com_ajax',
        module       : 'spactivitybigdata',  // to target: mod_spactivitybigdata
        method       : 'getUsersRegistered',  // to target: function getUsersRegisteredAjax in class ModSPDevRegisteredBigDataHelper
        format       : 'json',
        data         : { "dateStart": dateS, "dateEnd": dateE,
            "countryId": country, "stateId": state, "cityId": city, "zipcodeId": zipcode,
            "spotId": spot,
            "ageStart": ageS, "ageEnd": ageE, "gender": sex, "zipCode": zipcodes, "memberShip": member
        }
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let data = response.data;
            document.getElementById("registeredbigdata_r").innerHTML = Intl.NumberFormat().format(data);
        });
}

function evtSourceAvgTimeBigDataR(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, inDevices, exDevices, brands, status, presence, ageS, ageE, sex,
                                  zipcodes, member, userTZ, group) {

    seAvgTimeBigDataR = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/v2/average-presence?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zoneId="+zone+"%26includedDevices="+inDevices+"%26excludedDevices="+exDevices+
        "%26brands="+encodeURIComponent(brands)+"%26status="+status+"%26presence="+presence+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);

    seAvgTimeBigDataR.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        avgtimeBigDataR = eventData.value;
        avgtimeBigDataR = parseInt(avgtimeBigDataR);
        let last = eventData.isLast;

        if (avgtimeBigDataR > 0) {
            gettime2str(avgtimeBigDataR, 'r');
        }
        if (last) {
            seAvgTimeBigDataR.close();
        }
    }
}

function evtSourceUniqueBigDataR(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, inDevices, exDevices, brands, status, presence, ageS, ageE, sex,
                                 zipcodes, member, userTZ, group) {
    seUniqueBigDataR = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/v2/count-unique-devices?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zoneId="+zone+"%26includedDevices="+inDevices+"%26excludedDevices="+exDevices+
        "%26brands="+encodeURIComponent(brands)+"%26status="+status+"%26presence="+presence+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);

    seUniqueBigDataR.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        devUniqueBigDataR = eventData.count;
        let last = eventData.isLast;

        if (devUniqueBigDataR > 0) {
            document.getElementById("totalvisitorsbigdata_r").innerHTML = Intl.NumberFormat().format(devUniqueBigDataR);
        }
        if (last) {
            seUniqueBigDataR.close();
        }
    }
}

function evtSourceActivityBigDataC(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, inDevices, exDevices, brands, status, presence, ageS, ageE, sex,
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
            let d1 = new Date(dateS);
            let d2 = new Date(dateE);
            let days = Math.round((d2 - d1) / (1000 * 3600 * 24));
            for (let i=0; i<=days; i++) {
                let month = '' + (d1.getMonth() + 1);
                let day = '' + d1.getDate();
                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day =  '0' + day;
                axisBigDataC[i] = [month, day].join('-');
                inBigDataC[i] = 0;
                limitBigDataC[i] = 0;
                outBigDataC[i] = 0;
                deviceBigDataC[i] = 0;
                d1 = new Date(d1.setDate(d1.getDate() + 1));
            }
            break;
        case "BY_WEEK":
            let dw1 = new Date(dateS);
            let dw2 = new Date(dateE);
            let weeks = Math.round((dw2 - dw1) / (1000 * 3600 * 24 * 7));
            let week = dw1.getWeek();
            let weekYear = weeksInYear(dw1.getFullYear());
            let newWeek = 0;
            for (let i=0; i<=weeks; i++) {
                inBigDataC[i] = 0;
                limitBigDataC[i] = 0;
                outBigDataC[i] = 0;
                deviceBigDataC[i] = 0;
                if (week > weekYear) {
                    newWeek = week - weekYear;
                } else {
                    newWeek = week;
                }
                axisBigDataC[i] = newWeek.toString();
                if (newWeek < 10) {
                    axisBigDataC[i] = '0' + newWeek.toString();
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

    seActivityBigDataC = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/v2/find-bigdata?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zoneId="+zone+"%26includedDevices="+inDevices+"%26excludedDevices="+exDevices+
        "%26brands="+encodeURIComponent(brands)+"%26status="+status+"%26presence="+presence+
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

        if (!last) {
            switch (group) {
                case "BY_DAY":
                    axisGroup = group_x.substr(group_x.length -5,group_x.length);
                    break;
                case "BY_WEEK":
                    axisGroup = group_x.substr(group_x.length -2,group_x.length);
                    break;
                case "BY_MONTH":
                    month = new Date(group_x+'-'+'01');
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

            document.getElementById("totalVisits_c").innerHTML = Intl.NumberFormat().format(deviceBigDataC[pos]);
            document.getElementById("inVisits_c").innerHTML = Intl.NumberFormat().format(in_x);
            document.getElementById("limitVisits_c").innerHTML = Intl.NumberFormat().format(limit_x);
            document.getElementById("outVisits_c").innerHTML = Intl.NumberFormat().format(out_x);

            spChartBigDataC.setOption(optionC);
        } else {
            seActivityBigDataC.close();

            let total_c = 0;
            let in_c = 0;
            let limit_c = 0;
            let out_c = 0;
            for (let i = 0, len = deviceBigDataC.length; i < len; i++) {
                total_c += deviceBigDataC[i];
                in_c += inBigDataC[i];
                limit_c += limitBigDataC[i];
                out_c += outBigDataC[i];
                document.getElementById("totalVisits_c").innerHTML = Intl.NumberFormat().format(total_c);
                document.getElementById("inVisits_c").innerHTML = Intl.NumberFormat().format(in_c);
                document.getElementById("limitVisits_c").innerHTML = Intl.NumberFormat().format(limit_c);
                document.getElementById("outVisits_c").innerHTML = Intl.NumberFormat().format(out_c);
            }
        }
    }
}

function evtSourceUniqueBigDataC(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, inDevices, exDevices, brands, status, presence, ageS, ageE, sex,
                                 zipcodes, member, userTZ, group) {
    seUniqueBigDataC = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/v2/count-unique-devices?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zoneId="+zone+"%26includedDevices="+inDevices+"%26excludedDevices="+exDevices+
        "%26brands="+encodeURIComponent(brands)+"%26status="+status+"%26presence="+presence+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);

    seUniqueBigDataC.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        devUniqueBigDataC = eventData.count;
        let last = eventData.isLast;

        if (devUniqueBigDataC > 0) {
            document.getElementById("totalvisitorsbigdata_c").innerHTML = Intl.NumberFormat().format(devUniqueBigDataC);
        }
        if (last) {
            seUniqueBigDataC.close();
        }
    }
}

function countRegisteredBigDataC(dateS, dateE, country, state, city, zipcode, spot, ageS, ageE, sex, zipcodes, member) {

    let request = {
        option       : 'com_ajax',
        module       : 'spactivitybigdata',  // to target: mod_spactivitybigdata
        method       : 'getUsersRegistered',  // to target: function getUsersRegisteredAjax in class ModSPDevRegisteredBigDataHelper
        format       : 'json',
        data         : { "dateStart": dateS, "dateEnd": dateE,
            "countryId": country, "stateId": state, "cityId": city, "zipcodeId": zipcode,
            "spotId": spot,
            "ageStart": ageS, "ageEnd": ageE, "gender": sex, "zipCode": zipcodes, "memberShip": member
        }
    };
    $.ajax({
        method: 'GET',
        data: request
    })
        .success(function(response){
            let data = response.data;
            document.getElementById("registeredbigdata_c").innerHTML = Intl.NumberFormat().format(data);
        });
}

function evtSourceAvgTimeBigDataC(dateS, dateE, timeS, timeE, country, state, city, zipcode, spot, sensor, zone, inDevices, exDevices, brands, status, presence, ageS, ageE, sex,
                                  zipcodes, member, userTZ, group) {

    seAvgTimeBigDataC = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/bigdata/v2/average-presence?"+
        "timezone="+userTZ+"%26startDate="+dateS+"%26endDate="+dateE+"%26startTime="+timeS+"%26endTime="+timeE+
        "%26countryId="+country+"%26stateId="+state+"%26cityId="+city+"%26zipcodeId="+zipcode+
        "%26spotId="+spot+"%26sensorId="+sensor+"%26zoneId="+zone+"%26includedDevices="+inDevices+"%26excludedDevices="+exDevices+
        "%26brands="+encodeURIComponent(brands)+"%26status="+status+"%26presence="+presence+
        "%26ageStart="+ageS+"%26ageEnd="+ageE+"%26gender="+sex+"%26zipCode="+zipcodes+"%26memberShip="+member+"%26groupBy="+group);

    seAvgTimeBigDataC.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        avgtimeBigDataC = eventData.value;
        avgtimeBigDataC = parseInt(avgtimeBigDataC);
        let last = eventData.isLast;

        if (avgtimeBigDataC > 0) {
            gettime2str(avgtimeBigDataC, 'c');
        }
        if (last) {
            seAvgTimeBigDataC.close();
        }
    }
}
