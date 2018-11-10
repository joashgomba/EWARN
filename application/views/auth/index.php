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
    
    <!-- Page statistics area -->
    <div class="statsRow">
        <div class="wrapper">
        	<div class="controlB">
            	<ul>
                	<li><a href="<?php echo site_url('auth/create_user');?>" title=""><img src="<?php echo base_url(); ?>images/icons/control/32/hire-me.png" alt="" /><span>Add new user</span></a></li>
                   </ul>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    
    <div class="line"></div>
    
    <!-- Main content wrapper -->
    <div class="wrapper">
    	<?php
    	if(!empty($message))
		{
		?>
		
    <div class="nNote nInformation hideit"><p><?php echo $message;?></p></div>
	   <?php
	   }
	   ?>
        <!-- Dynamic table -->
        <div class="widget">
        	
            <div class="title"><img src="<?php echo base_url(); ?>images/icons/dark/full2.png" alt="" class="titleIcon" /><h6>Users</h6></div> 
            
            <table cellpadding="0" cellspacing="0" border="0" class="display dTable" width="80%">
            	<thead>
					<tr>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Email</th>
						<th>Groups</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
			<?php foreach ($users as $user):?>
				<tr class="gradeC">
					<td><?php echo $user->first_name;?></td>
					<td><?php echo $user->last_name;?></td>
					<td><?php echo $user->email;?></td>
					<td>
						<?php foreach ($user->groups as $group):?>
							<?php echo anchor("auth/edit_group/".$group->id, $group->name) ;?><br />
		                <?php endforeach?>
					</td>
					<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, 'Active') : anchor("auth/activate/". $user->id, 'Inactive');?></td>
					<td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
            
           
        </div>
    
    </div>
    
    <!-- Footer line -->
  <?php include(APPPATH . 'views/common/footer.php'); ?>

</div>

<div class="clear"></div>

</body>
</html>