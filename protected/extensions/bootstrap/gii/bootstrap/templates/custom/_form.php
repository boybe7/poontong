<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php \$form=\$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>  array('class'=>'well')
)); ?>\n"; ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php
foreach($this->tableSchema->columns as $column)
{
	if($column->autoIncrement)
		continue;
?>
<div class='row-fluid'>
	<?php echo "<?php echo ".$this->generateActiveRow($this->modelClass,$column)."; ?>\n"; ?>
</div>
<?php
}
?>

	<div class="row-fluid">
		<div class="span12 form-actions ">
			<?php 
	     		
	     	echo "<?php	\$this->widget('bootstrap.widgets.TbButton', array(
			         'buttonType'=>'submit',
			         'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 10px 0px 10px;'),
			         'type'=>'primary',
			         'label'=>'บันทึก',              
			    ));\n"; 

			    
	      	echo "	\$this->widget('bootstrap.widgets.TbButton', array(
				   'buttonType'=>'link',
				   'type'=>'danger',
				   'label'=>'ยกเลิก',
	         		'htmlOptions'=>array('class'=>'pull-right'),               
	          		'url'=>array('admin'), 
			  	));

			  	?>\n"; 
	         
	    ?>
		</div>
	  </div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
