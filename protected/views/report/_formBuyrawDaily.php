
<?php


$str_date = explode("/", $date_start);
$date_start = ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];   

$str_date = explode("/", $date_end);
$date_end = ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];

$date1=date_create($date_start);
$date2=date_create($date_end);
$interval = $date1->diff($date2);
$nday = $interval->days;


	
	echo "<center><div class='header'><b>รายงานซื้อวัตถุดิบรับเข้า ระหว่างวันที่ ".$this->renderDate($date_start)." ถึง ".$this->renderDate($date_end)."</b></div></center>";
	
	$materialBuy = Yii::app()->db->createCommand()
	                        ->select('material_id')
	                        ->from('buy_material_detail')
	                        ->join('buy_material_input t', 'buy_id=t.id')
	                        ->where(" buy_date BETWEEN '".$date_start."' AND '".$date_end."' AND t.site_id='".Yii::app()->user->getSite()."'")
	                        ->group("material_id")
	                        ->queryAll();
	
	echo '<div style="overflow-x:auto;width: 100%;">'; 
	
		echo '<table class="span12 table table-bordered" style="width: 100%;max-width: 100%;margin-left:0px;">';

		echo '<tr>';
		
			echo '<td rowspan=2 width="10%" style="text-align:center;background-color: #afd7a3;">วันที่</td>';
			$num_material = count($materialBuy);
			$col_width = (100-10-10-10)/$num_material;
			echo '<td colspan="'.$num_material.'" width="70%" style="text-align:center;background-color: #afd7a3;">จำนวน กก.</td>';
			echo '<td rowspan=2 width="10%" style="text-align:center;background-color: #afd7a3;">น้ำหนักรวม</td>';
			echo '<td rowspan=2 width="10%" style="text-align:center;background-color: #afd7a3;">หมายเหตุ</td>';
		echo '</tr>';
		echo '<tr>';
			foreach ($materialBuy as $key => $value) {
				echo '<td  width="'.$col_width.'%" style="text-align:center;background-color: #afd7a3;">'.$value['name'].'</td>';
			}

	
		echo '</tr>';

		for($i=0;$i<=$nday;$i++)
		{
			$bgcolor = $i%2==0 ?  "#eff4fd" : "#ffffff";
			echo '<tr>';
			$date_str = $date1->format('Y-m-d');

			echo '<td style="text-align:center;background-color:'.$bgcolor.'">'.$this->renderDate($date_str).'</td>';
			$sumday=0;
			foreach ($materialBuy as $key => $value) {
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