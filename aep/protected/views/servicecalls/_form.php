<?php
/* @var $this ServicecallsController */
/* @var $model Servicecalls */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'servicecalls-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'service_reference_number'); ?>
		<?php echo $form->textField($model,'service_reference_number'); ?>
		<?php echo $form->error($model,'service_reference_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'engineer_email'); ?>
		<?php echo $form->textArea($model,'engineer_email',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'engineer_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'callcenter_account_id'); ?>
		<?php echo $form->textArea($model,'callcenter_account_id',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'callcenter_account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_fullname'); ?>
		<?php echo $form->textArea($model,'customer_fullname',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'customer_fullname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_address'); ?>
		<?php echo $form->textArea($model,'customer_address',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'customer_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_postcode'); ?>
		<?php echo $form->textArea($model,'customer_postcode',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'customer_postcode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'communications'); ?>
		<?php echo $form->textArea($model,'communications',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'communications'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'data_recieved'); ?>
		<?php echo $form->textArea($model,'data_recieved',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'data_recieved'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'data_sent'); ?>
		<?php echo $form->textArea($model,'data_sent',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'data_sent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'jobstatus_id'); ?>
		<?php echo $form->textField($model,'jobstatus_id'); ?>
		<?php echo $form->error($model,'jobstatus_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modified'); ?>
		<?php echo $form->textField($model,'modified'); ?>
		<?php echo $form->error($model,'modified'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->