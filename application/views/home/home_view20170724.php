<?php include(APPPATH . 'views/common/header.php'); ?>
<style>
    #map-canvas{
      width: 100%;
      height: 500px;
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
  
   <style type="text/css">
   .labels {
     color: red;
     background-color: white;
     font-family: "Lucida Grande", "Arial", sans-serif;
     font-size: 10px;
     font-weight: bold;
     text-align: center;
     width: 40px;     
     border: 2px solid black;
     white-space: nowrap;
   }
 </style>
<style>
				#datatable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#datatable td, #listtable th 
				{
				font-size:0.9em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#datatable th 
				{
				font-size:0.9em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#datatable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
<script>
		
   function trim(str){
	return str.replace(/^\s\s*/, '').replace(/\s\s*$/, '');}
	function totalEncode(str){
	var s=escape(trim(str));
	s=s.replace(/\+/g,"+");
	s=s.replace(/@/g,"@");
	s=s.replace(/\//g,"/");
	s=s.replace(/\*/g,"*");
	return(s);
	}
	function connect(url,params)
	{
	var connection;  // The variable that makes Ajax possible!
	try{// Opera 8.0+, Firefox, Safari
	connection = new XMLHttpRequest();}
	catch (e){// Internet Explorer Browsers
	try{
	connection = new ActiveXObject("Msxml2.XMLHTTP");}
	catch (e){
	try{
	connection = new ActiveXObject("Microsoft.XMLHTTP");}
	catch (e){// Something went wrong
	return false;}}}
	connection.open("POST", url, true);
	connection.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	connection.setRequestHeader("Content-length", params.length);
	connection.setRequestHeader("connection", "close");
	connection.send(params);
	return(connection);
	}
	
	function validateForm(frm){
	var errors='';
		
	if (errors){
	alert('The following error(s) occurred:\n'+errors);
	return false; }
	return true;
	}
		
	function findReport(frm){
	if(validateForm(frm)){
	document.getElementById('maps').innerHTML='';
	
	var url = "<?php echo base_url(); ?>index.php/home/getlist";
	
	var params = "test=" + totalEncode(document.frm.test.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		
		document.getElementById('maps').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('maps').innerHTML = '<span style="color:green;"><h1>Retrieving records....</h1> <i class="icon-spinner icon-spin orange bigger-125"></i></span>';}}}
	}
	
	
</script>

	<body>
		<?php include(APPPATH . 'views/common/navbar.php'); ?>

		<div class="main-container container-fluid">
			<a class="menu-toggler" id="menu-toggler" href="#">
				<span class="menu-text"></span>
			</a>
			<?php include(APPPATH . 'views/common/sidebar.php'); ?>
			
			<div class="main-content">
				<div class="breadcrumbs" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="icon-home home-icon"></i>
							<a href="<?php echo site_url('home')?>">Home</a>

							<span class="divider">
								<i class="icon-angle-right arrow-icon"></i>
							</span>
						</li>

						<li class="active">Dashboard</li>
					</ul><!--.breadcrumb-->

					
				</div>

				<div class="page-content">
                
                <div class="row-fluid">
						<div class="span8">
							<!--PAGE CONTENT BEGINS-->
                       
                            
                            <h4 class="header smaller lighter blue">Alerts Map week <?php echo $to_week; ?> <?php echo $to_year; ?></h4>
         
                            
                            
                            
                            <div id="json_data" style="display:none;">
                            
									 <?php
                                    
                      					echo json_encode($points,JSON_HEX_QUOT | JSON_HEX_TAG);
                                     
                                     ?>
                                     </div>
                                     
                                   
                                   <div id="map-canvas"></div>
                                   
                                 
                                   
                                   <script src="<?php echo base_url(); ?>js/mapwithmarker.js"></script>
                   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
                   <script src="<?php echo base_url(); ?>js/clusterer.js"></script>
                  
  <script src="<?php echo base_url(); ?>js/map.js"></script>
                            
							<!--PAGE CONTENT ENDS-->
						</div>
                        
                        <div class="span4">
							<!--PAGE CONTENT BEGINS-->
                            
                            <h4 class="header smaller lighter blue">Alerts week <?php echo $to_week; ?> <?php echo $to_year; ?></h4>
                            <p class="text-info">
                            <strong>Total Alerts (<?php echo number_format($total_cases); ?>)</strong>
                            </p>
                            <p>
                            <ul class="unstyled spaced">
                                                
<?php echo $alert_list; ?>                                                            
                                                            
                                                </ul>
                                                <p class="text-error"><strong>Total true alerts (<?php echo number_format($true_cases); ?>)</strong></p>
                                                
                                                <p class="text-error"> 
                                                <ul>
                                               <?php echo $true_alert_list; ?> 
                                                </ul>
                                                </p>
                            
                            </p>
                            
							<!--PAGE CONTENT ENDS-->
						</div>
                        
                        
                        <!--/.span-->
					</div>
                    
                
                <div class="row-fluid">
						<div class="span6">
							<!--PAGE CONTENT BEGINS-->
                            
                            <div class="widget-box">
										<div class="widget-header">
											<h5 class="smaller">
                                            
                                           PERCENTAGE OF REPORTED CASES BY AGE WEEK <?php echo $to_week; ?> <?php echo $to_year; ?> 
											</h5>
										</div>

										<div class="widget-body">
											<div class="widget-main">
												<p class="muted">
                                              
													
                                                    <script type="text/javascript">
$(function () {
    var chart;
    
    $(document).ready(function () {
		
		// Radialize the colors
		Highcharts.getOptions().colors = $.map(Highcharts.getOptions().colors, function(color) {
		    return {
		        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
		        stops: [
		            [0, color],
		            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
		        ]
		    };
		});
    	
    	// Build the chart
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'agepie',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Percentage of reported cases by age week <?php echo $to_week; ?> <?php echo $to_year; ?>'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
            	percentageDecimals: 1
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },credits: {
      enabled: false
  },
            series: [{
                type: 'pie',
                name: 'Percentage of reported cases by age',
                data: [
                    ['Under 5 years',   <?php echo $under_five_total;?>],
					['Above 5 years',   <?php echo $over_five_total;?>]
                    
                ]
            }]
        });
    });
    
});
		</script>
        
        <div id="agepie" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
                                                    
                                                    
                                                    
                                                  
												</p>

												
											</div>
										</div>
                                        
									</div>
                            
							<!--PAGE CONTENT ENDS-->
						</div>
                        
                        <div class="span6">
							<!--PAGE CONTENT BEGINS-->
                            
                            <div class="widget-box">
										<div class="widget-header">
											<h5 class="smaller">
                                            
                                           PERCENTAGE OF REPORTED CASES BY SEX WEEK <?php echo $to_week; ?> <?php echo $to_year; ?> 
											</h5>
										</div>

										<div class="widget-body">
											<div class="widget-main">
												<p class="muted">
                                                
													<script type="text/javascript">
