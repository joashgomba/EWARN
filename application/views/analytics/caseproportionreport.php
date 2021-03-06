<?php include(APPPATH . 'views/common/header.php'); ?>
<SCRIPT language=Javascript>
    <!--
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    //-->
</SCRIPT>

<style>
    #themodal {
        display: none;
        position: absolute;
        top: 45%;
        left: 45%;
        width: 64px;
        height: 64px;
        padding:30px 15px 0px;
        border: 3px solid #ababab;
        box-shadow:1px 1px 10px #ababab;
        border-radius:20px;
        background-color: white;
        z-index: 1002;
        text-align:center;
        overflow: auto;
    }

    #fade {
        display: none;
        position:absolute;
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100%;
        background-color: #ababab;
        z-index: 1001;
        -moz-opacity: 0.8;
        opacity: .70;
        filter: alpha(opacity=80);
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

<script>

    function openModal() {
        document.getElementById('themodal').style.display = 'block';
        document.getElementById('fade').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('themodal').style.display = 'none';
        document.getElementById('fade').style.display = 'none';
    }

</script>

<script type="text/javascript">
    <!--
// Form validation code will come here.

        function validate()
        {

            if( document.frm.reporting_year.value == "" )
            {
                alert( "Please enter the from reporting year" );
                document.frm.reporting_year.focus() ;
                return false;
            }

            if( document.frm.week_no.value == "" )
            {
                alert( "Please enter the from week number" );
                document.frm.week_no.focus() ;
                return false;
            }

            if( document.frm.reporting_year2.value == "" )
            {
                alert( "Please enter the to reporting year" );
                document.frm.reporting_year2.focus() ;
                return false;
            }

            if( document.frm.week_no2.value == "" )
            {
                alert( "Please enter the to week number" );
                document.frm.week_no2.focus() ;
                return false;
            }

            var e = document.getElementById("reporting_year");
            var repyearone = e.options[e.selectedIndex].value;

            var y = document.getElementById("reporting_year2");
            var repyeartwo = y.options[y.selectedIndex].value;

            var x = document.getElementById("week_no");
            var fromval = x.options[x.selectedIndex].value;

            var z = document.getElementById("week_no2");
            var toval = z.options[z.selectedIndex].value;

            if(repyearone>repyeartwo)
            {
                alert( "The year from cannot be greater than the year to" );
                document.frm.reporting_year.focus() ;
                return false;
            }

            if(repyearone==repyeartwo)
            {
                if(Number(fromval)>Number(toval))
                {
                    alert( "The week from cannot be greater than the week to on the same year." );
                    document.frm.week_no.focus() ;
                    return false;
                }
            }

            var checked=false;
            var elements = document.getElementsByName("disease[]");
            for(var i=0; i < elements.length; i++){
                if(elements[i].checked) {
                    checked = true;
                }
            }
            if (!checked) {
                alert('Please select diseases');
            }
            return checked;

            return( true );
        }

</script>

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

                <li class="active">Proportion of cases by EPI week</li>
            </ul><!--.breadcrumb-->


        </div>

        <div class="page-content">
            <div class="row-fluid">
                <div class="span12">
                    <!--PAGE CONTENT BEGINS-->
                    <div class="page-header position-relative">
                        <h1>
                            Analytics
                            <small>
                                <i class="icon-double-angle-right"></i>
                                Proportion of cases by EPI week</small>
                        </h1>
                    </div><!--/.page-header-->
                    <?php
                    if(validation_errors())
                    {
                        ?>
                        <p><div class="alert alert-danger"> <?php echo validation_errors(); ?></div></p>
                        <?php
                    }
                    ?>
                    <?php
                    $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
                    echo form_open('analytics/caseproportionreport',$attributes); ?>

                    <div id="accordion2" class="accordion">
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a href="#collapseOne" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">
                                    Click here to Search Again
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

                                                <div class="row-fluid">

                                                    <div class="span6">

                                                        <div class="control-group"><label class="control-label" for="form-field-1">Diseases: </label><div class="controls">
                                                                <?php
                                                                foreach ($diseases->result() as $disease):
                                                                    ?>
                                                                    <div class="controls">
                                                                        <label>
                                                                            <input name="disease[]" type="checkbox" value="<?php echo $disease->disease_code;?>" />
                                                                            <span class="lbl"> <?php echo $disease->disease_name;?> (<?php echo $disease->disease_code;?>)</span>
                                                                        </label>
                                                                    </div>
                                                                    <?php

                                                                endforeach;
                                                                ?>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="span6">

                                                        <div class="control-group"><label class="control-label" for="form-field-1">Render As: </label><div class="controls">
                                                                <select name="render" id="render">
                                                                    <option value="line">Line</option>
                                                                    <option value="bar">Bar</option>
                                                                    <option value="column">Column</option>
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


                        <div class="widget-box">
                            <div class="widget-header widget-header-flat">
                                <h4>Proportion of cases by EPI week</h4>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">

                                    <div class="row-fluid">
                                        <script type="text/javascript">
                                            $(function () {
                                                var chart;
                                                $(document).ready(function() {
                                                    chart = new Highcharts.Chart({
                                                        chart: {
                                                            renderTo: 'linecontainer',
                                                            type: '<?php echo $render;?>',
                                                            marginRight: 130,
                                                            marginBottom: 25
                                                        },
                                                        title: {
                                                            text: 'Proportion of cases of <?php echo $label;?> by EPI week <?php echo $from; ?> <?php echo $reporting_year; ?> to week <?php echo $to; ?> <?php echo $reporting_year2; ?>',
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
                                        <script src="<?php echo base_url(); ?>js/highcharts.js"></script>
                                        <script src="<?php echo base_url(); ?>js/exporting.js"></script>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-box">
                                <div class="widget-header widget-header-flat">
                                    <h4>Breakdown of proportion of cases by EPI week from <?php echo $reporting_year;?> week <?php echo $from;?> to <?php echo $reporting_year2;?> week <?php echo $to;?></h4>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="row-fluid">
                                            <div class="span12">
                                                <?php
                                                $attributes = array('name' => 'myfrm', 'id' => 'myfrm', 'enctype' => 'multipart/form-data','target'=>'_blank');
                                                echo form_open('analytics/exportcaseproportion',$attributes); ?>

                                                <input type="hidden" name="zone_id" value="<?php echo $zone_id;?>">
                                                <input type="hidden" name="region_id" value="<?php echo $region_id;?>">
                                                <input type="hidden" name="district_id" value="<?php echo $district_id;?>">
                                                <input type="hidden" name="healthfacility_id" value="<?php echo $healthfacility_id;?>">
                                                <input type="hidden" name="from" value="<?php echo $from;?>">
                                                <input type="hidden" name="to" value="<?php echo $to;?>">
                                                <input type="hidden" name="reportingyear" value="<?php echo $reporting_year;?>">
                                                <input type="hidden" name="reportingyear2" value="<?php echo $reporting_year2;?>">
                                                <?php

                                                foreach ($mydiseases as $mydisease):
                                                    ?>
                                                    <input type="hidden" name="mydisease[]" value="<?php  echo $mydisease;?>">
                                                    <?php

                                                endforeach;
                                                ?>


                                                <input type="submit" name="submit" value="Export to Excel" class="btn btn-success">


                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>

                                        <div class="row-fluid">
                                            <p><?php echo $table; ?></p>

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
