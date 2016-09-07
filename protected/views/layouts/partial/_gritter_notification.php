<script>
    $(function(){
        $.gritter.add({
            title: '<?= $title; ?>',
            text: '<?= $message; ?>',
            image: '<?= Yii::app()->theme->baseUrl ?>/avatars/avatar3.png',
            sticky: true,
            time: 10,
            class_name: '<?= $gritter_key ?>'
        });

        return false;
    });
</script>