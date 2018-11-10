<?php include(APPPATH . 'views/common/header.php'); ?>

		<body>
			<?php include(APPPATH . 'views/common/navbar.php'); ?>
				<div class="main-container container-fluid">
					<a class="menu-toggler" id="menu-toggler" href="#">
						<span class="menu-text"></span>
					</a>
					<?php include(APPPATH . 'views/common/sidebar.php'); ?>
					<div class="main-content">
						<!--.breadcrumb--><div class="breadcrumbs" id="breadcrumbs">
							<ul class="breadcrumb">
								<li>
									<i class="icon-home home-icon"></i>
										<a href="<?php echo site_url('home')?>">Home</a>
										<span class="divider">
											<i class="icon-angle-right arrow-icon"></i>
										</span>
								</li>
								<li class="active">diseases</li>
							</ul><!--.breadcrumb-->
						<div class="nav-search" id="nav-search">
							<form class="form-search" method="post" action="" />
								<span class="input-icon">
									<input type="text" name="search" placeholder="Search ..." class="input-small nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="icon-search nav-search-icon"></i>
								</span>
							</form>
						</div>
					</div>
					<div class="page-content">
						<div class="row-fluid">
							<div class="span12">
								<!--PAGE CONTENT BEGINS-->
								<div class="page-header position-relative">
									<h1>
										Configuration
										<small>
											<i class="icon-double-angle-right"></i>
											diseases
										</small>
									</h1>
								</div>
                                 <?php $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data', 'class'=>'form-horizontal');
					  echo form_open('diseases/filter',$attributes); ?>
                      
                     <?php
					 if (getRole() == 'SuperAdmin')
					 {
						 ?>
                         <div id="accordion2" class="accordion">
										<div class="accordion-group">
											<div class="accordion-heading">
												<a href="#collapseOne" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">
													Filter records
												</a>
											</div>

											<div class="accordion-body collapse" id="collapseOne">
												<div class="accordion-inner">
													
                                                    <div class="widget-box">
										<div class="widget-header widget-header-flat">
											<h4>Select filter parameters</h4>
										</div>
                                        
                                       

										<div class="widget-body">
											<div class="widget-main">
												
	<div class="row-fluid">

<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Country: </label><div class="controls">
<?php
if (getRole() == 'Admin')
{
	$country = $this->countriesmodel->get_by_id($country_id)->row();
	
	?>
   <select name="country_id" id="country_id" required="required">
    <option value=""> - Select Country - </option>
     <option value="<?php echo $country->id;?>"> <?php echo $country->country_name;?> </option>
    
     </select>
    <?php
}
else
{
	?>
    <select name="country_id" id="country_id" required="required">
    <option value=""> - Select Country - </option>
    <?php
	foreach($countries as $key=>$country)
	{
		?>
        <option value="<?php echo $country['id'];?>"> <?php echo $country['country_name'];?> </option>
        <?php
	}
	?>
    </select>
    
    <?php
	
}
?>
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">&nbsp; </label><div class="controls">
&nbsp;
</div>
</div>


</div>
</div>




<div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo form_submit('submit', 'FILTER RECORDS', 'class="btn btn-info "'); ?> </label><div class="controls">
&nbsp;
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">&nbsp; </label><div class="controls">
&nbsp;
</div>
</div>

</div>
</div>


		
											</div>
										</div>
									</div>
                                                    
                                                    
												</div>
											</div>
										</div>

										

										
									</div>
                         <?php
					 }
					 ?>
                 <?php echo form_close(); ?>
                 
								<p>
									<a href="<?php echo base_url() ?>index.php/diseases/add"  class="btn btn-primary">
										<i class="icon-edit bigger-110"></i>
									Add
									</a>
								</p>


<table id="sample-table-1" class="table table-striped table-bordered table-hover">
<thead>
 <tr>
<th colspan="6">
<div class="pagination">
<?php echo $links; ?>
 </div>
 
</th>
</tr>
<tr>
<th>Country</th>
<th>Disease category</th>
<th>Disease code</th>
<th>Disease name</th>
<th>Colour</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($rows as $row): ?>
<tr>
<td><?php 
$country = $this->countriesmodel->get_by_id($row['country_id'])->row(); 
echo $country->country_name;?></td>
<td><?php 
$diseasecategory = $this->diseasecategoriesmodel->get_by_id($row['diseasecategory_id'])->row(); 
echo $diseasecategory->category_name;
?></td>
<td><?php echo $row['disease_code']; ?></td>
<td><?php echo $row['disease_name']; ?></td>
<td><strong><font color="<?php echo $row['color_code']; ?>"><?php echo $row['color_code']; ?></font></strong></td>
<td><a href="<?php echo base_url() ?>index.php/diseases/edit/<?php echo $row['id']; ?>" class="tooltip-success" data-rel="tooltip" title="Edit">
 <span class="green">
 <i class="icon-edit bigger-120"></i>

																	</span></a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
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
