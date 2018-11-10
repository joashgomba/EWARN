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
	 <?php 
	 $attributes = array('name' => 'validate', 'id' => 'validate', 'enctype' => 'multipart/form-data','class' => 'form');
	 echo form_open(uri_string(),$attributes);?>
            <fieldset>
                <div class="widget">
                <div class="title"><img src="<?php echo base_url(); ?>images/icons/dark/list.png" alt="" class="titleIcon" /><h6>Edit User</h6></div>
   <?php
    	if(!empty($message))
		{
		?>
		
    <div class="nNote nFailure hideit"><p><?php echo $message;?></p></div>
	   <?php
	   }
	   ?>
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
                                <label>Phone: </label>
                                <div class="formRight"> <?php echo form_input($phone1);?>-<?php echo form_input($phone2);?>-<?php echo form_input($phone3);?></div>
                                <div class="clear"></div>
                            </div>
                     
   
                            <div class="formRow">
                                <label>Password: (if changing password) </label>
                                <div class="formRight"><?php echo form_input($password);?></div>
                                <div class="clear"></div>
                            </div>
                       
                            <div class="formRow">
                                <label>Confirm Password: (if changing password) </label>
                                <div class="formRight"><?php echo form_input($password_confirm);?></div>
                                <div class="clear"></div>
                            </div>
                             <div class="formRow">
                                <label>Member of groups</label>
                                <div class="formRight">
								<?php foreach ($groups as $group):?>
	<label class="checkbox">
	<?php
		$gID=$group['id'];
		$checked = null;
		$item = null;
		foreach($currentGroups as $grp) {
			if ($gID == $grp->id) {
				$checked= ' checked="checked"';
			break;
			}
		}
	?>
	<input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
	<?php echo $group['name'];?>
	</label>
	<?php endforeach?>

      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>

								</div>
                                <div class="clear"></div>
                            </div>
                       

                </div>
            </fieldset>
             <p><?php echo form_submit('submit', 'Save User');?></p>
  <?php echo form_close();?>
</div>
    
    <!-- Footer line -->
  <?php include(APPPATH . 'views/common/footer.php'); ?>

</div>

<div class="clear"></div>

</body>
</html>
