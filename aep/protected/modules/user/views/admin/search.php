 <?php
/* @var $this UsersController */
/* @var $model Users */

 
?>

 
<h1><?php echo UserModule::t("List of Users"); ?></h1>
<?php if (UserModule::isAdmin()) {
    ?>
    <div id="submenu">
    <ul class="actions">
        <li><?php echo CHtml::link(UserModule::t('Search User'), array('/user/admin/search')); ?></li>
        <li><?php echo CHtml::link(UserModule::t('Manage User'), array('/user/admin')); ?></li>
    </ul></div><!-- actions --><?php
} ?>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'selectableRows'=>1,
	'selectionChanged'=>'function(id){ location.href = "'.$this->createUrl('admin/view').'&id="+$.fn.yiiGridView.getSelection(id);}',
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'username',
		'password',
		'email',
		'activkey',
		array('name'=>'createtime','value'=>'date("d-M-Y",$data->createtime)'),
		/*
		'lastvisit',
		'superuser',
		'status',
		*/
 
	),
)); ?>
