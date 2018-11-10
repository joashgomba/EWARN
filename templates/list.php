<? include(APPPATH . 'views/common/header.php'); ?>
<? include(APPPATH . 'views/common/top.php'); ?>
<? include(APPPATH . 'views/common/navigation.php'); ?>
<section id="content">
<div class="g12">
<h1>List</h1>
<p><?php
echo anchor(base_url().'index.php/{controller_name_l}/add/','&nbsp;',array('class'=>'btn i_document_add'));
if(!$results){
	echo '<h1>No Data</h1>';
	exit;
}
?></p>
<p><div id="tnt_pagination"><?php echo $this->pagination->create_links();?></div></p>

<?php
	$header = array_keys($results[0]);

for($i=0;$i<count($results);$i++){
            $id = array_values($results[$i]);
            $results[$i]['Edit']     = anchor(base_url().'index.php/{controller_name_l}/edit/'.$id[0],'Edit',array('class'=>'update'));
            $results[$i]['Delete']   = anchor(base_url().'index.php/{controller_name_l}/delete/'.$id[0],'Delete',array('class'=>'delete','onClick'=>'return deletechecked(\' '.base_url().'index.php/{controller_name_l}/delete/'.$id[0].' \')'));                                          
			array_shift($results[$i]);                        
        }
        
$clean_header = clean_header($header);
array_shift($clean_header);
$this->table->set_heading($clean_header); 
$this->table->set_template($template);
// view
echo $this->table->generate($results); 
//echo $this->pagination->create_links();
?>
<script type="text/javascript">
function deletechecked(link)
{
    var answer = confirm('Delete item?')
    if (answer){
        window.location = link;
    }
    
    return false;  
}

</script>
</div>
</section><!-- end div #content -->
<? include(APPPATH . 'views/common/footer.php'); ?>
