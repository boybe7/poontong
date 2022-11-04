<?php
$this->breadcrumbs=array(
	'สิทธิการเข้าถึงข้อมูล',
);

?>

<script type="text/javascript">
	$(function(){
        //autocomplete search on focus    	
		    $("#user_group").autocomplete({
	       
	                minLength: 0
	            }).bind('focus', function () {
	                $(this).autocomplete("search");
	      });
	 
	  });
</script>
<div class="well">
<h4>สิทธิการเข้าถึงข้อมูล</h4>

<?php
        $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'project-form',
            'enableAjaxValidation'=>false,
            'type'=>'vertical',
            'htmlOptions'=>  array('class'=>'','style'=>''),
        )); 
 echo $form->errorSummary($model);

        ?>

<div class="row-fluid">
	<div class="span3" style="text-align:right;font-weight:bold;font-size:15px;font-family: 'Boon700',sans-serif;">กลุ่มผู้ใช้งาน :</div>
	<div class="span9">
		<?php

						echo $form->hiddenField($model,'id');
                        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name'=>'user_group',
                            'id'=>'user_group',
                           // 'value'=>$model->pj_name,
                           // 'source'=>$this->createUrl('Ajax/GetDrug'),
                           'source'=>'js: function(request, response) {
                                $.ajax({
                                    url: "'.$this->createUrl('getGroup').'",
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
                                           $("input:checkbox").each(function () {

                                                  $(this).removeAttr("checked");

                                              });

                                           $.each(ui.item.rules, function( index, value ) {
                                              //console.log(  value["menu_id"] + ":" + value["access"] );
                                              name = "input:radio[name=authen_rule_"+value["menu_id"]+"][value="+value["access"]+"]";
                                              //$(name).attr("checked",true);

                                              name = "input[name=authen_rule_"+value["menu_id"]+"][value="+value["access"]+"]";
                                              $(name).prop("checked",true);
                                              
                                            });
                                           
                                     }',
                                     //'close'=>'js:function(){$(this).val("");}',
                                     
                            ),
                           'htmlOptions'=>array(
                                'class'=>'span6'
                            ),
                                  
                        ));

		?>
	</div>
</div>
<div class="row-fluid">
    <div class="span3" style="text-align:right;font-weight:bold;font-size:15px;font-family: 'Boon700',sans-serif;">เลือกสิทธิให้กลุ่มผู้ใช้งาน :</div>
    <div class="span9" id="list">
         
    <?php
       
            $menus = Menu::model()->findAll();
            foreach ($menus as $key => $menu) {
                    //echo '<input type="checkbox" id="authen_rule_'.$menu->id.'"  name="authen_rule_'.$menu->id.'"  value="2">';
                    //echo '<label for="authen_rule_'.$menu->id.'" >'.$menu->title.'</label>';
                    
                    echo ' <label class="checkbox">
                                <input type="checkbox" id="authen_rule_'.$menu->id.'"  name="authen_rule_'.$menu->id.'"  value="2"> '.$menu->title.'
                            </label>';
                
                
            }
            
       

    ?>
         
    </div>
</div>

            <div class="form-actions">
                <?php 
                

                $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'type'=>'primary',
                    'htmlOptions'=>array('class'=>'pull-right'),
                    'label'=>$model->isNewRecord ? 'บันทึก' : 'บันทึก',
                )); ?>
            </div>
 </div>           
  <?php $this->endWidget(); ?>