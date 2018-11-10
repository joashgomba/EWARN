<?php

require_once 'PHPWord/PHPWord.php';
require_once('tcpdf/tcpdf.php');

define ('BATIK_PATH', 'exporting-server/batik-rasterizer.jar');
define ('TEMP_PATH', 'exporting-server/temp/');


if(isset($_POST['type']) && isset($_POST['title']) && isset($_POST['header']) && isset($_POST['footer']) && isset($_POST['data'])){
    
  $title=urldecode($_POST['title']);
  $header=urldecode($_POST['header']);
  $footer=urldecode($_POST['footer']);
    
  $type=urldecode($_POST['type']);
  $data=json_decode(urldecode($_POST['data']));
  
  
  $items=array();
  for($i=0; $i < count($data); $i++){
    $items[]=svgToJpg($data[$i]);
  }
 
  if($type=='pdf'){
    doPDF($title,$header,$footer,$items);
  }elseif($type=='doc'){
    doDoc($title,$header,$footer,$items);
  }
  foreach($items as $item){
    unlink($item->filename);
  }
  exit;
}else{
  print 'ERROR docgen.php: no post data!';
}


function svgToJpg($item){
  /*CONVERTS SVG TO JPG*/
  
  ///////////////////////////////////////////////////////////////////////////////
  ini_set('magic_quotes_gpc', 'off');
  
  
  $filename =  isset($_POST['filename']) ? $_POST['filename'] : 'chart';
  $width =  isset($_POST['width']) ? $_POST['width'] : 300;
  
  $svg=$item->svg;
  if (get_magic_quotes_gpc()) {
    $svg = stripslashes($svg);  
  }
  
  
  
  $tempName = md5(rand());
  $typeString = '-m image/jpeg';
  $ext = '.jpg';
  $outfile = TEMP_PATH.$tempName.$ext;
  
  if (isset($typeString)) {
    
    // size
   $width = "-w $width";
   
  
    // generate the temporary file
    if (!file_put_contents(TEMP_PATH.$tempName.".svg", $svg)) { 
      die("Couldn't create temporary file. Check that the directory permissions for
        the /temp directory are set to 777.");
    }
    
    // do the conversion
    shell_exec("chmod 777 ".TEMP_PATH.$tempName.".svg");
    $output = shell_exec("java -jar ". BATIK_PATH ." $typeString -d $outfile $width ".TEMP_PATH.$tempName.".svg");
    
    // catch error
    if (!is_file($outfile) || filesize($outfile) < 10) {
      echo "<pre>$output</pre>";
      echo "Error while converting SVG. ";
      
      if (strpos($output, 'SVGConverter.error.while.rasterizing.file') !== false) {
        echo "SVG code for debugging: <hr/>";
        echo htmlentities($svg);
      }
    } 
    
    // stream it
    else {
      unlink(TEMP_PATH.$tempName.".svg");
      $item->filename=$outfile;
      return $item;
    }
    
    // delete it
    
    unlink($outfile);
  
  // SVG can be streamed directly back
  } else {
    echo "Invalid type";
  }
}
exit;



function doDoc($title,$headertext,$footertext,$items){
  // New Word Document
  $PHPWord = new PHPWord();
  // New portrait section
  $section = $PHPWord->createSection();
  
  // Add header
  $header = $section->createHeader();
  $table = $header->addTable();
  $table->addRow();
  $table->addCell(4500)->addText($headertext);
  
  // Add footer
  $footer = $section->createFooter();
  //$footer->addPreserveText('Page {PAGE} of {NUMPAGES}.', array('align'=>'center'));
  $footer->addPreserveText($footertext, array('align'=>'center'));
  
  // Title styles
  $PHPWord->addTitleStyle(1, array('size'=>20, 'color'=>'333333', 'bold'=>true));
  $PHPWord->addTitleStyle(2, array('size'=>16, 'color'=>'666666'));
  
  $section->addTitle($title, 1);
  
  foreach($items as $item){
    $section->addTitle($item->title, 2);
    $section->addTextBreak(1);
    $section->addText($item->text);
    $section->addTextBreak(1);
    $section->addImage($item->filename);
    $section->addTextBreak(1);
  }
  
  
  $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
  header('Content-Type: application/vnd.ms-word');
  header('Content-Disposition: attachment;filename="'.$title.'.docx"');
  header('Cache-Control: max-age=0');
  // At least write the document to webspace:
  $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
  $objWriter->save('php://output');
    
}


function doPDF($title,$headertext,$footertext,$items){
  
  require_once('tcpdf/config/lang/eng.php');
  require_once('tcpdf/tcpdf.php');
  
  
  // create new PDF document
  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  
  // set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Nicola Asuni');
  $pdf->SetTitle('TCPDF Example 006');
  $pdf->SetSubject('TCPDF Tutorial');
  $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
  
  // set default header data
  $pdf->SetHeaderData(NULL, NULL, $headertext, NULL);
  
  // set header and footer fonts
  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
  
  // set default monospaced font
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
  
  //set margins
  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
  
  //set auto page breaks
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
  
  //set image scale factor
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
  
  //set some language-dependent strings
  $pdf->setLanguageArray($l);
  
  // ---------------------------------------------------------
  
  // set font
  $pdf->SetFont('helvetica', '', 10);
  
  // add a page
  $pdf->AddPage();
    
  
  $html = '<h1>'.$title.'</h1>';
  
  
  
  foreach($items as $item){
    $html .= '<h2>'.$item->title.'</h2>';
    $html .= '<p>'.$item->text.'</p>';
    $html .= '<img src="'.$item->filename.'" />';
  }
  
  $pdf->writeHTML($html, true, false, true, false, '');
  
  
  //Close and output PDF document
  $pdf->Output($title.'.pdf', 'D');
}
  ?>