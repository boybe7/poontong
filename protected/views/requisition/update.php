<?php
$this->breadcrumbs=array(
	'เบิกวัตถุดิบ'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);


?>

<h3>แก้ไขข้อมูลเบิกวัตถุดิบ</h3>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>