
<?php


$month_th = array("1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม","4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน","7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน","10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");

// $month = $monthBegin<10 ? "0".$monthBegin : $monthBegin ;
// $date_start = ($yearBegin-543)."-".$month."-01";
// $month = $monthEnd<10 ? "0".$monthEnd : $monthEnd ;
// $number = cal_days_in_month(CAL_GREGORIAN, $monthEnd, $yearEnd-543);
// $day = $number<10 ? "0".$number : $number ;
// $date_end = ($yearEnd-543)."-".$month."-".$day;

$date_start = ($year-543)."-01-01";
$date_end = ($year-543)."-12-31";

	//echo $month_th[$monthBegin]." ".$yearBegin." - ".$month_th[$monthEnd]." ".$yearEnd;
	//echo "<center><div class='header'><b>รายงานสรุปซื้อขาย ระหว่างเดือน ".$month_th[$monthBegin]." ".$yearBegin." - ".$month_th[$monthEnd]." ".$yearEnd."</b></div></center>";

	echo "<center><div class='header'><h4>รายงานสรุปซื้อขาย(บด) ปี ".$year."</h4></div></center>";
	
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


	echo '<div style="overflow-x:auto;width: 100%;">'; 
	
		echo '<table class="span12 table table-bordered" style="width: 100%;max-width: 100%;margin-left:0px;">';

		echo '<tr>';
		
			echo '<td rowspan=2 width="10%" style="text-align:center;font-weight:bold;background-color: #c3c8c2;">เดือน ปี</td>';
			$num_material_buy = count($materialBuy)+1;
			echo '<td colspan='.$num_material_buy.' width="10%" style="text-align:center;font-weight:bold;background-color: #def7d7;">รายการซื้อ (กก.)</td>';
			
			$num_material_sell = count($materialSell)+1;
			echo '<td colspan='.$num_material_sell.' width="10%" style="text-align:center;font-weight:bold;background-color: #ffeec1;">รายการบด(กก.)</td>';
			echo '<td rowspan=2 width="10%" style="text-align:center;font-weight:bold;background-color: #c3c8c2;">บด-ซื้อ (กก.)</td>';
		
		echo '</tr>';

		echo '<tr>';
			$material_id = array();
			foreach ($materialBuy as $key => $value) {
				echo '<td  width="10%" style="text-align:center;font-weight:bold;background-color: #afd7a3;">'.Material::model()->FindByPk($value["material_id"])->name.'</td>';
				//$material_id[] = $value["material_id"];
			}
			echo '<td  width="10%" style="text-align:center;font-weight:bold;background-color: #def7d7;">รวมน้ำหนัก (กก.)</td>';

			foreach ($materialSell as $key => $value) {
				echo '<td  width="10%" style="text-align:center;font-weight:bold;background-color: #ffe295;">'.Material::model()->FindByPk($value["material_id"])->name.'</td>';
				//$material_id[] = $value["material_id"];
			}
			echo '<td  width="10%" style="text-align:center;font-weight:bold;background-color: #ffeec1;">รวมน้ำหนัก (กก.)</td>';

	
		echo '</tr>';

		for ($i=1; $i <= 12; $i++) {
			$bgcolor = $i%2==0 ?  "#eff4fd" : "#ffffff";

			echo '<tr>';
				echo '<td style="text-align:center;background-color:'.$bgcolor.'">'.$month_th[$i].' '.$year.'</td>';
				$sumbuy = 0;
				foreach ($materialBuy as $key => $value) {
					$mbuy = Yii::app()->db->createCommand()
	                        ->select('sum(amount) as amount')
	                        ->from('buy_material_detail')
	                        ->join('buy_material_input t', 'buy_id=t.id')
	                        ->where("material_id=".$value['material_id']." AND MONTH(buy_date) = '".$i."' AND  YEAR(buy_date)= '".($year-543)."' AND t.site_id='".Yii::app()->user->getSite()."'")
	                    	->queryAll();

	                $amount = empty($mbuy[0]['amount']) ? "-" : number_format($mbuy[0]['amount'],2);    
	                $sumbuy += $mbuy[0]['amount'];	
	                echo '<td style="text-align:right;background-color:'.$bgcolor.'">'.$amount.'</td>';    	
				}	
				echo '<td style="text-align:right;background-color:'.$bgcolor.'">'.number_format($sumbuy,2).'</td>';
				$sumsell = 0;
				foreach ($materialSell as $key => $value) {
					$msell = Yii::app()->db->createCommand()
	                        ->select('sum(amount) as amount')
	                        ->from('sell_material_detail')
	                        ->join('sell_material t', 'sell_id=t.id')
	                        ->where("material_id=".$value['material_id']." AND MONTH(sell_date) = '".$i."' AND  YEAR(sell_date)= '".($year-543)."' AND t.site_id='".Yii::app()->user->getSite()."'")
	                    	->queryAll();

	                $amount = empty($msell[0]['amount']) ? "-" : number_format($msell[0]['amount'],2);
	                $sumsell += $msell[0]['amount'];	    	
	                echo '<td style="text-align:right;background-color:'.$bgcolor.'">'.$amount.'</td>';    	
				}	
				echo '<td style="text-align:right;background-color:'.$bgcolor.'">'.number_format($sumsell,2).'</td>';
				echo '<td style="text-align:right;background-color:'.$bgcolor.'">'.number_format($sumsell-$sumbuy,2).'</td>';
			echo '</tr>';
		}

		echo '<tr>';
				echo '<td style="text-align:center;font-weight:bold;background-color:#c3c8c2">รวม</td>';
				$sumbuy = 0;
				foreach ($materialBuy as $key => $value) {
					$mbuy = Yii::app()->db->createCommand()
	                        ->select('sum(amount) as amount')
	                        ->from('buy_material_detail')
	                        ->join('buy_material_input t', 'buy_id=t.id')
	                        ->where("material_id=".$value['material_id']." AND buy_date BETWEEN '".$date_start."' AND '".$date_end."' AND t.site_id='".Yii::app()->user->getSite()."'")
	                    	->queryAll();

	                $amount = empty($mbuy[0]['amount']) ? "-" : number_format($mbuy[0]['amount'],2);  
	                $sumbuy += $mbuy[0]['amount'];  	
	                echo '<td style="text-align:right;font-weight:bold;background-color:#c3c8c2">'.$amount.'</td>';    	
				}	
				echo '<td style="text-align:right;font-weight:bold;background-color:#c3c8c2">'.number_format($sumbuy,2).'</td>';  
				$sumsell = 0;
				foreach ($materialSell as $key => $value) {
					$msell = Yii::app()->db->createCommand()
	                        ->select('sum(amount) as amount')
	                        ->from('sell_material_detail')
	                        ->join('sell_material t', 'sell_id=t.id')
	                        ->where("material_id=".$value['material_id']." AND sell_date BETWEEN '".$date_start."' AND '".$date_end."' AND  t.site_id='".Yii::app()->user->getSite()."'")
	                    	->queryAll();

	                $amount = empty($msell[0]['amount']) ? "-" : number_format($msell[0]['amount'],2);    
	                 $sumsell += $msell[0]['amount'];	
	                echo '<td style="text-align:right;font-weight:bold;background-color:#c3c8c2">'.$amount.'</td>';    	
				}	
				echo '<td style="text-align:right;font-weight:bold;background-color:#c3c8c2">'.number_format($sumsell,2).'</td>';
				echo '<td rowspan=2 style="text-align:right;font-weight:bold;background-color:#c3c8c2">'.number_format($sumsell-$sumbuy,2).'</td>';  
		echo '</tr>';
		echo '<tr>';
				echo '<td style="text-align:center;font-weight:bold;background-color:#e4e4e4"></td>';
				$ncol = count($materialBuy);
				echo '<td colspan='.$ncol.' style="text-align:center;font-weight:bold;background-color:#9ccffb">รวมซื้อ</td>';
				
				echo '<td  style="text-align:right;font-weight:bold;background-color:#9ccffb"><u>'.number_format($sumbuy,2).'</u></td>';
				$ncol = count($materialSell);
				echo '<td  colspan='.$ncol.' style="text-align:center;font-weight:bold;background-color:#9ccffb">รวมขาย</td>';
				
				echo '<td style="text-align:right;font-weight:bold;background-color:#9ccffb"><u>'.number_format($sumsell,2).'</u></td>';
				
		echo '</tr>';

		
	
	echo '</table>';
	echo '</div>';

			
?>