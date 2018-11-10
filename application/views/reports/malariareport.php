<?php include(APPPATH . 'views/common/header.php'); ?>
<style>
    #listtable
    {
        font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
        width:100%;
        border-collapse:collapse;
    }
    #listtable td, #listtable th
    {
        font-size:0.9em;
        border:1px solid #999999;
        padding:3px 7px 2px 7px;
    }
    #listtable th
    {
        font-size:0.9em;
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
</style>

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
                 <h3 class="header smaller lighter green">
										Malaria Morbidity from Epi week <?php echo $from;?> ,<?php echo $reporting_year;?> - Epi week <?php echo $to;?>, <?php echo $reporting_year2;?>
									</h3>

                            <?php
                            $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
                            echo form_open('reports/malariareport',$attributes); ?>

                            <div id="accordion2" class="accordion">
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a href="#collapseOne" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">
                                            Click Here to Search Again
                                        </a>
                                    </div>

                                    <div class="accordion-body collapse" id="collapseOne">
                                        <div class="accordion-inner">

                                            <div class="widget-box">
                                                <div class="widget-header widget-header-flat">
                                                    <h4>Select Report Parameters</h4>
                                                </div>

                                                <div class="widget-body">
                                                    <div class="widget-main">

                                                        <div class="row-fluid">

                                                            <div class="span6">

                                                                <div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->first_admin_level_label;?>: </label><div class="controls">
                                                                        <?php
                                                                        if(getRole() == 'SuperAdmin')
                                                                        {
                                                                            ?>
                                                                            <select name="zone_id" id="zone_id" onChange="GetRegions(this)">
                                                                                <option value="">-Select <?php echo $user_country->first_admin_level_label;?>-</option>
                                                                                <option value="">-All <?php echo $user_country->first_admin_level_label;?>-</option>
                                                                                <?php
                                                                                foreach($zones as $key=> $zone)
                                                                                {
                                                                                    ?>
                                                                                    <option value="<?php echo $zone['id'];?>"><?php echo $zone['zone'];?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {

                                                                            if($level==2 || $level==6 || $level==1)//FP, District or Zone
                                                                            {
                                                                                echo '<strong>'.$zone->zone.'</strong>';
                                                                                ?>
                                                                                <input type="hidden" name="zone_id" id="zone_id" value="<?php echo $zone->id?>">
                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <select name="zone_id" id="zone_id" onChange="GetRegions(this)">
                                                                                    <option value="">-Select <?php echo $user_country->first_admin_level_label;?>-</option>
                                                                                    <option value="">-All <?php echo $user_country->first_admin_level_label;?>-</option>
                                                                                    <?php
                                                                                    foreach($zones as $key=> $zone)
                                                                                    {
                                                                                        ?>
                                                                                        <option value="<?php echo $zone['id'];?>"><?php echo $zone['zone'];?></option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="span6">

                                                                <div class="control-group">
                                                                    <label class="control-label" for="form-field-1"><?php echo $user_country->second_admin_level_label;?>: </label>
                                                                    <div class="controls">
                                                                        <?php
                                                                        if($level==2 || $level==6)
                                                                        {
                                                                            echo '<strong>'.$region->region.'</strong>';
                                                                            ?>
                                                                            <input type="hidden" name="region_id" id="region_id" value="<?php echo $region->id?>">

                                                                            <?php
                                                                        }
                                                                        elseif($level==1)
                                                                        {
                                                                            ?>
                                                                            <select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                                                                <option value="">Select <?php echo $user_country->second_admin_level_label;?></option>
                                                                                <option value="">All <?php echo $user_country->second_admin_level_label;?></option>
                                                                                <?php
                                                                                foreach($regions as $key=>$region)
                                                                                {
                                                                                    ?>
                                                                                    <option value="<?php echo $region['id'];?>"><?php echo $region['region'];?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <div id="regions">
                                                                                <select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                                                                    <option value="">Select <?php echo $user_country->second_admin_level_label;?></option>

                                                                                </select>
                                                                            </div>
                                                                            <?php
                                                                        }?>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="row-fluid">

                                                            <div class="span6">

                                                                <div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->third_admin_level_label;?>: </label><div class="controls">
                                                                        <?php

                                                                        if($level==6)
                                                                        {
                                                                            ?>
                                                                            <select name="district_id" id="district_id">
                                                                                <option value="<?php echo $district->id;?>"><?php echo $district->district;?></option>
                                                                            </select>
                                                                            <?php
                                                                        }
                                                                        else if($level==2)
                                                                        {
                                                                            ?>
                                                                            <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)" >
                                                                                <option value="">Select <?php echo $user_country->third_admin_level_label;?></option>
                                                                                <option value="0">-All <?php echo $user_country->third_admin_level_label;?>-</option>
                                                                                <?php
                                                                                foreach($districts as $key => $district)
                                                                                {
                                                                                    ?>
                                                                                    <option value="<?php echo $district['id'];?>" <?php if($district['id']==set_value('district_id')){ echo 'selected="selected"';}?> ><?php echo $district['district'];?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            if(getRole() == 'SuperAdmin')
                                                                            {
                                                                                ?>
                                                                                <div id="districts">
                                                                                    <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)" >
                                                                                        <option value="">Select <?php echo $user_country->third_admin_level_label;?></option>
                                                                                        <option value="0">-All <?php echo $user_country->third_admin_level_label;?>-</option>

                                                                                    </select>

                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <div id="districts">
                                                                                    <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)" >
                                                                                        <option value="">Select <?php echo $user_country->third_admin_level_label;?></option>
                                                                                        <option value="0">-All <?php echo $user_country->third_admin_level_label;?>-</option>
                                                                                        <?php
                                                                                        foreach($districts as $key => $district)
                                                                                        {
                                                                                            ?>
                                                                                            <!-- <option value="<?php echo $district['id'];?>" <?php if($district['id']==set_value('district_id')){ echo 'selected="selected"';}?> ><?php echo $district['district'];?></option>-->
                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>


                                                            </div>

                                                        </div>

                                                        <div class="row-fluid">

                                                            <div class="span6">

                                                                <div class="control-group"><label class="control-label" for="form-field-1">From: </label><div class="controls">
                                                                        <select name="reporting_year" id="reporting_year">
                                                                            <option value="">Select Year</option>
                                                                            <?php
                                                                            $currentYear = date('Y')+1;
                                                                            foreach (range(2012, $currentYear) as $value) {
                                                                                ?>
                                                                                <option value="<?php echo $value;?>" <?php
                                                                                if($value==set_value('reporting_year'))
                                                                                {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                                ?>><?php echo $value;?></option>
                                                                                <?php

                                                                            }
                                                                            ?>
                                                                        </select> <select name="week_no" id="week_no" >
                                                                            <option value="">Select Week</option>
                                                                            <?php
                                                                            for($i=1;$i<=52;$i++)
                                                                            {
                                                                                ?>
                                                                                <option value="<?php echo $i;?>" <?php if(set_value('week_no')==$i){echo 'selected="selected"';}?>>Week <?php echo $i;?></option>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="span6">

                                                                <div class="control-group"><label class="control-label" for="form-field-1">To: </label><div class="controls">
                                                                        <select name="reporting_year2" id="reporting_year2">
                                                                            <option value="">Select Year</option>
                                                                            <?php
                                                                            $currentYear = date('Y')+1;
                                                                            foreach (range(2012, $currentYear) as $value) {
                                                                                ?>
                                                                                <option value="<?php echo $value;?>" <?php
                                                                                if($value==set_value('reporting_year2'))
                                                                                {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                                ?>><?php echo $value;?></option>
                                                                                <?php

                                                                            }
                                                                            ?>
                                                                        </select> <select name="week_no2" id="week_no2" >
                                                                            <option value="">Select Week</option>
                                                                            <?php
                                                                            for($i=1;$i<=52;$i++)
                                                                            {
                                                                                ?>
                                                                                <option value="<?php echo $i;?>" <?php if(set_value('week_no2')==$i){echo 'selected="selected"';}?>>Week <?php echo $i;?></option>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>



                                                <div class="form-actions"><?php echo form_submit('submit', 'Generate Report', 'class="btn btn-info "'); ?></div>


                                            </div><!---End inner accordion--->
                                        </div>
                                    </div>


                                </div>
                                <?php echo form_close(); ?>
                                   <p class="lead"> <strong>Zone:</strong> <?php echo $thezone;?>  <strong>Region:</strong> <?php echo $theregion;?> <strong>District:</strong> <?php echo $thedistrict;?>  <strong>Health Facility:</strong> <?php echo $thehealthfacility;?></p>
                                   
                                   <div class="row-fluid">
                    	<div class="span12">
                        
                        <div class="widget-box">
										<div class="widget-header">
											<h4 class="smaller">
												Malaria Report
												
											</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
                                                <?php
                                                $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','target'=>'_blank');
                                                echo form_open('reports/exportmalariareport',$attributes); ?>

                                                <input type="hidden" name="zone_id" value="<?php echo $zone_id;?>">
                                                <input type="hidden" name="region_id" value="<?php echo $region_id;?>">
                                                <input type="hidden" name="district_id" value="<?php echo $district_id;?>">
                                                <input type="hidden" name="from" value="<?php echo $from;?>">
                                                <input type="hidden" name="to" value="<?php echo $to;?>">
                                                <input type="hidden" name="reportingyear" value="<?php echo $reporting_year;?>">
                                                <input type="hidden" name="reportingyear2" value="<?php echo $reporting_year2;?>">


                                                <input type="submit" name="submit" value="Export to Excel" class="btn btn-success">


                                                <?php echo form_close(); ?>
												<p>
                                                
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
                categories: [<?php echo $categories;?>]
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
<script src="<?php echo base_url(); ?>js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>js/exporting.js"></script>
<div style="overflow-x:auto;">
<?php echo $report_table;?>
</div>
<hr>
<div id="cont" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
                                                
                                                </p>
												
											</div>
										</div>
									</div>
                        
                        </div>
                    
                    </div>
                      
                       
   
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
