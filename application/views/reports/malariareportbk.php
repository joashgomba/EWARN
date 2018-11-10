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

						<li class="active">Malaria Reports</li>
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
								Malaria Reports
							</small>
						</h1>
					</div><!--/.page-header-->
                
                      
                       <table id="customers">
                               <thead>
                               		<tr><th colspan="2">Malaria Morbidity by Region <?php echo $region;?> from Epi week <?php echo $from;?> ,<?php echo $reporting_year;?> - Epi week <?php echo $to;?>, <?php echo $reporting_year2;?></th></tr>
                               </thead>
                               <tbody>
                               <tr class="alt"><td colspan="2"><strong>Region:</strong> <?php echo $region;?></td></tr>
                         <script type="text/javascript">

(function($){ // encapsulate jQuery

$(function () {
        $('#container').highcharts({
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'Malaria Morbidity'
            },
            subtitle: {
                text: 'Source: eDEWS Somalia'
            },
            xAxis: [{
                categories: [<?php echo $categories;?>]
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value} %',
                    style: {
                        color: '#89A54E'
                    }
                },
                title: {
                    text: 'Percentage',
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
                    format: '{value} ',
                    style: {
                        color: '#4572A7'
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                x: 120,
                verticalAlign: 'top',
                y: 100,
                floating: true,
                backgroundColor: '#FFFFFF'
            },
            series: [{
                name: 'Malaria Cases',
                color: '#4572A7',
                type: 'column',
                yAxis: 1,
                data: [<?php echo $malariadata;?>],
                tooltip: {
                    valueSuffix: ' '
                }
    
            }, {
                name: 'Fr',
                color: '#89A54E',
                type: 'spline',
                data: [<?php echo $frdata;?>],
                tooltip: {
                    valueSuffix: ''
                }
            }]
        });
    });
    

})(jQuery);
</script>
<script src="<?php echo base_url(); ?>js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>js/exporting.js"></script>
<tr><td><?php echo $table;?></td></tr>
<tr><td><div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div></td></tr>
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
