<?php
$this->breadcrumbs=array(
	'Sites'=>array('index')
);



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('site-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>รายการข้อมูลโรงงาน</h3>



<?php 

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'success',
    'label'=>'เพิ่มโรงงาน',
    'icon'=>'plus-sign',
    'url'=>array('create'),
    'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 10px 10px 10px;'),
)); 


$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'site-grid',
	'type'=>'bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'selectableRows' =>2,
	'htmlOptions'=>array('style'=>'padding-top:10px;width:100%'),
    'enablePagination' => true,
    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
    'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
	'columns'=>array(
		'name'=>array(
			'name' => 'name',
			'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:left')
	  	),
	  	'address'=>array(
			'name' => 'address',
			'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:left')
	  	),
	  	'telephone'=>array(
			'name' => 'telephone',
			'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:left')
	  	),
		'email'=>array(
			'name' => 'email',
			'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:left')
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
