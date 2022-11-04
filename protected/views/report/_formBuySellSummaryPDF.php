<?php


// Include the main TCPDF library (search for installation path).
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
        $this->writeHTMLCell(0, 0, 0, 2, '<p style="font-weight:bold;text-align:center;">'.$this->site_name.'</p>', 0, 1, false, true, 'C', false);
        //$this->writeHTMLCell(229, 20, 2, 10, '<span style="text-align:center;font-size:14px;font-weight:bold;">ที่อยู่ '.$this->site_address.'</span>', 0, 1, false, true, 'C', false);
        //$this->writeHTMLCell(229, 20, 2, 14, '<span style="text-align:center;font-size:14px;font-weight:bold;">เบอร์โทร '.$this->site_phone.'</span>', 0, 1, false, true, 'C', false);
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
$pdf->SetTitle('ใบรับซื้อ');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setPrintHeader(true);
$site = Site::model()->FindByPk(Yii::app()->user->getSite());
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

$month_th = array("1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม","4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน","7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน","10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");

// $month = $monthBegin<10 ? "0".$monthBegin : $monthBegin ;
// $date_start = ($yearBegin-543)."-".$month."-01";
// $month = $monthEnd<10 ? "0".$monthEnd : $monthEnd ;
// $number = cal_days_in_month(CAL_GREGORIAN, $monthEnd, $yearEnd-543);
// $day = $number<10 ? "0".$number : $number ;
// $date_end = ($yearEnd-543)."-".$month."-".$day;

$date_start = ($year-543)."-01-01";
$date_end = ($year-543)."-12-31";

    //$html .= $month_th[$monthBegin]." ".$yearBegin." - ".$month_th[$monthEnd]." ".$yearEnd;
    //$html .= "<center><div class='header'><b>รายงานสรุปซื้อขาย ระหว่างเดือน ".$month_th[$monthBegin]." ".$yearBegin." - ".$month_th[$monthEnd]." ".$yearEnd."</b></div></center>";
