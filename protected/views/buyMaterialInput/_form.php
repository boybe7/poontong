<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'buy-material-input-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>  array('class'=>'well')
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<div class='row-fluid'>
	<div class="span8">
		<?php 
		  			echo CHtml::activeLabelEx($model, 'customer_id');
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name'=>'customer_id',
                            'id'=>'customer_id',
                            'value'=>'',//empty($vendor[0])? '' : $vendor[0]['pc_code']." ".$vendor[0]['v_name'],
                           'source'=>'js: function(request, response) {
                                $.ajax({
                                    url: "'.$this->createUrl('Customer/GetCustomers').'",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                       
                                    },
                                    success: function (data) {
                                            response(data);

                                    }
                                })
                             }',
                            // additional javascript options for the autocomplete plugin
                            'options'=>array(
                                     'showAnim'=>'fold',
                                     'minLength'=>0,
                                     'select'=>'js: function(event, ui) {
                                        
                                           //console.log(ui.item.id)
                                           $("#address").val(ui.item.address);
                                           $("#phone").val(ui.item.phone);
                                          
                                     }',
                                     //'close'=>'js:function(){$(this).val("");}',
                                     
                            ),
                           'htmlOptions'=>array(
                                'class'=>'span12'
                            ),
                                  
                        ));
            

		 ?>
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'bill_no',array('class'=>'span12','maxlength'=>255)); ?>
	</div>	
</div>
<div class='row-fluid'>
	<div class="span8">
		<label for='address'>ที่อยู่</label>
		<?php echo CHtml::textField('address','',array('class'=>'span12','maxlength'=>255)); ?>
	</div>	
	<div class="span4">
		<label for='phone'>เบอร์โทร</label>
		<?php echo CHtml::textField('phone','',array('class'=>'span12','maxlength'=>255)); ?>
	</div>
	
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'customer_id',array('class'=>'span5')); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'bill_no',array('class'=>'span5','maxlength'=>45)); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'car_no',array('class'=>'span5','maxlength'=>15)); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'weight_in',array('class'=>'span5','maxlength'=>10)); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'weight_out',array('class'=>'span5','maxlength'=>10)); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'weight_loss',array('class'=>'span5','maxlength'=>10)); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'weight_net',array('class'=>'span5','maxlength'=>10)); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'price_unit',array('class'=>'span5','maxlength'=>10)); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'material_id',array('class'=>'span5')); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'price_net',array('class'=>'span5','maxlength'=>10)); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'last_update',array('class'=>'span5')); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'update_by',array('class'=>'span5')); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'site_id',array('class'=>'span5')); ?>
</div>
<div class='row-fluid'>
	<?php echo $form->textFieldRow($model,'note',array('class'=>'span5','maxlength'=>255)); ?>
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
