
<?php


$month_th = array("1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม","4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน","7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน","10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");

$str_date = explode("/", $date_start);
$date_start = ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];   

$str_date = explode("/", $date_end);
$date_end = ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];

$date1=date_create($date_start);
$date2=date_create($date_end);
$interval = $date1->diff($date2);
$nday = $interval->days;



	echo "<center><div class='header'><h4>รายงานสรุปซื้อขาย ระหว่างวันที่ ".$this->renderDate($date_start)." ถึง ".$this->renderDate($date_end)."</h4></div></center>";
	
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
		
			echo '<td rowspan=2 width="10%" style="text-align:center;font-weight:bold;background-color: #c3c8c2;">วันที่</td>';
			$num_material_buy = count($materialBuy);
			echo '<td colspan='.$num_material_buy.' width="10%" style="text-align:center;font-weight:bold;background-color: #def7d7;">รายการซื้อ (บาท)</td>';
			$num_material_sell = count($materialSell);
			echo '<td colspan='.$num_material_sell.' width="10%" style="text-align:center;font-weight:bold;background-color: #ffeec1;">รายการขาย (บาท)</td>';
		
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

	
		echo '</tr>';
		$row = 1;
		for($i=0;$i<=$nday;$i++)
		{
			$bgcolor = $row%2==0 ?  "#eff4fd" : "#ffffff";
			
  			$date_str = $date1->format('Y-m-d');

			echo '<tr>';
				echo '<td style="text-align:center;background-color:'.$bgcolor.'">'.$this->renderDate($date_str).'</td>';
				foreach ($materialBuy as $key => $value) {
					$mbuy = Yii::app()->db->createCommand()
	                        ->select('sum(price_net) as pricenet')
	                        ->from('buy_material_detail')
	                        ->join('buy_material_input t', 'buy_id=t.id')
	                        ->where("material_id=".$value['material_id']." AND buy_date = '".$date_str."' AND t.site_id='".Yii::app()->user->getSite()."'")
	                    	->queryAll();
	                
	                $price = empty($mbuy[0]['pricenet']) ? "-" : number_format($mbuy[0]['pricenet'],2);    	
	                echo '<td style="text-align:right;background-color:'.$bgcolor.'">'.$price.'</td>';    	
				}	

				foreach ($materialSell as $key => $value) {
					$msell = Yii::app()->db->createCommand()
	                        ->select('sum(price_net) as pricenet')
	                        ->from('sell_material_detail')
	                        ->join('sell_material t', 'sell_id=t.id')
	                        ->where("material_id=".$value['material_id']." AND sell_date = '".$date_str."' AND t.site_id='".Yii::app()->user->getSite()."'")
	                    	->queryAll();

	                $price = empty($msell[0]['pricenet']) ? "-" : number_format($msell[0]['pricenet'],2);    	
	                echo '<td style="text-align:right;background-color:'.$bgcolor.'">'.$price.'</td>';    	
				}	
			echo '</tr>';
			$date1->modify('+1 day');

			$row++;
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
		echo '</tr>';
		echo '<tr>';
				if(count($materialBuy)>1)
				   echo '<td style="text-align:center;font-weight:bold;background-color:#e4e4e4"></td>';

				echo '<td style="text-align:center;font-weight:bold;background-color:#9ccffb">รวมซื้อ</td>';
				$ncol = count($materialBuy)-1;
				echo '<td colspan='.$ncol.' style="text-align:right;font-weight:bold;background-color:#9ccffb"><u>'.number_format($sumbuy,2).'</u></td>';
				if(count($materialSell)>1)
				{
					echo '<td style="text-align:center;font-weight:bold;background-color:#9ccffb">รวมขาย</td>';
					$ncol = count($materialSell)-1;
					echo '<td colspan='.$ncol.' style="text-align:right;font-weight:bold;background-color:#9ccffb"><u>'.number_format($sumsell,2).'</u></td>';
				}
				else
				{
					echo '<td style="text-align:right;font-weight:bold;background-color:#9ccffb">รวมขาย    <u>'.number_format($sumsell,2).'</u></td>';
				}
				
		echo '</tr>';

		
	
	echo '</table>';
	echo '</div>';

			
?>