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

            connection.onreadystatechange = function(){
                if(connection.readyState == 4){
                    document.getElementById('regions').innerHTML=connection.responseText;
                    document.getElementById('districts').innerHTML= district_element;

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

                <li class="active"> Age and sex distribution of diseases by cases</li>
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
                                Age and sex distribution of diseases by cases </small>
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
                    echo form_open('analytics/ageandsexreport',$attributes); ?>

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
                                                            <option value="<?php echo $zone['id'];?>" <?php if(set_value('zone_id')==$zone['id']){echo 'selected="selected"';}?>><?php echo $zone['zone'];?></option>
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
                                                                <option value="<?php echo $zone['id'];?>" <?php if(set_value('zone_id')==$zone['id']){echo 'selected="selected"';}?>><?php echo $zone['zone'];?></option>
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

                                        <div class="control-group"><label class="control-label" for="form-field-1">EPI Week: </label><div class="controls">
                                                <select name="reporting_year" id="reporting_year" required="required">
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
                                                </select> <select name="week_no" id="week_no" required="required">
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

                                </div>

                                <div class="row-fluid">

                                    <div class="span12">

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
                                </div>


                        </div>
                    </div>



                    <div class="form-actions"><?php echo form_submit('submit', 'Generate Report', 'class="btn btn-info "'); ?></div>


                        <?php echo form_close(); ?>
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
