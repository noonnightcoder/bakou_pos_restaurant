<?php /*$box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => 'Transaction History of <span class="text-info">' . $item->name .'</span>',
              'headerIcon' => 'icon-list-alt',
)); */?>

<?php echo TbHtml::labelTb($item->name . ' On-hand: ' . $item->quantity, array('color' => TbHtml::LABEL_COLOR_INFO)); ?>


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
                      'value'=>'$data->trans_user==0? "Admin" : $data->employee->first_name ." " . $data->employee->last_name',
                ),
	),
)); ?>

<?php //$this->endWidget(); ?>