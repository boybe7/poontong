<?php
$this->breadcrumbs=array(
	'Customers'=>array('index'),
	'Manage',
);

?>

<h3>รายการข้อมูลลูกค้า</h3>

<?php 

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'success',
    'label'=>'เพิ่มลูกค้า',
    'icon'=>'plus-sign',
    'url'=>array('create'),
    'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 10px 10px 10px;'),
)); 

if(Yii::app()->user->isAdmin())
{
	$this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'customer-grid',
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
				'headerHtmlOptions' => array('style' => 'width:22%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left')
		  	),
			'address'=>array(
				'name' => 'address',
				'headerHtmlOptions' => array('style' => 'width:31%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left')
		  	),
		  	'phone'=>array(
				'name' => 'phone',
				'headerHtmlOptions' => array('style' => 'width:13%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left')
		  	),
			'type'=>array(
				'name' => 'type',
				'value' => function($model){
				    if($model->type=='S')
					   return 'ผู้ขาย';
					if($model->type=='B')
					   return 'ผู้ซื้อ';		
				  },
			    'filter'=>CHtml::activeDropDownList($model, 'type', array('S' => 'ผู้ขาย', 'B' => 'ผู้ซื้อ'),array('empty'=>'')), 
				'headerHtmlOptions' => array('style' => 'width:7%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center')
		  	),
		  	'group'=>array(
				'name' => 'group_id',
				'value' => function($model){
				    if($model->group_id=='1')
					   return 'รายใหญ่';
					elseif($model->group_id=='2')
					   return 'รายย่อย';	
					elseif($model->group_id=='3')
					   return 'ประจำ';		
				  },
			    'filter'=>CHtml::activeDropDownList($model, 'group_id', array("1" => "รายใหญ่", "2" => "รายย่อย", "3" => "ประจำ"),array('empty'=>'')), 
				'headerHtmlOptions' => array('style' => 'width:7%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center')
		  	),
		  	'site'=>array(
				'name' => 'site_id',
				'value' => function($model){
					$siteModel =  Site::model()->FindByPk($model->site_id);
					return empty($siteModel) ? "" : $siteModel->name;
				  },
				'filter'=>CHtml::listData(Site::model()->findAll(), 'id', 'name'), 
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
}
else
{
	$this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'customer-grid',
		'type'=>'bordered condensed',
		'dataProvider'=>$model->searchBySite(Yii::app()->user->getSite()),
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
				'headerHtmlOptions' => array('style' => 'width:35%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left')
		  	),
			'address'=>array(
				'name' => 'address',
				'headerHtmlOptions' => array('style' => 'width:35%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left')
		  	),
		  	'phone'=>array(
				'name' => 'phone',
				'headerHtmlOptions' => array('style' => 'width:13%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left')
		  	),
			'type'=>array(
				'name' => 'type',
				'value' => function($model){
				    if($model->type=='S')
					   return 'ผู้ขาย';
					if($model->type=='B')
					   return 'ผู้ซื้อ';		
				  },
			    'filter'=>CHtml::activeDropDownList($model, 'type', array('S' => 'ผู้ขาย', 'B' => 'ผู้ซื้อ'),array('empty'=>'')), 
				'headerHtmlOptions' => array('style' => 'width:7%;text-align:center;background-color: #f5f5f5'),  	            	  	
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
}

 ?>
