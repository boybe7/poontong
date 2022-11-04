<?php
$this->breadcrumbs=array(
	'ขายผลผลิต'=>array('index'),
	'Update',
);


?>

<h3>แก้ไขข้อมูลการขาย</h3>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>