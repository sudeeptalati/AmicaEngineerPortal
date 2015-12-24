<?php
/* @var $this ServicecallsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Servicecalls',
);

$this->menu=array(
	array('label'=>'Create Servicecalls', 'url'=>array('create')),
	array('label'=>'Manage Servicecalls', 'url'=>array('admin')),
);
?>

<h1>Servicecalls</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
