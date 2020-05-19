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

    let dailygoalRegMaxValue = document.getElementById('dailygoalRegMaxValue').innerText;

    if ($('#chart_gauge_dailygoal_reg').length) {
        var chart_gauge_reg = document.getElementById('chart_gauge_dailygoal_reg'); // your canvas element
        var chart_gauge_dailygoal_reg = new Gauge(chart_gauge_reg).setOptions(option); // create sexy gauge!
    }
    dailygoal_reg = 0;
    if ($('#gauge-text-reg').length) {
        chart_gauge_dailygoal_reg.setTextField(document.getElementById("gauge-text-reg"));
        chart_gauge_dailygoal_reg.animationSpeed = 32; // set animation speed (32 is default value)
        chart_gauge_dailygoal_reg.maxValue = dailygoalRegMaxValue;
        chart_gauge_dailygoal_reg.set(dailygoal_reg);
    }

    setInterval(function () {
        if ($('#gauge-text-reg').length) {
            dailygoal_reg += (Math.random() * 5).toFixed(2) - 0;
            chart_gauge_dailygoal_reg.setTextField(document.getElementById("gauge-text-reg"));
            chart_gauge_dailygoal_reg.maxValue = dailygoalRegMaxValue;
            chart_gauge_dailygoal_reg.set(dailygoal_reg);
        }
    },4500);

});