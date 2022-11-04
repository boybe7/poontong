
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

	echo "<center><div class='header'><h4>รายงานกำไร-ขาดทุน ปี ".$year."</h4></div></center>";
	
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


	echo '<div style="overflow-x:auto;width: 100%;">'; 
	
		echo '<table class="span12 table table-bordered" style="width: 100%;max-width: 100%;margin-left:0px;">';

		echo '<tr>';
		
			echo '<td rowspan=2 width="10%" style="text-align:center;font-weight:bold;background-color: #c3c8c2;">เดือน ปี</td>';
			$num_material_buy = count($materialBuy);
			echo '<td colspan='.$num_material_buy.' width="10%" style="text-align:center;font-weight:bold;background-color: #def7d7;">รายการซื้อ (บาท)</td>';
			$num_material_sell = count($materialSell);
			echo '<td colspan='.$num_material_sell.' width="10%" style="text-align:center;font-weight:bold;background-color: #ffeec1;">รายการขาย (บาท)</td>';
			$num_cost = count($operationCost);
			echo '<td colspan='.$num_cost.' width="10%" style="text-align:center;font-weight:bold;background-color: #ffc6c6;">รายการค่าใช้จ่าย (บาท)</td>';
			echo '<td rowspan=2 width="10%" style="text-align:center;font-weight:bold;background-color: #c3c8c2;">กำไร-ขาดทุน</td>';
		echo '</tr>';

		echo '<tr>';
			$material_id = array();
			foreach ($materialBuy as $key => $value) {
				echo '<td  width="10%" style="text-align:center;font-weight:bold;background-color: #afd7a3;">'.Material::model()->FindByPk($value["material_id"])->name.'</td>';
				//$material_id[] = $value["material_id"];
			}

			foreach ($materialSell as $key => $value) {
				echo '<td  width="10%" style="text-align:center;font-weight:bold;background-color: #ffe295;">'.Material::model()->FindByPk($value["material_id"])->name.'</td>';
				//$material_id[] = $value["material_id"];
			}

			foreach ($operationCost as $key => $value) {
				echo '<td  width="10%" style="text-align:center;font-weight:bold;background-color: #ff9797;">'.$value->name.'</td>';
			}
	
		echo '</tr>';

		for ($i=1; $i <= 12; $i++) {
			$bgcolor = $i%2==0 ?  "#eff4fd" : "#ffffff";

			echo '<tr>';
				echo '<td style="text-align:center;background-color:'.$bgcolor.'">'.$month_th[$i].' '.$year.'</td>';
				
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
	                echo '<td style="text-align:right;background-color:'.$bgcolor.'">'.$price.'</td>';    	
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
	                echo '<td style="text-align:right;background-color:'.$bgcolor.'">'.$price.'</td>';    	
				}	


				foreach ($operationCost as $key => $value) {
					$mcost = Yii::app()->db->createCommand()
	                        ->select('sum(cost) as cost')
	                        ->from('cost_operation')
	                        ->where("group_id='".$value->id."' AND MONTH(create_date) = '".$i."' AND  YEAR(create_date)= '".($year-543)."' AND site_id='".Yii::app()->user->getSite()."'")
	                    	->queryAll();
					

					 $price = empty($mcost[0]['cost']) ? "-" : number_format($mcost[0]['cost'],2);    	
	                 $priceCost += $mcost[0]['cost'];

	                echo '<td style="text-align:right;background-color:'.$bgcolor.'">'.$price.'</td>';    	
				}

				$profitLoss = $priceSell - $priceBuy - $priceCost;
				 echo '<td style="text-align:right;background-color:'.$bgcolor.'">'.number_format($profitLoss,2).'</td>';  
			echo '</tr>';
		}

		echo '<tr>';
				echo '<td style="text-align:center;font-weight:bold;background-color:#c3c8c2">รวม</td>';
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
	                echo '<td style="text-align:right;font-weight:bold;background-color:#c3c8c2">'.$price.'</td>';    	
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
	                echo '<td style="text-align:right;font-weight:bold;background-color:#c3c8c2">'.$price.'</td>';    	
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
	                echo '<td style="text-align:right;font-weight:bold;background-color:#c3c8c2">'.$price.'</td>';    	
				}	
				$profitLoss = $sumsell - $sumcost - $sumbuy;
				echo '<td rowspan=2 style="text-align:right;font-weight:bold;background-color:#c3c8c2">'.number_format($profitLoss,2).'</td>'; 
		echo '</tr>';
		echo '<tr>';
				echo '<td style="text-align:center;font-weight:bold;background-color:#e4e4e4"></td>';
				echo '<td style="text-align:center;font-weight:bold;background-color:#9ccffb">รวมซื้อ</td>';
				$ncol = count($materialBuy)-1;
				echo '<td colspan='.$ncol.' style="text-align:right;font-weight:bold;background-color:#9ccffb"><u>'.number_format($sumbuy,2).'</u></td>';
				echo '<td style="text-align:center;font-weight:bold;background-color:#9ccffb">รวมขาย</td>';
				$ncol = count($materialSell)-1;
				echo '<td colspan='.$ncol.' style="text-align:right;font-weight:bold;background-color:#9ccffb"><u>'.number_format($sumsell,2).'</u></td>';
				echo '<td style="text-align:center;font-weight:bold;background-color:#9ccffb">รวมค่าใช้จ่าย</td>';
				$ncol = count($operationCost)-1;
				echo '<td colspan='.$ncol.' style="text-align:right;font-weight:bold;background-color:#9ccffb"><u>'.number_format($sumcost,2).'</u></td>';
				
		echo '</tr>';

		
	
	echo '</table>';
	echo '</div>';

			
?>