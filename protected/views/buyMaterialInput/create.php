<?php
$this->breadcrumbs=array(
	'ซื้อวัตถุดิบรายวัน'=>array('index'),
	'Create',
);


?>

<h3>เพิ่มข้อมูลซื้อวัตถุดิบรายวัน</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>