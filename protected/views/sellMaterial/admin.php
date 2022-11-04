<?php
$this->breadcrumbs=array(
	'ขายผลผลิต'=>array('index')
);?>



<h3>รายการขาย</h3>
<?php
 $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'success',
    'label'=>'เพิ่มรายการขาย',
    'icon'=>'plus-sign',
    'url'=>array('create'),
    'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 10px 10px 10px;'),
));?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'sell-material-grid',
	'dataProvider'=>$model->search(),
	'type'=>'bordered condensed',
	'filter'=>$model,
	'selectableRows' =>2,
	'htmlOptions'=>array('style'=>'padding-top:10px;width:100%'),
    'enablePagination' => true,
    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
    'template'=>'{items}<div class=\"row-fluid\"><div class=\"span6\">{pager}</div><div class=\"span6\">{summary}</div></div>',
	'columns'=>array(
		'sell_date'=>array(
			'name' => 'sell_date',
			//'filter'=> false,
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
			'header' => '<a class="sort-link">รายการขาย</a>',
			'value' => function($model){
				$data = $model->getItem($model->id);
				return $data;
			 },
			 'type'=>'raw',
			'filter'=>CHtml::listData(Material::model()->findAll(), 'id', 'name'), 
			'headerHtmlOptions' => array('style' => 'width:33%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:left')
	  	),
		
	  	'price_net'=>array(
			'header' => '<a class="sort-link">ราคารวม(บาท)</a>',
			'filter'=> false,
			'value' => function($model){
				
				$data = $model->getTotal($model->id);
				return number_format($data,2);
			 },
			'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
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
			'template' => '{print}  {update}  {delete}',
			'buttons'=>array(
				'print'=>array(
								'click'=>'function(){
										filename = "invoiceno"+$.now()+".pdf";
										
										link = $(this).attr("href");
									    $.ajax({
									        url: link,
									        data: {filename: filename},
									        success:function(response){
									             
									             window.open("../report/temp/"+filename, "_blank", "fullscreen=yes", "clearcache=yes");              
									            
									        }

									    });

									   return false; 
								}',
								'url'=>'Yii::app()->createUrl("SellMaterial/print", array("id"=>$data->id))',
								'options'=>array(),
						      'icon' => 'icon-print',	

							)
			)
		),
	),
)); ?>

