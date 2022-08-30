<script type="text/javascript">
	$(function(){
		$( "#RequisitionDetailTemp_amount,#RequisitionDetailTemp_sack,#RequisitionDetailTemp_bigbag" ).bind('keyup', function () {
			if(parseFloat($("#RequisitionDetailTemp_amount").val())>$("#stock_amount").val())
			{	alert("ไม่ควรกรอกเกิน stock");  $("#RequisitionDetailTemp_amount").val("")}
			if($("#RequisitionDetailTemp_sack").val()>$("#stock_sack").val())
			{	alert("ไม่ควรกรอกเกิน stock"); $("#RequisitionDetailTemp_sack").val("")}
			if($("#RequisitionDetailTemp_bigbag").val()>$("#stock_bigbag").val())
			{	alert("ไม่ควรกรอกเกิน stock"); $("#RequisitionDetailTemp_bigbag").val("")}

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
	<div class='span4'>
		<?php
			echo $form->textFieldRow($model,'username',array('class'=>'span12','maxlength'=>255));  
		?>
	</div>
	<div class='span3'>
		<?php 

		$typelist = CHtml::listData(Process::model()->findAll('site_id=:id', array(':id' => Yii::app()->user->getSite())),'id','name');
		echo $form->dropDownListRow($model, 'process', $typelist,array('class'=>'span12'), array('options' => array('process'=>array('selected'=>true))));
		?>
	</div>
	<div class='span4'>
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
	<div class='span4'>
		<?php 

		$typelist = CHtml::listData(Material::model()->findAll('site_id=:id', array(':id' => Yii::app()->user->getSite())),'id','name');
		echo $form->dropDownListRow($modelDetail, 'material_id', $typelist,array('class'=>'span12','empty' => '----เลือก----','ajax' => array(
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
	

		<div class='span2'><label for="stock_amount">Stock จำนวน กก.</label>
			<?php 

			$stock = '';
			if($modelDetail->material_id!='')
				$stock = Stock::model()->findAll('material_id='.$modelDetail->material_id);
			$stock_amount = empty($stock)? 0 : $stock[0]->amount;
			$stock_sack = empty($stock)? 0 : $stock[0]->sack;
			$stock_bigbag = empty($stock)? 0 : $stock[0]->bigbag;
			echo CHtml::textField('stock_amount',$stock_amount,array('class'=>'span12 number','maxlength'=>10,'disabled'=>true));  ?>
		</div>
		<div class='span2'><label for="stock_sack">Stock จำนวน กระสอบ</label>
			<?php echo CHtml::textField('stock_sack',$stock_sack,array('class'=>'span12 number','maxlength'=>10,'disabled'=>true));  ?>
		</div>
		<div class='span2'><label for="stock_bigbag">Stock จำนวน bigbag</label>
			<?php echo CHtml::textField('stock_bigbag',$stock_bigbag,array('class'=>'span12 number','maxlength'=>10,'disabled'=>true));  ?>
		</div>
</div>
<div class='row-fluid'>
		<div class='offset4 span2'>
			<?php echo $form->textFieldRow($modelDetail,'amount',array('class'=>'span12 number','maxlength'=>15)); ?>
		</div>
		<div class='span2'>
			<?php echo $form->textFieldRow($modelDetail,'sack',array('class'=>'span12 number')); ?>
		</div>
		<div class='span2'>
			<?php echo $form->textFieldRow($modelDetail,'bigbag',array('class'=>'span12 number')); ?>
		</div>
		<div class='span2'>
			<?php

					$this->widget('bootstrap.widgets.TbButton', array(
			              'buttonType'=>'link',
			              
			              'type'=>'success',
			              'label'=>'เพิ่มรายการ',
			              'icon'=>'plus-sign',
			              
			              'htmlOptions'=>array(
			                'class'=>'',
			                'style'=>'margin:25px 0px 0px 0px;',
						    'onclick'=>'
						           
								$.ajax({
										type: "POST",
										url: "' .CController::createUrl('Requisition/CreateItemDetailTemp'). '",										
										data: {
	                                        material_id: $("#RequisitionDetailTemp_material_id").val(),
	                                        sack: $("#RequisitionDetailTemp_sack").val(),
	                                        bigbag: $("#RequisitionDetailTemp_bigbag").val(),
	                                        amount:$("#RequisitionDetailTemp_amount").val()
                                       
                                    	}
									})									
									.done(function( msg ) {
													
										$("#requisition-item-grid").yiiGridView("update",{});

										$("#RequisitionDetailTemp_material_id").val(""),
	                                    $("#RequisitionDetailTemp_sack").val(""),
	                                    $("#RequisitionDetailTemp_bigbag").val(""),
	                                    $("#RequisitionDetailTemp_amount").val("")
                                                                             
									})	
													
							',
					                
			              ),
			          ));

			?>
		</div>
</div>	

<div>
		<?php

		
			$this->widget('bootstrap.widgets.TbGridView',array(
					'id'=>'requisition-item-grid',
					
				    'type'=>'bordered condensed',
					'dataProvider'=>$modelDetail->search(),
					//'filter'=>$model,
					'selectableRows' => 2,
					'enableSorting' => false,
					'rowCssClassExpression'=>'($row == 0) ? "hidden_row" : "" ',
				    'htmlOptions'=>array('style'=>'padding-top:10px;'),
				    'enablePagination' => true,
				    'summaryText'=>'',//'Displaying {start}-{end} of {count} results.',
					'columns'=>array(
						  //   'No.'=>array(
						  //       'header'=>'ลำดับ',
						  //       'headerHtmlOptions' => array('style' => 'width:3%;text-align:center;background-color: #eeeeee'),  	            	  		
								// 'htmlOptions'=>array(
	  	    //         	  			'style'=>'text-align:center'

	  	    //     				),
						  //       'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row)',
						  //     ),
							'material_id'=>array(
								'name' => 'material_id',
								'value' => function($model){
									$m =  Material::model()->FindByPk($model->material_id);
									return empty($m) ? "" : $m->name;
								 },
								'filter'=>false, 
								'headerHtmlOptions' => array('style' => 'width:18%;text-align:center;background-color: #f5f5f5'),  	            	  	
								'htmlOptions'=>array('style'=>'text-align:left')
						  	),
					  	    'amount'=>array(
					  	    	
								'name' => 'amount',
								'class' => 'editable.EditableColumn',
								'editable' => array( //editable section
								
									'title'=>'แก้ไข ',
									'url' => $this->createUrl('Requisition/updateDetailTemp'),
									'success' => 'js: function(response, newValue) {
														if(!response.success) return response.msg;

														$("#requisition-item-grid").yiiGridView("update",{});
													}',
									'options' => array(
										'ajaxOptions' => array('dataType' => 'json'),

									), 
									'placement' => 'right',
					
									
								),
								'filter'=> false,
								'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #f5f5f5'),  	            	  	
								'htmlOptions'=>array('style'=>'text-align:right')
						  	),
						  	'sack'=>array(
								'name' => 'sack',
								'class' => 'editable.EditableColumn',
								'editable' => array( //editable section
								
									'title'=>'แก้ไข ',
									'url' => $this->createUrl('Requisition/updateDetailTemp'),
									'success' => 'js: function(response, newValue) {
														if(!response.success) return response.msg;

														$("#requisition-item-grid").yiiGridView("update",{});
													}',
									'options' => array(
										'ajaxOptions' => array('dataType' => 'json'),

									), 
									'placement' => 'right'
									
								),
								'filter'=> false,
								'value' => function($model){
									
									return number_format($model->sack);
								 },
								'headerHtmlOptions' => array('style' => 'width:7%;text-align:center;background-color: #f5f5f5'),  	            	  	
								'htmlOptions'=>array('style'=>'text-align:right')
						  	),
						  	'bigbag'=>array(
					  	    	
								'name' => 'bigbag',
								'class' => 'editable.EditableColumn',

								'value' => function($model){
									
									return number_format($model->bigbag);
								 },
								'editable' => array( //editable section
								
									'title'=>'แก้ไข ',
									'url' => $this->createUrl('Requisition/updateDetailTemp'),
									'success' => 'js: function(response, newValue) {

														//console.log(response)
														if(!response.success) return response.msg;

														$("#requisition-item-grid").yiiGridView("update",{});
													}',
									'options' => array(
										'ajaxOptions' => array('dataType' => 'json'),

									), 
									'placement' => 'right',
					
									
								),
								'filter'=> false,
								'headerHtmlOptions' => array('style' => 'width:7%;text-align:center;background-color: #f5f5f5'),  	            	  	
								'htmlOptions'=>array('style'=>'text-align:right')
						  	),
						  
					  	   
					  	    array(
								'class'=>'bootstrap.widgets.TbButtonColumn',
								'headerHtmlOptions' => array('style' => 'width:2%;text-align:center;background-color: #eeeeee'),
								'template' => '{delete}',
								// 'deleteConfirmation'=>'js:bootbox.confirm("Are you sure to want to delete")',
								'buttons'=>array(
										'delete'=>array(
											'url'=>'Yii::app()->createUrl("BuyMaterialInput/deleteDetailTemp", array("id"=>$data->id))',	

										),
										

									)

								
							),
						)

					));







		?>
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
