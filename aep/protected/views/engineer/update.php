<?php
/* @var $this EngineerController */
/* @var $model Engineer */

$this->breadcrumbs=array(
	'Engineers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Engineer', 'url'=>array('index')),
	array('label'=>'Create Engineer', 'url'=>array('create')),
	array('label'=>'View Engineer', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Engineer', 'url'=>array('admin')),
);
?>

<h1>Update Engineer <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>