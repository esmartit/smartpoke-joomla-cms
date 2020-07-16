$(document).ready( function() {

    if (typeof (Gauge) === 'undefined') { return; }

    var option = {
        lines: 12,
        angle: 0,
        lineWidth: 0.4,
        pointer: {
            length: 0.75,
            strokeWidth: 0.042,
            color: '#1D212A'
        },
        limitMax: 'true',
        colorStart: '#1ABC9C',
        colorStop: '#1ABC9C',
        strokeColor: '#F0F3F3',
        generateGradient: true
    };

    let userTimeZone = document.getElementById('userTimeZone').innerText;
    const seDailyGoalReg = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/daily-registered-count?timezone="+userTimeZone);
    let currentMax = 0;
    let dailyGoalReg = 0;
    let currentDate = new Date();
    let dailyGoalRegMaxValue = document.getElementById('dailygoalRegMaxValue').innerText;

    if ($('#chart_gauge_dailygoal_reg').length) {
        var chart_gauge_reg = document.getElementById('chart_gauge_dailygoal_reg'); // your canvas element
        var chart_gauge_dailygoal_reg = new Gauge(chart_gauge_reg).setOptions(option); // create sexy gauge!
    }
    dailygoal_reg = 0;
    if ($('#gauge-text-reg').length) {
        chart_gauge_dailygoal_reg.setTextField(document.getElementById("gauge-text-reg"));
        chart_gauge_dailygoal_reg.animationSpeed = 32; // set animation speed (32 is default value)
        chart_gauge_dailygoal_reg.maxValue = dailyGoalRegMaxValue;
        chart_gauge_dailygoal_reg.set(dailygoal_reg);
    }

    seDailyGoalReg.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        dailyGoalReg = eventData.count;
        let today = new Date(eventData.time);
        let sameDate = (currentDate.getDate() === today.getUTCDate());

        if ($('#goal-text-reg').length) {
            chart_gauge_dailygoal_reg.setTextField(document.getElementById("goal-text-reg"));
            chart_gauge_dailygoal_reg.animationSpeed = 32; // set animation speed (32 is default value)
            chart_gauge_dailygoal_reg.maxValue = dailyGoalRegMaxValue;

            if (sameDate) {
                if (dailyGoalReg > currentMax) {
                    chart_gauge_dailygoal_reg.set(dailyGoalReg);
                    currentMax = dailyGoalReg;
                }
            }
        }
        // console.log('Date', dailygoal, currentMax);
    }

});