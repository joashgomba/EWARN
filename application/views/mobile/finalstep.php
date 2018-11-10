<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" class="">
<!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>ELECTRONIC DISEASE EARLY WARNING &amp; RESPONSE SYSTEM | WHO</title>
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url(); ?>respond.min.js"></script>
</head>
<body>
<div id="wrapper">
    <div class="bg">
        <div class="logo"><a href=""><img src="<?php echo base_url(); ?>img/logo.jpg" /></a></div>
        <div class="intro">ELECTRONIC DISEASE EARLY WARNING & RESPONSE SYSTEM</div>
        <div class="intro"><div align="right"><a href="<?php echo site_url('mobile/home')?>">Add</a> | <a href="<?php echo site_url('mobile/edit')?>">Edit</a> | <a href="<?php echo site_url('mobile/logout')?>">Logout</a></div></div>
    </div>

    <div class="results">
    <div class="intro">Data submitted successfully! Please review your submitted report	</div>
    <div class="intro">Respiratory Diseases	</div>

        

       <ul>
           <li><h3>SARI < 5yr</h3> <p> <strong>F</strong>:<?php echo $row->sariufivefemale;?>  <strong>M</strong>:<?php echo $row->sariufivemale;?></p></li>
           <li><h3>SARI > 5yr</h3> <p> <strong>F</strong>:<?php echo $row->sariofivefemale ;?>  <strong>M</strong>:<?php echo $row->sariofivemale;?></p></li>
           <li><h3>ILI < 5yr</h3> <p> <strong>F</strong>:<?php echo $row->iliufivefemale ;?>   <strong>M</strong>:<?php echo $row->iliufivemale;?> </p></li>
           <li><h3>ILI > 5yr</h3> <p> <strong>F</strong>:<?php echo $row->iliofivefemale;?>   <strong>M</strong>:<?php echo $row->iliofivemale;?> </p></li>

       </ul>
        <div class="intro">Gastro Intestinal Diseases</div>
        <ul>
            <li> <h3>AWD < 5yr</h3> <p> <strong>F</strong>:<?php echo $row->awdufivefemale;?>   <strong>M</strong>:<?php echo $row->awdufivemale;?> </p></li>
            <li><h3>AWD > 5yr</h3> <p> <strong>F</strong>:<?php echo $row->awdofivefemale;?>   <strong>M</strong>:<?php echo $row->awdofivemale;?> </p></li>
            <li><h3>BD < 5yr</h3> <p> <strong>F</strong>:<?php echo $row->bdufivefemale;?>   <strong>M</strong>:<?php echo $row->bdufivemale;?> </p></li>
            <li><h3>BD > 5yr</h3> <p> <strong>F</strong>:<?php echo $row->bdofivefemale;?>   <strong>M</strong>:<?php echo $row->bdofivemale;?> </p></li>
            <li><h3>AOD < 5yr</h3> <p> <strong>F</strong>:<?php echo $row->oadufivefemale;?>   <strong>M</strong>:<?php echo $row->oadufivemale;?> </p></li>
            <li><h3>AOD > 5yr</h3> <p> <strong>F</strong>:<?php echo $row->oadofivefemale;?>   <strong>M</strong>:<?php echo $row->oadofivemale;?> </p></li>

        </ul>
            <div class="intro">Vaccine Preventable Diseases</div>
        <ul>
            <li> <h3>Diph &lt;5yr </h3> <p> <strong>F</strong>:<?php echo $row->diphfemale;?>   <strong>M</strong>:<?php echo $row->diphmale;?> </p></li>
            <li> <h3>Diph &gt;5yr </h3> <p> <strong>F</strong>:<?php echo $row->diphofivefemale;?>   <strong>M</strong>:<?php echo $row->diphofivemale;?> </p></li>
            <li><h3>WC &lt;5yr </h3> <p> <strong>F</strong>:<?php echo $row->wcfemale;?>   <strong>M</strong>:<?php echo $row->wcmale;?> </p></li>
            <li><h3>WC &gt;5yr </h3> <p> <strong>F</strong>:<?php echo $row->wcofivefemale;?>   <strong>M</strong>:<?php echo $row->wcofivemale;?> </p></li>
            <li><h3>Meas &lt;5yr</h3> <p> <strong>F</strong>:<?php echo $row->measmale;?>   <strong>M</strong>:<?php echo $row->measfemale;?> </p></li>
                <li><h3>Meas &gt;5yr</h3> <p> <strong>F</strong>:<?php echo $row->measofivemale;?>   <strong>M</strong>:<?php echo $row->measofivefemale;?> </p></li>
            <li><h3>NNT</h3> <p> <strong>F</strong>:<?php echo $row->nntmale;?>   <strong>M</strong>:<?php echo $row->nntfemale;?> </p></li>
            <li><h3>AFP &lt;5yr</h3> <p> <strong>F</strong>:<?php echo $row->afpfemale;?>   <strong>M</strong>:<?php echo $row->afpmale;?> </p></li>
            <li><h3>AFP &gt;5yr</h3> <p> <strong>F</strong>:<?php echo $row->afpofivefemale;?>   <strong>M</strong>:<?php echo $row->afpofivemale;?> </p></li>
        </ul>
          <div class="intro">Other Communicable Diseases</div>
        <ul>
            <li> <h3>AJS</h3> <p> <strong>F</strong>:<?php echo $row->ajsfemale;?>   <strong>M</strong>:<?php echo $row->ajsmale;?> </p></li>
            <li><h3>VHF</h3> <p> <strong>F</strong>:<?php echo $row->vhffemale;?>   <strong>M</strong>:<?php echo $row->vhfmale;?> </p></li>
            <li><h3>Mal <5yr</h3> <p> <strong>F</strong>:<?php echo $row->malufivefemale;?>   <strong>M</strong>:<?php echo $row->malufivemale;?> </p></li>
            <li><h3>Mal >5yr </h3> <p> <strong>F</strong>:<?php echo $row->malofivefemale;?>   <strong>M</strong>:<?php echo $row->malofivemale;?> </p></li>
            <li><h3>Men &lt;5yr</h3> <p> <strong>F</strong>:<?php echo $row->suspectedmenegitisfemale;?>   <strong>M</strong>:<?php echo $row->suspectedmenegitismale;?> </p></li>
            <li><h3>Men &gt;5yr</h3> <p> <strong>F</strong>:<?php echo $row->suspectedmenegitisofivefemale;?>   <strong>M</strong>:<?php echo $row->suspectedmenegitisofivemale;?> </p></li>
          
        </ul>
         <div class="intro">Other Unusual Diseases or Deaths</div>
        <ul>
            <li> <h3>UnDis</h3> <p> <strong>F</strong>:<?php echo $row->undisfemale;?>   <strong>M</strong>:<?php echo $row->undismale;?> </p></li>
            <li><h3>UnDis</h3> <p> <strong>F</strong>:<?php echo $row->undisfemaletwo;?>   <strong>M</strong>:<?php echo $row->undismaletwo;?> </p></li>
            <li><h3>OC <5yr</h3> <p> <strong>F</strong>:<?php echo $row->ocfemale;?>   <strong>M</strong>:<?php echo $row->ocmale;?> </p></li>
          
          
        </ul>
          <ul>
            <li> <h3>Total Consultations</h3> <p> <strong>F</strong>:<?php echo $row->total_consultations;?>   <strong>M</strong>:<?php echo $row->undismale;?> </p></li>
   
          
          
          
        </ul>
         <div class="intro">Malaria Tests</div>
        <ul>
            <li> <h3>SRE</h3> <p> <strong>Total</strong>:<?php echo $row->sre;?>  </p></li>
            <li><h3>Pf</h3> <p> <strong>Total</strong>:<?php echo $row->pf;?>  </p></li>
            <li><h3>Pv <5yr</h3> <p> <strong>Total</strong>:<?php echo $row->pv;?>  </p></li>
          <li><h3>Pmix <5yr</h3> <p> <strong>Total</strong>:<?php echo $row->pmix;?></p></li>
          
        </ul>
        
    </div>
</div>
</body>
</html>
