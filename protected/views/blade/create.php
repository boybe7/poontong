<?php
$this->breadcrumbs=array(
	'ใบมีด'=>array('index'),
	'Create',
);


?>

<h3>เพิ่มข้อมูลใบมีด</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>