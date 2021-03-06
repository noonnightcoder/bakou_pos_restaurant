<div class="grid-view" id="grid_cart">  
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'receiving-item-form',
            'enableAjaxValidation'=>false,
            'layout'=>TbHtml::FORM_LAYOUT_INLINE,
    )); ?>
    <?php
    if (isset($warning))
    {
        echo "<div class='alert alert-warning'><strong>".$warning."</strong><a class='close' data-dismiss='alert'>×</a></div>";
    }
    ?>
    <table class="table table-hover table-condensed">
        <thead>
            <tr><th><?php echo Yii::t('model','model.receivingitem.name'); ?></th>
                <th><?php echo Yii::t('model','model.receivingitem.cost_price'); ?></th>
                <th><?php echo Yii::t('model','model.receivingitem.quantity'); ?></th>
                <th><?php echo Yii::t('model','model.receivingitem.discount_amount'); ?></th>
                <th><?php echo Yii::t('model','model.receivingitem.expire_date'); ?></th>
                <th><?php echo Yii::t('model','model.receivingitem.total'); ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody id="cart_contents">
            <?php foreach(array_reverse($items,true) as $id=>$item): ?>
                <?php
                    if (substr($item['discount'],0,1)=='$')
                    {
                        $total_item=($item['price']*$item['quantity']-substr($item['discount'],1));
                    }    
                    else  
                    {  
                        $total_item=($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100);
                    } 
                    $item_id=$item['item_id'];
                    $cur_item_info= Item::model()->findbyPk($item_id);
                    $qty_in_stock=$cur_item_info->quantity;
                    $n_expire=0;
                    if (Yii::app()->receivingCart->getMode()<>'receive') {
                        $n_expire=ItemExpire::model()->count('item_id=:item_id and quantity>0',array('item_id'=>(int)$item['item_id']));
                    }
                ?>
                    <tr>
                        <td> 
                            <?php echo $item['name']; ?><br/>
                            <span class="text-info"><?php echo $qty_in_stock . ' ' . Yii::t('app','in stock') ?> </span>
                        </td>
                        <td><?php echo $form->textField($model,"[$item_id]price",array('value'=>$item['price'],'class'=>'input-small numeric','id'=>"price_$item_id",'placeholder'=>'Price','data-id'=>"$item_id",'maxlength'=>50,'onkeypress'=>'return isNumberKey(event)')); ?></td> 
                        <td><?php echo $form->textField($model,"[$item_id]quantity",array('value'=>$item['quantity'],'class'=>'input-small numeric','id'=>"quantity_$item_id",'placeholder'=>'Quantity','data-id'=>"$item_id",'maxlength'=>50,'onkeypress'=>'return isNumberKey(event)')); ?>
                        </td>
                        <td><?php echo $form->textField($model,"[$item_id]discount",array('value'=>$item['discount'],'class'=>'input-small','id'=>"discount_$item_id",'placeholder'=>'Discount','data-id'=>"$item_id",'maxlength'=>50)); ?></td>
                        <!--<td><?php //$this->widget('yiiwheels.widgets.maskinput.WhMaskInput',array('name'=>'expire_date','mask'=> '10/2013','htmlOptions' => array('placeholder' => '10/2013')));?> </td> -->
                        <td><?php //$this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array('name' => 'datepickertest','value'=>$item['expire_date'],'pluginOptions' => array('format' => 'yyyy-mm-dd'),'htmlOptions'=>array('value'=>$item['expire_date'],'id'=>"expiredate_$item_id",'data-id'=>"$item_id",'class'=>'input-small'))); ?>
                            <?php 
                            if ( $n_expire>0 ) { 
                               echo TbHtml::dropDownList('expire_date','',ItemExpire::model()->getItemExpDate($item['item_id']),array('id'=>"expiredate_$item_id",
                                                'options'=>array($item['expire_date']=>array('selected'=>true)),
                                                'class'=>"expiredate input-sm",'data-id'=>"$item_id"));  
                            } else { 
                                $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array('name' => 'datepickertest','value'=>$item['expire_date'],'pluginOptions' => array('format' => 'yyyy-mm-dd'),'htmlOptions'=>array('value'=>$item['expire_date'],'id'=>"expiredate_$item_id",'data-id'=>"$item_id",'class'=>'input-small'))); 
                            }
                            ?>
                        </td>
                        <td><?php echo $total_item; ?>
                        <td><?php echo TbHtml::linkButton('',array(
                                'color'=>TbHtml::BUTTON_COLOR_DANGER,
                                'size'=>TbHtml::BUTTON_SIZE_MINI,
                                'icon'=>'glyphicon-trash',
                                'url'=>array('DeleteItem','item_id'=>$item_id),
                                'class'=>'delete-item',
                                'title' => Yii::t( 'app', 'Remove' ),
                            )); ?>
                        </td>
                    </tr> 
            <?php endforeach; ?> <!--/endforeach-->

        </tbody>
    </table>
    <?php $this->endWidget(); ?>  <!--/endformWidget-->     

    <?php
    if (empty($items))
        echo Yii::t('app','There are no items in the cart');

    ?> 

</div> <!--/endgridcartdiv-->                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              