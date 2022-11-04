<?php
$this->breadcrumbs=array(
	'โซดาไฟ'=>array('index')
);?>



<h3>รายการซื้อโซดาไฟ</h3>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'create-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>  array('class'=>'well')
)); ?>
	
<div class="row-fluid">
   <div class="span2">
		<?php 
		echo $form->labelEx($model,'buy_date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));
		echo '<div class="input-append" style="margin-top:-10px;">'; //ใส่ icon ลงไป
		                    $form->widget('zii.widgets.jui.CJuiDatePicker',

		                    array(
		                        'name'=>'buy_date',
		                        'attribute'=>'buy_date',
		                        'model'=>$model,
		                        'options' => array(
		                                          'mode'=>'focus',
		                                          //'language' => 'th',
		                                          'format'=>'dd/mm/yyyy', //กำหนด date Format
		                                          'showAnim' => 'slideDown',
		                                          ),
		                        'htmlOptions'=>array('class'=>'span12', 'value'=>$model->buy_date),  // ใส่ค่าเดิม ในเหตุการ Update 
		                     )
		                );
		                echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';
 

		?>	
	</div> 
	<div class='span3'>
		<?php echo $form->textFieldRow($model,'supplier',array('class'=>'span12')); ?>
	</div>
	<div class='span2'>
		<?php echo $form->textFieldRow($model,'volume',array('class'=>'span12 number')); ?>
	</div>
	<div class='span3'>
		<?php echo $form->textFieldRow($model,'price',array('class'=>'span12 number')); ?>
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
										url: "' .CController::createUrl('BuyChemical/create'). '",										
										data: $("#create-form").serialize()
									})									
									.done(function( msg ) {
													
										$("#buy-chemical-grid").yiiGridView("update",{});

	                           $("#BuyChemical_supplier").val("")
	                           $("#BuyChemical_volume").val("")
	                           $("#BuyChemical_price").val("")
	                           $("#BuyChemical_buy_date").val("")
                                                                             
									})	
													
							',
					                
			              ),
			          ));


		?>
	</div>
</div>		
<?php $this->endWidget(); ?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'buy-chemical-grid',
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
			
			'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		'supplier'=>array(
			'name' => 'supplier',
			//'filter'=> false,
			'class' => 'editable.EditableColumn',
			'editable' => array( //editable section
								
									'title'=>'แก้ไข ',
									'url' => $this->createUrl('BuyChemical/update'),
									'success' => 'js: function(response, newValue) {
														if(!response.success) return response.msg;

														$("#buy-chemical-grid").yiiGridView("update",{});
													}',
									'options' => array(
										'ajaxOptions' => array('dataType' => 'json'),

									), 
									'placement' => 'right',
					
									
			),
		
			'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:left')
	  	),
	  	'volume'=>array(
			'name' => 'volume',
			'filter'=> false,
			'class' => 'editable.EditableColumn',
			'editable' => array( //editable section
								
									'title'=>'แก้ไข ',
									'url' => $this->createUrl('BuyChemical/update'),
									'success' => 'js: function(response, newValue) {
														if(!response.success) return response.msg;

														$("#buy-chemical-grid").yiiGridView("update",{});
													}',
									'options' => array(
										'ajaxOptions' => array('dataType' => 'json'),

									), 
									'placement' => 'right',
					
									
			),
			'value' => function($model){
				return number_format($model->volume,2);
			 },
			'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:right')
	  	),
		'price'=>array(
			'name' => 'price',
			'filter'=> false,
			'class' => 'editable.EditableColumn',
			'editable' => array( //editable section
								
									'title'=>'แก้ไข ',
									'url' => $this->createUrl('BuyChemical/update'),
									'success' => 'js: function(response, newValue) {
														if(!response.success) return response.msg;

														$("#buy-chemical-grid").yiiGridView("update",{});
													}',
									'options' => array(
										'ajaxOptions' => array('dataType' => 'json'),

									), 
									'placement' => 'right',
					
									
			),
			'value' => function($model){
				return number_format($model->price,2);
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
