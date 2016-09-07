<div class="row" id="merge_table">
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'id'=>'list_table_frm'
    )); ?>


    <?php echo $form->inlineCheckBoxListControlGroup($model, 'list_table', Desk::model()->getTable()); ?>

    <div class="form-actions">
        <?php echo TbHtml::submitButton(Yii::t('app','form.button.save'),array(
           'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
           //'size'=>TbHtml::BUTTON_SIZE_SMALL,
          'class'=>'list-table'
       )); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>

<?php 
    Yii::app()->clientScript->registerScript( 'selectItem', "
        jQuery( function($){
            $('div#merge_table').on('click','.list-table',function(e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to merge these tables?'))
                {
                  return false;
                }
                var tables = [];    
                if ($('#list_table_frm input:checkbox:checked').length > 1)
                {
                    $('#list_table_frm input:checked').each(function() {
                        tables.push(this.value);
                    });
                } else {
                    alert('Please select at least two tables to merge');
                    return false;   
                }
                $('#myModal').modal('hide');
                var gridCart=$('#grid_cart');
                var gridZone=$('#grid_zone');
                $.ajax({url:'MergeTable',
                        dataType : 'json',
                        type : 'post',
                        data : {tables : tables},
                        //beforeSend: function() { $('.waiting').show(); },
                        //complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    //gridCart.html(data.div_gridcart);
                                    //gridZone.html(data.div_zonecart);
                                    location.reload(true);
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
