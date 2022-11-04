<?php
$this->breadcrumbs=array(
	'Sell Materials',
);

$this->menu=array(
	array('label'=>'Create SellMaterial','url'=>array('create')),
	array('label'=>'Manage SellMaterial','url'=>array('admin')),
);
?>

<h1>Sell Materials</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
