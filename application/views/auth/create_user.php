<?php include(APPPATH . 'views/common/header.php'); ?>

<body>

<?php include(APPPATH . 'views/common/left.php'); ?>


<!-- Right side -->
<div id="rightSide">

   <?php include(APPPATH . 'views/common/top.php'); ?>
    
   <?php include(APPPATH . 'views/common/responsiveheader.php'); ?>
    
    <!-- Title area -->
    <div class="titleArea">
        <div class="wrapper">
            <div class="pageTitle">
                <h5>Users</h5>
              
            </div>
            <div class="middleNav">
              
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="line"></div>
    
       
    <!-- Main content wrapper -->
<div class="wrapper">
	<div class="widget">
<div class="title"><img src="<?php echo base_url(); ?>images/icons/dark/list.png" alt="" class="titleIcon" /><h6>Create User</h6></div>

<?php
    	if(!empty($message))
		{
		?>
		
    <div class="nNote nFailure hideit"><p><?php echo $message;?></p></div>
	   <?php
	   }
	   ?>

<?php 
$attributes = array('name' => 'validate', 'id' => 'validate', 'enctype' => 'multipart/form-data','class' => 'form');
echo form_open("auth/create_user",$attributes);?>
		
                            <div class="formRow">
                                <label>First Name: </label>
                                <div class="formRight"><?php echo form_input($first_name);?></div>
                                <div class="clear"></div>
                            </div>
                      
                            <div class="formRow">
                                <label>Last Name: </label>
                                <div class="formRight"><?php echo form_input($last_name);?></div>
                                <div class="clear"></div>
                            </div>
                       
                            <div class="formRow">
                                <label>Company Name: </label>
                                <div class="formRight"><?php echo form_input($company);?></div>
                                <div class="clear"></div>
                            </div>
                       
                            <div class="formRow">
                                <label>Email: </label>
                                <div class="formRight"><?php echo form_input($email);?></div>
                                <div class="clear"></div>
                            </div>
                       
                            <div class="formRow">
                                <label>Phone: </label>
                                <div class="formRight"> <?php echo form_input($phone1);?>-<?php echo form_input($phone2);?>-<?php echo form_input($phone3);?></div>
                                <div class="clear"></div>
                            </div>
                      
                            <div class="formRow">
                                <label>Password: </label>
                                <div class="formRight"><?php echo form_input($password);?></div>
                                <div class="clear"></div>
                            </div>
              
                            <div class="formRow">
                                <label>Confirm Password: </label>
                                <div class="formRight"><?php echo form_input($password_confirm);?></div>
                                <div class="clear"></div>
                            </div>
                      

	 
      <p><?php echo form_submit('submit', 'Create User');?></p>

<?php echo form_close();?>
</div>
</div>
    
    <!-- Footer line -->
  <?php include(APPPATH . 'views/common/footer.php'); ?>

</div>

<div class="clear"></div>

</body>
</html>