<style type="text/css">
	
</style>
<script type="text/javascript">
  
  $(function(){
      

      $( "input[id*='customer_id']" ).autocomplete({
       
                minLength: 0
      }).bind('focus', function () {
             //console.log("focus");
                $(this).autocomplete("search");
      });

      $( "#weight_in,#weight_out,#weight_loss" ).bind('keyup', function () {
            
            var weight = $("#weight_in").val() - $("#weight_out").val()- $("#weight_loss").val();
            
            $("#amount").val(weight)

            var price = $("#price_unit").val();
            //console.log(net+"x"+price+"="+(net*price))
            $("#price_net").val((weight*price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'))
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
			<?php echo $form->textFieldRow($model,'bill_no',array('class'=>'span12  number','maxlength'=>255)); ?>
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
		   		else{
		   			$model->site_id = Yii::app()->user->getSite();
		   			echo $form->hiddenField($model,'site_id');
		   		} 
		    ?>
		</div>	
	</div>
<fieldset class="scheduler-border">
    <legend class="scheduler-border">ลูกค้า</legend>
<div class='row-fluid div-scheduler-border'>
	<div class="span8">
		<?php 
		  			echo CHtml::activeLabelEx($model, 'customer_id');

		  			$customer = Customer::model()->findByPk($model->customer_id);
		  			$customer_address = "";
		  			$customer_group = "";
		  			$customer_phone = "";
		  			if(!empty($customer))
		  			{
		  				$customer_address = $customer->address;
		  				$customer_group = $customer->group_id;
		  				$customer_phone = $customer->phone;
		  			}
		  			echo $form->hiddenField($model,'customer_id');
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name'=>'customer_id',
                            'id'=>'customer_id',
                            'value'=>empty($customer)? '' : $customer->name,
                           'source'=>'js: function(request, response) {
                                $.ajax({
                                    url: "'.$this->createUrl('Customer/GetCustomers').'",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                        type: "S"
                                       
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
                                        
                                           $("#BuyMaterialInput_customer_id").val(ui.item.id)
                                           $("#address").val(ui.item.address)
                                           $("#phone").val(ui.item.phone)
                                           $("#group_id").val(ui.item.group_id)
                                         
                                          
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
		 	 echo CHtml::dropDownList('group_id', $customer_group,$typelist,array('class'=>'span12','empty' => '----เลือก----'));
         
			?>
	</div>
	
</div>
<div class='row-fluid'>
	<div class="span8">
		<label for='address'>ที่อยู่</label>
		<?php echo CHtml::textField('address',$customer_address,array('class'=>'span12','maxlength'=>255)); ?>
	</div>	
	<div class="span4">
		<label for='phone'>เบอร์โทร</label>
		<?php echo CHtml::textField('phone',$customer_phone,array('class'=>'span12','maxlength'=>255)); ?>
	</div>
	
</div>
</fieldset>

<fieldset class="scheduler-border">
    <legend class="scheduler-border">รายการซื้อวัตถุดิบ</legend>
	<div class='row-fluid div-scheduler-border'>

		<div class="span6"><label for="material_id">วัตถุดิบ</label>
			<?php 
			  			
	            	if(!Yii::app()->user->isAdmin())
					{
						$typelist = CHtml::listData(Material::model()->findAll('site_id=:id', array(':id' => Yii::app()->user->getSite())),'id','name');
			   		 	echo CHtml::dropDownList('material_id', "",$typelist,array('class'=>'span12','empty' => '----เลือก----')); 
			   		} 
			   		else
			   		{
			   			$typelist = CHtml::listData(Material::model()->findAll('site_id=:id', array(':id' => 1)),'id','name');
			   		 	echo CHtml::dropDownList('material_id', "",$typelist,array('class'=>'span12','empty' => '----เลือก----'));   
			   		}

			 ?>
		</div>
		<div class='span2'><label for="price_unit">ราคา/หน่วย</label>
			<?php 
			   echo CHtml::textField('price_unit','',array('class'=>'span12 number','maxlength'=>10)); 
			?>
		</div>
	</div>
	<div class="row-fluid">	
		<div class='span2'><label for="weight_in">นน.เข้า</label>
			<?php 
			   echo CHtml::textField('weight_in','',array('class'=>'span12 number','maxlength'=>10)); 
			?>
		</div>
		<div class='span2'><label for="weight_out">นน.ออก</label>
			<?php 
			   echo CHtml::textField('weight_out','',array('class'=>'span12 number','maxlength'=>10)); 
			?>
		</div>
		<div class='span2'><label for="weight_loss">ของเสีย</label>
			<?php 
			   echo CHtml::textField('weight_loss','',array('class'=>'span12 number','maxlength'=>10)); 
			?>
		</div>
		<div class='span2'><label for="amount">นน.สุทธิ</label>
			<?php 
			   echo CHtml::textField('amount','',array('class'=>'span12 number','maxlength'=>10,'disabled'=>true)); 
			?>
		</div>
		<div class='span2'><label for="price_net">ราคารวม</label>
			<?php echo CHtml::textField('price_net',"",array('class'=>'span12 number','maxlength'=>10,'disabled'=>true)); ?>
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
										url: "' .CController::createUrl('BuyMaterialInput/CreateItemDetailTemp'). '",										
										data: {
	                                        material_id: $("#material_id").val(),
	                                        price_unit: $("#price_unit").val(),
	                                        price_net: $("#price_net").val(),
	                                        weight_in: $("#weight_in").val(),
	                                        weight_out: $("#weight_out").val(),
	                                        weight_loss: $("#weight_loss").val(),
	                                        amount:$("#amount").val()
                                       
                                    	}
									})									
									.done(function( msg ) {
													
										// jQuery.fn.yiiGridView.update("buy-item-grid");
										$("#buy-item-grid").yiiGridView("update",{});

										$("#material_id").val(""),
	                                    $("#price_unit").val(""),
	                                    $("#price_net").val(""),
	                                    $("#amount").val("")
	                                    $("#weight_in").val("")
	                                    $("#weight_out").val("")
	                                    $("#weight_loss").val("")
                                                                             
									})	
													
							',
					                
			              ),
			          ));

			?>
		</div>
	</div>
	<div>
		<?php

		$modelTemp = new BuyMaterialDetailTemp;
			$this->widget('bootstrap.widgets.TbGridView',array(
					'id'=>'buy-item-grid',
					
				    'type'=>'bordered condensed',
					'dataProvider'=>$modelTemp->search(),
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
					  	    'price_unit'=>array(
					  	    	
								'name' => 'price_unit',
								'class' => 'editable.EditableColumn',
								'editable' => array( //editable section
								
									'title'=>'แก้ไข ',
									'url' => $this->createUrl('BuyMaterialInput/updateDetailTemp'),
									'success' => 'js: function(response, newValue) {
														if(!response.success) return response.msg;

														$("#buy-item-grid").yiiGridView("update",{});
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
						  	'weight_in'=>array(
								'name' => 'weight_in',
								'class' => 'editable.EditableColumn',
								'editable' => array( //editable section
								
									'title'=>'แก้ไข ',
									'url' => $this->createUrl('BuyMaterialInput/updateDetailTemp'),
									'success' => 'js: function(response, newValue) {
														if(!response.success) return response.msg;

														$("#buy-item-grid").yiiGridView("update",{});
													}',
									'options' => array(
										'ajaxOptions' => array('dataType' => 'json'),

									), 
									'placement' => 'right'
									
								),
								'filter'=> false,
								'value' => function($model){
									
									return number_format($model->weight_in,2);
								 },
								'headerHtmlOptions' => array('style' => 'width:7%;text-align:center;background-color: #f5f5f5'),  	            	  	
								'htmlOptions'=>array('style'=>'text-align:right')
						  	),
						  	'weight_out'=>array(
					  	    	
								'name' => 'weight_out',
								'class' => 'editable.EditableColumn',

								'value' => function($model){
									
									return number_format($model->weight_out,2);
								 },
								'editable' => array( //editable section
								
									'title'=>'แก้ไข ',
									'url' => $this->createUrl('BuyMaterialInput/updateDetailTemp'),
									'success' => 'js: function(response, newValue) {
														if(!response.success) return response.msg;

														$("#buy-item-grid").yiiGridView("update",{});
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
						  	'weight_loss'=>array(
								'name' => 'weight_loss',
								'class' => 'editable.EditableColumn',
								'editable' => array( //editable section
								
									'title'=>'แก้ไข ',
									'url' => $this->createUrl('BuyMaterialInput/updateDetailTemp'),
									'success' => 'js: function(response, newValue) {
														if(!response.success) return response.msg;

														$("#buy-item-grid").yiiGridView("update",{});
													}',
									'options' => array(
										'ajaxOptions' => array('dataType' => 'json'),

									), 
									'placement' => 'right'
									
								),
								'filter'=> false,
								'value' => function($model){
									
									return number_format($model->weight_loss,2);
								 },
								'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #f5f5f5'),  	            	  	
								'htmlOptions'=>array('style'=>'text-align:right')
						  	),
						  	'amount'=>array(
								'name' => 'amount',
								// 'class' => 'editable.EditableColumn',
								// 'editable' => array( //editable section
								
								// 	'title'=>'แก้ไข ',
								// 	'url' => $this->createUrl('BuyMaterialInput/updateDetailTemp'),
								// 	'success' => 'js: function(response, newValue) {
								// 						if(!response.success) return response.msg;

								// 						$("#buy-item-grid").yiiGridView("update",{});
								// 					}',
								// 	'options' => array(
								// 		'ajaxOptions' => array('dataType' => 'json'),

								// 	), 
								// 	'placement' => 'right'
									
								// ),
								'filter'=> false,
								'value' => function($model){
									
									return number_format($model->amount,2);
								 },
								'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
								'htmlOptions'=>array('style'=>'text-align:right')
						  	),
						  	'price_net'=>array(
								'name' => 'price_net',
								// 'class' => 'editable.EditableColumn',
								// 'editable' => array( //editable section
								
								// 	'title'=>'แก้ไข ',
								// 	'url' => $this->createUrl('BuyMaterialInput/updateDetailTemp'),
								// 	'success' => 'js: function(response, newValue) {
								// 						if(!response.success) return response.msg;

								// 						$("#buy-item-grid").yiiGridView("update",{});
								// 					}',
								// 	'options' => array(
								// 		'ajaxOptions' => array('dataType' => 'json'),

								// 	), 
								// 	'placement' => 'right'
									
								// ),
								'filter'=> false,
								'value' => function($model){
									
									return number_format($model->price_net,2);
								 },
								'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
								'htmlOptions'=>array('style'=>'text-align:right'),
								'footer'=>number_format($modelTemp->getTotals($modelTemp->search()),2),
								'footerHtmlOptions'=>array('style' => 'font-weight:bold;text-align:right;background-color: #ffe7e7'),
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
</fieldset>	


<div class='row-fluid'>
	<?php echo $form->textAreaRow($model,'note',array('rows'=>5, 'cols'=>50, 'class'=>'span12','maxlength'=>255)); ?>
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


<?php

Yii::app()->clientScript->registerScript('loadMaterialPrice', '
$( "#group_id,#material_id,#amount").bind("change", function () {
            var group_customer = $("#group_id").val();
            var material_id = $("#material_id").val();

            var _url = "' . Yii::app()->controller->createUrl("Material/GetPrice").'" ;
            if(group_customer!="" || material_id!="")
            {
            	$.ajax({
			        url: _url,
			        data : {group_customer:group_customer,material_id:material_id},
			        success:function(response){
			                              
			              $("#price_unit").val(response)
			              var net = $("#amount").val();
			              var price = response;
            			  $("#price_net").val((net*price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,"))
			        }

			    });
            }
});


', CClientScript::POS_END);

?>

