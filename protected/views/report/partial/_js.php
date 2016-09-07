<script>
    jQuery( function($){
        $('div#report_header').on('click','.btn-view',function(e) {
            e.preventDefault();
            var data=$("#report-form").serialize();
            $.ajax({url: '<?=  Yii::app()->createUrl($this->route); ?>',
                type : 'GET',
                //dataType : 'json',
                data:data,
                beforeSend: function() { $('.waiting').show(); },
                complete: function() { $('.waiting').hide(); },
                success : function(data) {
                    //$("#report_grid").html(data.div); // Using with Json Data Return
                    $("#report_grid").html(data);
                    return false;
                }
            });
        });
    });
</script>


<script type="text/javascript">
    jQuery( function($){
        $('.btn-opt li a').on('click', function(e) {
            e.preventDefault();
            var current_link=$(this);
            var url=current_link.attr('href');
            var data=$("#report-form").serialize();
            current_link.parent().parent().find('.active').removeClass('active');
            current_link.parent().addClass('active').css('font-weight', 'bold');
            $.ajax({url: url,
                type : 'GET',
                //dataType : 'json',
                data:data,
                beforeSend: function() { $('.waiting').show(); },
                complete: function() { $('.waiting').hide(); },
                success : function(data) {
                    //$("#report_grid").html(data.div);  // Using with Json Data Return
                    $("#report_grid").html(data);
                    return false;
                }
            });
        });
    });
</script>

<script>
    $('#report_grid').on('click','a.btnCancelInvoice', function(e) {
        e.preventDefault();
        var remark = prompt('Why do you want to cancel this invoice?');
        if (remark==='') {
            alert('Invoice is not canceled because you did not specify a reason.');
        }
        else if(remark) {
            var url=$(this).attr('href');
            $.ajax({url: url,
                dataType : 'json',
                type : 'post',
                data : {remark : remark},
                beforeSend: function() { $('.waiting').show(); },
                complete: function() { $('.waiting').hide(); },
                success : function(data) {
                    if (data.status==='success')
                    {
                        //$.fn.yiiGridView.update('sale-grid');
                        //$('#sale_invoice').html(data.div);
                        location.reload(true);
                    }
                    else
                    {
                        console.log(data.message);
                    }
                }
            });
        }
    });
</script>