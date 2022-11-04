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

        
        $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');    
                
                //ob_start();

                //header('Content-Type: application/vnd.ms-excel');
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
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