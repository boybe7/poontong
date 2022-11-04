<?php
$this->breadcrumbs=array(
	'ค่าไฟ'=>array('index'),
	'Update',
);


?>

<h3>แก้ไขข้อมูลค่าไฟ</h3>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>