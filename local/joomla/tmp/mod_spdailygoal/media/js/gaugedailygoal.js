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
        maxValue: 6000,
        minValue: 0,
        limitMax: 'true',
        colorStart: '#3498db',
        colorStop: '#3498db',
        strokeColor: '#F0F3F3',
        generateGradient: true
    };

    if ($('#chart_gauge_dailygoal').length) {
        var chart_gauge = document.getElementById('chart_gauge_dailygoal'); // your canvas element
        var chart_gauge_dailygoal = new Gauge(chart_gauge).setOptions(option); // create sexy gauge!
    }
    dailygoal = 0;
    if ($('#gauge-text').length) {
        chart_gauge_dailygoal.maxValue = 6000;
        chart_gauge_dailygoal.animationSpeed = 32; // set animation speed (32 is default value)
        chart_gauge_dailygoal.set(dailygoal);
        chart_gauge_dailygoal.setTextField(document.getElementById("gauge-text"));
    }

    setInterval(function () {
        if ($('#gauge-text').length) {
            dailygoal += (Math.random() * 10).toFixed(2) - 0;
            chart_gauge_dailygoal.set(dailygoal);
            chart_gauge_dailygoal.setTextField(document.getElementById("gauge-text"));
        }
    },3500);

});