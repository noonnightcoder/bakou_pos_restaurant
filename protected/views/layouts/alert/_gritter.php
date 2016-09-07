<?php foreach (Yii::app()->user->getFlashes() as $key => $message) {
    if (isset($key)) { ?>
        <script>
            $(function(){
                $.gritter.add({
                    title: '<?= ucfirst($key); ?>',
                    text: '<?= $message; ?>',
                    image: '<?= Yii::app()->theme->baseUrl ?>/avatars/avatar3.png',
                    sticky: true,
                    time: '10',
                    class_name: '<?= 'gritter-' . $key ?>'
                });
                return false;
            });
        </script>
<?php   }
}