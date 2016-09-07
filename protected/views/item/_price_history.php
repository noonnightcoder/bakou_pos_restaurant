<?php /*$box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => 'Price History of <span class="text-info">' . $item->name .'</span>',
              'headerIcon' => 'icon-info-sign',
)); */?>

<?php echo TbHtml::em(TbHtml::b($item->name) .' Current Reference Price: ' . $item->unit_price, array('color' => TbHtml::TEXT_COLOR_INFO)); ?>
<?php //echo TbHtml::muted('Average Cost: ' . Yii::app()->numberFormatter->formatCurrency($avg_cost,''), array('color' => TbHtml::TEXT_COLOR_INFO)); ?>
<?php //echo TbHtml::muted('Total On-Hand Quantity: ' . $item->quantity, array('color' => TbHtml::TEXT_COLOR_INFO)); ?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'pricehistory-grid',
	'dataProvider'=>$model->search($item_id),
        'enableSorting' => false,
	'columns'=>array(
		array('name'=>'modified_date',
                      'header'=>'Date',
                ),
                array('name'=>'old_price',
                      'header'=>'Old Price',
                ),
                array('name'=>'new_price',
                      'header'=>'New Price',
                ),
                array('name'=>'employee_id',
                      'header'=>'Change By',
                      'value'=>'ucwords($data->employee->first_name . " " . $data->employee->last_name)',
                ),
	),
)); ?>

<?php //$this->endWidget(); ?>