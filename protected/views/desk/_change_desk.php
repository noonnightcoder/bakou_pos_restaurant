<h4>
    From Table <?php if (isset($table_info)) { echo TbHtml::b($table_info->name); } ?> To :
</h4>

<div class="" id="change_table">
    <?php  foreach ($tables as $table) { ?> 
        <?php echo TbHtml::linkButton($table['name'],array(
          'color'=>TbHtml::BUTTON_COLOR_INFO,
          'size'=>TbHtml::BUTTON_SIZE_LARGE,
          'icon'=>'ace-icon fa fa-square-o bigger-110 green',
          'url'=>Yii::app()->createUrl('saleItem/changeTable/',array('new_table_id'=>$table['id'])),
          'class'=>'btn btn-white btn-info btn-round table-btn',
        )); ?>
    <?php } ?>
</div>

<?php 
    Yii::app()->clientScript->registerScript( 'selectItem', "
        jQuery( function($){
            $('div#change_table').on('click','a.table-btn',function(e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to change this table?'))
                {
                  return false;
                }
                $('#myModal').modal('hide');
                var url=$(this).attr('href');
                $.ajax({url:url,
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                            $('#register_container').html(data);
                        }
                }); /* End Ajax */
             });
         });
      ");
 ?> 
