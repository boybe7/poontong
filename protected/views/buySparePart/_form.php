<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'buy-spare-part-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>  array('class'=>'well')
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<div class='row-fluid'>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'item_name',array('class'=>'span12','maxlength'=>10)); ?>	
	</div>
	<div class="span2">
		<?php echo $form->textFieldRow($model,'volume',array('class'=>'span12 number','maxlength'=>10)); ?>	
	</div>
	<div class="span2">
		<?php echo $form->textFieldRow($model,'price',array('class'=>'span12 number','maxlength'=>10)); ?>	
	</div>
	<div class="span3">
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
</div>
<div class='row-fluid'>
	<div class="span6">
		<?php echo $form->textFieldRow($model,'supplier',array('class'=>'span12','maxlength'=>10)); ?>	
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($model,'note',array('class'=>'span12','maxlength'=>10)); ?>	
	</div>
</div>

	<div class="row-fluid">
		<div class="span12 form-actions ">
			<?php	$this->widget('bootstrap.widgets.TbButton', array(
			         'buttonType'=>'submit',
			         'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 10px 0px 10px;'),
			         'type'=>'primary',
			         'label'=>'บันทึก',              
			    ));
	$this->widget('bootstrap.widgets.TbButton', array(
				   'buttonType'=>'link',
				   'type'=>'danger',
				   'label'=>'ยกเลิก',
	         		'htmlOptions'=>array('class'=>'pull-right'),               
	          		'url'=>array('admin'), 
			  	));

			  	?>
		</div>
	  </div>

<?php $this->endWidget(); ?>
