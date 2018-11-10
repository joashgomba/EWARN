<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html xmlns:br="http://www.w3.org/1999/xhtml" class="">
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Early Warning Alert and Response Network System </title>
<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css" />
 <style>
	
	select {
        width: 80%;
        font-size: 20px;
        text-align: center;
        margin: 5px 0;
    }
	
	</style>
</head>
<body>
<div id="wrapper ">
 <div class="bg"><a href=""></a>
  <div class="intro">EARLY WARNING ALERT AND RESPONSE NETWORK SYSTEM </div>
  <div class="intro"><div align="right"><a href="<?php echo site_url('mobile/home')?>">Add</a> | <a href="<?php echo site_url('mobile/edit')?>">Edit</a>| <a href="<?php echo site_url('mobile/logout')?>">Logout</a></div></div>
  </div>
  <?php echo $error; ?>
 <div class="intro">Reporting form	</div>
 <div class="form">
    <?php 
$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
echo form_open('mobile/getdata',$attributes); 
						  ?>
     <ul>
      <li>

 <label>Reporting Year</label>
 <select name="reporting_year" id="reporting_year" onChange="GetPeriod(this)">
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
                               </select>
          </li>
         <li>
  <label>Week No.</label>
<select name="week_no" id="week_no" onChange="GetPeriod(this)">
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
         </li>
         <li><div id="reporingperiods">
            &nbsp;
         </div></li>
         </ul>
         <input type="submit" value="GET DATA" />     
 </form>
 
 </div>
</div>
</body>
</html>
