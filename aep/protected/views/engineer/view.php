<?php
/* @var $this EngineerController */
/* @var $model Engineer */

$this->breadcrumbs=array(
	'Engineers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Engineer', 'url'=>array('index')),
	array('label'=>'Create Engineer', 'url'=>array('create')),
	array('label'=>'Update Engineer', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Engineer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Engineer', 'url'=>array('admin')),
);
?>

<h1>View Engineer #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'email',
		'password',
		'active',
		'company',
		'address',
		'town',
		'postcode',
		'created',
		'modified',
	),
)); ?>
