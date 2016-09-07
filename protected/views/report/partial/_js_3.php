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