<?php
/* @var $this ServicecallsController */
/* @var $model Servicecalls */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'service_reference_number'); ?>
		<?php echo $form->textField($model,'service_reference_number'); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model,'customer_fullname'); ?>
		<?php echo $form->textArea($model,'customer_fullname',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'customer_address'); ?>
		<?php echo $form->textArea($model,'customer_address',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'customer_postcode'); ?>
		<?php echo $form->textArea($model,'customer_postcode',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'communications'); ?>
		<?php echo $form->textArea($model,'communications',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'data_recieved'); ?>
		<?php echo $form->textArea($model,'data_recieved',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'data_sent'); ?>
		<?php echo $form->textArea($model,'data_sent',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'jobstatus_id'); ?>
		<?php echo $form->textField($model,'jobstatus_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modified'); ?>
		<?php echo $form->textField($model,'modified'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->