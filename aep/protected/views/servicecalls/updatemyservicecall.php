<?php
/* @var $this WorkcarriedoutController */
/* @var $model Workcarriedout */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'workcarriedout-updatemyservicecall-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation' => true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'product_serial_number'); ?>
		<?php echo $form->textField($model,'product_serial_number'); ?>
		<?php echo $form->error($model,'product_serial_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'spares_used'); ?>
		<?php echo $form->textField($model,'spares_used'); ?>
		<?php echo $form->error($model,'spares_used'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'first_visit_date'); ?>
		<?php echo $form->textField($model,'first_visit_date'); ?>
		<?php echo $form->error($model,'first_visit_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'job_completion_date'); ?>
		<?php echo $form->textField($model,'job_completion_date'); ?>
		<?php echo $form->error($model,'job_completion_date'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->