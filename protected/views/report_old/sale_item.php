<?php /* $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => 'Invoice #<span class="text-info"> ' . $sale_id . '</span>',
              'headerIcon' => 'icon-list-alt',
)); */?>

<p class="text-info">Invoice No. <?php echo $sale_id; ?> </p>

<?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'id'=>'sale-item-grid',
	'dataProvider'=>$model->search($sale_id),
	//'summaryText' => '', // 1st way to hide result of summary text
        //'template' => '{items}{pager}', //2nd way to hide result of 
        //'enableSorting' => false,
	'columns'=>array(
		//'sale_id',
                array('name'=>'item_id',
                      'header'=>'Name',
                      'value'=>'$data->item_id==null? "N/A" : $data->item->name'
                ),
                'price',
                'quantity',
                array('name'=>'sub_total',
                      'value'=>'$data->price*$data->quantity',
                ),
                array('name'=>'discount_amount',
                      'header'=> 'Discount'
                ),
	),
)); ?>

<?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'id'=>'sale-payment-grid',
	'dataProvider'=>$payment->search($sale_id),
	//'summaryText' => '<p class="text-info" align="left"> Payment</p>', // 1st way to hide result of summary text
	'columns'=>array(
		'payment_type',
                'payment_amount',
	),
)); ?>


<label class="text-info"> Cashier :  <?php echo $employee_id; ?> </label>