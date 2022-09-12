<?php
$this->breadcrumbs=array(
	'Productions'=>array('index')
);?>



<h3>รายการบันทึกกระบวนการผลิต</h3>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'production-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>  array('class'=>'well')
)); ?>
<div class='row-fluid'>
	<div class='span2'>
		<?php 

		$modelCreate = new Production;

		$typelist = CHtml::listData(Process::model()->findAll('site_id=:id', array(':id' => Yii::app()->user->getSite())),'id','name');
		echo $form->dropDownListRow($modelCreate, 'process_id', $typelist,array('class'=>'span12'), array('options' => array('process_id'=>array('selected'=>true))));
		?>
	</div>
	<div class='span2'>
		<?php
			echo $form->labelEx($modelCreate,'production_date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;')); 

                 
                        echo '<div class="input-append" style="margin-top:-10px;">'; //ใส่ icon ลงไป
                            $form->widget('zii.widgets.jui.CJuiDatePicker',

                            array(
                                'name'=>'production_date',
                                'attribute'=>'production_date',
                                'model'=>$modelCreate,
                                'options' => array(
                                                  'mode'=>'focus',
                                                  //'language' => 'th',
                                                  'format'=>'dd/mm/yyyy', //กำหนด date Format
                                                  'showAnim' => 'slideDown',
                                                  ),
                                'htmlOptions'=>array('class'=>'span10', 'value'=>$modelCreate->production_date),  // ใส่ค่าเดิม ในเหตุการ Update 
                             )
                        );
                        echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';  
		?>
	</div>
	
	<div class='span2'>
		<?php 

		$typelist = array("0" => "input", "1" => "output");
		echo $form->dropDownListRow($modelCreate, 'in_out', $typelist,array('class'=>'span12'), array('options' => array('in_out'=>array('selected'=>true))));
		?>
	</div>
	<div class='span3'>
		<?php 

		$typelist = CHtml::listData(Material::model()->findAll('site_id=:id', array(':id' => Yii::app()->user->getSite())),'id','name');
		echo $form->dropDownListRow($modelCreate, 'material_id', $typelist,array('class'=>'span12','empty' => '----เลือก----','ajax' => array(
                                'type'=>'GET', 
                                'url'=>CController::createUrl('Stock/GetStock'),
                                'data'=>array('material_id' => 'js:this.value'),
                                'success'=>'function(data){
                                		response = JSON.parse(data);
                                		//$("#stock_amount").val(response.amount)
                                		//$("#stock_sack").val(response.sack)
                                		//$("#stock_bigbag").val(response.bigbag)
                                }', 
                            )), array('options' => array('material_id'=>array('selected'=>true))));

		?>
	</div>
	

	<div class='span2'>
		<?php echo $form->textFieldRow($modelCreate,'amount',array('class'=>'span12 number','maxlength'=>15)); ?>
	</div>

   <div class='span1'>
		<?php
			$this->widget('bootstrap.widgets.TbButton', array(
			              'buttonType'=>'link',
			              
			              'type'=>'success',
			              'label'=>'เพิ่ม',
			              'icon'=>'plus-sign',
			              
			              'htmlOptions'=>array(
			                'class'=>'span12',
			                'style'=>'margin:25px 0px 0px 0px;',
						    'onclick'=>'
						           
								$.ajax({
										type: "POST",
										url: "' .CController::createUrl('Production/create'). '",										
										data: $("#production-form").serialize()
									})									
									.done(function( msg ) {
													
										$("#production-grid").yiiGridView("update",{});

	                           $("#Production_amount").val("")
                                                                             
									})	
													
							',
					                
			              ),
			          ));


		?>
	</div>
</div>		
<?php $this->endWidget(); ?>

<?php 

$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'production-grid',
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
		'production_date'=>array(
			'name' => 'production_date',
			'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'model'=>$model, 
				'attribute'=>'production_date', 
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
			'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		'process_id'=>array(
			'name' => 'process_id',
			'value' => function($model){
				$m = Process::model()->FindByPk($model->process_id);
				$data = empty($m) ? "" : $m->name;
				return $data;
			 },
			'filter'=>CHtml::listData(Process::model()->findAll(), 'id', 'name'), 
			'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:left')
	  	),
	  	'in_out'=>array(
			'name' => 'in_out',
			'value' => function($model){
				$data = $model->in_out==1 ? "output": "input";
				return $data;
			 },
			'filter'=>false, 
			'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		'material_id'=>array(
			'name' => 'material_id',
			'value' => function($model){
				$m = Material::model()->FindByPk($model->material_id);
				$data = empty($m) ? "" : $m->name;
				return $data;
			 },
			'filter'=>false, 
			'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
	  	'amount'=>array(
			'name' => 'amount',
			'value' => function($model){
				
				return number_format($model->amount,2);
			 },
			'filter'=>false, 
			'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:right')
	  	),
		
		array(
			'header' => '<a class="sort-link"></a>',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),
			'template' => '{delete}'
		)
	),
)); 


Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
        //use the same parameters that you had set in your widget else the datepicker will be refreshed by default
	$('#datepicker_for_due_date').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['th'],{'dateFormat':'yy/mm/dd'}));
}
");
?>
