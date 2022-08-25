<?php
$this->breadcrumbs=array(
	'Stocks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);


?>

<h3>แก้ไขข้อมูลStock</h3>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>