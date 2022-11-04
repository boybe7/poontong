<?php
$this->breadcrumbs=array(
	'Blades',
);

$this->menu=array(
	array('label'=>'Create Blade','url'=>array('create')),
	array('label'=>'Manage Blade','url'=>array('admin')),
);
?>

<h1>Blades</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