$html = "";
$html .= '<center><div class="header" style="text-align:center;"><h4>รายงานสรุปซื้อขาย ปี '.$year.'</h4></div></center>';
    
    $raw_material = Material::model()->findAll('site_id=:id', array(':id' => Yii::app()->user->getSite()));
    
    $materialBuy = Yii::app()->db->createCommand()
                            ->select('material_id')
                            ->from('buy_material_detail')
                            ->join('buy_material_input t', 'buy_id=t.id')
                            ->where(" buy_date BETWEEN '".$date_start."' AND '".$date_end."' AND t.site_id='".Yii::app()->user->getSite()."'")
                            ->group("material_id")
                            ->queryAll();


    $materialSell = Yii::app()->db->createCommand()
                            ->select('material_id')
                            ->from('sell_material_detail')
                            ->join('sell_material t', 'sell_id=t.id')
                            ->where(" sell_date BETWEEN '".$date_start."' AND '".$date_end."' AND t.site_id='".Yii::app()->user->getSite()."'")
                            ->group("material_id")
                            ->queryAll();                        

    
        $html .= '<table style="">';

        $html .= '<tr>';
        
            $html .= '<td rowspan="2" width="10%" style="width:10%;text-align:center;font-weight:bold;background-color: #c3c8c2;">เดือน ปี</td>';
            $num_material_buy = count($materialBuy);
            $colwidth_buy = round(45/$num_material_buy);
            $colwidth = $colwidth_buy*$num_material_buy;
            $html .= '<td colspan="'.$num_material_buy.'" width="'.$colwidth.'%" style="text-align:center;font-weight:bold;background-color: #def7d7;">รายการซื้อ (บาท)</td>';
            $num_material_sell = count($materialSell);
            $colwidth_sell = round(45/$num_material_sell);
            $colwidth = $colwidth_sell*$num_material_sell;
            $html .= '<td colspan="'.$num_material_sell.'" width="'.$colwidth.'%" style="text-align:center;font-weight:bold;background-color: #ffeec1;">รายการขาย (บาท)</td>';
        
        $html .= '</tr>';

        $html .= '<tr>';
            $material_id = array();
            foreach ($materialBuy as $key => $value) {
                $html .= '<td  width="'.$colwidth_buy.'%" style="text-align:center;font-weight:bold;background-color: #afd7a3;">'.Material::model()->FindByPk($value["material_id"])->name.'</td>';
                //$material_id[] = $value["material_id"];
            }

            foreach ($materialSell as $key => $value) {
                $html .= '<td  width="'.$colwidth_sell.'%" style="text-align:center;font-weight:bold;background-color: #ffe295;">'.Material::model()->FindByPk($value["material_id"])->name.'</td>';
                //$material_id[] = $value["material_id"];
            }

    
        $html .= '</tr>';

        for ($i=1; $i <= 12; $i++) {
            $bgcolor = $i%2==0 ?  "#eff4fd" : "#ffffff";

            $html .= '<tr>';
                $html .= '<td style="text-align:center;background-color:'.$bgcolor.'">'.$month_th[$i].' '.$year.'</td>';
                foreach ($materialBuy as $key => $value) {
                    $mbuy = Yii::app()->db->createCommand()
                            ->select('sum(price_net) as pricenet')
                            ->from('buy_material_detail')
                            ->join('buy_material_input t', 'buy_id=t.id')
                            ->where("material_id=".$value['material_id']." AND MONTH(buy_date) = '".$i."' AND  YEAR(buy_date)= '".($year-543)."' AND t.site_id='".Yii::app()->user->getSite()."'")
                            ->queryAll();

                    $price = empty($mbuy[0]['pricenet']) ? "-" : number_format($mbuy[0]['pricenet'],2);     
                    $html .= '<td style="text-align:right;background-color:'.$bgcolor.'">'.$price.'</td>';      
                }   

                foreach ($materialSell as $key => $value) {
                    $msell = Yii::app()->db->createCommand()
                            ->select('sum(price_net) as pricenet')
                            ->from('sell_material_detail')
                            ->join('sell_material t', 'sell_id=t.id')
                            ->where("material_id=".$value['material_id']." AND MONTH(sell_date) = '".$i."' AND  YEAR(sell_date)= '".($year-543)."' AND t.site_id='".Yii::app()->user->getSite()."'")
                            ->queryAll();

                    $price = empty($msell[0]['pricenet']) ? "-" : number_format($msell[0]['pricenet'],2);       
                    $html .= '<td style="text-align:right;background-color:'.$bgcolor.'">'.$price.'</td>';      
                }   
            $html .= '</tr>';
        }

        $html .= '<tr>';
                $html .= '<td style="text-align:center;font-weight:bold;background-color:#c3c8c2">รวม</td>';
                $sumbuy = 0;
                foreach ($materialBuy as $key => $value) {
                    $mbuy = Yii::app()->db->createCommand()
                            ->select('sum(price_net) as pricenet')
                            ->from('buy_material_detail')
                            ->join('buy_material_input t', 'buy_id=t.id')
                            ->where("material_id=".$value['material_id']." AND buy_date BETWEEN '".$date_start."' AND '".$date_end."' AND t.site_id='".Yii::app()->user->getSite()."'")
                            ->queryAll();

                    $price = empty($mbuy[0]['pricenet']) ? "-" : number_format($mbuy[0]['pricenet'],2);  
                    $sumbuy += $mbuy[0]['pricenet'];    
                    $html .= '<td style="text-align:right;font-weight:bold;background-color:#c3c8c2">'.$price.'</td>';      
                }   
                $sumsell = 0;
                foreach ($materialSell as $key => $value) {
                    $msell = Yii::app()->db->createCommand()
                            ->select('sum(price_net) as pricenet')
                            ->from('sell_material_detail')
                            ->join('sell_material t', 'sell_id=t.id')
                            ->where("material_id=".$value['material_id']." AND sell_date BETWEEN '".$date_start."' AND '".$date_end."' AND  t.site_id='".Yii::app()->user->getSite()."'")
                            ->queryAll();

                    $price = empty($msell[0]['pricenet']) ? "-" : number_format($msell[0]['pricenet'],2);    
                     $sumsell += $msell[0]['pricenet']; 
                    $html .= '<td style="text-align:right;font-weight:bold;background-color:#c3c8c2">'.$price.'</td>';      
                }   
        $html .= '</tr>';
        $html .= '<tr>';
                $html .= '<td style="text-align:center;font-weight:bold;background-color:#ffffff"></td>';
                $html .= '<td style="text-align:center;font-weight:bold;background-color:#9ccffb">รวมซื้อ</td>';
                $ncol = count($materialBuy)-1;
                $html .= '<td colspan='.$ncol.' style="text-align:right;font-weight:bold;background-color:#9ccffb"><u>'.number_format($sumbuy,2).'</u></td>';
                $html .= '<td style="text-align:center;font-weight:bold;background-color:#9ccffb">รวมขาย</td>';
                $ncol = count($materialSell)-1;
                $html .= '<td colspan='.$ncol.' style="text-align:right;font-weight:bold;background-color:#9ccffb"><u>'.number_format($sumsell,2).'</u></td>';
                
        $html .= '</tr>';

        
    
    $html .= '</table>';
  
          
        $pdf->AddPage('L','A4');


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
        // $pdf->AddPage('L', $page_format, false, false);


        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);




$pdf->Output($_SERVER['DOCUMENT_ROOT'].'/poontong/report/temp/'.$filename,'F');
// Print text using writeHTMLCell()


// ---------------------------------------------------------

// Close and output PDF document

ob_end_clean() ;

exit;
?>