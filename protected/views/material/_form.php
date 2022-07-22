<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'material-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>  array('class'=>'well')
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'unit',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'is_compressed',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'have_label',array('class'=>'span5')); ?>

	<div class="row-fluid">
		<div class="span12 form-actions ">
			<?php 
	                
	      
	     		
	     		$this->widget('bootstrap.widgets.TbButton', array(
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
	          		'url'=>array("admin"), 
			  	)); 
	         
	    ?>
		</div>
	  </div>

<?php $this->endWidget(); ?>
