<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
$this->breadcrumbs=array(
	UserModule::t("Login"),
);
$model->rememberMe=true;
?>


<div style="float:right;">	
	<a target="_blank" href="https://rapportsoftware.freshdesk.com/support/solutions/9000106881" title='Help'>		
		<span  class="fa fa-question-circle fa-3x" ></span>
	</a>
</div>
<h1><?php echo UserModule::t("Secondary Login"); ?></h1>
<table style="width:50%" >
	<tr>
		<td>
			<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

			<div class="success">
				<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
			</div>

			<?php endif; ?>

			<p><?php echo UserModule::t("Please fill out the following form with your login credentials:"); ?>
				
			</p>

			<div class="form">
			<?php echo CHtml::beginForm(); ?>

			<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

			<?php echo CHtml::errorSummary($model); ?>

			<div class="row">
				<?php echo CHtml::activeLabelEx($model,'username'); ?>
				<?php echo CHtml::activeTextField($model,'username') ?>
			</div>

			<div class="row">
				<?php echo CHtml::activeLabelEx($model,'password'); ?>
				<?php echo CHtml::activePasswordField($model,'password') ?>
			</div>



			<div class="row">
			<table>
				<tr>
					<td>	
						<?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
					</td>
					<td>	
						<?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>
					</td>
				</tr>
			</table>
			</div>
			
			<div class="row submit">
				<?php echo CHtml::submitButton(UserModule::t("Login")); ?>
			</div>
			
			<div class="row">
				<p class="hint">
					<?php //echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?> 
					<?php //echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
				</p>
			</div>
			

			<?php echo CHtml::endForm(); ?>
			</div><!-- form -->

		</td>
		<td>
 
		</td>
	</tr>
</table>


<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>