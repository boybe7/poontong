<?php

class AjaxController extends Controller {
	public function actionGetMaterialOption() {        
    
        //$user_dept = Yii::app()->user->userdept;
      	$data = array();

        $data = Material::model()->findAll('site_id=:id', array(':id' => (int) $_POST['site_id']));        
        

        if(empty($data))
             echo CHtml::tag('option', array('value' => ''), CHtml::encode(""), true);
        else
             echo CHtml::tag('option', array('value' => ''), CHtml::encode("-----------"), true);
        $data = CHtml::listData($data, 'id', 'name');
        foreach ($data as $value => $name) {            
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }

       
    }
}

?>