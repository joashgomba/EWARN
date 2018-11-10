<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta name="viewport" content="width=device-width">
<title>Weekly <?php echo $zone->zone;?> Zone Online Bulletin - <?php echo $row->issue_no;?> Epi Week <?php echo $row->week_no;?></title>
<style>
				#lasttable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#lasttable td, #lasttable th 
				{
				font-size:1.0em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#lasttable th 
				{
				font-size:1.0em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#lasttable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				
				
				#listtable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:80%;
				border-collapse:collapse;
				}
				#listtable td, #listtable th 
				{
				font-size:1.0em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#listtable th 
				{
				font-size:1.0em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#listtable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				
				/**/
				#zonlisttable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#zonlisttable td, #zonlisttable th 
				{
				font-size:1.0em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#zonlisttable th 
				{
				font-size:1.0em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#zonlisttable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
                
                 <style>
        #customers
        {
        font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
        width:100%;
        border-collapse:collapse;
        }
        #customers td, #customers th 
        {
        font-size:0.9em;
        border:2px  solid #fff;
        padding:3px 7px 2px 7px;
        }
        #customers th 
        {
        font-size:1.0em;
        text-align:left;
        padding-top:5px;
        padding-bottom:4px;
        background-color:#cccccc;
        color:#fff;
        }
        #customers tr.alt td 
        {
        color:#000;
        background-color:#cccfff;
        }
        </style>
        
        <style>
				#alertstable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#alertstable td, #alertstable th 
				{
				font-size:0.8em;
				border:1px solid #1F7EB8;
				padding:3px 7px 2px 7px;
				}
				#alertstable th 
				{
				font-size:0.8em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#alertstable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
        
         <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui-1.10.3.custom.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/chosen.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-timepicker.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/daterangepicker.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/colorpicker.css" />
        
         <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>media/js/jquery.dataTables.js"></script>
    <style>
    #map-canvas{
      width: 500px;
      height: 360px;
	    padding: 6px;
        border-width: 1px;
        border-style: solid;
        border-color: #ccc #ccc #999 #ccc;
        -webkit-box-shadow: rgba(64, 64, 64, 0.5) 0 2px 5px;
        -moz-box-shadow: rgba(64, 64, 64, 0.5) 0 2px 5px;
        box-shadow: rgba(64, 64, 64, 0.1) 0 2px 5px;
    }
	
	img { max-width:none; }
  </style>
  
<style>
p.mybreak { page-break-before: always; }
</style>
</head>

<body>
<center>
<table width="100%" id="listtable">
<tr><td><img src="<?php echo base_url(); ?>images/header.png" width="1050" height=""></td></tr>
<tr><th><center><?php echo $zone->zone;?>, Issue <?php echo $row->issue_no;?>, Epi Week <?php echo $row->week_no;?>, <?php echo date("d F Y", strtotime($row->period_from)); ?> - <?php echo date("d F Y", strtotime($row->period_to)); ?></center></th></tr>
<tr><td>
<table id="customers">
<tr><td bgcolor="#892A24" width="50%"><font color="#FFFFFF"><strong>Highlights</strong></font></td><td bgcolor="#892A24" width="50%"><font color="#FFFFFF"><strong>Reporting rates vs consultations in <?php echo $zone->zone;?>, Epi Weeks <?php echo $startingweek;?> to <?php echo $row->week_no;?> - <?php echo $row->week_year;?></strong></font></td></tr>
<tr><td valign="top">
<?php echo $static_highlight;?><?php echo $row->highlight;?></td><td valign="top">

<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                zoomType: 'xy'/**,
				events: {
                load: function () {
                    var ch = this;
                    setTimeout(function(){
                        ch.exportChart();
                    },1);
                }
            	}
				**/
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: [{
                categories: [<?php echo $categories;?>]
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    formatter: function() {
                        return this.value +'°%';
                    },
                    style: {
                        color: '#89A54E'
                    }
                },
				gridLineWidth: 0,
				minPadding: 0, 
                maxPadding: 0,
				tickInterval: 50,         
                min: 0, 
                max:100,
                title: {
                    text: 'Percentage',
                    style: {
                        color: '#89A54E'
                    }
                }
            }, { // Secondary yAxis
			 
                title: {
                    text: 'Consultations',
					y: 15,
					min: 0, 
                    max:<?php echo $maxconsultation;?>,
                    style: {
                        color: '#4572A7'
                    }
                },
                labels: {
                    formatter: function() {
                        return this.value +' ';
                    },
                    style: {
                        color: '#4572A7'
                    }
                },
                opposite: true
            }],  credits: {
      enabled: false
  },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.x +': '+ this.y +
                        (this.series.name == 'Consultations' ? ' ' : '%');
                }
            }/**,
            legend: {
                layout: 'vertical',
                align: 'left',
                x: 120,
                verticalAlign: 'top',
                y: 100,
                floating: true,
                backgroundColor: '#FFFFFF'
            }**/,/**
			exporting: { url:'example.com/highcharts/exporting-server/php/php-batik/' }**/
            series: [{
                name: 'Consultations',
                color: '#4572A7',
                type: 'column',
                yAxis: 1,
				min: 0,
                data: [<?php echo $consultationdata;?>]
    
            }, {
				
                name: 'Percentage',
                color: '#89A54E',
                type: 'spline',
                data: [<?php echo $percentagedata;?>]
            }]
        });
    });
    
});
		</script>
     
        <script type="text/javascript">
