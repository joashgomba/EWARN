<!-- Dependencies -->
<script src="//a----.github.io/highcharts-export-clientside/bower_components/jquery/dist/jquery.min.js"></script>
<script src="//a----.github.io/highcharts-export-clientside/bower_components/highcharts/highcharts.js"></script>
<script src="//a----.github.io/highcharts-export-clientside/bower_components/highcharts/modules/exporting.js"></script>
<script src="//a----.github.io/highcharts-export-clientside/bower_components/highcharts/modules/canvas-tools.js"></script>
<script src="//a----.github.io/highcharts-export-clientside/bower_components/export-csv/export-csv.js"></script>
<script type="application/javascript" src="//a----.github.io/highcharts-export-clientside/bower_components/jspdf/dist/jspdf.min.js"></script>

<!-- Export Client-Side module -->
<script src="//a----.github.io/highcharts-export-clientside/bower_components/highcharts-export-clientside/highcharts-export-clientside.js"></script>

<!-- HighCharts container -->
<div class="highcharts-container" id="example-1"></div>

<!-- Buttons -->
<div>
    <p>Programmatically-defined buttons:</p>
    
    <div class=" chart-export" data-chart-selector="#example-1">
        <button type="button" class="btn btn-default" data-type="image/svg+xml">SVG</button>
        <button type="button" class="btn btn-default" data-type="image/png">PNG</button>
        <button type="button" class="btn btn-default" data-type="image/jpeg">JPEG</button>
        <button type="button" class="btn btn-default" data-type="application/pdf">PDF</button>
        <button type="button" class="btn btn-default" data-type="text/csv">CSV</button>
        <button type="button" class="btn btn-default" data-type="application/vnd.ms-excel">XLS</button>
    </div>
</div>

<script>

// Defining the chart
$('#example-1').highcharts({
  title: {
    text: 'Monthly Average Temperature',
    x: -20 //center
  },
  subtitle: {
    text: 'Source: WorldClimate.com',
    x: -20
  },
  xAxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
    ]
  },
  yAxis: {
    title: {
      text: 'Temperature (°C)'
    },
    plotLines: [{
      value: 0,
      width: 1,
      color: '#808080'
    }]
  },
  tooltip: {
    valueSuffix: '°C'
  },
  legend: {
    layout: 'vertical',
    align: 'right',
    verticalAlign: 'middle',
    borderWidth: 0
  },
  series: [{
    name: 'Tokyo',
    data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
  }, {
    name: 'New York',
    data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
  }, {
    name: 'Berlin',
    data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
  }, {
    name: 'London',
    data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
  }]
});


// Programmatically-defined buttons
$(".chart-export").each(function() {
  var jThis = $(this),
      chartSelector = jThis.data("chartSelector"),
      chart = $(chartSelector).highcharts();

  $("*[data-type]", this).each(function() {
    var jThis = $(this),
        type = jThis.data("type");
    if(Highcharts.exporting.supports(type)) {
      jThis.click(function() {
        chart.exportChartLocal({ type: type });
      });
    }
    else {
      jThis.attr("disabled", "disabled");
    }
  });
});


</script>