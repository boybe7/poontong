
<?php


$month_th = array("1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม","4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน","7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน","10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");

$monthBetween = $month_th[$month]." ".$year;


$number = cal_days_in_month(CAL_GREGORIAN, $month, $year-543);
$monthEnd2 = $month<10 ? "0".$month : $monthEnd;

$number = $number<10 ? "0".$number : $number;
$dayEnd = $year."-".$monthEnd2."-".$number;
$monthCondition = " <= '".$dayEnd."'";


	
	echo "<center><div class='header'><b>รายงานซื้อวัตถุดิบรายวัน ประจำเดือน ".$monthBetween."</b></div></center>";
	
	// if(empty($material_id))
	// 	$raw_material = Material::model()->findAll('site_id=:id', array(':id' => Yii::app()->user->getSite()));
	// else
	//	$raw_material = Material::model()->findAll('id=:id', array(':id' => $material_id));
	$raw_material = Material::model()->FindByPk($material_id);
	
	echo '<div style="overflow-x:auto;width: 100%;">'; 
	if(count($raw_material)>2)
		echo '<table class="span12 table table-bordered" style="width: 150%;max-width: 150%;margin-left:0px;">';
	else
		echo '<table class="span12 table table-bordered" style="width: 100%;max-width: 100%;margin-left:0px;">';

		echo '<tr>';
		
			echo '<td rowspan=2 width="5%" style="text-align:center;background-color: #afd7a3;">วันที่</td>';
			echo '<td rowspan=2 width="9%" style="text-align:center;background-color: #afd7a3;">ร้าน</td>';
			echo '<td colspan=5 width="24%" style="text-align:center;background-color: #afd7a3;">'.$raw_material->name.'</td>';
		
		echo '</tr>';
		echo '<tr>';			
			echo '<td  width="5%" style="text-align:center;background-color: #afd7a3;">นน.เข้า</td>';
			echo '<td  width="5%" style="text-align:center;background-color: #afd7a3;">นน.ออก</td>';
			echo '<td  width="4%" style="text-align:center;background-color: #afd7a3;">ของเสีย</td>';
			echo '<td  width="5%" style="text-align:center;background-color: #afd7a3;">นน.สุทธิ</td>';
			echo '<td  width="5%" style="text-align:center;background-color: #afd7a3;">นน.ต่อวัน</td>';
	
		echo '</tr>';

		$details = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('buy_material_detail')
                        ->join('buy_material_input t', 'buy_id=t.id')
                        ->where("material_id='$material_id' AND YEAR(buy_date)=".($year-543)." AND MONTH(buy_date)=".$month)
                        ->order(array('buy_date asc'))
                        ->queryAll();

        $date_select = "";               
        foreach ($details as $key => $value) {

        	if($date_select=="")
        	{	$date_select = $value['buy_date']; 
        		$date_str = $this->renderDate($value['buy_date']);
        	}
        	else 
        	{	
        		if($date_select!=$value['buy_date'])
        		{	
	        		$temp = Yii::app()->db->createCommand()
	                        ->select('SUM(amount) as sum')
	                        ->from('buy_material_detail')
	                        ->join('buy_material_input t', 'buy_id=t.id')
	                        ->where("material_id='$material_id' AND buy_date='".$date_select."'")
	                        ->queryAll();
	        		$sum_amount = $temp[0]['sum'];
	        		echo '<tr><td colspan=6 style="background-color: #fdffcb;"></td>';
	        			echo '<td style="text-align:right;background-color: #fdffcb;">'.number_format($sum_amount,2).'</td>';
	        		echo '</tr>';     
	        		$date_str = $this->renderDate($value['buy_date']);
	        		$date_select = $value['buy_date']; 
        		}
        		else
        		{
        			$date_str = "";
        		}
        	}
        	


           echo '<tr>';
           		echo '<td style="text-align:center;">'.$date_str.'</td>';
           		echo '<td>'.Customer::model()->findByPk($value['customer_id'])->name.'</td>';
           		echo '<td style="text-align:right;">'.number_format($value['weight_in'],2).'</td>';
           		echo '<td style="text-align:right;">'.number_format($value['weight_out'],2).'</td>';
           		echo '<td style="text-align:right;">'.number_format($value['weight_loss'],2).'</td>';
           		echo '<td style="text-align:right;">'.number_format($value['amount'],2).'</td>';
           		echo '<td></td>';
           echo '</tr>';  


                        
        }   

        			$temp = Yii::app()->db->createCommand()
	                        ->select('SUM(amount) as sum')
	                        ->from('buy_material_detail')
	                        ->join('buy_material_input t', 'buy_id=t.id')
	                        ->where("material_id='$material_id' AND buy_date='".$date_select."'")
	                        ->queryAll();
	        		$sum_amount = $temp[0]['sum'];
	        		echo '<tr><td colspan=6 style="background-color: #fdffcb;"></td>';
	        			echo '<td style="text-align:right;background-color: #fdffcb;">'.number_format($sum_amount,2).'</td>';
	        		echo '</tr>';               

	echo '</table>';
	echo '</div>';

			
?>