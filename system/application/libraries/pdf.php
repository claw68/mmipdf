<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//============================================================+
// File name   : example_061.php
// Begin       : 2010-05-24
// Last Update : 2010-08-08
//
// Description : Example 061 for TCPDF class
//               XHTML + CSS
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               Manor Coach House, Church Hill
//               Aldershot, Hants, GU12 4RQ
//               UK
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: XHTML + CSS
 * @author Nicola Asuni
 * @since 2010-05-25
 */

require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');
class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
	    //Page header
    public function Header() {
        // Logo
		
		$this->SetFont('helvetica', 'B', 14);
        // Title
        
		//TCPDF::Cell($w,$h = 0,$txt = '',$border = 0,$ln = 0,$align = '',$fill = false,$link = '',$stretch = 0,$ignore_min_height = false,$calign = 'T',$valign = 'M' )
		$html = "<div>Bukidnon State University</div>";
		
		//TCPDF::writeHTMLCell($w,$h,$x,$y,$html = '',$border = 0,$ln = 0,$fill = false,$reseth = true,$align = '',$autopadding = true)
		
		$this->writeHTMLCell(0,14,15,12,$html,0, true, false, true, 'M', true);
       // $this->Cell(0, 20, 'Unilever Philippines, Inc.', 0, true, '', 0, '', 0, false, 'M', 'M');
		$this->SetFont('helvetica', '', 11);
        // Title
        //$this->Cell(0, 20, 'Customer Marketing Department', 0, true, '', 0, '', 0, false, 'M', 'M');
        $html = "<p>Computer Society</p>";
  		$this->writeHTMLCell(0,14,15,18,$html,0, true, false, true, 'M', true);
		//$pdf->writeHTML($html, true, false, true, false, '');
		//Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
        $this->Image(K_PATH_IMAGES.PDF_HEADER_LOGO, 250, 7, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font    
    }
}