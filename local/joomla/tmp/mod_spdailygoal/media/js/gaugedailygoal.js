$(document).ready( function() {

    if (typeof (Gauge) === 'undefined') { return; }

    console.log('init_gauge [' + $('.gauge-chart').length + ']');
    console.log('init_gauge');

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
        colorStart: '#3498db',
        colorStop: '#3498db',
        strokeColor: '#F0F3F3',
        generateGradient: true
    };

    let userTimeZone = document.getElementById('userTimeZone').innerText;
    let seDailyGoal = new EventSource("/index.php?option=com_spserverevent&format=json&base_url=ms_data&resource_path=/sensor-activity/today-detected-count?timezone="+userTimeZone);
    let currentMax = 0;
    let dailyGoal = 0;
    let currentDate = new Date();
    let dailyGoalMaxValue = document.getElementById('dailygoalMaxValue').innerText;

    if ($('#chart_gauge_dailygoal').length) {
        var chart_gauge = document.getElementById('chart_gauge_dailygoal'); // your canvas element
        var chart_gauge_dailygoal = new Gauge(chart_gauge).setOptions(option); // create sexy gauge!
    }

    if ($('#gauge-text').length) {
        chart_gauge_dailygoal.setTextField(document.getElementById("gauge-text"));
        chart_gauge_dailygoal.animationSpeed = 32; // set animation speed (32 is default value)
        chart_gauge_dailygoal.maxValue = dailyGoalMaxValue;
        chart_gauge_dailygoal.set(dailyGoal);
    }

    seDailyGoal.onmessage = function (event) {
        let eventData = JSON.parse(event.data);
        dailyGoal = eventData.count;
        let today = new Date(eventData.time);
        let sameDate = (currentDate.getDate() === today.getDate());

        if ($('#gauge-text').length) {
            chart_gauge_dailygoal.setTextField(document.getElementById("gauge-text"));
            chart_gauge_dailygoal.animationSpeed = 32; // set animation speed (32 is default value)
            chart_gauge_dailygoal.maxValue = dailyGoalMaxValue;

            if (sameDate) {
                if (dailyGoal > currentMax) {
                    chart_gauge_dailygoal.set(dailyGoal);
                    currentMax = dailyGoal;
                }
            }
        }
        // console.log('Date', dailygoal, currentMax);
    }
});