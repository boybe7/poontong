<?php
$this->breadcrumbs=array(
	'Electricities',
);

$this->menu=array(
	array('label'=>'Create Electricity','url'=>array('create')),
	array('label'=>'Manage Electricity','url'=>array('admin')),
);
?>

<h1>Electricities</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