$(function () {
    $(document).ready(function() {
        var chart = new Highcharts.Chart({
            chart: {
                renderTo: 'distributioncontainer',
                type: 'column'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: [<?php echo $zonecategories;?>]
            },
            yAxis: {
				
				min: 0,
				max: 100,
				tickInterval: 20,
				title: {
                    text: 'No HF Reports %'
                },
                plotLines:[{
                    value:80,
                    color: '#ff0000',
                    width:2,
                    zIndex:4,
                    label:{text:'Target'}
                }]
            }/**,
			 legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 100,
                y: 70,
                floating: true,
                shadow: true
            }**/,  credits: {
      enabled: false
  },
			 labels: {
                    formatter: function() {
                        return this.value +'°%';
                    },
                    style: {
                        color: '#89A54E'
                    }
                },
			tooltip: {
                formatter: function() {
                    return ''+
                        this.x +': '+ this.y +' %';
                }
            },
            series: [{
                name: 'Reporting Rate',
                data: [<?php echo $zonereportingrate;?>]
            }]
        });
    });
    
});

		</script>
        
      <script src="<?php echo base_url(); ?>js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>js/exporting.js"></script>
<div id="container" style="min-width:200px; height: 200px; margin: 0 auto"></div>
<hr />
<p><center>
  <font size="-1" color="#1F7EB8">Reporting Rates by Regions(Epi-week <?php echo $row->week_no;?>, <?php echo $row->week_year;?>)</font>
</center></p>
<div id="distributioncontainer" style="min-width:200px; height: 210px; margin: 0 auto"></div>

</td></tr>
<tr><td bgcolor="#892A24" width="50%"><font color="#FFFFFF"><strong>Leading diseases in <?php echo $zone->zone;?> (Epi week <?php echo $row->week_no;?>)</strong></font></td><td bgcolor="#892A24" width="50%"><font color="#FFFFFF"><strong>Alerts and outbreaks - Epi Week <?php echo $row->week_no;?></strong></font></td></tr>
<tr><td valign="top">
<?php echo $leadingdiseasetext;?>
<?php echo $leadingdiseasetable;?>
</td><td valign="top"><?php //echo $proportionalmorbiditytable;?>

<div id="json_data" style="display:none;">
                     <?php
					
      echo json_encode($points);
					 
					 ?>
                     </div>
                   <div id="map-canvas"></div>
                    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
                   <script src="<?php echo base_url(); ?>js/bulletin_markerclusterer.js"></script>
                   <script src="<?php echo base_url(); ?>js/map.js"></script>

