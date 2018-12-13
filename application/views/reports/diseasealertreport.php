<?php include(APPPATH . 'views/common/header.php'); ?>
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

    function openModal() {
        document.getElementById('themodal').style.display = 'block';
        document.getElementById('fade').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('themodal').style.display = 'none';
        document.getElementById('fade').style.display = 'none';
    }

    function GetZones(frm){
        if(validateForm(frm)){
            document.getElementById('zones').innerHTML='';
            var url = "<?php echo base_url(); ?>/index.php/users/getzones";

            var params = "country_id=" + totalEncode(document.frm.country_id.value ) ;
            var connection=connect(url,params);

            connection.onreadystatechange = function(){
                if(connection.readyState == 4){
                    document.getElementById('zones').innerHTML=connection.responseText;


                }
                if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('zones').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
    }


    function GetHealthFacilities(frm){
        if(validateForm(frm)){
            document.getElementById('healthfacilities').innerHTML='';

            var url = "<?php echo base_url(); ?>index.php/datalist/gethealthfacilities";

            var params = "district_id=" + totalEncode(document.frm.district_id.value );
            var connection=connect(url,params);

            connection.onreadystatechange = function(){
                if(connection.readyState == 4){

                    document.getElementById('healthfacilities').innerHTML=connection.responseText;


                }
                if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('healthfacilities').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
    }

    function GetRegions(frm){
        if(validateForm(frm)){
            document.getElementById('regions').innerHTML='';
            var url = "<?php echo base_url(); ?>index.php/users/getregions";

            var params = "zone_id=" + totalEncode(document.frm.zone_id.value );
            var connection=connect(url,params);
            var district_element = '<select id="district_id" name="district_id">' + '<option value="0">Select One</option>' + '</select>';
            var healthfacility_element = '<select id="healthfacility_id" name="healthfacility_id">' + '<option value="0">Select One</option>' + '</select>';

            connection.onreadystatechange = function(){
                if(connection.readyState == 4){
                    document.getElementById('regions').innerHTML=connection.responseText;
                    document.getElementById('districts').innerHTML= district_element;
                    document.getElementById('healthfacilities').innerHTML= healthfacility_element;


                }
                if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('regions').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
    }


    function GetDistricts(frm){
        if(validateForm(frm)){
            document.getElementById('districts').innerHTML='';
            var url = "<?php echo base_url(); ?>index.php/export/getdistricts";

            var params = "region_id=" + totalEncode(document.frm.region_id.value );
            var connection=connect(url,params);
            var health_element = '<select id="healthfacility_id" name="healthfacility_id">' + '<option value="">Select One</option>' + '</select>';

            connection.onreadystatechange = function(){
                if(connection.readyState == 4){
                    document.getElementById('districts').innerHTML=connection.responseText;
                    document.getElementById('healthfacilities').innerHTML= health_element;


                }
                if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('districts').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
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
								Weekly Disease Alerts
							</small>
						</h1>
					</div><!--/.page-header-->
                    <h3 class="header smaller lighter green">
										<i class="icon-bullhorn"></i>
										Weekly Disease Alerts from <?php echo $reporting_year;?>/<?php echo $from;?> - <?php echo $reporting_year2;?>/<?php echo $to;?>
									</h3>

                            <?php
                            $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
                            echo form_open('reports/diseasealertreport',$attributes); ?>

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
                                                                            $currentYear = date('Y');
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
                                                                            $currentYear = date('Y');
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
												Weekly Disease Alerts
												
											</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
                                            <p>
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
                text: 'Weekly Disease Alerts <?php echo $reporting_year;?> Week <?php echo $from;?> to <?php echo $reporting_year2;?> Week <?php echo $to;?>'
            },
            xAxis: {
            },
            yAxis: {
                title: {
                    text: 'Alerts'
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
                                            <hr>
                                                <?php
                                                $attributes = array('name' => 'myfrm', 'id' => 'myfrm', 'enctype' => 'multipart/form-data','target'=>'_blank');
                                                echo form_open('reports/exportdiseasealert',$attributes); ?>

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
