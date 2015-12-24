<?php
/* @var $this ServicecallsController */
/* @var $model Servicecalls */

$this->breadcrumbs=array(
	'Servicecalls'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Servicecalls', 'url'=>array('index')),
	array('label'=>'Create Servicecalls', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#servicecalls-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Servicecalls</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'servicecalls-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'service_reference_number',
		'engineer_email',
		'callcenter_account_id',
		'customer_fullname',
		'customer_address',
		/*
		'customer_postcode',
		'communications',
		'data_recieved',
		'data_sent',
		'jobstatus_id',
		'created',
		'modified',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
