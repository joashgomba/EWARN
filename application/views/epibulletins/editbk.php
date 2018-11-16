<?php include(APPPATH . 'views/common/header.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.js"></script>

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
                <li class="active">Epi bulletins</li>
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
                            Reports
                            <small>
                                <i class="icon-double-angle-right"></i>
                                Epi bulletins
                            </small>
                        </h1>
                    </div>
                    <div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="icon-remove"></i>
                        </button>

                        <strong>
                            <i class="icon-remove"></i>
                            Note!
                        </strong>
                        This is the generated EPI bulletin template. You should be able to add some text in the areas with the text entry fields below. Once you are done, click on the update button to save the changes to the bulletin.
                        <br />
                    </div>
                    <?php if(validation_errors()){?>
                        <p><div class="alert alert-danger"> <?php echo validation_errors(); ?></div></p>
                    <?php } ?>
                    <?php $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data');?>
                    <?php echo form_open('epibulletins/edit_validate/'.$row->id,$attributes); ?>

                    <table id="listtable" width="100%">
                        <tr><td><img src="<?php echo base_url(); ?>images/header.png" alt=""></td></tr>
                        <tr bgcolor="#1f7eb8"><th><center>
                                    <font color="#FFFFFF"><strong> Epi Week <?php echo $row->week_no;?>, <?php echo date("d F Y", strtotime($row->from_date)); ?> - <?php echo date("d F Y", strtotime($row->to_date)); ?></strong></font></center>
                            </th></tr>

                        <tr><td>
                                <table width="100%" cellpadding="2" cellspacing="2" id="customers">
                                    <tr>
                                        <td bgcolor="#892A24" width="50%">
                                            <font color="#FFFFFF"><strong>Highlights</strong></font>
                                        </td>
                                        <td bgcolor="#892A24" width="50%">
                                            <font color="#FFFFFF"><strong>eWARN Reporting Rates vs Consultations in All <?php echo $country->first_admin_level_label;?> in <?php echo $country->country_name;?>, Epi Weeks <?php echo $start_week;?> <?php echo $start_year;?> to <?php echo $row->week_no; ?> <?php echo $row->week_year; ?></strong></font>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td valign="top"><p align="justify"><?php echo $row->highlight;?></p>

                                            <p><strong>Highlights Narrative</strong><br>
                                                <small>Any other narrative you would like to add on the highlight section including an image of the alerts map.<font color="#ff4500"><strong>If uploading an image make sure you resize it to atmost 250 by 250 to avoid distorting the PDF produced.</strong></font> </small></p>

                                            <textarea id="highlight_text" name="highlight_text"><?php echo $row->highlight_text;?></textarea>
                                            <script>

                                                $('#highlight_text').summernote({
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
                                                            $('#highlight_text').summernote("insertImage", url);

                                                        }
                                                    });
                                                }

                                            </script>
                                        </td>
                                        <td valign="top">

                                            <img src="<?php echo base_url();?>images/reportelements/<?php echo $row->reporting_rates_graph;?>">
                                            <hr>
                                            <p><strong>Distribution of Reporting Rates by <?php echo $country->first_admin_level_label;?> (Epi-week <?php echo $row->week_no;?> , <?php echo $row->week_year;?>)</strong></p>

                                            <img src="<?php echo base_url();?>images/reportelements/<?php echo $row->distribution_rates_graph;?>">



                                        </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                        <tr><td>
                                <table width="100%" cellpadding="2" cellspacing="2" id="customers">
                                    <tr>
                                        <td bgcolor="#892A24" width="50%">
                                            <font color="#FFFFFF"><strong>Number of alerts received and reported </strong></font>
                                        </td>
                                        <td bgcolor="#892A24" width="50%">
                                            <font color="#FFFFFF"><strong>Epi curve for priority diseases weeks <?php echo $start_week;?> <?php echo $start_year;?> to <?php echo $row->week_no; ?> <?php echo $row->week_year; ?></strong></font>
                                        </td>
                                    </tr>
                                    <tr><td>
                                            <img src="<?php echo base_url();?>images/reportelements/<?php echo $row->alerts_graph;?>">

                                        </td><td>
                                            <img src="<?php echo base_url();?>images/reportelements/<?php echo $row->epi_curve;?>">

                                        </td></tr>

                                </table>
                            </td>
                        </tr>
                        <tr><td>
                                <table width="100%" cellpadding="2" cellspacing="2" id="customers">
                                    <tr>
                                        <td bgcolor="#892A24" width="50%">
                                            <font color="#FFFFFF"><strong>Leading causes of morbidity and mortality in Epi-week <?php echo $row->week_no;?> , <?php echo $row->week_year;?></strong></font>
                                        </td>
                                        <td bgcolor="#892A24" width="50%">
                                            <font color="#FFFFFF"><strong>Leading disease outbreak in all <?php echo $country->first_admin_level_label;?> &amp; Proportional morbidity of leading priority diseases, Epi weeks <?php echo $start_week;?> <?php echo $start_year;?> to <?php echo $row->week_no; ?> <?php echo $row->week_year; ?></strong></font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><p align="justify"><?php echo $row->leading_causes;?></p>
                                            <p><strong>Enter details on interventions or actions taken/Any other narrative</strong></p>


                                            <textarea name="interventions" id="interventions" maxlength="800" rows="10" cols="100" ><?php echo $row->interventions;?></textarea>
                                            <!-- <p><b id='mycounter1'>800</b> characters remaining</p>-->

                                            <script>
                                                $('#interventions').summernote({
                                                    height: 200,
                                                    width: 500,
                                                });
                                            </script>


                                        </td>
                                        <td valign="top">

                                            <img src="<?php echo base_url();?>images/reportelements/<?php echo $row->leadingdisease_curve;?>" width="500" height="100">

                                            <hr>
                                            <center> <strong>Proportional Morbidity</strong></center>
                                            <img src="<?php echo base_url();?>images/reportelements/<?php echo $row->proportional_morbidity;?>" width="400" height="200">

                                        </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                        <tr><td>
                                <table width="100%" border="1" cellpadding="3" cellspacing="0">
                                    <tr bgcolor="#892A24"><td colspan="2"><font color="#FFFFFF">Weekly trends of Respiratory Diseases, Gastro Intestinal Tract Diseases, Measles, and Suspected Malaria ( Epi week <?php echo $start_week+2;?> to <?php echo $row->week_no; ?>, <?php echo $row->week_year; ?> & <?php echo $previous_year;?>)</font></td></tr>

                                    <tr><td width="50%">
                                            <p><div align="center"><strong>Respiratory Diseases</strong></div></p>
                                            <img src="<?php echo base_url();?>images/reportelements/<?php echo $row->respiratory_curve;?>">
                                        </td>
                                        <td>
                                            <p><div align="center"><strong>Gastro Intestinal Tract Diseases</strong></div></p>
                                            <img src="<?php echo base_url();?>images/reportelements/<?php echo $row->gastro_curve;?>">
                                        </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                        <tr><td>
                                <table width="100%" border="1" cellpadding="3" cellspacing="0">
                                    <tr>
                                        <td width="50%">
                                            <p><div align="center"><strong>Prop. Morb. of Measles</strong></div></p>
                                            <img src="<?php echo base_url();?>images/reportelements/<?php echo $row->measles_curve;?>">
                                        </td>
                                        <td width="50%">
                                            <p><div align="center"><strong>Suspected Malaria</strong></div></p>
                                            <img src="<?php echo base_url();?>images/reportelements/<?php echo $row->malaria_curve;?>">
                                        </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                        <tr><td>
                                <?php echo $row->leadingdiseasetable;?>
                            </td>
                        </tr>
                        <tr><td>
                                <?php echo $row->reportintable; ?>
                            </td>
                        </tr>
                        <tr><td>
                                <?php echo $row->zonedistributiontable; ?>
                            </td>
                        </tr>
                        <tr><td>
                                <?php echo $row->alertstable; ?>
                            </td>
                        </tr>

                    </table>
                    <div class="form-actions"><?php echo form_submit('submit', 'Update', 'class="btn btn-info "'); ?></div>
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