</td></tr>
<tr bgcolor="#892A24">
  <td><font color="#FFFFFF"><strong>Trends for leading priority diseases  Epiweeks <?php echo $row->week_no;?> to <?php echo $previous_week;?>, <?php echo $row->week_year;?></strong></font></td>
  <td><font color="#FFFFFF"><strong>Proportional Morbidity for Leading Priority Diseases - Epi Week <?php echo $row->week_no;?>, <?php echo $row->week_year;?></strong></font></td></tr>

<tr><td>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'trendscontainer',
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: '',
                x: 0 //center
            },
            subtitle: {
                text: '',
                x: 0
            },
            xAxis: {
                categories: [<?php 	echo $categories;?>]
            },
            yAxis: {
				minPadding: 0, 
				maxPadding: 0,         
				min: 0, 
				max:30,
				tickInterval: 10,
                title: {
                    text: 'Percentage (%)'
                },
				
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },  credits: {
      enabled: false
  },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +'%';
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: 0,
                y: 100,
                borderWidth: 0
            },
			
            series: [{
                name: 'DD',
                data: [<?php 	echo $dddata;?>]
            }, {
                name: 'ILI',
                data: [<?php 	echo $ilidata;?>]
            }, {
                name: 'MAL',
                data: [<?php 	echo $maldata;?>]
            }]
        });
    });
    
});
		</script>
        
        <div id="trendscontainer" style="min-width: 300px; height: 220px; margin: 0 auto"></div>
</td><td><script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'propmorbiditycontainer',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: ''
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
            	percentageDecimals: 1
            },  credits: {
      enabled: false
  },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(1) +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Proportional Morbidity',
                data: [
                    ['SARI',    <?php echo $piesaridata;?>],
                    ['OAD',       <?php echo $pieoaddata;?>],
                    {
                        name: 'BD',
                        y: <?php echo $piebddata;?>,
                        sliced: true,
                        selected: true
                    },
                    ['AWD',   <?php echo $pieawddata;?>],
                    ['Mal',     <?php echo $piemaldata;?>],
                    ['ILI',   <?php echo $pieilidata;?>],
					['Others',   <?php echo $pieotherdata;?>]
                ]
            }]
        });
    });
    
});
		</script>
        <div id="propmorbiditycontainer" style="min-width: 300px; height: 220px; margin: 0 auto"></div>
        
        </td></tr>
        
        <tr bgcolor="#892A24"><td colspan="2"><font color="#FFFFFF" size="-2"><?php echo $row->footercaption;?></font></td></tr>
          <tr bgcolor="#1F7EB8 "><td colspan="2"><font color="#FFFFFF" size="-2">This weekly Epidemiological bulletin is published jointly by the Health Authorities and the World Health Organization. For further information, please contact the surveillance team on: ajangaa@nbo.emro.who.int</font></td></tr>
</table>
</td></tr></table>

<p class="mybreak"></p>
<table width="100%" id="listtable">
<tr><td>
<table id="customers">

<tr bgcolor="#892A24"><td><font color="#FFFFFF"><strong>Number of alerts received and reported (Epiweeks <?php echo $period_three;?> to <?php echo $row->week_no;?> - <?php echo $row->week_year;?>)</strong></font></td><td><font color="#FFFFFF"><strong>Age and sex distribution of diseases by cases (Epiweek <?php echo $row->week_no;?>, <?php echo $row->week_year;?>)</strong></font></td></tr>
<tr><td valign="top">
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container_sect',
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [
                    'Wk<?php echo $last_week_bt_one;?>',
                    'Wk<?php echo $last_week;?>',
                    'Wk<?php echo $this_week;?>'
                ]
            },
            yAxis: {
                min: 0,
				tickInterval: 5,
                title: {
                    text: 'Number of Alerts'
                }
            },  credits: {
      enabled: false
  },/**
            legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 100,
                y: 70,
                floating: true,
                shadow: true
            },**/
            tooltip: {
                formatter: function() {
                    return ''+
                        this.x +': '+ this.y +' ';
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
                series: [{
                name: 'Meas',
                data: [<?php echo $week_three_meas;?>, <?php echo $week_two_meas;?>, <?php echo $wk_one_meas;?>]
    
            }, {
                name: 'AFP',
                data: [<?php echo $week_three_afp;?>, <?php echo $week_two_afp;?>, <?php echo $week_one_afp;?>]
    
            }, {
                name: 'NNT',
                data: [<?php echo $week_three_nnt;?>, <?php echo $week_two_nnt;?>, <?php echo $week_one_nnt;?>]
    
            }, {
                name: 'Sus.Cholera',
                data: [<?php echo $week_three_awd;?>, <?php echo $week_two_awd;?>, <?php echo $week_one_awd;?>]
    
            }, {
                name: 'Sus.Malaria',
                data: [<?php echo $week_three_mal;?>, <?php echo $week_two_mal;?>, <?php echo $week_one_mal;?>]
    
            }
			, {
                name: 'SARI',
                data: [<?php echo $week_three_sari;?>, <?php echo $week_two_sari;?>, <?php echo $week_one_sari;?>]
    
            }
			, {
                name: 'ILI',
                data: [<?php echo $week_three_ili;?>, <?php echo $week_two_ili;?>, <?php echo $week_one_ili;?>]
    
            }]
        });
    });
    
});
		</script>
        
        
        <div id="container_sect" style="min-width: 300px; height: 220px; margin: 0 auto"></div>





