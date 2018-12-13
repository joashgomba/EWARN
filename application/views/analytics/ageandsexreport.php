<?php include(APPPATH . 'views/common/header.php'); ?>
<script src="<?php echo base_url(); ?>js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>js/exporting.js"></script>

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

                <li class="active">Age and sex distribution of diseases by cases</li>
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
                                Age and sex distribution of diseases by cases</small>
                        </h1>
                    </div><!--/.page-header-->
                    <?php
                    if(validation_errors())
                    {
                        ?>
                        <p><div class="alert alert-danger"> <?php echo validation_errors(); ?></div></p>
                        <?php
                    }
                    if(!empty($error_message))
                    {
                        ?>
                        <p><div class="alert alert-danger"> <?php echo $error_message; ?></div></p>
                        <?php
                    }
                    ?>
                    <?php
                    $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
                    echo form_open('analytics/ageandsexreport',$attributes); ?>

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


                                    </div><!---End inner accordion--->
                                </div>
                            </div>


                        </div>

                            <?php echo form_close(); ?>

                            <p class="lead"> <strong>Zone:</strong> <?php echo $thezone;?>  <strong>Region:</strong> <?php echo $theregion;?> <strong>District:</strong> <?php echo $thedistrict;?>  <strong>Health Facility:</strong> <?php echo $thehealthfacility;?></p>


                            <div class="widget-box">
                                <div class="widget-header widget-header-flat">
                                    <h4>Age and sex distribution of diseases by cases by EPI week <?php echo $from;?> <?php echo $reporting_year;?></h4>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main">

                                        <div class="row-fluid">


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
                                                        series: [<?php echo $series;?>],
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
                                                            title: {
                                                                text: 'Cases'
                                                            }
                                                        },  credits: {
                                                            enabled: false
                                                        }
                                                    });
                                                });
                                            </script>
                                            <div id="categorycont" style="min-width: 100%; height: 400px; margin: 0 auto"></div>

                                        </div>
                                    </div>
                                </div>

                                <div class="widget-box">
                                    <div class="widget-header widget-header-flat">
                                        <h4>Age and sex distribution of diseases by cases EPI Week <?php echo $from;?> <?php echo $reporting_year;?></h4>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <?php
                                                    $attributes = array('name' => 'myfrm', 'id' => 'myfrm', 'enctype' => 'multipart/form-data','target'=>'_blank');
                                                    echo form_open('analytics/exportageandsex',$attributes); ?>

                                                    <input type="hidden" name="zone_id" value="<?php echo $zone_id;?>">
                                                    <input type="hidden" name="region_id" value="<?php echo $region_id;?>">
                                                    <input type="hidden" name="district_id" value="<?php echo $district_id;?>">
                                                    <input type="hidden" name="from" value="<?php echo $from;?>">
                                                    <input type="hidden" name="reportingyear" value="<?php echo $reporting_year;?>">
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
