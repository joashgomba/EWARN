<?php include(APPPATH . 'views/common/header.php'); ?>

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

						<li class="active">Weekly Disease Cases</li>
					</ul><!--.breadcrumb-->

					
				</div>

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
                            <div class="page-header position-relative">
						<h1>
							Reports
							<small>
								<i class="icon-double-angle-right"></i>
								Weekly Disease Cases
							</small>
						</h1>
					</div><!--/.page-header-->
                
                      
                       <table id="customers">
                               <thead>
                               		<tr><th colspan="2">Weekly Disease cases from <?php echo $reporting_year;?>/<?php echo $from;?> - <?php echo $reporting_year2;?>/<?php echo $to;?></th></tr>
                               </thead>
                               <tbody>
                               <tr class="alt"><td colspan="2"><strong>Zone:</strong> <?php echo $zone;?>  <strong>Region:</strong> <?php echo $region;?> <strong>District:</strong> <?php echo $district;?>  <strong>Health Facility:</strong> <?php echo $healthfacility;?></td></tr>
                               <tr><td><strong>Weekly Disease Cases </strong></td><td>&nbsp;</td></tr>
                               <tr><td width="50%" valign="top"><?php echo $table;?></td><td width="50%" valign="top">
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
                text: 'Weekly Disease Cases'
            },  credits: {
      enabled: false
  },
            xAxis: {
            },
            yAxis: {
                title: {
                    text: 'Number'
                }
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
       <script src="<?php echo base_url(); ?>js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>js/exporting.js"></script>
                               
                               
                              
                               </td></tr>
                               <tr><td colspan="2"><div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div></td></tr>
                               <tr><td colspan="2">
                               <?php echo $disttable;?>
                               <?php echo $typebtable;?>
                               </td></tr>
                               </tbody>
                               
                               </table>
   
							<!--PAGE CONTENT ENDS-->
						</div><!--/.span-->
					</div><!--/.row-fluid-->
				</div><!--/.page-content-->

				<?php include(APPPATH . 'views/common/settingscontainer.php'); ?>
			</div><!--/.main-content-->
		</div><!--/.main-container-->

		<?php include(APPPATH . 'views/common/footer.php'); ?>
	</body>
</html>
