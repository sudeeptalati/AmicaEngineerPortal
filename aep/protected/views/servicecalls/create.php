<?php
/* @var $this ServicecallsController */
/* @var $model Servicecalls */

$this->breadcrumbs=array(
	'Servicecalls'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Servicecalls', 'url'=>array('index')),
	array('label'=>'Manage Servicecalls', 'url'=>array('admin')),
);
?>

<h1>Create Servicecalls</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>