</td>

<td valign="top">
<script>
	/**
 * Grouped Categories v0.0.1 (2013-02-22)
 *
 * (c) 2012-2013 Black Label
 *
 * License: Creative Commons Attribution (CC)
 */
(function(HC){
/*jshint expr:true, boss:true */
var UNDEFINED = void 0,
    mathRound = Math.round,
    mathMin   = Math.min,
    mathMax   = Math.max,

    // cache prototypes
    axisProto  = HC.Axis.prototype,
    tickProto  = HC.Tick.prototype,

    // cache original methods
    _axisInit          = axisProto.init,
    _axisRender        = axisProto.render,
    _axisSetCategories = axisProto.setCategories,
    _tickGetLabelSize  = tickProto.getLabelSize,
    _tickAddLabel      = tickProto.addLabel,
    _tickDestroy       = tickProto.destroy,
    _tickRender        = tickProto.render;


function Category(obj, parent) {
  this.name = obj.name || obj;
  this.parent = parent;

  return this;
}

Category.prototype.toString = function () {
  var parts = [],
      cat = this;

  while (cat) {
    parts.push(cat.name);
    cat = cat.parent;
  }

  return parts.join(', ');
};


// Highcharts methods
function defined(obj) {
  return obj !== UNDEFINED && obj !== null;
}

// calls parseInt with radix = 10, adds 0.5 to avoid blur
function pInt(n) {
  return parseInt(n, 10) - 0.5;
}

// returns sum of an array
function sum(arr) {
  var l = arr.length,
      x = 0;

  while (l--)
    x += arr[l];

  return x;
}


// Builds reverse category tree
function buildTree(cats, out, options, parent, depth) {
  var len = cats.length,
      cat;

  depth || (depth = 0);
  options.depth || (options.depth = 0);

  while (len--) {
    cat = cats[len];


    if (parent)
      cat.parent = parent;


    if (cat.categories)
      buildTree(cat.categories, out, options, cat, depth + 1);

    else
      addLeaf(out, cat, parent);
  }

  options.depth = mathMax(options.depth, depth);
}

// Adds category leaf to array
function addLeaf(out, cat, parent) {
  out.unshift(new Category(cat, parent));

  while (parent) {
    parent.leaves++ || (parent.leaves = 1);
    parent = parent.parent;
  }
}

// Pushes part of grid to path
function addGridPart(path, d) {
  path.push(
    'M',
    pInt(d[0]), pInt(d[1]),
    'L',
    pInt(d[2]), pInt(d[3])
  );
}

// Destroys category groups
function cleanCategory(category) {
  var tmp;

  while (category) {
    tmp = category.parent;

    if (category.label)
      category.label.destroy();

    delete category.parent;
    delete category.label;

    category = tmp;
  }
}

// Returns tick position
function tickPosition(tick, pos) {
  return tick.getPosition(tick.axis.horiz, pos, tick.axis.tickmarkOffset);
}

function walk(arr, key, fn) {
  var l = arr.length,
      children;

  while (l--) {
    children = arr[l][key];

    if (children)
      walk(children, key, fn);

    fn(arr[l]);
  }
}



//
// Axis prototype
//

axisProto.init = function (chart, options) {
  // default behaviour
  _axisInit.call(this, chart, options);

  if (typeof options === 'object' && options.categories)
    this.setupGroups(options);
};

// setup required axis options
axisProto.setupGroups = function (options) {
  var categories  = HC.extend([], options.categories),
      reverseTree = [],
      stats       = {};

  // build categories tree
  buildTree(categories, reverseTree, stats);

  // set axis properties
  this.categoriesTree   = categories;
  this.categories       = reverseTree;
  this.isGrouped        = stats.depth !== 0;
  this.labelsDepth      = stats.depth;
  this.labelsSizes      = [];
  this.labelsGridPath   = [];
  this.tickLength       = options.tickLength || this.tickLength || null;
  this.directionFactor  = [-1, 1, 1, -1][this.side];

  this.options.lineWidth = options.lineWidth || 1;
};


axisProto.render = function () {
  // clear grid path
  if (this.isGrouped)
    this.labelsGridPath = [];

  // cache original tick length
  if (this.originalTickLength === UNDEFINED)
    this.originalTickLength = this.options.tickLength;

  // use default tickLength for not-grouped axis
  // and generate grid on grouped axes,
  // use tiny number to force highcharts to hide tick
  this.options.tickLength = this.isGrouped ? 0.001 : this.originalTickLength;

  _axisRender.call(this);


  if (!this.isGrouped) {
    if (this.labelsGrid)
      this.labelsGrid.attr({visibility: 'hidden'});
    return;
  }

  var axis    = this,
      options = axis.options,
      top     = axis.top,
      left    = axis.left,
      right   = left + axis.width,
      bottom  = top + axis.height,
      visible = axis.hasVisibleSeries,
      depth   = axis.labelsDepth,
      grid    = axis.labelsGrid,
      horiz   = axis.horiz,
      d       = axis.labelsGridPath,
      i       = 0,
      offset  = axis.opposite ? (horiz ? top : right) : (horiz ? bottom : left),
      part;

  if (axis.userTickLength)
    depth -= 1;

  // render grid path for the first time
  if (!grid) {
    grid = axis.labelsGrid = axis.chart.renderer.path()
      .attr({
        strokeWidth: options.lineWidth,
        stroke: options.lineColor
      })
      .add(axis.axisGroup);
  }

  // go through every level and draw horizontal grid line
  while (i <= depth) {
    offset += axis.groupSize(i);

    part = horiz ?
      [left, offset, right, offset] :
      [offset, top, offset, bottom];

    addGridPart(d, part);
    i++;
  }

  // draw grid path
  grid.attr({
    d: d,
    visibility: visible ? 'visible' : 'hidden'
  });

  axis.labelGroup.attr({
    visibility: visible ? 'visible' : 'hidden'
  });


  walk(axis.categoriesTree, 'categories', function (group) {
    var tick = group.tick;

    if (!tick)
      return;

    if (tick.startAt + tick.leaves - 1 < axis.min || tick.startAt > axis.max) {
      tick.label.hide();
      tick.destroyed = 0;
    }
    else
      tick.label.show();
  });
};

axisProto.setCategories = function (newCategories, doRedraw) {
  if (this.categories)
    this.cleanGroups();

  this.setupGroups({
    categories: newCategories
  });

  _axisSetCategories.call(this, this.categories, doRedraw);
};

// cleans old categories
axisProto.cleanGroups = function () {
  var ticks = this.ticks,
      n;

  for (n in ticks)
    if (ticks[n].parent);
      delete ticks[n].parent;

  walk(this.categoriesTree, 'categories', function (group) {
    var tick = group.tick,
        n;

    if (!tick)
      return;

    tick.label.destroy();

    for (n in tick)
      delete tick[n];

    delete group.tick;
  });
};

// keeps size of each categories level
axisProto.groupSize = function (level, position) {
  var positions = this.labelsSizes,
      direction = this.directionFactor;

  if (position !== UNDEFINED)
    positions[level] = mathMax(positions[level] || 0, position + 10);

  if (level === true)
    return sum(positions) * direction;

  else if (positions[level])
    return positions[level] * direction;

  return 0;
};



//
// Tick prototype
//

// Override methods prototypes
tickProto.addLabel = function () {
  var category;

  _tickAddLabel.call(this);

  if (!this.axis.categories ||
      !(category = this.axis.categories[this.pos]))
    return;

  // set label text
  if (category.name)
    this.label.attr('text', category.name);

  // create elements for parent categories
  if (this.axis.isGrouped)
    this.addGroupedLabels(category);
};

// render ancestor label
tickProto.addGroupedLabels = function (category) {
  var tick    = this,
      axis    = this.axis,
      chart   = axis.chart,
      options = axis.options.labels,
      useHTML = options.useHTML,
      css     = options.style,
      attr    = { align: 'center' },
      size    = axis.horiz ? 'height' : 'width',
      depth   = 0,
      label;


  while (tick) {
    if (depth > 0 && !category.tick) {
      // render label element
      label = chart.renderer.text(category.name, 0, 0, useHTML)
        .attr(attr)
        .css(css)
        .add(axis.labelGroup);

      // tick properties
      tick.startAt = this.pos;
      tick.childCount = category.categories.length;
      tick.leaves = category.leaves;
      tick.visible = this.childCount;
      tick.label = label;

      // link tick with category
      category.tick = tick;
    }

    // set level size
    axis.groupSize(depth, tick.label.getBBox()[size]);

    // go up to the parent category
    category = category.parent;

    if (category)
      tick = tick.parent = category.tick || {};
    else
      tick = null;

    depth++;
  }
};

// set labels position & render categories grid
tickProto.render = function (index, old) {
  _tickRender.call(this, index, old);

  if (!this.axis.isGrouped || !this.axis.categories[this.pos] || this.pos > this.axis.max)
    return;

  var tick    = this,
      group   = tick,
      axis    = tick.axis,
      tickPos = tick.pos,
      isFirst = tick.isFirst,
      max     = axis.max,
      min     = axis.min,
      horiz   = axis.horiz,
      cat     = axis.categories[tickPos],
      grid    = axis.labelsGridPath,
      size    = axis.groupSize(0),
      tickLen = axis.tickLength || size,
      factor  = axis.directionFactor,
      xy      = tickPosition(tick, tickPos),
      start   = horiz ? xy.y : xy.x,
      depth   = 1,
      gridAttrs,
      lvlSize,
      attrs,
      bBox;

  // render grid for "normal" categories (first-level), render left grid line only for the first category
  if (isFirst) {
    gridAttrs = horiz ?
      [axis.left, xy.y, axis.left, xy.y + axis.groupSize(true)] :
      axis.isXAxis ?
        [xy.x, axis.top, xy.x + axis.groupSize(true), axis.top] :
        [xy.x, axis.top + axis.len, xy.x + axis.groupSize(true), axis.top + axis.len];

    addGridPart(grid, gridAttrs);
  }

  gridAttrs = horiz ?
    [xy.x, xy.y, xy.x, xy.y + size] :
    [xy.x, xy.y, xy.x + size, xy.y];

  addGridPart(grid, gridAttrs);

  size = start + size;



  while (group = group.parent) {
    minPos  = tickPosition(tick, mathMax(group.startAt - 1, min - 1));
    maxPos  = tickPosition(tick, mathMin(group.startAt + group.leaves - 1, max));
    bBox    = group.label.getBBox();
    lvlSize = axis.groupSize(depth);

    attrs = horiz ? {
      x: (minPos.x + maxPos.x) / 2,
      y: bBox.height * factor + size + 4
    } : {
      x: size,
      y: (minPos.y + maxPos.y + bBox.height) / 2
    };

    group.label.attr(attrs);

    if (grid) {
      gridAttrs = horiz ?
        [maxPos.x, size, maxPos.x, size + lvlSize] :
        [size, maxPos.y, size + lvlSize, maxPos.y];

      addGridPart(grid, gridAttrs);
    }

    size += lvlSize;
    depth++;
  }
};

tickProto.destroy = function () {
  var group = this;

  while (group = group.parent)
    group.destroyed++ || (group.destroyed = 1);

  _tickDestroy.call(this);
};

// return size of the label (height for horizontal, width for vertical axes)
tickProto.getLabelSize = function () {
  if (this.axis.isGrouped === true)
    return sum(this.axis.labelsSizes);
  else
    return _tickGetLabelSize.call(this);
};

}(Highcharts));
$(function () {
    var chart = new Highcharts.Chart({
        chart: {
            renderTo: "categorycont",
            type: "column"
        },
        title: {
            text: null
        },  credits: {
      enabled: false
  },
        series: [{
                name: 'Bloody Diarrhea',
                data: [<?php echo $bdunderfive;?>,<?php echo $bdoverfive;?>,<?php echo $bdmale;?>,<?php echo $bdfemale;?>]
            }, {
                name: 'Cholera',
                data: [<?php echo $awdunderfive;?>,<?php echo $awdoverfive;?>,<?php echo $awdmale;?>,<?php echo $awdfemale;?>]
            }, {
                name: 'OAD',
                data: [<?php echo $oadunderfive;?>,<?php echo $oadoverfive;?>,<?php echo $oadmale;?>,<?php echo $oadfemale;?>]
            }, {
                name: 'Malaria',
                data: [<?php echo $malunderfive;?>,<?php echo $maloverfive;?>,<?php echo $malmale;?>,<?php echo $malfemale;?>]
            }],
        xAxis: {
            categories: [{
                name: "Age",
                categories: ["<5yrs", ">5yrs"]
            }, {
                name: "Sex",
                categories: ["Male", "Female"]
            }]
        },
            yAxis: {
                min: 0,
				tickInterval: 50,
                title: {
                    text: 'Percentages'
                }
            },  credits: {
      enabled: false
  }
    });
});
</script>
 <div id="categorycont" style="min-width: 300px; height: 220px; margin: 0 auto"></div>
