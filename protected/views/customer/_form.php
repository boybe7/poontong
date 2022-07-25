<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'customer-form',
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
	<?php echo $form->textFieldRow($model,'phone',array('class'=>'span8','maxlength'=>45)); ?>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<?php 

		 	 $typelist = array("S" => "ผู้ขาย", "B" => "ผู้ซื้อ");
             echo $form->dropDownListRow($model, 'type', $typelist,array('class'=>'span12'), array('options' => array('type'=>array('selected'=>true)))); 


			?>
		</div>
		
	</div>

	<div class="row-fluid">
		<div class="span4">
			<?php 

		 	 $typelist = array("1" => "ลูกค้ารายใหญ่", "2" => "ลูกค้ารายย่อย", "3" => "ลูกค้าประจำ");
             echo $form->dropDownListRow($model, 'group_id', $typelist, array('class'=>'span12'), array('options' => array('type'=>array('selected'=>true)))); 

			?>
		</div>
		
	</div>

	<div class="row-fluid">
		
		<div class="span4">
			<?php 
		   if(Yii::app()->user->isAdmin())	
		   {
		   		 $typelist = CHtml::listData(Site::model()->findAll(),'id','name');
		   		 echo $form->dropDownListRow($model, 'site_id', $typelist,array('class'=>'span12'), array('options' => array('site_id'=>array('selected'=>true)))); 

		   }
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
