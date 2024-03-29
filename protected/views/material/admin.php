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

$groups = CustomerGroup::model()->findAll("site_id=".Yii::app()->user->getSite());
$num_group = count($groups);

$price1 = !empty($groups[0]) ? 'ราคา '.$groups[0]->name : 'ราคา 1';
$price2 = !empty($groups[1]) ? 'ราคา '.$groups[1]->name : 'ราคา 2';
$price3 = !empty($groups[2]) ? 'ราคา '.$groups[2]->name : 'ราคา 3';
$price4 = !empty($groups[3]) ? 'ราคา '.$groups[3]->name : 'ราคา 4';
$price5 = !empty($groups[4]) ? 'ราคา '.$groups[4]->name : 'ราคา 5';
$price6 = !empty($groups[5]) ? 'ราคา '.$groups[5]->name : 'ราคา 6';

if(Yii::app()->user->isAdmin())
{
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
			'headerHtmlOptions' => array('style' => 'width:32%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:left')
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
				//return $model->getPriceType($model,1);
				return $model->price1;
			  },
			'headerHtmlOptions' => array('style' => 'width:8%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		  'price2'=>array(
			'header' => '<a class="sort-link">ราคารับซื้อ<br>รายย่อย</a>',
			'type'=>'raw', 
			'value' => function($model){
				//return $model->getPriceType($model,2);
				return $model->price2;
			  },
			'headerHtmlOptions' => array('style' => 'width:8%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		  'price3'=>array(
			'header' => '<a class="sort-link">ราคารับซื้อ<br>ลูกค้าประจำ</a>',
			'type'=>'raw', 
			'value' => function($model){
				//return $model->getPriceType($model,3);
				return $model->price3;
			  },

			'headerHtmlOptions' => array('style' => 'width:8%;text-align:center;background-color: #f5f5f5'),  	            	  	
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
			'header' => '<a class="sort-link">'.$price1.'</a>',
			'type'=>'raw', 
			'value' => function($model){
				//return $model->getPrice($model);
				//return $model->getPriceType($model,1);
				return $model->price1;
			  },
			'visible' => $num_group>=1 ? true : false,  
			'headerHtmlOptions' => array('style' => 'width:8%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		  'price2'=>array(
			'header' => '<a class="sort-link">'.$price2.'</a>',
			'type'=>'raw', 
			'value' => function($model){
				//return $model->getPriceType($model,2);
				return $model->price2;
			  },
			'visible' => $num_group>=2 ? true : false,
			'headerHtmlOptions' => array('style' => 'width:8%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		  'price3'=>array(
			'header' => '<a class="sort-link">'.$price3.'</a>',
			'type'=>'raw', 
			'value' => function($model){
				//return $model->getPriceType($model,3);
				return $model->price3;
			  },
			'visible' => $num_group>=3 ? true : false,
			'headerHtmlOptions' => array('style' => 'width:8%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		 'price4'=>array(
			'header' => '<a class="sort-link">'.$price4.'</a>',
			'type'=>'raw', 
			'value' => function($model){
				return $model->price4;
			  },
			'visible' => $num_group>=4 ? true : false,
			'headerHtmlOptions' => array('style' => 'width:8%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
	  	 'price5'=>array(
			'header' => '<a class="sort-link">'.$price5.'</a>',
			'type'=>'raw', 
			'value' => function($model){
				return $model->price5;
			  },
			'visible' => $num_group>=5 ? true : false,
			'headerHtmlOptions' => array('style' => 'width:8%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),  
		'price6'=>array(
			'header' => '<a class="sort-link">'.$price6.'</a>',
			'type'=>'raw', 
			'value' => function($model){
				return $model->price6;
			  },
			'visible' => $num_group>=6 ? true : false,
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
?>