</td></tr>
<tr bgcolor="#892A24">
<td valign="top"><font color="#FFFFFF"><strong>Trends for confirmed Malaria morbidity in <?php echo $zone->zone;?></strong></font></td><td valign="top"><font color="#FFFFFF"><strong>Summary of malaria morbidity in week <?php echo $row->week_no;?></strong></font></td>
</tr>
<tr>
  <td valign="top">
  
        
        <script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'cont',
                zoomType: 'xy'
            },
			  credits: {
      enabled: false
  },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: [{
                categories: [<?php echo $malariacategories;?>]
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    formatter: function() {
                        return this.value +'%';
                    },
                    style: {
                        color: '#89A54E'
                    }
                },
				gridLineWidth: 0,
				minPadding: 0, 
                maxPadding: 0,         
                min: 0, 
                max:100,
                title: {
                    text: 'SPR/FR',
                    style: {
                        color: '#89A54E'
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Confirmed Cases',
                    style: {
                        color: '#4572A7'
                    }
                },
                labels: {
                    formatter: function() {
                        return this.value +' ';
                    },
                    style: {
                        color: '#4572A7'
                    }
                },
                opposite: true
            }],
            tooltip: {
                formatter: function() {
                    return ''+
                        this.x +': '+ this.y +
                        (this.series.name == 'Confirmed Cases' ? ' ' : '');
                }
            },/**
            legend: {
                layout: 'vertical',
                align: 'left',
                x: 120,
                verticalAlign: 'top',
                y: 100,
                floating: true,
                backgroundColor: '#FFFFFF'
            },**/
            series: [{
                name: '< 5 Confirmed Cases',
                color: '#892A24',
                type: 'column',
                yAxis: 1,
                data: [<?php echo $malariaufivedata;?>]
    
            }, {
                name: '> 5 Confirmed Cases',
                color: '#4572A7',
                type: 'column',
                yAxis: 1,
                data: [<?php echo $malariaofivedata;?>]
    
            },{
                name: 'SPR',
                color: '#89A54E',
                type: 'spline',
                data: [<?php echo $sprdata;?>]
            }
			,{
                name: 'FR',
                color: '#AA4643',
                type: 'spline',
				dashStyle: 'shortdot',
                data: [<?php echo $frdata;?>]
            }]
        });
    });
    
});
		</script>
        
        <div id="cont" style="min-width: 300px; height: 280px; margin: 0 auto"></div>
  
  </td>
  <td valign="top"><?php echo $malariatable;?></td></tr>
