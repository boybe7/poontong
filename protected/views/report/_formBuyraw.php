
<?php


$month_th = array("1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม","4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน","7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน","10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");

// $monthBetween = $month_th[$month]." ".$year;


// $number = cal_days_in_month(CAL_GREGORIAN, $month, $year-543);
// $monthEnd2 = $month<10 ? "0".$month : $monthEnd;

// $number = $number<10 ? "0".$number : $number;
// $dayEnd = $year."-".$monthEnd2."-".$number;
// $monthCondition = " <= '".$dayEnd."'";


	
	echo "<center><div class='header'><b>รายงานซื้อวัตถุดิบรายวัน ระหว่างวันที่ ".$date_start." ถึง ".$date_end."</b></div></center>";

	echo '<div style="width: 100%;">'; 
		echo '<table class="span12 table table-bordered" style="width: 100%;max-width: 100%;margin-left:0px;">';

		echo '<tr>';
		
			echo '<td  width="15%" style="text-align:center;background-color: #afd7a3;">วันที่</td>';
			echo '<td  width="20%" style="text-align:center;background-color: #afd7a3;">ร้าน</td>';
			echo '<td  width="40%" style="text-align:center;background-color: #afd7a3;">รายการ</td>';
		
			echo '<td  width="25%" style="text-align:center;background-color: #afd7a3;">จำนวนเงินรวม(บาท)</td>';
	
		echo '</tr>';

	$str_date = explode("/", $date_start);
    if(count($str_date)>1)
        $date_start= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];

    $str_date = explode("/", $date_end);
    if(count($str_date)>1)
        $date_end= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];    	

	//$date_start = "2022-08-01";
	//$date_end = "2022-08-31";	

	$condition = empty($customer_id) ? "" : " AND customer_id=".$customer_id;

	$buymaterial = Yii::app()->db->createCommand()
                        ->select('*,buy_material_input.id as buy_id')
                        ->from('buy_material_input')
                        ->join('customer t', 'customer_id=t.id')
                        ->where("buy_date BETWEEN '".$date_start."' AND '".$date_end."' AND buy_material_input.site_id='".Yii::app()->user->getSite()."'".$condition)
                        ->order(array('buy_date asc'))
                        ->queryAll();

	foreach ($buymaterial as $key => $value) {
		echo '<tr>';
		
			echo '<td  width="15%" style="text-align:center;background-color: #ffffff;">'.$this->renderDate($value["buy_date"]).'</td>';
			echo '<td  width="20%" style="text-align:left;background-color: #ffffff;">'.$value["name"].'</td>';
			echo '<td  width="40%" style="text-align:left;background-color: #ffffff;">'.BuyMaterialInput::model()->getItem($value['buy_id']).'</td>';
		
			echo '<td  width="25%" style="text-align:right;background-color: #ffffff;">'.number_format(BuyMaterialInput::model()->getTotal($value['buy_id']),2).'</td>';
	
		echo '</tr>';	

	}	

		// $details = Yii::app()->db->createCommand()
  //                       ->select('*')
  //                       ->from('buy_material_detail')
  //                       ->join('buy_material_input t', 'buy_id=t.id')
  //                       ->where("material_id='$material_id' AND YEAR(buy_date)=".($year-543)." AND MONTH(buy_date)=".$month)
  //                       ->order(array('buy_date asc'))
  //                       ->queryAll();

  //       $date_select = "";               
  //       foreach ($details as $key => $value) {

  //       	if($date_select=="")
  //       	{	$date_select = $value['buy_date']; 
  //       		$date_str = $this->renderDate($value['buy_date']);
  //       	}
  //       	else 
  //       	{	
  //       		if($date_select!=$value['buy_date'])
  //       		{	
	 //        		$temp = Yii::app()->db->createCommand()
	 //                        ->select('SUM(amount) as sum')
	 //                        ->from('buy_material_detail')
	 //                        ->join('buy_material_input t', 'buy_id=t.id')
	 //                        ->where("material_id='$material_id' AND buy_date='".$date_select."'")
	 //                        ->queryAll();
	 //        		$sum_amount = $temp[0]['sum'];
	 //        		echo '<tr><td colspan=6 style="background-color: #fdffcb;"></td>';
	 //        			echo '<td style="text-align:right;background-color: #fdffcb;">'.number_format($sum_amount,2).'</td>';
	 //        		echo '</tr>';     
	 //        		$date_str = $this->renderDate($value['buy_date']);
	 //        		$date_select = $value['buy_date']; 
  //       		}
  //       		else
  //       		{
  //       			$date_str = "";
  //       		}
  //       	}
        	


  //          echo '<tr>';
  //          		echo '<td style="text-align:center;">'.$date_str.'</td>';
  //          		echo '<td>'.Customer::model()->findByPk($value['customer_id'])->name.'</td>';
  //          		echo '<td style="text-align:right;">'.number_format($value['weight_in'],2).'</td>';
  //          		echo '<td style="text-align:right;">'.number_format($value['weight_out'],2).'</td>';
  //          		echo '<td style="text-align:right;">'.number_format($value['weight_loss'],2).'</td>';
  //          		echo '<td style="text-align:right;">'.number_format($value['amount'],2).'</td>';
  //          		echo '<td></td>';
  //          echo '</tr>';  


                        
  //       }   

  //       			$temp = Yii::app()->db->createCommand()
	 //                        ->select('SUM(amount) as sum')
	 //                        ->from('buy_material_detail')
	 //                        ->join('buy_material_input t', 'buy_id=t.id')
	 //                        ->where("material_id='$material_id' AND buy_date='".$date_select."'")
	 //                        ->queryAll();
	 //        		$sum_amount = $temp[0]['sum'];
	 //        		echo '<tr><td colspan=6 style="background-color: #fdffcb;"></td>';
	 //        			echo '<td style="text-align:right;background-color: #fdffcb;">'.number_format($sum_amount,2).'</td>';
	 //        		echo '</tr>';               

	echo '</table>';
	echo '</div>';

			
?>