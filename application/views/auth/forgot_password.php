<?php include(APPPATH . 'views/common/header.php'); ?>
<body class="nobg loginPage">
<!-- Top fixed navigation -->
<div class="topNav">
    <div class="wrapper">
        <div class="userNav">
            <ul>
                <li><a href="<?php echo site_url('auth/login');?>" title=""><img src="<?php echo base_url(); ?>images/icons/topnav/mainWebsite.png" alt="" /><span>Back to login</span></a></li>
               
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</div>



<!-- Main content wrapper -->
<div class="loginWrapper">
    <div class="loginLogo"><img src="<?php echo base_url(); ?>images/loginLogo.png" alt="" /></div>
    <div class="widget">
        <div class="title"><img src="<?php echo base_url(); ?>images/icons/dark/files.png" alt="" class="titleIcon" /><h6>Forgot Password</h6></div>
          	<?php 
        	$attributes = array('name' => 'validate', 'id' => 'validate', 'enctype' => 'multipart/form-data','class' => 'form');
        	echo form_open("auth/forgot_password",$attributes);?>
        	<div id="infoMessage"><?php echo $message;?></div>
            <fieldset>
            	
                <div class="formRow">
                    <label for="login">Please enter your <?php echo $identity_label; ?> so we can send you an email to reset your password.</label>
                    <div class="clear"></div>
                </div>
                
                <div class="formRow">
                    <label for="pass"><?php echo $identity_label; ?>:</label>
                    <div class="loginInput"><?php echo form_input($email);?></div>
                    <div class="clear"></div>
                </div>
                
                <div class="loginControl">
                    <input type="submit" value="Submit" class="dredB logMeIn" /><br>
                     <div class="clear"></div>
                     
                </div>
            </fieldset>
       <?php echo form_close();?>
    </div>
</div>    

<!-- Footer line -->
<div id="footer">
    <div class="wrapper">All rights reserved. Danish Refugee Council</div>
</div>

</body>
</html>