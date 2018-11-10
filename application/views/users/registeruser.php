<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html dir="ltr" lang="en-US" xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<title>One Drop Perfumes</title>
		
		<script src="<?php echo base_url(); ?>jquery/jquery-1.4.2.min.js" type="text/javascript"></script>
		<!-- 1140px Grid styles for IE -->
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" /><![endif]-->

		<!-- The 1140px Grid -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>_layout/1140.css" type="text/css" media="screen" />
		
		
		<link rel="stylesheet" href="<?php echo base_url(); ?>_layout/styles.css" type="text/css" media="screen" />
		<link rel='stylesheet' href='<?php echo base_url(); ?>_themes/default.css' type='text/css' media='screen' />

		
		<!--css3-mediaqueries-js - http://code.google.com/p/css3-mediaqueries-js/ - Enables media queries in some unsupported browsers-->
		<script type="text/javascript" src="<?php echo base_url(); ?>_layout/scripts/css3-mediaqueries.js"></script>
		
			
		<!-- Fonts -->
		<link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold|PT+Sans+Narrow:regular,bold|Droid+Serif:iamp;v1' rel='stylesheet' type='text/css' />
		
		
		<!-- Scripts -->
		<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js?ver=1.6'></script>
	
	
		<!-- Forms Elemets -->
		<script type='text/javascript' src='<?php echo base_url(); ?>_layout/scripts/jquery.uniform/jquery.uniform.min.js'></script>
		<link rel='stylesheet' href='<?php echo base_url(); ?>_layout/scripts/jquery.uniform/uniform.default.css' type='text/css' media='screen' />
				
		
		<script type='text/javascript' src='<?php echo base_url(); ?>_layout/custom.js'></script>
		<script>

//"Accept terms" form submission- By Dynamic Drive
//For full source code and more DHTML scripts, visit http://www.dynamicdrive.com
//This credit MUST stay intact for use

var checkobj

function agreesubmit(el){
checkobj=el
if (document.all||document.getElementById){
for (i=0;i<checkobj.form.length;i++){  //hunt down submit button
var tempobj=checkobj.form.elements[i]
if(tempobj.type.toLowerCase()=="submit")
tempobj.disabled=!checkobj.checked
}
}
}

function defaultagree(el){
if (!document.all&&!document.getElementById){
if (window.checkobj&&checkobj.checked)
return true
else{
alert("Please read/accept terms to submit form")
return false
}
}
}

</script>



			<script type="text/javascript"><!--
var lastDiv = "";
function showDiv(divName) {
	// hide last div
	if (lastDiv) {
		document.getElementById(lastDiv).className = "hiddenDiv";
	}
	//if value of the box is not nothing and an object with that name exists, then change the class
	if (divName && document.getElementById(divName)) {
		document.getElementById(divName).className = "visibleDiv";
		lastDiv = divName;
	}
}
//-->
</script>
		<style type="text/css" media="screen"><!--
.hiddenDiv {
	display: none;
	}
.visibleDiv {
	display: block;
	border: 1px grey solid;
	}

--></style>

 <script type="text/javascript">
    function show(obj) {
      no = obj.options[obj.selectedIndex].value;
      count = obj.options.length;
      for(i=1;i<count;i++)
        document.getElementById('myDiv'+i).style.display = 'none';
      if(no>0)
        document.getElementById('myDiv'+no).style.display = 'block';
    }
  </script>

	</head>

<body>
<div id="header-wrapper" class="container">
		<div id="user-account" class="row" >
			<div class="threecol"> <span>Welcome to the best Dashboard v1.0</span> </div>
			<div class="ninecol last"> &nbsp; </div>
		</div>

		<div id="user-options" class="row">
			<div class="threecol"><a href="dashboard.html"><img class="logo" src="_layout/images/back-logo.png" alt="QuickAdmin" /></a></div>
			<div class="ninecol last fixed">
				
				
			</div>
		</div>
	</div>
	


<section id="content">

	<div class="g12">

		<p><a href="<?php echo site_url('login'); ?>">Back to login</a></p>

		
			<?php 

