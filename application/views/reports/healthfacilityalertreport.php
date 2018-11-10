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

						<li class="active">Weekly HF Cases</li>
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
								Weekly HF Alerts &amp; Cases
							</small>
						</h1>
					</div><!--/.page-header-->
                
                       <h3 class="header smaller lighter green">
									
										Weekly Health Facility Disease Alerts &amp; Cases from <?php echo $reporting_year;?>/<?php echo $from;?> - <?php echo $reporting_year2;?>/<?php echo $to;?>
									</h3>
                            <?php
                            $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
                            echo form_open('reports/diseasecasesreport',$attributes); ?>

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
                                                            <div class="span6">

                                                                <div class="control-group"><label class="control-label" for="form-field-1">Health facility</label><div class="controls">

                                                                        <div id="healthfacilities">
                                                                            <?php

                                                                            if($level==2)//FP
                                                                            {
                                                                                ?>
                                                                                <select name="healthfacility_id" id="healthfacility_id">
                                                                                    <option value="">-All health facilities-</option>
                                                                                    <option value="">Select Health Facility</option>
                                                                                    <?php
                                                                                    foreach($healthfacilities->result() as $healthfacility)
                                                                                    {
                                                                                        ?>
                                                                                        <!--<option value="<?php echo $healthfacility->healthfacility_id;?>" <?php if($healthfacility->healthfacility_id==set_value('healthfacility_id')){ echo 'selected="selected"';}?>><?php echo $healthfacility->health_facility;?></option>-->
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                                <?php
                                                                            }
                                                                            else if($level==6)//district
                                                                            {
                                                                                ?>
                                                                                <select name="healthfacility_id" id="healthfacility_id">
                                                                                    <?php
                                                                                    foreach($healthfacilities as $key=>$healthfacility):
                                                                                        ?>
                                                                                        <option value="<?php echo $healthfacility['id'];?>"><?php echo $healthfacility['health_facility'];?></option>
                                                                                        <?php
                                                                                    endforeach;
                                                                                    ?>
                                                                                </select>
                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <select name="healthfacility_id" id="healthfacility_id">
                                                                                    <option value="">Select Health Facility</option>
                                                                                </select>
                                                                                <!-- <select name="healthfacility_id" id="healthfacility_id">
                                  <option value="">Select Health Facility</option>
                                  <?php
                                                                                foreach($healthfacilities as $key => $healthfacility)
                                                                                {
                                                                                    ?>
                                  <option value="<?php echo $healthfacility['id'];?>" <?php if($healthfacility['id']==set_value('healthfacility_id')){ echo 'selected="selected"';}?>><?php echo $healthfacility['health_facility'];?></option>
                                  <?php
                                                                                }
                                                                                ?>
                                  </select>-->
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </div>

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

                                <?php
                                $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','target'=>'_blank');
                                echo form_open('reports/exporthfalert',$attributes); ?>

                                <input type="hidden" name="zone_id" value="<?php echo $zone_id;?>">
                                <input type="hidden" name="region_id" value="<?php echo $region_id;?>">
                                <input type="hidden" name="district_id" value="<?php echo $district_id;?>">
                                <input type="hidden" name="healthfacility_id" value="<?php echo $healthfacility_id;?>">
                                <input type="hidden" name="from" value="<?php echo $from;?>">
                                <input type="hidden" name="to" value="<?php echo $to;?>">
                                <input type="hidden" name="reportingyear" value="<?php echo $reporting_year;?>">
                                <input type="hidden" name="reportingyear2" value="<?php echo $reporting_year2;?>">


                                <input type="submit" name="submit" value="Export to Excel" class="btn btn-success">


                                <?php echo form_close(); ?>

                                   <div class="row-fluid">
                    	<div class="span12">
                        
                        <div class="widget-box">
										<div class="widget-header">
											<h4 class="smaller">
												Weekly Health Facility Disease Alerts
												
											</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
                                            
                                          
												<p>
                                                <div style="overflow-x:auto;">
                                                <?php echo $tbl;?>
                                                </div>
                                                </p>
												
											</div>
										</div>
									</div>
                        
                        </div>
                    
                    </div>
                    
                    <div class="row-fluid">
                    	<div class="span12">
                        
                        <div class="widget-box">
										<div class="widget-header">
											<h4 class="smaller">
												Weekly Health Facility Disease Cases
												
											</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
                                            
                                          
												<p>
                                                <div style="overflow-x:auto;">
                                                <?php echo $table;?>
                                                </div>
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
