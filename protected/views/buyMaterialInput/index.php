<?php
$this->breadcrumbs=array(
	'Buy Material Inputs',
);

$this->menu=array(
	array('label'=>'Create BuyMaterialInput','url'=>array('create')),
	array('label'=>'Manage BuyMaterialInput','url'=>array('admin')),
);
?>

<h1>Buy Material Inputs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
