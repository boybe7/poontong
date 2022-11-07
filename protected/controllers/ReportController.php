<?php

class ReportController extends Controller {
	/**
      * Declares class-based actions.
      */
     public function actions()
     {
          return array(
               // captcha action renders the CAPTCHA image displayed on the contact page
               'captcha'=>array(
                    'class'=>'CCaptchaAction',
                    'backColor'=>0xFFFFFF,
               ),
               // page action renders "static" pages stored under 'protected/views/site/pages'
               // They can be accessed via: index.php?r=site/page&view=FileName
               'page'=>array(
                    'class'=>'CViewAction',
               ),
          );
     }

     function renderDate($value)
     {
         $th_month = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
         $dates = explode("-", $value);
         $d=0;
         $mi = 0;
         $yi = 0;
         foreach ($dates as $key => $value) {
              $d++;
              if($d==2)
                 $mi = $value;
              if($d==3)
                 $yi = $value;
         }
         if(substr($mi, 0,1)==0)
             $mi = substr($mi, 1);
         if(substr($dates[0], 0,1)==0)
             $d = substr($dates[0], 1);
         else
             $d = $dates[0];

         $renderDate = $yi." ".$th_month[$mi]." ".($d+543);
         if($renderDate==0)
             $renderDate = "";   

         return $renderDate;             
     }

     public function actionBuyraw()
     {
                    
          // display the progress form
          $this->render('buyraw');
     }

     public function actionGentBuyraw()
    {
        
        // $this->renderPartial('_formBuyraw', array(
        //     'month'=>$_GET['month'],'year'=>$_GET['year'],'material_id'=>$_GET['material_id'],
        //     'display' => 'block',
        // ), false, true);


        $this->renderPartial('_formBuyraw', array(
            'date_start'=>$_GET['date_start'],'date_end'=>$_GET['date_end'],'customer_id'=>$_GET['customer_id'],
            'display' => 'block',
        ), false, true);

        
    }

     public function actionBuyrawExcel()
    {
        $date_start = $_GET['date_start'];
        $date_end = $_GET['date_end'];
        $customer_id = $_GET['customer_id'];

        $str_date = explode("/", $date_start);
        if(count($str_date)>1)
            $date_start= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];

