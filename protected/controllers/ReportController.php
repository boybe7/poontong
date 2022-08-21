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

}

?>