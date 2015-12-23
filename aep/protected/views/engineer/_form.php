<?php
/* @var $this EngineerController */
/* @var $model Engineer */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'engineer-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    $model->password = '';
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('style' => 'width:75%')); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model, 'company'); ?>
        <?php echo $form->textField($model, 'company', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'company'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'address'); ?>
        <?php echo $form->textArea($model, 'address', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'address'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'town'); ?>
        <?php echo $form->textField($model, 'town', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'town'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'postcode'); ?>
        <?php echo $form->textField($model, 'postcode', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'postcode'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'active'); ?>
        <?php
        echo $form->radioButtonList($model, 'active',
            array(1 => 'Yes',
                0 => 'No',),
            array(
                'labelOptions'=>array('style'=>'display:inline'), // add this code
                'separator'=>'  ',
            ) );

        ?>
        <?php echo $form->error($model, 'active'); ?>
    </div>



    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->