<?php
$this->breadcrumbs=array(
	'Materials'=>array('index'),
	'Create',
);

?>

<h3>เพิ่มข้อมูลวัตถุดิบ</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>