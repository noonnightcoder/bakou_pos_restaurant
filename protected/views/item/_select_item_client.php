<div id="listofitem">
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'select-item-grid',
	'dataProvider'=>$model->search(),
	'summaryText'=>'',
	'columns'=>array(
		//'id',
		'item_number',  
                array('name'=>'name',
                      'value'=>'CHtml::link($data->name, Yii::app()->createUrl("clientItem/indexpara",array("item_id"=>$data->id)),array("class"=>"list-item"))',
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
                var remote = $('#SaleItem_item_id');
                var url=$(this).attr('href');
                var gridCart=$('#grid_cart');
                var taskCart=$('#task_cart');
                $.ajax({url:url,
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    gridCart.html(data.div_gridcart);
                                    taskCart.html(data.div_taskcart);
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