$(function () {
    var chart;
    
    $(document).ready(function () {
		
		    	
    	// Build the chart
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'sexpie',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Percentage of reported cases by sex week <?php echo $to_week; ?> <?php echo $to_year; ?>'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
            	percentageDecimals: 1
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },credits: {
      enabled: false
  },
            series: [{
                type: 'pie',
                name: 'Percentage of reported cases by sex',
                data: [
                    ['Male',   <?php echo $total_male;?>],
					['Female',   <?php echo $total_female;?>]
                    
                ]
            }]
        });
    });
    
});
		</script>
        
        <div id="sexpie" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
                                                    
												</p>

												
											</div>
										</div>
                                        
									</div>
                            
							<!--PAGE CONTENT ENDS-->
						</div>
                        
                        
                        <!--/.span-->
					</div>
                    
					<div class="row-fluid">
						<div class="span12" style="overflow: auto">
							<!--PAGE CONTENT BEGINS-->
                            
                            <div class="widget-box">
										<div class="widget-header">
											<h4 class="smaller">
                                            
                                            <?php
										 if($level==3)//HF
										   {
												   
											  	$administrative_region =  $healthfacility->healthfacillity_name;							   
										   }
										 if($level==6)//District
										   {
												$administrative_region =  $district->district;   
											 													   
										   }										 
										  if($level==2)//FP
										   {
												$administrative_region =  $region->region;									   
										   }										   
										   if($level==1)//zonal
										   {
											  	$administrative_region =  $zone->zone;										   
										   }										   
										   if($level==4)//national
										   {
											  $administrative_region =  $country->country_name;
										   }										   
										   if($level==5)//stakeholder
										   {
											 $administrative_region =  $country->country_name;
										   }
											?>
												Weekly Disease Cases for <?php echo $administrative_region;?> for the previous ten (10) weeks
											</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
												<p class="muted">
                                               
													<?php echo $table;?>
                                                  
												</p>

												
											</div>
										</div>
									</div>
                            
							<!--PAGE CONTENT ENDS-->
						</div>
                        
                        
                        <!--/.span-->
					</div>
                    
                    
                    
                    <div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
                            
                            <div class="widget-box">
										<div class="widget-header">
											<h4 class="smaller">
												Weekly Disease Cases from week <?php echo $from_week; ?> <?php echo $from_year; ?>  to week <?php echo $to_week; ?> <?php echo $to_year; ?> 
											</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
												<p class="muted">
													<script type="text/javascript">
