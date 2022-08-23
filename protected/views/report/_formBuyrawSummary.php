
<?php


$month_th = array("1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม","4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน","7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน","10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");

$monthBetween = $month_th[$month]." ".$year;


$number = cal_days_in_month(CAL_GREGORIAN, $month, $year-543);
$monthEnd2 = $month<10 ? "0".$month : $monthEnd;

$number = $number<10 ? "0".$number : $number;
$dayEnd = $year."-".$monthEnd2."-".$number;
$monthCondition = " <= '".$dayEnd."'";


	
	echo "<center><div class='header'><b>รายงานซื้อวัตถุดิบรับเข้า ประจำเดือน ".$monthBetween."</b></div></center>";
	
	$raw_material = Material::model()->findAll('site_id=:id', array(':id' => Yii::app()->user->getSite()));
	
	
	echo '<div style="overflow-x:auto;width: 100%;">'; 
	
		echo '<table class="span12 table table-bordered" style="width: 100%;max-width: 100%;margin-left:0px;">';

		echo '<tr>';
		
			echo '<td rowspan=2 width="10%" style="text-align:center;background-color: #afd7a3;">วันที่</td>';
			$num_material = count($raw_material);
			$col_width = (100-10-10-10)/$num_material;
			echo '<td colspan="'.$num_material.'" width="70%" style="text-align:center;background-color: #afd7a3;">จำนวน กก.</td>';
			echo '<td rowspan=2 width="10%" style="text-align:center;background-color: #afd7a3;">น้ำหนักรวม</td>';
			echo '<td rowspan=2 width="10%" style="text-align:center;background-color: #afd7a3;">หมายเหตุ</td>';
		echo '</tr>';
		echo '<tr>';
			foreach ($raw_material as $key => $value) {
				echo '<td  width="'.$col_width.'%" style="text-align:center;background-color: #afd7a3;">'.$value->name.'</td>';
			}

	
		echo '</tr>';

		for ($i=1; $i <= cal_days_in_month(CAL_GREGORIAN,$month,$year); $i++) { 
			echo '<tr>';
			$date_str = $i.'/'.$month.'/'.$year;	
			echo '<td style="text-align:center;">'.$date_str.'</td>';
			$sumday=0;
			foreach ($raw_material as $key => $value) {
				$material_id = $value['id'];
				$details = Yii::app()->db->createCommand()
	                        ->select('buy_date,SUM(amount) as sum_amount')
	                        ->from('buy_material_detail')
	                        ->join('buy_material_input t', 'buy_id=t.id')
	                        ->where("material_id='$material_id' AND DAY(buy_date)=".$i." AND YEAR(buy_date)=".($year-543)." AND MONTH(buy_date)=".$month)
	                        ->group("buy_date")
	                        ->queryAll();
	    	   
	           		$amount = empty($details) ? 0 : $details[0]['sum_amount'];
	           		
	           		echo '<td style="text-align:right;">'.number_format($amount,2).'</td>';
	           	
	       			$sumday += $amount;
	                        
	        }   
	        	echo '<td style="text-align:right;">'.number_format($sumday,2).'</td>';
	           	echo '<td></td>';
	           
	        echo '</tr>';  
               
	    }    
	echo '</table>';
	echo '</div>';

			
?>