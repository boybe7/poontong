<?php
$this->breadcrumbs=array(
	'ซื้ออะไหล่'=>array('index'),
	'Update',
);


?>

<h3>แก้ไขข้อมูลซื้ออะไหล่</h3>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>