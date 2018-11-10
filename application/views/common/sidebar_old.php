<?php
$active_class = $this->router->fetch_class();

$active_method =  $this->router->fetch_method();

$user_country_id = $this->erkanaauth->getField('country_id');
$user_country = $this->countriesmodel->get_by_id($user_country_id)->row();
?>
<div class="sidebar" id="sidebar">
				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-small btn-success">
							<i class="icon-signal"></i>
						</button>

						<button class="btn btn-small btn-info">
							<i class="icon-pencil"></i>
						</button>

						<button class="btn btn-small btn-warning">
							<i class="icon-group"></i>
						</button>

						<button class="btn btn-small btn-danger">
							<i class="icon-cogs"></i>
						</button>
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!--#sidebar-shortcuts-->

				<ul class="nav nav-list">
					<li <?php if($active_class=='home'){ echo 'class="active"';}?>>
						<a href="<?php echo site_url('home')?>">
							<i class="icon-dashboard"></i>
							<span class="menu-text"> Dashboard</span>
						</a>
					</li>
<?php 
					$level = $this->erkanaauth->getField('level');
					/**
					1- zonal
					2- Regional
					3 - Health facility
					4- National
					5 - stake holder
					6 - District
					**/
					if (getRole() == 'SuperAdmin' || $level ==2 || $level ==3 || $level ==6){
					?>
					<li <?php if($active_class=='reportingforms' || $active_class=='forms'){ echo 'class="active open"';}?>>
						<a href="#" class="dropdown-toggle">
							<i class="icon-edit"></i>
							<span class="menu-text"> Data Collection </span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
                        
                        <!--<li <?php if($active_class=='forms'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('forms/add')?>">
									<i class="icon-double-angle-right"></i>
									Dynamic Form 
								</a>
							</li>
                             <li <?php if($active_class=='forms'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('forms')?>">
									<i class="icon-double-angle-right"></i>
									Dynamic Form List
								</a>
							</li>-->
                            
							<li <?php if($active_method=='add' || $active_method=='add_validate'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('reportingforms/add')?>">
									<i class="icon-double-angle-right"></i>
									Add New Form 
								</a>
							</li>
                            <li <?php if($active_method=='healthfacility' || $active_method=='update_form' || $active_method=='edit_validate' || $active_method=='edit'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('reportingforms/healthfacility')?>">
									<i class="icon-double-angle-right"></i>
									Edit Form
								</a>
							</li>
							<li>
								<a href="<?php echo site_url('reportingforms')?>">
									<i class="icon-double-angle-right"></i>
									Data List
								</a>
							</li>
							
                            
                            <!-- end here --->
						
						</ul>
					</li>
                    <?php 
					}
					$access = $this->erkanaauth->getField('level');
					/**
					1- zonal
					2- Regional
					3 - Health facility
					4- National
					5 - stake holder
					6 - District
					**/
					if (getRole() == 'SuperAdmin' || $access==2 || $access==1 || $access==4 || $access==6){?>
                    <li  <?php if($active_class=='datalist' || $active_class=='alerts'  || $active_class=='export'){ echo 'class="active open"';}?>>
						<a href="#" class="dropdown-toggle">
							<i class="icon-book"></i>
							<span class="menu-text"> Data Management </span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
                        <?php
						if (getRole() == 'SuperAdmin' || $access==2 || $access==1 || $access==6){?>
							<li <?php if($active_class=='datalist'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('datalist')?>">
									<i class="icon-double-angle-right"></i>
									Validate Data
								</a>
							</li>
                            <?php
						}
						?>
                            <li <?php if( $active_class=='export'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('export')?>">
									<i class="icon-double-angle-right"></i>
									Export Data
								</a>
							</li>
                            <li <?php if($active_class=='alerts'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('alerts')?>">
									<i class="icon-double-angle-right"></i>
									List Alerts
								</a>
							</li>


						</ul>
					</li>
                    <?php } ?>
                    <?php if (getRole() == 'SuperAdmin'){?>

					<li  <?php if($active_class=='users' || $active_class=='mobilenumbers'){ echo 'class="active open"';}?>>
						<a href="#" class="dropdown-toggle">
							<i class="icon-tag"></i>
							<span class="menu-text"> Registration</span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							                            
                            <li <?php if($active_class=='users'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('users')?>">
									<i class="icon-double-angle-right"></i>
									Users
								</a>
							</li>
                            
                            <li <?php if($active_class=='mobilenumbers'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('mobilenumbers')?>">
									<i class="icon-double-angle-right"></i>
									Mobile Numbers
								</a>
							</li>
						</ul>
					</li>
                    
                    <li <?php if($active_class=='zones' || $active_class=='regions' || $active_class=='districts' || $active_class=='healthfacilities' || $active_class=='countries'){ echo 'class="active open"';}?>>
						<a href="#" class="dropdown-toggle">
							<i class="icon-globe"></i>
							<span class="menu-text"> Admin Settings </span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
                        <li <?php if($active_class=='countries'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('countries')?>">
									<i class="icon-double-angle-right"></i>
									Countries
								</a>
							</li>
                            
                          <li <?php if($active_class=='zones'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('zones')?>">
									<i class="icon-double-angle-right"></i>
									<?php echo $user_country->first_admin_level_label;?>
								</a>
							</li>

							<li <?php if($active_class=='regions'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('regions')?>">
									<i class="icon-double-angle-right"></i>
									<?php echo $user_country->second_admin_level_label;?>
								</a>
							</li>

							<li <?php if($active_class=='districts'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('districts')?>">
									<i class="icon-double-angle-right"></i>
									<?php echo $user_country->third_admin_level_label;?>
								</a>
							</li>
                            
                            <li <?php if($active_class=='zones'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('zones')?>">
									<i class="icon-double-angle-right"></i>
									<?php echo $user_country->first_admin_level_label;?>
								</a>
							</li>

							<li <?php if($active_class=='healthfacilities'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('healthfacilities')?>">
									<i class="icon-double-angle-right"></i>
									Health Facilities
								</a>
							</li>
                            

						</ul>
					</li>
                    
                    <li  <?php if($active_class=='diseases' || $active_class=='diseasecategories'){ echo 'class="active open"';}?>>
						<a href="#" class="dropdown-toggle">
							<i class="icon-bolt"></i>
							<span class="menu-text"> Disease Settings</span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							                            
                            <li <?php if($active_class=='diseasecategories'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('diseasecategories')?>">
									<i class="icon-double-angle-right"></i>
									Disease categories
								</a>
							</li>
                            
                            <li <?php if($active_class=='diseases'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('diseases')?>">
									<i class="icon-double-angle-right"></i>
									Diseases
								</a>
							</li>
                            
                            
						</ul>
					</li>
                   <?php } ?>
                  <li <?php if($active_class=='epdcalendar'){ echo 'class="active open"';}?>>
						<a href="#" class="dropdown-toggle">
							<i class="icon-calendar"></i>
							<span class="menu-text"> EPI Calendar </span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							<?php if (getRole() == 'SuperAdmin'){?>
                            <li <?php if($active_method=='add' || $active_method=='add_validate'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('epdcalendar/add')?>">
									<i class="icon-double-angle-right"></i>
									Create EPI Calendar
								</a>
							</li>
							<?php
							}
							?>
							<li  <?php if($active_method=='view'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('epdcalendar/view')?>">
									<i class="icon-double-angle-right"></i>
									View EPI Calendars
								</a>
							</li>

						</ul>
					</li>
                   
                    <li <?php if($active_class=='bulletins' || $active_class=='documents' || $active_class=='reports'){ echo 'class="active open"';}?>>
						<a href="#" class="dropdown-toggle">
							<i class="icon-bar-chart"></i>
							<span class="menu-text"> Reports </span>
                            <b class="arrow icon-angle-down"></b>
						</a>
                        <ul class="submenu">
                        <?php
						$lev = $this->erkanaauth->getField('level');
						if (getRole() == 'SuperAdmin' || $lev ==1  || $lev ==2 || $lev==3 || $lev==4 || $lev==5 || $lev==6){
						?>   
						 <li <?php if($active_method=='add' || $active_method=='add_validate' || $active_method=='edit' || $active_method=='edit_validate'){ echo 'class="active"';}?>>
									<a href="<?php echo site_url('bulletins')?>">
										<i class="icon-double-angle-right"></i>
										National Weekly Reports
									</a>
								</li>    
						
						<?php
						}
						?>
							<?php
							$lev = $this->erkanaauth->getField('level');
							if (getRole() == 'SuperAdmin' || $lev ==1 || $lev ==4){
								?>
                                   <li  <?php if($active_method=='zonallist' || $active_method=='addzonal' || $active_method=='add_zonal_validate' || $active_method=='zonal_edit' || $active_method=='edit_zonal_validate'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('bulletins/zonallist')?>">
									<i class="icon-double-angle-right"></i>
									<?php echo $user_country->first_admin_level_label;?> Weekly Reports
								</a>
							</li>
                                <?php
							}
							if (getRole() == 'SuperAdmin' || $lev ==2 ){
							?>                            
                           
                           <li  <?php if($active_method=='regionallist' || $active_method=='addregional' || $active_method=='add_region_validate' || $active_method=='editregional' || $active_method=='edit_region_validate'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('bulletins/regionallist')?>">
									<i class="icon-double-angle-right"></i>
									<?php echo $user_country->second_admin_level_label;?> Weekly Reports
								</a>
							</li>
                                                       
                            <?php
							}
							$lev = $this->erkanaauth->getField('level');
							//if (getRole() == 'SuperAdmin' || $lev ==2 || $lev ==1 || $lev ==4 || $lev ==3){
							if (getRole() == 'SuperAdmin' || $lev ==2 || $lev ==1 || $lev ==4 || $lev ==5){
							?>
                            <li <?php if($active_class=='documents'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('documents')?>">
									<i class="icon-double-angle-right"></i>
									Information Resources
								</a>
							</li>
                             <?php
							}
							
							$rptlevel = $this->erkanaauth->getField('level');
							/**
					1- zonal
					2- Regional
					3 - Health facility
					4- National
					5 - stake holder
					**/
					if (getRole() == 'SuperAdmin' || $rptlevel==2 || $rptlevel==1 || $rptlevel==4 || $rptlevel==5){
							?>
                            
                             <li <?php if($active_method=='weeklydiseasecasesquery' || $active_method=='weeklydiseasecases'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('reports/weeklydiseasecasesquery')?>">
									<i class="icon-double-angle-right"></i>
									Weekly Disease Cases
								</a>
							</li>
                            <li <?php if($active_method=='weeklydiseasealertsquery' || $active_method=='weeklydiseasealerts'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('reports/weeklydiseasealertsquery')?>">
									<i class="icon-double-angle-right"></i>
									Weekly Disease Alerts
								</a>
							</li>
                            <li <?php if($active_method=='weeklyhfalertsquery' || $active_method=='weeklyhfalerts'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('reports/weeklyhfalertsquery')?>">
									<i class="icon-double-angle-right"></i>
									Weekly HF Alerts/Cases
								</a>
							</li>
                               <li <?php if($active_method=='malariaquery' || $active_method=='malariareport'){ echo 'class="active"';}?>>
								<a href="<?php echo site_url('reports/malariaquery')?>">
									<i class="icon-double-angle-right"></i>
									Malaria Report
								</a>
							</li>
                            <?php
					}
					?>
						</ul>
					</li>
                    <?php 
					$level = $this->erkanaauth->getField('level');
					/**
					1- zonal
					2- Regional
					3 - Health facility
					4- National
					5 - stake holder
					**/
					if (getRole() == 'SuperAdmin' || $level ==2 || $level ==4 || $level ==1 || $level ==5){
					?>

                    
                    <li <?php if($active_class=='maps'){ echo 'class="active"';}?>>
						<a href="#" class="dropdown-toggle">
							<i class="icon-globe"></i>
							<span class="menu-text"> Maps </span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
                        	<li>
								<a href="<?php echo site_url('maps')?>">
									<i class="icon-double-angle-right"></i>
									Weekly Alerts Map
								</a>
							</li>
							<li>
								<a href="<?php echo site_url('maps/fullscreen')?>" target="_blank">
									<i class="icon-double-angle-right"></i>
									Full Screen
								</a>
							</li>

							<li>
								<a href="<?php echo site_url('maps/fullscreen_hfs')?>" target="_blank">
									<i class="icon-double-angle-right"></i>
									Health Facilities Alerts
								</a>
							</li>

						
						</ul>
					</li>
                    <?php
					}
					?>
                   
				</ul><!--/.nav-list-->

				<div class="sidebar-collapse" id="sidebar-collapse">
					<i class="icon-double-angle-left"></i>
				</div>
			</div>
