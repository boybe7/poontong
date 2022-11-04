<?php
$this->breadcrumbs=array(
	'ค่าไฟ'=>array('index')
);?>



<h3>รายการค่าไฟ</h3>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'electricity-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>  array('class'=>'well')
)); ?>
	
<div class="row-fluid">
   <div class="span2">
		<?php 
		echo $form->labelEx($model,'create_date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));
		echo '<div class="input-append" style="margin-top:-10px;">'; //ใส่ icon ลงไป
		                    $form->widget('zii.widgets.jui.CJuiDatePicker',

		                    array(
		                        'name'=>'create_date',
		                        'attribute'=>'create_date',
		                        'model'=>$model,
		                        'options' => array(
		                                          'mode'=>'focus',
		                                          //'language' => 'th',
		                                          'format'=>'dd/mm/yyyy', //กำหนด date Format
		                                          'showAnim' => 'slideDown',
		                                          ),
		                        'htmlOptions'=>array('class'=>'span12', 'value'=>$model->create_date),  // ใส่ค่าเดิม ในเหตุการ Update 
		                     )
		                );
		                echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';
 

		?>	
	</div> 
	
	<div class='span3'>
		<?php echo $form->textFieldRow($model,'hour',array('class'=>'span12 number')); ?>
	</div>
	<div class='span3'>
		<?php echo $form->textFieldRow($model,'unit',array('class'=>'span12 number')); ?>
	</div>	
	<div class='span2'>
		<?php
			$this->widget('bootstrap.widgets.TbButton', array(
			              'buttonType'=>'link',
			              
			              'type'=>'success',
			              'label'=>'เพิ่มรายการ',
			              'icon'=>'plus-sign',
			              
			              'htmlOptions'=>array(
			                'class'=>'span12',
			                'style'=>'margin:25px 0px 0px 0px;',
						    'onclick'=>'
						           
								$.ajax({
										type: "POST",
										url: "' .CController::createUrl('Electricity/create'). '",										
										data: $("#electricity-form").serialize()
									})									
									.done(function( msg ) {
													
										$("#electricity-grid").yiiGridView("update",{});

	                           $("#Electricity_hour").val("")
	                           $("#Electricity_unit").val("")
                                                                             
									})	
													
							',
					                
			              ),
			          ));


		?>
	</div>
</div>		
<?php $this->endWidget(); ?>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'electricity-grid',
	'dataProvider'=>$model->search(),
	'type'=>'bordered condensed',
	'filter'=>$model,
	'selectableRows' =>2,
	'htmlOptions'=>array('style'=>'padding-top:10px;width:100%'),
    'enablePagination' => true,
    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
    'template'=>'{items}<div class=\"row-fluid\"><div class=\"span6\">{pager}</div><div class=\"span6\">{summary}</div></div>',
	'columns'=>array(
		'create_date'=>array(
			'name' => 'create_date',
			//'filter'=> false,
			'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
	  
		'hour'=>array(
			'name' => 'hour',
			'filter'=> false,
			'class' => 'editable.EditableColumn',
			'editable' => array( //editable section
								
									'title'=>'แก้ไข ',
									'url' => $this->createUrl('Electricity/update'),
									'success' => 'js: function(response, newValue) {
														if(!response.success) return response.msg;

														$("#electricity-grid").yiiGridView("update",{});
													}',
									'options' => array(
										'ajaxOptions' => array('dataType' => 'json'),

									), 
									'placement' => 'right',
					
									
			),
			'value' => function($model){
				return number_format($model->hour,2);
			 },
			'headerHtmlOptions' => array('style' => 'width:25%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:right')
	  	),
		'unit'=>array(
			'name' => 'unit',
			'filter'=> false,
			'class' => 'editable.EditableColumn',
			'editable' => array( //editable section
								
									'title'=>'แก้ไข ',
									'url' => $this->createUrl('Electricity/update'),
									'success' => 'js: function(response, newValue) {
														if(!response.success) return response.msg;

														$("#electricity-grid").yiiGridView("update",{});
													}',
									'options' => array(
										'ajaxOptions' => array('dataType' => 'json'),

									), 
									'placement' => 'right',
					
									
			),
			'value' => function($model){
				return number_format($model->unit,2);
			 },
			'headerHtmlOptions' => array('style' => 'width:25%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:right')
	  	),
		
		array(
			'header' => '<a class="sort-link"></a>',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),
			'template' => '{delete}',
		),
	),
)); ?>
