<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'blade-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>  array('class'=>'well')
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'lenght',array('class'=>'span5')); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'width',array('class'=>'span5')); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'last_update',array('class'=>'span5')); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'site_id',array('class'=>'span5')); ?>
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
