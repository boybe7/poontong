<?php
$this->breadcrumbs=array(
	'Sites'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);


?>

<h3>แก้ไขข้อมูลโรงงาน</h3>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>