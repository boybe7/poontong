<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit')); ?>:</b>
	<?php echo CHtml::encode($data->unit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_compressed')); ?>:</b>
	<?php echo CHtml::encode($data->is_compressed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('have_label')); ?>:</b>
	<?php echo CHtml::encode($data->have_label); ?>
	<br />


</div>