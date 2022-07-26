<script type="text/javascript">
  
  $(function(){
      
      
       $("#Material_price1,#Material_price2,#Material_price3,#Material_sell").maskMoney({"symbolStay":true,"thousands":",","decimal":".","precision":2,"symbol":null})  
   
  });

</script>  

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'material-form',
	'enableAjaxValidation'=>false,
	 // 'type'=>'horizontal',
	 'htmlOptions'=>  array('class'=>'well')
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row-fluid">
		<div class="span7">
			<?php echo $form->textFieldRow($model,'name',array('class'=>'span12','maxlength'=>255)); ?>
		</div>
		<div class="span2">
			<?php  	$typelist = CHtml::listData(MaterialGroup::model()->findAll(),'id','name');
		   		 	echo $form->dropDownListRow($model, 'material_group_id', $typelist,array('class'=>'span12'), array('options' => array('material_group_id'=>array('selected'=>true))));   
		    ?>
		</div>	
		<div class="span2">
			<?php echo $form->textFieldRow($model,'unit',array('class'=>'span12','maxlength'=>45)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span2">
			<?php 	echo CHtml::activeCheckBox($model,'is_compressed');
                	echo "  <font color=''><b>อัดก้อน</b></font>";   ?>
        </div>
        <div class="span2">
			<?php 	echo CHtml::activeCheckBox($model,'have_label');
                	echo "  <font color=''><b>แกะฉลาก</b></font>";   ?>
        </div>        	
	</div>
	<div class="row-fluid">
		<div class="span3">
			<?php echo $form->textFieldRow($model,'price1',array('class'=>'span12','maxlength'=>45,'style'=>'text-align:right')); ?>
		</div>
		<div class="span3">
			<?php echo $form->textFieldRow($model,'price2',array('class'=>'span12','maxlength'=>45,'style'=>'text-align:right')); ?>
		</div>
		<div class="span3">
			<?php echo $form->textFieldRow($model,'price3',array('class'=>'span12','maxlength'=>45,'style'=>'text-align:right')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span3">
		<?php echo $form->textFieldRow($model,'sell',array('class'=>'span12','style'=>'text-align:right')); ?>
		</div>
		<div class="span2">
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
