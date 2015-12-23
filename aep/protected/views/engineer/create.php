<?php
/* @var $this EngineerController */
/* @var $model Engineer */

$this->breadcrumbs=array(
	'Engineers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Engineer', 'url'=>array('index')),
	array('label'=>'Manage Engineer', 'url'=>array('admin')),
);
?>

<h1>Create Engineer</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>