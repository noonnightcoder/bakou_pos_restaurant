<?php /*$box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => 'Cost History of <span class="text-info">' . $item->name .'</span>',
              'headerIcon' => 'icon-info-sign',
)); */?>

<?php echo TbHtml::em(TbHtml::b($item->name) . ' Current Reference Cost: ' . $item->cost_price, array('color' => TbHtml::TEXT_COLOR_INFO)); ?>
<?php echo TbHtml::muted('Average Cost: ' . Yii::app()->numberFormatter->formatCurrency($avg_cost,''), array('color' => TbHtml::TEXT_COLOR_INFO)); ?>
<?php echo TbHtml::muted('Total On-Hand Quantity: ' . $item->quantity, array('color' => TbHtml::TEXT_COLOR_INFO)); ?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'costhistory-grid',
	'dataProvider'=>$model->costHistory($item_id),
        'enableSorting' => false,
	'columns'=>array(
		array('name'=>'receive_time',
                      'header'=>'Date',
                      'value'=>'$data["receive_time"]',
                ),
                array('name'=>'supplier_id',
                      'header'=>'Supplier',
                     'value'=>'$data["supplier_id"]',
                ),
                array('name'=>'quantity',
                      'header'=>'Qty Received',
                     'value'=>'$data["quantity"]',
                ),
                array('name'=>'cost_price',
                      'header'=>'Cost',
                     'value'=>'$data["cost_price"]',
                ),
	),
)); ?>

<?php //$this->endWidget(); ?>