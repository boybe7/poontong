<?php
$this->breadcrumbs=array(
	'เบิกวัตถุดิบ'=>array('index'),
	'Create',
);


?>

<h3>เพิ่มข้อมูลเบิกวัตถุดิบ</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model,'modelDetail'=>$modelDetail)); ?>