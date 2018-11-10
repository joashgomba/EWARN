<?php
class Landrates extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array(
            'url',
            'my_path'
        ));

       $this->load->library('Pdf');
    }

    public function index()
    {
        //create new PDF document
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('County Government of Nairobi');
        $pdf->SetTitle('PROPERTY RATES');
        $pdf->SetSubject('PROPERTY RATES');
        $pdf->SetKeywords('NAIROBI CITY COUNTY, RATES, PROPERTY, Diseases');


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

        $pdf->SetPrintFooter(false);

        //set some language-dependent strings
        //$pdf->setLanguageArray($l);

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('dejavusans', '', 9);

        $pdf->SetPrintHeader(false);

        $pdf->SetMargins(5, 10, 5, true);

        // add a page
        //$pdf->AddPage('L','A4');
        $pdf->AddPage();

        $html = '<table width="100%" cellpadding="0" cellspacing="0">
<tr><td width="15%"><img src="'. base_url().'images/Nairobi_City_Logo.png" width="100" height="100" alt=""></td>
<td width="85%" valign="top">
    <table width="100%" cellpadding="3" cellspacing="0" border="1" bordercolor="#999999" bgcolor="#ccccc0">
        <tr>
            <td width="60%" rowspan="2"><div align="center"><strong><font size="13">PROPERTY RATES<br>
            PAYMENT REQUEST</font></strong></div>
            </td>
            <td width="15%"><strong>Number</strong></td>
            <td width="25%"><strong>LR1803-05232</strong></td>
        </tr>
        <tr>
            <td width="15%"><strong>Date</strong></td>
            <td width="25%"><strong>06-Mar-2018</strong></td>
        </tr>
    </table>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td><strong><font size="10">LA Name: - 001 - NAIROBI CITY COUNTY</font></strong></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            CUSTOMER SERVICES OFFICE</td>
        </tr>
        
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <font size="7">The Customer Services Office Notifies</font> </td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="10">MOGERE GUTO &amp; OTHERS (P0074650-P)</font></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><font size="8">that the PROPERTY RATES payment for <strong><font size="10">36/VII/189/36/VII/189</font></strong> is due at the CASH OFFICE of the council</font></td>
        </tr>
    </table>
    
</td>
</tr>';

        $html .= '</table>';

        $html .= '<table width="100%" cellpadding="4" cellspacing="0" border="1" bordercolor="#999999">
<tr bgcolor="#ccccc0"><td><div align="center"><font size="10">DETAIL OF CHARGES</font></div></td></tr>

<tr><td>
<table width="100%" cellpadding="1" cellspacing="0">
<tr>
    <td width="5%"><strong>NO.</strong></td>
    <td width="10%"><strong>Account</strong></td>
    <td width="15%"><strong>CostCentreID</strong></td>
    <td width="40%"><strong>Description</strong></td>
    <td width="30%"><div align="right"><strong>Amount (KSh)</strong></div></td>
</tr>
<tr>
    <td width="5%">1</td>
    <td width="10%">1-2102</td>
    <td width="15%">0304-02-00</td>
    <td width="40%">Land Rates Penalties</td>
    <td width="30%"><div align="right">1,237,069</div></td>
</tr>
<tr>
    <td width="5%">2</td>
    <td width="10%">1-2103</td>
    <td width="15%">0304-02-00</td>
    <td width="40%">Land Rates Arrears (Principal)</td>
    <td width="30%"><div align="right">647,790</div></td>
</tr>
<tr>
    <td width="5%">3</td>
    <td width="10%">1-2101</td>
    <td width="15%">0304-02-00</td>
    <td width="40%">Land Rates Current Year</td>
    <td width="30%"><div align="right">27,750<br style="line-height:2px;" /><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
    <br>Bill Total Amount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1,905,109<br style="line-height:2px;" /><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></div></td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td colspan="5">
        <table width="75%" cellpadding="1" cellspacing="0">
            <tr>
                <td><font size="7">Annual Rates: 27,750</font> </td>
                <td><font size="7">Ground Rent: 0</font></td>
                <td><font size="7">Other Charges: 0</font></td>
                <td><font size="7">Total: 27,750</font></td>
            </tr>
        </table>
    </td>
</tr>
</table>


</td></tr>

</table>
<br style="line-height:1px;" />';
        $html .= '<table width="100%" cellpadding="4" cellspacing="0" border="1" bordercolor="#999999">
<tr><td><div align="center"><strong>The total outstanding amount before payment is KShs. 1,905,109<br>
NOTE: LATE PAYMENTS ATTRACT A PENALTY OF 3.00% PER MONTH FROM DUE DATE</strong>
</div></td></tr>
</table>';
        $html .= '<br style="line-height:1px;" />';
        $html .= '<table width="100%" cellpadding="4" cellspacing="0" border="1" bordercolor="#999999">
<tr><td><div align="right">Payment Information</div>
<p>&nbsp;</p>
</td></tr>
</table>';
        $html .= '<table width="100%" cellpadding="4" cellspacing="0" border="0">
<tr><td><div align="right">(Customer Copy)</div></td></tr>
</table>';
        $html .= '
<table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>';

        $html .= '<table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>......................................................................................................................................................................................................</td>
        </tr>
    </table>';

        $html .= '
<table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>';

        $html .= '<table width="100%" cellpadding="0" cellspacing="0">
<tr><td width="15%"><img src="'. base_url().'images/Nairobi_City_Logo.png" width="100" height="100" alt=""></td>
<td width="85%" valign="top">
    <table width="100%" cellpadding="3" cellspacing="0" border="1" bordercolor="#999999" bgcolor="#ccccc0">
        <tr>
            <td width="60%" rowspan="2"><div align="center"><strong><font size="13">PROPERTY RATES<br>
            PAYMENT REQUEST</font></strong></div>
            </td>
            <td width="15%"><strong>Number</strong></td>
            <td width="25%"><strong>LR1803-05232</strong></td>
        </tr>
        <tr>
            <td width="15%"><strong>Date</strong></td>
            <td width="25%"><strong>06-Mar-2018</strong></td>
        </tr>
    </table>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td><strong><font size="10">LA Name: - 001 - NAIROBI CITY COUNTY</font></strong></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            CUSTOMER SERVICES OFFICE</td>
        </tr>
        
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <font size="7">The Customer Services Office Notifies</font> </td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="10">MOGERE GUTO &amp; OTHERS (P0074650-P)</font></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><font size="8">that the PROPERTY RATES payment for <strong><font size="10">36/VII/189/36/VII/189</font></strong> is due at the CASH OFFICE of the council</font></td>
        </tr>
    </table>
    
</td>
</tr>';

        $html .= '</table>';

        $html .= '<table width="100%" cellpadding="4" cellspacing="0" border="1" bordercolor="#999999">
<tr bgcolor="#ccccc0"><td><div align="center"><font size="10">DETAIL OF CHARGES</font></div></td></tr>

<tr><td>
<table width="100%" cellpadding="1" cellspacing="0">
<tr>
    <td width="5%"><strong>NO.</strong></td>
    <td width="10%"><strong>Account</strong></td>
    <td width="15%"><strong>CostCentreID</strong></td>
    <td width="40%"><strong>Description</strong></td>
    <td width="30%"><div align="right"><strong>Amount (KSh)</strong></div></td>
</tr>
<tr>
    <td width="5%">1</td>
    <td width="10%">1-2102</td>
    <td width="15%">0304-02-00</td>
    <td width="40%">Land Rates Penalties</td>
    <td width="30%"><div align="right">1,237,069</div></td>
</tr>
<tr>
    <td width="5%">2</td>
    <td width="10%">1-2103</td>
    <td width="15%">0304-02-00</td>
    <td width="40%">Land Rates Arrears (Principal)</td>
    <td width="30%"><div align="right">647,790</div></td>
</tr>
<tr>
    <td width="5%">3</td>
    <td width="10%">1-2101</td>
    <td width="15%">0304-02-00</td>
    <td width="40%">Land Rates Current Year</td>
    <td width="30%"><div align="right">27,750<br style="line-height:2px;" /><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
    <br>Bill Total Amount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1,905,109<br style="line-height:2px;" /><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></div></td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td colspan="5">
        <table width="75%" cellpadding="1" cellspacing="0">
            <tr>
                <td><font size="7">Annual Rates: 27,750</font> </td>
                <td><font size="7">Ground Rent: 0</font></td>
                <td><font size="7">Other Charges: 0</font></td>
                <td><font size="7">Total: 27,750</font></td>
            </tr>
        </table>
    </td>
</tr>
</table>


</td></tr>

</table>
<br style="line-height:1px;" />';
        $html .= '<table width="100%" cellpadding="4" cellspacing="0" border="1" bordercolor="#999999">
<tr><td><div align="center"><strong>The total outstanding amount before payment is KShs. 1,905,109<br>
NOTE: LATE PAYMENTS ATTRACT A PENALTY OF 3.00% PER MONTH FROM DUE DATE</strong>
</div></td></tr>
</table>';
        $html .= '<br style="line-height:1px;" />';
        $html .= '<table width="100%" cellpadding="4" cellspacing="0" border="1" bordercolor="#999999">
<tr><td><div align="right">Payment Information</div>
<p>&nbsp;</p>
</td></tr>
</table>';
        $html .= '<table width="100%" cellpadding="4" cellspacing="0" border="0">
<tr><td><div align="right">(Cash Office Copy)</div></td></tr>
</table>';





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
        $pdf->Output('PropertyRates.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+
    }

    public function template()
    {
        //create new PDF document
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('County Government of Nairobi');
        $pdf->SetTitle('PROPERTY RATES');
        $pdf->SetSubject('PROPERTY RATES');
        $pdf->SetKeywords('NAIROBI CITY COUNTY, RATES, PROPERTY, Diseases');


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

        $pdf->SetPrintFooter(false);

        //set some language-dependent strings
        //$pdf->setLanguageArray($l);

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('dejavusans', '', 9);

        $pdf->SetPrintHeader(false);

        $pdf->SetMargins(5, 10, 5, true);

        // add a page
        //$pdf->AddPage('L','A4');
        $pdf->AddPage();

        $html = '
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td width="15%"><img src="'. base_url().'images/Nairobi_City_Logo.png" width="100" height="100" alt=""></td>
<td width="85%" valign="top">
    <table width="100%" cellpadding="3" cellspacing="0" border="1" bordercolor="#999999" bgcolor="#ccccc0">
        <tr>
            <td width="60%" rowspan="2"><div align="center"><strong><font size="13">PROPERTY RATES<br>
            PAYMENT REQUEST</font></strong></div>
            </td>
            <td width="15%"><strong>Number</strong></td>
            <td width="25%"><strong>LR1801-22339</strong></td>
        </tr>
        <tr>
            <td width="15%"><strong>Date</strong></td>
            <td width="25%"><strong>06-Mar-2018</strong></td>
        </tr>
    </table>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td><strong><font size="10">LA Name: - 001 - NAIROBI CITY COUNTY</font></strong></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            CUSTOMER SERVICES OFFICE</td>
        </tr>
        
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <font size="7">The Customer Services Office Notifies</font> </td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="10">KEBOYE TRADING CO LTD (P0071980-P)</font></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><font size="8">that the PROPERTY RATES payment for <strong><font size="10">36/VII/356/36/VII/356</font></strong> is due at the CASH OFFICE of the council</font></td>
        </tr>
    </table>
    
</td>
</tr>';

        $html .= '</table>';

        $html .= '<table width="100%" cellpadding="4" cellspacing="0" border="1" bordercolor="#999999">
<tr bgcolor="#ccccc0"><td><div align="center"><font size="10">DETAIL OF CHARGES</font></div></td></tr>

<tr><td>
<table width="100%" cellpadding="1" cellspacing="0">
<tr>
    <td width="5%"><strong>NO.</strong></td>
    <td width="10%"><strong>Account</strong></td>
    <td width="15%"><strong>CostCentreID</strong></td>
    <td width="40%"><strong>Description</strong></td>
    <td width="30%"><div align="right"><strong>Amount (KSh)</strong></div></td>
</tr>
<tr>
    <td width="5%">1</td>
    <td width="10%">1-2102</td>
    <td width="15%">0304-02-00</td>
    <td width="40%">Land Rates Penalties</td>
    <td width="30%"><div align="right">2,247,405</div></td>
</tr>
<tr>
    <td width="5%">2</td>
    <td width="10%">1-2103</td>
    <td width="15%">0304-02-00</td>
    <td width="40%">Land Rates Arrears (Principal)</td>
    <td width="30%"><div align="right">865,490</div></td>
</tr>
<tr>
    <td width="5%">3</td>
    <td width="10%">1-2101</td>
    <td width="15%">0304-02-00</td>
    <td width="40%">Land Rates Current Year</td>
    <td width="30%"><div align="right">27,750<br style="line-height:2px;" /><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
    <br>Bill Total Amount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3,140,645<br style="line-height:2px;" /><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></div></td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td colspan="5">
        <table width="75%" cellpadding="1" cellspacing="0">
            <tr>
                <td><font size="7">Annual Rates: 27,750</font> </td>
                <td><font size="7">Ground Rent: 0</font></td>
                <td><font size="7">Other Charges: 0</font></td>
                <td><font size="7">Total: 27,750</font></td>
            </tr>
        </table>
    </td>
</tr>
</table>


</td></tr>

</table>
<br style="line-height:1px;" />';
        $html .= '<table width="100%" cellpadding="4" cellspacing="0" border="1" bordercolor="#999999">
<tr><td><div align="center"><strong>The total outstanding amount before payment is KShs. 3,140,645<br>
NOTE: LATE PAYMENTS ATTRACT A PENALTY OF 3.00% PER MONTH FROM DUE DATE</strong>
</div></td></tr>
</table>';
        $html .= '<br style="line-height:1px;" />';
        $html .= '<table width="100%" cellpadding="4" cellspacing="0" border="1" bordercolor="#999999">
<tr><td><div align="right">Payment Information</div>
<p>&nbsp;</p>
</td></tr>
</table>';
        $html .= '<table width="100%" cellpadding="4" cellspacing="0" border="0">
<tr><td><div align="right">(Customer Copy)</div></td></tr>
</table>';
        $html .= '
<table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>';

        $html .= '<table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>......................................................................................................................................................................................................</td>
        </tr>
    </table>';

        $html .= '
<table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>';

        $html .= '
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td width="15%"><img src="'. base_url().'images/Nairobi_City_Logo.png" width="100" height="100" alt=""></td>
<td width="85%" valign="top">
    <table width="100%" cellpadding="3" cellspacing="0" border="1" bordercolor="#999999" bgcolor="#ccccc0">
        <tr>
            <td width="60%" rowspan="2"><div align="center"><strong><font size="13">PROPERTY RATES<br>
            PAYMENT REQUEST</font></strong></div>
            </td>
            <td width="15%"><strong>Number</strong></td>
            <td width="25%"><strong>LR1801-22339</strong></td>
        </tr>
        <tr>
            <td width="15%"><strong>Date</strong></td>
            <td width="25%"><strong>06-Mar-2018</strong></td>
        </tr>
    </table>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td><strong><font size="10">LA Name: - 001 - NAIROBI CITY COUNTY</font></strong></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            CUSTOMER SERVICES OFFICE</td>
        </tr>
        
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <font size="7">The Customer Services Office Notifies</font> </td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="10">KEBOYE TRADING CO LTD (P0071980-P)</font></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><font size="8">that the PROPERTY RATES payment for <strong><font size="10">36/VII/356/36/VII/356</font></strong> is due at the CASH OFFICE of the council</font></td>
        </tr>
    </table>
    
</td>
</tr>';

        $html .= '</table>';

        $html .= '<table width="100%" cellpadding="4" cellspacing="0" border="1" bordercolor="#999999">
<tr bgcolor="#ccccc0"><td><div align="center"><font size="10">DETAIL OF CHARGES</font></div></td></tr>

<tr><td>
<table width="100%" cellpadding="1" cellspacing="0">
<tr>
    <td width="5%"><strong>NO.</strong></td>
    <td width="10%"><strong>Account</strong></td>
    <td width="15%"><strong>CostCentreID</strong></td>
    <td width="40%"><strong>Description</strong></td>
    <td width="30%"><div align="right"><strong>Amount (KSh)</strong></div></td>
</tr>
<tr>
    <td width="5%">1</td>
    <td width="10%">1-2102</td>
    <td width="15%">0304-02-00</td>
    <td width="40%">Land Rates Penalties</td>
    <td width="30%"><div align="right">2,247,405</div></td>
</tr>
<tr>
    <td width="5%">2</td>
    <td width="10%">1-2103</td>
    <td width="15%">0304-02-00</td>
    <td width="40%">Land Rates Arrears (Principal)</td>
    <td width="30%"><div align="right">865,490</div></td>
</tr>
<tr>
    <td width="5%">3</td>
    <td width="10%">1-2101</td>
    <td width="15%">0304-02-00</td>
    <td width="40%">Land Rates Current Year</td>
    <td width="30%"><div align="right">27,750<br style="line-height:2px;" /><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
    <br>Bill Total Amount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3,140,645<br style="line-height:2px;" /><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></div></td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td colspan="5">
        <table width="75%" cellpadding="1" cellspacing="0">
            <tr>
                <td><font size="7">Annual Rates: 27,750</font> </td>
                <td><font size="7">Ground Rent: 0</font></td>
                <td><font size="7">Other Charges: 0</font></td>
                <td><font size="7">Total: 27,750</font></td>
            </tr>
        </table>
    </td>
</tr>
</table>


</td></tr>

</table>
<br style="line-height:1px;" />';
        $html .= '<table width="100%" cellpadding="4" cellspacing="0" border="1" bordercolor="#999999">
<tr><td><div align="center"><strong>The total outstanding amount before payment is KShs. 3,140,645<br>
NOTE: LATE PAYMENTS ATTRACT A PENALTY OF 3.00% PER MONTH FROM DUE DATE</strong>
</div></td></tr>
</table>';
        $html .= '<br style="line-height:1px;" />';
        $html .= '<table width="100%" cellpadding="4" cellspacing="0" border="1" bordercolor="#999999">
<tr><td><div align="right">Payment Information</div>
<p>&nbsp;</p>
</td></tr>
</table>';
        $html .= '<table width="100%" cellpadding="4" cellspacing="0" border="0">
<tr><td><div align="right">(Cash Office Copy)</div></td></tr>
</table>';
        $html .= '
<table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>';





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
        $pdf->Output('PropertyRates.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+
    }
}
?>