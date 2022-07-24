<?php
$this->breadcrumbs=array(
	'Materials'=>array('index'),
	
	'Update',
);

echo '<h3>แก้ไขข้อมูลวัตถุดิบ : '.$model->name.'</h3>';
?>



<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>