<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'buy-material-detail-temp-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>  array('class'=>'well')
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'material_id',array('class'=>'span5')); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'amount',array('class'=>'span5')); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'price_unit',array('class'=>'span5','maxlength'=>10)); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'price_net',array('class'=>'span5','maxlength'=>15)); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'buy_id',array('class'=>'span5')); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span5')); ?>
</div>



<?php $this->endWidget(); ?>
