<div class="widget-box transparent" id="widget-box-12">

    <div class="widget-header">
    <h4 class="widget-title lighter">Sub Cart</h4>

    <div class="widget-toolbar no-border">
        <ul class="nav nav-tabs" id="myTab2">
            <li class="active">
                <a data-toggle="tab" href="#home2">Cart 1</a>
            </li>

            <li>
                <a data-toggle="tab" href="#profile2">Cart 2</a>
            </li>

            <li>
                <a data-toggle="tab" href="#info2">Cart 3</a>
            </li>
        </ul>
    </div>
</div>


    <div class="widget-body">
    <div class="widget-main padding-12 no-padding-left no-padding-right">
        <div class="tab-content padding-4">
            <div id="home2" class="tab-pane in active">
                <!-- #section:custom/scrollbar.horizontal -->
                <div class="scrollable-horizontal" data-size="800">
                    <table class="table table-hover table-condensed">
                        <thead>
                        <tr>
                            <th><?php echo Yii::t('app', 'Item Code'); ?></th>
                            <th><?php echo Yii::t('app', 'Item Name'); ?></th>
                            <th><?php echo Yii::t('app', 'Price'); ?></th>
                            <th><?php echo Yii::t('app', 'Quantity'); ?></th>
                            <!-- <th class="<?php //echo Yii::app()->settings->get('sale','discount'); ?>"><?php //echo Yii::t('model','model.saleitem.discount_amount'); ?></th> -->
                            <th><?php echo Yii::t('app', 'Total'); ?></th>
                            <th><?php echo Yii::t('app', 'Action'); ?></th>
                        </tr>
                        </thead>
                        <tbody id="cart_contents">
                        <?php foreach ($items as $id => $item): ?>
                            <?php
                            $total_item = number_format($item['total'], Yii::app()->orderingCart->getDecimalPlace());
                            $item_id = $item['item_id'];
                            $item_parent_id = $item['item_parent_id'];
                            $unit_name = '';
                            ?>
                            <tr>
                                <td>
                                    <?php echo TbHtml::linkButton('', array(
                                        'color' => TbHtml::BUTTON_COLOR_SUCCESS,
                                        'size' => TbHtml::BUTTON_SIZE_MINI,
                                        'icon' => 'glyphicon-hand-up white',
                                        'url' => $this->createUrl('Item/SelectItem/',
                                            array('item_parent_id' => $item_id, 'category_id' => $item['category_id'])),
                                        'class' => 'update-dialog-open-link',
                                        'data-update-dialog-title' => Yii::t('app', 'Select Topping'),
                                    )); ?>
                                    <?php echo $item['item_number']; ?>
                                </td>
                                <?php if ($item['topping'] == 0) { ?>
                                    <td>
                       <span class="text-info">
                        <?php echo $item['name']; ?>
                       </span>
                                    </td>
                                <?php } else { ?>
                                    <td align="right"><span class="text-info orange"><?php echo $item['name']; ?></span></td>
                                <?php } ?>
                                <td>
                                    <?php echo $form->textField($model, "[$item_id]price", array(
                                        'value' => number_format($item['price'], Yii::app()->shoppingCart->getDecimalPlace()),
                                        'disabled' => true,
                                        'class' => 'input-small alignRight readonly',
                                        'id' => "price_$item_id",
                                        'placeholder' => 'Price',
                                        'data-id' => "$item_id",
                                        'maxlength' => 50,
                                        'onkeypress' => 'return isNumberKey(event)'
                                    )); ?>
                                </td>
                                <td>
                                    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                                        'method' => 'post',
                                        'action' => Yii::app()->createUrl('saleItem/editItem/',
                                            array('item_id' => $item['item_id'], 'item_parent_id' => $item_parent_id)),
                                        'htmlOptions' => array('class' => 'line_item_form'),
                                    ));
                                    ?>

                                    <?php echo $form->textField($model, "quantity", array(
                                        'value' => $item['quantity'],
                                        'class' => 'input-small input-grid alignRight',
                                        'id' => "quantity_$item_id",
                                        'placeholder' => 'Quantity',
                                        'data-id' => "$item_id",
                                        'data-parentid' => "$item_parent_id",
                                        'maxlength' => 10
                                    )); ?>

                                    <?php $this->endWidget(); ?>
                                </td>
                                <td>
                                    <?php echo $form->textField($model, "[$item_id]total", array(
                                        'value' => $total_item,
                                        'disabled' => true,
                                        'class' => 'input-small alignRight readonly'
                                    )); ?>
                                </td>
                                <td>
                                    <?php echo TbHtml::linkButton('', array(
                                        'color' => TbHtml::BUTTON_COLOR_DANGER,
                                        'size' => TbHtml::BUTTON_SIZE_MINI,
                                        'icon' => 'glyphicon-trash',
                                        'url' => array(
                                            'DeleteItem',
                                            'item_id' => $item_id,
                                            'item_parent_id' => $item['item_parent_id']
                                        ),
                                        'class' => 'delete-item',
                                        //3'title' => Yii::t( 'app', 'Remove' ),
                                    )); ?>
                                </td>
                            </tr>
                            <?php //$this->endWidget(); ?>  <!--/endformWidget-->
                        <?php endforeach; ?> <!--/endforeach-->
                        </tbody>
                    </table>
                </div>

                <!-- /section:custom/scrollbar.horizontal -->
            </div>

            <div id="profile2" class="tab-pane">
                <div class="scrollable" data-size="100" data-position="left">
                    <b>Scroll on Left</b>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis. Nullam interdum massa vel nisl fringilla sed viverra erat tincidunt. Phasellus in ipsum velit. Maecenas id erat vel sem convallis blandit. Nunc aliquam enim ut arcu aliquet adipiscing. Fusce dignissim volutpat justo non consectetur.
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis. Nullam interdum massa vel nisl fringilla sed viverra erat tincidunt. Phasellus in ipsum velit. Maecenas id erat vel sem convallis blandit. Nunc aliquam enim ut arcu aliquet adipiscing. Fusce dignissim volutpat justo non consectetur.
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis. Nullam interdum massa vel nisl fringilla sed viverra erat tincidunt. Phasellus in ipsum velit. Maecenas id erat vel sem convallis blandit. Nunc aliquam enim ut arcu aliquet adipiscing. Fusce dignissim volutpat justo non consectetur.
                </div>
            </div>

            <div id="info2" class="tab-pane">
                <div class="scrollable" data-size="100">
                    <b>Scroll # 3</b>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis. Nullam interdum massa vel nisl fringilla sed viverra erat tincidunt. Phasellus in ipsum velit. Maecenas id erat vel sem convallis blandit. Nunc aliquam enim ut arcu aliquet adipiscing. Fusce dignissim volutpat justo non consectetur.
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis. Nullam interdum massa vel nisl fringilla sed viverra erat tincidunt. Phasellus in ipsum velit. Maecenas id erat vel sem convallis blandit. Nunc aliquam enim ut arcu aliquet adipiscing. Fusce dignissim volutpat justo non consectetur.
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis. Nullam interdum massa vel nisl fringilla sed viverra erat tincidunt. Phasellus in ipsum velit. Maecenas id erat vel sem convallis blandit. Nunc aliquam enim ut arcu aliquet adipiscing. Fusce dignissim volutpat justo non consectetur.
                </div>
            </div>
        </div>
    </div>
</div>

</div>