$attributes = array('name' => 'agreeform', 'id' => 'agreeform', 'enctype' => 'multipart/form-data','data-ajax'=>'false', 'onSubmit' =>'return defaultagree(this)');

 

echo form_open('manageusers/registeruser',$attributes); ?>

<fieldset>




			
All fields marked <span style="color:red;">*</span> are required
<p><?php echo validation_errors(); ?></p>		

		

				<section><label for="fname">First Name<span style="color:red;">*</span></label>

				<div><input type="text" name="fname" class="text" value="<?php echo set_value('fname'); ?>" size="40"/>

				<?php echo form_error('fname'); ?></div>

			</section>

            <section>

				<label for="lname">Last Name<span style="color:red;">*</span></label>

				<div><input type="text" name="lname" class="text" value="<?php echo set_value('lname'); ?>" size="40"/>

				<?php echo form_error('lname'); ?></div>

			</section>
			   <section>

				<label for="email">Email<span style="color:red;">*</span></label>

				<div><input type="text" name="email" class="text" value="<?php echo set_value('email'); ?>" size="50"/>

				<?php echo form_error('email'); ?></div>

			</section>
			 <section>

				<label for="email">Confirm Email<span style="color:red;">*</span></label>

				<div><input type="text" name="comemail" class="text" value="<?php echo set_value('comemail'); ?>" size="50"/>

				<?php echo form_error('comemail'); ?></div>

			</section>
			  <section>

				<label for="email">Country Code<span style="color:red;">*</span></label>
				
								<div><input type="text" name="countrycode" value="<?php echo set_value('countrycode'); ?>" size="10" />

				<?php echo form_error('countrycode'); ?></div>

			</section>
			  <section>

				<label for="email">Mobile<span style="color:red;">*</span></label>

				<div><input type="text" name="mobile" class="text" value="<?php echo set_value('mobile'); ?>" size="30"/>

				<?php echo form_error('mobile'); ?></div>

			</section>
			
			 <section>

				<label for="email">Telephone Number</label>

				<div><input type="text" name="telnumber" class="text" value="<?php echo set_value('telnumber'); ?>" size="30"/>

				<?php echo form_error('telnumber'); ?></div>

			</section>
			
			 <section>

				<label for="email">ID/Passport Number<span style="color:red;">*</span></label>

				<div><input type="text" name="idno" class="text" value="<?php echo set_value('idno'); ?>" size="30"/>
					
					<input type="hidden" name="authorizationletter" value="letter"/>

				<?php echo form_error('idno'); ?></div>

			</section>
			
			
			  <section>

				<label for="email">Photo<span style="color:red;">*  photo size should be (150px by 150px)</span></label>

				<div><input type="file" name="userfile" id="userfile" class="text" value="" size="50"/>

				<?php echo form_error('userfile'); ?></div>

			</section>
			
			<!--<section>

				<label for="role">Job Title/Account Type<span style="color:red;">*</span></label>

				<div><select name="role_id" id="role_id">

                <?php

				foreach($roles as $key => $list)

				{
					
						if($list['id']==1)
						{
							
						}
						else {
							
						

				?>

                <option value="<?php echo $list['id'];?>" <?php if($list['id']==3){ echo 'selected="selected"';} ?>><?php echo $list['description'];?></option>

                <?php
                		}
				}

				?>

                

                </select>

					</div>

			</section>-->

			
			 <section>
			 	<input type="hidden" name="role_id" id="role_id" value="2" />

				<label for="email">Country<span style="color:red;">*</span></label>

				<div><select name="country">
   
   
      <option value="United States">United States</option>
   
      <option value="United Kingdom">United Kingdom</option>
   
      <option value="Afghanistan">Afghanistan</option>
   
      <option value="Albania">Albania</option>
   
      <option value="Algeria">Algeria</option>
   
      <option value="American Samoa">American Samoa</option>
   
      <option value="Andorra">Andorra</option>
  
      <option value="Angola">Angola</option>
  
      <option value="Anguilla">Anguilla</option>
  
      <option value="Antarctica">Antarctica</option>
  
      <option value="Antigua and Barbuda">Antigua and Barbuda</option>
  
      <option value="Argentina">Argentina</option>
  
      <option value="Armenia">Armenia</option>
  
      <option value="Aruba">Aruba</option>
  
      <option value="Australia">Australia</option>
  
      <option value="Austria">Austria</option>
  
      <option value="Azerbaijan">Azerbaijan</option>
  
      <option value="Bahamas">Bahamas</option>
  
      <option value="Bahrain">Bahrain</option>
  
      <option value="Bangladesh">Bangladesh</option>
  
      <option value="Barbados">Barbados</option>
  
      <option value="Belarus">Belarus</option>
  
      <option value="Belgium">Belgium</option>
  
      <option value="Belize">Belize</option>
  
      <option value="Benin">Benin</option>
  
      <option value="Bermuda">Bermuda</option>
  
      <option value="Bhutan">Bhutan</option>
  
      <option value="Bolivia">Bolivia</option>
  
      <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
  
      <option value="Botswana">Botswana</option>
  
      <option value="Bouvet Island">Bouvet Island</option>
  
      <option value="Brazil">Brazil</option>
  
      <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
  
      <option value="Brunei Darussalam">Brunei Darussalam</option>
  
      <option value="Bulgaria">Bulgaria</option>
  
      <option value="Burkina Faso">Burkina Faso</option>
  
      <option value="Burundi">Burundi</option>
  
      <option value="Cambodia">Cambodia</option>
  
      <option value="Cameroon">Cameroon</option>
  
      <option value="Canada">Canada</option>
  
      <option value="Cape Verde">Cape Verde</option>
  
      <option value="Cayman Islands">Cayman Islands</option>
  
      <option value="Central African Republic">Central African Republic</option>
  
      <option value="Chad">Chad</option>
  
      <option value="Chile">Chile</option>
  
      <option value="China">China</option>
  
      <option value="Christmas Island">Christmas Island</option>
  
      <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
  
      <option value="Colombia">Colombia</option>
  
      <option value="Comoros">Comoros</option>
  
      <option value="Congo">Congo</option>
  
      <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
  
      <option value="Cook Islands">Cook Islands</option>
  
      <option value="Costa Rica">Costa Rica</option>
  
      <option value="Cote D'ivoire">Cote D'ivoire</option>
  
      <option value="Croatia">Croatia</option>
  
      <option value="Cuba">Cuba</option>
  
      <option value="Cyprus">Cyprus</option>
  
      <option value="Czech Republic">Czech Republic</option>
  
      <option value="Denmark">Denmark</option>
  
      <option value="Djibouti">Djibouti</option>
  
      <option value="Dominica">Dominica</option>
  
      <option value="Dominican Republic">Dominican Republic</option>
  
      <option value="Ecuador">Ecuador</option>
  
      <option value="Egypt">Egypt</option>
  
      <option value="El Salvador">El Salvador</option>
  
      <option value="Equatorial Guinea">Equatorial Guinea</option>
  
      <option value="Eritrea">Eritrea</option>
  
      <option value="Estonia">Estonia</option>
  
      <option value="Ethiopia">Ethiopia</option>
  
      <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
  
      <option value="Faroe Islands">Faroe Islands</option>
  
      <option value="Fiji">Fiji</option>
  
      <option value="Finland">Finland</option>
  
      <option value="France">France</option>
  
      <option value="French Guiana">French Guiana</option>
  
      <option value="French Polynesia">French Polynesia</option>
  
      <option value="French Southern Territories">French Southern Territories</option>
  
      <option value="Gabon">Gabon</option>
  
      <option value="Gambia">Gambia</option>
  
      <option value="Georgia">Georgia</option>
  
      <option value="Germany">Germany</option>
  
      <option value="Ghana">Ghana</option>
  
      <option value="Gibraltar">Gibraltar</option>
  
      <option value="Greece">Greece</option>
  
      <option value="Greenland">Greenland</option>
  
      <option value="Grenada">Grenada</option>
  
      <option value="Guadeloupe">Guadeloupe</option>
  
      <option value="Guam">Guam</option>
  
      <option value="Guatemala">Guatemala</option>
  
      <option value="Guinea">Guinea</option>
  
      <option value="Guinea-bissau">Guinea-bissau</option>
  
      <option value="Guyana">Guyana</option>
  
      <option value="Haiti">Haiti</option>
  
      <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
  
      <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
  
      <option value="Honduras">Honduras</option>
 
      <option value="Hong Kong">Hong Kong</option>
 
      <option value="Hungary">Hungary</option>
 
      <option value="Iceland">Iceland</option>
 
      <option value="India">India</option>
 
      <option value="Indonesia">Indonesia</option>
 
      <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
 
      <option value="Iraq">Iraq</option>
 
      <option value="Ireland">Ireland</option>
 
      <option value="Israel">Israel</option>
 
      <option value="Italy">Italy</option>
 
      <option value="Jamaica">Jamaica</option>
 
      <option value="Japan">Japan</option>
 
      <option value="Jordan">Jordan</option>
 
      <option value="Kazakhstan">Kazakhstan</option>
 
      <option value="Kenya">Kenya</option>
 
      <option value="Kiribati">Kiribati</option>
 
      <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
 
      <option value="Korea, Republic of">Korea, Republic of</option>
 
      <option value="Kuwait">Kuwait</option>
 
      <option value="Kyrgyzstan">Kyrgyzstan</option>
 
      <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
 
      <option value="Latvia">Latvia</option>
 
      <option value="Lebanon">Lebanon</option>
 
      <option value="Lesotho">Lesotho</option>
 
      <option value="Liberia">Liberia</option>
 
      <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
 
      <option value="Liechtenstein">Liechtenstein</option>
 
      <option value="Lithuania">Lithuania</option>
 
      <option value="Luxembourg">Luxembourg</option>
 
      <option value="Macao">Macao</option>
 
      <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
 
      <option value="Madagascar">Madagascar</option>
 
      <option value="Malawi">Malawi</option>
 
      <option value="Malaysia">Malaysia</option>
 
      <option value="Maldives">Maldives</option>
 
      <option value="Mali">Mali</option>
 
      <option value="Malta">Malta</option>
 
      <option value="Marshall Islands">Marshall Islands</option>
 
      <option value="Martinique">Martinique</option>
 
      <option value="Mauritania">Mauritania</option>
 
      <option value="Mauritius">Mauritius</option>
 
      <option value="Mayotte">Mayotte</option>
 
      <option value="Mexico">Mexico</option>
 
      <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
 
      <option value="Moldova, Republic of">Moldova, Republic of</option>
 
      <option value="Monaco">Monaco</option>
 
      <option value="Mongolia">Mongolia</option>
 
      <option value="Montserrat">Montserrat</option>
 
      <option value="Morocco">Morocco</option>
 
      <option value="Mozambique">Mozambique</option>
 
      <option value="Myanmar">Myanmar</option>
 
      <option value="Namibia">Namibia</option>
 
      <option value="Nauru">Nauru</option>
 
      <option value="Nepal">Nepal</option>
 
      <option value="Netherlands">Netherlands</option>
 
      <option value="Netherlands Antilles">Netherlands Antilles</option>
 
      <option value="New Caledonia">New Caledonia</option>
 
      <option value="New Zealand">New Zealand</option>
 
      <option value="Nicaragua">Nicaragua</option>
 
      <option value="Niger">Niger</option>
 
      <option value="Nigeria">Nigeria</option>
 
      <option value="Niue">Niue</option>
 
      <option value="Norfolk Island">Norfolk Island</option>
 
      <option value="Northern Mariana Islands">Northern Mariana Islands</option>
 
      <option value="Norway">Norway</option>
 
      <option value="Oman">Oman</option>
 
      <option value="Pakistan">Pakistan</option>
 
      <option value="Palau">Palau</option>
 
      <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
 
      <option value="Panama">Panama</option>
 
      <option value="Papua New Guinea">Papua New Guinea</option>
 
      <option value="Paraguay">Paraguay</option>
 
      <option value="Peru">Peru</option>
 
      <option value="Philippines">Philippines</option>
 
      <option value="Pitcairn">Pitcairn</option>
 
      <option value="Poland">Poland</option>
 
      <option value="Portugal">Portugal</option>
 
      <option value="Puerto Rico">Puerto Rico</option>
 
      <option value="Qatar">Qatar</option>
 
      <option value="Reunion">Reunion</option>
 
      <option value="Romania">Romania</option>
 
      <option value="Russian Federation">Russian Federation</option>
 
      <option value="Rwanda">Rwanda</option>
 
      <option value="Saint Helena">Saint Helena</option>
 
      <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
 
      <option value="Saint Lucia">Saint Lucia</option>
 
      <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
 
      <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
 
      <option value="Samoa">Samoa</option>
 
      <option value="San Marino">San Marino</option>
 
      <option value="Sao Tome and Principe">Sao Tome and Principe</option>
 
      <option value="Saudi Arabia">Saudi Arabia</option>
 
      <option value="Senegal">Senegal</option>
 
      <option value="Serbia and Montenegro">Serbia and Montenegro</option>
 
      <option value="Seychelles">Seychelles</option>
 
      <option value="Sierra Leone">Sierra Leone</option>
 
      <option value="Singapore">Singapore</option>
 
      <option value="Slovakia">Slovakia</option>
 
      <option value="Slovenia">Slovenia</option>
 
      <option value="Solomon Islands">Solomon Islands</option>
 
      <option value="Somalia">Somalia</option>
 
      <option value="South Africa">South Africa</option>
 
      <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
 
      <option value="Spain">Spain</option>
 
      <option value="Sri Lanka">Sri Lanka</option>
 
      <option value="Sudan">Sudan</option>
 
      <option value="Suriname">Suriname</option>
 
      <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
 
      <option value="Swaziland">Swaziland</option>
 
      <option value="Sweden">Sweden</option>
 
      <option value="Switzerland">Switzerland</option>
 
      <option value="Syrian Arab Republic">Syrian Arab Republic</option>
 
      <option value="Taiwan, Province of China">Taiwan, Province of China</option>
 
      <option value="Tajikistan">Tajikistan</option>
 
      <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
 
      <option value="Thailand">Thailand</option>
 
      <option value="Timor-leste">Timor-leste</option>
 
      <option value="Togo">Togo</option>
 
      <option value="Tokelau">Tokelau</option>
 
      <option value="Tonga">Tonga</option>
 
      <option value="Trinidad and Tobago">Trinidad and Tobago</option>
 
      <option value="Tunisia">Tunisia</option>
 
      <option value="Turkey">Turkey</option>
 
      <option value="Turkmenistan">Turkmenistan</option>
 
      <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
 
      <option value="Tuvalu">Tuvalu</option>
 
      <option value="Uganda">Uganda</option>
 
      <option value="Ukraine">Ukraine</option>
 
      <option value="United Arab Emirates">United Arab Emirates</option>
 
      <option value="United Kingdom">United Kingdom</option>
 
      <option value="United States">United States</option>
 
      <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
 
      <option value="Uruguay">Uruguay</option>
 
      <option value="Uzbekistan">Uzbekistan</option>
 
      <option value="Vanuatu">Vanuatu</option>
 
      <option value="Venezuela">Venezuela</option>
 
      <option value="Viet Nam">Viet Nam</option>
 
      <option value="Virgin Islands, British">Virgin Islands, British</option>
 
      <option value="Virgin Islands, US">Virgin Islands, US</option>
 
      <option value="Wallis and Futuna">Wallis and Futuna</option>
 
      <option value="Western Sahara">Western Sahara</option>
 
      <option value="Yemen">Yemen</option>
 
      <option value="Zambia">Zambia</option>
 
      <option value="Zimbabwe">Zimbabwe</option>
 
      </select>

				<?php echo form_error('country'); ?></div>

			</section>
			
			  <section>

				<label for="email">Town<span style="color:red;">*</span></label>

				<div><input type="text" name="town" class="text" value="" size="50"/>

				<?php echo form_error('town'); ?></div>

			</section>
			
			  <section>

				<label for="email">Postal Address<span style="color:red;">*</span></label>

				<div><input type="text" name="postaladdress" class="text" value="" size="50"/>

				<?php echo form_error('postaladdress'); ?></div>

			</section>
			
			  <section>

				<label for="email">Physical Address<span style="color:red;">*</span></label>

				<div><input type="text" name="physicaladdress" class="text" value="<?php echo set_value('physicaladdress'); ?>" size="50"/>
					
					<input type="hidden" name="salesoutlet" class="text" value="" size="50"/>

				<?php echo form_error('physicaladdress'); ?></div>

			</section>

            <!--  <section>

				<label for="email">Sales Outlet<span style="color:red;">*</span></label>

				<div><input type="text" name="salesoutlet" class="text" value="" size="50"/>

				<?php echo form_error('salesoutlet'); ?></div>

			</section>-->
			
			<section>
				<label for="email">Who introduced you to One Drop Perfume? Please choose below<span style="color:red;">*</span></label>

				<div>
	<select name="refferedby" onchange="show(this)">
      <option value="1" selected="selected">Please select one</option>
					<option value="1">Friend/Colleague</option>
					<option value="3">One Drop Perfume Media</option>
					<option value="2">One Drop Business Partner</option>
                    <option value="4">Stockist</option>
    </select>
    <?php echo form_error('refferedby'); ?>
    </div>
      
			</section>
			
		 		
		<div id="myDiv1" style="display:none">
			  <section>

				<label for="username">If friend/colleague, please enter their Full Names, Mobile Number, ID Number below<br><br>
					
					Friend's/Colleague's Name
				</label>

				<div><input type="text" name="referrername" class="text" value=""/>

				<?php echo form_error('referrername'); ?></div>

			</section>
			
				 <section>

				<label for="username">Friend's/Colleague's Mobile</label>

				<div><input type="text" name="friendmobile" class="text" value=""/>

				<?php echo form_error('friendmobile'); ?></div>

			</section>
			
				 <section>

				<label for="username">Friend's/Colleague's ID</label>

				<div><input type="text" name="friendid" class="text" value=""/>

				<?php echo form_error('friendid'); ?></div>

			</section>
			</div>
			
			<div id="myDiv2" style="display:none">
			
			 	  <section>

				<label for="username">Referrer Mobile Number</label>

				<div><input type="text" name="refmobnumber" class="text" value=""/>

				<?php echo form_error('refmobnumber'); ?></div>

			</section>
			
			
			
			<section>

				<label for="username">Referrer ID/Passport Number</label>

				<div><input type="text" name="refidno" class="text" value=""/>

				<?php echo form_error('refidno'); ?></div>

			</section>
			 	
			 	</div>
			 	
			 	 <div id="myDiv3" style="display:none">&nbsp;</div>
			  <section>

				<label for="username">
			<span style="color:red;">Please create your preferred username (e.g. ‘jasperm’) and Password  which you can use to login to your <strong>One Drop Perfume Business Partner  Membership account</strong> .</span><br>
			 </label>
			 </section>

               <section>

				<label for="username">Username<span style="color:red;">*</span></label>

				<div><input type="text" name="username" class="text" value=""/>

				<?php echo form_error('username'); ?></div>

			</section>

              <section>

				<label for="password">Password<span style="color:red;">*</span></label>

				<div><input type="password" name="password" class="text" value=""/>

                <?php echo form_error('password'); ?>

				</div>

			</section>

			 <section>
			 <span style="color:red;">Please see the sample letter of authorization <a href="<?php echo base_url();?>upload/Letter of authorisation for BP contacts.pdf" target="_blank">here</a> </span><br>
			 	<input name="agreecheck" type="checkbox" onClick="agreesubmit(this)"><b>I agree to the terms and conditions of One Drop Perfume. Please see sample terms and conditions here </b><br>
			 </section>
			

			<section>

			<div><button class="reset">Reset</button><button class="submit" name="submitbuttonname" value="submitbuttonvalue">Submit</button>
				
			</div>

			</section>

		

	

		

		</fieldset>

		</form>

		<script>
//change two names below to your form's names
document.forms.agreeform.agreecheck.checked=false
</script>

	</div>

</section><!-- end div #content -->

<? include(APPPATH . 'views/common/footer.php'); ?>