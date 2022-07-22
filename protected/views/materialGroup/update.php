<?php
$this->breadcrumbs=array(
	'Material Groups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MaterialGroup','url'=>array('index')),
	array('label'=>'Create MaterialGroup','url'=>array('create')),
	array('label'=>'View MaterialGroup','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage MaterialGroup','url'=>array('admin')),
);
?>

<h1>Update MaterialGroup <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>