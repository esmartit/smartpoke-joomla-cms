$(document).ready(function () {
    var sample_data =
        {
            "29":10101,
            "09":11292,
            "14":12383,
            "45":13474,
            "10":14565,
            "50":15656,
            "08":16747,
            "28":17838,
            "43":18929,
            "11":19010,
            "24":20101,
            "18":21292,
            "31":22383,
            "41":23474,
            "21":24565,
            "04":25656
        }

    $('#vmap_spain').vectorMap({
        map: 'spain_en',
        backgroundColor: '#ffffff',
        color: '#ffffff',
        hoverOpacity: 0.7,
        selectedColor: '#34495E',
        enableZoom: true,
        showTooltip: true,
        values: sample_data,
        scaleColors: ['#E6F2F0', '#149B7E'],
        normalizeFunction: 'polynomial',
        hoverColor: true
    });
});
