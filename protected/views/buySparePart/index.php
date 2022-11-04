<?php
$this->breadcrumbs=array(
	'Buy Spare Parts',
);

$this->menu=array(
	array('label'=>'Create BuySparePart','url'=>array('create')),
	array('label'=>'Manage BuySparePart','url'=>array('admin')),
);
?>

<h1>Buy Spare Parts</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
