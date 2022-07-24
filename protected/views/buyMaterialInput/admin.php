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
		'id',
		'customer',
		'buy_date',
		'customer_id',
		'bill_no',
		'car_no',
		/*
		'weight_in',
		'weight_out',
		'weight_loss',
		'weight_net',
		'price_unit',
		'material_id',
		'price_net',
		'last_update',
		'update_by',
		'site_id',
		'note',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