$(function () {
    // On document ready, call visualize on the datatable.
    $(document).ready(function() {
        /**
         * Visualize an HTML table using Highcharts. The top (horizontal) header
         * is used for series names, and the left (vertical) header is used
         * for category names. This function is based on jQuery.
         * @param {Object} table The reference to the HTML table to visualize
         * @param {Object} options Highcharts options
         */
        Highcharts.visualize = function(table, options) {
            // the categories
            options.xAxis.categories = [];
            $('tbody th', table).each( function(i) {
                options.xAxis.categories.push(this.innerHTML);
            });
    
            // the data series
            options.series = [];
            $('tr', table).each( function(i) {
                var tr = this;
                $('th, td', tr).each( function(j) {
                    if (j > 0) { // skip first column
                        if (i == 0) { // get the name and init the series
                            options.series[j - 1] = {
                                name: this.innerHTML,
                                data: []
                            };
                        } else { // add values
                            options.series[j - 1].data.push(parseFloat(this.innerHTML));
                        }
                    }
                });
            });
    
            var chart = new Highcharts.Chart(options);
        }
    
        var table = document.getElementById('datatable'),
        options = {
            chart: {
                renderTo: 'container',
                type: 'column'
            },
            title: {
                text: 'Weekly Disease Cases <?php echo $administrative_region;?> wk <?php echo $from_week; ?> <?php echo $from_year; ?> to wk <?php echo $to_week; ?> <?php echo $to_year; ?>'
            },
            xAxis: {
            },
            yAxis: {
                title: {
                    text: 'Cases'
                }
            },
			credits: {
      enabled: false
  },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+
                        this.y +' '+ this.x.toLowerCase();
                }
            }
        };
    
        Highcharts.visualize(table, options);
    });
    
});
		</script>
        
        <div id="container" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
                            <script src="<?php echo base_url(); ?>js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>js/exporting.js"></script>
												</p>

												
											</div>
										</div>
									</div>
                            
							<!--PAGE CONTENT ENDS-->
						</div>
                        
                        
                        <!--/.span-->
					</div>
                    
                    <div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
                            
                            <div class="widget-box">
										<div class="widget-header">
											<h5 class="smaller">
                                            
                                           Total consultations and number of reporting sites by EPI week <?php echo $first_week; ?> <?php echo $first_year; ?> to week <?php echo $last_week; ?> <?php echo $last_year; ?>
											</h5>
										</div>

										<div class="widget-body">
											<div class="widget-main">
												<p class="muted">
                                                
											<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'consultationscontainer',
                zoomType: 'xy'
            },
            title: {
                text: 'Total consultations and number of reporting sites week <?php echo $first_week; ?> <?php echo $first_year; ?> to week <?php echo $last_week; ?> <?php echo $last_year; ?>'
            },
			credits: {
      enabled: false
  },
            xAxis: [{
                categories: [<?php echo $categories; ?>]
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    formatter: function() {
                        return this.value ;
                    },
                    style: {
                        color: '#89A54E'
                    }
                },
				gridLineWidth: 0,
				minPadding: 0, 
                maxPadding: 0,         
                min: 0, 
                max:<?php echo $total_facilities; ?>,
                title: {
                    text: 'Reporting Sites',
                    style: {
                        color: '#89A54E'
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Consultations',
                    style: {
                        color: '#4572A7'
                    }
                },
                labels: {
                    formatter: function() {
                        return this.value ;
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
                        (this.series.name == 'Consultations' ? ' ' : '');
                }
            },
            series: [{
                name: 'Consultations',
                color: '#4572A7',
                type: 'column',
                yAxis: 1,
                data: [<?php echo $consultations_column; ?>]
    
            }, {
                name: 'Reporting Sites',
                color: '#89A54E',
                type: 'spline',
                data: [<?php echo $reporting_sites_column; ?>]
            }]
        });
    });
    
});
		</script>
        
        <div id="consultationscontainer" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
                                                    
                                                    
                                                    
                                                    
												</p>

												
											</div>
										</div>
                                        
									</div>
                            
							<!--PAGE CONTENT ENDS-->
						</div>
                        
                        
                        
                        
                        <!--/.span-->
					</div>
                    
                    <div class="row-fluid">
						
                        <div class="span12">
							<!--PAGE CONTENT BEGINS-->
                            
                            <div class="widget-box">
										<div class="widget-header">
											<h5 class="smaller">
                                            
                                          Proportion of cases by EPI week
											</h5>
										</div>

										<div class="widget-body">
											<div class="widget-main">
												<p class="muted">
                                              
												<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'linecontainer',
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: 'Proportion of cases of <?php echo $label;?> by EPI week <?php echo $first_week; ?> <?php echo $first_year; ?> to week <?php echo $last_week; ?> <?php echo $last_year; ?>',
                x: -20 //center
            },
			credits: {
      enabled: false
  },
            xAxis: {
                categories: [<?php echo $categories; ?>]
            },
            yAxis: {
                title: {
                    text: 'Percentage'
                },
				gridLineWidth: 0,
				minPadding: 0, 
                maxPadding: 0,         
                min: 0,
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
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
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [<?php echo $series; ?>]
        });
    });
    
});
		</script>
        
        <div id="linecontainer" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
                                                    
												</p>

												
											</div>
										</div>
                                        
									</div>
                            
							<!--PAGE CONTENT ENDS-->
						</div>
                        
                        
                        
                        <!--/.span-->
					</div>
                    
                    
                    <!--/.row-fluid-->
				</div><!--/.page-content-->

				<?php include(APPPATH . 'views/common/settingscontainer.php'); ?>
			</div><!--/.main-content-->
		</div><!--/.main-container-->

		<?php include(APPPATH . 'views/common/footer.php'); ?>
	</body>
</html>
