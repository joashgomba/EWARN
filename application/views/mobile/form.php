<html>

<head>

   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Early Warning Alert and Response Network System </title>
<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript">

    

        // This function handles style and display changes for each next button click

        function handleWizardNext()

        {
			
			<?php
			
			foreach($diseasecategories as $key=>$diseasecategory):
			$current_step = $diseasecategory['id'];
			$next_step = ($current_step + 1);
			$third_step = ($next_step + 1);
			$previous_step = ($current_step - 1);
			
			if($diseasecategory['id']==$last)
			{
				$final_step = $last+1;
				$previous = $final_step-1;
				?>
			else if (document.getElementById('ButtonNext').name == 'Step<?php echo $final_step;?>')

            {

                // Change the button name - we use this to keep track of which step to display on a click

                document.getElementById('ButtonNext').name = '';

                document.getElementById('ButtonPrevious').name = 'Step<?php echo $previous;?>';

                // Disable/enable buttons when reach reach start and review steps

                document.getElementById('ButtonNext').disabled = 'disabled';

                document.getElementById('SubmitFinal').disabled = '';

                // Set new step to display and turn off display of current step

                document.getElementById('Step<?php echo $previous;?>').style.display = 'none';

                document.getElementById('Step<?php echo $final_step;?>').style.display = '';

                // Change background color on header to highlight new step

                document.getElementById('HeaderTableStep<?php echo $final_step;?>').style.backgroundColor = 'Yellow';

                document.getElementById('HeaderTableStep<?php echo $previous;?>').style.backgroundColor = 'Silver';

                // Load table elements for final review step

                loadStep5Review();

            }	
				<?php
			}
			else
			{
			?>
			<?php
			if($diseasecategory['id']==$first)
			{
			?>
   if (document.getElementById('ButtonNext').name == 'Step<?php echo $next_step;?>')

            {
			<?php
			}
			else
			{
				?>
	else if (document.getElementById('ButtonNext').name == 'Step<?php echo $next_step;?>')

            {
				<?php
			}
			?>

                // Change the button name - we use this to keep track of which step to display on a click
				
				<?php
				if($diseasecategory['id']=='pp')
				{
					?>
					  document.getElementById('ButtonNext').name = '';
					  document.getElementById('ButtonPrevious').name = 'Step<?php echo $previous_step;?>';
					<?php
				}
				else
				{
				?>

                document.getElementById('ButtonNext').name = 'Step<?php echo $third_step;?>';

                document.getElementById('ButtonPrevious').name = 'Step<?php echo $current_step;?>';
				<?php
				}
				?>
				
				

                // Disable/enable buttons when reach reach start and review steps
				<?php
				if($diseasecategory['id']==$first)
				{
					?>

                document.getElementById('ButtonPrevious').disabled = '';
				<?php
				}
				?>

                // Set new step to display and turn off display of current step
				
				<?php
				if($next_step=='kk')
				{
				?>
				 document.getElementById('ButtonNext').disabled = 'disabled';

                document.getElementById('SubmitFinal').disabled = '';

                // Set new step to display and turn off display of current step

                document.getElementById('Step<?php echo $previous_step;?>').style.display = 'none';

                document.getElementById('Step<?php echo $current_step;?>').style.display = '';

                // Change background color on header to highlight new step

                document.getElementById('HeaderTableStep<?php echo $current_step;?>').style.backgroundColor = 'Yellow';

                document.getElementById('HeaderTableStep<?php echo $previous_step;?>').style.backgroundColor = 'Silver';

                // Load table elements for final review step

                loadStep5Review();
				
				<?php
				}
				else
				{
				?>

                document.getElementById('Step<?php echo $current_step;?>').style.display = 'none';

                document.getElementById('Step<?php echo $next_step;?>').style.display = '';

                // Change background color on header to highlight new step

                document.getElementById('HeaderTableStep<?php echo $next_step;?>').style.backgroundColor = 'Yellow';

                document.getElementById('HeaderTableStep<?php echo $current_step;?>').style.backgroundColor = 'Silver';
				<?php
				}
				?>

            }
			<?php
			
			}
			endforeach;
			?>

            
        }

        

        // This function handles style and display changes for each previous button click

        function handleWizardPrevious()

        {
			<?php
			foreach($diseasecategories as $key=>$diseasecategory):
			$current_step = $diseasecategory['id'];
			$next_step = ($current_step + 1);
			$previous_step = ($next_step-2);
			?>
			<?php
			if($diseasecategory['id']==$first)
			{
			?>
            if (document.getElementById('ButtonPrevious').name == 'Step<?php echo $current_step; ?>')

            {
			<?php
			}
			else
			{
				?>
			else if (document.getElementById('ButtonPrevious').name == 'Step<?php echo $current_step; ?>')

            {	
				<?php
			}
			?>
				

                // Change the button name - we use this to keep track of which step to display on a click

                document.getElementById('ButtonNext').name = 'Step<?php echo $next_step; ?>';

                

                // Disable/enable buttons when reach reach start and review steps
				<?php
				if($diseasecategory['id']==$first)
				{
				?>
				document.getElementById('ButtonPrevious').name = '';
                document.getElementById('ButtonPrevious').disabled = 'disabled';
				<?php
				}
				else
				{
				?>
				document.getElementById('ButtonPrevious').name = 'Step<?php echo $previous_step;?>';
				<?php	
				}
				?>
				<?php
				if($diseasecategory['id']==$last)
				{
				?>
				document.getElementById('ButtonNext').disabled = '';

                document.getElementById('SubmitFinal').disabled = 'disabled';
				<?php
				}
				?>

                // Set new step to display and turn off display of current step

                document.getElementById('Step<?php echo $next_step; ?>').style.display = 'none';

                document.getElementById('Step<?php echo $current_step; ?>').style.display = '';

                // Change background color on header to highlight new step

                document.getElementById('HeaderTableStep<?php echo $current_step; ?>').style.backgroundColor = 'Yellow';

                document.getElementById('HeaderTableStep<?php echo $next_step; ?>').style.backgroundColor = 'Silver';

            }
			<?php
			endforeach;
			?>

            
        }

       
        // This function handles loading the review table innerHTML for the user to review before final submission

        function loadStep5Review()

        {

            // Assign values to appropriate cells in review table
			
			<?php foreach ($diseases->result() as $disease): ?>

            document.getElementById('Review<?php echo $disease->disease_code;?>_ufive_male').innerHTML = document.getElementById('<?php echo $disease->disease_code;?>_ufive_male').value;
			
			document.getElementById('Review<?php echo $disease->disease_code;?>_ufive_female').innerHTML = document.getElementById('<?php echo $disease->disease_code;?>_ufive_female').value;
			
			document.getElementById('Review<?php echo $disease->disease_code;?>_ofive_male').innerHTML = document.getElementById('<?php echo $disease->disease_code;?>_ofive_male').value;
			
			document.getElementById('Review<?php echo $disease->disease_code;?>_ofive_female').innerHTML = document.getElementById('<?php echo $disease->disease_code;?>_ofive_female').value;
			
			<?php
			endforeach;
			?>
			
			 document.getElementById('ButtonNext').disabled = 'disabled';

             document.getElementById('SubmitFinal').disabled = '';
        


        }

    </script>
    
    
    <style>
	
	select {
        width: 80%;
        font-size: 20px;
        text-align: center;
        margin: 5px 0;
    }
        #customers
        {
        font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
        
        border-collapse:collapse;
        }
        #customers td, #customers th 
        {
        font-size:0.9em;
        border:2px  solid #1b1b1b;
        padding:3px 7px 2px 7px;
        }
        #customers th 
        {
        font-size:1.0em;
        text-align:left;
        padding-top:5px;
        padding-bottom:4px;
        background-color:#cccccc;
        color:#1b1b1b;
        }
        #customers tr.alt td 
        {
        color:#000;
        background-color:#cccfff;
        }
		
		
.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
}

.disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
        </style>

 <SCRIPT language=Javascript>
      <!--
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
</script>


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
	
function GetPeriod(frm){
	if(validateForm(frm)){
	document.getElementById('reporingperiods').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/forms/getperiodbyhf";
	
	var params = "week_no=" + totalEncode(document.frm.week_no.value ) + "&reporting_year="+totalEncode(document.frm.reporting_year.value ) + "&healthfacility_id="+totalEncode(document.frm.healthfacility_id.value )  ;
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('reporingperiods').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('reporingperiods').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	
	function GetHealthFacilities(frm){
	if(validateForm(frm)){
	document.getElementById('healthfacilities').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/reportingforms/gethealthfacilities";
	
	var params = "district_id=" + totalEncode(document.frm.district_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('healthfacilities').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('healthfacilities').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
</script>


<script type="text/javascript">
<!--
// Form validation code will come here.
function checkvalid()
{
	if( document.frm.period_check.value == 1)
   {
     alert( "The reporting period for this health facility has been captured previously, please use 'Edit Form' to edit the data if it has not been validated." );
     document.frm.reporting_year.focus() ;
     return false;
   }
}


function validate()
{
	if( document.frm.period_check.value == 1)
   {
      alert( "The reporting period for this health facility has been captured previously, please use 'Edit Form' to edit the data if it has not been validated." );
     document.frm.reporting_year.focus() ;
     return false;
   }
   
	if( document.frm.reporting_year.value == "" )
   {
     alert( "Please enter the reporting year" );
     document.frm.reporting_year.focus() ;
     return false;
   }
   
   if( document.frm.week_no.value == "" )
   {
     alert( "Please enter the week number" );
     document.frm.week_no.focus() ;
     return false;
   }
   
   <?php foreach ($diseases->result() as $disease): ?>
   
   if( document.frm.<?php echo $disease->disease_code;?>_ufive_male.value == "" )
   {
     alert( "Please enter <?php echo $disease->disease_code;?> <=5yr Male" );
     document.frm.<?php echo $disease->disease_code;?>_ufive_male.focus() ;
     return false;
   }
   
    if(!document.frm.<?php echo $disease->disease_code;?>_ufive_male.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for <?php echo $disease->disease_code;?> <= 5 Male")
	  document.frm.<?php echo $disease->disease_code;?>_ufive_male.focus() ;
     return false;
    }
	
	if( document.frm.<?php echo $disease->disease_code;?>_ufive_female.value == "" )
   {
     alert( "Please enter <?php echo $disease->disease_code;?> <=5yr Female" );
     document.frm.<?php echo $disease->disease_code;?>_ufive_female.focus() ;
     return false;
   }
   
    if(!document.frm.<?php echo $disease->disease_code;?>_ufive_female.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for <?php echo $disease->disease_code;?> <= 5 Female")
	  document.frm.<?php echo $disease->disease_code;?>_ufive_female.focus() ;
     return false;
    }
	
	
	if( document.frm.<?php echo $disease->disease_code;?>_ofive_male.value == "" )
   {
     alert( "Please enter <?php echo $disease->disease_code;?> >=5yr Male" );
     document.frm.<?php echo $disease->disease_code;?>_ofive_male.focus() ;
     return false;
   }
   
    if(!document.frm.<?php echo $disease->disease_code;?>_ofive_male.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for <?php echo $disease->disease_code;?> >= 5 Male")
	  document.frm.<?php echo $disease->disease_code;?>_ofive_male.focus() ;
     return false;
    }
	
	
	if( document.frm.<?php echo $disease->disease_code;?>_ofive_female.value == "" )
   {
     alert( "Please enter <?php echo $disease->disease_code;?> >=5yr Female" );
     document.frm.<?php echo $disease->disease_code;?>_ofive_female.focus() ;
     return false;
   }
   
    if(!document.frm.<?php echo $disease->disease_code;?>_ofive_female.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for <?php echo $disease->disease_code;?> >= 5 Female")
	  document.frm.<?php echo $disease->disease_code;?>_ofive_female.focus() ;
     return false;
    }
	
	<?php
	endforeach;
	?>
		
     
}
</script>

</head>

<body>
<div id="wrapper ">
<div class="bg"><a href=""></a>
  <div class="intro">EARLY WARNING ALERT AND RESPONSE NETWORK SYSTEM</div>
  </div>
   <div class="intro"><div align="right"><a href="<?php echo site_url('mobile/home')?>">Add</a> | <a href="<?php echo site_url('mobile/edit')?>">Edit</a> | <a href="<?php echo site_url('mobile/logout')?>">Logout</a></div></div>
  </div>

<?php if(validation_errors()){?>
<div class="intro"> <font color="#FF0000"><?php echo validation_errors(); ?></font></div>
<?php } ?> 

<?php
if(!empty($sucsess_message))
{
	echo '<div class="intro"><font color="#00CC66"><strong>'.$sucsess_message.'</strong></font></div>';
}
?>


<div class="form">
<form id="frm" name="frm" action="<?php echo site_url('mobile/add_validate')?>" method="post" onSubmit="return(validate())">
<?php
foreach($diseasecategories as $key=>$diseasecategory):

if($diseasecategory['id']==$first)
{
	?>
 <div id="HeaderTableStep<?php echo $diseasecategory['id'];?>" style="background-color:Yellow; display: inline-block;"><h3><?php echo $diseasecategory['category_name'];?></h3></div>   
    <?php
}
else
{
?>
<div id="HeaderTableStep<?php echo $diseasecategory['id'];?>" style="background-color:Silver; display: inline-block;"><h3><?php echo $diseasecategory['category_name'];?></h3></div>
<?php
}
endforeach;

$lastheader = $last+1;
?>
<div id="HeaderTableStep<?php echo $lastheader;?>" style="background-color:Silver; display: inline-block"><h3>Finish</h3></div>

   
   
    <br />
   
 <div class="intro"> <div align="left"><label>Reporting Year</label>
 <select name="reporting_year" id="reporting_year" onChange="GetPeriod(this)">
                               <option value="">Select Year</option>
                               <?php
     $currentYear = date('Y')+1;
        foreach (range(2012, $currentYear) as $value) {
          ?>
           <option value="<?php echo $value;?>" <?php 
		   if($value==set_value('reporting_year'))
		   {
			   echo 'selected="selected"';
		   }
		   ?>><?php echo $value;?></option>
          <?php

        }
?>
                               </select>
                               
                               <label>Week No.</label>
<select name="week_no" id="week_no" onChange="GetPeriod(this)">
                            <option value="">Select Week</option>
                               <?php
							   for($i=1;$i<=52;$i++)
							   {
								   ?>
                                   <option value="<?php echo $i;?>" <?php if(set_value('week_no')==$i){echo 'selected="selected"';}?>>Week <?php echo $i;?></option>
                                   <?php
							   }
							   ?>
                               </select>
<input type="hidden" name="healthfacility_id" id="healthfacility_id" value="<?php echo $healthfacility_id;?>">
<?php
 if($country_diseases==0)
 {
	 ?>
 <input type="hidden" name="disease_check" id="disease_check" value="">
     <?php
 }
 else
 {
	 ?>
<input type="hidden" name="disease_check" id="disease_check" value="1">     
     <?php
 }
 ?>
 
 
                               
<div id="reporingperiods">
            &nbsp;
            <input type="hidden" name="period_check" id="period_check" value="0">
         </div>
                               </div>
                               </div>
<?php
foreach($diseasecategories as $key=>$diseasecategory):

if($diseasecategory['id'] !=$first)
{
	echo '<span id="Step'.$diseasecategory['id'].'" style="display:none">';
	?>

<?php
}
else
{
?>
<span id="Step<?php echo $diseasecategory['id']; ?>">
<?php
}
?>


 <div class="intro"><?php echo $diseasecategory['category_name']; ?></div>

<ul>

<?php
$categorydiseases = $this->diseasesmodel->get_by_category_country($diseasecategory['id'],$country_id);
foreach($categorydiseases as $key=>$categorydisease)
{
?>
         <h3><?php echo $categorydisease->disease_code;?> <= 5yr</h3>
         <li>

 <label>MALE</label>
 <input type="text" id="<?php echo $categorydisease->disease_code;?>_ufive_male" name="<?php echo $categorydisease->disease_code;?>_ufive_male" onKeyPress="return isNumberKey(event)" maxlength="5" onFocus="checkvalid()"/>
          </li>
         <li>
  <label>FEMALE</label>
 <input type="text" id="<?php echo $categorydisease->disease_code;?>_ufive_female" name="<?php echo $categorydisease->disease_code;?>_ufive_female" onKeyPress="return isNumberKey(event)" maxlength="5" onFocus="checkvalid()"/>
         </li>
         <h3><?php echo $categorydisease->disease_code;;?> >= 5yr</h3>
         <li>
 <!---->

 <label>MALE</label>
 <input type="text" id="<?php echo $categorydisease->disease_code;?>_ofive_male" name="<?php echo $categorydisease->disease_code;?>_ofive_male" onKeyPress="return isNumberKey(event)" maxlength="5" onFocus="checkvalid()"/>
         </li>
         <li>
  <label>FEMALE</label>
 <input type="text" id="<?php echo $categorydisease->disease_code;?>_ofive_female" name="<?php echo $categorydisease->disease_code;?>_ofive_female" onKeyPress="return isNumberKey(event)" maxlength="5" onFocus="checkvalid()"/>
         </li>
         
<?php
}

if($diseasecategory['id'] !=$last)
{
?>

<?php	
	
}
?>

         </ul>

</span>

<?php
endforeach;
?>



<span id="Step<?php echo $lastheader;?>" style="display:none">

    <table border="1" cellpadding="5" cellspacing="0" width="100%">

        <tr>

            <td colspan="8">

                <strong>Final Review:</strong></td>

        </tr>
        <?php foreach($diseasecategories as $key=>$diseasecategory): ?>
		 <tr>

            <td colspan="8">

                <div class="intro"><?php echo $diseasecategory['category_name']; ?>:</div></td>

        </tr>
        <?php
		$categorydiseases = $this->diseasesmodel->get_by_category_country($diseasecategory['id'],$country_id);
		foreach($categorydiseases as $key=>$disease)
		{
	   ?>
        <tr>

            <td align="right">

                <?php echo $disease->disease_code;?> &lt;=5 Male:</td>

            <td id="Review<?php echo $disease->disease_code;?>_ufive_male">

                </td>

      

            <td align="right">

                <?php echo $disease->disease_code;?> &lt;=5 Female:</td>

            <td id="Review<?php echo $disease->disease_code;?>_ufive_female">

                </td>


            <td align="right">

                <?php echo $disease->disease_code;?> &gt;=5 Male:</td>

            <td id="Review<?php echo $disease->disease_code;?>_ofive_male">

                </td>

      
            <td align="right">

                <?php echo $disease->disease_code;?> &gt;=5 Female:</td>

            <td id="Review<?php echo $disease->disease_code;?>_ofive_female">

                </td>

        </tr>
         <tr>

            <td colspan="8">&nbsp;</td>
            
            </tr>
        <?php
		}
		
		endforeach;
		?>



    </table>

</span>

<br />    

<table border="0" cellpadding="5" cellspacing="0">

    <tr>

        <td>

            <input id="ButtonPrevious" type="button" value="Previous" disabled="disabled" name="" onClick="handleWizardPrevious()" /></td>

        <td>

            <input id="ButtonNext" type="button" value="Next" name="Step2" onClick="handleWizardNext()" /></td>

        <td>

            <input id="SubmitFinal" type="submit" value="Finish" disabled="disabled" onClick="return(checkvalid())" /></td>

    </tr>

</table>

</form>
</div>
</div>
</body>

</html>