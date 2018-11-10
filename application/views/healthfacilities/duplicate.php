<html>
<head>
</head>
  <body>
    <?php $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data', 'class'=>'form-horizontal');
echo form_open('duplicate/generatesql',$attributes); ?>
<?php echo form_submit('submit', 'GET SQL', 'class="btn btn-info "'); ?>
    <?php echo $table; ?>


<?php echo form_submit('submit', 'GET SQL', 'class="btn btn-info "'); ?>

    <?php echo form_close(); ?>
  </body>
</html>
