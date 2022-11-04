<?php
$this->breadcrumbs=array(
	'ใบมีด'=>array('index'),
	'Update',
);


?>

<h3>แก้ไขข้อมูลใบมีด</h3>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>