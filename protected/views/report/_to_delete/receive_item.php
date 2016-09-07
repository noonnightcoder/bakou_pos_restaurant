<?php /* $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => 'Invoice #<span class="text-info"> ' . $sale_id . '</span>',
              'headerIcon' => 'icon-list-alt',
)); */?>

<p class="text-info">Invoice No. <?php echo $receive_id; ?> </p>
<p class="text-info">Remarks: <?php echo TbHtml::b(ucwords($remark)); ?> </p>

<?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'id'=>'receive-item-grid',
	'dataProvider'=>$model->search($receive_id),
	//'summaryText' => '', // 1st way to hide result of summary text
        //'template' => '{items}{pager}', //2nd way to hide result of 
        //'enableSorting' => false,
	'columns'=>array(
		//'sale_id',
                array('name'=>'item_id',
                      'header'=>'Name',
                      'value'=>'$data->item_id==null? "N/A" : $data->item->name'
                ),
                'cost_price',
                'quantity',
                array('name'=>'sub_total',
                      'value'=>'$data->cost_price*$data->quantity',
                ),
                /*
                array('name'=>'discount_amount',
                      'header'=> 'Discount'
                ),
                 * 
                */
	),
)); ?>


<label class="text-info"> Cashier :  <?php echo TbHtml::b(ucwords($employee_id)); ?> </label>