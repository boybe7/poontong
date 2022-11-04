
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

	echo "<center><div class='header'><h4>รายงานค่าใช้จ่าย ปี ".$year."</h4></div></center>";
	
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
		
			echo '<td  width="15%" style="text-align:center;font-weight:bold;background-color: #c3c8c2;">เดือน ปี</td>';	
			echo '<td  width="20%" style="text-align:center;font-weight:bold;background-color: #def7d7;">ค่าใช้จ่าย (บาท)</td>';
			echo '<td  width="20%" style="text-align:center;font-weight:bold;background-color: #def7d7;">บด (กก.)</td>';
			echo '<td  width="20%" style="text-align:center;font-weight:bold;background-color: #def7d7;">ค่าใช้จ่าย/กก.</td>';
			echo '<td  width="20%" style="text-align:center;font-weight:bold;background-color: #def7d7;">ค่าแรง/กก.</td>';
			
		echo '</tr>';

		

		for ($i=1; $i <= 12; $i++) {
			$bgcolor = $i%2==0 ?  "#eff4fd" : "#ffffff";

			echo '<tr>';
				echo '<td style="text-align:center;background-color:'.$bgcolor.'">'.$month_th[$i].' '.$year.'</td>';
				   $sumbuy = 0;
			
					$mbuy = Yii::app()->db->createCommand()
	                        ->select('sum(cost) as amount')
	                        ->from('cost_operation')
	                        ->join('cost_operation_group t', 'group_id=t.id')
	                        ->where(" MONTH(create_date) = '".$i."' AND  YEAR(create_date)= '".($year-543)."' AND t.site_id='".Yii::app()->user->getSite()."'")
	                    	->queryAll();

	                $amount = empty($mbuy[0]['amount']) ? "-" : number_format($mbuy[0]['amount'],2);    

	                $wage = Yii::app()->db->createCommand()
	                        ->select('sum(cost) as amount')
	                        ->from('cost_operation')
	                        ->join('cost_operation_group t', 'group_id=t.id')
	                        ->where("t.name LIKE '%ค่าแรง%' AND MONTH(create_date) = '".$i."' AND  YEAR(create_date)= '".($year-543)."' AND t.site_id='".Yii::app()->user->getSite()."'")
	                    	->queryAll();

	                $amount = empty($wage[0]['amount']) ? "-" : number_format($wage[0]['amount'],2);    
	         
	            echo '<td style="text-align:right;background-color:'.$bgcolor.'">'.$amount.'</td>';    	


	            $production = Yii::app()->db->createCommand()
	                        ->select('sum(amount) as amount')
	                        ->from('production')
	                        ->where(" MONTH(production_date) = '".$i."' AND  YEAR(production_date)= '".($year-543)."' AND site_id='".Yii::app()->user->getSite()."'")
	                    	->queryAll();
				$amount = empty($production[0]['amount']) ? "-" : number_format($production[0]['amount'],2);    
				echo '<td style="text-align:right;background-color:'.$bgcolor.'">'.$amount.'</td>';
				$cost_per_production = empty($production[0]['amount']) ? "-" : number_format($mbuy[0]['amount']/$production[0]['amount'],2);
				echo '<td style="text-align:right;background-color:'.$bgcolor.'">'.$cost_per_production.'</td>';


				$wage_per_production = empty($production[0]['amount']) ? "-" : number_format($wage[0]['amount']/$production[0]['amount'],2);
				echo '<td style="text-align:right;background-color:'.$bgcolor.'">'.$wage_per_production.'</td>';

			echo '</tr>';
		}


		// echo '<tr>';
		// 		echo '<td style="text-align:center;font-weight:bold;background-color:#e4e4e4"></td>';
		// 		$ncol = count($materialBuy);
		// 		echo '<td colspan='.$ncol.' style="text-align:center;font-weight:bold;background-color:#9ccffb">รวมซื้อ</td>';
				
		// 		echo '<td  style="text-align:right;font-weight:bold;background-color:#9ccffb"><u>'.number_format($sumbuy,2).'</u></td>';
		// 		$ncol = count($materialSell);
		// 		echo '<td  colspan='.$ncol.' style="text-align:center;font-weight:bold;background-color:#9ccffb">รวมขาย</td>';
				
		// 		echo '<td style="text-align:right;font-weight:bold;background-color:#9ccffb"><u>'.number_format($sumsell,2).'</u></td>';
				
		// echo '</tr>';

		
	
	echo '</table>';
	echo '</div>';

			
?>