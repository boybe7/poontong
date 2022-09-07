<?php
$this->breadcrumbs=array(
	'ประเภทลูกค้า'=>array('index'),
	'Manage',
);

?>

<h3>ประเภทลูกค้า</h3>
<center>
<div class="row-fluid">	
		<div class='offset3 span4'><label for="name"></label>
			<?php 
			   echo CHtml::textField('name','',array('class'=>'span12 ')); 
			?>
		</div>
		<div class='span2'>
			<?php



					$this->widget('bootstrap.widgets.TbButton', array(
			              'buttonType'=>'link',
			              
			              'type'=>'success',
			              'label'=>'เพิ่มประเภท',
			              'icon'=>'plus-sign',
			              //'url'=> CController::createUrl('MaterialGroup/create'),
			              'htmlOptions'=>array(
			                'class'=>'span12',
			                'style'=>'margin:5px 0px 0px 0px;',
						    'onclick'=>'
						           
								$.ajax({
										type: "POST",
										url: "' .CController::createUrl('CustomerGroup/create'). '",										
										data: {
	                                        name: $("#name").val()                                                                             
                                    	}
									})									
									.done(function( msg ) {
										$("#customer-group-grid").yiiGridView("update",{});
									});									
								
													
							',
					                
			              ),
			          ));

			?>
		</div>
</div>
<div class="row-fluid">
	<div class="offset3 span6">
<?php 


    $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'customer-group-grid',
	'dataProvider'=>$model->search(),
	'type'=>'bordered condensed',
	'filter'=>$model,
	'selectableRows' =>2,
	'htmlOptions'=>array('style'=>'padding-top:10px;width:100%'),
    'enablePagination' => true,
    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
    'template'=>'{items}<div class=\"row-fluid\"><div class=\"span6\">{summary}</div></div>',
	'columns'=>array(
	
		'name'=>array(
			'name' => 'name',
			'class' => 'editable.EditableColumn',
			'editable' => array( //editable section
								
									'title'=>'แก้ไข ',
									'url' => $this->createUrl('CustomerGroup/update'),
									'success' => 'js: function(response, newValue) {
														if(!response.success) return response.msg;

														$("#customer-group-grid").yiiGridView("update",{});
													}',
									'options' => array(
										'ajaxOptions' => array('dataType' => 'json'),

									), 
									'placement' => 'right',
					
									
			),
			//'filter'=> false,
			'headerHtmlOptions' => array('style' => 'width:90%;text-align:center;background-color: #f5f5f5'),  	            	  	
			'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		array(
			'header' => '<a class="sort-link"></a>',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),
			'template' => '{delete}'
		),
	),
)); ?>
	</div>
</div>
</center>