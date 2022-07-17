<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'material-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'unit',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'is_compressed',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'have_label',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
