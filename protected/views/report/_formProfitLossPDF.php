<?php

// Include the main TCPDF library (search for installation path).
require_once($_SERVER['DOCUMENT_ROOT'].'/poontong/tcpdf/tcpdf.php');

class MYPDF extends TCPDF {

	private $site_name;
	private $site_phone;
	private $site_address;
    private $title_report;
	
	public function setHeaderInfo($site_name,$title_report) {
		$this->site_name = $site_name;
		$this->title_report = $title_report;
		        
	}

    //Page header
    public function Header() {
        
        // Set font
        $this->SetFont('thsarabun', '', 18);
        $this->writeHTMLCell(0, 50, 0, 2, '<div style="font-weight:bold;text-align:center;">'.$this->site_name.'</div>', 0, 1, false, true, 'C', false);
        $this->writeHTMLCell(0, 50, 0, 10, '<div style="font-weight:bold;text-align:center;">'.$this->title_report.'</div>', 0, 1, false, true, 'C', false);
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
$pdf->SetTitle('รายงานสรุปซื้อขายรายวัน');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setPrintHeader(true);
$site = Site::model()->FindByPk(Yii::app()->user->getSite());


$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
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

$date_start = ($year-543)."-01-01";
$date_end = ($year-543)."-12-31";

$title_report = "รายงานกำไร-ขาดทุน ปี ".$year;
$pdf->setHeaderInfo($site->name,$title_report);
$html = "";

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

	$operationCost = CostOperationGroup::model()->findAll("flag_delete=0 AND site_id=".Yii::app()->user->getSite());                                                

		$html .= '<br><br><table style="">';
        $html .= '<thead>'; 
        $html .= '<tr>';
        		
			$html .= '<th rowspan="2" width="10%" style="text-align:center;font-weight:bold;background-color: #c3c8c2;">เดือน ปี</th>';
			$num_material_buy = count($materialBuy);
			$num_material_sell = count($materialSell);
			$num_cost = count($operationCost);
			$colwidth = round(80/($num_material_buy+$num_material_sell+$num_cost));

			$colheader = $num_material_buy*$colwidth;
			$html .= '<th colspan="'.$num_material_buy.'" width="'.$colheader.'%" style="text-align:center;font-weight:bold;background-color: #def7d7;">รายการซื้อ (บาท)</th>';
			
			$colheader = $num_material_sell*$colwidth;
			$html .= '<th colspan="'.$num_material_sell.'" width="'.$colheader.'%" style="text-align:center;font-weight:bold;background-color: #ffeec1;">รายการขาย (บาท)</th>';
			$colheader = $num_cost*$colwidth;
			$html .= '<th colspan="'.$num_cost.'" width="'.$colheader.'%" style="text-align:center;font-weight:bold;background-color: #ffc6c6;">รายการค่าใช้จ่าย (บาท)</th>';
			$html .= '<th rowspan="2" width="10%" style="text-align:center;font-weight:bold;background-color: #c3c8c2;">กำไร-ขาดทุน</th>';
		$html .= '</tr>';

		$html .= '<tr>';
			$material_id = array();
			foreach ($materialBuy as $key => $value) {
				$html .= '<th  width="'.$colwidth.'%" style="text-align:center;font-weight:bold;background-color: #afd7a3;">'.Material::model()->FindByPk($value["material_id"])->name.'</th>';
				//$material_id[] = $value["material_id"];
			}

			foreach ($materialSell as $key => $value) {
				$html .= '<th  width="'.$colwidth.'%" style="text-align:center;font-weight:bold;background-color: #ffe295;">'.Material::model()->FindByPk($value["material_id"])->name.'</th>';
				//$material_id[] = $value["material_id"];
			}

			foreach ($operationCost as $key => $value) {
				$html .= '<th  width="'.$colwidth.'%" style="text-align:center;font-weight:bold;background-color: #ff9797;">'.$value->name.'</th>';
			}
	
		$html .= '</tr></thead><tbody>';

		for ($i=1; $i <= 12; $i++) {
			$bgcolor = $i%2==0 ?  "#eff4fd" : "#ffffff";

			$html .= '<tr>';
				$html .= '<td width="10%" style="text-align:center;background-color:'.$bgcolor.'">'.$month_th[$i].' '.$year.'</td>';
				
				$priceSell = 0;
				$priceBuy = 0;
				$priceCost = 0;
				foreach ($materialBuy as $key => $value) {
					$mbuy = Yii::app()->db->createCommand()
	                        ->select('sum(price_net) as pricenet')
	                        ->from('buy_material_detail')
	                        ->join('buy_material_input t', 'buy_id=t.id')
	                        ->where("material_id=".$value['material_id']." AND MONTH(buy_date) = '".$i."' AND  YEAR(buy_date)= '".($year-543)."' AND t.site_id='".Yii::app()->user->getSite()."'")
	                    	->queryAll();

	                $price = empty($mbuy[0]['pricenet']) ? "-" : number_format($mbuy[0]['pricenet'],2);  
	                $priceBuy += $mbuy[0]['pricenet'];  	
	                $html .= '<td width="'.$colwidth.'%"  style="text-align:right;background-color:'.$bgcolor.'">'.$price.'</td>';    	
				}	

				foreach ($materialSell as $key => $value) {
					$msell = Yii::app()->db->createCommand()
	                        ->select('sum(price_net) as pricenet')
	                        ->from('sell_material_detail')
	                        ->join('sell_material t', 'sell_id=t.id')
	                        ->where("material_id=".$value['material_id']." AND MONTH(sell_date) = '".$i."' AND  YEAR(sell_date)= '".($year-543)."' AND t.site_id='".Yii::app()->user->getSite()."'")
	                    	->queryAll();

	                $price = empty($msell[0]['pricenet']) ? "-" : number_format($msell[0]['pricenet'],2);    	
	               
	                $priceSell += $msell[0]['pricenet'];
	                $html .= '<td width="'.$colwidth.'%" style="text-align:right;background-color:'.$bgcolor.'">'.$price.'</td>';    	
				}	


				foreach ($operationCost as $key => $value) {
					$mcost = Yii::app()->db->createCommand()
	                        ->select('sum(cost) as cost')
	                        ->from('cost_operation')
	                        ->where("group_id='".$value->id."' AND MONTH(create_date) = '".$i."' AND  YEAR(create_date)= '".($year-543)."' AND site_id='".Yii::app()->user->getSite()."'")
	                    	->queryAll();
					

					 $price = empty($mcost[0]['cost']) ? "-" : number_format($mcost[0]['cost'],2);    	
	                 $priceCost += $mcost[0]['cost'];

	                $html .= '<td width="'.$colwidth.'%" style="text-align:right;background-color:'.$bgcolor.'">'.$price.'</td>';    	
				}

				$profitLoss = $priceSell - $priceBuy - $priceCost;
				 $html .= '<td width="10%" style="text-align:right;background-color:'.$bgcolor.'">'.number_format($profitLoss,2).'</td>';  
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

				$sumcost = 0;
				foreach ($operationCost as $key => $value) {
					$mcost = Yii::app()->db->createCommand()
	                        ->select('sum(cost) as pricenet')
	                        ->from('cost_operation')
	                        ->where("group_id=".$value->id." AND create_date BETWEEN '".$date_start."' AND '".$date_end."' AND  site_id='".Yii::app()->user->getSite()."'")
	                    	->queryAll();

	                $price = empty($mcost[0]['pricenet']) ? "-" : number_format($mcost[0]['pricenet'],2);    
	                $sumcost += $mcost[0]['pricenet'];	
	                $html .= '<td style="text-align:right;font-weight:bold;background-color:#c3c8c2">'.$price.'</td>';    	
				}	
				$profitLoss = $sumsell - $sumcost - $sumbuy;
				$html .= '<td rowspan=2 style="text-align:right;font-weight:bold;background-color:#c3c8c2">'.number_format($profitLoss,2).'</td>'; 
		$html .= '</tr>';
		$html .= '<tr>';
				$html .= '<td style="text-align:center;font-weight:bold;background-color:#e4e4e4"></td>';
				$html .= '<td style="text-align:center;font-weight:bold;background-color:#9ccffb">รวมซื้อ</td>';
				$ncol = count($materialBuy)-1;
				$html .= '<td colspan="'.$ncol.'" style="text-align:right;font-weight:bold;background-color:#9ccffb"><u>'.number_format($sumbuy,2).'</u></td>';
				$html .= '<td style="text-align:center;font-weight:bold;background-color:#9ccffb">รวมขาย</td>';
				$ncol = count($materialSell)-1;
				$html .= '<td colspan="'.$ncol.'" style="text-align:right;font-weight:bold;background-color:#9ccffb"><u>'.number_format($sumsell,2).'</u></td>';
				$html .= '<td style="text-align:center;font-weight:bold;background-color:#9ccffb">รวมค่าใช้จ่าย</td>';
				$ncol = count($operationCost)-1;
				$html .= '<td colspan="'.$ncol.'" style="text-align:right;font-weight:bold;background-color:#9ccffb"><u>'.number_format($sumcost,2).'</u></td>';
				
		$html .= '</tr>';

		
	
	$html .= '</tbody></table>';

			
   
        $pdf->AddPage('L','A4');


    

        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);




$pdf->Output($_SERVER['DOCUMENT_ROOT'].'/poontong/report/temp/'.$filename,'F');
// Print text using writeHTMLCell()


// ---------------------------------------------------------

// Close and output PDF document

ob_end_clean() ;

exit;
?>