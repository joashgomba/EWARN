<button id="export">export</button>
<div id="chart_exchange" style="width: 450px; height: 400px; margin: 0 auto"></div>
<canvas id="chart_exchange_canvas" width="900" height="800"></canvas>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.27/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.27/vfs_fonts.js"></script>
<script>
$('#export').click(function() {
  drawInlineSVG($('#chart_exchange').highcharts().getSVG(), "chart_exchange_canvas", function(chart_exchange) {
	console.log(chart_exchange);
	build_pdf(chart_exchange);
  });
});

function build_pdf(chart_exchange) {
	//var docDefinition = { image: chart_exchange };
	var docDefinition = {
		content: [
			{text: 'World Hello!' },
			{ image: chart_exchange, width: 600 },
		]
	};
	pdfMake.createPdf(docDefinition).download('pdfName.pdf');
}


function drawInlineSVG(svgElement, canvas_id, callback) {
  var can = document.getElementById(canvas_id);
  var ctx = can.getContext('2d');

  var img = new Image();
  img.setAttribute('src', 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgElement))));
  img.onload = function() {
    ctx.drawImage(img, 0, 0);
    callback(can.toDataURL("image/png"));
  }
}


//chart
$.getJSON('https://www.highcharts.com/samples/data/jsonp.php?filename=usdeur.json&callback=?', function(data) {

  Highcharts.chart('chart_exchange', {
    chart: {
      zoomType: 'x'
    },
    title: {
      text: 'USD to EUR exchange rate over time'
    },
    subtitle: {
      text: document.ontouchstart === undefined ?
        'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
    },
    xAxis: {
      type: 'datetime'
    },
    yAxis: {
      title: {
        text: 'Exchange rate'
      }
    },
    legend: {
      enabled: false
    },
    plotOptions: {
      area: {
        fillColor: {
          linearGradient: {
            x1: 0,
            y1: 0,
            x2: 0,
            y2: 1
          },
          stops: [
            [0, Highcharts.getOptions().colors[0]],
            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
          ]
        },
        marker: {
          radius: 2
        },
        lineWidth: 1,
        states: {
          hover: {
            lineWidth: 1
          }
        },
        threshold: null
      }
    },

    series: [{
      type: 'area',
      name: 'USD to EUR',
      data: data
    }]
  });
});
</script>