
    <div class="col-sm-12">
        <div class="tabbable tabs-left">
            <ul class="nav nav-tabs" id="myTab3">
                <li class="active">
                    <a data-toggle="tab" href="#home3">
                        <i class="pink ace-icon fa fa-tachometer bigger-110"></i>
                        Summary
                    </a>
                </li>

                <li>
                    <a data-toggle="tab" href="#profile3">
                        <i class="blue ace-icon fa fa-shopping-cart bigger-110"></i>
                        Cart 1
                    </a>
                </li>

                <li>
                    <a data-toggle="tab" href="#dropdown13">
                        <i class="ace-icon fa fa-shopping-cart"></i>
                        Cart 2
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="home3" class="tab-pane in active">
                    <?php $this->renderPartial('partial/_cart_summary', array(
                        'form' => $form,
                        'items' => $items,
                        'model' => $model,
                    ))
                    ?>
                </div>

                <div id="profile3" class="tab-pane">
                    <?php $this->renderPartial('partial/' . Common::getTableID() . '/_cart_1', array(
                        'form' => $form,
                        'items' => $items,
                        'model' => $model,
                    ))
                    ?>
                </div>

                <div id="dropdown13" class="tab-pane">
                    <?php $this->renderPartial('partial/'. Common::getTableID() . '/_cart_2', array(
                        'form' => $form,
                        'items' => $items,
                        'model' => $model,
                    ))
                    ?>
                </div>
            </div>
        </div>

    </div><!-- /.col -->

