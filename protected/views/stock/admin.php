<?php
$this->breadcrumbs=array(
	'Stocks'=>array('index/'.$type)
);?>




<?php

 $typename= '';
 if($type==0)
 	 $typename = 'วัตถุดิบ';
 if($type==1)
 	 $typename = 'สารเคมี';
 if($type==2)
 	 $typename = 'ใบมีด';


 	echo '<h3>รายการ Stocks '.$typename.'</h3>';


 $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'success',
    'label'=>'เพิ่มข้อมูล'.$typename,
    'icon'=>'plus-sign',
    'url'=> Yii::app()->createUrl("Stock/create", array("id"=>$type)),//array('create'),
    'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 10px 10px 10px;'),
));



?>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'stock-grid',
	'dataProvider'=>$model->searchByType($type),
	'type'=>'bordered condensed',
	'filter'=>$model,
	'selectableRows' =>2,
	'htmlOptions'=>array('style'=>'padding-top:10px;width:100%'),
    'enablePagination' => true,
    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
    'template'=>'{items}<div class=\"row-fluid\"><div class=\"span6\">{pager}</div><div class=\"span6\">{summary}</div></div>',
	'columns'=>array(
		'material_id'=>array(
			'name' => 'material_id',
			'value' => function($model){
				$m = Material::model()->FindByPk($model->material_id);
				$data = empty($m) ? "" : $m->name;
				return $data;
			 },
			'filter'=>CHtml::listData(Material::model()->findAll(), 'id', 'name'), 
			'headerHtmlOptions' => array('style' => 'width:33%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:left')
	  	),
		'amount'=>array(
			'name' => 'amount',
			'value' => function($model){
				return number_format($model->amount,2);
			 },
			 'class' => 'editable.EditableColumn',
			'editable' => array( //editable section
								
									'title'=>'แก้ไข ',
									'url' => $this->createUrl('Stock/update'),
									'success' => 'js: function(response, newValue) {
														if(!response.success) return response.msg;

														$("#stock-grid").yiiGridView("update",{});
													}',
									'options' => array(
										'ajaxOptions' => array('dataType' => 'json'),

									), 
									'placement' => 'right',
					
									
			),
			'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:right')
	  	),
	  	'sack'=>array(
			'name' => 'sack',
			'value' => function($model){
				return number_format($model->sack);
			 },
			 'class' => 'editable.EditableColumn',
			 'editable' => array( //editable section
								
									'title'=>'แก้ไข ',
									'url' => $this->createUrl('Stock/update'),
									'success' => 'js: function(response, newValue) {
														if(!response.success) return response.msg;

														$("#stock-grid").yiiGridView("update",{});
													}',
									'options' => array(
										'ajaxOptions' => array('dataType' => 'json'),

									), 
									'placement' => 'right',
					
									
			),
			'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:right')
	  	),
	  	'bigbag'=>array(
			'name' => 'bigbag',
			'class' => 'editable.EditableColumn',
			'editable' => array( //editable section
								
									'title'=>'แก้ไข ',
									'url' => $this->createUrl('Stock/update'),
									'success' => 'js: function(response, newValue) {
														if(!response.success) return response.msg;

														$("#stock-grid").yiiGridView("update",{});
													}',
									'options' => array(
										'ajaxOptions' => array('dataType' => 'json'),

									), 
									'placement' => 'right',
					
									
			),
			'value' => function($model){
				return number_format($model->bigbag);
			 },
			'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:right')
	  	),
		'last_update'=>array(
			'name' => 'last_update',
			'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
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
