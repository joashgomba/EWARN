<script src="http://code.highcharts.com/highcharts.js"></script>
<div id="buttons"></div>
<hr/>
<div id="JSFiddle">
 <!-- Insert your document here -->
    <header style="display:none;margin-top:20px;"><p>Add your header</p></header>     
    <footer style="display:none"><p>Add your header</p></footer>  
    <div id="container1" style="height: 200px; width:700px"></div>
    <div style="page-break-before:always;">
        <div id="container2" style="height: 200px;  width:700px"></div>
    </div>
 </div>
 <script>
 /**
 * Create a global getSVG method that takes an array of charts as an argument
 */
Highcharts.getSVG = function(charts) {
    var svgArr = [],
        top = 0,
        width = 0;

    $.each(charts, function(i, chart) {
        var svg = chart.getSVG();
        svg = svg.replace('<svg', '<g transform="translate(0,' + top + ')" ');
        svg = svg.replace('</svg>', '</g>');

        top += chart.chartHeight;
        width = Math.max(width, chart.chartWidth);

        svgArr.push(svg);
    });

    return '<svg height="'+ top +'" width="' + width + '" version="1.1" xmlns="http://www.w3.org/2000/svg">' + svgArr.join('') + '</svg>';
};

/**
 * Create a global exportCharts method that takes an array of charts as an argument,
 * and exporting options as the second argument
 */
Highcharts.exportCharts = function(charts, options) {
    var form
        svg = Highcharts.getSVG(charts);

    // merge the options
    options = Highcharts.merge(Highcharts.getOptions().exporting, options);

    // create the form
    form = Highcharts.createElement('form', {
        method: 'post',
        action: options.url
    }, {
        display: 'none'
    }, document.body);

    // add the values
    Highcharts.each(['filename', 'type', 'width', 'svg'], function(name) {
        Highcharts.createElement('input', {
            type: 'hidden',
            name: name,
            value: {
                filename: options.filename || 'chart',
                type: options.type,
                width: options.width,
                svg: svg
            }[name]
        }, null, form);
    });
    //console.log(svg); return;
    // submit
    form.submit();

    // clean up
    form.parentNode.removeChild(form);
};

var chart1 = new Highcharts.Chart({

    chart: {
        renderTo: 'container1'
    },

    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },

    series: [{
        data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]}]

});

var chart2 = new Highcharts.Chart({

    chart: {
        renderTo: 'container2',
        type: 'column'
    },

    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },

    series: [{
        data: [176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4, 29.9, 71.5, 106.4, 129.2, 144.0]}]

});



<!-- PDF, Postscript and XPS are set to download as Fiddle (and some browsers) will not embed them -->

var click="return xepOnline.Formatter.Format('JSFiddle', {render:'download'})";
jQuery('#buttons').append('<button onclick="'+ click +'">PDF</button>');

click="return xepOnline.Formatter.Format('JSFiddle', {render:'download', mimeType:'application/postscript'})";
jQuery('#buttons').append('<button onclick="'+ click +'">Postscript</button>');

click="return xepOnline.Formatter.Format('JSFiddle', {render:'download', mimeType:'application/vnd.ms-xpsdocument'})";
jQuery('#buttons').append('<button onclick="'+ click +'">XPS</button>');

<!-- SVG and all image formats will embed right into the result pane over your content -->

click="return xepOnline.Formatter.Format('JSFiddle', {render:'embed', mimeType:'image/svg+xml'})";
jQuery('#buttons').append('<button onclick="'+ click +'">SVG</button>');

click="return xepOnline.Formatter.Format('JSFiddle', {render:'embed', mimeType:'image/png'})";
jQuery('#buttons').append('<button onclick="'+ click +'">PNG @120dpi</button>');

click="return xepOnline.Formatter.Format('JSFiddle', {render:'embed', mimeType:'image/jpg', resolution:'60'})";
jQuery('#buttons').append('<button onclick="'+ click +'">JPG @60dpi</button>');

click="return xepOnline.Formatter.Format('JSFiddle', {render:'embed', mimeType:'image/gif', resolution:'30'})";
jQuery('#buttons').append('<button onclick="'+ click +'">GIF @30dpi</button>');
 
 </script>