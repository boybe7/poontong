<?php
$this->breadcrumbs=array(
	'วัตถุดิบ'=>array('index')
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('material-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>รายการข้อมูลวัตถุดิบ</h3>



<?php 

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'success',
    'label'=>'เพิ่มวัตถุดิบ',
    'icon'=>'plus-sign',
    'url'=>array('create'),
    'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 10px 10px 10px;'),
)); 

$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'material-grid',
	'type'=>'bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'selectableRows' =>2,
	'htmlOptions'=>array('style'=>'padding-top:10px;width:100%'),
    'enablePagination' => true,
    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
    'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
	'columns'=>array(
		'checkbox'=> array(
        	    'id'=>'selectedID',
            	'class'=>'CCheckBoxColumn',
            	//'selectableRows' => 2, 
        		 'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #f5f5f5'),
	  	         'htmlOptions'=>array(
	  	            	  			'style'=>'text-align:center'

	  	            	  		)   	  		
        ),
		
		'name'=>array(
			'name' => 'name',
			'headerHtmlOptions' => array('style' => 'width:40%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:left')
	  	),
		'unit'=>array(
			'name' => 'unit',
			'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		'material_group_id'=>array(
			'name' => 'material_group_id',
			'value' => function($model){
				$groupModel =  MaterialGroup::model()->FindByPk($model->material_group_id);
				return empty($groupModel) ? "" : $groupModel->name;
			  },
		    'filter'=>CHtml::listData(MaterialGroup::model()->findAll(), 'id', 'name'),  
			'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		'price1'=>array(
			'header' => '<a class="sort-link">ราคารับซื้อ<br>รายใหญ่</a>',
			'type'=>'raw', 
			'value' => function($model){
				//return $model->getPrice($model);
				return $model->getPriceType($model,1);
			  },
			'headerHtmlOptions' => array('style' => 'width:8%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		  'price2'=>array(
			'header' => '<a class="sort-link">ราคารับซื้อ<br>รายย่อย</a>',
			'type'=>'raw', 
			'value' => function($model){
				return $model->getPriceType($model,2);
			  },
			'headerHtmlOptions' => array('style' => 'width:8%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		  'price3'=>array(
			'header' => '<a class="sort-link">ราคารับซื้อ<br>ลูกค้าประจำ</a>',
			'type'=>'raw', 
			'value' => function($model){
				return $model->getPriceType($model,3);
			  },
			'headerHtmlOptions' => array('style' => 'width:8%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		
		array(
			'header' => '<a class="sort-link"></a>',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),
			'template' => '{delete} {update}'
		),

	),
));

?>
