<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receipts extends CI_Controller {


	public function index()
	{
        /*******GENERATE PDF FOR ATTACHMENT*******/

        // create new PDF document
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('DRC/DDG');
        $pdf->SetTitle('Monthly Statistical Report');
        $pdf->SetSubject('DRC/DDG Monthly Statistical Report');
        $pdf->SetKeywords('DRC, DDG, Report, Statistics','Projects','Beneficiaries','Activities');

        // set default header data
        $pdf->SetHeaderData(false, false, '', '');


        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


        //set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        //set some language-dependent strings
        //$pdf->setLanguageArray($l);

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('dejavusans', '', 9);

        $pdf->SetPrintHeader(false);

        // add a page
        //$pdf->AddPage('L','A4');
        $pdf->AddPage('P','A4');

        $html = '<table width="100%" cellpadding="1" cellspacing="1" border="1">';

        $html .= '<tr><td width="20%"><img src="'. base_url().'images/mansoor.png" alt="" width="138" height="63"></td><td width="80%" valign="center"><center><font size="20"> MAANSOOR HOTEL</font></center></td></tr>';

        $html .= '</table>';


        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        $txt = date("m/d/Y h:m:s");

        // print a block of text using Write()
        //$pdf->Write($h=0, $txt, $link='', $fill=0, $align='C', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // test pre tag


        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // reset pointer to the last page
        $pdf->lastPage();

        ob_start();
        // ---------------------------------------------------------
        //ob_end_clean();
        //Close and output PDF document
        $pdf->Output('Mansoor_Receipt.pdf', 'I');
       // $pdf->Output('Mansoor_Receipt.pdf', 'F');

        //============================================================+
        // END OF FILE
        //============================================================+



        /****************END OF PDF GENERATION*********************/
	}

    public function garowe()
    {
        /*******GENERATE PDF FOR ATTACHMENT*******/

        // create new PDF document
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('GIH');
        $pdf->SetTitle('Receipt');
        $pdf->SetSubject('Accomodation Receipt');
        $pdf->SetKeywords('GIH, Receipt, Garowe, UNSOA');

        // set default header data
        $pdf->SetHeaderData(false, false, '', '');


        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


        //set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        //set some language-dependent strings
        //$pdf->setLanguageArray($l);

        $pdf->SetFooterMargin(0);
        $pdf->setPrintFooter(false);
        $pdf->SetAutoPageBreak(False, 0);

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('times', '', 9);

        $pdf->SetPrintHeader(false);

        // add a page
        //$pdf->AddPage('L','A4');
        $pdf->SetMargins(1,1,1); // set the margins
        $pdf->AddPage('L','A6');


        $html = '<table width="100%" cellpadding="2" cellspacing="0" style="border: 3px solid #1aa3ff;">';

        $html .= '<tr><td>
<table width="100%" cellpadding="3" cellspacing="0" style="border: 1px solid #1aa3ff;">
<tr><td>';
        $html .= '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
        $html .= '<tr><td colspan="2"><div align="center"><font size="23" color="#1aa3ff"><strong>GIH COMPOUND GAROWE</strong></font></div> </td></tr>';
        $html .= '<tr><td width="70%"><div align="center"><font size="17" color="#1aa3ff"><u>Receipt Voucher</u></font></div>
<br><font size="13" color="#1aa3ff">Date: ...............</font> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="13" color="#1aa3ff">No:</font> <font color="#ff3333" size="16">3148</font></td><td width="30%"><img src="'. base_url().'images/UNSOA.png" alt="" ></td></tr>';
        $html .= '<tr><td colspan="2"><font size="13" color="#1aa3ff">Received from: .................................................................................................</font></td></tr>';
        $html .= '<tr><td colspan="2">&nbsp;</td></tr>';
        $html .= '<tr><td colspan="2"><font size="13" color="#1aa3ff">Amount USDS: ......................... Inwards ............................. GIH ..................</font></td></tr>';
        $html .= '<tr><td colspan="2">&nbsp;</td></tr>';
        $html .= '<tr><td colspan="2"><font size="13" color="#1aa3ff">..........................................................................................................................</font></td></tr>';
        $html .= '<tr><td colspan="2">&nbsp;</td></tr>';
        $html .= '<tr><td colspan="2"><font size="13" color="#1aa3ff">Being: ..............................................................................................................</font></td></tr>';
        $html .= '<tr><td colspan="2"><font size="13" color="#1aa3ff">..........................................................................................................................</font></td></tr>';
        $html .= '<tr><td colspan="2">&nbsp;</td></tr>';
        $html .= '<tr><td colspan="2"><font size="13" color="#1aa3ff">Received by: Name ............................................... Signature .........................</font></td></tr>';
        $html .= '<tr><td colspan="2">&nbsp;</td></tr>';
        $html .= '<tr><td colspan="2"><font size="13" color="#1aa3ff">Date: .........................</font><br></td></tr>';
        $html .= '</table>';
        $html .='</td></tr>
</table>

</td></tr>';

        $html .= '</table>';


        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        $txt = date("m/d/Y h:m:s");

        // print a block of text using Write()
        //$pdf->Write($h=0, $txt, $link='', $fill=0, $align='C', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // test pre tag


        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // reset pointer to the last page
        $pdf->lastPage();
        ob_start();
        // ---------------------------------------------------------
        //ob_end_clean();
        //Close and output PDF document
        $pdf->Output('GIH_Receipt.pdf', 'I');
        // $pdf->Output('Mansoor_Receipt.pdf', 'F');

        //============================================================+
        // END OF FILE
        //============================================================+



        /****************END OF PDF GENERATION*********************/
    }
}

