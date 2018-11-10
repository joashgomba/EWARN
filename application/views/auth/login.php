<?php include(APPPATH . 'views/common/header.php'); ?>
<body class="nobg loginPage">
<!-- Top fixed navigation -->
<div class="topNav">
    <div class="wrapper">
        <div class="userNav">
            <ul>
                <li><a href="#" title=""><img src="<?php echo base_url(); ?>images/icons/topnav/mainWebsite.png" alt="" /><span>Main website</span></a></li>
               
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</div>


<!-- Main content wrapper -->
<div class="loginWrapper">
  <div class="loginLogo"><img src="<?php echo base_url(); ?>images/logo.png" alt="" /></div>
    <div class="widget">
        <div class="title"><img src="<?php echo base_url(); ?>images/icons/dark/files.png" alt="" class="titleIcon" /><h6>Login panel</h6></div>
          	<?php 
        	$attributes = array('name' => 'validate', 'id' => 'validate', 'enctype' => 'multipart/form-data','class' => 'form');
        	echo form_open("auth/login",$attributes);?>
        	<div id="infoMessage"><?php echo $message;?></div>
            <fieldset>
            	
                <div class="formRow">
                    <label for="login">Email/Username:</label>
                    <div class="loginInput"> <?php echo form_input($identity);?></div>
                    <div class="clear"></div>
                </div>
                
                <div class="formRow">
                    <label for="pass">Password:</label>
                    <div class="loginInput"><?php echo form_input($password);?></div>
                    <div class="clear"></div>
                </div>
                
                <div class="loginControl">
                    <div class="rememberMe"><?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?><label for="remMe">Remember me</label></div>
                    <input type="submit" value="Log me in" class="dredB logMeIn" /><br>
                    <div class="rememberMe"><a href="forgot_password">Forgot your password?</a></div>
                    <div class="clear"></div>
                     <div class="clear"></div>
                     
                </div>
            </fieldset>
       <?php echo form_close();?>
    </div>
</div>    

<!-- Footer line -->
<div id="footer">
    <div class="wrapper">All rights reserved. CISP Somalia</div>
</div>

</body>
</html>