<?php
/* @var $this ServicecallsController */
/* @var $model Servicecalls */

$this->breadcrumbs=array(
	'Servicecalls'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Servicecalls', 'url'=>array('index')),
	array('label'=>'Create Servicecalls', 'url'=>array('create')),
	array('label'=>'View Servicecalls', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Servicecalls', 'url'=>array('admin')),
);
?>

<h1>Update Servicecalls <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>