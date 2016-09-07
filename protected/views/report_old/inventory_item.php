<?php $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
              'title' => 'Transaction History of <span class="text-info">' . $item->name .'</span>',
              'headerIcon' => 'icon-list-alt',
));?>

        
<?php $this->widget('bootstrap.widgets.TbLabel', array(
    'type'=>'important', // 'success', 'warning', 'important', 'info' or 'inverse'
    'label'=>'On-hand: ' . $item->quantity,
)); ?>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'inventory-grid',
	'dataProvider'=>$model->search($item_id),
	//'filter'=>$model,
        'enableSorting' => false,
	'columns'=>array(
		array('name'=>'trans_date',
                       'header'=>'Date',
                ),
                array('name'=>'trans_comment',
                      'header'=>'Remarks',
                ),
                array('name'=>'trans_inventory',
                      'header'=>'Effect on Qty',
                ),
                array('name'=>'trans_user',
                      'header'=>'Action By',
                      'value'=>'$data->trans_user==0? "Admin" : $data->trans_user',
                ),
                //'trans_id',
                /*
		array('name'=>'trans_items',
                      'value'=>'$data->transItems->name',
                ),
		'trans_user',
		'trans_comment',
		'trans_inventory',
                 * 
                */
                /*
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
                 * 
                */
	),
)); ?>

<?php $this->endWidget(); ?>