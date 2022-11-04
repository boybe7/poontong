<?php
$this->breadcrumbs=array(
	'ประเภทค่าใช้จ่าย'=>array('index')
);?>



<h3>รายการประเภทค่าใช้จ่าย</h3>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'cost-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>  array('class'=>'')
)); ?>
<div class="row-fluid">
	<div class='offset3 span4'>
		<?php echo $form->textFieldRow($model,'name',array('class'=>'span12')); ?>
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
										url: "' .CController::createUrl('CostOperationGroup/create'). '",										
										data: $("#cost-form").serialize()
									})									
									.done(function( msg ) {
													
										$("#cost-operation-group-grid").yiiGridView("update",{});

	                           $("#CostOperationGroup_name").val("")
                                                                             
									})	
													
							',
					                
			              ),
			          ));


		?>
	</div>
</div>
<?php $this->endWidget(); ?>

<div class="row-fluid">
	<div class="offset3 span6">
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'cost-operation-group-grid',
	'dataProvider'=>$model->search(),
	'type'=>'bordered condensed',
	'filter'=>$model,
	'selectableRows' =>2,
	'htmlOptions'=>array('style'=>'padding-top:10px;width:100%'),
    'enablePagination' => true,
    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
    'template'=>'{items}<div class=\"row-fluid\"><div class=\"span6\">{pager}</div><div class=\"span6\">{summary}</div></div>',
	'columns'=>array(
		
		'name'=>array(
			'name' => 'name',
			//'filter'=> false,
			'class' => 'editable.EditableColumn',
			'editable' => array( //editable section
								
									'title'=>'แก้ไข ',
									'url' => $this->createUrl('CostOperationGroup/update'),
									'success' => 'js: function(response, newValue) {
														if(!response.success) return response.msg;

														$("#cost-operation-group-grid").yiiGridView("update",{});
													}',
									'options' => array(
										'ajaxOptions' => array('dataType' => 'json'),

									), 
									'placement' => 'right',
					
									
			),
			'headerHtmlOptions' => array('style' => 'width:60%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
	  
		array(
			'header' => '<a class="sort-link"></a>',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),
			'template' => '{delete}',
		),
	),
)); ?>
	</div>
</div>
