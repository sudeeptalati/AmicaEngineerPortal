<?php
/* @var $this EngineerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Engineers',
);

$this->menu=array(
	array('label'=>'Create Engineer', 'url'=>array('create')),
	array('label'=>'Manage Engineer', 'url'=>array('admin')),
);
?>

<h1>Engineers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
