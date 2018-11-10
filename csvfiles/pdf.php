<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<style>
.container {
	max-width: 600px;
	min-width: 320px;
	margin: 0 auto;
}
#buttonrow {
	max-width: 600px;
	min-width: 320px;
	margin: 0 auto;
}
</style>

<div id="ubercontainer">

</div>

<div id="buttonrow">
	<button id="export-png">Export to PNG</button>
	<button id="export-pdf">Export to PDF</button>
</div>

<script>
$(function () {
    /**
     * Create a global getSVG method that takes an array of charts as an
     * argument
     */
    Highcharts.getSVG = function (charts) {
        var svgArr = [],
            top = 0,
            width = 0;

        Highcharts.each(charts, function (chart) {
            var svg = chart.getSVG();
            svg = svg.replace(
                '<svg',
                '<g transform="translate(0,' + top + ')" '
            );
            svg = svg.replace('</svg>', '</g>');

            top += chart.chartHeight;
            width = Math.max(width, chart.chartWidth);

            svgArr.push(svg);
        });

        return '<svg height="' + top + '" width="' + width +
            '" version="1.1" xmlns="http://www.w3.org/2000/svg">' +
            svgArr.join('') + '</svg>';
    };

    /**
     * Create a global exportCharts method that takes an array of charts as an
     * argument, and exporting options as the second argument
     */
    Highcharts.exportCharts = function (charts, options) {

        // Merge the options
        options = Highcharts.merge(Highcharts.getOptions().exporting, options);

        // Post to export server
        Highcharts.post(options.url, {
            filename: options.filename || 'chart',
            type: options.type,
            width: options.width,
            svg: Highcharts.getSVG(charts)
        });
    };

	var n = 16,
    	container
    for (var i = 0; i < n; i++) {
        container = document.createElement('div');
        container.className = 'container';
        document.getElementById('ubercontainer').appendChild(container);
        Highcharts.chart(container, {

            chart: {
                height: 200
            },

            title: {
                text: 'Chart' + i
            },

            credits: {
                enabled: false
            },

            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },

            series: [{
                data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0,
                    135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
                showInLegend: false
            }],

            exporting: {
                enabled: false // hide button
            }

        });
    }
    
    $('#export-png').click(function () {
        Highcharts.exportCharts(Highcharts.charts);
    });

    $('#export-pdf').click(function () {
        Highcharts.exportCharts(Highcharts.charts, {
            type: 'application/pdf'
        });
    });
});

</script>