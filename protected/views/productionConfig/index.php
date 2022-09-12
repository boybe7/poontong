<?php
$this->breadcrumbs=array(
	'Production Configs',
);

$this->menu=array(
	array('label'=>'Create ProductionConfig','url'=>array('create')),
	array('label'=>'Manage ProductionConfig','url'=>array('admin')),
);
?>

<h1>Production Configs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
