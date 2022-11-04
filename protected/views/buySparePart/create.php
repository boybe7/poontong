<?php
$this->breadcrumbs=array(
	'ซื้ออะไหล่'=>array('index'),
	'Create',
);


?>

<h3>เพิ่มข้อมูลซื้ออะไหล่</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>