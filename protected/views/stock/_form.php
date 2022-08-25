<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'stock-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>  array('class'=>'well')
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<div class='row-fluid'>
	<?php 
		           $typelist = CHtml::listData(Material::model()->findAll('site_id=:id', array(':id' => Yii::app()->user->getSite())),'id','name');
		   		 	echo $form->dropDownListRow($model, 'material_id', $typelist,array('class'=>'span5'), array('options' => array('material_id'=>array('selected'=>true))));	
	?>
</div>

<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'amount',array('class'=>'span5')); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'sack',array('class'=>'span5')); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'bigbag',array('class'=>'span5')); ?>
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
