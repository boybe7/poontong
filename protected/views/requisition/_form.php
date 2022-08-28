<script type="text/javascript">
	$(function(){
		$( "#Requisition_amount,#Requisition_sack,#Requisition_bigbag" ).bind('keyup', function () {
			if($("#Requisition_amount").val()>$("#stock_amount").val())
			{	alert("ไม่ควรกรอกเกิน stock");  $("#Requisition_amount").val("")}
			if($("#Requisition_sack").val()>$("#stock_sack").val())
			{	alert("ไม่ควรกรอกเกิน stock"); $("#Requisition_sack").val("")}
			if($("#Requisition_bigbag").val()>$("#stock_bigbag").val())
			{	alert("ไม่ควรกรอกเกิน stock"); $("#Requisition_bigbag").val("")}

			//console.log($("#stock_amount").val())
		});

	});
</script>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'requisition-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>  array('class'=>'well')
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<div class='row-fluid'>
	<div class='span6'>
		<?php
			echo $form->textFieldRow($model,'username',array('class'=>'span12','maxlength'=>255));  
		?>
	</div>
	<div class='span6'>
		<?php
			echo $form->labelEx($model,'create_date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;')); 

                 
                        echo '<div class="input-append" style="margin-top:-10px;">'; //ใส่ icon ลงไป
                            $form->widget('zii.widgets.jui.CJuiDatePicker',

                            array(
                                'name'=>'create_date',
                                'attribute'=>'create_date',
                                'model'=>$model,
                                'options' => array(
                                                  'mode'=>'focus',
                                                  //'language' => 'th',
                                                  'format'=>'dd/mm/yyyy', //กำหนด date Format
                                                  'showAnim' => 'slideDown',
                                                  ),
                                'htmlOptions'=>array('class'=>'span12', 'value'=>$model->create_date),  // ใส่ค่าเดิม ในเหตุการ Update 
                             )
                        );
                        echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';  
		?>
	</div>
</div>
<div class='row-fluid'>
	<div class='span6'>
		<?php 

		$typelist = CHtml::listData(Material::model()->findAll('site_id=:id', array(':id' => Yii::app()->user->getSite())),'id','name');
		echo $form->dropDownListRow($model, 'material_id', $typelist,array('class'=>'span12','empty' => '----เลือก----','ajax' => array(
                                'type'=>'GET', 
                                'url'=>CController::createUrl('Stock/GetStock'),
                                'data'=>array('material_id' => 'js:this.value'),
                                'success'=>'function(data){
                                		response = JSON.parse(data);
                                		$("#stock_amount").val(response.amount)
                                		$("#stock_sack").val(response.sack)
                                		$("#stock_bigbag").val(response.bigbag)
                                }', 
                            )), array('options' => array('material_id'=>array('selected'=>true))));

		?>
	</div>
	<div class='span3'>
		<?php 

		$typelist = CHtml::listData(Process::model()->findAll('site_id=:id', array(':id' => Yii::app()->user->getSite())),'id','name');
		echo $form->dropDownListRow($model, 'process', $typelist,array('class'=>'span12'), array('options' => array('process'=>array('selected'=>true))));
		?>
	</div>
</div>
<div class='row-fluid'>
		<div class='span3'><label for="stock_amount">Stock จำนวน กก.</label>
			<?php 
			$stock = Stock::model()->findAll('material_id='.$model->material_id);
			$stock_amount = empty($stock)? 0 : $stock[0]->amount;
			$stock_sack = empty($stock)? 0 : $stock[0]->sack;
			$stock_bigbag = empty($stock)? 0 : $stock[0]->bigbag;
			echo CHtml::textField('stock_amount',$stock_amount,array('class'=>'span12 number','maxlength'=>10,'disabled'=>true));  ?>
		</div>
		<div class='span3'><label for="stock_sack">Stock จำนวน กระสอบ</label>
			<?php echo CHtml::textField('stock_sack',$stock_sack,array('class'=>'span12 number','maxlength'=>10,'disabled'=>true));  ?>
		</div>
		<div class='span3'><label for="stock_bigbag">Stock จำนวน bigbag</label>
			<?php echo CHtml::textField('stock_bigbag',$stock_bigbag,array('class'=>'span12 number','maxlength'=>10,'disabled'=>true));  ?>
		</div>
</div>
<div class='row-fluid'>
		<div class='span3'>
			<?php echo $form->textFieldRow($model,'amount',array('class'=>'span12 number','maxlength'=>15)); ?>
		</div>
		<div class='span3'>
			<?php echo $form->textFieldRow($model,'sack',array('class'=>'span12 number')); ?>
		</div>
		<div class='span3'>
			<?php echo $form->textFieldRow($model,'bigbag',array('class'=>'span12 number')); ?>
		</div>
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
	          		'url'=>array('index'), 
			  	));

			  	?>
		</div>
	  </div>

<?php $this->endWidget(); ?>
