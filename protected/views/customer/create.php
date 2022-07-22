<?php
$this->breadcrumbs=array(
	'Customers'=>array('index'),
	'Create',
);


?>


<h3>เพิ่มข้อมูลลูกค้า</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>