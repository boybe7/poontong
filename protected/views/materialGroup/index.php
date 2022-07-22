<?php
$this->breadcrumbs=array(
	'Material Groups',
);

$this->menu=array(
	array('label'=>'Create MaterialGroup','url'=>array('create')),
	array('label'=>'Manage MaterialGroup','url'=>array('admin')),
);
?>

<h1>Material Groups</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
