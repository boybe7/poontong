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
        
        $this->renderPartial('_formBuyraw', array(
            'month'=>$_GET['month'],'year'=>$_GET['year'],'material_id'=>$_GET['material_id'],
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

}

?>