<tr bgcolor="#892A24">
<?php
if(empty($row->title))
{
	?>
<td valign="top"><font color="#FFFFFF"><strong>Measles Trends <?php echo date('Y')-1;?> - <?php echo date('Y');?></strong></font></td>    
    <?php
}
else
{
?>
<td valign="top"><font color="#FFFFFF"><strong><?php echo $row->title;?></strong></font></td>
<?php
}
?>

<td><font color="#FFFFFF"><strong>Number of alerts &amp; outbreaks reported and investigated with appropriate response</strong></font></td></tr>
<tr>
<?php
if(empty($row->title))
{
	?>
 <td valign="top">		<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'meascontainer',
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: '',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: [<?php echo $meascategories; ?>],
				labels: {
                rotation: 270,
                y:17
                
            	}
            },
            yAxis: {
				min: 0,
				tickInterval: 5,
                title: {
                    text: 'Number of Cases'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +'';
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
			credits: {
      enabled: false
  },
            series: [{
                name: '<?php echo $last_year;?>',
                data: [<?php echo $last_year_data;?>]
            }, {
                name: '<?php echo $current_year;?>',
                data: [<?php echo $current_year_data;?>]
            }]
        });
    });
    
});
		</script>
        
        <div id="meascontainer" style="min-width: 300px; height: 250px; margin: 0 auto"></div>
        </td>   
    <?php
}
else
{
?>
  <td valign="top"><?php echo $row->narrative;?></td>
<?php
}
?>
  <td valign="top">
  <?php echo $alertsouttable;?>
  </td></tr>
