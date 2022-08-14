<?php
$this->breadcrumbs=array(
	'ซื้อวัตถุดิบรายวัน'=>array('index')
);?>



<h3>รายการซื้อวัตถุดิบรายวัน</h3>
<?php
 $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'success',
    'label'=>'เพิ่มรายการซื้อวัตถุดิบ',
    'icon'=>'plus-sign',
    'url'=>array('create'),
    'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 10px 10px 10px;'),
));?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'buy-material-input-grid',
	'dataProvider'=>$model->search(),
	'type'=>'bordered condensed',
	'filter'=>$model,
	'selectableRows' =>2,
	'htmlOptions'=>array('style'=>'padding-top:10px;width:100%'),
    'enablePagination' => true,
    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
    'template'=>'{items}<div class=\"row-fluid\"><div class=\"span6\">{pager}</div><div class=\"span6\">{summary}</div></div>',
	'columns'=>array(
		'buy_date'=>array(
			'name' => 'buy_date',
			'filter'=> false,
			'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
	  	'customer_id'=>array(
			'name' => 'customer_id',
			'value' => function($model){
				$m =  Customer::model()->FindByPk($model->customer_id);
				return empty($m) ? "" : $m->name;
			 },
			'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:left')
	  	),
	  	'material_id'=>array(
			'name' => 'material_id',
			'value' => function($model){
				$m =  Material::model()->FindByPk($model->material_id);
				return empty($m) ? "" : $m->name;
			 },
			'filter'=>CHtml::listData(Material::model()->findAll(), 'id', 'name'), 
			'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		'price_unit'=>array(
			'name' => 'price_unit',
			'filter'=> false,
			'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:right')
	  	),
	  	'weight_net'=>array(
			'name' => 'weight_net',
			'filter'=> false,
			'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:right')
	  	),
	  	'price_net'=>array(
			'name' => 'price_net',
			'filter'=> false,
			'value' => function($model){
				
				return number_format($model->price_net,2);
			 },
			'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:right')
	  	),
	  	'note'=>array(
			'name' => 'note',
			'filter'=> false,
			'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:left')
	  	),
		array(
			'header' => '<a class="sort-link"></a>',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),
			'template' => '{delete} {update}'
		),
	),
)); ?>
