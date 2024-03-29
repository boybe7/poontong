<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/poontong/tcpdf/tcpdf.php');

class MYPDF extends TCPDF {

	private $site_name;
	private $site_phone;
	private $site_address;
	
	public function setHeaderInfo($site_name,$site_phone,$site_address) {
		$this->site_name = $site_name;
		$this->site_phone = $site_phone;
		$this->site_address = $site_address;
		        
	}

    //Page header
    public function Header() {
        
        // Set font
        $this->SetFont('thsarabun', '', 18);
        $this->writeHTMLCell(229, 20, 0, 2, '<center><p style="font-weight:bold;">'.$this->site_name.'</p></center>', 0, 1, false, true, 'C', false);
        $this->writeHTMLCell(229, 20, 2, 10, '<span style="text-align:center;font-size:14px;font-weight:bold;">ที่อยู่ '.$this->site_address.'</span>', 0, 1, false, true, 'C', false);
        $this->writeHTMLCell(229, 20, 2, 14, '<span style="text-align:center;font-size:14px;font-weight:bold;">เบอร์โทร '.$this->site_phone.'</span>', 0, 1, false, true, 'C', false);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-10);
        // Set font
        $this->SetFont('thsarabun', '', 11);
        // Page number
        //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        // Logo
        //$image_file = 'bank/image/mwa2.jpg';
        //$this->Image($image_file, 170, 270, 25, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Cell(0, 5, date("d/m/Y"), 0, false, 'R', 0, '', 0, false, 'T', 'M');

        
        //writeHTMLCell ($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=false, $reseth=true, $align='', $autopadding=true)
    }
}

// create new PDF document
//$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF('P', 'mm', array(228.6, 139.7), true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('poontong');
$pdf->SetTitle('ใบแจ้งหนี้');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setPrintHeader(true);
$site = Site::model()->FindByPk($model->site_id);
$pdf->setHeaderInfo($site->name,$site->telephone,$site->address);
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('thsarabun', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
//$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$html = "";

$html .= '<br><br><div style="font-weight:bold;font-size:28px;text-align:center"><u>ใบแจ้งหนี้</u></div>';
$html .= '<table border=0><tr style="font-weight:bold;font-size:16px;"><td width="50%">เลขที่ : '.$model->bill_no.'</td>';
$html .= '<td width="50%" style="text-align:right">วันที่ : '.$model->sell_date.'</td></tr>';
$html .= '<tr style="font-weight:bold;font-size:16px;"><td colspan=2>ลูกค้า : '.Customer::model()->findByPk($model->customer_id)->name.'</td></tr>';
$html .= '<tr style="font-weight:bold;font-size:16px;"><td colspan=2>ที่อยู่ : '.Customer::model()->findByPk($model->customer_id)->address.'</td></tr>';
$html .= '</table>';

$html .= '<br><br><table style=""><tr style="font-weight:bold;font-size:16px;">
			<td width="45%" style="border-top:1px solid black;border-bottom:1px solid black;text-align:center;">รายการ</td><td width="15%" style="border-top:1px solid black;border-bottom:1px solid black;text-align:center;">จำนวน</td><td width="20%" style="border-top:1px solid black;border-bottom:1px solid black;text-align:right;">ราคาต่อหน่วย</td><td width="20%" style="border-top:1px solid black;border-bottom:1px solid black;text-align:right;">รวมเงิน</td></tr>';
$details = SellMaterialDetail::model()->findAll('sell_id='.$model->id);
$total = 0;
foreach ($details as $key => $value) {
	$html .=  '<tr>';
		$html .=  '<td style="">'.Material::model()->findByPk($value->material_id)->name.'</td>';
		$html .=  '<td style="text-align:center;">'.$value->amount.'</td>';
		$html .=  '<td style="text-align:right;">'.number_format($value->price_unit,2).'</td>';
		$html .=  '<td style="text-align:right;">'.number_format($value->price_net,2).'</td>';
	$html .=  '</tr>';	

	$total += $value->price_net;
}
$html .=  '<tr style="font-weight:bold;font-size:16px;"><td colspan=4  width="100%" style="line-height: 10%;border-top:1px solid black;text-align:right;"></td></tr>';

$html .=  '<tr style="">';
		$html .=  '<td width="45%" ></td><td colspan=2 width="35%" style="text-align:right;font-weight:bold;font-size:16px;">รวมเป็นเงิน</td>';
		$html .=  '<td width="20%" bgcolor="ghostwhite" style="text-align:right;">'.number_format($total,2).'</td>';
$html .=  '</tr>';

$vat = round($total*0.07,2);
$html .=  '<tr style="">';
		$html .=  '<td width="45%"></td><td colspan=2 width="35%" style="text-align:right;font-weight:bold;font-size:16px;">ภาษีมูลค่าเพิ่ม 7%</td>';
		$html .=  '<td width="20%" bgcolor="ghostwhite" style="text-align:right;">'.number_format($vat,2).'</td>';
$html .=  '</tr>';
$html .=  '<tr style="font-weight:bold;font-size:16px;">';
		$html .=  '<td width="45%"></td><td colspan=2 width="35%" style="text-align:right;">รวมเป็นเงินทั้งหมด</td>';
		$html .=  '<td width="20%" bgcolor="gainsboro" style="text-align:right;">'.number_format($total+$vat,2).'</td>';
$html .=  '</tr>';
$html .= '</table>';
    
$html .= '<br><br><br><br><table border=0><tr style="font-size:16px;"><td width="50%"></td>';
$html .= '<td width="50%" style="text-align:right">ผู้อนุมัติ _____________________</td></tr></table>';  
  
$page_format = array(
    'MediaBox' => array ('llx' => 0, 'lly' => 0, 'urx' => 228, 'ury' => 139),
    //'CropBox' => array ('llx' => 0, 'lly' => 0, 'urx' => 210, 'ury' => 297),
    //'BleedBox' => array ('llx' => 5, 'lly' => 5, 'urx' => 205, 'ury' => 292),
    //'TrimBox' => array ('llx' => 10, 'lly' => 10, 'urx' => 200, 'ury' => 287),
    //'ArtBox' => array ('llx' => 15, 'lly' => 15, 'urx' => 195, 'ury' => 282),
    'Dur' => 3,
    'trans' => array(
        'D' => 1.5,
        'S' => 'Split',
        'Dm' => 'V',
        'M' => 'O'
    ),
    'Rotate' => 0,
    'PZ' => 1,
);

// Check the example n. 29 for viewer preferences

// add first page ---
$pdf->AddPage('L', $page_format, false, false);


$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->Output($_SERVER['DOCUMENT_ROOT'].'/poontong/report/temp/'.$filename,'F');
// Print text using writeHTMLCell()


// ---------------------------------------------------------

// Close and output PDF document

ob_end_clean() ;

exit;
?>