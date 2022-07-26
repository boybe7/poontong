<script type="text/javascript">
  
  $(function(){
      

      $( "input[id*='BuyMaterialInput_customer_id']" ).autocomplete({
       
                minLength: 0
      }).bind('focus', function () {
             //console.log("focus");
                $(this).autocomplete("search");
      });

  });
 </script>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'buy-material-input-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>  array('class'=>'well')
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class='row-fluid'>
		<div class="span2 pull-right">
			<?php echo $form->textFieldRow($model,'bill_no',array('class'=>'span12','maxlength'=>255)); ?>
		</div>	
		<div class="span2">
			<?php  	
				if(Yii::app()->user->isAdmin())
				{
					$typelist = CHtml::listData(Site::model()->findAll(),'id','name');
		   		 	echo $form->dropDownListRow($model, 'site_id', $typelist,array('class'=>'span12','ajax' => 
                            array(
                                'type'=>'POST', 
                                'url'=>CController::createUrl('Ajax/GetMaterialOption'),
                                'data'=>array('site_id' => 'js:this.value'),
                                'update'=>'#BuyMaterialInput_material_id', 
                            )), array('options' => array('site_id'=>array('selected'=>true))));  
		   		} 
		    ?>
		</div>	
	</div>
<fieldset class="scheduler-border">
    <legend class="scheduler-border"><?php $img = Yii::app()->baseUrl."/images/customer.png"; echo '<img src="'.$img.'">'; ?></legend>
<div class='row-fluid div-scheduler-border'>
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
                                        type: "B"
                                       
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
                                           $("#group_id").val(ui.item.group_id);
                                          
                                     }',
                                     //'close'=>'js:function(){$(this).val("");}',
                                     
                            ),
                           'htmlOptions'=>array(
                                'class'=>'span12'
                            ),
                                  
                        ));
            

		 ?>
	</div>
	<div class="span2">
			<label for='group_id'>ประเภท</label>
			<?php 

		 	 $typelist = array("1" => "ลูกค้ารายใหญ่", "2" => "ลูกค้ารายย่อย", "3" => "ลูกค้าประจำ");
		 	 echo CHtml::dropDownList('group_id', '',$typelist,array('class'=>'span12','empty' => '----เลือก----'));
         
			?>
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
</fieldset>

<fieldset class="scheduler-border">
    <legend class="scheduler-border"><?php $img = Yii::app()->baseUrl."/images/cargo-truck.png"; echo '<img src="'.$img.'">'; ?></legend>
<div class='row-fluid div-scheduler-border'>
	<div class="span4">
	<?php echo $form->textFieldRow($model,'car_no',array('class'=>'span12','maxlength'=>15)); ?>
	</div>
	<div class="span2">
	<?php echo $form->textFieldRow($model,'weight_in',array('class'=>'span12','maxlength'=>15)); ?>
	</div>
	<div class="span2">
	<?php echo $form->textFieldRow($model,'weight_out',array('class'=>'span12','maxlength'=>15)); ?>
	</div>
	<div class="span2">
	<?php echo $form->textFieldRow($model,'weight_loss',array('class'=>'span12','maxlength'=>15)); ?>
	</div>
	<div class="span2">
	<?php echo $form->textFieldRow($model,'weight_net',array('class'=>'span12','maxlength'=>15)); ?>
	</div>
</div>
</fieldset>
<div class='row-fluid'>
	<div class="span8">
		<?php 
		  			
            	if(!Yii::app()->user->isAdmin())
				{
					$typelist = CHtml::listData(Material::model()->findAll('site_id=:id', array(':id' => Yii::app()->user->getSite())),'id','name');
		   		 	echo $form->dropDownListRow($model, 'material_id', $typelist,array('class'=>'span12'), array('options' => array('site_id'=>array('selected'=>true))));  
		   		} 
		   		else
		   		{
		   			$typelist = CHtml::listData(Material::model()->findAll('site_id=:id', array(':id' => 1)),'id','name');
		   		 	echo $form->dropDownListRow($model, 'material_id', $typelist,array('class'=>'span12'), array('options' => array('site_id'=>array('selected'=>true))));  
		   		}

		 ?>
	</div>
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
