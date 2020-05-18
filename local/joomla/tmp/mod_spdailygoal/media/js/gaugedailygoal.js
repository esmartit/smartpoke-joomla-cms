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

    const sourceEvt = new EventSource("index.php?option=com_spserverevent&format=json&resource_path=/sensor-activity/daily-unique-devices-detected-count");
    let currentMax = 0;
    let dailygoal = 0;

    if ($('#chart_gauge_dailygoal').length) {
        var chart_gauge = document.getElementById('chart_gauge_dailygoal'); // your canvas element
        var chart_gauge_dailygoal = new Gauge(chart_gauge).setOptions(option); // create sexy gauge!
    }

    if ($('#gauge-text').length) {
        chart_gauge_dailygoal.setTextField(document.getElementById("gauge-text"));
        chart_gauge_dailygoal.animationSpeed = 32; // set animation speed (32 is default value)
        chart_gauge_dailygoal.maxValue = 6000;
        chart_gauge_dailygoal.set(dailygoal);
    }

    sourceEvt.onmessage = function (event) {
        dailygoal = JSON.parse(event.data).count;

        if ($('#gauge-text').length) {
            chart_gauge_dailygoal.setTextField(document.getElementById("gauge-text"));
            chart_gauge_dailygoal.animationSpeed = 32; // set animation speed (32 is default value)
            chart_gauge_dailygoal.maxValue = 6000;

            if (dailygoal > currentMax) {
                chart_gauge_dailygoal.set(dailygoal);
                currentMax = dailygoal;
            }
        }
        // console.log('Date', dailygoal, currentMax);
    }




});