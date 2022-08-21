
<?php


$month_th = array("1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม","4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน","7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน","10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");

$monthBetween = $month_th[$month]." ".$year;


$number = cal_days_in_month(CAL_GREGORIAN, $month, $year-543);
$monthEnd2 = $month<10 ? "0".$month : $monthEnd;

$number = $number<10 ? "0".$number : $number;
$dayEnd = $year."-".$monthEnd2."-".$number;
$monthCondition = " <= '".$dayEnd."'";


	
	echo "<center><div class='header'><b>รายงานซื้อวัตถุดิบรายวัน ประจำเดือน ".$monthBetween."</b></div></center>";
	
	if(empty($material_id))
		$raw_material = Material::model()->findAll('site_id=:id', array(':id' => Yii::app()->user->getSite()));
	else
		$raw_material = Material::model()->findByPk($material_id);
	echo '<div style="overflow-x:auto;width: 100%;">'; 
	echo '<table class="span12 table table-bordered" style="width: 150%;max-width: 150%;margin-left:0px;">';

		echo '<tr>';
		foreach ($raw_material as $key => $value) {
			
			echo '<td rowspan=2 width="5%" style="text-align:center;">วันที่</td>';
			echo '<td rowspan=2 width="7%" style="text-align:center;">ร้าน</td>';
			echo '<td colspan=5 width="25%" style="text-align:center;">'.$value->name.'</td>';
		}	
		echo '</tr>';
		echo '<tr>';
		foreach ($raw_material as $key => $value) {
			
			echo '<td  width="5%" style="text-align:center;">นน.เข้า</td>';
			echo '<td  width="5%" style="text-align:center;">นน.ออก</td>';
			echo '<td  width="5%" style="text-align:center;">ของเสีย</td>';
			echo '<td  width="5%" style="text-align:center;">นน.สุทธิ</td>';
			echo '<td  width="5%" style="text-align:center;">นน.ต่อวัน</td>';
		}	
		echo '</tr>';
	echo '</table>';
	echo '</div>';

			
?>