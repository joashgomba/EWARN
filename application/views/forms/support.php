<?php include(APPPATH . 'views/common/header.php'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.js"></script>

<script>
		
   function trim(str){
	return str.replace(/^\s\s*/, '').replace(/\s\s*$/, '');}
	function totalEncode(str){
	var s=escape(trim(str));
	s=s.replace(/\+/g,"+");
	s=s.replace(/@/g,"@");
	s=s.replace(/\//g,"/");
	s=s.replace(/\*/g,"*");
	return(s);
	}
	function connect(url,params)
	{
	var connection;  // The variable that makes Ajax possible!
	try{// Opera 8.0+, Firefox, Safari
	connection = new XMLHttpRequest();}
	catch (e){// Internet Explorer Browsers
	try{
	connection = new ActiveXObject("Msxml2.XMLHTTP");}
	catch (e){
	try{
	connection = new ActiveXObject("Microsoft.XMLHTTP");}
	catch (e){// Something went wrong
	return false;}}}
	connection.open("POST", url, true);
	connection.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	connection.setRequestHeader("Content-length", params.length);
	connection.setRequestHeader("connection", "close");
	connection.send(params);
	return(connection);
	}
	
	function validateForm(frm){
	var errors='';
		
	if (errors){
	alert('The following error(s) occurred:\n'+errors);
	return false; }
	return true;
	}
	
function GetZones(frm){
	if(validateForm(frm)){
	document.getElementById('zones').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/users/getzones";
	
	var params = "country_id=" + totalEncode(document.frm.country_id.value ) ;
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('zones').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('zones').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	function GetRegions(frm){
	if(validateForm(frm)){
	document.getElementById('regions').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/users/getregions";
	
	var params = "zone_id=" + totalEncode(document.frm.zone_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('regions').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('regions').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	
	function GetDistricts(frm){
	if(validateForm(frm)){
	document.getElementById('districts').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/reportingforms/getdistricts";
	
	var params = "region_id=" + totalEncode(document.frm.region_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('districts').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('districts').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	
	
	
</script>

	<body>
		<?php include(APPPATH . 'views/common/navbar.php'); ?>

		<div class="main-container container-fluid">
			<a class="menu-toggler" id="menu-toggler" href="#">
				<span class="menu-text"></span>
			</a>
			<?php include(APPPATH . 'views/common/sidebar.php'); ?>
			
			<div class="main-content">
				<div class="breadcrumbs" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="icon-home home-icon"></i>
							<a href="<?php echo site_url('home')?>">Home</a>

							<span class="divider">
								<i class="icon-angle-right arrow-icon"></i>
							</span>
						</li>

						<li class="active">Support</li>
					</ul><!--.breadcrumb-->

					
				</div>

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
                            <div class="page-header position-relative">
						<h1>
							System
							<small>
								<i class="icon-double-angle-right"></i>
								Support
							</small>
						</h1>
					</div><!--/.page-header-->
                   
                         	<?php
				if(validation_errors())
				{
					?>
					<p><div class="alert alert-danger"> <?php echo validation_errors(); ?></div></p>
					<?php
				}

                if(!empty($success_message))
                {
                ?>
                   <p><div class="alert alert-success"> <?php echo $success_message; ?></div></p>
                <?php
                }
				?>
                <?php 
				$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data', 'class'=>'form-horizontal');

				echo form_open('support/sendmail',$attributes); ?>

                            <div class="control-group"><label class="control-label" for="form-field-1">Your Name: </label><div class="controls"><?php $data = array('id' => 'your_name', 'name' => 'your_name', 'value'=>$user->fname.' '.$user->lname,'class'=>'form-control', 'required'=>'required'); echo form_input($data, set_value('your_name')); ?></div>
                            </div>

                            <div class="control-group"><label class="control-label" for="form-field-1">Your Email: </label><div class="controls"><?php $data = array('id' => 'email', 'name' => 'email', 'value'=>$user->email,'class'=>'form-control', 'required'=>'required'); echo form_input($data, set_value('your_name')); ?></div>
                            </div>

                            <div class="control-group"><label class="control-label" for="form-field-1">Subject: </label><div class="controls"><?php $data = array('id' => 'subject', 'name' => 'subject','class'=>'form-control', 'required'=>'required'); echo form_input($data, set_value('your_name')); ?></div>
                            </div>

                            <div class="control-group"><label class="control-label" for="form-field-1">Message: </label>
                                <div class="controls">

                                    <textarea id="message" name="message" required="required"></textarea>
                                    <script>

                                        $('#message').summernote({
                                            height: 200,
                                            width: 500,

                                            //set callback image tuk upload ke serverside
                                            callbacks: {
                                                onImageUpload: function(files) {
                                                    uploadFile(files[0]);
                                                }
                                            }

                                        });

                                        function uploadFile(file) {
                                            data = new FormData();
                                            data.append("file", file);

                                            $.ajax({
                                                data: data,
                                                type: "POST",
                                                url: "<?php echo base_url();?>index.php/epibulletins/imageupload",
                                                cache: false,
                                                contentType: false,
                                                processData: false,
                                                success: function(url) {
                                                    console.log(url);
                                                    $('#message').summernote("insertImage",url);

                                                }
                                            });
                                        }

                                    </script>

                                </div>
                            </div>

<div class="form-actions"><?php echo form_submit('submit', 'SUBMIT SUPPORT REQUEST', 'class="btn btn-info "'); ?></div>
<?php echo form_close(); ?>


                           
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
