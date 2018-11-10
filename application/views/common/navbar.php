<div class="navbar">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a href="<?php echo site_url('home')?>" class="brand">
						<small>
							<!--<i class="icon-leaf"></i>-->
                            <img src="<?php echo base_url(); ?>images/who-logo.jpg" width="40" height="26">
							Early Warning Alert and Response Network System 
						</small>
					</a><!--/.brand-->

					<ul class="nav ace-nav pull-right">
                  
							<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
                            <?php
							$user_id = $this->erkanaauth->getField('id');		
							$profile = $this->profilesmodel->get_by_user_id($user_id)->row();
							if(empty($profile->photo))
							{
							?>
								<img class="nav-user-photo" src="<?php echo base_url();?>profilepics/one22.jpg" alt="" />
                            <?php
							}
							else
							{
								?>
                                <img class="nav-user-photo" src="<?php echo base_url();?>profilepics/<?php echo $profile->photo;?>" alt="" />
                                <?php
							}
							?>
								<span class="user-info">
									<small>Welcome,</small>
									<?php echo getField('username'); ?>
								</span>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
								
								<li>
									<a href="<?php 
									$user_id = $this->erkanaauth->getField('id');
									echo site_url('profiles/edit')?>">
										<i class="icon-user"></i>
										Profile
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="<?php echo site_url('home/logout')?>">
										<i class="icon-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>
					</ul><!--/.ace-nav-->
				</div><!--/.container-fluid-->
			</div><!--/.navbar-inner-->
		</div>