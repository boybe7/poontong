<?php
$this->breadcrumbs=array(
	'Production Configs'=>array('index')
);?>



<h3>กำหนดค่ากระบวนการผลิต</h3>
<?php
 $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'success',
    'label'=>'เพิ่ม',
    'icon'=>'plus-sign',
    'url'=>array('create'),
    'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 10px 10px 10px;'),
));?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'production-config-grid',
	'dataProvider'=>$model->search(),
	'type'=>'bordered condensed',
	'filter'=>$model,
	'selectableRows' =>2,
	'htmlOptions'=>array('style'=>'padding-top:10px;width:100%'),
    'enablePagination' => true,
    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
    'template'=>'{items}<div class=\"row-fluid\"><div class=\"span6\">{pager}</div><div class=\"span6\">{summary}</div></div>',
	'columns'=>array(
		'process_id'=>array(
			'name' => 'process_id',
			'value' => function($model){
				$m = Process::model()->FindByPk($model->process_id);
				$data = empty($m) ? "" : $m->name;
				return $data;
			 },
			'filter'=>CHtml::listData(Process::model()->findAll(), 'id', 'name'), 
			'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:left')
	  	),
		'material_id'=>array(
			'name' => 'material_id',
			'value' => function($model){
				$m = Material::model()->FindByPk($model->material_id);
				$data = empty($m) ? "" : $m->name;
				return $data;
			 },
			'filter'=>false, 
			'headerHtmlOptions' => array('style' => 'width:40%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		'in_out'=>array(
			'name' => 'in_out',
			'value' => function($model){
				$data = $model->in_out==1 ? "output": "input";
				return $data;
			 },
			'filter'=>false, 
			'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		array(
			'header' => '<a class="sort-link"></a>',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),
			'template' => '{delete}'
		),
	),
)); ?>