        $str_date = explode("/", $date_end);
        if(count($str_date)>1)
            $date_end= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];
     

        Yii::import('ext.phpexcel.XPHPExcel');    
        $objPHPExcel= XPHPExcel::createPHPExcel();
        $sheet = 0;
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex($sheet)->setTitle("รายงานซื้อวัตถุดิบรายวัน");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "รายงานซื้อวัตถุดิบรายวัน ระหว่างวันที่ ".$this->renderDate($date_start)." ถึง ".$this->renderDate($date_end));
        $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');    

        $objPHPExcel->getActiveSheet()->setCellValue('A2',"วันที่");
        $objPHPExcel->getActiveSheet()->setCellValue('B2',"ร้าน");
        $objPHPExcel->getActiveSheet()->setCellValue('C2',"รายการ");
        $objPHPExcel->getActiveSheet()->setCellValue('D2',"จำนวน (กก.)");
        $objPHPExcel->getActiveSheet()->setCellValue('E2',"ราคา (บาท)");

        $condition = empty($customer_id) ? "" : " AND customer_id=".$customer_id;

        $buymaterial = Yii::app()->db->createCommand()
                        ->select('*,buy_material_input.id as buy_id')
                        ->from('buy_material_input')
                        ->join('customer t', 'customer_id=t.id')
                        ->where("buy_date BETWEEN '".$date_start."' AND '".$date_end."' AND buy_material_input.site_id='".Yii::app()->user->getSite()."' ".$condition)
                        ->order(array('buy_date asc'))
                        ->queryAll();

        $row = 3;                
        foreach ($buymaterial as $key => $value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $this->renderDate($value["buy_date"]));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, ($value["name"]));
            
            $sql= 'SELECT * FROM buy_material_detail LEFT JOIN material ON material_id=material.id WHERE buy_id='.$value['buy_id'];
            $model = Yii::app()->db->createCommand($sql)->queryAll();
            foreach ($model as $key => $value2) {
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, ($value2["name"]));
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, ($value2["amount"]));
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, ($value2["price_net"]));
                
                $row++;     
            }
            if(count($model)==0)   
                $row++;
        }   


        for ($i = 'A'; $i <=  $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }

          header('Content-Type: application/vnd.ms-excel');
                //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="buyrawdaily_report.xlsx"');
                header('Cache-Control: max-age=0');
                // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

                // If you're serving to IE over SSL, then the following may be needed
                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header ('Pragma: public'); // HTTP/1.0
                
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                ob_end_clean();
                $objWriter->save('php://output');  //
                Yii::app()->end();



    }

    public function actionPrintBill()
    {
            
        $this->renderPartial('_formBill_PDF', array(
            'date_start'=>$_GET['date_start'],'date_end'=>$_GET['date_end'],'customer_id'=>$_GET['customer_id'],'filename'=>$_GET['filename'],
            'display' => 'block',
        ), false, true);

    }

    public function actionProfitLoss()
     {
                    
          // display the progress form
          $this->render('profitLoss');
     }

     public function actionGentProfitLoss()
    {
        
        $this->renderPartial('_formProfitLoss', array(
            'year'=>$_GET['year'],
            'display' => 'block',
        ), false, true);

        
    }

     public function actionPrintProfitLoss()
    {
            
        $this->renderPartial('_formProfitLossPDF', array(
            'year'=>$_GET['year'],'filename'=>$_GET['filename'],
            'display' => 'block',
        ), false, true);

    }
    public function actionProfitLossExcel()
    {
        
        $year=$_GET['year'];
      
         Yii::import('ext.phpexcel.XPHPExcel');    
        $objPHPExcel= XPHPExcel::createPHPExcel();
        $sheet = 0;
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex($sheet)->setTitle("รายงานกำไร-ขาดทุน");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "รายงานกำไร-ขาดทุน ปี ".$year);    

        $month_th = array("1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม","4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน","7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน","10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");

        $date_start = ($year-543)."-01-01";
        $date_end = ($year-543)."-12-31";

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


        $objPHPExcel->getActiveSheet()->setCellValue('A2', "เดือน ปี");
        $objPHPExcel->getActiveSheet()->mergeCells('A2:A3');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', "รายการซื้อ (บาท)");
        $nbuy = count($materialBuy);
        $colbuy = chr(ord("B") + $nbuy - 1);
        $objPHPExcel->getActiveSheet()->mergeCells('B2:'.$colbuy.'2');
        $nsell = count($materialSell);
        $colsell_begin = chr(ord($colbuy) + 1);
        $colsell_end = chr(ord($colsell_begin) + $nsell - 1);
        $objPHPExcel->getActiveSheet()->mergeCells($colsell_begin.'2:'.$colsell_end.'2');
        $objPHPExcel->getActiveSheet()->setCellValue($colsell_begin.'2', "รายการขาย (บาท)");
        $ncost = count($operationCost);
        $colcost_begin = chr(ord($colsell_end) + 1);
        $colcost_end = chr(ord($colcost_begin) + $ncost - 1);
        $objPHPExcel->getActiveSheet()->mergeCells($colcost_begin.'2:'.$colcost_end.'2');
        $objPHPExcel->getActiveSheet()->setCellValue($colcost_begin.'2', "รายการค่าใช้จ่าย (บาท)");
        $colcost_end++;
        $objPHPExcel->getActiveSheet()->setCellValue($colcost_end.'2', "กำไร-ขาดทุน (บาท)");
        $objPHPExcel->getActiveSheet()->mergeCells($colcost_end.'2:'.$colcost_end.'3');

        $col = "B";  
            foreach ($materialBuy as $key => $value) {
                $objPHPExcel->getActiveSheet()->setCellValue($col.'3',Material::model()->FindByPk($value["material_id"])->name);
                $col++;
            }

            foreach ($materialSell as $key => $value) {
                $objPHPExcel->getActiveSheet()->setCellValue($col.'3',Material::model()->FindByPk($value["material_id"])->name);
                $col++;
            }

            foreach ($operationCost as $key => $value) {
                $objPHPExcel->getActiveSheet()->setCellValue($col.'3',$value->name);

                $col++;
            }

        $row = 4;    
        for ($i=1; $i <= 12; $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$month_th[$i].' '.$year);

                $priceSell = 0;
                $priceBuy = 0;
                $priceCost = 0;
                $col = 'B';
                foreach ($materialBuy as $key => $value) {
                    $mbuy = Yii::app()->db->createCommand()
                            ->select('sum(price_net) as pricenet')
                            ->from('buy_material_detail')
                            ->join('buy_material_input t', 'buy_id=t.id')
                            ->where("material_id=".$value['material_id']." AND MONTH(buy_date) = '".$i."' AND  YEAR(buy_date)= '".($year-543)."' AND t.site_id='".Yii::app()->user->getSite()."'")
                            ->queryAll();

                    $price = empty($mbuy[0]['pricenet']) ? "-" : $mbuy[0]['pricenet'];  
                    $priceBuy += $mbuy[0]['pricenet'];      
                    $objPHPExcel->getActiveSheet()->setCellValue($col.$row,"".$price);

                    $col++;      
                }

                foreach ($materialSell as $key => $value) {
                    $msell = Yii::app()->db->createCommand()
                            ->select('sum(price_net) as pricenet')
                            ->from('sell_material_detail')
                            ->join('sell_material t', 'sell_id=t.id')
                            ->where("material_id=".$value['material_id']." AND MONTH(sell_date) = '".$i."' AND  YEAR(sell_date)= '".($year-543)."' AND t.site_id='".Yii::app()->user->getSite()."'")
                            ->queryAll();

                    $price = empty($msell[0]['pricenet']) ? "-" : ($msell[0]['pricenet']);       
                   
                    $priceSell += $msell[0]['pricenet'];
                    $objPHPExcel->getActiveSheet()->setCellValue($col.$row,"".$price);

                    $col++;         
                }   


                foreach ($operationCost as $key => $value) {
                    $mcost = Yii::app()->db->createCommand()
                            ->select('sum(cost) as cost')
                            ->from('cost_operation')
                            ->where("group_id='".$value->id."' AND MONTH(create_date) = '".$i."' AND  YEAR(create_date)= '".($year-543)."' AND site_id='".Yii::app()->user->getSite()."'")
                            ->queryAll();
                    

                     $price = empty($mcost[0]['cost']) ? "-" : $mcost[0]['cost'];      
                     $priceCost += $mcost[0]['cost'];

                    $objPHPExcel->getActiveSheet()->setCellValue($col.$row,"".$price);

                    $col++;     
                }

                $profitLoss = $priceSell - $priceBuy - $priceCost;
                $objPHPExcel->getActiveSheet()->setCellValue($col.$row,"".$profitLoss);

            $row++;

        }    
    

        $objPHPExcel->setActiveSheetIndex($sheet)->getStyle('A2:'.$objPHPExcel->getActiveSheet()->getHighestColumn().'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        for ($i = 'A'; $i <=  $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }

          header('Content-Type: application/vnd.ms-excel');
                //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="profitLoss_report.xlsx"');
                header('Cache-Control: max-age=0');
                // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

                // If you're serving to IE over SSL, then the following may be needed
                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header ('Pragma: public'); // HTTP/1.0
                
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                ob_end_clean();
                $objWriter->save('php://output');  //
                Yii::app()->end();
    }

    public function actionBuyProductionSummary()
     {
                    
          // display the progress form
          $this->render('buyProductionSummary');
     }

    public function actionGentBuyProductionSummary()
    {
        
        $this->renderPartial('_formBuyProductionSummary', array(
            'year'=>$_GET['year'],
            'display' => 'block',
        ), false, true);

        
    }

     public function actionPrintBuyProductionSummary()
    {
        
        $this->renderPartial('_formBuyProductionSummaryPDF', array(
            'year'=>$_GET['year'],'filename'=>$_GET['filename'],
            'display' => 'block',
        ), false, true);

        
    }

    public function actionBuyProductionSummaryExcel()
    {
               
        $year = $_GET['year'];
       $month_th = array("1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม","4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน","7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน","10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");

        $date_start = ($year-543)."-01-01";
        $date_end = ($year-543)."-12-31";

        Yii::import('ext.phpexcel.XPHPExcel');    
        $objPHPExcel= XPHPExcel::createPHPExcel();
        $sheet = 0;
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex($sheet)->setTitle("รายงานสรุปซื้อขาย(บด)");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "รายงานสรุปซื้อขาย(บด) ปี ".$year);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');

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

        $objPHPExcel->getActiveSheet()->mergeCells('A2:A3');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', "เดือน ปี");
        $nbuy = count($materialBuy)+1;
        $colbuy = chr(ord("B") + $nbuy - 1);
        $objPHPExcel->getActiveSheet()->mergeCells('B2:'.$colbuy.'2');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', "รายการซื้อ (กก.)");
        $nsell = count($materialSell)+1;
        $colsell_begin = chr(ord($colbuy) + 1);
        $colsell_end = chr(ord($colsell_begin) + $nsell - 1);
        $objPHPExcel->getActiveSheet()->mergeCells($colsell_begin.'2:'.$colsell_end.'2');
        $objPHPExcel->getActiveSheet()->setCellValue($colsell_begin.'2', "รายการขายบด (กก.)"); 
        $colsell_end++;
        $objPHPExcel->getActiveSheet()->setCellValue($colsell_end.'2', "บด-ซื้อ (กก.)");
        $objPHPExcel->getActiveSheet()->mergeCells($colsell_end.'2:'.$colsell_end.'3'); 

        $row = 4;
        $col = "A";
        for ($i=1; $i <= 12; $i++) {
            
                $objPHPExcel->getActiveSheet()->setCellValue($col.$row, $month_th[$i].' '.$year); 
                $col++;
                $sumbuy = 0;
                $row2 = 4;
                foreach ($materialBuy as $key => $value) {
                    $mbuy = Yii::app()->db->createCommand()
                            ->select('sum(amount) as amount')
                            ->from('buy_material_detail')
                            ->join('buy_material_input t', 'buy_id=t.id')
                            ->where("material_id=".$value['material_id']." AND MONTH(buy_date) = '".$i."' AND  YEAR(buy_date)= '".($year-543)."' AND t.site_id='".Yii::app()->user->getSite()."'")
                            ->queryAll();

                    $amount = empty($mbuy[0]['amount']) ? "-" : $mbuy[0]['amount'];    
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
                                   


         header('Content-Type: application/vnd.ms-excel');
                //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="buyproduction_report.xlsx"');
                header('Cache-Control: max-age=0');
                // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

                // If you're serving to IE over SSL, then the following may be needed
                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header ('Pragma: public'); // HTTP/1.0
                
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                ob_end_clean();
                $objWriter->save('php://output');  //
                Yii::app()->end();
    }

    public function actionCostOperation()
     {
                    
          // display the progress form
          $this->render('costOperation');
     }

    public function actionGentCostOperation()
    {
        
        $this->renderPartial('_formCostOperation', array(
            'year'=>$_GET['year'],
            'display' => 'block',
        ), false, true);

        
    }


    public function actionBuyrawSummary()
     {
                    
          // display the progress form
          $this->render('buyrawSummary');
     }

     public function actionGentBuyrawSummary()
    {
        
        $this->renderPartial('_formBuyrawSummary', array(
            'month'=>$_GET['month'],'year'=>$_GET['year'],
            'display' => 'block',
        ), false, true);

        
    }

    
    public function actionBuySellDaily()
    {
                    
          // display the progress form
          $this->render('buysellDaily');
    }

    public function actionGentBuySellDaily()
    {
        
        $this->renderPartial('_formBuySellDaily', array(
            'date_start'=>$_GET['date_start'],'date_end'=>$_GET['date_end'],
            'display' => 'block',
        ), false, true);

       
    }
    public function actionPrintBuySellDaily()
    {
            
        $this->renderPartial('_formBuySellDailyPDF', array(
            'date_start'=>$_GET['date_start'],'date_end'=>$_GET['date_end'],'filename'=>$_GET['filename'],
            'display' => 'block',
        ), false, true);

    }

    public function actionBuySellDailyExcel()
    {
       $date_start = $_GET['date_start'];
       $date_end = $_GET['date_end'];  

       $str_date = explode("/", $date_start);
        $date_start = ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];   

        $str_date = explode("/", $date_end);
        $date_end = ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];

        $date1=date_create($date_start);
        $date2=date_create($date_end);
        $interval = $date1->diff($date2);
        $nday = $interval->days;

        Yii::import('ext.phpexcel.XPHPExcel');    
        $objPHPExcel= XPHPExcel::createPHPExcel();
        $sheet = 0;
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex($sheet)->setTitle("รายงานสรุปซื้อขาย");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "รายงานสรุปซื้อขาย ระหว่างวันที่ ".$this->renderDate($date_start)." ถึง ".$this->renderDate($date_end));    
        
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

        $objPHPExcel->getActiveSheet()->mergeCells('A2:A3');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', "วันที่");
        $nbuy = count($materialBuy);
        $colbuy = chr(ord("B") + $nbuy - 1);
        $objPHPExcel->getActiveSheet()->mergeCells('B2:'.$colbuy.'2');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', "รายการซื้อ (บาท)");
        $nsell = count($materialSell);
        $colsell_begin = chr(ord($colbuy) + 1);
        $colsell_end = chr(ord($colsell_begin) + $nsell - 1);
        $objPHPExcel->getActiveSheet()->mergeCells($colsell_begin.'2:'.$colsell_end.'2');
        $objPHPExcel->getActiveSheet()->setCellValue($colsell_begin.'2', "รายการขาย (บาท)");  

        $colall = chr(ord("A") + $nbuy + $nsell);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:'.$colall.'1');  

        $col = "B";

        foreach ($materialBuy as $key => $value) {
            $row = 3;
            $date_begin = date_create($date_start);

            $objPHPExcel->getActiveSheet()->setCellValue($col.$row, Material::model()->FindByPk($value["material_id"])->name);

            $row++;
            for($i=0;$i<=$nday;$i++)
            {
                $date_str = $date_begin->format('Y-m-d'); 
                $objPHPExcel->getActiveSheet()->setCellValue("A".$row, $this->renderDate($date_str));


                $mbuy = Yii::app()->db->createCommand()
                            ->select('sum(price_net) as pricenet')
                            ->from('buy_material_detail')
                            ->join('buy_material_input t', 'buy_id=t.id')
                            ->where("material_id=".$value['material_id']." AND buy_date = '".$date_str."' AND t.site_id='".Yii::app()->user->getSite()."'")
                            ->queryAll();
                    
                $price = empty($mbuy[0]['pricenet']) ? "-" : $mbuy[0]['pricenet']; 
                $objPHPExcel->getActiveSheet()->setCellValue($col.$row,"".$price);

                $row++;
                $date_begin->modify('+1 day');
            }

            $col++;

        }     

        foreach ($materialSell as $key => $value) {
            $row = 3;
            $date_begin = date_create($date_start);

            $objPHPExcel->getActiveSheet()->setCellValue($col.$row, Material::model()->FindByPk($value["material_id"])->name);

            $row++;
            for($i=0;$i<=$nday;$i++)
            {
                $date_str = $date_begin->format('Y-m-d'); 
                //$objPHPExcel->getActiveSheet()->setCellValue("A".$row, $this->renderDate($date_str));


                $msell = Yii::app()->db->createCommand()
                            ->select('sum(price_net) as pricenet')
                            ->from('sell_material_detail')
                            ->join('sell_material t', 'sell_id=t.id')
                            ->where("material_id=".$value['material_id']." AND sell_date = '".$date_str."' AND t.site_id='".Yii::app()->user->getSite()."'")
                            ->queryAll();

                    
                $price = empty($msell[0]['pricenet']) ? "-" : $msell[0]['pricenet']; 
                $objPHPExcel->getActiveSheet()->setCellValue($col.$row,$price);

                $row++;
                $date_begin->modify('+1 day');
            }

            $col++;

        }                

        $objPHPExcel->setActiveSheetIndex($sheet)->getStyle('A2:'.$objPHPExcel->getActiveSheet()->getHighestColumn().'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        for ($i = 'A'; $i <=  $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }

          header('Content-Type: application/vnd.ms-excel');
                //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="buyselldaily_report.xlsx"');
                header('Cache-Control: max-age=0');
                // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

                // If you're serving to IE over SSL, then the following may be needed
                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header ('Pragma: public'); // HTTP/1.0
                
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                ob_end_clean();
                $objWriter->save('php://output');  //
                Yii::app()->end();

    }

    public function actionBuySellSummary()
    {
                    
          // display the progress form
          $this->render('buysellSummary');
    }

    public function actionGentBuySellSummary()
    {
        
        // $this->renderPartial('_formBuySellSummary', array(
        //     'monthBegin'=>$_GET['monthBegin'],'yearBegin'=>$_GET['yearBegin'],'monthEnd'=>$_GET['monthEnd'],'yearEnd'=>$_GET['yearEnd'],
        //     'display' => 'block',
        // ), false, true);

        $this->renderPartial('_formBuySellSummary', array(
            'year'=>$_GET['year'],
            'display' => 'block',
        ), false, true);
        
    }

    public function actionPrintBuySellSummary()
    {
            
        $this->renderPartial('_formBuySellSummaryPDF', array(
            'year'=>$_GET['year'],'filename'=>$_GET['filename'],
            'display' => 'block',
        ), false, true);

    }

     public function actionBuySellSummaryExcel()
    {
        $year=$_GET['year'];

        $month_th = array("1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม","4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน","7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน","10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");

        // $month = $monthBegin<10 ? "0".$monthBegin : $monthBegin ;
        // $date_start = ($yearBegin-543)."-".$month."-01";
        // $month = $monthEnd<10 ? "0".$monthEnd : $monthEnd ;
        // $number = cal_days_in_month(CAL_GREGORIAN, $monthEnd, $yearEnd-543);
        // $day = $number<10 ? "0".$number : $number ;
        // $date_end = ($yearEnd-543)."-".$month."-".$day;

        $date_start = ($year-543)."-01-01";
        $date_end = ($year-543)."-12-31";
            
       Yii::import('ext.phpexcel.XPHPExcel');    
        $objPHPExcel= XPHPExcel::createPHPExcel();
        $sheet = 0;
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex($sheet)->setTitle("รายงานสรุปซื้อขาย");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "รายงานสรุปซื้อขาย ปี ".$year);

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
 
        $row = 2;

        //header
        $objPHPExcel->getActiveSheet()->mergeCells('A2:A3');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', "เดือน ปี");
        $nbuy = count($materialBuy);
        $colbuy = chr(ord("B") + $nbuy - 1);
        $objPHPExcel->getActiveSheet()->mergeCells('B2:'.$colbuy.'2');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', "รายการซื้อ (บาท)");
        $nsell = count($materialSell);
        $colsell_begin = chr(ord($colbuy) + 1);
        $colsell_end = chr(ord($colsell_begin) + $nsell - 1);
        $objPHPExcel->getActiveSheet()->mergeCells($colsell_begin.'2:'.$colsell_end.'2');
        $objPHPExcel->getActiveSheet()->setCellValue($colsell_begin.'2', "รายการขาย (บาท)");
        
        $col = "B";

        foreach ($materialBuy as $key => $value) {
            $row = 3;
            $objPHPExcel->getActiveSheet()->setCellValue($col.$row, Material::model()->FindByPk($value["material_id"])->name);
            $sumprice = 0;
            for ($i=1; $i <= 12; $i++)
            { 
                
                $row++;
                $mbuy = Yii::app()->db->createCommand()
                                ->select('sum(price_net) as pricenet')
                                ->from('buy_material_detail')
                                ->join('buy_material_input t', 'buy_id=t.id')
                                ->where("material_id=".$value['material_id']." AND MONTH(buy_date) = '".$i."' AND  YEAR(buy_date)= '".($year-543)."' AND t.site_id='".Yii::app()->user->getSite()."'")
                                ->queryAll();

                $price = empty($mbuy[0]['pricenet']) ? "-" : $mbuy[0]['pricenet']; 

                $objPHPExcel->getActiveSheet()->setCellValue($col.$row,$price); 
                $objPHPExcel->getActiveSheet()->setCellValue("A".$row,$month_th[$i].' '.$year);   
                $sumprice +=  $mbuy[0]['pricenet'];
                if($i==12)
                {
                    $objPHPExcel->getActiveSheet()->setCellValue("A".($row+1),"รวม");
                    $objPHPExcel->getActiveSheet()->setCellValue($col.($row+1),"".$sumprice);
                }
            }
                
            $col++;
        }

        foreach ($materialSell as $key => $value) {
            $row = 3;
            $objPHPExcel->getActiveSheet()->setCellValue($col.$row, Material::model()->FindByPk($value["material_id"])->name);
            $sumprice = 0;
            for ($i=1; $i <= 12; $i++)
            { 
                
                $row++;
                $msell = Yii::app()->db->createCommand()
                            ->select('sum(price_net) as pricenet')
                            ->from('sell_material_detail')
                            ->join('sell_material t', 'sell_id=t.id')
                            ->where("material_id=".$value['material_id']." AND MONTH(sell_date) = '".$i."' AND  YEAR(sell_date)= '".($year-543)."' AND t.site_id='".Yii::app()->user->getSite()."'")
                            ->queryAll();

                $price = empty($msell[0]['pricenet']) ? "-" : $msell[0]['pricenet']; 
                $sumprice +=  $msell[0]['pricenet'];
                $objPHPExcel->getActiveSheet()->setCellValue($col.$row,$price); 
                if($i==12)
                    $objPHPExcel->getActiveSheet()->setCellValue($col.($row+1),"".$sumprice);
            }
                
            $col++;   
        }

        $objPHPExcel->setActiveSheetIndex($sheet)->getStyle('A2:'.$objPHPExcel->getActiveSheet()->getHighestColumn().'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        for ($i = 'A'; $i <=  $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }



                
                //ob_start();
                

                header('Content-Type: application/vnd.ms-excel');
                //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="buysellsummary_report2.xlsx"');
                header('Cache-Control: max-age=0');
                // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

                // If you're serving to IE over SSL, then the following may be needed
                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header ('Pragma: public'); // HTTP/1.0
                
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                ob_end_clean();
                $objWriter->save('php://output');  //
                Yii::app()->end();


    }

}

?>