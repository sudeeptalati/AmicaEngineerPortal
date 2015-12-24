<?php
/* @var $this ServicecallsController */
/* @var $model Servicecalls */

$this->breadcrumbs=array(
	'Servicecalls'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Servicecalls', 'url'=>array('index')),
	array('label'=>'Create Servicecalls', 'url'=>array('create')),
	array('label'=>'Update Servicecalls', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Servicecalls', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Servicecalls', 'url'=>array('admin')),
);
?>

<h1>View Servicecalls #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'service_reference_number',
		'engineer_email',
		'callcenter_account_id',
		'customer_fullname',
		'customer_address',
		'customer_postcode',
		'communications',
		'data_recieved',
		'data_sent',
		'jobstatus_id',
		'created',
		'modified',
	),
)); ?>
