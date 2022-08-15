<?php
$this->breadcrumbs=array(
	'Buy Material Detail Temps'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);


?>

<h3>แก้ไขข้อมูลBuyMaterialDetailTemp</h3>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>