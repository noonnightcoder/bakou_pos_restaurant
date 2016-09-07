<?php echo TbHtml::linkButton(Yii::t( 'app', 'Create Backup' ),array(
        'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
        'size'=>TbHtml::BUTTON_SIZE_SMALL,
        'icon'=>'ace-menu fa fa-cloud-upload white',
        'url'=>Yii::app()->createUrl('backup/default/create/'),
)); ?>

<?php echo TbHtml::linkButton(Yii::t( 'app', 'Restore Lastest Backup' ),array(
        'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
        'size'=>TbHtml::BUTTON_SIZE_SMALL,
        'icon'=>'ace-icon fa fa-cloud-download white',
        'url'=>Yii::app()->createUrl('backup/default/restore/'),
)); ?>

<?php echo TbHtml::linkButton(Yii::t( 'app', 'System Restore' ),array(
        'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
        'size'=>TbHtml::BUTTON_SIZE_SMALL,
        'icon'=>'ace-icon fa fa-download white',
        'url'=>Yii::app()->createUrl('backup/default/systemrestore/'),
)); ?>

<br /><br/>
<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
 )); ?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'install-grid',
	'dataProvider' => $dataProvider,
	'columns' => array(
		array('name'=>'name',
                      'header'=>Yii::t('app','File Name'),
                ),
		array('name'=>'size',
                      'header'=>Yii::t('app','File Size'),
                ),
		array('name'=>'create_time',
                      'header'=>Yii::t('app','Create Time'),
                ),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'template' => '{download} {restore}{delete}',
                        'buttons'=>array
                          (
                              'download' => array
                              (
                                  'imageUrl'=>Yii::app()->request->baseUrl.'/images/database_download.png',
                                  'url'=>'Yii::app()->createUrl("backup/default/download", array("file"=>$data["name"]))',
                              ),
                              'restore' => array
                              (
                                  'imageUrl'=>Yii::app()->request->baseUrl.'/images/database_restore.png',
                                  'url'=>'Yii::app()->createUrl("backup/default/restore", array("file"=>$data["name"]))',
                              ),
                              'delete' => array
                              (
                                  'imageUrl'=>Yii::app()->request->baseUrl.'/images/database_delete.png',
                                  'url'=>'Yii::app()->createUrl("backup/default/delete", array("file"=>$data["name"]))',
                              ),
                          ),		
		),
	),
)); ?>