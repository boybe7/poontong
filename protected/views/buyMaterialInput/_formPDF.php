<?php


// Include the main TCPDF library (search for installation path).
require_once($_SERVER['DOCUMENT_ROOT'].'/poontong/protected/tcpdf/tcpdf.php');

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
        $this->writeHTMLCell(145, 20, 0, 2, '<p style="font-weight:bold;">'.$this->site_name.'</p>', 0, 1, false, true, 'C', false);
        $this->writeHTMLCell(145, 20, 2, 10, '<span style="text-align:center;font-size:14px;font-weight:bold;">ที่อยู่ '.$this->site_address.'</span>', 0, 1, false, true, 'C', false);
        $this->writeHTMLCell(145, 20, 2, 14, '<span style="text-align:center;font-size:14px;font-weight:bold;">เบอร์โทร '.$this->site_phone.'</span>', 0, 1, false, true, 'C', false);
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

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('poontong');
$pdf->SetTitle('ใบรับซื้อ');
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

$html .= '<br><br><div style="font-weight:bold;font-size:28px;text-align:center"><u>ใบรับซื้อสินค้า</u></div>';
$html .= '<table border=0><tr style="font-weight:bold;font-size:16px;"><td width="50%">เลขที่ : '.$model->bill_no.'</td>';
$html .= '<td width="50%" style="text-align:right">วันที่ : '.$model->buy_date.'</td></tr>';
$html .= '<tr style="font-weight:bold;font-size:16px;"><td colspan=2>ลูกค้า : '.Customer::model()->findByPk($model->customer_id)->name.'</td></tr></table>';

$html .= '<br><br><table style=""><tr style="font-weight:bold;font-size:16px;">
			<td width="45%" style="border-top:1px solid black;border-bottom:1px solid black;text-align:center;">รายการ</td><td width="15%" style="border-top:1px solid black;border-bottom:1px solid black;text-align:center;">จำนวน</td><td width="20%" style="border-top:1px solid black;border-bottom:1px solid black;text-align:right;">ราคาต่อหน่วย</td><td width="20%" style="border-top:1px solid black;border-bottom:1px solid black;text-align:right;">รวมเงิน</td></tr>';
$details = BuyMaterialDetail::model()->findAll('buy_id='.$model->id);
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
$html .=  '<tr style="font-weight:bold;font-size:16px;">';
		$html .=  '<td colspan=3 width="80%" style="border-top:1px solid black;border-bottom:1px solid black;text-align:center;">รวมเป็นเงินทั้งหมด</td>';
		$html .=  '<td width="20%" style="border-top:1px solid black;border-bottom:1px solid black;text-align:right;">'.number_format($total,2).'</td>';
$html .=  '</tr>';
$html .= '</table>';
    
$html .= '<br><br><br><br><table border=0><tr style="font-size:16px;"><td width="50%"></td>';
$html .= '<td width="50%" style="text-align:right">ผู้รับของ _____________________</td></tr></table>';  
  
$pdf->AddPage('P','A5');
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->Output($_SERVER['DOCUMENT_ROOT'].'/poontong/report/temp/'.$filename,'F');
// Print text using writeHTMLCell()


// ---------------------------------------------------------

// Close and output PDF document

ob_end_clean() ;

exit;
?>