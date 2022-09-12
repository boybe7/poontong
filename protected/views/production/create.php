<?php
$this->breadcrumbs=array(
	'Productions'=>array('index'),
	'Create',
);


?>

<h3>เพิ่มข้อมูลProduction</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>