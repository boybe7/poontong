<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'site-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>  array('class'=>'well')
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row-fluid">
	<?php echo $form->textFieldRow($model,'name',array('class'=>'span8','maxlength'=>255)); ?>
	</div>
	<div class="row-fluid">
	<?php echo $form->textAreaRow($model,'address',array('rows'=>3, 'cols'=>50, 'class'=>'span8')); ?>
    </div>
    <div class="row-fluid">
	<?php echo $form->textFieldRow($model,'telephone',array('class'=>'span8','maxlength'=>45)); ?>
	</div>
	<div class="row-fluid">
	<?php echo $form->textFieldRow($model,'email',array('class'=>'span8','maxlength'=>255)); ?>
	</div>
	
	<div class="row-fluid">
		<div class="span4">
			<?php 

		 	 $typelist = array( "1" => "ใช้งาน","0" => "ไม่ใช้งาน");
             echo $form->dropDownListRow($model, 'status', $typelist,array('class'=>'span12'), array('options' => array('status'=>array('selected'=>true)))); 


			?>
		</div>
		
	</div>

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
