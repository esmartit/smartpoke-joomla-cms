$(document).ready( function() {

    if (typeof (Gauge) === 'undefined') { return; }

    let option = {
        lines: 12,
        angle: 0,
        lineWidth: 0.25,
        pointer: {
            length: 0.75,
            strokeWidth: 0.042,
            color: '#1D212A'
        },
        limitMax: 'false',
        colorStart: '#8abfb5',
        colorStop: '#1ABC9C',
        strokeColor: '#F0F3F3',
        generateGradient: true
    };

    let userTimeZone = document.getElementById('userTimeZone').innerText;
    let seDailyGoalReg = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/daily-registered-count?timezone="+userTimeZone);
    let dailyGoalReg = 0;
    let dailyGoalRegMaxValue = document.getElementById('dailygoalRegMaxValue').innerText;

    if ($('#chart_gauge_dailygoal_reg').length) {
        var chart_gauge_reg = document.getElementById('chart_gauge_dailygoal_reg'); // your canvas element
        var chart_gauge_dailygoal_reg = new Gauge(chart_gauge_reg).setOptions(option); // create sexy gauge!
    }

    if ($('#gauge-text-reg').length) {
        chart_gauge_dailygoal_reg.setTextField(document.getElementById("gauge-text-reg"));
        chart_gauge_dailygoal_reg.animationSpeed = 32; // set animation speed (32 is default value)
        chart_gauge_dailygoal_reg.maxValue = dailyGoalRegMaxValue;
        chart_gauge_dailygoal_reg.set(dailyGoalReg);
    }

    seDailyGoalReg.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        dailyGoalReg = eventData.count;

        if ($('#gauge-text-reg').length) {
            chart_gauge_dailygoal_reg.setTextField(document.getElementById("gauge-text-reg"));
            chart_gauge_dailygoal_reg.animationSpeed = 32; // set animation speed (32 is default value)
            chart_gauge_dailygoal_reg.maxValue = dailyGoalRegMaxValue;

            if (dailyGoalReg > dailyGoalRegMaxValue) {
                chart_gauge_dailygoal_reg.maxValue = dailyGoalReg
                chart_gauge_dailygoal_reg.set(dailyGoalReg);
            } else {
                if (dailyGoalReg == 0) {
                    chart_gauge_dailygoal_reg.set(0.001);
                } else {
                    chart_gauge_dailygoal_reg.set(dailyGoalReg);
                }

            }

        }
        // console.log('Date', dailyGoalReg, dailyGoalRegMaxValue);

    }

});