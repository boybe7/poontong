<?php
$this->breadcrumbs=array(
	'ซื้อวัตถุดิบรายวัน'=>array('index'),
	'Update',
);


?>

<h3>แก้ไขข้อมูลซื้อวัตถุดิบรายวัน</h3>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>