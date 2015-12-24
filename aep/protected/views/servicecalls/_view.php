<?php
/* @var $this ServicecallsController */
/* @var $data Servicecalls */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('service_reference_number')); ?>:</b>
	<?php echo CHtml::encode($data->service_reference_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('engineer_email')); ?>:</b>
	<?php echo CHtml::encode($data->engineer_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('callcenter_account_id')); ?>:</b>
	<?php echo CHtml::encode($data->callcenter_account_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_fullname')); ?>:</b>
	<?php echo CHtml::encode($data->customer_fullname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_address')); ?>:</b>
	<?php echo CHtml::encode($data->customer_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_postcode')); ?>:</b>
	<?php echo CHtml::encode($data->customer_postcode); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('communications')); ?>:</b>
	<?php echo CHtml::encode($data->communications); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_recieved')); ?>:</b>
	<?php echo CHtml::encode($data->data_recieved); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_sent')); ?>:</b>
	<?php echo CHtml::encode($data->data_sent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jobstatus_id')); ?>:</b>
	<?php echo CHtml::encode($data->jobstatus_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified')); ?>:</b>
	<?php echo CHtml::encode($data->modified); ?>
	<br />

	*/ ?>

</div>