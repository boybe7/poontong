<?php
$this->breadcrumbs=array(
	'Stocks'=>array('index'),
	'Create',
);


?>

<h3>เพิ่มข้อมูล Stock</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model,'type'=>$type)); ?>