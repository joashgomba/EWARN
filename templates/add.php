<? include(APPPATH . 'views/common/header.php'); ?>
<? include(APPPATH . 'views/common/top.php'); ?>
<? include(APPPATH . 'views/common/navigation.php'); ?>
<section id="content">
	<div class="g12">
		<p><?php echo anchor('{controller}/index/','Back to list',array('class'=>'back'));	 ?></p>
<?php 
$attributes = array('name' => 'form', 'id' => 'form', 'enctype' => 'multipart/form-data','data-ajax'=>'false');
 
echo form_open(current_url(),$attributes); ?>
<fieldset>
<label>Add</label>

<?php //echo $custom_error; ?>

{forms_inputs}

<section>
<div><button class="reset">Reset</button><button class="submit" name="submitbuttonname" value="submitbuttonvalue">Submit</button></div>

</section>

</fieldset>
<?php echo form_close(); ?>
</div>
</section><!-- end div #content -->
<? include(APPPATH . 'views/common/footer.php'); ?>