<?php
$this->breadcrumbs=array(
	'Customers'=>array('index'),
	'Update',
);


?>

<h3>แก้ไขข้อมูลลูกค้า</h3>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>