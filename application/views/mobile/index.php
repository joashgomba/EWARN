<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" class="">
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Early Warning Alert and Response Network System | WHO</title>
<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>js/respond.min.js"></script>
</head>
<body>
<div id="wrapper">
<div class="bg">
 <div class="logo"><a href=""><img src="<?php echo base_url(); ?>img/logo.jpg" /></a></div>
 <div class="intro">EARLY WARNING ALERT AND RESPONSE NETWORK SYSTEM</div>
 </div>
 <div class="form">
 
<?php     

$attributes = array('name' => 'loginform','enctype' => 'multipart/form-data');

echo form_open('verifymoblelogin',$attributes); ?>
 <?php echo validation_errors(); ?>
 <label>USERNAME:</label>
 <input type="text" id="username" name="username" value="<?php echo set_value('username'); ?>" />
  <label>PASSWORD:</label>
 <input type="password"  id="password" name="password" value=""/>
 <input type="submit"  value="LOGIN"/>
 </form>
 </div>
</div>
</body>
</html>
