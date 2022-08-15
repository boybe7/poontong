<script type="text/javascript">
  
  $(function(){
      

      $( "input[id*='customer_id']" ).autocomplete({
       
                minLength: 0
      }).bind('focus', function () {
             //console.log("focus");
                $(this).autocomplete("search");
      });

      $( "#BuyMaterialInput_weight_in,#BuyMaterialInput_weight_out,#BuyMaterialInput_weight_loss,#BuyMaterialInput_percent_mixed,#BuyMaterialInput_percent_moisture" ).bind('keyup', function () {
            //var net = $("#BuyMaterialInput_weight_in").val() - $("#BuyMaterialInput_weight_out").val() - $("#BuyMaterialInput_weight_loss").val();

            var weight = $("#BuyMaterialInput_weight_in").val() - $("#BuyMaterialInput_weight_out").val();
            var mixed = 0;
            var moisture = 0;
            if($("#BuyMaterialInput_percent_mixed").val()!="" && $("#BuyMaterialInput_percent_mixed").val()!=0)
            	mixed = $("#BuyMaterialInput_percent_mixed").val()/100.00;
            
            if($("#BuyMaterialInput_percent_moisture").val()!="" && $("#BuyMaterialInput_percent_moisture").val()!=0)
            	moisture = $("#BuyMaterialInput_percent_moisture").val()/100.00;
            
            var net = weight - weight*mixed - weight*moisture;



            
            $("#BuyMaterialInput_weight_net").val(net)

            var price = $("#BuyMaterialInput_price_unit").val();
            //console.log(net+"x"+price+"="+(net*price))
            $("#BuyMaterialInput_price_net").val((net*price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'))
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
    <legend class="scheduler-border"><?php $img = Yii::app()->baseUrl."/images/customer.png"; echo '<img src="'.$img.'">'; ?></legend>
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
    <legend class="scheduler-border"><?php $img = Yii::app()->baseUrl."/images/cargo-truck.png"; echo '<img src="'.$img.'">'; ?></legend>
<div class='row-fluid div-scheduler-border'>
	<div class="span4">
	<?php echo $form->textFieldRow($model,'car_no',array('class'=>'span12','maxlength'=>15)); ?>
	</div>
	<div class="span2">
	<?php echo $form->textFieldRow($model,'weight_in',array('class'=>'span12 number','maxlength'=>15)); ?>
	</div>
	<div class="span2">
	<?php echo $form->textFieldRow($model,'weight_out',array('class'=>'span12  number','maxlength'=>15)); ?>
	</div>
	<div class="span1">
	<?php echo $form->textFieldRow($model,'percent_mixed',array('class'=>'span12  number','maxlength'=>15)); ?>
	</div>
	<div class="span1">
	<?php echo $form->textFieldRow($model,'percent_moisture',array('class'=>'span12  number','maxlength'=>15)); ?>
	</div>
	<div class="span2">
	<?php echo $form->textFieldRow($model,'weight_net',array('class'=>'span12  number','maxlength'=>15)); ?>
	</div>
</div>
</fieldset>
<div class='row-fluid'>
	<div class="span7">
		<?php 
		  			
            	if(!Yii::app()->user->isAdmin())
				{
					$typelist = CHtml::listData(Material::model()->findAll('site_id=:id', array(':id' => Yii::app()->user->getSite())),'id','name');
		   		 	echo $form->dropDownListRow($model, 'material_id', $typelist,array('class'=>'span12','empty'=>'--เลือก--',), array('options' => array('site_id'=>array('selected'=>true))));  
		   		} 
		   		else
		   		{
		   			$typelist = CHtml::listData(Material::model()->findAll('site_id=:id', array(':id' => 1)),'id','name');
		   		 	echo $form->dropDownListRow($model, 'material_id', $typelist,array('class'=>'span12','empty'=>'--เลือก--'), array('options' => array('site_id'=>array('selected'=>true))));  
		   		}

		 ?>
	</div>
	<div class='span2'>
		<?php echo $form->textFieldRow($model,'price_unit',array('class'=>'span12 number','maxlength'=>10)); ?>
	</div>
	<div class='span3'>
		<?php echo $form->textFieldRow($model,'price_net',array('class'=>'span12 number','maxlength'=>10)); ?>
	</div>
</div>

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
	          		'url'=>array('admin'), 
			  	));

			  	?>
		</div>
	  </div>

<?php $this->endWidget(); ?>


<?php

Yii::app()->clientScript->registerScript('loadMaterialPrice', '
$( "#group_id,#BuyMaterialInput_material_id" ).bind("change", function () {
            var group_customer = $("#group_id").val();
            var material_id = $("#BuyMaterialInput_material_id").val();

            var _url = "' . Yii::app()->controller->createUrl("Material/GetPrice").'" ;
            if(group_customer!="" && material_id!="")
            {
            	$.ajax({
			        url: _url,
			        data : {group_customer:group_customer,material_id:material_id},
			        success:function(response){
			                              
			              $("#BuyMaterialInput_price_unit").val(response)
			              var net = $("#BuyMaterialInput_weight_net").val();
			              var price = response;
            			  $("#BuyMaterialInput_price_net").val((net*price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,"))
			        }

			    });
            }
});


', CClientScript::POS_END);

?>

