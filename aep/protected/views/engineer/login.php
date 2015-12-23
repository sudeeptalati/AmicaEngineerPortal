<h1>Engineer Login</h1>


<?php
/**
 * Created by PhpStorm.
 * User: sudeeptalati
 * Date: 22/12/2015
 * Time: 15:25
 */
?>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'engineer-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
)); ?>

<?php if ($message != ''): ?>
    <div class="infobox">
    <?php echo $message; ?>
</div>
<?php endif; ?>

<div class="row">
    <?php echo $form->labelEx($model,'email'); ?>
    <?php echo $form->textField($model,'email',array('rows'=>6, 'cols'=>50)); ?>
    <?php echo $form->error($model,'email'); ?>
</div>
<div class="row">
    <?php echo $form->labelEx($model,'password'); ?>
    <?php echo $form->passwordField($model,'password',array('rows'=>6, 'cols'=>50)); ?>
    <?php echo $form->error($model,'password'); ?>
</div>
<div class="row buttons">
    <?php echo CHtml::submitButton('Login'); ?>
</div>

<?php $this->endWidget(); ?>