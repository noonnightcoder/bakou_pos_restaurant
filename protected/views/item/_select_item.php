<div id="listofitem">
    
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'select-item-grid',
	'dataProvider'=>$model->topping($category_id),
	'summaryText'=>'',
	'columns'=>array(
		//'id',
		'item_number',  
                array('name'=>'name',
                      'value'=>'CHtml::link($data->name, Yii::app()->createUrl("saleItem/indexpara",array("item_id"=>$data->id, "item_parent_id" =>' . $item_parent_id . ')),array("class"=>"list-item"))',
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
                $.ajax({url:url,
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                            $('#register_container').html(data);
                        }
                }); 
             });
         });
      ");
 ?> 



