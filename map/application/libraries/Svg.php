<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/svg/SVGGraph.php';
class Svg extends SVGGraph{	
    function __construct()    {
        parent::__construct($w=100, $h=100, $settings = NULL);
    }
}


/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */ 
?>