<tr bgcolor="#892A24">
  <td colspan="2"><font color="#FFFFFF"><strong>Distribution of consultations of leading diseases by region, Epiweek <?php echo $row->week_no;?></strong></font></td></tr>
<tr><td colspan="2"><?php echo $distribution_table; ?></td></tr>
 <tr bgcolor="#892A24"><td colspan="2"><font color="#FFFFFF" size="-2"><?php echo $row->footercaption;?></font></td></tr>
          <tr bgcolor="#1F7EB8 "><td colspan="2"><font color="#FFFFFF" size="-2">This weekly Epidemiological bulletin is published jointly by the Health Authorities and the World Health Organization. For further information, please contact the surveillance team on: ajangaa@nbo.emro.who.int</font></td></tr>
</table>
</td></tr></table>

<p class="mybreak"></p>
<table width="92%" id="lasttable">

<tr><td colspan="2">
<table id="customers">
<tr><td>
<table id="zonlisttable">
<?php echo $zonetable; ?>
</table>
</td>
</tr>

<tr bgcolor="#892A24"><td colspan="2"><font color="#FFFFFF"><strong>Alerts/Outbreaks Reported in Epi Week <?php echo $row->week_no;?>, <?php echo $row->week_year;?></strong></font></td></tr>
<tr ><td colspan="2">
<?php echo $alertstable; ?>
</td></tr>
</table>
</td></tr>
 <tr bgcolor="#892A24"><td colspan="2"><font color="#FFFFFF" size="-2"><?php echo $row->footercaption;?></font></td></tr>
 <tr bgcolor="#1F7EB8 "><td colspan="2"><font color="#FFFFFF" size="-2">This weekly Epidemiological bulletin is published jointly by the Health Authorities and the World Health Organization. For further information, please contact the surveillance team on: ajangaa@nbo.emro.who.int</font></td></tr>
</table>
</center>
</body>
</html>