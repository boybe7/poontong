<?php
$this->breadcrumbs=array(
	'Material Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MaterialGroup','url'=>array('index')),
	array('label'=>'Manage MaterialGroup','url'=>array('admin')),
);
?>

<h1>Create MaterialGroup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>