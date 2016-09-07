<div id="listofitem">
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'select-item-recv-grid',
	'dataProvider'=>$model->search(),
	'summaryText'=>'',
	'columns'=>array(
		//'id',
		'item_number',  
                array('name'=>'name',
                      'value'=>'CHtml::link($data->name, Yii::app()->createUrl("receivingItem/indexpara",array("item_id"=>$data->id)),array("class"=>"list-item"))',
                      'type'=>'raw',
                ),
		array('name' => 'category_id',
                      'value' => '$data->category_id==null? " " : $data->category->name',
                ),
                array('name'=>'unit_price',
                      //'header'=>'Price',
                ),
                //'quantity'
	),
)); ?>
</div>

<?php 
    Yii::app()->clientScript->registerScript( 'selectItem', "
        jQuery( function($){
            $('div#listofitem').on('click','a.list-item',function(e) {
                e.preventDefault();
                $('#myModal').modal('hide');
                var remote = $('#ReceiveItem_item_id');
                var url=$(this).attr('href');
                var gridCart=$('#grid_cart');
                //var paymentCart=$('#payment_cart');
                //var cancelCart=$('#cancel_cart');
                $.ajax({url:url,
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    gridCart.html(data.div_gridcart);
                                    $('#task_cart').html(data.div_taskcart);
                                    //paymentCart.html(data.div_paymentcart);
                                    //cancelCart.html(data.div_cancelcart);
                                    if (data.items==0)
                                    {
                                         $('div#payment_cart').hide();
                                    }
                                    remote.select2('open');
                                }
                                else 
                                {
                                  alert('something worng');
                                  return false;
                                }
                          }
                }); /* End Ajax */
             });
         });
      ");
 ?> 



