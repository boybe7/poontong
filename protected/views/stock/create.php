<?php
$this->breadcrumbs=array(
	'Stocks'=>array('index'),
	'Create',
);

if($type==0)
	echo '<h3>เพิ่มข้อมูล Stock วัตถุดิบ</h3>';
if($type==1)
	echo '<h3>เพิ่มข้อมูล Stock สารเคมี</h3>';
if($type==2)
	echo '<h3>เพิ่มข้อมูล Stock ใบมีด</h3>';

echo $this->renderPartial('_form', array('model'=>$model,'type'=>$type)); 

?>