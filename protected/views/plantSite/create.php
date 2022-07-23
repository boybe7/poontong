<?php
$this->breadcrumbs=array(
	'Sites'=>array('index'),
	'Create',
);


?>

<h3>เพิ่มข้อมูลโรงงาน</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>