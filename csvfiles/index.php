<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />


<title>jQuery Highcharts</title>

<link href="css/css.css" rel="stylesheet" type="text/css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>

<script src="js/highcharts.js" type="text/javascript"></script>
<script src="js/modules/exporting.js" type="text/javascript"></script>
<script src="js/jquery.json-2.3.min.js" type="text/javascript"></script>
<script>
var charts;


$(document).ready(function() {
  
  $('#pdf').click(function(){
    getDocument('pdf');
  });
  
  $('#doc').click(function(){
    getDocument('doc');
  });
  
  
  /*BUILD PAGE FROM XML*/
  $.ajax({
    type: 'GET',
    url: 'data.xml',
    dataType : 'xml',
    success: function(data) {
      charts=new Array();
      // Iterate over the lines and add categories or series
      $(data).find('chart').each(function(id) {
        var chart, title, subtitle, containerChart, renderTo;
        
        var options = {
          chart: {renderTo: ''},
          title: null,
          subtitle: null,
          tooltip: {
            formatter: function() {
              return '<b>' + this.point.name + '</b>: ' + this.percentage + ' %';
            }
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: true,
                formatter: function() {
                  return '<b>' + this.point.name + '</b>: ' + this.percentage + ' %';
                }
              },
              showInLegend: true,
              events: {
                click: function(e) {
                    window.open(e.point.url);
                }
              }
            }
          },
          navigation: {
            buttonOptions: true
          },
          series: [],
          navigation: {
            buttonOptions: {
              enabled: false
            }
          },
          exporting: {
            type: 'image/jpeg',
            url:'http://localhost:81/edews/csvfiles/exporting-server/'
          },
          credits: {
            enabled: false
          }
        };
        
        containerChart = 'containerChart-'+id;
        renderTo = 'chart-'+id;
        
        
        $('#container').append('<div class="chart" id="' + containerChart + '"></div>');
        $('#'+containerChart)
          .append('<h2 class="title">'+$(this).find('title').text()+'</h2>')
          .append('<div id="' + renderTo + '"></div>')
          .append('<div class="text">'+$(this).find('text').text()+'</div');
        
        options.chart.renderTo = renderTo;
        
        $(this).find('series').each(function() {
          var serie = new Object();
          serie.type = $(this).find('type').text();
          serie.name = $(this).find('name').text();         
          serie.data = new Array();
          
          $(this).find('data').each(function() {
            var categorie = $(this).find('categorie').text();
            var point = parseFloat($(this).find('point').text());
            var url=$(this).find('url').text();
            var item = {
              name: categorie,
              y: point,
              url:url
            };
            
            
            serie.data.push(item);
          });
          
          options.series.push(serie);
        });
        
        // Create the chart
        chart = new Highcharts.Chart(options);
        /*ADD CHART DATA TO ARRAY, getSVG for exporting*/
        charts.push({title:$(this).find('title').text(),text:$(this).find('text').text(),svg:chart.getSVG()})
        
        // button handler
        /*$('#' + containerChart).append('<button id="button-' + id + '">Download chart</button>');
        $('#button-' + id).click(function() {
          chart.exportChart();
        });*/
      });
    }
  });
});


function getDocument(type){
  
  var title='title';
  var header='header';
  var footer='footer';
  
  
  var json={
    'type':type, 
    'title':title,
    'header':header,
    'footer':footer,
    'data': $.toJSON(charts)
  };
  //console.log(json);
  /*$.ajax
    ({
        type: 'POST',
        url: 'docgen.php',
        data: json,
        success: function (response) {
          console.log(response);
        }
    });*/
  /*TRICK CLIENT INTO DOWNLOAD FILE WITH jQUery*/
  download('docgen.php',json,'POST');
}

function download(url, data, method){
  //url and data options required
  if( url && data ){ 
    //data can be string of parameters or array/object
    data = typeof data == 'string' ? data : jQuery.param(data);
    //split params into form inputs
    var inputs = '';
    jQuery.each(data.split('&'), function(){ 
      var pair = this.split('=');
      inputs+='<input type="hidden" name="'+ pair[0] +'" value="'+ pair[1] +'" />'; 
    });
    //send request
    jQuery('<form action="'+ url +'" method="'+ (method||'post') +'">'+inputs+'</form>')
    .appendTo('body').submit().remove();
  };
};
</script>
</head>

<body>
  <button id="pdf">PDF</button>
  <button id="doc">DOC</button>
  <div id="container" style=""></div>
</body>
</html>