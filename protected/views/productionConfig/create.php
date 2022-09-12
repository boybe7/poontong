<?php
$this->breadcrumbs=array(
	'Production Configs'=>array('index'),
	'Create',
);


?>

<h3>เพิ่มข้อมูลProductionConfig</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>