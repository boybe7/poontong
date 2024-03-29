<?php
$this->breadcrumbs=array(
	'Requisitions'=>array('index')
);?>



<h3>รายการเบิก</h3>
<?php
 $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'success',
    'label'=>'เพิ่มรายการเบิก',
    'icon'=>'plus-sign',
    'url'=>array('create'),
    'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 10px 10px 10px;'),
));?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'requisition-grid',
	'dataProvider'=>$model->search(),
	'type'=>'bordered condensed',
	'afterAjaxUpdate' => 'reinstallDatePicker',
	'filter'=>$model,
	'selectableRows' =>2,
	'htmlOptions'=>array('style'=>'padding-top:10px;width:100%'),
    'enablePagination' => true,
    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
    'template'=>'{items}<div class=\"row-fluid\"><div class=\"span6\">{pager}</div><div class=\"span6\">{summary}</div></div>',
	'columns'=>array(
		// 'material_id'=>array(
		// 	'name' => 'material_id',
		// 	'value' => function($model){
		// 		$m = Material::model()->FindByPk($model->material_id);
		// 		$data = empty($m) ? "" : $m->name;
		// 		return $data;
		// 	 },
		// 	'filter'=>CHtml::listData(Material::model()->findAll(), 'id', 'name'), 
		// 	'headerHtmlOptions' => array('style' => 'width:25%;text-align:center;background-color: #f5f5f5'),  	            	  	
		// 	'htmlOptions'=>array('style'=>'text-align:left')
	 //  	),
		'create_date'=>array(
			'name' => 'create_date',
			'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'model'=>$model, 
				'attribute'=>'create_date', 
				'language' => 'ja',
				// 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
				'htmlOptions' => array(
					'id' => 'datepicker_for_due_date',
					'size' => '10',
				),
				'defaultOptions' => array(  // (#3)
					'showOn' => 'focus', 
					'dateFormat' => 'yy/mm/dd',
					'showOtherMonths' => true,
					'selectOtherMonths' => true,
					'changeMonth' => true,
					'changeYear' => true,
					'showButtonPanel' => true,
				)
			), 
			true),
			'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
	  	'username'=>array(
			'name' => 'username',
			'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
	  	'process'=>array(
			'name' => 'process',
			'value' => function($model){
				$m = Process::model()->FindByPk($model->process);
				$data = empty($m) ? "" : $m->name;
				return $data;
			 },
			'filter'=>CHtml::listData(Process::model()->findAll(), 'id', 'name'), 
			'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
	  	'material_id'=>array(
			'header' => '<a class="sort-link">รายการวัตถุดิบ</a>',
			'value' => function($model){
				$data = $model->getItem($model->id);
				return $data;
			 },
			 'type'=>'raw',
			'filter'=>CHtml::listData(Material::model()->findAll(), 'id', 'name'), 
			'headerHtmlOptions' => array('style' => 'width:55%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:left')
	  	),
		// 'amount'=>array(
		// 	'name' => 'amount',
		// 	'value' => function($model){
		// 		return number_format($model->amount,2);
		// 	 },
		// 	 'class' => 'editable.EditableColumn',
		// 	'editable' => array( //editable section
								
		// 							'title'=>'แก้ไข ',
		// 							'url' => $this->createUrl('Requisition/update2'),
		// 							'success' => 'js: function(response, newValue) {
		// 												if(!response.success) return response.msg;

		// 												$("#requisition-grid").yiiGridView("update",{});
		// 											}',
		// 							'options' => array(
		// 								'ajaxOptions' => array('dataType' => 'json'),

		// 							), 
		// 							'placement' => 'right',
					
									
		// 	),
		// 	'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
		// 	'htmlOptions'=>array('style'=>'text-align:right')
	 //  	),
	 //  	'sack'=>array(
		// 	'name' => 'sack',
		// 	'value' => function($model){
		// 		return number_format($model->sack);
		// 	 },
		// 	 'class' => 'editable.EditableColumn',
		// 	 'editable' => array( //editable section
								
		// 							'title'=>'แก้ไข ',
		// 							'url' => $this->createUrl('Requisition/update2'),
		// 							'success' => 'js: function(response, newValue) {
		// 												if(!response.success) return response.msg;

		// 												$("#requisition-grid").yiiGridView("update",{});
		// 											}',
		// 							'options' => array(
		// 								'ajaxOptions' => array('dataType' => 'json'),

		// 							), 
		// 							'placement' => 'right',
					
									
		// 	),
		// 	'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
		// 	'htmlOptions'=>array('style'=>'text-align:right')
	 //  	),
	 //  	'bigbag'=>array(
		// 	'name' => 'bigbag',
		// 	'class' => 'editable.EditableColumn',
		// 	'editable' => array( //editable section
								
		// 							'title'=>'แก้ไข ',
		// 							'url' => $this->createUrl('Requisition/update2'),
		// 							'success' => 'js: function(response, newValue) {
		// 												if(!response.success) return response.msg;

		// 												$("#requisition-grid").yiiGridView("update",{});
		// 											}',
		// 							'options' => array(
		// 								'ajaxOptions' => array('dataType' => 'json'),

		// 							), 
		// 							'placement' => 'right',
					
									
		// 	),
		// 	'value' => function($model){
		// 		return number_format($model->bigbag);
		// 	 },
		// 	'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
		// 	'htmlOptions'=>array('style'=>'text-align:right')
	 //  	),
	  	
		array(
			'header' => '<a class="sort-link"></a>',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'headerHtmlOptions' => array('style' => 'width:6%;text-align:center;background-color: #f5f5f5'),
			'template' => '{print} {update} {delete}',
			'buttons'=>array(
				'print'=>array(
								'click'=>'function(){
										filename = "requisition_"+$.now()+".pdf";
										
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
								'url'=>'Yii::app()->createUrl("Requisition/print", array("id"=>$data->id))',
								'options'=>array(),
						      'icon' => 'icon-print',	

							)
			)
		),
	),
));

Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
        //use the same parameters that you had set in your widget else the datepicker will be refreshed by default
	$('#datepicker_for_due_date').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['th'],{'dateFormat':'yy/mm/dd'}));
}
");
 ?>
