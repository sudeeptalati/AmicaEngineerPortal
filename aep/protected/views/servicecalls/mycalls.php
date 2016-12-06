<?php $this->layout='column1'; ?>

<table>
	<tr>
		<td>
			<h1>Welcome <?php echo Yii::app()->user->name; ?></h1>
		</td>
		<td style="text-align:right;">
				<a target="_blank" href="" title='Help'>		
					<span  class="fa fa-question-circle fa-3x" ></span>
				</a>
		</td>
	</tr>
</table>
<!--
<p>
    You can also search your servicealls by entering a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
-->




<?php
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
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search',array(
        'model'=>$model,
    )); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'servicecalls-grid',
    'dataProvider'=>$model->myservicecallsearch(),
    'filter'=>$model,
    'columns'=>array(
        //'id',
        //'service_reference_number',

        /*
        array(
            'name' => 'id',
            'type'=>'raw',
            'value' => 'CHtml::link(CHtml::encode($data->id),array("updatemyservicecall","id"=>$data->id))',
        ),
        */

        array(
            'name' => 'service_reference_number',
            'type'=>'raw',
            'value' => 'CHtml::link(CHtml::encode($data->service_reference_number),array("viewmyservicecall","id"=>$data->id))',
        ),
        //'engineer_user_id',
       // 'engineer_email',
       // 'callcenter_account_id',
        'customer_fullname',
        'customer_address',
        //'customer_postcode',

		array(
            'name'=>'jobstatus_id',
            'value'=>'Jobstatus::published_item("Jobstatus",$data->jobstatus_id)',
             'filter'=>Jobstatus::published_items('Jobstatus'),
        ),
        
        
        /*
		'jobstatus_id',
		////DISABLE AS HTML Name was not visible 
		
		array(
            'name'=>'jobstatus_id',
            'type'=>'raw',
            //'value'=>'$data->jobstatus->name',
            'filter'=>Jobstatus::published_items('Jobstatus'),
        ),
		 */

        array( 'name'=>'created', 'value'=>'$data->created==null ? "":date("d-M-Y",$data->created)', 'filter'=>false),
        //array( 'name'=>'modified', 'value'=>'$data->modified==null ? "":date("d-M-Y",$data->modified)', 'filter'=>false),

		array(
			'header'=>'Payment Date',
			'type'=>'raw',
			'value'=>'Servicecalls::model()->findpaymentdate($data->communications)',
		),


        /*
        'communications',
        'data_recieved',
        'data_sent',
        
        array(
            'class'=>'CButtonColumn',
            'template'=>'{view}{update}',
        ),
        
        */
    ),
)); ?>
