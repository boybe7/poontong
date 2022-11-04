<?php
$this->breadcrumbs=array(
	'ขายผลผลิต'=>array('index'),
	'Create',
);


?>

<h3>เพิ่มข้อมูลการขาย</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>